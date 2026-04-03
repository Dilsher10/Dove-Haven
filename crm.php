<?php 
require_once './auth/role_middleware.php';
$user_id = check_access(['Admin', 'Sales Manager']);
include './includes/header.php'; 
?>

<div id="app" class="min-h-screen flex flex-col md:flex-row">
    <?php include './includes/sidebar.php'; ?>

    <main class="flex-1 overflow-y-auto bg-gray-50 p-4 md:p-8">
        <div id="alertsContainer" class="fixed top-4 right-4 z-50 space-y-2"></div>

        <!-- Sales & Purchases Page -->
        <div id="page-crm" class="page-content space-y-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Sales & Purchases</h1>
                    <p class="text-gray-600">Manage orders, track payments, record purchases, and monitor stock</p>
                </div>
                <div class="flex gap-2">
                    <button onclick="openModal('customerModal')"
                        class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        <i data-lucide="user-plus" class="w-4 h-4"></i>
                        <span>New Customer</span>
                    </button>
                    <button onclick="openModal('orderModal')"
                        class="flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        <span>New Order</span>
                    </button>
                </div>
            </div>

                   <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                    <p class="text-sm text-gray-600 mb-1">Total Crates Today</p>
                    <p class="text-2xl font-bold text-gray-900" id="salesTotalCrates">0</p>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                    <p class="text-sm text-gray-600 mb-1">Loose Eggs</p>
                    <p class="text-2xl font-bold text-gray-900" id="salesTotalLoose">0</p>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                    <p class="text-sm text-gray-600 mb-1">Excess Quantity</p>
                    <p class="text-2xl font-bold text-orange-600" id="salesTotalExcess">0</p>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                    <p class="text-sm text-gray-600 mb-1">Crates in Stock</p>
                    <p class="text-2xl font-bold text-blue-600" id="salesCratesStock">0</p>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                    <p class="text-sm text-gray-600 mb-1">Total Eggs (All Grades)</p>
                    <p class="text-2xl font-bold text-green-600" id="salesTotalEggs">0</p>
                </div>
            </div>

             <!-- Egg Grades Breakdown -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold mb-4">Available Stock by Grade</h3>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4" id="eggGradesStock">
                    <!-- Populated by JS -->
                </div>
            </div>

             <!-- CRM Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <p class="text-sm text-gray-600 mb-1">Total Outstanding</p>
                    <p class="text-2xl font-bold text-red-600" id="totalOutstanding">GH₵0.00</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <p class="text-sm text-gray-600 mb-1">Today's Cash Sales</p>
                    <p class="text-2xl font-bold text-green-600" id="cashSales">GH₵0.00</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <p class="text-sm text-gray-600 mb-1">Bank Deposits</p>
                    <p class="text-2xl font-bold text-blue-600" id="bankSales">GH₵0.00</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <p class="text-sm text-gray-600 mb-1">Pending Balance</p>
                    <p class="text-2xl font-bold text-orange-600" id="pendingBalance">GH₵0.00</p>
                </div>
            </div>

            <!-- Purchases Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold">Purchases Recording</h3>
                    <button onclick="openPurchaseModal()"
                        class="flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        <span>Record Purchase</span>
                    </button>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3">Date</th>
                                    <th class="px-4 py-3">Item</th>
                                    <th class="px-4 py-3">Category</th>
                                    <th class="px-4 py-3">Quantity</th>
                                    <th class="px-4 py-3">Unit Cost</th>
                                    <th class="px-4 py-3">Total Cost</th>
                                    <th class="px-4 py-3">Supplier</th>
                                    <th class="px-4 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="purchasesTableBody">
                                <!-- Populated by JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="border-b border-gray-200">
                    <div class="flex">
                        <button onclick="switchCrmTab('customers')" id="tab-customers" class="px-6 py-3 text-sm font-medium border-b-2 border-green-600 text-green-600">Customers</button>
                        <button onclick="switchCrmTab('orders')" id="tab-orders" class="px-6 py-3 text-sm font-medium border-b-2 border-transparent text-gray-600 hover:text-gray-800">Orders & Payments</button>
                    </div>
                </div>
                <div class="p-6">
                    <div id="crm-customers" class="crm-tab-content">
                        <table class="w-full text-sm text-left"><tbody id="customersTableBody"></tbody></table>
                    </div>
                    <div id="crm-orders" class="crm-tab-content hidden">
                        <table class="w-full text-sm text-left"><tbody id="ordersTableBody"></tbody></table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<?php include './includes/modals.php'; ?>
<?php include './includes/footer.php'; ?>
