// Dove Haven Farms - Management Portal JavaScript

// Global State
let currentUser = null;
let currentPage = 'dashboard';
let productionData = [];
let inventory = [];
let customers = [];
let orders = [];
let employees = [];
let crateStock = 150;
let crateMovements = [];
let excessData = [];
let growthData = [];
let mortalityData = [];
let inventoryTransactions = [];
let purchases = [];
let productionChartInstance = null;
let houseChartInstance = null;
let growthChartInstance = null;
let mortalityChartInstance = null;
let layingChartInstance = null;
const EGGS_PER_CRATE = 30;

// Demo Data Initialization
async function initializeDemoData() {
    try {
        const response = await fetchWithAuth('./api/get_all_data.php');
        const data = await response.json();
        employees = data.employees || [];
        productionData = data.production || [];
        inventory = data.inventory || [];
        customers = data.customers || [];
        orders = data.orders || [];
        crateMovements = data.crateMovements || [];
        inventoryTransactions = data.inventoryTransactions || [];
        growthData = data.growthData || [];
        mortalityData = data.mortalityData || [];
        purchases = data.purchases || [];
    } catch (e) {
        console.error("Backend data fetch failed", e);
        showAlert("Cannot connect to database. Please check your PHP server.", "error");
    }
}

// Alert System
function showAlert(message, type = 'success') {
    const container = document.getElementById('alertsContainer');
    if (!container) return;

    const alert = document.createElement('div');
    const colors = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        warning: 'bg-yellow-500',
        info: 'bg-blue-500'
    };
    const icons = {
        success: 'check-circle',
        error: 'alert-circle',
        warning: 'alert-triangle',
        info: 'info'
    };

    alert.className = `${colors[type]} text-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3 alert-enter`;
    alert.innerHTML = `
        <i data-lucide="${icons[type]}" class="w-5 h-5"></i>
        <span>${message}</span>
    `;
    container.appendChild(alert);

    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    setTimeout(() => {
        alert.classList.remove('alert-enter');
        alert.classList.add('alert-exit');
        setTimeout(() => alert.remove(), 300);
    }, 3000);
}


// Authentication
function initLogin() {
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            try {
                const response = await fetch('./api/login.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email, password })
                });
                const result = await response.json();
                if (result.success) {
                    localStorage.setItem('access_token', result.access_token);
                    localStorage.setItem('refresh_token', result.refresh_token);
                    currentUser = result.user;
                    await loginSuccess();
                } else {
                    showAlert(result.message || 'Invalid credentials.', 'error');
                }
            } catch (error) {
                console.error("Backend login failed", error);
                showAlert('Server connection error.', 'error');
            }
        });
    }
}


async function loginSuccess() {
    window.location.href = 'dashboard.php';
}

function logout() {
    const refreshToken = localStorage.getItem('refresh_token');
    if (refreshToken) {
        fetch('./api/logout.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ refresh_token: refreshToken })
        }).finally(() => {
            localStorage.removeItem('access_token');
            localStorage.removeItem('refresh_token');
            currentUser = null;
            window.location.href = 'login.php';
        });
    } else {
        window.location.href = 'login.php';
    }
}

// Global Auth Fetch Wrapper
async function fetchWithAuth(url, options = {}) {
    let accessToken = localStorage.getItem('access_token');
    
    if (!options.headers) options.headers = {};
    if (accessToken) {
        options.headers['Authorization'] = `Bearer ${accessToken}`;
    }

    let response = await fetch(url, options);

    // If unauthorized, attempt to refresh token
    if (response.status === 401) {
        const refreshToken = localStorage.getItem('refresh_token');
        if (refreshToken) {
            const refreshRes = await fetch('./auth/refresh.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ refresh_token: refreshToken })
            });
            const refreshData = await refreshRes.json();
            if (refreshData.success) {
                localStorage.setItem('access_token', refreshData.access_token);
                options.headers['Authorization'] = `Bearer ${refreshData.access_token}`;
                response = await fetch(url, options); // Retry original request
            } else {
                logout(); // Refresh failed
            }
        } else {
            logout(); // No refresh token
        }
    }
    return response;
}

// Navigation
function navigateTo(page) {
    document.querySelectorAll('.page-content').forEach(el => el.classList.add('hidden'));
    const pageEl = document.getElementById(`page-${page}`);
    if (pageEl) {
        pageEl.classList.remove('hidden');
    }

    document.querySelectorAll('.nav-btn').forEach(btn => {
        if (btn.dataset.page === page) {
            btn.classList.add('bg-gray-800');
        } else {
            btn.classList.remove('bg-gray-800');
        }
    });

    currentPage = page;

    switch (page) {
        case 'dashboard':
            loadDashboard();
            break;
        case 'rearing':
            loadRearingPage();
            break;
        case 'inventory':
            loadInventory();
            break;
        case 'crm':
            loadCRM();
            break;
        case 'crates':
            loadCrates();
            break;
        case 'admin':
            loadAdmin();
            break;
    }

    const mobileMenu = document.getElementById('mobileMenu');
    if (mobileMenu) mobileMenu.classList.add('hidden');

    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
}

function toggleMobileMenu() {
    const menu = document.getElementById('mobileMenu');
    if (menu) menu.classList.toggle('hidden');
}

// Modal Functions
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) modal.classList.remove('hidden');
    if (typeof lucide !== 'undefined') lucide.createIcons();
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) modal.classList.add('hidden');
}



// Show Recent Collections
function showRecentCollections() {
    const table = document.getElementById('recentProductionTable');
    if (table) {
        table.innerHTML = '';

        console.log(productionData);


        productionData.reverse().slice(0, 5).forEach(p => {
            const row = document.createElement('tr');
            row.className = 'bg-white border-b hover:bg-gray-50';
            const employee = employees.find(e => e.id === p.employee_id);

            row.innerHTML = `
                <td class="px-4 py-3">${p.date}</td>
                <td class="px-4 py-3">${p.house_id}</td>
                <td class="px-4 py-3">${p.crates}</td>
                <td class="px-4 py-3">${p.loose_eggs}</td>
                <td class="px-4 py-3 font-semibold">${p.total_eggs}</td>
                <td class="px-4 py-3 font-bold">${employee.name}</td>
            `;
            table.appendChild(row);
        });
    }
}



function showHouseDetail(houseId) {
    const section = document.getElementById('houseDetailSection');
    if (!section) return;
    section.classList.remove('hidden');

    const nameEl = document.getElementById('selectedHouseName');
    if (nameEl) nameEl.textContent = houseId.toUpperCase();

    // Get data for this house
    const houseProduction = productionData.filter(p => p.house_id === houseId);
    const houseGrowth = growthData.filter(g => g.houseId === houseId);
    const houseMortality = mortalityData.filter(m => m.houseId === houseId);

    // Populate summary cards
    const latestGrowth = houseGrowth[houseGrowth.length - 1];
    const totalBirds = latestGrowth ? latestGrowth.birdCount : 500;
    const totalDeaths = houseMortality.reduce((sum, m) => sum + m.deaths, 0);
    const mortalityRate = totalBirds > 0 ? ((totalDeaths / (totalBirds + totalDeaths)) * 100).toFixed(1) : '0.0';
    const avgProduction = houseProduction.length > 0 ? Math.round(houseProduction.reduce((sum, p) => sum + p.totalEggs, 0) / houseProduction.length) : 0;
    const avgFeed = houseProduction.length > 0 ? (houseProduction.reduce((sum, p) => sum + p.feed, 0) / houseProduction.reduce((sum, p) => sum + p.totalEggs, 0) || 0).toFixed(2) : '0.00';

    const totalBirdsEl = document.getElementById('flockTotalBirds');
    const mortalityRateEl = document.getElementById('flockMortalityRate');
    const totalLossesEl = document.getElementById('flockTotalLosses');
    const avgProdEl = document.getElementById('flockAvgProduction');
    const feedConvEl = document.getElementById('flockFeedConversion');
    if (totalBirdsEl) totalBirdsEl.textContent = totalBirds.toLocaleString();
    if (mortalityRateEl) mortalityRateEl.textContent = mortalityRate + '%';
    if (totalLossesEl) totalLossesEl.textContent = totalDeaths;
    if (avgProdEl) avgProdEl.textContent = avgProduction;
    if (feedConvEl) feedConvEl.textContent = avgFeed;

    // Render Growth Chart
    renderGrowthChart(houseGrowth, houseId);
    // Render Mortality Chart
    renderMortalityChart(houseMortality, houseId);
    // Render Laying Performance Chart
    renderLayingChart(houseProduction, totalBirds);
    // Render Benchmark Section
    renderBenchmark(houseProduction, totalBirds);

    // Populate production history table
    const table = document.getElementById('houseProductionTable');
    if (table) {
        table.innerHTML = '';
        // console.log(houseProduction);

        houseProduction.slice().reverse().forEach(p => {
            const row = document.createElement('tr');
            row.className = 'bg-white border-b hover:bg-gray-50';
            row.innerHTML = `
                <td class="px-4 py-3">${p.date}</td>
                <td class="px-4 py-3">${p.grades?.large || 0}</td>
                <td class="px-4 py-3">${p.grades?.medium || 0}</td>
                <td class="px-4 py-3">${p.grades?.small || 0}</td>
                <td class="px-4 py-3">${p.grades?.pullet || 0}</td>
                <td class="px-4 py-3">${p.grades?.broken || 0}</td>
                <td class="px-4 py-3 font-semibold">${p.crates}</td>
                <td class="px-4 py-3 font-bold">${p.total_eggs}</td>
            `;
            table.appendChild(row);
        });
    }

    // Scroll to detail section
    section.scrollIntoView({ behavior: 'smooth' });
    if (typeof lucide !== 'undefined') lucide.createIcons();
}




