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
            $product, $data['total'], $data['paid'], $data['balance'], $data['payment_method'], $data['paymentStatus']
        );
        $stmt->execute();
        
        $stmt2 = $conn->prepare("UPDATE customers SET balance = balance + ?, total_orders = total_orders + 1 WHERE id = ?");
        $stmt2->bind_param("di", $data['balance'], $data['customerId']);
        $stmt2->execute();

        // Update Crate Stock
        if ($data['quantity'] > 0) {
            $qty = (int)$data['quantity'];
            $conn->query("UPDATE crate_inventory SET stock = stock - $qty");
            
            $stockRes = $conn->query("SELECT stock FROM crate_inventory LIMIT 1");
            $newStock = $stockRes->fetch_assoc()['stock'];
            
            $custRes = $conn->query("SELECT name FROM customers WHERE id = " . (int)$data['customerId']);
            $customerName = $custRes->fetch_assoc()['name'];
            
            $stmt3 = $conn->prepare("INSERT INTO crate_movements (type, quantity, reason, balance) VALUES ('Sale', ?, ?, ?)");
            $negQty = -$qty;
            $reason = "Order to " . $customerName;
            $stmt3->bind_param("isi", $negQty, $reason, $newStock);
            $stmt3->execute();
        }

        echo json_encode(['success' => true]);
    } catch (\mysqli_sql_exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
