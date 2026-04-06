<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
require_once '../auth/role_middleware.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = check_access(['Admin']);

    $data = json_decode(file_get_contents("php://input"), true);
    
    if (!isset($data['employee_id']) || !isset($data['houses']) || !is_array($data['houses'])) {
        echo json_encode(['success' => false, 'error' => 'Invalid parameters.']);
        exit;
    }
    
    $employee_id = (int)$data['employee_id'];
    $houses = $data['houses'];

    $conn->begin_transaction();
    try {
        $stmt = $conn->prepare("DELETE FROM user_house_assignments WHERE employee_id = ?");
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        
        if (count($houses) > 0) {
            $insert_stmt = $conn->prepare("INSERT INTO user_house_assignments (employee_id, house_id) VALUES (?, ?)");
            foreach ($houses as $house_id) {
                $house_str = (string)$house_id;
                $insert_stmt->bind_param("is", $employee_id, $house_str);
                $insert_stmt->execute();
            }
        }
        
        $conn->commit();
        echo json_encode(['success' => true]);
    } catch (\Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
