<?php
require_once './auth/auth_middleware.php';
if (is_logged_in()) {
    header('Location: dashboard.php');
    exit;
}
include './includes/header.php';
?>

<!-- Login Screen -->
<div id="loginScreen"
    class="fixed inset-0 bg-gradient-to-br from-green-600 to-teal-700 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md mx-4">
        <div class="text-center mb-8">
            <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="egg" class="w-8 h-8 text-green-600"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Dove Haven Farms</h1>
            <p class="text-gray-600 mt-2">Farm Management Portal</p>
        </div>
        <form id="loginForm" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none"
                    placeholder="Enter email" required>
            </div>
            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <div class="relative">
                    <input type="password" id="password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none"
                        placeholder="Enter password" required>
                    <button type="button" id="togglePassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none">
                        <i data-lucide="eye" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>
            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center">
                    <input type="checkbox" class="rounded text-green-600 focus:ring-green-500 mr-2">
                    <span class="text-gray-600">Remember me</span>
                </label>
                <a href="forgot_password.php" class="text-green-600 hover:text-green-700">Forgot password?</a>
            </div>
            <button type="submit"
                class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition duration-200 font-medium">
                Sign In
            </button>
        </form>
        <div class="mt-6 text-center text-sm text-gray-600">
            <p class="mt-1"><strong>Admin:</strong> admin@dovehaven.com</p>
            <p><strong>Farm Manager 1:</strong> manager1@dovehaven.com</p>
            <p><strong>Farm Manager 2:</strong> manager2@dovehaven.com</p>
            <p><strong>Supervisor:</strong> supervisor@dovehaven.com</p>
            <p><strong>Sales Manager:</strong> sales@dovehaven.com</p>
        </div>
    </div>
</div>

<?php
include './includes/footer.php';
?>
