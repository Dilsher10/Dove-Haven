<?php 
require_once './auth/auth_middleware.php';
$user_id = authenticate_user();
include './includes/header.php'; 
?>

<div id="app" class="min-h-screen flex flex-col md:flex-row">
    <?php include './includes/sidebar.php'; ?>

    <main class="flex-1 overflow-y-auto bg-gray-50 p-4 md:p-8">
        <div id="alertsContainer" class="fixed top-4 right-4 z-50 space-y-2"></div>

        <!-- Day-Old Chicks Page -->
        <div id="page-chicks" class="page-content space-y-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Day-Old Chick Management</h1>
                    <p class="text-gray-600">Track chick arrivals, mortality, and growth (Coming Soon)</p>
                </div>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-200 text-center">
                <div class="bg-gray-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="bird" class="w-8 h-8 text-gray-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Module Under Development</h3>
                <p class="text-gray-600 max-w-md mx-auto">This dashboard for tracking 1-day-old chick checks will be available in the next update.</p>
                <a href="dashboard.php"
                    class="mt-4 inline-block px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                    Return to Dashboard
                </a>
            </div>
        </div>
    </main>
</div>

<?php include './includes/modals.php'; ?>
<?php include './includes/footer.php'; ?>
