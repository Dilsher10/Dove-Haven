<!-- All Modals -->

<!-- Production Entry Modal -->
<div id="productionModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-3xl max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold">Record Egg Collection with Grades</h3>
            <button onclick="closeModal('productionModal')" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <form id="productionForm" class="p-6 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input type="date" name="date" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">House Unit</label>
                    <select name="houseId" id="productionHouseSelect" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
                        <!-- Populated by JS with 60 units -->
                    </select>
                </div>
            </div>

            <!-- Egg Grades Input -->
            <div class="border rounded-lg p-4 bg-gray-50">
                <h4 class="font-medium mb-3 text-gray-700">Egg Counts by Grade</h4>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Large Eggs</label>
                        <input type="number" name="largeEggs" id="largeEggsInput" min="0" value="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none text-sm"
                            oninput="calculateGradesTotal()">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Medium Eggs</label>
                        <input type="number" name="mediumEggs" id="mediumEggsInput" min="0" value="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none text-sm"
                            oninput="calculateGradesTotal()">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Small Eggs</label>
                        <input type="number" name="smallEggs" id="smallEggsInput" min="0" value="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none text-sm"
                            oninput="calculateGradesTotal()">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Pullet/X-Small</label>
                        <input type="number" name="pulletEggs" id="pulletEggsInput" min="0" value="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none text-sm"
                            oninput="calculateGradesTotal()">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Broken</label>
                        <input type="number" name="brokenEggs" id="brokenEggsInput" min="0" value="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 outline-none text-sm"
                            oninput="calculateGradesTotal()">
                    </div>
                </div>
            </div>

            <!-- Calculated Totals -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-green-50 p-4 rounded-lg border border-green-200">
                <div>
                    <label class="block text-sm font-medium text-green-800 mb-1">Full Crates (30 eggs = 1 crate)</label>
                    <input type="number" name="crates" id="crateInput" min="0"
                        class="w-full px-4 py-2 border border-green-300 rounded-lg bg-white font-semibold text-green-900"
                        oninput="calculateFromCrates()">
                    <p class="text-xs text-green-700 mt-1">Auto-calculated from grades, or enter manually</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-green-800 mb-1">Remaining Loose Eggs</label>
                    <input type="number" name="looseEggs" id="looseEggInput" min="0" max="29"
                        class="w-full px-4 py-2 border border-green-300 rounded-lg bg-white font-semibold text-green-900"
                        oninput="calculateFromLoose()">
                    <p class="text-xs text-green-700 mt-1">Eggs not filling a full crate (0-29)</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-green-800 mb-1">Total Eggs</label>
                    <input type="number" name="totalEggs" id="totalEggDisplay" readonly
                        class="w-full px-4 py-2 border border-green-300 rounded-lg bg-green-100 font-bold text-green-900">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Feed Type Used</label>
                    <select name="feedType" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
                        <option value="galdus">Galdus Feed</option>
                        <option value="starter">Starter Feed</option>
                        <option value="grower">Grower Feed</option>
                        <option value="developer">Developer Feed</option>
                        <option value="layer">Layer Feed</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Feed Used (kg)</label>
                    <input type="number" name="feed" required min="0" step="0.1"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
                </div>
            </div>

            <!-- Water/Medication Tracking -->
            <div class="border rounded-lg p-4 bg-blue-50">
                <h4 class="font-medium mb-3 text-blue-800">Water & Medication</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Water Type</label>
                        <select name="waterType" id="waterTypeSelect"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                            onchange="toggleMedicationFields()">
                            <option value="plain">Plain Water</option>
                            <option value="vitamins">Vitamins</option>
                            <option value="medication">Medication</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Water Amount (liters)</label>
                        <input type="number" name="waterAmount" min="0" step="0.1"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                            placeholder="e.g., 50">
                    </div>
                </div>
                <div id="medicationFields" class="hidden space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Medication Name</label>
                        <input type="text" name="medicationName" id="medicationNameInput"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                            placeholder="e.g., Antibiotics, Dewormer">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dosage</label>
                            <input type="text" name="medicationDosage"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                                placeholder="e.g., 10ml per liter">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Next Dose Date</label>
                            <input type="date" name="nextDoseDate" id="nextDoseDateInput"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Comments</label>
                <textarea name="comments" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none"
                    placeholder="Any observations..."></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeModal('productionModal')"
                    class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">Cancel</button>
                <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">Save
                    Collection</button>
            </div>
        </form>
    </div>
