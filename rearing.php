<?php 
require_once './auth/role_middleware.php';
$user_id = check_access(['Admin', 'Farm Manager', 'Supervisor']);
include './includes/header.php'; 
?>

<div id="app" class="min-h-screen flex flex-col md:flex-row">
    <?php include './includes/sidebar.php'; ?>

    <main class="flex-1 overflow-y-auto bg-gray-50 p-4 md:p-8">
        <div id="alertsContainer" class="fixed top-4 right-4 z-50 space-y-2"></div>

        <!-- Rearing & Production Page -->
        <div id="page-rearing" class="page-content space-y-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Rearing & Production</h1>
                    <p class="text-gray-600">Monitor flock growth, mortality, and egg production by house unit</p>
                </div>
                <div class="flex gap-2">
                    <button onclick="openGrowthModal()"
                        class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        <i data-lucide="trending-up" class="w-4 h-4"></i>
                        <span>Record Growth</span>
                    </button>
                    <button onclick="openMortalityModal()"
                        class="flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        <i data-lucide="heart-pulse" class="w-4 h-4"></i>
                        <span>Record Mortality</span>
                    </button>
                    <button onclick="openProductionModal()"
                        class="flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        <span>Add Collection</span>
                    </button>
                </div>
            </div>

            <!-- House Units Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4" id="houseUnitsGrid">
            <!-- Populated by JS -->
            </div>

            <!-- House Detail Section -->
            <div id="houseDetailSection"
                class="hidden bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-6">
                <!-- Content same as in index.php -->
                <div class="flex justify-between items-center border-b pb-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900" id="selectedHouseName">House 1A</h2>
                        <p class="text-gray-600">Flock monitoring and production analytics</p>
                    </div>
                    <button onclick="closeHouseDetail()" class="text-gray-400 hover:text-gray-600">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                        <p class="text-sm text-blue-600 mb-1">Total Birds</p>
                        <p class="text-2xl font-bold text-blue-900" id="flockTotalBirds">0</p>
                    </div>
                    <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                        <p class="text-sm text-red-600 mb-1">Mortality Rate</p>
                        <p class="text-2xl font-bold text-red-900" id="flockMortalityRate">0%</p>
                        <p class="text-xs text-red-700">Total losses: <span id="flockTotalLosses">0</span></p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                        <p class="text-sm text-green-600 mb-1">Avg Daily Production</p>
                        <p class="text-2xl font-bold text-green-900" id="flockAvgProduction">0</p>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                        <p class="text-sm text-purple-600 mb-1">Feed Conversion</p>
                        <p class="text-2xl font-bold text-purple-900" id="flockFeedConversion">0.0</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Growth Chart</h3>
                        <canvas id="growthChart" height="250"></canvas>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Mortality Trend</h3>
                        <canvas id="mortalityChart" height="250"></canvas>
                    </div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Laying Performance (% Hen Day)</h3>
                        <canvas id="layingChart" height="250"></canvas>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Production Benchmark Comparison</h3>
                        <div class="space-y-4" id="benchmarkSection">
                            <!-- Populated by JS -->
                        </div>
                    </div>
                </div>


                <!-- Production Data Table for this House -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Production History</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3">Date</th>
                                    <th class="px-4 py-3">Large</th>
                                    <th class="px-4 py-3">Medium</th>
                                    <th class="px-4 py-3">Small</th>
                                    <th class="px-4 py-3">Pullet</th>
                                    <th class="px-4 py-3">Broken</th>
                                    <th class="px-4 py-3">Total Crates</th>
                                    <th class="px-4 py-3">Total Eggs</th>
                                </tr>
                            </thead>
                            <tbody id="houseProductionTable">
                                <!-- Populated by JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>


<?php include './includes/modals.php'; ?>
<?php include './includes/footer.php'; ?>