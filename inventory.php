<?php 
require_once './auth/role_middleware.php';
$user_id = check_access(['Admin', 'Farm Manager', 'Supervisor']);
include './includes/header.php'; 
?>

<div id="app" class="min-h-screen flex flex-col md:flex-row">
    <?php include './includes/sidebar.php'; ?>

    <main class="flex-1 overflow-y-auto bg-gray-50 p-4 md:p-8">
        <div id="alertsContainer" class="fixed top-4 right-4 z-50 space-y-2"></div>
        <!-- Feed Stock Page -->
        <div id="page-inventory" class="page-content space-y-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Feed & Ingredients Stock</h1>
                    <p class="text-gray-600">Track all ingredients for feed formulation</p>
                </div>
                <div class="flex gap-2">
                    <button onclick="openModal('inventoryModal')"
                        class="flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        <span>Add Purchase</span>
                    </button>
                    <button onclick="openIngredientUsageModal()"
                        class="flex items-center gap-2 px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition">
                        <i data-lucide="minus" class="w-4 h-4"></i>
                        <span>Record Usage</span>
                    </button>
                </div>
            </div>

            <div id="inventoryAlerts" class="space-y-2"></div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4" id="ingredientsGrid"></div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold mb-4">Inventory Transactions</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-3">Date</th>
                                <th class="px-4 py-3">Ingredient</th>
                                <th class="px-4 py-3">Type</th>
                                <th class="px-4 py-3">Quantity</th>
                                <th class="px-4 py-3">Balance</th>
                                <th class="px-4 py-3">Notes</th>
                            </tr>
                        </thead>
                        <tbody id="inventoryHistoryTable"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<?php include './includes/modals.php'; ?>
<?php include './includes/footer.php'; ?>
