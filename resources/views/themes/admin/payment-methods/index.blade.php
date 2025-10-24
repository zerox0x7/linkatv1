<!DOCTYPE html>
<html lang="ar" dir="rtl"  style="overflow-y: scroll; -ms-overflow-style: none; scrollbar-width: none;"  >

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Methods</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#00c8b3',
                        secondary: '#24589f'
                    },
                    borderRadius: {
                        'none': '0px',
                        'sm': '4px',
                        DEFAULT: '8px',
                        'md': '12px',
                        'lg': '16px',
                        'xl': '20px',
                        '2xl': '24px',
                        '3xl': '32px',
                        'full': '9999px',
                        'button': '8px'
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <style>
        :where([class^="ri-"])::before {
            content: "\f3c2";
        }

        body {
            background-color: #131a2a;
            color: #fff;
            font-family: 'gg', sans-serif;
        }

        .switch {
            direction: ltr;
        }

        [dir="rtl"] .ri-arrow-left-s-line:before {
            content: "\EA6C";
        }

        [dir="rtl"] .ri-arrow-right-s-line:before {
            content: "\EA64";
        }

        [dir="rtl"] .translate-x-full {
            transform: translateX(-100%);
        }

        .card {
            background-color: #1c2536;
            border-radius: 8px;
        }

        .payment-method-card {
            transition: all 0.3s ease;
        }

        .payment-method-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 24px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #3a4255;
            transition: .4s;
            border-radius: 24px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #00c8b3;
        }

        input:checked+.slider:before {
            transform: translateX(24px);
        }

        .tab-active {
            background-color: rgba(0, 200, 179, 0.1);
            color: #00c8b3;
            font-weight: 500;
        }

        .search-input {
            background-color: #1c2536;
            border: 1px solid #2d3748;
        }

        .search-input:focus {
            border-color: #00c8b3;
            outline: none;
        }
    </style>


   <!-- CSS للتحكم في القوائم المنسدلة -->
    <style>
        .s-dropdown-content {
            display: none;
            opacity: 0;
            max-height: 0;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .s-dropdown-content.show {
            display: block;
            opacity: 1;
            max-height: 500px;
        }

        .s-dropdown-toggle {
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .s-dropdown-toggle:hover {
            color: #10b981;
        }

        .s-transform.rotate-180 {
            transform: rotate(180deg);
        }
    </style>
</head>

<body class="min-h-screen">
    <!-- Top Navigation -->
    {{-- <header class="bg-[#131a2a] border-b border-gray-700 px-6 py-3 flex items-center justify-between">
        <div class="flex items-center space-x-reverse space-x-4">
            <button class="text-gray-400 w-8 h-8 flex items-center justify-center">
                <i class="ri-menu-line ri-lg"></i>
            </button>
            <div class="font-['Pacifico'] text-primary text-2xl">logo</div>
        </div>
        <div class="relative w-96">
            <input type="text" placeholder="Search..."
                class="search-input w-full py-2 px-4 pr-10 rounded-button text-sm text-white">
            <div
                class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 flex items-center justify-center text-gray-400">
                <i class="ri-search-line"></i>
            </div>
        </div>
        <div class="flex items-center space-x-5">
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-400">EN</span>
                <div class="w-5 h-5 flex items-center justify-center">
                    <i class="ri-global-line text-gray-400"></i>
                </div>
            </div>
            <div class="flex items-center">
                <label class="switch">
                    <input type="checkbox" checked>
                    <span class="slider"></span>
                </label>
            </div>
            <div class="w-8 h-8 flex items-center justify-center">
                <i class="ri-notification-3-line text-gray-400"></i>
            </div>
        </div>
    </header> --}}
   
    <div class="flex">
        <!-- Sidebar -->
        @include('themes.admin.parts.sidebar')
        <!-- Main Content -->
        <main class=" flex-1  bg-[#131a2a]">

            <div class="max-w-7xl mx-auto">
         @include('themes.admin.parts.header')

                <!-- Page Header -->
                {{-- <div class="mb-8 ">
                    <h1 class="text-2xl font-semibold mb-2">Payment Methods</h1>
                    <p class="text-gray-400">Manage and add payment methods to your store</p>
                </div> --}}
                <!-- Tabs -->
                <div class="mb-8 mt-4 flex space-x-reverse space-x-2 border-b border-gray-700">
                    <button id="paymentMethodsTab" class="px-4 py-3 tab-active rounded-t-lg">Payment Methods</button>
                    <button id="settingsTab" class="px-4 py-3 text-gray-400 hover:text-gray-300">Settings</button>
                    <button id="historyTab" class="px-4 py-3 text-gray-400 hover:text-gray-300">Transaction
                        History</button>
                </div>
                <!-- Add New Payment Method -->
                <div class="card p-6 mb-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-medium">Add New Payment Method</h2>
                        <button
                            class="bg-primary text-white px-4 py-2 rounded-button whitespace-nowrap flex items-center">
                            <div class="w-5 h-5 flex items-center justify-center mr-2">
                                <i class="ri-add-line"></i>
                            </div>
                            Add Method
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div
                            class="payment-method-card p-5 border border-gray-700 rounded-lg flex flex-col items-center justify-center cursor-pointer hover:border-primary">
                            <div
                                class="w-12 h-12 flex items-center justify-center bg-blue-500 bg-opacity-10 rounded-full mb-4">
                                <i class="ri-bank-card-line ri-xl text-blue-400"></i>
                            </div>
                            <h3 class="text-lg font-medium mb-1">Credit Card</h3>
                            <p class="text-sm text-gray-400 text-center">Accept Visa, Mastercard, Amex and more</p>
                        </div>
                        <div
                            class="payment-method-card p-5 border border-gray-700 rounded-lg flex flex-col items-center justify-center cursor-pointer hover:border-primary">
                            <div
                                class="w-12 h-12 flex items-center justify-center bg-blue-500 bg-opacity-10 rounded-full mb-4">
                                <i class="ri-paypal-fill ri-xl text-blue-400"></i>
                            </div>
                            <h3 class="text-lg font-medium mb-1">PayPal</h3>
                            <p class="text-sm text-gray-400 text-center">Connect your PayPal business account</p>
                        </div>
                        <div
                            class="payment-method-card p-5 border border-gray-700 rounded-lg flex flex-col items-center justify-center cursor-pointer hover:border-primary">
                            <div
                                class="w-12 h-12 flex items-center justify-center bg-blue-500 bg-opacity-10 rounded-full mb-4">
                                <i class="ri-bank-line ri-xl text-blue-400"></i>
                            </div>
                            <h3 class="text-lg font-medium mb-1">Bank Transfer</h3>
                            <p class="text-sm text-gray-400 text-center">Accept direct bank transfers</p>
                        </div>
                    </div>
                </div>
                <!-- Current Payment Methods -->
                <div class="card p-6 mb-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-medium">Current Payment Methods</h2>
                        <div class="relative">
                            <button
                                class="flex items-center space-x-1 text-sm text-gray-400 border border-gray-700 px-3 py-2 rounded-button whitespace-nowrap">
                                <span>Filter</span>
                                <div class="w-4 h-4 flex items-center justify-center">
                                    <i class="ri-filter-3-line"></i>
                                </div>
                            </button>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <!-- Payment Method 1 -->
                        <div class="bg-[#1f2937] p-4 rounded-lg flex items-center justify-between">
                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 flex items-center justify-center bg-blue-500 bg-opacity-10 rounded-full mr-4">
                                    <i class="ri-visa-fill ri-xl text-blue-400"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium">Visa ending in 4242</h3>
                                    <p class="text-sm text-gray-400">Expires 06/2027</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <span
                                    class="px-3 py-1 bg-green-500 bg-opacity-10 text-green-400 text-xs rounded-full">Default</span>
                                <label class="switch">
                                    <input type="checkbox" checked>
                                    <span class="slider"></span>
                                </label>
                                <div class="flex space-x-2">
                                    <button
                                        class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-white bg-gray-700 bg-opacity-50 rounded-full">
                                        <i class="ri-pencil-line"></i>
                                    </button>
                                    <button
                                        class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-white bg-gray-700 bg-opacity-50 rounded-full">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Payment Method 2 -->
                        <div class="bg-[#1f2937] p-4 rounded-lg flex items-center justify-between">
                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 flex items-center justify-center bg-blue-500 bg-opacity-10 rounded-full mr-4">
                                    <i class="ri-mastercard-fill ri-xl text-orange-400"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium">Mastercard ending in 5678</h3>
                                    <p class="text-sm text-gray-400">Expires 09/2026</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <label class="switch">
                                    <input type="checkbox" checked>
                                    <span class="slider"></span>
                                </label>
                                <div class="flex space-x-2">
                                    <button
                                        class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-white bg-gray-700 bg-opacity-50 rounded-full">
                                        <i class="ri-pencil-line"></i>
                                    </button>
                                    <button
                                        class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-white bg-gray-700 bg-opacity-50 rounded-full">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Payment Method 3 -->
                        <div class="bg-[#1f2937] p-4 rounded-lg flex items-center justify-between">
                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 flex items-center justify-center bg-blue-500 bg-opacity-10 rounded-full mr-4">
                                    <i class="ri-paypal-fill ri-xl text-blue-400"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium">PayPal</h3>
                                    <p class="text-sm text-gray-400">store@example.com</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <label class="switch">
                                    <input type="checkbox" checked>
                                    <span class="slider"></span>
                                </label>
                                <div class="flex space-x-2">
                                    <button
                                        class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-white bg-gray-700 bg-opacity-50 rounded-full">
                                        <i class="ri-pencil-line"></i>
                                    </button>
                                    <button
                                        class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-white bg-gray-700 bg-opacity-50 rounded-full">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Payment Method 4 (Disabled) -->
                        <div class="bg-[#1f2937] p-4 rounded-lg flex items-center justify-between opacity-60">
                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 flex items-center justify-center bg-blue-500 bg-opacity-10 rounded-full mr-4">
                                    <i class="ri-bank-line ri-xl text-gray-400"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium">Bank Transfer</h3>
                                    <p class="text-sm text-gray-400">Account ending in 9012</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <label class="switch">
                                    <input type="checkbox">
                                    <span class="slider"></span>
                                </label>
                                <div class="flex space-x-2">
                                    <button
                                        class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-white bg-gray-700 bg-opacity-50 rounded-full">
                                        <i class="ri-pencil-line"></i>
                                    </button>
                                    <button
                                        class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-white bg-gray-700 bg-opacity-50 rounded-full">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Payment Settings -->
                <div class="card p-6">
                    <h2 class="text-xl font-medium mb-6">Payment Settings</h2>
                    <div class="space-y-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium">Auto-capture payments</h3>
                                <p class="text-sm text-gray-400">Automatically capture payments when an order is placed
                                </p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" id="autoCapture" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium">Save customer payment methods</h3>
                                <p class="text-sm text-gray-400">Allow customers to save payment methods for future
                                    purchases</p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" id="savePaymentMethods" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium">Test mode</h3>
                                <p class="text-sm text-gray-400">Process test payments without charging real money</p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" id="testMode">
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium">3D Secure authentication</h3>
                                <p class="text-sm text-gray-400">Require additional authentication for all card
                                    payments</p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" id="secureAuth" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="pt-4 border-t border-gray-700">
                            <button class="bg-primary text-white px-6 py-2 rounded-button whitespace-nowrap">Save
                                Settings</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <!-- Add Payment Method Modal -->
    <div id="addPaymentModal"
        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
        <div class="bg-[#1c2536] rounded-lg w-full max-w-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold">Add Credit Card</h2>
                <button id="closeModal" class="text-gray-400 hover:text-white">
                    <div class="w-6 h-6 flex items-center justify-center">
                        <i class="ri-close-line ri-lg"></i>
                    </div>
                </button>
            </div>
            <form id="paymentForm" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Card Number</label>
                    <input type="text" placeholder="1234 5678 9012 3456"
                        class="w-full bg-[#131a2a] border border-gray-700 rounded-button px-4 py-2 text-white focus:border-primary focus:outline-none">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Expiration Date</label>
                        <input type="text" placeholder="MM/YY"
                            class="w-full bg-[#131a2a] border border-gray-700 rounded-button px-4 py-2 text-white focus:border-primary focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">CVC</label>
                        <input type="text" placeholder="123"
                            class="w-full bg-[#131a2a] border border-gray-700 rounded-button px-4 py-2 text-white focus:border-primary focus:outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Cardholder Name</label>
                    <input type="text" placeholder="John Smith"
                        class="w-full bg-[#131a2a] border border-gray-700 rounded-button px-4 py-2 text-white focus:border-primary focus:outline-none">
                </div>
                <div class="flex items-center mt-4">
                    <input type="checkbox" id="defaultCard" class="hidden">
                    <label for="defaultCard" class="flex items-center cursor-pointer">
                        <div
                            class="w-5 h-5 border border-gray-600 rounded flex items-center justify-center mr-2 bg-[#131a2a]">
                            <div class="w-3 h-3 bg-primary rounded hidden" id="defaultCardCheck"></div>
                        </div>
                        <span class="text-sm text-gray-300">Set as default payment method</span>
                    </label>
                </div>
                <div class="pt-4">
                    <button type="submit"
                        class="w-full bg-primary text-white py-2 rounded-button whitespace-nowrap">Add Card</button>
                </div>
            </form>
        </div>
    </div>
    <script id="modalScript">
        document.addEventListener('DOMContentLoaded', function() {
            const addMethodBtn = document.querySelector('.bg-primary');
            const modal = document.getElementById('addPaymentModal');
            const closeModal = document.getElementById('closeModal');
            const defaultCardCheckbox = document.getElementById('defaultCard');
            const defaultCardCheck = document.getElementById('defaultCardCheck');
            const toastContainer = document.createElement('div');
            toastContainer.id = 'toastContainer';
            toastContainer.className = 'fixed bottom-4 right-4 z-50';
            document.body.appendChild(toastContainer);

            function showToast(message, type = 'success') {
                const toast = document.createElement('div');
                toast.className =
                    `flex items-center p-4 mb-3 rounded-lg text-white ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} shadow-lg transition-all duration-300 transform translate-x-full`;
                toast.innerHTML = `
<div class="w-6 h-6 flex items-center justify-center mr-2">
<i class="${type === 'success' ? 'ri-check-line' : 'ri-error-warning-line'}"></i>
</div>
<span>${message}</span>
`;
                toastContainer.appendChild(toast);
                requestAnimationFrame(() => {
                    toast.style.transform = 'translateX(0)';
                });
                setTimeout(() => {
                    toast.style.transform = 'translateX(full)';
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }

            function savePreference(settingId, value) {
                localStorage.setItem(settingId, value);
                showToast('Setting updated successfully');
            }

            function initializeSliders() {
                const sliders = document.querySelectorAll('.switch input[type="checkbox"]');
                sliders.forEach(slider => {
                    if (!slider.id) return;
                    const savedValue = localStorage.getItem(slider.id);
                    if (savedValue !== null) {
                        slider.checked = savedValue === 'true';
                    }
                    slider.addEventListener('change', function() {
                        savePreference(this.id, this.checked);
                    });
                });
            }
            initializeSliders();
            addMethodBtn.addEventListener('click', function() {
                modal.classList.remove('hidden');
            });
            closeModal.addEventListener('click', function() {
                modal.classList.add('hidden');
            });
            defaultCardCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    defaultCardCheck.classList.remove('hidden');
                } else {
                    defaultCardCheck.classList.add('hidden');
                }
            });
            // Close modal when clicking outside
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                }
            });
            // Form submission
            document.getElementById('paymentForm').addEventListener('submit', function(e) {
                e.preventDefault();
                // Here you would handle the form submission
                alert('Payment method added successfully!');
                modal.classList.add('hidden');
            });
        });
    </script>
    <script id="paymentMethodCardScript">
        document.addEventListener('DOMContentLoaded', function() {
            const paymentCards = document.querySelectorAll('.payment-method-card');
            paymentCards.forEach(card => {
                card.addEventListener('click', function() {
                    document.getElementById('addPaymentModal').classList.remove('hidden');
                });
            });
        });
    </script>
    <script id="tabScript">
        document.addEventListener('DOMContentLoaded', function() {
            const paymentMethodsTab = document.getElementById('paymentMethodsTab');
            const settingsTab = document.getElementById('settingsTab');
            const historyTab = document.getElementById('historyTab');
            const paymentMethodsContent = document.querySelector('.max-w-7xl > div:not(.mb-8)');
            const settingsContent = document.createElement('div');
            const historyContent = document.createElement('div');
            settingsContent.classList.add('hidden');
            historyContent.classList.add('hidden');
            historyContent.innerHTML = `
<div class="card p-6 mb-6">
<div class="flex flex-wrap items-center justify-between gap-4 mb-6">
<div class="flex items-center gap-4">
<div class="relative">
<input type="text" id="startDate" placeholder="Start Date" class="bg-[#1f2937] border border-gray-700 rounded-button px-4 py-2 text-white w-36">
</div>
<div class="relative">
<input type="text" id="endDate" placeholder="End Date" class="bg-[#1f2937] border border-gray-700 rounded-button px-4 py-2 text-white w-36">
</div>
<select id="statusFilter" class="bg-[#1f2937] border border-gray-700 rounded-button px-4 py-2 text-white">
<option value="">All Status</option>
<option value="completed">Completed</option>
<option value="pending">Pending</option>
<option value="failed">Failed</option>
<option value="refunded">Refunded</option>
</select>
</div>
<button id="applyFilters" class="bg-primary text-white px-4 py-2 rounded-button whitespace-nowrap flex items-center">
<div class="w-5 h-5 flex items-center justify-center mr-2">
<i class="ri-filter-3-line"></i>
</div>
Apply Filters
</button>
</div>
<div class="overflow-x-auto">
<table class="w-full" style="direction: rtl;">
<thead>
<tr class="text-right border-b border-gray-700">
<th class="pb-3 font-medium text-gray-400">Date</th>
<th class="pb-3 font-medium text-gray-400">Transaction ID</th>
<th class="pb-3 font-medium text-gray-400">Payment Method</th>
<th class="pb-3 font-medium text-gray-400">Amount</th>
<th class="pb-3 font-medium text-gray-400">Status</th>
<th class="pb-3 font-medium text-gray-400">Actions</th>
</tr>
</thead>
<tbody class="text-sm">
<tr class="border-b border-gray-700">
<td class="py-4">2025-06-01</td>
<td class="py-4">TRX-89012</td>
<td class="py-4 flex items-center">
<div class="w-6 h-6 flex items-center justify-center bg-blue-500 bg-opacity-10 rounded-full mr-2">
<i class="ri-visa-fill text-blue-400"></i>
</div>
**** 4242
</td>
<td class="py-4">$299.99</td>
<td class="py-4"><span class="px-2 py-1 bg-green-500 bg-opacity-10 text-green-400 rounded-full text-xs">Completed</span></td>
<td class="py-4">
<div class="flex space-x-2">
<button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-white bg-gray-700 bg-opacity-50 rounded-full">
<i class="ri-file-list-line"></i>
</button>
<button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-white bg-gray-700 bg-opacity-50 rounded-full">
<i class="ri-download-line"></i>
</button>
</div>
</td>
</tr>
<tr class="border-b border-gray-700">
<td class="py-4">2025-06-01</td>
<td class="py-4">TRX-89011</td>
<td class="py-4 flex items-center">
<div class="w-6 h-6 flex items-center justify-center bg-blue-500 bg-opacity-10 rounded-full mr-2">
<i class="ri-mastercard-fill text-orange-400"></i>
</div>
**** 5678
</td>
<td class="py-4">$149.99</td>
<td class="py-4"><span class="px-2 py-1 bg-yellow-500 bg-opacity-10 text-yellow-400 rounded-full text-xs">Pending</span></td>
<td class="py-4">
<div class="flex space-x-2">
<button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-white bg-gray-700 bg-opacity-50 rounded-full">
<i class="ri-file-list-line"></i>
</button>
<button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-white bg-gray-700 bg-opacity-50 rounded-full">
<i class="ri-download-line"></i>
</button>
</div>
</td>
</tr>
<tr class="border-b border-gray-700">
<td class="py-4">2025-05-31</td>
<td class="py-4">TRX-89010</td>
<td class="py-4 flex items-center">
<div class="w-6 h-6 flex items-center justify-center bg-blue-500 bg-opacity-10 rounded-full mr-2">
<i class="ri-paypal-fill text-blue-400"></i>
</div>
PayPal
</td>
<td class="py-4">$89.99</td>
<td class="py-4"><span class="px-2 py-1 bg-red-500 bg-opacity-10 text-red-400 rounded-full text-xs">Failed</span></td>
<td class="py-4">
<div class="flex space-x-2">
<button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-white bg-gray-700 bg-opacity-50 rounded-full">
<i class="ri-file-list-line"></i>
</button>
<button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-white bg-gray-700 bg-opacity-50 rounded-full">
<i class="ri-download-line"></i>
</button>
</div>
</td>
</tr>
</tbody>
</table>
</div>
<div class="flex items-center justify-between mt-6">
<div class="text-sm text-gray-400">
Showing 1-3 of 24 transactions
</div>
<div class="flex items-center space-x-2">
<button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-white bg-gray-700 bg-opacity-50 rounded-full">
<i class="ri-arrow-left-s-line"></i>
</button>
<button class="w-8 h-8 flex items-center justify-center text-white bg-primary rounded-full">1</button>
<button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-white bg-gray-700 bg-opacity-50 rounded-full">2</button>
<button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-white bg-gray-700 bg-opacity-50 rounded-full">3</button>
<button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-white bg-gray-700 bg-opacity-50 rounded-full">
<i class="ri-arrow-right-s-line"></i>
</button>
</div>
</div>
</div>`;
            settingsContent.innerHTML = `
<div class="card p-6">
<h2 class="text-xl font-medium mb-6">Payment Configuration</h2>
<div class="space-y-6">
<div class="flex items-center justify-between">
<div>
<h3 class="font-medium">Auto-capture payments</h3>
<p class="text-sm text-gray-400">Automatically capture payments when an order is placed</p>
</div>
<label class="switch">
<input type="checkbox" id="autoCapture" checked>
<span class="slider"></span>
</label>
</div>
<div class="flex items-center justify-between">
<div>
<h3 class="font-medium">Save customer payment methods</h3>
<p class="text-sm text-gray-400">Allow customers to save payment methods for future purchases</p>
</div>
<label class="switch">
<input type="checkbox" id="savePaymentMethods" checked>
<span class="slider"></span>
</label>
</div>
<div class="flex items-center justify-between">
<div>
<h3 class="font-medium">Test mode</h3>
<p class="text-sm text-gray-400">Process test payments without charging real money</p>
</div>
<label class="switch">
<input type="checkbox" id="testMode">
<span class="slider"></span>
</label>
</div>
<div class="flex items-center justify-between">
<div>
<h3 class="font-medium">3D Secure authentication</h3>
<p class="text-sm text-gray-400">Require additional authentication for all card payments</p>
</div>
<label class="switch">
<input type="checkbox" id="secureAuth" checked>
<span class="slider"></span>
</label>
</div>
<div class="flex items-center justify-between">
<div>
<h3 class="font-medium">Payment Currency</h3>
<p class="text-sm text-gray-400">Set default currency for transactions</p>
</div>
<select class="bg-[#1f2937] border border-gray-700 rounded-button px-4 py-2 text-white">
<option value="USD">USD - US Dollar</option>
<option value="EUR">EUR - Euro</option>
<option value="GBP">GBP - British Pound</option>
</select>
</div>
<div class="flex items-center justify-between">
<div>
<h3 class="font-medium">Transaction Fees</h3>
<p class="text-sm text-gray-400">Configure how transaction fees are handled</p>
</div>
<select class="bg-[#1f2937] border border-gray-700 rounded-button px-4 py-2 text-white">
<option value="merchant">Absorbed by merchant</option>
<option value="customer">Passed to customer</option>
<option value="split">Split between both</option>
</select>
</div>
<div class="pt-4 border-t border-gray-700">
<button class="bg-primary text-white px-6 py-2 rounded-button whitespace-nowrap">Save Settings</button>
</div>
</div>
</div>`;
            paymentMethodsContent.parentNode.appendChild(settingsContent);
            paymentMethodsContent.parentNode.appendChild(historyContent);

            function switchTab(activeTab) {
                [paymentMethodsTab, settingsTab, historyTab].forEach(tab => {
                    tab.classList.remove('tab-active');
                    tab.classList.add('text-gray-400', 'hover:text-gray-300');
                });
                activeTab.classList.remove('text-gray-400', 'hover:text-gray-300');
                activeTab.classList.add('tab-active');
                paymentMethodsContent.classList.add('hidden');
                settingsContent.classList.add('hidden');
                historyContent.classList.add('hidden');
                if (activeTab === settingsTab) {
                    settingsContent.classList.remove('hidden');
                } else if (activeTab === historyTab) {
                    historyContent.classList.remove('hidden');
                } else {
                    paymentMethodsContent.classList.remove('hidden');
                }
            }
            paymentMethodsTab.addEventListener('click', () => switchTab(paymentMethodsTab));
            settingsTab.addEventListener('click', () => switchTab(settingsTab));
            historyTab.addEventListener('click', () => switchTab(historyTab));
            document.getElementById('applyFilters').addEventListener('click', function() {
                const startDate = document.getElementById('startDate').value;
                const endDate = document.getElementById('endDate').value;
                const status = document.getElementById('statusFilter').value;
            });
        });
    </script>
