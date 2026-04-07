<?php 
require_once './auth/role_middleware.php';
$user_id = check_access(['Admin', 'Farm Manager', 'Supervisor', 'Sales Manager']);
include './includes/header.php'; 
?>

<div id="app" class="min-h-screen flex flex-col md:flex-row">
    <?php include './includes/sidebar.php'; ?>

    <main class="flex-1 overflow-y-auto bg-gray-50 p-4 md:p-8">
        <div id="alertsContainer" class="fixed top-4 right-4 z-50 space-y-2"></div>

        <!-- Dashboard Page -->
        <div id="page-dashboard" class="page-content space-y-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Farm Overview</h1>
                    <p class="text-gray-600">Welcome back! Here's what's happening today at Dove Haven Farms.</p>
                </div>
                <div class="flex gap-2">
                    <button onclick="refreshDashboard()"
                        class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                        <span>Refresh</span>
                    </button>
                    <button onclick="exportDashboardPDF()"
                        class="flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        <i data-lucide="download" class="w-4 h-4"></i>
                        <span>Export PDF</span>
                    </button>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <i data-lucide="egg" class="w-6 h-6 text-blue-600"></i>
                        </div>
                        <span class="text-sm text-green-600 font-medium" id="eggTrend">+12%</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900" id="todayEggs">
                        <!-- Populated by JS -->
                    </p>
                    <p class="text-sm text-gray-600">Eggs Today</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-orange-100 rounded-lg">
                            <i data-lucide="package" class="w-6 h-6 text-orange-600"></i>
                        </div>
                        <span class="text-sm text-gray-600 font-medium">In Stock</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900" id="todayCrates">0</p>
                    <p class="text-sm text-gray-600">Crates Available</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-green-100 rounded-lg">
                            <i data-lucide="dollar-sign" class="w-6 h-6 text-green-600"></i>
                        </div>
                        <span class="text-sm text-green-600 font-medium">+8%</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900" id="todaySales">GH₵0</p>
                    <p class="text-sm text-gray-600">Today's Revenue</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-purple-100 rounded-lg">
                            <i data-lucide="activity" class="w-6 h-6 text-purple-600"></i>
                        </div>
                        <span class="text-sm text-gray-600 font-medium">Active</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">3,450</p>
                    <p class="text-sm text-gray-600">Birds in Houses</p>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Weekly Egg Production</h3>
                    <canvas id="productionChart" height="250"></canvas>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">House Performance</h3>
                    <canvas id="houseChart" height="250"></canvas>
                </div>
            </div>

            <!-- Recent Activity & House Status -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Recent Collections</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3">Date</th>
                                    <th class="px-4 py-3">House</th>
                                    <th class="px-4 py-3">Crates</th>
                                    <th class="px-4 py-3">Loose Eggs</th>
                                    <th class="px-4 py-3">Total Eggs</th>
                                    <th class="px-4 py-3">Collected By</th>
                                </tr>
                            </thead>
                            <tbody id="recentProductionTable">
                                <!-- Populated by JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">House Status</h3>
                    <div id="houseStatus" class="space-y-3">
                        <!-- Populated by JS -->
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<?php include './includes/modals.php'; ?>
<?php include './includes/footer.php'; ?>