// Dashboard Functions
function loadDashboard() {
    const today = new Date().toLocaleDateString('en-CA');

    const todayData = productionData.filter(p => p.date === today);
    const totalEggs = todayData.reduce((sum, p) => sum + (p.totalEggs || 0), 0);

    const todaySales = orders
        .filter(o => o.date === today)
        .reduce((sum, o) => sum + (o.paid || 0), 0);

    updateElement('todayEggs', totalEggs.toLocaleString());
    updateElement('todayCrates', crateStock);
    updateElement('todaySales', `GH₵${todaySales.toFixed(0)}`);

    initCharts();
    showRecentCollections();
}

function updateElement(id, value) {
    const el = document.getElementById(id);
    if (el) el.textContent = value;
}

function initCharts() {
    if (productionChartInstance) productionChartInstance.destroy();

    const ctx1 = document.getElementById('productionChart');
    if (ctx1) {
        const dates = [...new Set(productionData.map(p => p.date))];
        const dailyTotals = dates.map(date => {
            return productionData.filter(p => p.date === date).reduce((sum, p) => sum + p.totalEggs, 0);
        });

        productionChartInstance = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Total Eggs',
                    data: dailyTotals,
                    borderColor: '#16a34a',
                    backgroundColor: 'rgba(22, 163, 74, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });
    }
}


function refreshDashboard() {
    showAlert('Dashboard refreshed!', 'success');
    loadDashboard();
}

// Toggle functions
function toggleMedicationFields() {
    const waterType = document.getElementById('waterTypeSelect')?.value;
    const medFields = document.getElementById('medicationFields');
    if (medFields) {
        medFields.classList.toggle('hidden', waterType !== 'medication');
    }
}

function toggleGrowthMedicationFields() {
    const waterType = document.getElementById('growthWaterTypeSelect')?.value;
    const medFields = document.getElementById('growthMedicationFields');
    if (medFields) {
        medFields.classList.toggle('hidden', waterType !== 'medication');
    }
}

function toggleBagSizeField() {
    const unit = document.getElementById('inventoryUnitSelect')?.value;
    const bagField = document.getElementById('bagSizeField');
    if (bagField) {
        bagField.classList.toggle('hidden', unit !== 'bags');
    }
}

// Order functions
function addOrderItem() {
    const container = document.getElementById('orderItemsContainer');
    if (!container) return;

    const rowCount = container.querySelectorAll('.order-item-row').length;
    if (rowCount >= 5) {
        showAlert('Maximum 5 products per order', 'warning');
        return;
    }

    const newRow = document.createElement('div');
    newRow.className = 'grid grid-cols-12 gap-2 items-end order-item-row';
    newRow.innerHTML = `
        <div class="col-span-4">
            <label class="block text-xs font-medium text-gray-600 mb-1">Product</label>
            <select name="product[]" class="product-select w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none text-sm" oninput="calculateOrderTotal()">
                <option value="">Select Product</option>
                <option value="eggs_tray_large" data-price="12">Large Eggs (Tray)</option>
                <option value="eggs_tray_medium" data-price="11">Medium Eggs (Tray)</option>
                <option value="eggs_tray_small" data-price="10">Small Eggs (Tray)</option>
                <option value="live_bird" data-price="15">Live Bird</option>
                <option value="manure" data-price="5">Manure (Bag)</option>
            </select>
        </div>
        <div class="col-span-3">
            <label class="block text-xs font-medium text-gray-600 mb-1">Qty</label>
            <input type="number" name="quantity[]" min="0" value="0" class="quantity-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none text-sm" oninput="calculateOrderTotal()">
        </div>
        <div class="col-span-3">
            <label class="block text-xs font-medium text-gray-600 mb-1">Unit Price (GH₵)</label>
            <input type="number" name="unitPrice[]" min="0" step="0.01" value="0" class="unit-price-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none text-sm" oninput="calculateOrderTotal()">
        </div>
        <div class="col-span-2">
            <button type="button" onclick="removeOrderItem(this)" class="w-full px-3 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition text-sm">
                <i data-lucide="trash-2" class="w-4 h-4 mx-auto"></i>
            </button>
        </div>
    `;
    container.appendChild(newRow);
    if (typeof lucide !== 'undefined') lucide.createIcons();
}

function removeOrderItem(btn) {
    const container = document.getElementById('orderItemsContainer');
    const rows = container.querySelectorAll('.order-item-row');
    if (rows.length > 1) {
        btn.closest('.order-item-row').remove();
        calculateOrderTotal();
    } else {
        showAlert('You must have at least one product line', 'warning');
    }
}

function calculateOrderTotal() {
    let subtotal = 0;
    let totalCrates = 0;

    // Calculate egg grade rows
    const eggRows = document.querySelectorAll('.egg-grade-row');
    eggRows.forEach(row => {
        const qtyInput = row.querySelector('.egg-qty');
        const priceInput = row.querySelector('.egg-price');
        const subtotalSpan = row.querySelector('.egg-subtotal');
        const qty = parseFloat(qtyInput?.value) || 0;
        const price = parseFloat(priceInput?.value) || 0;
        const lineTotal = qty * price;
        subtotal += lineTotal;
        totalCrates += qty;
        if (subtotalSpan) subtotalSpan.textContent = 'GH₵' + lineTotal.toFixed(2);
    });

    // Calculate other product rows
    const rows = document.querySelectorAll('.order-item-row');
    rows.forEach(row => {
        const productSelect = row.querySelector('.product-select');
        const quantityInput = row.querySelector('.quantity-input');
        const unitPriceInput = row.querySelector('.unit-price-input');

        if (productSelect && quantityInput && unitPriceInput) {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            if (selectedOption && selectedOption.dataset.price && parseFloat(unitPriceInput.value) === 0) {
                unitPriceInput.value = selectedOption.dataset.price;
            }
            const qty = parseFloat(quantityInput.value) || 0;
            const price = parseFloat(unitPriceInput.value) || 0;
            subtotal += qty * price;
        }
    });

    const subtotalEl = document.getElementById('orderSubtotal');
    const totalItemsEl = document.getElementById('orderTotalItems');
    const displayTotalEl = document.getElementById('displayOrderTotal');

    if (subtotalEl) subtotalEl.textContent = 'GH₵' + subtotal.toFixed(2);
    if (totalItemsEl) totalItemsEl.textContent = totalCrates + ' crates';
    if (displayTotalEl) displayTotalEl.textContent = 'GH₵' + subtotal.toFixed(2);

    updateOrderBalance();
}

function updateOrderBalance() {
    const subtotalEl = document.getElementById('orderSubtotal');
    const paidInput = document.getElementById('orderAmountPaid');
    const displayPaidEl = document.getElementById('displayOrderPaid');
    const displayBalanceEl = document.getElementById('displayOrderBalance');

    const subtotalText = subtotalEl?.textContent || 'GH₵0.00';
    const subtotal = parseFloat(subtotalText.replace('GH₵', '')) || 0;
    const paid = parseFloat(paidInput?.value) || 0;
    const balance = Math.max(0, subtotal - paid);

    if (displayPaidEl) displayPaidEl.textContent = 'GH₵' + paid.toFixed(2);
    if (displayBalanceEl) displayBalanceEl.textContent = 'GH₵' + balance.toFixed(2);
}