</body>

</html>
















{{-- @extends('themes.admin.layouts.app')

@section('title', 'إدارة طرق الدفع')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">إدارة طرق الدفع</h1>
        <a href="{{ route('admin.payment-methods.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded shadow dark:bg-blue-700 dark:hover:bg-blue-800">
            إضافة طريقة دفع جديدة
        </a>
    </div>
    
    <!-- Payment Methods Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden dark:bg-gray-900">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            الشعار
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            الاسم
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            الكود
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            وضع التشغيل
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            الرسوم
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            الحالة
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            إجراءات
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-800">
                    @forelse ($paymentMethods as $method)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="h-10 w-10 rounded overflow-hidden">
                                @if ($method->logo)
                                    <img src="{{ asset('storage/' . $method->logo) }}" 
                                         class="h-10 w-10 object-contain" alt="{{ $method->name }}"
                                         onerror="this.src='{{ asset('images/payment-icon.svg') }}'">
                                @else
                                    <div class="h-10 w-10 flex items-center justify-center bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $method->name }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-300">{{ Str::limit($method->description, 50) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                            {{ $method->code }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $method->mode == 'live' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' }}">
                                {{ $method->mode == 'live' ? 'مباشر' : 'تجريبي' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                            @if ($method->fee_percentage > 0 || $method->fee_fixed > 0)
                                <div>{{ $method->fee_percentage }}% + {{ $method->fee_fixed }} ر.س</div>
                            @else
                                <div>بدون رسوم</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('admin.payment-methods.toggle-status', $method) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full cursor-pointer {{ $method->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                    {{ $method->is_active ? 'مفعل' : 'معطل' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex items-center justify-center space-x-3 space-x-reverse">
                                <a href="{{ route('admin.payment-methods.edit', $method) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                
                                <form action="{{ route('admin.payment-methods.destroy', $method) }}" method="POST" class="inline-block" onsubmit="return confirm('هل أنت متأكد من حذف طريقة الدفع هذه؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-300">
                            لا توجد طرق دفع متاحة. <a href="{{ route('admin.payment-methods.create') }}" class="text-blue-600 hover:underline">إضافة طريقة دفع جديدة</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection  --}}