</div>




<!-- Excess Quantity Modal -->
<div id="excessModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-orange-600">Record Excess Quantity</h3>
            <button onclick="closeModal('excessModal')" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <form id="excessForm" class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                <input type="date" name="date" required class="w-full px-4 py-2 border border-gray-300 rounded-lg outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Excess Eggs Count</label>
                <input type="number" name="excessCount" required min="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg outline-none">
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeModal('excessModal')" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition">Record Excess</button>
            </div>
        </form>
    </div>
</div>




<!-- Order Modal -->
<div id="orderModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-3xl max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold">New Order</h3>
            <button onclick="closeModal('orderModal')" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <form id="orderForm" class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Customer</label>
                <select name="customerId" id="orderCustomerSelect" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
                    <option value="">Select Customer</option>
                </select>
            </div>

            <!-- Egg Grades Order Section -->
            <div class="border rounded-lg p-4 bg-gray-50">
                <h4 class="font-medium mb-3 text-gray-700">Egg Orders by Grade</h4>
                <div class="space-y-3">
                    <div class="grid grid-cols-12 gap-2 items-end text-xs font-medium text-gray-500 uppercase">
                        <div class="col-span-3">Grade</div>
                        <div class="col-span-3">Qty (Crates)</div>
                        <div class="col-span-3">Unit Price (GH₵)</div>
                        <div class="col-span-3">Subtotal (GH₵)</div>
                    </div>
                    <div class="grid grid-cols-12 gap-2 items-center egg-grade-row" data-product="eggs_large">
                        <div class="col-span-3"><span class="text-sm font-medium text-gray-700">Large</span></div>
                        <div class="col-span-3"><input type="number" name="qty_large" min="0" value="0"
                                class="egg-qty w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none text-sm"
                                oninput="calculateOrderTotal()"></div>
                        <div class="col-span-3"><input type="number" name="price_large" min="0" step="0.01" value="30"
                                class="egg-price w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none text-sm"
                                oninput="calculateOrderTotal()"></div>
                        <div class="col-span-3"><span
                                class="egg-subtotal text-sm font-semibold text-gray-900">GH₵0.00</span></div>
                    </div>
                    <div class="grid grid-cols-12 gap-2 items-center egg-grade-row" data-product="eggs_medium">
                        <div class="col-span-3"><span class="text-sm font-medium text-gray-700">Medium</span></div>
                        <div class="col-span-3"><input type="number" name="qty_medium" min="0" value="0"
                                class="egg-qty w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none text-sm"
                                oninput="calculateOrderTotal()"></div>
                        <div class="col-span-3"><input type="number" name="price_medium" min="0" step="0.01" value="28"
                                class="egg-price w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none text-sm"
                                oninput="calculateOrderTotal()"></div>
                        <div class="col-span-3"><span
                                class="egg-subtotal text-sm font-semibold text-gray-900">GH₵0.00</span></div>
                    </div>
                    <div class="grid grid-cols-12 gap-2 items-center egg-grade-row" data-product="eggs_small">
                        <div class="col-span-3"><span class="text-sm font-medium text-gray-700">Small</span></div>
                        <div class="col-span-3"><input type="number" name="qty_small" min="0" value="0"
                                class="egg-qty w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none text-sm"
                                oninput="calculateOrderTotal()"></div>
                        <div class="col-span-3"><input type="number" name="price_small" min="0" step="0.01" value="25"
                                class="egg-price w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none text-sm"
                                oninput="calculateOrderTotal()"></div>
                        <div class="col-span-3"><span
                                class="egg-subtotal text-sm font-semibold text-gray-900">GH₵0.00</span></div>
                    </div>
                    <div class="grid grid-cols-12 gap-2 items-center egg-grade-row" data-product="eggs_xsmall">
                        <div class="col-span-3"><span class="text-sm font-medium text-gray-700">Extra Small</span></div>
                        <div class="col-span-3"><input type="number" name="qty_xsmall" min="0" value="0"
                                class="egg-qty w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none text-sm"
                                oninput="calculateOrderTotal()"></div>
                        <div class="col-span-3"><input type="number" name="price_xsmall" min="0" step="0.01" value="22"
                                class="egg-price w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none text-sm"
                                oninput="calculateOrderTotal()"></div>
                        <div class="col-span-3"><span
                                class="egg-subtotal text-sm font-semibold text-gray-900">GH₵0.00</span></div>
                    </div>
                </div>
            </div>

            <!-- Other Products -->
            <div class="border rounded-lg p-4 bg-gray-50">
                <h4 class="font-medium mb-3 text-gray-700">Other Products (Optional)</h4>
                <div id="orderItemsContainer" class="space-y-3">
                    <div class="grid grid-cols-12 gap-2 items-end order-item-row">
                        <div class="col-span-4">
                            <label class="block text-xs font-medium text-gray-600 mb-1">Product</label>
                            <select name="product[]"
                                class="product-select w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none text-sm"
                                oninput="calculateOrderTotal()">
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
                            <input type="number" name="quantity[]" min="0" value="0"
                                class="quantity-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none text-sm"
                                oninput="calculateOrderTotal()">
                        </div>
                        <div class="col-span-3">
                            <label class="block text-xs font-medium text-gray-600 mb-1">Unit Price (GH₵)</label>
                            <input type="number" name="unitPrice[]" min="0" step="0.01" value="0"
                                class="unit-price-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none text-sm"
                                oninput="calculateOrderTotal()">
                        </div>
                        <div class="col-span-2">
                            <button type="button" onclick="removeOrderItem(this)"
                                class="w-full px-3 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition text-sm">
                                <i data-lucide="trash-2" class="w-4 h-4 mx-auto"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <button type="button" onclick="addOrderItem()"
                    class="mt-3 flex items-center gap-2 px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition text-sm">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Add Another Product
                </button>
            </div>

            <!-- Order Summary -->
            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-green-800">Subtotal:</span>
                    <span class="text-lg font-bold text-green-900" id="orderSubtotal">GH₵0.00</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-green-800">Total Items:</span>
                    <span class="text-sm font-semibold text-green-900" id="orderTotalItems">0 crates</span>
                </div>
            </div>

            <div class="border-t pt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Payment Details</label>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Payment Method</label>
                        <select name="payment_method" id="orderPaymentMethod" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
                            <option value="cash">Cash</option>
                            <option value="bank">Bank Deposit</option>
                            <option value="mobile">Mobile Money</option>
                            <option value="credit">Credit/Balance</option>
                            <option value="mixed">Mixed Payment</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Amount Paid Now (GH₵)</label>
                        <input type="number" name="amountPaid" id="orderAmountPaid" min="0" step="0.01" value="0"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none"
                            oninput="updateOrderBalance()">
                    </div>
                </div>
                <div class="bg-gray-50 p-3 rounded-lg">
                    <div class="flex justify-between text-sm mb-1">
                        <span>Total Amount:</span>
                        <span class="font-semibold" id="displayOrderTotal">GH₵0.00</span>
                    </div>
                    <div class="flex justify-between text-sm mb-1">
                        <span>Amount Paid:</span>
                        <span class="font-semibold text-green-600" id="displayOrderPaid">GH₵0.00</span>
                    </div>
                    <div class="flex justify-between text-sm font-medium border-t pt-1 mt-1">
                        <span>Balance Due:</span>
                        <span class="text-red-600" id="displayOrderBalance">GH₵0.00</span>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeModal('orderModal')"
                    class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">Cancel</button>
                <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">Create
                    Order</button>
            </div>
        </form>
    </div>
