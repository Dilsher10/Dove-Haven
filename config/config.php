<?php
$host = 'localhost';
$db   = 'codeanddesign_dovehaven';
$user = 'codeanddesign_dovehavenU'; 
$pass = 'dovehavenU';   
$charset = 'utf8mb4';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($host, $user, $pass, $db);
    $conn->set_charset($charset);
} catch (\mysqli_sql_exception $e) {
    echo json_encode(['error' => 'Database connection failed.']);
    exit;
}