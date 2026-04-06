<?php
require_once './auth/auth_middleware.php';
$current_page = basename($_SERVER['PHP_SELF']);
$user_info = get_current_user_info();
$user_role = $user_info['role'] ?? '';
$user_name = $user_info['name'] ?? 'User Name';

// Define access helper
function has_access($page, $role) {
    if ($role === 'admin') return true;
    
    $permissions = [
        'dashboard' => ['admin', 'farm_manager', 'supervisor', 'sales_manager'],
        'rearing' => ['admin', 'farm_manager', 'supervisor'],
        'inventory' => ['admin', 'farm_manager', 'supervisor'],
        'crm' => ['admin', 'sales_manager'],
        'crates' => ['admin', 'farm_manager', 'sales_manager'],
        'reports' => ['admin', 'farm_manager', 'supervisor', 'sales_manager'],
        'chicks' => ['admin'],
        'admin' => ['admin']
    ];
    
    return in_array($role, $permissions[$page] ?? []);
}
?>
<!-- Sidebar -->
<aside id="sidebar"
    class="bg-gray-900 text-white w-full md:w-64 flex-shrink-0 hidden md:flex flex-col transition-all duration-300">
    <div class="p-6 border-b border-gray-800">
        <div class="flex items-center gap-3">
            <div class="bg-green-500 p-2 rounded-lg">
                <i data-lucide="egg" class="w-6 h-6 text-white"></i>
            </div>
            <div>
                <h2 class="font-bold text-lg">Dove Haven</h2>
                <p class="text-xs text-gray-400">Farm Portal</p>
            </div>
        </div>
    </div>
    <nav class="flex-1 overflow-y-auto p-4 space-y-1">
        <?php if (has_access('dashboard', $user_role)): ?>
        <a href="dashboard.php"
            class="nav-btn w-full flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition text-left <?php echo $current_page == 'dashboard.php' ? 'bg-gray-800' : ''; ?>"
            data-page="dashboard">
            <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
            <span>Dashboard</span>
        </a>
        <?php endif; ?>

        <?php if (has_access('rearing', $user_role)): ?>
        <a href="rearing.php"
            class="nav-btn w-full flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition text-left <?php echo $current_page == 'rearing.php' ? 'bg-gray-800' : ''; ?>"
            data-page="rearing">
            <i data-lucide="clipboard-list" class="w-5 h-5"></i>
            <span>Rearing & Production</span>
        </a>
        <?php endif; ?>

        <?php if (has_access('inventory', $user_role)): ?>
        <a href="inventory.php"
            class="nav-btn w-full flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition text-left <?php echo $current_page == 'inventory.php' ? 'bg-gray-800' : ''; ?>"
            data-page="inventory">
            <i data-lucide="package" class="w-5 h-5"></i>
            <span>Stock & Feed</span>
        </a>
        <?php endif; ?>

        <?php if (has_access('crm', $user_role)): ?>
        <a href="crm.php"
            class="nav-btn w-full flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition text-left <?php echo $current_page == 'crm.php' ? 'bg-gray-800' : ''; ?>"
            data-page="crm">
            <i data-lucide="users" class="w-5 h-5"></i>
            <span>Sales & Purchases</span>
        </a>
        <?php endif; ?>

        <?php if (has_access('crates', $user_role)): ?>
        <a href="crates.php"
            class="nav-btn w-full flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition text-left <?php echo $current_page == 'crates.php' ? 'bg-gray-800' : ''; ?>"
            data-page="crates">
            <i data-lucide="container" class="w-5 h-5"></i>
            <span>Crate Inventory</span>
        </a>
        <?php endif; ?>

        <?php if (has_access('reports', $user_role)): ?>
        <a href="reports.php"
            class="nav-btn w-full flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition text-left <?php echo $current_page == 'reports.php' ? 'bg-gray-800' : ''; ?>"
            data-page="reports">
            <i data-lucide="file-text" class="w-5 h-5"></i>
            <span>Reports</span>
        </a>
        <?php endif; ?>

        <?php if (has_access('chicks', $user_role)): ?>
        <a href="chicks.php"
            class="nav-btn w-full flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition text-left <?php echo $current_page == 'chicks.php' ? 'bg-gray-800' : ''; ?>"
            data-page="chicks">
            <i data-lucide="bird" class="w-5 h-5"></i>
            <span>Day-Old Chicks</span>
        </a>
        <?php endif; ?>

        <?php if (has_access('admin', $user_role)): ?>
        <div id="adminMenu" class="pt-4 border-t border-gray-800 mt-4">
            <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Administration</p>
            <a href="admin.php"
                class="nav-btn w-full flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition text-left <?php echo $current_page == 'admin.php' ? 'bg-gray-800' : ''; ?>"
                data-page="admin">
                <i data-lucide="shield" class="w-5 h-5"></i>
                <span>Admin Portal</span>
            </a>
        </div>
        <?php endif; ?>
    </nav>
    <div class="p-4 border-t border-gray-800">
        <div class="flex items-center gap-3 mb-4">
            <img src="https://static.photos/people/200x200/42" alt="User"
                class="w-10 h-10 rounded-full bg-gray-700">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium truncate" id="userNameDisplay"><?php echo htmlspecialchars($user_name); ?></p>
                <p class="text-xs text-gray-400 capitalize truncate" id="userRoleDisplay"><?php echo htmlspecialchars(str_replace('_', ' ', $user_role)); ?></p>
            </div>
        </div>
        <button onclick="logout()"
            class="w-full flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-800 transition text-red-400">
            <i data-lucide="log-out" class="w-4 h-4"></i>
            <span>Logout</span>
        </button>
    </div>