</div>





<!-- Customer Modal -->
<div id="customerModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold">Add New Customer</h3>
            <button onclick="closeModal('customerModal')" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <form id="customerForm" class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                <input type="text" name="name" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email (optional)</label>
                <input type="email" name="email"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                <input type="tel" name="phone" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                <textarea name="address" rows="2"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none"></textarea>
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeModal('customerModal')"
                    class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">Cancel</button>
                <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">Add
                    Customer</button>
            </div>
        </form>
    </div>
</div>




<!-- Employee Modal -->
<div id="employeeModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold">Add Employee</h3>
            <button onclick="closeModal('employeeModal')" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <form id="employeeForm" class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" name="name" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="text" name="password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select name="role" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
                    <option value="">select role</option>
                    <option value="auditor">Auditor/Consultant</option>
                    <option value="farm_manager">Farm Manager</option>
                    <option value="supervisor">Supervisor</option>
                    <option value="sales_manager">Sales Manager</option>
                </select>
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeModal('employeeModal')"
                    class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">Cancel</button>
                <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">Add
                    Employee</button>
            </div>
        </form>
    </div>
</div>




<!-- Growth Modal -->
<div id="growthModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold">Record Flock Growth</h3>
            <button onclick="closeModal('growthModal')" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <form id="growthForm" class="p-6 space-y-4">
            <div class="grid grid-cols-2 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                <input type="date" name="growthDate" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">House Unit</label>
                <select name="growthHouse" id="growthHouseSelect" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    <!-- Populated by JS -->
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Flock/Batch ID</label>
                <input type="text" name="flockId" placeholder="e.g., F001-H1A" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Average Bird Weight (grams)</label>
                <input type="number" name="avgWeight" required min="0" step="1"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Total Birds in Flock</label>
                <input type="number" name="birdCount" required min="0"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Age (weeks)</label>
                <input type="number" name="flockAge" required min="0"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            </div>

            <!-- Water/Medication Tracking for Growth -->
            <div class="border rounded-lg p-4 bg-blue-50">
                <h4 class="font-medium mb-3 text-blue-800">Water & Medication</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Water Type</label>
                        <select name="growthWaterType" id="growthWaterTypeSelect"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                            onchange="toggleGrowthMedicationFields()">
                            <option value="plain">Plain Water</option>
                            <option value="vitamins">Vitamins</option>
                            <option value="medication">Medication</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Water Amount (liters)</label>
                        <input type="number" name="growthWaterAmount" min="0" step="0.1"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                            placeholder="e.g., 50">
                    </div>
                </div>
                <div id="growthMedicationFields" class="hidden space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Medication Name</label>
                        <input type="text" name="growthMedicationName" id="growthMedicationNameInput"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                            placeholder="e.g., Antibiotics, Dewormer">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dosage</label>
                            <input type="text" name="growthMedicationDosage"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                                placeholder="e.g., 10ml per liter">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Next Dose Date</label>
                            <input type="date" name="growthNextDoseDate" id="growthNextDoseDateInput"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeModal('growthModal')"
                    class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">Cancel</button>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Record
                    Growth</button>
            </div>
        </form>
    </div>
