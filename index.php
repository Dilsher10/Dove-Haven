<?php
require_once './auth/auth_middleware.php';
if (is_logged_in()) {
    header("Location: dashboard.php");
} else {
    header("Location: login.php");
}
exit;
?>