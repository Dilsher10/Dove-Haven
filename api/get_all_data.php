<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
require_once '../auth/role_middleware.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $user_id = check_access(['Admin', 'Farm Manager', 'Supervisor', 'Sales Manager']);
    $response = [];
    try {
        $response['employees'] = $conn->query("SELECT * FROM employees")->fetch_all(MYSQLI_ASSOC);
        $dbProduction = $conn->query("SELECT * FROM production")->fetch_all(MYSQLI_ASSOC);
        $prodList = [];
        foreach ($dbProduction as $row) {
            $row['grades'] = [
                'large' => (int)$row['large_eggs'],
                'medium' => (int)$row['medium_eggs'],
                'small' => (int)$row['small_eggs'],
                'pullet' => (int)$row['pullet_eggs'],
                'broken' => (int)$row['broken_eggs']
            ];
            unset($row['large_eggs'], $row['medium_eggs'], $row['small_eggs'], $row['pullet_eggs'], $row['broken_eggs']);
            $prodList[] = $row;
        }
        $response['production'] = $prodList;
        $response['inventory'] = $conn->query("SELECT * FROM inventory")->fetch_all(MYSQLI_ASSOC);
        $response['customers'] = $conn->query("SELECT * FROM customers")->fetch_all(MYSQLI_ASSOC);
        $response['orders'] = $conn->query("SELECT * FROM orders")->fetch_all(MYSQLI_ASSOC);
        $response['purchases'] = $conn->query("SELECT * FROM purchases")->fetch_all(MYSQLI_ASSOC);
        $response['growthData'] = $conn->query("SELECT * FROM growth")->fetch_all(MYSQLI_ASSOC);
        $response['mortalityData'] = $conn->query("SELECT * FROM mortality")->fetch_all(MYSQLI_ASSOC);
        $response['inventoryTransactions'] = $conn->query("SELECT id, date, ingredient, type, quantity, purpose, notes FROM inventory_transactions")->fetch_all(MYSQLI_ASSOC);
        $response['payments'] = $conn->query("SELECT * FROM payments")->fetch_all(MYSQLI_ASSOC);
        $response['houses'] = $conn->query("SELECT * FROM houses")->fetch_all(MYSQLI_ASSOC);
        $response['user_house_assignments'] = $conn->query("SELECT * FROM user_house_assignments")->fetch_all(MYSQLI_ASSOC);
        
        $stock_res = $conn->query("SELECT stock FROM crate_inventory LIMIT 1")->fetch_assoc();
        $response['crateStock'] = $stock_res ? $stock_res['stock'] : 0;
        $response['crateMovements'] = $conn->query("SELECT * FROM crate_movements ORDER BY date DESC")->fetch_all(MYSQLI_ASSOC);

        // Ensure settings table exists and fetch them
        $conn->query("CREATE TABLE IF NOT EXISTS system_settings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            setting_key VARCHAR(100) UNIQUE NOT NULL,
            setting_value VARCHAR(255) NOT NULL
        )");

        // Check if default settings exist, if not insert them
        $defaults = [
            'eggsPerCrate' => '30',
            'stockThreshold' => '500'
        ];
        foreach ($defaults as $key => $val) {
            $conn->query("INSERT IGNORE INTO system_settings (setting_key, setting_value) VALUES ('$key', '$val')");
        }

        $settings_res = $conn->query("SELECT setting_key, setting_value FROM system_settings")->fetch_all(MYSQLI_ASSOC);
        $settings = [];
        foreach ($settings_res as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        $response['settings'] = $settings;

        $user_res = $conn->query("SELECT id, name, role FROM employees WHERE id = $user_id")->fetch_assoc();
        $response['currentUser'] = $user_res;
        
        echo json_encode($response);
    } catch (\mysqli_sql_exception $e) {
        echo json_encode(['error' => 'Database query failed.']);
    }
}