</div>




<!-- Mortality Modal -->
<div id="mortalityModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-red-600">Record Mortality</h3>
            <button onclick="closeModal('mortalityModal')" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <form id="mortalityForm" class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                <input type="date" name="mortalityDate" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">House Unit</label>
                <select name="mortalityHouse" id="mortalityHouseSelect" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 outline-none">
                    <!-- Populated by JS -->
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Number of Deaths</label>
                <input type="number" name="deaths" required min="1"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cause (if known)</label>
                <select name="cause"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 outline-none">
                    <option value="unknown">Unknown</option>
                    <option value="disease">Disease</option>
                    <option value="predator">Predator</option>
                    <option value="environment">Environmental (Heat/Cold)</option>
                    <option value="cannibalism">Cannibalism</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                <textarea name="mortalityNotes" rows="2"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 outline-none"></textarea>
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeModal('mortalityModal')"
                    class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">Cancel</button>
                <button type="submit"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">Record Loss</button>
            </div>
        </form>
    </div>
</div>




<!-- Ingredient Purchase Modal -->
<div id="inventoryModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold">Add Ingredient Purchase</h3>
            <button onclick="closeModal('inventoryModal')" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <form id="addIngredientPurchaseForm" class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ingredient Type</label>
                <select name="ingredientType" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
                    <option value="corn">Corn/Maize</option>
                    <option value="soybean">Soybean Meal</option>
                    <option value="wheat">Wheat</option>
                    <option value="fishmeal">Fish Meal</option>
                    <option value="limestone">Limestone</option>
                    <option value="dcp">DCP (Dicalcium Phosphate)</option>
                    <option value="lysine">Lysine</option>
                    <option value="methionine">Methionine</option>
                    <option value="premix">Vitamin Premix</option>
                    <option value="salt">Salt</option>
                    <option value="oil">Vegetable Oil</option>
                    <option value="starter">Starter Feed (Formulated)</option>
                    <option value="grower">Grower Feed (Formulated)</option>
                    <option value="developer">Developer Feed (Formulated)</option>
                    <option value="layer">Layer Feed (Formulated)</option>
                    <option value="galdus">Galdus Feed</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Supplier</label>
                <input type="text" name="supplier" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Quantity Purchased</label>
                <input type="number" name="quantity" required min="0" step="0.1"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Unit</label>
                <select name="unit" id="inventoryUnitSelect"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none"
                    onchange="toggleBagSizeField()">
                    <option value="kg">Kilograms (kg)</option>
                    <option value="bags">Bags</option>
                </select>
            </div>
            <div id="bagSizeField" class="hidden">
                <label class="block text-sm font-medium text-gray-700 mb-1">Bag Size</label>
                <select name="bagSize"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
                    <option value="5">5 kg</option>
                    <option value="10">10 kg</option>
                    <option value="20">20 kg</option>
                    <option value="25">25 kg</option>
                    <option value="50">50 kg</option>
                    <option value="100">100 kg</option>
                    <option value="150">150 kg</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cost per unit (GH₵)</label>
                <input type="number" name="cost" required min="0" step="0.01"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Purchase Date</label>
                <input type="date" name="purchaseDate" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeModal('inventoryModal')"
                    class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">Cancel</button>
                <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">Add
                    Purchase</button>
            </div>
        </form>
    </div>
