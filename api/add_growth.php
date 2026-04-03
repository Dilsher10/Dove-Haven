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
        $stmt = $conn->prepare("INSERT INTO growth (date, house_id, flock_id, avg_weight, bird_count, flock_age_weeks, water_type, water_amount, medication_name, medication_dosage, next_dose_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdiisdsss", 
            $data['date'], $data['houseId'], $data['flockId'], $data['avgWeight'], $data['birdCount'], $data['flockAgeWeeks'],
            $data['water']['type'], $data['water']['amount'], $data['water']['medicationName'], $data['water']['medicationDosage'], $data['water']['nextDoseDate']
        );
        $stmt->execute();
        echo json_encode(['success' => true]);
    } catch (\mysqli_sql_exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
