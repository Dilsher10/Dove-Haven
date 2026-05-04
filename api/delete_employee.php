<?php
header("Content-Type: application/json");
require_once "../config/config.php";

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
    exit;
}

if (!isset($_GET['id'])) {
    echo json_encode(["success" => false, "message" => "Employee ID is required"]);
    exit;
}

$employeeId = intval($_GET['id']);

$conn->begin_transaction();

try {

    // Get employee role
    $stmt = $conn->prepare("SELECT role FROM employees WHERE id = ?");
    $stmt->bind_param("i", $employeeId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        throw new Exception("Employee not found");
    }

    $employee = $result->fetch_assoc();
    $role = $employee['role'];

    // If role is manager, delete assigned houses
    if ($role === 'manager') {
        $stmt = $conn->prepare("DELETE FROM user_house_assignments WHERE employee_id = ?");
        $stmt->bind_param("i", $employeeId);
        $stmt->execute();
    }

    // Delete employee
    $stmt = $conn->prepare("DELETE FROM employees WHERE id = ?");
    $stmt->bind_param("i", $employeeId);
    $stmt->execute();

    $conn->commit();

    echo json_encode([
        "success" => true,
        "message" => "Employee deleted successfully"
    ]);

} catch (Exception $e) {

    $conn->rollback();

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}

$conn->close();