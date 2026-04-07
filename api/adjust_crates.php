<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
require_once '../auth/role_middleware.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Admin or Farm Manager or Sales Manager
    $user_id = check_access(['Admin', 'Farm Manager', 'Sales Manager']);

    try {
        $type = $data['adjustmentType'];
        $qty = (int)$data['crateQty'];
        $reason = $data['reason'];
        $actualQty = ($type === 'add') ? $qty : (($type === 'remove') ? -$qty : 0);

        // Calculate and validate for stock correction
        if ($type === 'correct') {
            // Get current stock
            $stockRes = $conn->query("SELECT stock FROM crate_inventory LIMIT 1");
            $currentStock = $stockRes->fetch_assoc()['stock'];
            $actualQty = $qty - $currentStock;
            $finalStock = $qty;
            $typeLabel = 'Correction';
        } else {
            // Update stock
            $conn->query("UPDATE crate_inventory SET stock = stock + $actualQty");
            
            // Get updated stock
            $stockRes = $conn->query("SELECT stock FROM crate_inventory LIMIT 1");
            $finalStock = $stockRes->fetch_assoc()['stock'];
            $typeLabel = ($type === 'add') ? 'Purchase/Return' : 'Damage/Loss';
        }

        if ($type === 'correct') {
            $conn->query("UPDATE crate_inventory SET stock = $qty");
        }

        // Record movement
        $stmt = $conn->prepare("INSERT INTO crate_movements (type, quantity, reason, balance) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sisi", $typeLabel, $actualQty, $reason, $finalStock);
        $stmt->execute();

        echo json_encode(['success' => true, 'newStock' => $finalStock]);
    } catch (\mysqli_sql_exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
?>
