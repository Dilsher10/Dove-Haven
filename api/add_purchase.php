<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
require_once '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if it's a multipart/form-data request
    $isMultipart = !empty($_FILES) || (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'multipart/form-data') !== false);
    
    if ($isMultipart) {
        $data = $_POST;
        $invoice = null;
        if (isset($_FILES['purchaseInvoice']) && $_FILES['purchaseInvoice']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $filename = basename($_FILES['purchaseInvoice']['name']);
            if (move_uploaded_file($_FILES['purchaseInvoice']['tmp_name'], $uploadDir . $filename)) {
                $invoice = $filename;
            }
        }
    } else {
        $data = json_decode(file_get_contents("php://input"), true);
        $invoice = $data['purchaseInvoice'] ?? $data['invoice'] ?? null;
    }

    try {
        $stmt = $conn->prepare("INSERT INTO purchases (date, category, item, quantity, unit, unit_cost, total_cost, supplier, invoice) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $p1 = $data['purchaseDate'] ?? $data['date'] ?? '';
        $p2 = $data['purchaseCategory'] ?? $data['category'] ?? '';
        $p3 = $data['purchaseItem'] ?? $data['item'] ?? '';
        // Handle potential string versions of numbers from FormData
        $p4 = floatval($data['purchaseQty'] ?? $data['quantity'] ?? 0);
        $p5 = $data['purchaseUnit'] ?? $data['unit'] ?? '';
        $p6 = floatval($data['unitCost'] ?? 0);
        $p7 = floatval($data['totalCost'] ?? 0);
        $p8 = $data['purchaseSupplier'] ?? $data['supplier'] ?? '';
        $p9 = $invoice;

        $stmt->bind_param("sssdsddss", $p1, $p2, $p3, $p4, $p5, $p6, $p7, $p8, $p9);
        $stmt->execute();
        echo json_encode(['success' => true]);
    } catch (\mysqli_sql_exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
