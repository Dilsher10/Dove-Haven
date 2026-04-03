<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
require_once '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Ensure quantity is a float
    $data['purchaseQuantity'] = isset($data['purchaseQuantity']) ? floatval($data['purchaseQuantity']) : 0;

    if (!$data['purchaseIngredient'] || !$data['purchaseDate'] || $data['purchaseQuantity'] <= 0) {
        echo json_encode(['success' => false, 'error' => 'Invalid input data']);
        exit;
    }

    try {
        // Start transaction
        $conn->begin_transaction();

        // Insert transaction record
        $stmt = $conn->prepare("
            INSERT INTO inventory_transactions 
            (date, ingredient, type, quantity, purpose, notes) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            "sssdss", 
            $data['purchaseDate'], 
            $data['purchaseIngredient'], 
            $data['purchaseType'], 
            $data['purchaseQuantity'], 
            $data['purchasePurpose'], 
            $data['purchaseNote']
        );
        $stmt->execute();

        // Update inventory: increase quantity and purchased
        $updateStmt = $conn->prepare("
            UPDATE inventory 
            SET quantity = quantity + ?, purchased = purchased + ? 
            WHERE id = ?
        ");
        $updateStmt->bind_param("dds", $data['purchaseQuantity'], $data['purchaseQuantity'], $data['purchaseIngredient']);
        $updateStmt->execute();

        // Commit transaction
        $conn->commit();

        echo json_encode(['success' => true]);

    } catch (\Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
?>