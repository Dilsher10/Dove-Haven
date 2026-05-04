<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = json_decode(file_get_contents("php://input"), true);

    $usageDate = $data['usageDate'] ?? null;
    $ingredient = $data['usageIngredient'] ?? null;
    $type = $data['usageType'] ?? 'usage';
    $quantity = isset($data['usageQuantity']) ? floatval($data['usageQuantity']) : 0;
    $purpose = $data['usagePurpose'] ?? '';
    $notes = $data['usageNotes'] ?? '';

    if (!$ingredient || !$usageDate || $quantity <= 0) {
        echo json_encode([
            'success' => false,
            'error' => 'Invalid input data'
        ]);
        exit;
    }

    try {
        $conn->begin_transaction();

        // Check current stock
        $checkStmt = $conn->prepare("SELECT quantity, used FROM inventory WHERE id = ?");
        $checkStmt->bind_param("s", $ingredient);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        $row = $result->fetch_assoc();

        if (!$row) {
            throw new Exception("Ingredient not found");
        }

        if ($row['quantity'] < $quantity) {
            throw new Exception("Not enough stock available");
        }

        $stmt = $conn->prepare("
            INSERT INTO inventory_transactions 
            (date, ingredient, type, quantity, purpose, notes) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("sssdss", $usageDate, $ingredient, $type, $quantity, $purpose, $notes);
        $stmt->execute();

        // Update inventory: reduce quantity and add to used
        $updateStmt = $conn->prepare("
            UPDATE inventory 
            SET quantity = quantity - ?, used = used + ? 
            WHERE id = ?
        ");
        $updateStmt->bind_param("dds", $quantity, $quantity, $ingredient);
        $updateStmt->execute();

        $conn->commit();
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
}
?>