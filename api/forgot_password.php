<?php
header('Content-Type: application/json');
require_once '../config/config.php';

$data = json_decode(file_get_contents("php://input"), true);
$email = trim($data['email'] ?? '');

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email']);
    exit;
}

try {
    $stmt = $conn->prepare('SELECT id FROM employees WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $employee = $result->fetch_assoc();
    $stmt->close();

    if (!$employee) {
        echo json_encode(['success' => false, 'message' => 'No account found']);
        exit;
    }

    // Generate token and expiry
    $token = bin2hex(random_bytes(16));
    $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

    $stmt = $conn->prepare('INSERT INTO password_resets (employee_id, token, expires_at) VALUES (?, ?, ?)');
    $stmt->bind_param('iss', $employee['id'], $token, $expires);
    $stmt->execute();
    $stmt->close();

    // Build reset link
    $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http')
        . '://' . $_SERVER['HTTP_HOST'];

    $resetLink = $baseUrl . '/reset_password.php?token=' . $token;

    // Send email
    $subject = 'Password Reset Request';
    $message = "Hello,\n\nWe received a request to reset your password. Click the link below to set a new password (valid for 1 hour):\n\n$resetLink\n\nIf you did not request this, you can ignore this email.\n\nBest regards,\nDove Haven Team";
    $headers = "From: no-reply@dovehaven.com";

    mail($email, $subject, $message, $headers);
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
}