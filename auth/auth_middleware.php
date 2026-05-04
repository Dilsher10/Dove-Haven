<?php
require_once __DIR__ . '/jwt_helper.php';
require_once __DIR__ . '/../config/config.php';

// Validates user authentication for APIs (via Authorization header)
function requireAuth() {
    $headers = getallheaders();
    $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';

    if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $jwt = $matches[1];
        $decoded = JWTHelper::verify($jwt);
        if ($decoded) {
            return $decoded['user_id'];
        }
    }

    // Invalid or missing token
    header('Content-Type: application/json');
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Validates user authentication for full page loads
function authenticate_user() {
    global $conn;
    $jwt = null;

    // Try to read from Authorization header
    $headers = getallheaders();
    $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';
    if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $jwt = $matches[1];
    }

    // Try to read from Cookie
    if (!$jwt && isset($_COOKIE['access_token'])) {
        $jwt = $_COOKIE['access_token'];
    }

    if (!$jwt) {
        handle_unauthorized();
    }

    // Verify JWT signature and expiry
    $decoded = JWTHelper::verify($jwt);
    if (!$decoded) {
        handle_unauthorized();
    }

    $user_id = $decoded['user_id'];

    // Check if user exists in employees table
    $stmt = $conn->prepare("SELECT id FROM employees WHERE id = ? AND status = 'active'");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows === 0) {
        handle_unauthorized();
    }

    // Deny access if refresh token was deleted (user logged out)
    $token_stmt = $conn->prepare("SELECT id FROM refresh_tokens WHERE user_id = ?");
    $token_stmt->bind_param("i", $user_id);
    $token_stmt->execute();
    if ($token_stmt->get_result()->num_rows === 0) {
        handle_unauthorized();
    }

    return $user_id;
}

function handle_unauthorized() {
    $is_api = strpos($_SERVER['REQUEST_URI'], '/api/') !== false || 
              (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false);

    if ($is_api) {
        header('Content-Type: application/json');
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    } else {
        header('Location: login.php');
    }
    exit;
}

// Returns true if the user is currently authenticated
function is_logged_in() {
    global $conn;
    $jwt = $_COOKIE['access_token'] ?? null;
    if (!$jwt) return false;

    $decoded = JWTHelper::verify($jwt);
    if (!$decoded) return false;

    $user_id = $decoded['user_id'];
    $stmt = $conn->prepare("SELECT id FROM employees WHERE id = ? AND status = 'active'");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows === 0) return false;

    $token_stmt = $conn->prepare("SELECT id FROM refresh_tokens WHERE user_id = ?");
    $token_stmt->bind_param("i", $user_id);
    $token_stmt->execute();
    if ($token_stmt->get_result()->num_rows === 0) return false;

    return true;
}

// Get current user role and name safely
function get_current_user_info() {
    global $conn;
    $jwt = $_COOKIE['access_token'] ?? null;
    if (!$jwt) return null;

    $decoded = JWTHelper::verify($jwt);
    if (!$decoded) return null;

    $user_id = $decoded['user_id'];
    $stmt = $conn->prepare("SELECT id, name, role FROM employees WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}
