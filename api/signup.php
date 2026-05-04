<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../auth/role_middleware.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['password']) || strlen($data['password']) < 8) {
        echo json_encode([
            'success' => false,
            'error' => 'Password must be at least 8 characters long'
        ]);
        exit;
    }

    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            'success' => false,
            'error' => 'Invalid email format'
        ]);
        exit;
    }

    try {
        // Check if email already exists
        $checkStmt = $conn->prepare("SELECT id FROM employees WHERE email = ?");
        $checkStmt->bind_param("s", $data['email']);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows > 0) {
            echo json_encode([
                'success' => false,
                'error' => 'Email already exists'
            ]);
            exit;
        }

        // Insert employee
        $stmt = $conn->prepare("
            INSERT INTO employees 
            (name, username, password, role, email, status, last_login, failed_attempts, lock_until) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        $stmt->bind_param(
            "sssssssis",
            $data['name'],
            $data['username'],
            $hashedPassword,
            $data['role'],
            $data['email'],
            $data['status'],
            $data['last_login'],
            $data['failed_attempts'],
            $data['lock_until']
        );

        $stmt->execute();

        echo json_encode(['success' => true]);

    } catch (\mysqli_sql_exception $e) {
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
}
?>