<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
require_once '../auth/role_middleware.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    check_access(['Admin', 'Farm Manager'], $data['houseId'], 'write');

    try {
        $stmt = $conn->prepare("INSERT INTO mortality (date, house_id, deaths, cause, notes) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiss", $data['date'], $data['houseId'], $data['deaths'], $data['cause'], $data['notes']);
        $stmt->execute();
        echo json_encode(['success' => true]);
    } catch (\mysqli_sql_exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
