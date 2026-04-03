<?php 
require_once './auth/role_middleware.php';
$user_id = check_access(['Admin']);
include './includes/header.php'; 
?>

<div id="app" class="min-h-screen flex flex-col md:flex-row">
    <?php include './includes/sidebar.php'; ?>

    <main class="flex-1 overflow-y-auto bg-gray-50 p-4 md:p-8">
        <div id="alertsContainer" class="fixed top-4 right-4 z-50 space-y-2"></div>

        <!-- Admin Portal Page -->
        <div id="page-admin" class="page-content space-y-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Admin Portal</h1>
                    <p class="text-gray-600">Manage employees, system settings, and domain configuration</p>
                </div>
                <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                    admin.dovehaven.com
                </div>
            </div>

            <!-- Admin Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                    <p class="text-2xl font-bold text-gray-900" id="totalEmployees">0</p>
                    <p class="text-sm text-gray-600">Total Employees</p>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                    <p class="text-2xl font-bold text-green-600" id="activeEmployees">0</p>
                    <p class="text-sm text-gray-600">Active Today</p>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                    <p class="text-2xl font-bold text-blue-600" id="totalHouses">4</p>
                    <p class="text-sm text-gray-600">Active Houses</p>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                    <p class="text-2xl font-bold text-purple-600" id="dataEntries">0</p>
                    <p class="text-sm text-gray-600">Collections (7d)</p>
                </div>
            </div>

            <!-- Employee Management -->
             <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold">Employee Management</h3>
                    <button onclick="openEmployeeModal()"
                        class="flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        <i data-lucide="user-plus" class="w-4 h-4"></i>
                        Add Employee
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-6 py-4">Name</th>
                                <th class="px-6 py-4">Role</th>
                                <th class="px-6 py-4">Assigned Houses</th>
                                <th class="px-6 py-4">Last Login</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="employeesTableBody">
                            <!-- Populated by JS -->
                        </tbody>
                    </table>
                </div>
            </div>

              <!-- Domain Settings -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold mb-4">Domain Configuration</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="font-medium mb-1">Admin Portal</p>
                        <p class="text-sm text-gray-600 mb-2">Current: admin.dovehaven.com</p>
                        <input type="text" value="admin.dovehaven.com"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100" readonly>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="font-medium mb-1">Public Website</p>
                        <p class="text-sm text-gray-600 mb-2">Customer facing: dovehavenfarms.com</p>
                        <input type="text" value="dovehavenfarms.com"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100" readonly>
                    </div>
                </div>
            </div>

             <!-- System Settings -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold mb-4">System Settings</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Eggs per Crate (Standard)</label>
                        <input type="number" id="eggsPerCrate" value="30"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Low Feed Alert Threshold
                            (kg)</label>
                        <input type="number" id="stockThreshold" value="500"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<?php include './includes/modals.php'; ?>
<?php include './includes/footer.php'; ?>
