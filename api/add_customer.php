<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
require_once '../auth/role_middleware.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    try {
        $stmt = $conn->prepare("INSERT INTO customers (name, email, phone, address, balance, total_orders) VALUES (?, ?, ?, ?, 0, 0)");
        $stmt->bind_param("ssss", $data['name'], $data['email'], $data['phone'], $data['address']);
        $stmt->execute();
        $id = $conn->insert_id;
        echo json_encode(['success' => true, 'id' => $id]);
    } catch (\mysqli_sql_exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
