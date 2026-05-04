<?php
header("Content-Type: application/json");
require_once "../config/config.php";

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? null;
$role = $data['role'] ?? null;

$allowedRoles = ['auditor', 'farm_manager', 'supervisor', 'sales_manager'];

if (!$id || !$role) {
    echo json_encode([
        "success" => false,
        "message" => "Employee ID and role are required"
    ]);
    exit;
}

if (!in_array($role, $allowedRoles)) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid role selected"
    ]);
    exit;
}

$stmt = $conn->prepare("SELECT id FROM employees WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode([
        "success" => false,
        "message" => "Employee not found"
    ]);
    exit;
}

$stmt = $conn->prepare("UPDATE employees SET role = ? WHERE id = ?");
$stmt->bind_param("si", $role, $id);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Role updated successfully"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Failed to update role"
    ]);
}

$stmt->close();
$conn->close();