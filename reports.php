<?php 
require_once './auth/role_middleware.php';
$user_id = check_access(['Admin', 'Farm Manager', 'Supervisor', 'Sales Manager']);
include './includes/header.php'; 
?>

<div id="app" class="min-h-screen flex flex-col md:flex-row">
    <?php include './includes/sidebar.php'; ?>

    <main class="flex-1 overflow-y-auto bg-gray-50 p-4 md:p-8">
        <div id="alertsContainer" class="fixed top-4 right-4 z-50 space-y-2"></div>

        <!-- Reports Page -->
        <div id="page-reports" class="page-content space-y-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Reports & Analytics</h1>
                    <p class="text-gray-600">Generate production, sales, and inventory reports</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold mb-4">Generate Report</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                    <select id="reportType" class="px-4 py-2 border border-gray-300 rounded-lg outline-none">
                        <option value="daily">Daily Report</option>
                        <option value="weekly">Weekly Report</option>
                        <option value="monthly">Monthly Report</option>
                        <option value="custom">Custom Range</option>
                    </select>
                    <input type="date" id="reportStartDate" class="px-4 py-2 border border-gray-300 rounded-lg outline-none">
                    <input type="date" id="reportEndDate" class="px-4 py-2 border border-gray-300 rounded-lg outline-none">
                    <select id="reportFormat" class="px-4 py-2 border border-gray-300 rounded-lg outline-none">
                        <option value="pdf">PDF Export</option>
                        <option value="view">View Online</option>
                    </select>
                </div>
                <button onclick="generateReport()" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    Generate Report
                </button>
            </div>

            <div id="reportPreview" class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hidden">
                <div id="reportContent" class="space-y-4"></div>
            </div>
        </div>
    </main>
</div>

<?php include './includes/modals.php'; ?>
<?php include './includes/footer.php'; ?>
