<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
require_once '../auth/role_middleware.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    check_access(['Admin', 'Sales Manager'], null, 'write');

    try {
        $stmt = $conn->prepare("INSERT INTO orders (id, customer_id, date, items, quantity, product, total, paid, balance, payment_method, payment_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $product = 'various';
        $stmt->bind_param("sissisdddss", 
            $data['id'], $data['customerId'], $data['date'], $data['items'], $data['quantity'], 
            $product, $data['total'], $data['paid'], $data['balance'], $data['paymentMethod'], $data['paymentStatus']
        );
        $stmt->execute();
        
        $stmt2 = $conn->prepare("UPDATE customers SET balance = balance + ?, total_orders = total_orders + 1 WHERE id = ?");
        $stmt2->bind_param("di", $data['balance'], $data['customerId']);
        $stmt2->execute();

        echo json_encode(['success' => true]);
    } catch (\mysqli_sql_exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
