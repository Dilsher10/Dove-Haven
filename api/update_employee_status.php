<?php
header("Content-Type: application/json");
include 'db.php'; // your DB connection

$data = json_decode(file_get_contents("php://input"), true);

$id = $_GET['id'];
$status = $data['status'];

if (!$id || !$status) {
    echo json_encode(["message" => "Missing data"]);
    exit;
}

$sql = "UPDATE employees SET status = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $status, $id);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Employee status updated"
    ]);
} else {
    echo json_encode([
        "message" => "Database error"
    ]);
}
?>