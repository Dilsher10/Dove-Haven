<?php
$host = 'localhost';
$db   = 'dovehaven';
$user = 'root'; 
$pass = '';   
$charset = 'utf8mb4';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($host, $user, $pass, $db);
    $conn->set_charset($charset);
} catch (\mysqli_sql_exception $e) {
    echo json_encode(['error' => 'Database connection failed. fallback to local mock data.']);
    exit;
}