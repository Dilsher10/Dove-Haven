<?php
require_once __DIR__ . '/../config/config.php';

// List of demo accounts and their plain-text passwords
$users = [
    'admin@dovehaven.com' => 'admin123',
    'manager1@dovehaven.com' => 'manager123',
    'manager2@dovehaven.com' => 'manager123',
    'supervisor@dovehaven.com' => 'super123',
    'sales@dovehaven.com' => 'sales123'
];

echo "Updating passwords to bcrypt...\n";

foreach ($users as $email => $plain_password) {
    $hashed_password = password_hash($plain_password, PASSWORD_BCRYPT, ['cost' => 12]);
    
    $stmt = $conn->prepare("UPDATE employees SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $hashed_password, $email);
    
    if ($stmt->execute()) {
        echo "Updated password for: $email\n";
    } else {
        echo "Failed to update password for: $email\n";
    }
}

echo "Done.\n";