// Inventory Functions
function loadInventory() {
    const grid = document.getElementById('ingredientsGrid');
    const alerts = document.getElementById('inventoryAlerts');

    if (grid) {
        grid.innerHTML = '';
        inventory.forEach(item => {
            const div = document.createElement('div');
            div.className = 'bg-white p-6 rounded-xl shadow-sm border border-gray-200';
            const percentRemaining = (item.quantity / item.purchased) * 100;
            const statusColor = percentRemaining < 20 ? 'text-red-600' : (percentRemaining < 40 ? 'text-yellow-600' : 'text-green-600');

            div.innerHTML = `
                <div class="flex items-center justify-between mb-4">
                    <h4 class="font-semibold text-lg">${item.name}</h4>
                    <span class="text-xs px-2 py-1 rounded-full ${percentRemaining < 20 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'}">
                        ${percentRemaining.toFixed(0)}% left
                    </span>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Current Stock:</span>
                        <span class="font-semibold ${statusColor}">${item.quantity.toLocaleString()} kg</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Total Purchased:</span>
                        <span class="text-gray-800">${item.purchased.toLocaleString()} kg</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Total Used:</span>
                        <span class="text-gray-800">${item.used.toLocaleString()} kg</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-3">
                        <div class="${percentRemaining < 20 ? 'bg-red-500' : (percentRemaining < 40 ? 'bg-yellow-500' : 'bg-green-600')} h-2 rounded-full" style="width: ${Math.min(percentRemaining, 100)}%"></div>
                    </div>
                </div>
            `;
            grid.appendChild(div);
        });
    }

    if (alerts) {
        alerts.innerHTML = '';
        const lowStock = inventory.filter(item => (item.quantity / item.purchased) < 0.2);
        if (lowStock.length > 0) {
            lowStock.forEach(item => {
                const alert = document.createElement('div');
                alert.className = 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded flex items-center gap-2';
                alert.innerHTML = `
                    <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                    <span><strong>Low Stock:</strong> ${item.name} - ${item.quantity} kg remaining</span>
                `;
                alerts.appendChild(alert);
            });
        }
    }

    // Load transaction history
    const historyTable = document.getElementById('inventoryHistoryTable');
    if (historyTable) {
        historyTable.innerHTML = '';
        inventoryTransactions.slice().reverse().forEach(t => {
            const item = inventory.find(i => i.id === t.ingredient);
            const row = document.createElement('tr');
            row.className = 'bg-white border-b hover:bg-gray-50';
            row.innerHTML = `
                <td class="px-4 py-3">${t.date}</td>
                <td class="px-4 py-3 font-medium">${item?.name || t.ingredient}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded-full text-xs ${t.type === 'purchase' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800'}">
                        ${t.type === 'purchase' ? 'Purchase' : 'Usage'}
                    </span>
                </td>
                <td class="px-4 py-3 font-medium 
                    ${t.type === 'purchase' ? 'text-green-600' : 'text-red-600'}">
                    ${t.type === 'purchase' ? '+' : '-'} ${t.quantity} kg
                </td>
                <td class="px-4 py-3">${item.quantity} kg</td>
                <td class="px-4 py-3 text-sm text-gray-600">${t.notes}</td>
            `;
            historyTable.appendChild(row);
        });
    }

    if (typeof lucide !== 'undefined') lucide.createIcons();
}

function openInventoryModal() {
    const dateInput = document.querySelector('#inventoryForm [name="purchaseDate"]');
    if (dateInput) dateInput.value = new Date().toISOString().split('T')[0];
    openModal('inventoryModal');
}

function openIngredientUsageModal() {
    const dateInput = document.getElementById('usageDateInput');
    if (dateInput) dateInput.value = new Date().toISOString().split('T')[0];

    const ingredientSelect = document.getElementById('usageIngredientSelect');
    if (ingredientSelect) {
        ingredientSelect.innerHTML = '<option value="">Select Ingredient</option>';
        inventory.forEach(item => {
            ingredientSelect.innerHTML += `<option value="${item.id}">${item.name} (${item.quantity} kg available)</option>`;
        });
    }
    openModal('ingredientUsageModal');
}

// Rearing Page
function loadRearingPage() {
    const grid = document.getElementById('houseUnitsGrid');
    if (!grid) return;

    grid.innerHTML = '';
    const houseUnits = ['house1a', 'house1b', 'house1c', 'house2a', 'house2b', 'house2c'];

    houseUnits.forEach(house => {

        const houseData = productionData.filter(p => p.houseId === house);
        const latestData = houseData[houseData.length - 1];

        const div = document.createElement('div');
        div.className = 'bg-white p-4 rounded-xl shadow-sm border border-gray-200 cursor-pointer hover:shadow-md transition';
        div.onclick = () => showHouseDetail(house);

        div.innerHTML = `
            <div class="flex justify-between items-start mb-3">
                <h3 class="font-bold text-lg text-gray-900">${house.toUpperCase()}</h3>
                <span class="text-xs px-2 py-1 rounded-full ${latestData ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600'}">
                    ${latestData ? 'Active' : 'No Data'}
                </span>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Latest Production:</span>
                    <span class="font-semibold">${latestData ? latestData.totalEggs + ' eggs' : 'N/A'}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Crates:</span>
                    <span class="font-semibold text-green-600">${latestData ? latestData.crates : '0'}</span>
                </div>
            </div>
        `;
        grid.appendChild(div);
    });
}












function showHouseDetail(houseId) {
    const section = document.getElementById('houseDetailSection');
    if (!section) return;
    section.classList.remove('hidden');

    const nameEl = document.getElementById('selectedHouseName');
    if (nameEl) nameEl.textContent = houseId.toUpperCase();

    // Get data for this house
    const houseProduction = productionData.filter(p => p.house_id === houseId);
    const houseGrowth = growthData.filter(g => g.houseId === houseId);
    const houseMortality = mortalityData.filter(m => m.houseId === houseId);

    // Populate summary cards
    const latestGrowth = houseGrowth[houseGrowth.length - 1];
    const totalBirds = latestGrowth ? latestGrowth.birdCount : 500;
    const totalDeaths = houseMortality.reduce((sum, m) => sum + m.deaths, 0);
    const mortalityRate = totalBirds > 0 ? ((totalDeaths / (totalBirds + totalDeaths)) * 100).toFixed(1) : '0.0';
    const avgProduction = houseProduction.length > 0 ? Math.round(houseProduction.reduce((sum, p) => sum + p.totalEggs, 0) / houseProduction.length) : 0;
    const avgFeed = houseProduction.length > 0 ? (houseProduction.reduce((sum, p) => sum + p.feed, 0) / houseProduction.reduce((sum, p) => sum + p.totalEggs, 0) || 0).toFixed(2) : '0.00';

    const totalBirdsEl = document.getElementById('flockTotalBirds');
    const mortalityRateEl = document.getElementById('flockMortalityRate');
    const totalLossesEl = document.getElementById('flockTotalLosses');
    const avgProdEl = document.getElementById('flockAvgProduction');
    const feedConvEl = document.getElementById('flockFeedConversion');
    if (totalBirdsEl) totalBirdsEl.textContent = totalBirds.toLocaleString();
    if (mortalityRateEl) mortalityRateEl.textContent = mortalityRate + '%';
    if (totalLossesEl) totalLossesEl.textContent = totalDeaths;
    if (avgProdEl) avgProdEl.textContent = avgProduction;
    if (feedConvEl) feedConvEl.textContent = avgFeed;

    // Render Growth Chart
    renderGrowthChart(houseGrowth, houseId);
    // Render Mortality Chart
    renderMortalityChart(houseMortality, houseId);
    // Render Laying Performance Chart
    renderLayingChart(houseProduction, totalBirds);
    // Render Benchmark Section
    renderBenchmark(houseProduction, totalBirds);

    // Populate production history table
    const table = document.getElementById('houseProductionTable');
    if (table) {
        table.innerHTML = '';
        // console.log(houseProduction);

        houseProduction.slice().reverse().forEach(p => {
            const row = document.createElement('tr');
            row.className = 'bg-white border-b hover:bg-gray-50';
            row.innerHTML = `
                <td class="px-4 py-3">${p.date}</td>
                <td class="px-4 py-3">${p.grades?.large || 0}</td>
                <td class="px-4 py-3">${p.grades?.medium || 0}</td>
                <td class="px-4 py-3">${p.grades?.small || 0}</td>
                <td class="px-4 py-3">${p.grades?.pullet || 0}</td>
                <td class="px-4 py-3">${p.grades?.broken || 0}</td>
                <td class="px-4 py-3 font-semibold">${p.crates}</td>
                <td class="px-4 py-3 font-bold">${p.total_eggs}</td>
            `;
            table.appendChild(row);
        });
    }

    // Scroll to detail section
    section.scrollIntoView({ behavior: 'smooth' });
    if (typeof lucide !== 'undefined') lucide.createIcons();
}












