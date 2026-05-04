<?php 
require_once './auth/role_middleware.php';
$user_id = check_access(['Admin', 'Farm Manager', 'Sales Manager']);
include './includes/header.php'; 
?>

<div id="app" class="min-h-screen flex flex-col md:flex-row">
    <?php include './includes/sidebar.php'; ?>

    <main class="flex-1 overflow-y-auto bg-gray-50 p-4 md:p-8">


        <!-- Crate Inventory Page -->
        <div id="page-crates" class="page-content space-y-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Crate Inventory Management</h1>
                    <p class="text-gray-600">Real-time crate tracking from production to sales</p>
                </div>
                <div class="flex gap-2">
                    <button onclick="openModal('crateAdjustmentModal')"
                        class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        <i data-lucide="adjustments" class="w-4 h-4"></i>
                        <span>Adjust Stock</span>
                    </button>
                </div>
            </div>

                      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold mb-2">Available Crates</h3>
                    <p class="text-4xl font-bold text-green-600" id="availableCrates">0</p>
                    <p class="text-sm text-gray-600 mt-2">Ready for sale</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold mb-2">Reserved/Sold Today</h3>
                    <p class="text-4xl font-bold text-blue-600" id="soldCratesToday">0</p>
                    <p class="text-sm text-gray-600 mt-2">From today's orders</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold mb-2">Damaged/Lost</h3>
                    <p class="text-4xl font-bold text-red-600" id="damagedCrates">0</p>
                    <p class="text-sm text-gray-600 mt-2">Needs replacement</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold mb-4">Crate Movement Log</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-3">Date/Time</th>
                                <th class="px-4 py-3">Type</th>
                                <th class="px-4 py-3">Quantity</th>
                                <th class="px-4 py-3">Source/Destination</th>
                                <th class="px-4 py-3">Balance</th>
                            </tr>
                        </thead>
                        <tbody id="crateMovementTable"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<?php include './includes/modals.php'; ?>
<?php include './includes/footer.php'; ?>