</aside>

<!-- Mobile Header -->
<div class="md:hidden bg-gray-900 text-white p-4 flex items-center justify-between">
    <div class="flex items-center gap-2">
        <i data-lucide="egg" class="w-6 h-6 text-green-500"></i>
        <span class="font-bold">Dove Haven</span>
    </div>
    <button onclick="toggleMobileMenu()" class="p-2">
        <i data-lucide="menu" class="w-6 h-6"></i>
    </button>
</div>

<!-- Mobile Menu -->
<div id="mobileMenu" class="hidden md:hidden bg-gray-800 text-white p-4 space-y-2">
    <?php if (has_access('dashboard', $user_role)): ?>
    <a href="dashboard.php"
        class="w-full block px-4 py-3 rounded-lg hover:bg-gray-700 <?php echo $current_page == 'dashboard.php' ? 'bg-gray-700' : ''; ?>">Dashboard</a>
    <?php endif; ?>
    
    <?php if (has_access('rearing', $user_role)): ?>
    <a href="rearing.php"
        class="w-full block px-4 py-3 rounded-lg hover:bg-gray-700 <?php echo $current_page == 'rearing.php' ? 'bg-gray-700' : ''; ?>">Egg Collection</a>
    <?php endif; ?>

    <?php if (has_access('inventory', $user_role)): ?>
    <a href="inventory.php"
        class="w-full block px-4 py-3 rounded-lg hover:bg-gray-700 <?php echo $current_page == 'inventory.php' ? 'bg-gray-700' : ''; ?>">Stock & Feed</a>
    <?php endif; ?>

    <?php if (has_access('crm', $user_role)): ?>
    <a href="crm.php"
        class="w-full block px-4 py-3 rounded-lg hover:bg-gray-700 <?php echo $current_page == 'crm.php' ? 'bg-gray-700' : ''; ?>">Sales & Payments</a>
    <?php endif; ?>

    <?php if (has_access('crates', $user_role)): ?>
    <a href="crates.php"
        class="w-full block px-4 py-3 rounded-lg hover:bg-gray-700 <?php echo $current_page == 'crates.php' ? 'bg-gray-700' : ''; ?>">Crate Inventory</a>
    <?php endif; ?>

    <?php if (has_access('reports', $user_role)): ?>
    <a href="reports.php"
        class="w-full block px-4 py-3 rounded-lg hover:bg-gray-700 <?php echo $current_page == 'reports.php' ? 'bg-gray-700' : ''; ?>">Reports</a>
    <?php endif; ?>

    <?php if (has_access('chicks', $user_role)): ?>
    <a href="chicks.php"
        class="w-full block px-4 py-3 rounded-lg hover:bg-gray-700 <?php echo $current_page == 'chicks.php' ? 'bg-gray-700' : ''; ?>">Day-Old Chicks</a>
    <?php endif; ?>

    <?php if (has_access('admin', $user_role)): ?>
    <a href="admin.php" id="mobileAdminBtn"
        class="w-full block px-4 py-3 rounded-lg hover:bg-gray-700 <?php echo $current_page == 'admin.php' ? 'bg-gray-700' : ''; ?>">Admin Portal</a>
    <?php endif; ?>

    <button onclick="logout()"
        class="w-full flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 text-red-400">Logout</button>
</div>
