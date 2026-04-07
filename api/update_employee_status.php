<?php
require_once '../config/config.php';

if ($conn->connect_error) {
    die(json_encode(["message" => "Database connection failed"]));
}

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? null;
$status = $data['status'] ?? null;

if (!$id || !$status) {
    echo json_encode(["message" => "Invalid input"]);
    exit;
}

$stmt = $conn->prepare("UPDATE employees SET status = ? WHERE id = ?");
$stmt->bind_param("si", $status, $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(["message" => "Status updated successfully"]);
    } else {
        echo json_encode(["message" => "Employee not found"]);
    }
} else {
    echo json_encode(["message" => "Update failed"]);
}

$stmt->close();
$conn->close();
?>