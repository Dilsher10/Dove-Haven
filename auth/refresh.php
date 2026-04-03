<?php
header('Content-Type: application/json');
require_once '../config/config.php';
require_once '../auth/jwt_helper.php';

$data = json_decode(file_get_contents("php://input"), true);
$refresh_token = $data['refresh_token'] ?? '';

if (empty($refresh_token)) {
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'message' => 'Refresh token required']);
    exit;
}

// 1. Check refresh token in database
$stmt = $conn->prepare("SELECT user_id, expires_at FROM refresh_tokens WHERE token = ?");
$stmt->bind_param("s", $refresh_token);
$stmt->execute();
$result = $stmt->get_result();
$tokenData = $result->fetch_assoc();

if (!$tokenData || strtotime($tokenData['expires_at']) < time()) {
    http_response_code(401); // Unauthorized
    echo json_encode(['success' => false, 'message' => 'Invalid or expired refresh token']);
    exit;
}

$user_id = $tokenData['user_id'];

// 2. Fetch user to include in new JWT payload
$user_stmt = $conn->prepare("SELECT id, email, role FROM employees WHERE id = ?");
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user = $user_stmt->get_result()->fetch_assoc();

if (!$user) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'User not found']);
    exit;
}

// 3. Issue new access token
$payload = [
    'user_id' => $user['id'],
    'email' => $user['email'],
    'role' => $user['role']
];
$new_access_token = JWTHelper::generate($payload, 15);

echo json_encode([
    'success' => true,
    'access_token' => $new_access_token
]);
