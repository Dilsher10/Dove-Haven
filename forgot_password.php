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
            <button type="submit"
                class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition duration-200 font-medium">
                Send Email
            </button>
        </form>
    </div>
</div>

<?php
include './includes/footer.php';
?>
