<?php
require_once './auth/auth_middleware.php';
if (is_logged_in()) {
    header('Location: dashboard.php');
    exit;
}
include './includes/header.php';
require_once './config/config.php'; 

$token = $_GET['token'] ?? '';
$valid = false;

if ($token) {
    $stmt = $conn->prepare("SELECT employee_id, expires_at FROM password_resets WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row && strtotime($row['expires_at']) > time()) {
        $valid = true;
    }
}
?>

<div id="resetPasswordScreen" class="fixed inset-0 bg-gradient-to-br from-green-600 to-teal-700 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md mx-4">
        <div class="text-center mb-8">
            <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="egg" class="w-8 h-8 text-green-600"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Dove Haven Farms</h1>
            <p class="text-gray-600 mt-2">Farm Management Portal</p>
        </div>
        
        <?php if ($valid): ?>
        <div id="alertsContainer" class="fixed top-4 right-4 z-50 space-y-2"></div>
        <form id="resetPasswordForm" method="POST" class="space-y-4">
             <div class="relative">
                <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                <div class="relative">
                    <input type="password" name="new_password" id="password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none"
                        placeholder="Enter password" required>
                    <button type="button" id="togglePassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none">
                        <i data-lucide="eye" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>
            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                <div class="relative">
                    <input type="password" name="confirm_password" id="confirmPassword"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none"
                        placeholder="Enter password" required>
                    <button type="button" id="toggleConfirmPassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none">
                        <i data-lucide="eye" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>
            <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition duration-200 font-medium">Reset Password</button>
        </form>
        <?php else: ?>
        <div class="text-center">
           <p class="mt-4 text-red-600 font-medium">Invalid or expired token.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php
include './includes/footer.php';
?>
