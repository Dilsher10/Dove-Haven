<?php
header('Content-Type: application/json');
require_once '../config/config.php';
require_once '../auth/auth_middleware.php';

// Verify JWT
$user_id = requireAuth(); 

// Return employee data
$stmt = $conn->prepare("SELECT id, name, username, role, email, status, last_login FROM employees WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
    echo json_encode(['success' => true, 'user' => $user]);
} else {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'User not found']);
}