</div>




<!-- Ingredient Usage Modal -->
<div id="ingredientUsageModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold">Record Ingredient Usage</h3>
            <button onclick="closeModal('ingredientUsageModal')" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <form id="ingredientUsageForm" class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                <input type="date" name="usageDate" id="usageDateInput" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ingredient</label>
                <select name="usageIngredient" id="usageIngredientSelect" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none">
                    <option value="">Select Ingredient</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Quantity Used (kg)</label>
                <input type="number" name="usageQuantity" id="usageQuantityInput" required min="0" step="0.1"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Used For (House/Feed Type)</label>
                <input type="text" name="usagePurpose" id="usagePurposeInput"
                    placeholder="e.g., House 1A, Layer Feed Mix"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                <textarea name="usageNotes" id="usageNotesInput" rows="2"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none"></textarea>
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeModal('ingredientUsageModal')"
                    class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">Cancel</button>
                <button type="submit"
                    class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition">Record
                    Usage</button>
            </div>
        </form>
    </div>
</div>




<!-- Purchase Recording Modal -->
<div id="purchaseModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold">Record Purchase</h3>
            <button onclick="closeModal('purchaseModal')" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <form id="purchaseForm" class="p-6 space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input type="date" name="purchaseDate" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select name="purchaseCategory" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
                        <option value="feed">Feed/Ingredients</option>
                        <option value="equipment">Equipment</option>
                        <option value="medicine">Medicine/Vaccines</option>
                        <option value="utilities">Utilities</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Item Description</label>
                <input type="text" name="purchaseItem" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                    <input type="number" name="purchaseQty" required min="1"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Unit</label>
                    <select name="purchaseUnit"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
                        <option value="units">Units</option>
                        <option value="kg">Kilograms</option>
                        <option value="bags">Bags</option>
                        <option value="liters">Liters</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Unit Cost (GH₵)</label>
                    <input type="number" name="unitCost" required min="0" step="0.01"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Total Cost (GH₵)</label>
                    <input type="number" name="totalCost" required min="0" step="0.01"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Supplier</label>
                <input type="text" name="purchaseSupplier" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Upload Invoice (optional)</label>
                <input type="file" name="purchaseInvoice" id="purchaseInvoiceInput" accept="image/*,.pdf"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none text-sm file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-green-100 file:text-green-700 file:font-medium file:cursor-pointer">
                <p class="text-xs text-gray-500 mt-1">Accepted: images, PDF</p>
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeModal('purchaseModal')"
                    class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">Cancel</button>
                <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">Save
                    Purchase</button>
            </div>
        </form>
    </div>
