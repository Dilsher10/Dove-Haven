<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
require_once '../auth/role_middleware.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Admin or Farm Manager for assigned house
    $user_id = check_access(['Admin', 'Farm Manager'], $data['houseId'], 'write');

    try {
        $stmt = $conn->prepare("INSERT INTO production (date, house_id, crates, loose_eggs, total_eggs, large_eggs, medium_eggs, small_eggs, pullet_eggs, broken_eggs, feed, feed_type, comments, employee_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $employeeId = $user_id;
        $stmt->bind_param("ssiiiiiiiiidss",
            $data['date'], $data['houseId'], $data['crates'], $data['looseEggs'], $data['totalEggs'],
            $data['grades']['large'], $data['grades']['medium'], $data['grades']['small'], $data['grades']['pullet'], $data['grades']['broken'],
            $data['feed'], $data['feedType'], $data['comments'], $employeeId
        );
        $stmt->execute();
        echo json_encode(['success' => true]);
    } catch (\mysqli_sql_exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
