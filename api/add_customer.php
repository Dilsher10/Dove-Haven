<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');





$host = 'localhost';
$db   = 'dovehaven';
$user = 'root'; 
$pass = '';   
$charset = 'utf8mb4';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($host, $user, $pass, $db);
    $conn->set_charset($charset);
} catch (\mysqli_sql_exception $e) {
    echo json_encode(['error' => 'Database connection failed. fallback to local mock data.']);
    exit;
}





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