function closeHouseDetail() {
    const section = document.getElementById('houseDetailSection');
    if (section) section.classList.add('hidden');
}

function renderGrowthChart(data, houseId) {
    if (growthChartInstance) growthChartInstance.destroy();
    const ctx = document.getElementById('growthChart');
    if (!ctx) return;

    // Use real data or generate sample data
    let labels, weights;
    if (data.length > 0) {
        labels = data.map(d => 'Week ' + d.flockAgeWeeks);
        weights = data.map(d => d.avgWeight);
    } else {
        // Sample growth curve for layers
        labels = ['Week 4', 'Week 8', 'Week 12', 'Week 16', 'Week 20', 'Week 24', 'Week 28'];
        weights = [250, 550, 900, 1250, 1500, 1700, 1800];
    }

    growthChartInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Avg Weight (g)',
                data: weights,
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#3b82f6'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: true } },
            scales: { y: { beginAtZero: true, title: { display: true, text: 'Weight (grams)' } } }
        }
    });
}

function renderMortalityChart(data, houseId) {
    if (mortalityChartInstance) mortalityChartInstance.destroy();
    const ctx = document.getElementById('mortalityChart');
    if (!ctx) return;

    let labels, deaths;
    if (data.length > 0) {
        labels = data.map(d => d.date);
        deaths = data.map(d => d.deaths);
    } else {
        // Sample mortality data
        const today = new Date();
        labels = [];
        deaths = [];
        for (let i = 6; i >= 0; i--) {
            const d = new Date(today);
            d.setDate(d.getDate() - i);
            labels.push(d.toISOString().split('T')[0]);
            deaths.push(Math.floor(Math.random() * 3));
        }
    }

    mortalityChartInstance = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Deaths',
                data: deaths,
                backgroundColor: 'rgba(239, 68, 68, 0.7)',
                borderColor: '#ef4444',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: true } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 }, title: { display: true, text: 'Number of Deaths' } } }
        }
    });
}

function renderLayingChart(data, totalBirds) {
    if (layingChartInstance) layingChartInstance.destroy();
    const ctx = document.getElementById('layingChart');
    if (!ctx) return;

    let labels, henDay;
    if (data.length > 0 && totalBirds > 0) {
        labels = data.map(d => d.date);
        henDay = data.map(d => ((d.totalEggs / totalBirds) * 100).toFixed(1));
    } else {
        // Sample laying performance
        const today = new Date();
        labels = [];
        henDay = [];
        for (let i = 6; i >= 0; i--) {
            const d = new Date(today);
            d.setDate(d.getDate() - i);
            labels.push(d.toISOString().split('T')[0]);
            henDay.push((70 + Math.random() * 15).toFixed(1));
        }
    }

    layingChartInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: '% Hen Day Production',
                data: henDay,
                borderColor: '#16a34a',
                backgroundColor: 'rgba(22, 163, 74, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#16a34a'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: true } },
            scales: { y: { min: 0, max: 100, title: { display: true, text: '% Hen Day' } } }
        }
    });
}

function renderBenchmark(data, totalBirds) {
    const section = document.getElementById('benchmarkSection');
    if (!section) return;

    const avgEggs = data.length > 0 ? Math.round(data.reduce((s, p) => s + p.totalEggs, 0) / data.length) : 0;
    const henDayPct = totalBirds > 0 && data.length > 0 ? ((avgEggs / totalBirds) * 100).toFixed(1) : 0;
    const targetHenDay = 80;
    const performancePct = Math.min(100, (henDayPct / targetHenDay * 100)).toFixed(0);

    section.innerHTML = `
        <div class="space-y-4">
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600">Hen Day Production</span>
                    <span class="font-semibold">${henDayPct}% / ${targetHenDay}% target</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-green-600 h-3 rounded-full" style="width: ${performancePct}%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600">Avg Daily Eggs</span>
                    <span class="font-semibold">${avgEggs} eggs</span>
                </div>
            </div>
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600">Feed Efficiency</span>
                    <span class="font-semibold">${data.length > 0 ? (data.reduce((s, p) => s + p.feed, 0) / data.reduce((s, p) => s + p.totalEggs, 0) || 0).toFixed(3) : '0.000'} kg/egg</span>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">Benchmarks based on industry standards for layer operations.</p>
        </div>
    `;
}

function openGrowthModal() {
    console.log('Growth');

    const dateInput = document.querySelector('#growthForm [name="growthDate"]');
    if (dateInput) dateInput.value = new Date().toISOString().split('T')[0];

    const houseSelect = document.getElementById('growthHouseSelect');
    if (houseSelect) {
        houseSelect.innerHTML = '<option value="">Select House Unit</option>';
        const houseUnits = ['house1a', 'house1b', 'house1c', 'house2a', 'house2b', 'house2c'];
        houseUnits.forEach(h => {
            houseSelect.innerHTML += `<option value="${h}">${h.toUpperCase()}</option>`;
        });
    }
    openModal('growthModal');
}

function openMortalityModal() {
    const dateInput = document.querySelector('#mortalityForm [name="mortalityDate"]');
    if (dateInput) dateInput.value = new Date().toISOString().split('T')[0];

    const houseSelect = document.getElementById('mortalityHouseSelect');
    if (houseSelect) {
        houseSelect.innerHTML = '<option value="">Select House Unit</option>';
        const houseUnits = ['house1a', 'house1b', 'house1c', 'house2a', 'house2b', 'house2c'];
        houseUnits.forEach(h => {
            houseSelect.innerHTML += `<option value="${h}">${h.toUpperCase()}</option>`;
        });
    }
    openModal('mortalityModal');
}

function openProductionModal() {
    const dateInput = document.querySelector('#productionForm [name="date"]');
    if (dateInput) dateInput.value = new Date().toISOString().split('T')[0];

    const houseSelect = document.getElementById('productionHouseSelect');
    if (houseSelect) {
        houseSelect.innerHTML = '<option value="">Select House Unit</option>';
        const houseUnits = ['house1a', 'house1b', 'house1c', 'house2a', 'house2b', 'house2c'];
        houseUnits.forEach(h => {
            houseSelect.innerHTML += `<option value="${h}">${h.toUpperCase()}</option>`;
        });
    }
    openModal('productionModal');
}

function calculateGradesTotal() {
    const large = parseInt(document.getElementById('largeEggsInput')?.value) || 0;
    const medium = parseInt(document.getElementById('mediumEggsInput')?.value) || 0;
    const small = parseInt(document.getElementById('smallEggsInput')?.value) || 0;
    const pullet = parseInt(document.getElementById('pulletEggsInput')?.value) || 0;
    const broken = parseInt(document.getElementById('brokenEggsInput')?.value) || 0;

    const total = large + medium + small + pullet + broken;
    const crates = Math.floor(total / EGGS_PER_CRATE);
    const loose = total % EGGS_PER_CRATE;

    const totalDisplay = document.getElementById('totalEggDisplay');
    const crateInput = document.getElementById('crateInput');
    const looseInput = document.getElementById('looseEggInput');

    if (totalDisplay) totalDisplay.value = total;
    if (crateInput) crateInput.value = crates;
    if (looseInput) looseInput.value = loose;
}

// Called when user manually edits the crates field
function calculateFromCrates() {
    const crateInput = document.getElementById('crateInput');
    const looseInput = document.getElementById('looseEggInput');
    const totalDisplay = document.getElementById('totalEggDisplay');

    const crates = parseInt(crateInput?.value) || 0;
    const loose = parseInt(looseInput?.value) || 0;
    const total = (crates * EGGS_PER_CRATE) + loose;

    if (totalDisplay) totalDisplay.value = total;
}

