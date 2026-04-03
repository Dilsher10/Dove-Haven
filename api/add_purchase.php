<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
require_once '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    try {
        $stmt = $conn->prepare("INSERT INTO purchases (date, category, item, quantity, unit, unit_cost, total_cost, supplier) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $p1 = $data['purchaseDate'] ?? $data['date'];
        $p2 = $data['purchaseCategory'] ?? $data['category'];
        $p3 = $data['purchaseItem'] ?? $data['item'];
        $p4 = $data['purchaseQty'] ?? $data['quantity'];
        $p5 = $data['purchaseUnit'] ?? $data['unit'];
        $p6 = $data['unitCost'];
        $p7 = $data['totalCost'];
        $p8 = $data['purchaseSupplier'] ?? $data['supplier'];

        $stmt->bind_param("sssssdds", $p1, $p2, $p3, $p4, $p5, $p6, $p7, $p8);
        $stmt->execute();
        echo json_encode(['success' => true]);
    } catch (\mysqli_sql_exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
