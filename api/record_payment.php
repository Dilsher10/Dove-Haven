<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config/config.php';
require_once '../auth/role_middleware.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    check_access(['Admin', 'Sales Manager'], null, 'write');
    $conn->begin_transaction();

    try {
        // Get customer_id for this order
        $idStmt = $conn->prepare("SELECT customer_id FROM orders WHERE id = ?");
        $idStmt->bind_param("s", $data['orderId']);
        $idStmt->execute();
        $res = $idStmt->get_result();
        $order = $res->fetch_assoc();
        
        if (!$order) {
            throw new Exception("Order not found.");
        }
        
        $customerId = $order['customer_id'];

        // Insert into payments table
        $stmt = $conn->prepare("INSERT INTO payments (order_id, amount, payment_method, payment_ref) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdss", $data['orderId'], $data['amount'], $data['paymentMethod'], $data['paymentRef']);
        $stmt->execute();

        // Update the specific order
        $updateStmt = $conn->prepare("
            UPDATE orders 
            SET paid = paid + ?, 
                balance = balance - ?, 
                payment_status = CASE WHEN balance - ? <= 0 THEN 'paid' ELSE 'partial' END 
            WHERE id = ?
        ");
        
        $updateStmt->bind_param("ddds", $data['amount'], $data['amount'], $data['amount'], $data['orderId']);
        $updateStmt->execute();

        // 4. Update the customer overall balance
        $custStmt = $conn->prepare("UPDATE customers SET balance = balance - ? WHERE id = ?");
        $custStmt->bind_param("di", $data['amount'], $customerId);
        $custStmt->execute();

        $conn->commit();
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
?>