// Called when user manually edits the loose eggs field
function calculateFromLoose() {
    const crateInput = document.getElementById('crateInput');
    const looseInput = document.getElementById('looseEggInput');
    const totalDisplay = document.getElementById('totalEggDisplay');

    const crates = parseInt(crateInput?.value) || 0;
    const loose = parseInt(looseInput?.value) || 0;
    const total = (crates * EGGS_PER_CRATE) + loose;

    if (totalDisplay) totalDisplay.value = total;
}

// Crate Functions
function loadCrates() {
    const availableEl = document.getElementById('availableCrates');
    const soldEl = document.getElementById('soldCratesToday');

    if (availableEl) availableEl.textContent = crateStock;
    if (soldEl) soldEl.textContent = 0;
}

function openCrateAdjustmentModal() {
    openModal('crateAdjustmentModal');
}

// CRM Functions
function loadCRM() {
    const totalOutstanding = orders.reduce((sum, o) => sum + (parseFloat(o.balance) || 0), 0);

    const today = new Date().toISOString().split('T')[0];
    const todayOrders = orders.filter(o => o.date === today);

    const cashSales = todayOrders
        .filter(o => o.paymentMethod === 'cash')
        .reduce((sum, o) => sum + (parseFloat(o.paid) || 0), 0);

    const bankSales = todayOrders
        .filter(o => o.paymentMethod === 'bank')
        .reduce((sum, o) => sum + (parseFloat(o.paid) || 0), 0);

    const outstandingEl = document.getElementById('totalOutstanding');
    const cashEl = document.getElementById('cashSales');
    const bankEl = document.getElementById('bankSales');

    if (outstandingEl) outstandingEl.textContent = 'GH₵' + totalOutstanding.toFixed(2);
    if (cashEl) cashEl.textContent = 'GH₵' + cashSales.toFixed(2);
    if (bankEl) bankEl.textContent = 'GH₵' + bankSales.toFixed(2);

    // CUSTOMERS TABLE
    const customersBody = document.getElementById('customersTableBody');
    if (customersBody) {
        customersBody.innerHTML = '';

        customers.forEach(customer => {
            const balance = parseFloat(customer.balance) || 0;
            const totalOrders = customer.totalOrders || 0;

            const row = document.createElement('tr');
            row.className = 'bg-white border-b hover:bg-gray-50';

            const statusClass = balance > 0
                ? 'bg-yellow-100 text-yellow-800'
                : 'bg-green-100 text-green-800';

            const status = balance > 0 ? 'Has Balance' : 'Paid Up';

            row.innerHTML = `
                <td class="px-4 py-3 font-medium">${customer.name}</td>
                <td class="px-4 py-3">${customer.phone}</td>
                <td class="px-4 py-3">${totalOrders}</td>
                <td class="px-4 py-3 font-semibold ${balance > 0 ? 'text-red-600' : 'text-green-600'}">
                    GH₵${balance.toFixed(2)}
                </td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded-full text-xs ${statusClass}">
                        ${status}
                    </span>
                </td>
                <td class="px-4 py-3">
                    <button onclick="viewCustomer('${customer.id}')" class="text-blue-600 hover:text-blue-800">
                        <i data-lucide="eye" class="w-4 h-4"></i>
                    </button>
                </td>
            `;

            customersBody.appendChild(row);
        });

        if (typeof lucide !== 'undefined') lucide.createIcons();
    }

    // ORDERS TABLE
    const ordersBody = document.getElementById('ordersTableBody');
    if (ordersBody) {
        ordersBody.innerHTML = '';

        orders.forEach(order => {
            const customer = customers.find(c => c.id == order.customer_id);

            const total = parseFloat(order.total) || 0;
            const paid = parseFloat(order.paid) || 0;
            const balance = parseFloat(order.balance) || 0;

            const row = document.createElement('tr');
            row.className = 'bg-white border-b hover:bg-gray-50';

            row.innerHTML = `
                <td class="px-4 py-3 font-medium">${order.id}</td>
                <td class="px-4 py-3">${customer ? customer.name : 'Unknown'}</td>
                <td class="px-4 py-3">${order.date}</td>
                <td class="px-4 py-3">${order.quantity || 0} crates</td>
                <td class="px-4 py-3 font-semibold">GH₵${total.toFixed(2)}</td>
                <td class="px-4 py-3 text-green-600">GH₵${paid.toFixed(2)}</td>
                <td class="px-4 py-3 ${balance > 0 ? 'text-red-600' : 'text-green-600'} font-medium">
                    GH₵${balance.toFixed(2)}
                </td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded text-xs ${order.payment_method === 'cash'
                    ? 'bg-green-100 text-green-800'
                    : 'bg-blue-100 text-blue-800'
                }">
                        ${order.payment_method}
                    </span>
                </td>
                <td class="px-4 py-3 flex gap-2">
                    <button onclick="printOrderReceipt('${order.id}')" 
                        class="text-green-600 hover:text-green-800 text-sm font-medium">
                        <i data-lucide="printer" class="w-4 h-4"></i>
                    </button>

                    ${balance > 0
                    ? `<button onclick="openPaymentModal('${order.id}')" 
                            class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Pay
                        </button>`
                    : ''
                }
                </td>
            `;

            ordersBody.appendChild(row);
        });
    }
    const customerSelect = document.getElementById('orderCustomerSelect');
    if (customerSelect) {
        customerSelect.innerHTML = '<option value="">Select Customer</option>';

        customers.forEach(c => {
            customerSelect.innerHTML += `<option value="${c.id}">${c.name}</option>`;
        });
    }

    loadPurchasesTable();
}

function switchCrmTab(tab) {
    document.querySelectorAll('.crm-tab-content').forEach(el => el.classList.add('hidden'));
    const tabEl = document.getElementById(`crm-${tab}`);
    if (tabEl) tabEl.classList.remove('hidden');

    const customersTab = document.getElementById('tab-customers');
    const ordersTab = document.getElementById('tab-orders');

    if (customersTab) {
        customersTab.className = `px-6 py-3 text-sm font-medium border-b-2 ${tab === 'customers' ? 'border-green-600 text-green-600' : 'border-transparent text-gray-600'}`;
    }
    if (ordersTab) {
        ordersTab.className = `px-6 py-3 text-sm font-medium border-b-2 ${tab === 'orders' ? 'border-green-600 text-green-600' : 'border-transparent text-gray-600'}`;
    }
}

function openCustomerModal() {
    openModal('customerModal');
}

function openOrderModal() {
    // Reset egg grade rows
    document.querySelectorAll('.egg-grade-row .egg-qty').forEach(i => i.value = '0');
    document.querySelectorAll('.egg-grade-row .egg-subtotal').forEach(s => s.textContent = 'GH₵0.00');
    // Reset other product items to single row
    const container = document.getElementById('orderItemsContainer');
    if (container) {
        const firstRow = container.querySelector('.order-item-row');
        container.innerHTML = '';
        if (firstRow) {
            container.appendChild(firstRow);
            firstRow.querySelectorAll('select').forEach(s => s.value = '');
            firstRow.querySelectorAll('input').forEach(i => i.value = '0');
        }
    }
    calculateOrderTotal();
    openModal('orderModal');
}

function openPaymentModal(orderId) {
    const order = orders.find(o => o.id === orderId);
    if (!order) return;

    const orderIdInput = document.getElementById('paymentOrderId');
    const balanceDisplay = document.getElementById('currentBalanceDisplay');

    if (orderIdInput) orderIdInput.value = orderId;
    if (balanceDisplay) balanceDisplay.value = 'GH₵' + order.balance.toFixed(2);
    openModal('paymentModal');
}

function viewCustomer(id) {
    showAlert('Customer detail view coming soon!', 'info');
}

