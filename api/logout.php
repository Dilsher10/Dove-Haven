<?php
header('Content-Type: application/json');
require_once '../config/config.php';

$data = json_decode(file_get_contents("php://input"), true);
$refresh_token = $data['refresh_token'] ?? '';

if (empty($refresh_token)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Refresh token required for logout']);
    exit;
}

// 1. Delete refresh token from DB
$stmt = $conn->prepare("DELETE FROM refresh_tokens WHERE token = ?");
$stmt->bind_param("s", $refresh_token);
$stmt->execute();

// 2. Clear access_token cookie
setcookie('access_token', '', [
    'expires' => time() - 3600,
    'path' => '/',
    'httponly' => false,
    'samesite' => 'Lax'
]);

echo json_encode(['success' => true, 'message' => 'Logged out successfully']);
