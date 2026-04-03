<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

require_once '../config/config.php';
require_once '../auth/jwt_helper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Email and password are required']);
        exit;
    }

    // 1. Fetch user by email
    $stmt = $conn->prepare("SELECT id, name, username, role, email, password, status, failed_attempts, lock_until FROM employees WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
        exit;
    }

    // 2. Check account lock
    if ($user['lock_until'] && strtotime($user['lock_until']) > time()) {
        echo json_encode(['success' => false, 'message' => 'Account is locked. Try again later.']);
        exit;
    }

    // 3. Verify password
    if (password_verify($password, $user['password'])) {
        // Successful login
        // Reset failed attempts
        $reset_stmt = $conn->prepare("UPDATE employees SET failed_attempts = 0, lock_until = NULL, last_login = NOW() WHERE id = ?");
        $reset_stmt->bind_param("i", $user['id']);
        $reset_stmt->execute();

        // 4. Generate JWT access token (15 min)
        $payload = [
            'user_id' => $user['id'],
            'email' => $user['email'],
            'role' => $user['role']
        ];
        $access_token = JWTHelper::generate($payload, 15);

        // 5. Generate Refresh token (7 days)
        $refresh_token = bin2hex(random_bytes(32));
        $expires_at = date('Y-m-d H:i:s', time() + (7 * 24 * 60 * 60));

        // 6. Insert refresh token into DB
        $refresh_stmt = $conn->prepare("INSERT INTO refresh_tokens (user_id, token, expires_at) VALUES (?, ?, ?)");
        $refresh_stmt->bind_param("iss", $user['id'], $refresh_token, $expires_at);
        $refresh_stmt->execute();

        // Set cookie for PHP page protection (15 mins)
        setcookie('access_token', $access_token, [
            'expires' => time() + (15 * 60),
            'path' => '/',
            'httponly' => false, // Set to false so JS can still access it if needed
            'samesite' => 'Lax'
        ]);

        unset($user['password']); // Don't return password
        echo json_encode([
            'success' => true,
            'access_token' => $access_token,
            'refresh_token' => $refresh_token,
            'user' => $user
        ]);
    } else {
        // Failed login
        $failed_attempts = $user['failed_attempts'] + 1;
        $lock_until = NULL;

        if ($failed_attempts >= 5) {
            $lock_until = date('Y-m-d H:i:s', time() + (15 * 60)); // Lock for 15 mins
            echo json_encode(['success' => false, 'message' => 'Too many failed attempts. Account locked for 15 minutes.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
        }

        $update_stmt = $conn->prepare("UPDATE employees SET failed_attempts = ?, lock_until = ? WHERE id = ?");
        $update_stmt->bind_param("isi", $failed_attempts, $lock_until, $user['id']);
        $update_stmt->execute();
    }
}