// Purchases Table
function loadPurchasesTable() {
    const tbody = document.getElementById('purchasesTableBody');
    if (!tbody) return;

    tbody.innerHTML = '';

    purchases.forEach(p => {
        const row = document.createElement('tr');
        row.className = 'bg-white border-b hover:bg-gray-50';

        const unitCost = parseFloat(p.unitCost) || 0;
        const totalCost = parseFloat(p.totalCost) || 0;

        row.innerHTML = `
            <td class="px-4 py-3">${p.date || ''}</td>
            <td class="px-4 py-3 font-medium">${p.item || ''}</td>
            <td class="px-4 py-3"><span class="px-2 py-1 rounded-full text-xs bg-gray-100">${p.category || ''}</span></td>
            <td class="px-4 py-3">${p.quantity || 0} ${p.unit || ''}</td>
            <td class="px-4 py-3">GH₵${unitCost.toFixed(2)}</td>
            <td class="px-4 py-3 font-semibold">GH₵${totalCost.toFixed(2)}</td>
            <td class="px-4 py-3">${p.supplier || ''}</td>
            <td class="px-4 py-3">
                ${p.invoiceFile
                ? `<button onclick="viewInvoice('${p.id}')" class="text-blue-600 hover:text-blue-800 text-sm" title="View Invoice">
                        <i data-lucide="file-text" class="w-4 h-4 inline"></i> ${p.invoiceFile}
                    </button>`
                : '<span class="text-gray-400 text-sm">No invoice</span>'
            }
            </td>
        `;

        tbody.appendChild(row);
    });

    if (typeof lucide !== 'undefined') lucide.createIcons();
}

function viewInvoice(purchaseId) {
    const purchase = purchases.find(p => p.id == purchaseId);

    if (purchase && purchase.invoiceData) {
        const win = window.open('', '_blank');
        if (!win) return;

        if (purchase.invoiceData.startsWith('data:application/pdf')) {
            win.document.write(`
                <iframe src="${purchase.invoiceData}" 
                    style="width:100%;height:100%;border:none"></iframe>
            `);
        } else {
            win.document.write(`
                <html>
                    <body style="margin:0;display:flex;justify-content:center;align-items:center;background:#f0f0f0">
                        <img src="${purchase.invoiceData}" style="max-width:100%;max-height:100vh">
                    </body>
                </html>
            `);
        }

        win.document.close();
    } else {
        showAlert('Invoice file not available', 'warning');
    }
}

// Receipt Generation
function generateReceipt(order, customer) {
    const receiptWindow = window.open('', '_blank', 'width=400,height=600');
    if (!receiptWindow) {
        showAlert('Please allow popups to view receipt', 'warning');
        return;
    }

    const itemNames = {
        eggs_large: 'Large Eggs (Crate)',
        eggs_medium: 'Medium Eggs (Crate)',
        eggs_small: 'Small Eggs (Crate)',
        eggs_xsmall: 'Extra Small Eggs (Crate)',
        eggs_tray_large: 'Large Eggs (Tray)',
        eggs_tray_medium: 'Medium Eggs (Tray)',
        eggs_tray_small: 'Small Eggs (Tray)',
        live_bird: 'Live Bird',
        manure: 'Manure (Bag)'
    };

    const itemRows = (order.products || []).map(p => {
        const quantity = parseFloat(p.quantity) || 0;
        const unitPrice = parseFloat(p.unitPrice) || 0;
        const amount = quantity * unitPrice;

        return `<tr>
            <td>${itemNames[p.product] || p.product}</td>
            <td style="text-align:center">${quantity}</td>
            <td style="text-align:right">GH₵${unitPrice.toFixed(2)}</td>
            <td style="text-align:right">GH₵${amount.toFixed(2)}</td>
        </tr>`;
    }).join('');

    const total = parseFloat(order.total) || 0;
    const paid = parseFloat(order.paid) || 0;
    const balance = parseFloat(order.balance) || 0;

    receiptWindow.document.write(`<!DOCTYPE html>
<html>
<head>
<title>Receipt ${order.id}</title>
<style>
body {font-family:'Courier New',monospace;padding:20px;max-width:350px;margin:0 auto;font-size:12px}
h2{text-align:center;margin:0;font-size:16px}
p.sub{text-align:center;margin:2px 0;color:#666}
hr{border:none;border-top:1px dashed #000;margin:10px 0}
table{width:100%;border-collapse:collapse}
th,td{padding:4px 2px;text-align:left;font-size:11px}
th{border-bottom:1px solid #000}
.total{font-weight:bold;font-size:13px}
.print-btn{display:block;margin:20px auto;padding:8px 24px;background:#16a34a;color:#fff;border:none;border-radius:6px;cursor:pointer;font-size:14px}
@media print{.print-btn{display:none}}
</style>
</head>
<body>
<h2>DOVE HAVEN FARMS</h2>
<p class="sub">Farm Management Portal</p>
<p class="sub">Sales Receipt</p>
<hr>
<p><strong>Receipt:</strong> ${order.id}</p>
<p><strong>Date:</strong> ${order.date || ''}</p>
<p><strong>Customer:</strong> ${customer?.name || 'Walk-in'}</p>
<p><strong>Phone:</strong> ${customer?.phone || 'N/A'}</p>
<hr>
<table>
<thead>
<tr><th>Item</th><th style="text-align:center">Qty</th><th style="text-align:right">Price</th><th style="text-align:right">Amount</th></tr>
</thead>
<tbody>${itemRows}</tbody>
</table>
<hr>
<p class="total">Total: GH₵${total.toFixed(2)}</p>
<p><strong>Paid:</strong> GH₵${paid.toFixed(2)}</p>
<p><strong>Balance:</strong> GH₵${balance.toFixed(2)}</p>
<p><strong>Payment:</strong> ${order.paymentMethod || ''}</p>
<hr>
<p style="text-align:center">Thank you for your business!</p>
<p style="text-align:center;color:#666">Dove Haven Farms</p>
<button class="print-btn" onclick="window.print()">Print Receipt</button>
</body>
</html>`);

    receiptWindow.document.close();
}

function printOrderReceipt(orderId) {
    const order = orders.find(o => o.id === orderId);
    if (!order) return;
    const customer = customers.find(c => c.id === order.customerId);
    generateReceipt(order, customer);
}

