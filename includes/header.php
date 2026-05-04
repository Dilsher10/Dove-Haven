<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dove Haven Farms - Management Portal</title>
    <link rel="icon" type="image/x-icon" href="./assets/images/favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<?php
$user_info = get_current_user_info();
$body_class = 'bg-gray-50 font-[\'Inter\'] text-gray-800 role-' . ($user_info['role'] ?? 'guest');
?>
<body class="<?php echo $body_class; ?>">
<div id="alertDashboardLogin" class="fixed top-4 right-4 z-50 space-y-2"></div>