<?php
require_once __DIR__ . '/auth_middleware.php';

/**
 * Checks role and house-level access for the authenticated user.
 * 
 * @param array|string $required_roles List of roles allowed on this page.
 * @param string|null $house_id The ID of the house being accessed (if applicable).
 * @param string $action 'read' or 'write'.
 */
function check_access($required_roles, $house_id = null, $action = 'read') {
    // 1. Ensure user is authenticated
    $user_id = authenticate_user();
    global $conn;

    // 2. Fetch user role
    $stmt = $conn->prepare("SELECT role, name FROM employees WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if (!$user) {
        deny_access("User not found.");
    }

    $role = $user['role'];

    // 3. Admin has absolute bypass
    if ($role === 'admin') {
        return $user_id;
    }

    // 4. Validate Role Requirements
    $role_map = [
        'Admin' => 'admin',
        'Farm Manager' => 'farm_manager',
        'Supervisor' => 'supervisor',
        'Sales Manager' => 'sales_manager'
    ];
    
    $required_roles_list = (array)$required_roles;
    $db_required_roles = array_map(function($r) use ($role_map) {
        return $role_map[$r] ?? $r;
    }, $required_roles_list);

    if (!in_array($role, $db_required_roles)) {
        deny_access("Access Denied: Your role does not have permission for this section.");
    }

    // 5. Action-Level Restrictions
    // Supervisor is read-only
    if ($role === 'supervisor' && $action === 'write') {
        deny_access("Access Denied: Supervisors have read-only permissions.");
    }

    // 6. House-Level Restrictions
    if ($role === 'farm_manager' && $house_id) {
        $house_stmt = $conn->prepare("SELECT id FROM user_house_assignments WHERE user_id = ? AND house_id = ?");
        $house_stmt->bind_param("is", $user_id, $house_id);
        $house_stmt->execute();
        $is_assigned = ($house_stmt->get_result()->num_rows > 0);

        if (!$is_assigned) {
            deny_access("Access Denied: You are not assigned to " . htmlspecialchars($house_id));
        }
    }

    return $user_id;
}

/**
 * Stop execution and return error message
 */
function deny_access($message) {
    $is_api = strpos($_SERVER['REQUEST_URI'], '/api/') !== false || 
              (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false);

    if ($is_api) {
        header('Content-Type: application/json');
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => $message]);
    } else {
        // Just redirect to dashboard if unauthorized, no need for the UI box
        header('Location: dashboard.php');
    }
    exit;
}