// Admin Functions
function loadAdmin() {
    const totalEl = document.getElementById('totalEmployees');
    const activeEl = document.getElementById('activeEmployees');
    const dataEl = document.getElementById('dataEntries');

    if (totalEl) totalEl.textContent = employees.length;
    if (activeEl) activeEl.textContent = employees.filter(e => e.status === 'active').length;
    if (dataEl) dataEl.textContent = productionData.length;

    const tbody = document.getElementById('employeesTableBody');
    if (tbody) {
        tbody.innerHTML = '';
        employees.forEach(emp => {
            const row = document.createElement('tr');
            row.className = 'bg-white border-b hover:bg-gray-50';
            row.innerHTML = `
                <td class="px-6 py-4 font-medium">${emp.name}</td>
                <td class="px-6 py-4 capitalize">${emp.role}</td>
                <td class="px-6 py-4">${emp.accessLevel}</td>
                <td class="px-6 py-4 text-sm">${emp.lastLogin}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded-full text-xs ${emp.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'}">
                        ${emp.status}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <button onclick="toggleEmployeeStatus(${emp.id})" class="text-gray-600 hover:text-gray-800">
                        <i data-lucide="power" class="w-4 h-4"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(row);
        });
        if (typeof lucide !== 'undefined') lucide.createIcons();
    }
}

function openEmployeeModal() {
    openModal('employeeModal');
}

function toggleEmployeeStatus(id) {
    const emp = employees.find(e => e.id === id);
    if (emp) {
        emp.status = emp.status === 'active' ? 'inactive' : 'active';
        loadAdmin();
        showAlert(`Employee ${emp.status === 'active' ? 'activated' : 'deactivated'}`, 'success');
    }
}

function openPurchaseModal() {
    const dateInput = document.querySelector('#purchaseForm [name="purchaseDate"]');
    if (dateInput) dateInput.value = new Date().toISOString().split('T')[0];
    openModal('purchaseModal');
}

// Form Handlers
function initFormHandlers() {
    // Production Form
    const productionForm = document.getElementById('productionForm');
    if (productionForm) {
        productionForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            const formData = new FormData(e.target);

            const large = parseInt(formData.get('largeEggs')) || 0;
            const medium = parseInt(formData.get('mediumEggs')) || 0;
            const small = parseInt(formData.get('smallEggs')) || 0;
            const pullet = parseInt(formData.get('pulletEggs')) || 0;
            const broken = parseInt(formData.get('brokenEggs')) || 0;
            const totalEggs = large + medium + small + pullet + broken;
            const crates = Math.floor(totalEggs / 30);
            const loose = totalEggs % 30;

            const newEntry = {
                id: Date.now(),
                date: formData.get('date'),
                houseId: formData.get('houseId'),
                crates: crates,
                looseEggs: loose,
                totalEggs: totalEggs,
                grades: { large, medium, small, pullet, broken },
                feed: parseFloat(formData.get('feed')) || 0,
                feedType: formData.get('feedType'),
                water: {
                    type: formData.get('waterType'),
                    amount: parseFloat(formData.get('waterAmount')) || 0,
                    medicationName: formData.get('medicationName') || null,
                    medicationDosage: formData.get('medicationDosage') || null,
                    nextDoseDate: formData.get('nextDoseDate') || null
                },
                comments: formData.get('comments') || '',
                employee: currentUser?.name || 'Unknown'
            };

            try {
                const res = await fetchWithAuth('./api/add_production.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(newEntry)
                });
                const responseData = await res.json();
                if (responseData.success) {
                    await initializeDemoData();
                    closeModal('productionModal');
                    e.target.reset();
                    if (document.getElementById('medicationFields')) {
                        document.getElementById('medicationFields').classList.add('hidden');
                    }
                    showAlert('Collection recorded successfully!', 'success');
                    if (currentPage === 'dashboard') loadDashboard();
                    if (currentPage === 'rearing') loadRearingPage();
                } else {
                    showAlert('Error: ' + responseData.error, 'error');
                }
            } catch (error) {
                console.error("Backend Error:", error);
                showAlert("Server connection failed.", "error");
            }
        });
    }

    // Customer Form
    const customerForm = document.getElementById('customerForm');
    if (customerForm) {
        customerForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            const formData = new FormData(e.target);
            const newCustomer = {
                id: Date.now(),
                name: formData.get('name'),
                email: formData.get('email'),
                phone: formData.get('phone'),
                address: formData.get('address'),
                balance: 0,
                totalOrders: 0
            };
            try {
                const res = await fetchWithAuth('./api/add_customer.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(newCustomer)
                });
                const responseData = await res.json();
                if (responseData.success) {
                    await initializeDemoData();
                    closeModal('customerModal');
                    e.target.reset();
                    loadCRM();
                    showAlert('Customer added successfully!', 'success');
                } else {
                    showAlert('Error: ' + responseData.error, 'error');
                }
            } catch (error) {
                console.error("Backend Error:", error);
                showAlert("Server connection failed.", "error");
            }
        });
    }

    // Order Form
    const orderForm = document.getElementById('orderForm');
    if (orderForm) {
        orderForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            const formData = new FormData(e.target);
            const customerId = parseInt(formData.get('customerId'));
            const paid = parseFloat(formData.get('amountPaid')) || 0;

            let total = 0;
            let totalCrates = 0;
            const itemDescriptions = [];
            const orderProducts = [];
            const gradeNames = { eggs_large: 'Large Eggs', eggs_medium: 'Medium Eggs', eggs_small: 'Small Eggs', eggs_xsmall: 'Extra Small Eggs' };

            // Collect egg grade items
            const eggRows = document.querySelectorAll('.egg-grade-row');
            eggRows.forEach(row => {
                const product = row.dataset.product;
                const qty = parseFloat(row.querySelector('.egg-qty')?.value) || 0;
                const price = parseFloat(row.querySelector('.egg-price')?.value) || 0;
                if (qty > 0) {
                    const lineTotal = qty * price;
                    total += lineTotal;
                    totalCrates += qty;
                    itemDescriptions.push(`${qty} Crates ${gradeNames[product] || product}`);
                    orderProducts.push({ product, quantity: qty, unitPrice: price });
                }
            });

            // Collect other product items
            const products = formData.getAll('product[]');
            const quantities = formData.getAll('quantity[]');
            const unitPrices = formData.getAll('unitPrice[]');
            for (let i = 0; i < products.length; i++) {
                if (products[i] && parseFloat(quantities[i]) > 0) {
                    const qty = parseFloat(quantities[i]) || 0;
                    const price = parseFloat(unitPrices[i]) || 0;
                    total += qty * price;
                    const productSelect = document.querySelectorAll('.product-select')[i];
                    const productName = productSelect?.options[productSelect.selectedIndex]?.textContent || products[i];
                    itemDescriptions.push(`${qty} x ${productName}`);
                    orderProducts.push({ product: products[i], quantity: qty, unitPrice: price });
                }
            }

            const newOrder = {
                id: `ORD-${String(orders.length + 1).padStart(3, '0')}`,
                customerId: customerId,
                date: new Date().toISOString().split('T')[0],
                items: itemDescriptions.join(', '),
                quantity: totalCrates,
                products: orderProducts,
                total: total,
                paid: paid,
                balance: total - paid,
                paymentMethod: formData.get('paymentMethod'),
                paymentStatus: paid >= total ? 'paid' : (paid > 0 ? 'partial' : 'pending')
            };

            if (totalCrates > 0) {
                crateStock -= totalCrates;
                crateMovements.unshift({
                    date: new Date().toLocaleString(),
                    type: 'Sale',
                    quantity: -totalCrates,
                    source: customers.find(c => c.id === customerId)?.name || 'Unknown',
                    balance: crateStock
                });
            }

            const customer = customers.find(c => c.id === customerId);
            if (customer) {
                customer.balance += (total - paid);
                customer.totalOrders += 1;
            }

            try {
                const res = await fetchWithAuth('./api/add_order.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(newOrder)
                });
                const responseData = await res.json();
                if (responseData.success) {
                    await initializeDemoData();
                    closeModal('orderModal');
                    e.target.reset();

                    // Reset order fields
                    document.querySelectorAll('.egg-grade-row .egg-qty').forEach(i => i.value = '0');
                    document.querySelectorAll('.egg-grade-row .egg-subtotal').forEach(s => s.textContent = 'GH₵0.00');
                    const container = document.getElementById('orderItemsContainer');
                    if (container) {
                        const rows = container.querySelectorAll('.order-item-row');
                        for (let i = rows.length - 1; i > 0; i--) rows[i].remove();
                        const firstRow = container.querySelector('.order-item-row');
                        if (firstRow) {
                            firstRow.querySelectorAll('select').forEach(s => s.value = '');
                            firstRow.querySelectorAll('input').forEach(i => i.value = '0');
                        }
                    }

                    loadCRM();
                    showAlert('Order created successfully!', 'success');
                    generateReceipt(newOrder, customer);
                } else {
                    showAlert('Error: ' + responseData.error, 'error');
                }
            } catch (error) {
                console.error("Backend Error:", error);
                showAlert("Server connection failed.", "error");
            }
        });
    }

    // Payment Form
    const paymentForm = document.getElementById('paymentForm');
    if (paymentForm) {
        paymentForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            const formData = new FormData(e.target);
            const data = {
                orderId: document.getElementById('paymentOrderId').value,
                amount: parseFloat(formData.get('paymentAmount')) || 0,
                paymentMethod: formData.get('paymentMethod'),
                paymentRef: formData.get('paymentRef')
            };

            try {
                const res = await fetchWithAuth('./api/add_payment.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });
                const result = await res.json();
                if (result.success) {
                    await initializeDemoData();
                    closeModal('paymentModal');
                    e.target.reset();
                    loadCRM();
                    showAlert('Payment recorded successfully!', 'success');
                } else {
                    showAlert('Error: ' + result.error, 'error');
                }
            } catch (error) {
                console.error("Backend Error:", error);
                showAlert("Server connection failed.", "error");
            }
        });
    }

    // Growth Form
    const growthForm = document.getElementById('growthForm');
    if (growthForm) {
        growthForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            const formData = new FormData(e.target);
            const newGrowth = {
                date: formData.get('growthDate'),
                houseId: formData.get('growthHouse'),
                flockId: formData.get('flockId'),
                avgWeight: parseInt(formData.get('avgWeight')) || 0,
                birdCount: parseInt(formData.get('birdCount')) || 0,
                flockAgeWeeks: parseInt(formData.get('flockAge')) || 0,
                water: {
                    type: formData.get('growthWaterType'),
                    amount: parseFloat(formData.get('growthWaterAmount')) || 0,
                    medicationName: formData.get('growthMedicationName') || null,
                    medicationDosage: formData.get('growthMedicationDosage') || null,
                    nextDoseDate: formData.get('growthNextDoseDate') || null
                }
            };

            try {
                const res = await fetchWithAuth('./api/add_growth.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(newGrowth)
                });
                const result = await res.json();
                if (result.success) {
                    await initializeDemoData();
                    closeModal('growthModal');
                    e.target.reset();
                    if (document.getElementById('growthMedicationFields')) {
                        document.getElementById('growthMedicationFields').classList.add('hidden');
                    }
                    showAlert('Growth recorded successfully!', 'success');
                } else {
                    showAlert('Error: ' + result.error, 'error');
                }
            } catch (error) {
                console.error("Backend Error:", error);
                showAlert("Server connection failed.", "error");
            }
        });
    }

    // Mortality Form
    const mortalityForm = document.getElementById('mortalityForm');
    if (mortalityForm) {
        mortalityForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            const formData = new FormData(e.target);
            const newMortality = {
                date: formData.get('mortalityDate'),
                houseId: formData.get('mortalityHouse'),
                deaths: parseInt(formData.get('deaths')) || 0,
                cause: formData.get('cause'),
                notes: formData.get('mortalityNotes')
            };

            try {
                const res = await fetchWithAuth('./api/add_mortality.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(newMortality)
                });
                const result = await res.json();
                if (result.success) {
                    await initializeDemoData();
                    closeModal('mortalityModal');
                    e.target.reset();
                    showAlert('Mortality recorded', 'warning');
                } else {
                    showAlert('Error: ' + result.error, 'error');
                }
            } catch (error) {
                console.error("Backend Error:", error);
                showAlert("Server connection failed.", "error");
            }
        });
    }

    // Employee Form
    const employeeForm = document.getElementById('employeeForm');
    if (employeeForm) {
        employeeForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(e.target);
            const selectedHouses = Array.from(document.querySelectorAll('#employeeForm [name="houses"]:checked')).map(cb => cb.value);

            const newEmployee = {
                id: Date.now(),
                name: formData.get('name'),
                email: formData.get('email'),
                role: formData.get('role'),
                accessLevel: selectedHouses.length > 0 ? selectedHouses.join(', ') : 'None',
                lastLogin: 'Never',
                status: 'active',
                houses: selectedHouses
            };
            employees.push(newEmployee);
            closeModal('employeeModal');
            e.target.reset();
            loadAdmin();
            showAlert('Employee added successfully!', 'success');
        });
    }


    // Add Ingredient Purchase Form
    const addIngredientPurchaseForm = document.getElementById('addIngredientPurchaseForm');
    if (addIngredientPurchaseForm) {
        addIngredientPurchaseForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            const formData = new FormData(e.target);

            const limit = {
                purchaseDate: formData.get('purchaseDate'),
                purchaseIngredient: formData.get('ingredientType'),
                purchaseType: 'purchase',
                purchaseQuantity: parseFloat(formData.get('quantity')) || 0,
                unit: formData.get('unit'),
                purchasePurpose: '',
                purchaseNote: `Purchased from ${formData.get('supplier')}`,
                unitCost: parseFloat(formData.get('cost')) || 0,
            };

            if (limit.unit === 'bags') {
                const bagSize = parseFloat(formData.get('bagSize')) || 50;
                limit.purchaseQuantity = limit.purchaseQuantity * bagSize;
            }

            try {
                const res = await fetchWithAuth('./api/add_ingredient_purchase.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(limit)
                });
                const result = await res.json();
                if (result.success) {
                    await initializeDemoData();
                    closeModal('inventoryModal');
                    e.target.reset();
                    if (document.getElementById('bagSizeField')) {
                        document.getElementById('bagSizeField').classList.add('hidden');
                    }
                    loadInventory();
                    showAlert('Purchase recorded successfully!', 'success');
                } else {
                    showAlert('Error: ' + result.error, 'error');
                }
            } catch (error) {
                console.error("Backend Error:", error);
                showAlert("Server connection failed.", "error");
            }
        });
    }



    // Ingredient Usage Form
    const ingredientUsageForm = document.getElementById('ingredientUsageForm');

    if (ingredientUsageForm) {
        ingredientUsageForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData(e.target);
            const data = {
                usageDate: formData.get('usageDate'),
                usageIngredient: formData.get('usageIngredient'),
                usageType: 'usage',
                usageQuantity: parseFloat(formData.get('usageQuantity')) || 0,
                usagePurpose: formData.get('usagePurpose'),
                usageNotes: formData.get('usageNotes')
            };

            if (data.usageQuantity <= 0) {
                showAlert("Quantity must be greater than 0", "error");
                return;
            }

            try {
                const res = await fetchWithAuth('./api/add_ingredient_usage.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });
                const result = await res.json();

                if (result.success) {
                    await initializeDemoData();
                    closeModal('ingredientUsageModal');
                    e.target.reset();
                    loadInventory();
                    showAlert('Usage recorded successfully!', 'success');
                } else {
                    showAlert('Error: ' + result.error, 'error');
                }
            } catch (error) {
                console.error("Backend Error:", error);
                showAlert("Server connection failed.", "error");
            }
        });
    }

    // Purchase Form
    const purchaseForm = document.getElementById('purchaseForm');
    if (purchaseForm) {
        purchaseForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            const formData = new FormData(e.target);

            const newPurchase = {
                date: formData.get('purchaseDate'),
                category: formData.get('purchaseCategory'),
                item: formData.get('purchaseItem'),
                quantity: parseFloat(formData.get('purchaseQty')) || 0,
                unit: formData.get('purchaseUnit'),
                unitCost: parseFloat(formData.get('unitCost')) || 0,
                totalCost: parseFloat(formData.get('totalCost')) || 0,
                supplier: formData.get('purchaseSupplier')
            };

            try {
                const res = await fetchWithAuth('./api/add_purchase.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(newPurchase)
                });
                const result = await res.json();
                if (result.success) {
                    await initializeDemoData();
                    closeModal('purchaseModal');
                    e.target.reset();
                    loadPurchasesTable();
                    showAlert('Purchase recorded!', 'success');
                } else {
                    showAlert('Error: ' + result.error, 'error');
                }
            } catch (error) {
                console.error("Backend Error:", error);
                showAlert("Server connection failed.", "error");
            }
        });
    }

    // Crate Adjustment Form
    const crateForm = document.getElementById('crateAdjustmentForm');
    if (crateForm) {
        crateForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(e.target);
            const type = formData.get('adjustmentType');
            const qty = parseInt(formData.get('crateQty')) || 0;
            const actualQty = type === 'add' ? qty : -qty;

            crateStock += actualQty;
            crateMovements.unshift({
                date: new Date().toLocaleString(),
                type: type === 'add' ? 'Purchase/Return' : (type === 'remove' ? 'Damage/Loss' : 'Correction'),
                quantity: actualQty,
                source: formData.get('reason'),
                balance: crateStock
            });

            closeModal('crateAdjustmentModal');
            e.target.reset();
            loadCrates();
            showAlert('Crate stock adjusted!', 'success');
        });
    }

    // Excess Form
    const excessForm = document.getElementById('excessForm');
    if (excessForm) {
        excessForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(e.target);

            const newExcess = {
                id: Date.now(),
                date: formData.get('date'),
                houseId: formData.get('houseId'),
                excessCount: parseInt(formData.get('excessCount')) || 0,
                reason: formData.get('reason')
            };

            excessData.push(newExcess);
            closeModal('excessModal');
            e.target.reset();
            showAlert('Excess quantity recorded!', 'success');
        });
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', async function () {
    const page = window.location.pathname.split('/').pop().replace('.php', '') || 'dashboard';

    initLogin();
    initFormHandlers();

    // If we're on a page other than login, load the data and the page-specific UI
    if (page !== 'login') {
        await initializeDemoData();

        switch (page) {
            case 'dashboard':
            case 'index':
                loadDashboard();
                break;
            case 'rearing':
                loadRearingPage();
                break;
            case 'inventory':
                loadInventory();
                break;
            case 'crm':
                loadCRM();
                break;
            case 'crates':
                loadCrates();
                break;
            case 'admin':
                loadAdmin();
                break;
        }
    }

    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Toggle Password Visibility
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            const isPass = passwordInput.type === 'password';
            passwordInput.type = isPass ? 'text' : 'password';
            this.innerHTML = `<i data-lucide="${isPass ? 'eye-off' : 'eye'}" class="w-5 h-5"></i>`;
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    }
});