<?php
header('Content-Type: application/json');
require_once '../auth/role_middleware.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = check_access(['Admin']);
    
    $eggsPerCrate = $_POST['eggsPerCrate'] ?? null;
    $stockThreshold = $_POST['stockThreshold'] ?? null;

    if ($eggsPerCrate === null || $stockThreshold === null) {
        echo json_encode(['error' => 'Missing required fields.']);
        exit;
    }

    try {
        $stmt = $conn->prepare("UPDATE system_settings SET setting_value = ? WHERE setting_key = 'eggsPerCrate'");
        $stmt->bind_param('s', $eggsPerCrate);
        $stmt->execute();

        $stmt = $conn->prepare("UPDATE system_settings SET setting_value = ? WHERE setting_key = 'stockThreshold'");
        $stmt->bind_param('s', $stockThreshold);
        $stmt->execute();

        echo json_encode(['success' => true, 'message' => 'Settings updated successfully.']);
    } catch (\mysqli_sql_exception $e) {
        echo json_encode(['error' => 'Database update failed: ' . $e->getMessage()]);
    }
}
