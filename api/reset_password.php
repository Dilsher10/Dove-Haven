<?php
header('Content-Type: application/json');
require_once '../config/config.php';

$data = json_decode(file_get_contents('php://input'), true);

$password = $data['password'] ?? '';
$confirmPassword = $data['confirmPassword'] ?? '';
$token = $_GET['token'] ?? '';

if (!$token) {
    echo json_encode(['success' => false, 'message' => 'Missing token.']);
    exit;
}

// Validate token
$stmt = $conn->prepare("SELECT employee_id, expires_at FROM password_resets WHERE token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row || strtotime($row['expires_at']) < time()) {
    echo json_encode(['success' => false, 'message' => 'Invalid or expired token.']);
    exit;
}

// Validate passwords
if ($password !== $confirmPassword) {
    echo json_encode(['success' => false, 'message' => 'Passwords do not match.']);
    exit;
}

if (strlen($password) < 8) {
    echo json_encode(['success' => false, 'message' => 'Password must be at least 8 characters.']);
    exit;
}

// Hash password
$hashed = password_hash($password, PASSWORD_DEFAULT);

// Update password
$stmt = $conn->prepare("UPDATE employees SET password = ? WHERE id = ?");
$stmt->bind_param("si", $hashed, $row['employee_id']);
$stmt->execute();

// Delete token
$stmt = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();

echo json_encode([
    'success' => true,
    'message' => 'Password has been reset successfully.'
]);