<?php
header('Content-Type: application/json');
require_once '../config/config.php';
require_once '../auth/auth_middleware.php';

$user_id = requireAuth(); // Verify JWT

$data = json_decode(file_get_contents("php://input"), true);
$current_password = $data['current_password'] ?? '';
$new_password = $data['new_password'] ?? '';

if (empty($current_password) || empty($new_password)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Current and new password required']);
    exit;
}

// 1. Fetch current password hash
$stmt = $conn->prepare("SELECT password FROM employees WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user || !password_verify($current_password, $user['password'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Incorrect current password']);
    exit;
}

// 2. Hash new password (bcrypt, cost 12)
$hashed_password = password_hash($new_password, PASSWORD_BCRYPT, ['cost' => 12]);

// 3. Update database
$update_stmt = $conn->prepare("UPDATE employees SET password = ? WHERE id = ?");
$update_stmt->bind_param("si", $hashed_password, $user_id);
$update_stmt->execute();

echo json_encode(['success' => true, 'message' => 'Password updated successfully']);