</div>


<!-- Crate Adjustment Modal -->
<div id="crateAdjustmentModal"
    class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold">Adjust Crate Stock</h3>
            <button onclick="closeModal('crateAdjustmentModal')" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <form id="crateAdjustmentForm" class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Adjustment Type</label>
                <select name="adjustmentType" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="add">Add Crates (Purchase/Return)</option>
                    <option value="remove">Remove Crates (Damage/Loss)</option>
                    <option value="correct">Stock Correction</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                <input type="number" name="crateQty" required min="1"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Reason</label>
                <input type="text" name="reason" required placeholder="e.g., Damaged crates, purchased new, etc."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeModal('crateAdjustmentModal')"
                    class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">Cancel</button>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Adjust
                    Stock</button>
            </div>
        </form>
    </div>
</div>




<!-- House Assignment Modal -->
<div id="reassignHouseModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-4xl">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold">Reassign Houses for <span id="reassignEmployeeName" class="text-green-600"></span></h3>
            <button onclick="closeModal('reassignHouseModal')" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <form id="reassignHouseForm" class="px-6 space-y-4">
            <input type="hidden" name="employee_id" id="reassignEmployeeId">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Assigned Houses</label>
                <div class="grid grid-cols-6 gap-2" id="reassignHouseCheckboxes">
                    <!-- Populated dynamically via JS -->
                </div>
            </div>
            <div class="flex justify-end gap-3 pb-3">
                <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">Save Assignments</button>
            </div>
        </form>
    </div>
</div>





    <!-- Payment Modal (for existing orders) -->
    <div id="paymentModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold">Record Payment</h3>
                <button onclick="closeModal('paymentModal')" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            <form id="paymentForm" class="p-6 space-y-4">
                <input type="hidden" name="orderId" id="paymentOrderId">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Current Balance</label>
                    <input type="text" id="currentBalanceDisplay" readonly class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-red-50 text-red-600 font-semibold">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                    <select name="paymentMethod" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
                        <option value="cash">Cash</option>
                        <option value="bank">Bank Deposit</option>
                        <option value="mobile">Mobile Money</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Amount Paid (GH₵)</label>
                    <input type="number" name="paymentAmount" required min="0.01" step="0.01" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Reference/Notes</label>
                    <input type="text" name="paymentRef" placeholder="Receipt number, bank ref, etc." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
                </div>
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="closeModal('paymentModal')" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">Record Payment</button>
                </div>
            </form>
        </div>
    </div>
    
    
    
    <div id="roleModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md">
        <div class="p-5 border-b flex justify-between items-center">
            <h3 class="text-lg font-semibold">Change Employee Role</h3>
             <button onclick="closeModal('roleModal')" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-6 h-6"></i>
             </button>
        </div>
        <form id="employeeRoleForm" class="p-5 space-y-4">
            <input type="hidden" name="empId" id="roleEmployeeId">
            <div>
                <label class="block text-sm font-medium mb-1">Select Role</label>
                <select name="empRole" id="roleSelect" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="auditor">Auditor/Consultant</option>
                    <option value="farm_manager">Farm Manager</option>
                    <option value="supervisor">Supervisor</option>
                    <option value="sales_manager">Sales Manager</option>
                </select>
            </div>
            <div class="flex justify-end gap-3 pt-3">
                <button onclick="closeModal('roleModal')"
                    class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>