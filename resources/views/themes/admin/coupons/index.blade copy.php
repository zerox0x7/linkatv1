<!DOCTYPE html>
<html lang="en" dir="rtl" style="overflow-y: scroll; -ms-overflow-style: none; scrollbar-width: none;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coupon Management</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#00e5c9',
                        secondary: '#1f2937'
                     
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
    <style>
        :where([class^="ri-"])::before {
            content: "\f3c2";
        }

        body {
            background-color: #1a202c;
            color: #e2e8f0;
        }

        .coupon-card {
            position: relative;
            overflow: hidden;
            height: 180px;
        }

        .coupon-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
        }

        .coupon-content {
            position: relative;
            z-index: 1;
            height: 100%;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background-color: rgba(0, 0, 0, 0.4);
        }

        input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            width: 18px;
            height: 18px;
            border: 2px solid #4b5563;
            border-radius: 4px;
            background-color: transparent;
            display: inline-block;
            position: relative;
            cursor: pointer;
        }

        input[type="checkbox"]:checked {
            background-color: #00e5c9;
            border-color: #00e5c9;
        }

        input[type="checkbox"]:checked::after {
            content: "";
            position: absolute;
            left: 5px;
            top: 2px;
            width: 6px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .status-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 2;
            border-radius: 9999px;
            padding: 2px 10px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-active {
            background-color: rgba(16, 185, 129, 0.2);
            color: #10b981;
        }

        .status-inactive {
            background-color: rgba(156, 163, 175, 0.2);
            color: #9ca3af;
        }

        .search-input:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(0, 229, 201, 0.3);
        }

        .pagination-item {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
            cursor: pointer;
        }

        .pagination-item.active {
            background-color: #00e5c9;
            color: #1a202c;
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




    {{-- modal style  --}}

  <style>
        /* Custom CSS with coupon- prefix for RTL specific styling needs */
        .coupon-modal {
            backdrop-filter: blur(15px);
            background: rgba(0, 0, 0, 0.7);
            direction: rtl;
        }

        .coupon-modal.active {
            display: flex !important;
        }

        .coupon-modal-content {
            transform: scale(0.95) translateY(20px);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .coupon-modal.active .coupon-modal-content {
            transform: scale(1) translateY(0);
            opacity: 1;
        }

        .coupon-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .coupon-scrollbar::-webkit-scrollbar-track {
            background: #1a1f2e;
            border-radius: 6px;
        }

        .coupon-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #00e1c0, #00c4a7);
            border-radius: 6px;
        }

        .coupon-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #00c4a7, #00a691);
        }

        .coupon-toggle {
            position: relative;
            width: 44px;
            height: 24px;
            background: #1a1f2e;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid #2a3441;
        }

        .coupon-toggle.active {
            background: linear-gradient(135deg, #00e1c0, #00c4a7);
            border-color: #00e1c0;
            box-shadow: 0 4px 12px rgba(0, 225, 192, 0.3);
        }

        .coupon-toggle-thumb {
            position: absolute;
            top: 2px;
            right: 2px; /* Changed from left to right for RTL */
            width: 16px;
            height: 16px;
            background: white;
            border-radius: 50%;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }

        .coupon-toggle.active .coupon-toggle-thumb {
            transform: translateX(-20px); /* Negative value for RTL */
        }

        .coupon-gradient-bg {
            background: linear-gradient(145deg, #232b3e 0%, #1a1f2e 100%);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .coupon-header-gradient {
            background: linear-gradient(135deg, #232b3e 0%, #2a3441 50%, #1a1f2e 100%);
            border-bottom: 1px solid rgba(0, 225, 192, 0.2);
            position: relative;
        }

        .coupon-header-gradient::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, #00e1c0, transparent);
        }

        .coupon-btn-primary {
            background: linear-gradient(135deg, #00e1c0, #00c4a7);
            border: none;
            color: #232b3e;
            font-weight: 600;
            position: relative;
            overflow: hidden;
        }

        .coupon-btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            right: -100%; /* Changed from left to right for RTL */
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: right 0.5s; /* Changed from left to right */
        }

        .coupon-btn-primary:hover::before {
            right: 100%; /* Changed from left to right */
        }

        .coupon-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 225, 192, 0.4);
        }

        .coupon-btn-secondary {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #ffffff;
            backdrop-filter: blur(10px);
        }

        .coupon-btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: #00e1c0;
            transform: translateY(-1px);
        }

        .coupon-section-indicator-1 {
            background: linear-gradient(135deg, #00e1c0, #00c4a7);
            box-shadow: 0 0 15px rgba(0, 225, 192, 0.4);
        }

        .coupon-section-indicator-2 {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            box-shadow: 0 0 15px rgba(99, 102, 241, 0.4);
        }

        .coupon-section-indicator-3 {
            background: linear-gradient(135deg, #ec4899, #f97316);
            box-shadow: 0 0 15px rgba(236, 72, 153, 0.4);
        }

        .coupon-section-indicator-4 {
            background: linear-gradient(135deg, #f59e0b, #ef4444);
            box-shadow: 0 0 15px rgba(245, 158, 11, 0.4);
        }

        .coupon-input {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            text-align: right; /* RTL text alignment */
        }

        .coupon-input:focus {
            background: rgba(255, 255, 255, 0.08) !important;
            border-color: #00e1c0 !important;
            box-shadow: 0 0 0 3px rgba(0, 225, 192, 0.1) !important;
            outline: none !important;
        }

        .coupon-input::placeholder {
            color: rgba(255, 255, 255, 0.4) !important;
        }

        /* Custom dropdown styling for RTL */
        .coupon-select {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: left 12px center; /* Changed from right to left for RTL */
            background-repeat: no-repeat;
            background-size: 16px;
            padding-left: 40px; /* Changed from padding-right to padding-left */
            padding-right: 12px;
            text-align: right; /* RTL text alignment */
        }

        .coupon-select:focus {
            background: rgba(255, 255, 255, 0.08) !important;
            border-color: #00e1c0 !important;
            box-shadow: 0 0 0 3px rgba(0, 225, 192, 0.1) !important;
            outline: none !important;
        }

        .coupon-select option {
            background: #232b3e !important;
            color: #ffffff !important;
            border: none !important;
            padding: 12px !important;
            text-align: right; /* RTL text alignment */
        }

        .coupon-select option:hover {
            background: #2a3441 !important;
        }

        .coupon-select option:checked {
            background: linear-gradient(135deg, #00e1c0, #00c4a7) !important;
            color: #232b3e !important;
        }

        .coupon-stat-card-1 {
            background: linear-gradient(135deg, rgba(0, 225, 192, 0.1), rgba(0, 196, 167, 0.05));
            border: 1px solid rgba(0, 225, 192, 0.2);
            backdrop-filter: blur(10px);
        }

        .coupon-stat-card-2 {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.1), rgba(34, 197, 94, 0.05));
            border: 1px solid rgba(34, 197, 94, 0.2);
            backdrop-filter: blur(10px);
        }

        .coupon-stat-card-3 {
            background: linear-gradient(135deg, rgba(249, 115, 22, 0.1), rgba(249, 115, 22, 0.05));
            border: 1px solid rgba(249, 115, 22, 0.2);
            backdrop-filter: blur(10px);
        }

        .coupon-stat-card-4 {
            background: linear-gradient(135deg, rgba(168, 85, 247, 0.1), rgba(168, 85, 247, 0.05));
            border: 1px solid rgba(168, 85, 247, 0.2);
            backdrop-filter: blur(10px);
        }

        .coupon-open-modal-gradient {
            background: linear-gradient(135deg, #00e1c0, #00c4a7);
            box-shadow: 0 8px 32px rgba(0, 225, 192, 0.3);
        }

        .coupon-section-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 16px;
        }

        .coupon-checkbox-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .coupon-checkbox-card:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(0, 225, 192, 0.3);
        }

        .coupon-tag {
            background: rgba(0, 225, 192, 0.15);
            border: 1px solid rgba(0, 225, 192, 0.3);
            color: #00e1c0;
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
        }

        .coupon-tag:hover {
            background: rgba(0, 225, 192, 0.25);
            border-color: rgba(0, 225, 192, 0.5);
        }

        .coupon-tag .coupon-tag-remove {
            position: absolute;
            top: -6px;
            left: -6px; /* Changed from right to left for RTL */
            background: rgba(255, 82, 82, 0.9);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            cursor: pointer;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .coupon-tag:hover .coupon-tag-remove {
            opacity: 1;
        }

        @keyframes couponModalSlideIn {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(30px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .coupon-modal.active .coupon-modal-content {
            animation: couponModalSlideIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Glass morphism effect */
        .coupon-glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .coupon-close-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .coupon-close-btn:hover {
            background: rgba(255, 82, 82, 0.2);
            border-color: rgba(255, 82, 82, 0.4);
            transform: rotate(90deg);
        }

        /* Wizard Guide Styles - RTL adjustments */
        .coupon-wizard-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            z-index: 9999;
            display: none;
            animation: fadeIn 0.3s ease;
            direction: rtl;
        }

        .coupon-wizard-overlay.active {
            display: block;
        }

        .coupon-wizard-spotlight {
            position: absolute;
            border: 3px solid #00e1c0;
            border-radius: 12px;
            box-shadow: 0 0 0 4px rgba(0, 225, 192, 0.3), 0 0 30px rgba(0, 225, 192, 0.6);
            background: transparent;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 10001;
            pointer-events: none;
        }

        .coupon-wizard-tooltip {
            position: absolute;
            background: linear-gradient(135deg, #232b3e, #1a1f2e);
            border: 1px solid rgba(0, 225, 192, 0.3);
            border-radius: 16px;
            padding: 20px;
            min-width: 280px;
            max-width: 350px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6), 0 0 20px rgba(0, 225, 192, 0.2);
            z-index: 10002;
            backdrop-filter: blur(20px);
            animation: tooltipSlideIn 0.4s ease;
            text-align: right; /* RTL text alignment */
        }

        .coupon-wizard-tooltip::before {
            content: '';
            position: absolute;
            width: 0;
            height: 0;
            border-style: solid;
        }

        .coupon-wizard-tooltip.top::before {
            bottom: -10px;
            right: 20px; /* Changed from left to right for RTL */
            border-width: 10px 10px 0 10px;
            border-color: rgba(0, 225, 192, 0.3) transparent transparent transparent;
        }

        .coupon-wizard-tooltip.bottom::before {
            top: -10px;
            right: 20px; /* Changed from left to right for RTL */
            border-width: 0 10px 10px 10px;
            border-color: transparent transparent rgba(0, 225, 192, 0.3) transparent;
        }

        .coupon-wizard-tooltip.left::before {
            left: -10px; /* This remains the same as it's the arrow pointing direction */
            top: 20px;
            border-width: 10px 0 10px 10px;
            border-color: transparent transparent transparent rgba(0, 225, 192, 0.3);
        }

        .coupon-wizard-tooltip.right::before {
            right: -10px; /* Changed from left to right for RTL */
            top: 20px;
            border-width: 10px 10px 10px 0;
            border-color: transparent rgba(0, 225, 192, 0.3) transparent transparent;
        }

        .coupon-wizard-header {
            display: flex;
            align-items: center;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(0, 225, 192, 0.2);
        }

        .coupon-wizard-icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #00e1c0, #00c4a7);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 12px; /* Changed from margin-right to margin-left for RTL */
            color: #232b3e;
            font-weight: bold;
            font-size: 14px;
        }

        .coupon-wizard-title {
            color: #00e1c0;
            font-size: 16px;
            font-weight: 600;
            margin: 0;
        }

        .coupon-wizard-description {
            color: rgba(255, 255, 255, 0.85);
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .coupon-wizard-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .coupon-wizard-progress {
            display: flex;
            align-items: center;
            gap: 8px;
            color: rgba(255, 255, 255, 0.6);
            font-size: 12px;
        }

        .coupon-wizard-progress-bar {
            width: 60px;
            height: 4px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 2px;
            overflow: hidden;
        }

        .coupon-wizard-progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #00e1c0, #00c4a7);
            transition: width 0.3s ease;
        }

        .coupon-wizard-buttons {
            display: flex;
            gap: 8px;
        }

        .coupon-wizard-btn {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
        }

        .coupon-wizard-btn-skip {
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .coupon-wizard-btn-skip:hover {
            background: rgba(255, 255, 255, 0.15);
            color: rgba(255, 255, 255, 0.9);
        }

        .coupon-wizard-btn-next {
            background: linear-gradient(135deg, #00e1c0, #00c4a7);
            color: #232b3e;
            font-weight: 600;
        }

        .coupon-wizard-btn-next:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 225, 192, 0.4);
        }

        .coupon-wizard-btn-prev {
            background: rgba(255, 255, 255, 0.05);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .coupon-wizard-btn-prev:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: #00e1c0;
        }

        .coupon-wizard-btn-finish {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: white;
            font-weight: 600;
        }

        .coupon-wizard-btn-finish:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.4);
        }

        .coupon-wizard-floating-btn {
            position: fixed;
            bottom: 8rem;
            left: 8px; /* Changed from right to left for RTL */
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(99, 102, 241, 0.4);
            transition: all 0.3s ease;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .coupon-wizard-floating-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 25px rgba(99, 102, 241, 0.6);
        }

        .coupon-section-card.highlighted {
            border: 2px solid #00e1c0 !important;
            box-shadow: 0 0 20px rgba(0, 225, 192, 0.3) !important;
            background: rgba(0, 225, 192, 0.05) !important;
            transition: all 0.4s ease !important;
        }

        /* RTL specific adjustments */
        .rtl-text {
            text-align: right;
            direction: rtl;
        }

        .coupon-input[type="search"] {
            background-position: left 12px center !important;
            padding-left: 40px !important;
            padding-right: 12px !important;
        }

        /* Search icon positioning for RTL */
        .search-icon-container {
            left: 12px !important;
            right: auto !important;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes tooltipSlideIn {
            from {
                opacity: 0;
                transform: translateY(10px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .coupon-wizard-pulse {
            animation: pulse 2s infinite;
        }
  </style>









</head>

<body class="min-h-screen">

    {{-- <div
        class="relative w-full max-w-3xl h-80 mx-auto bg-gradient-to-br from-gray-100 via-gray-200 to-gray-300 rounded-3xl shadow-2xl overflow-hidden">
        <!-- Marble veining -->
        <div class="absolute inset-0 opacity-40">
            <div
                class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-gray-600 to-transparent transform rotate-12 scale-150">
            </div>
            <div
                class="absolute top-12 left-0 w-full h-px bg-gradient-to-r from-gray-500 via-transparent to-gray-600 transform -rotate-6 scale-125">
            </div>
            <div
                class="absolute top-24 left-0 w-full h-px bg-gradient-to-r from-transparent via-gray-700 to-gray-500 transform rotate-3 scale-110">
            </div>
            <div
                class="absolute bottom-16 left-0 w-full h-px bg-gradient-to-r from-gray-600 via-gray-400 to-transparent transform -rotate-12 scale-140">
            </div>
        </div>

        <!-- Marble highlights -->
        <div class="absolute inset-0 bg-gradient-to-tr from-white/30 via-transparent to-white/20"></div>

        <!-- Content -->
        <div class="relative flex items-center justify-center h-full">
            <div class="text-center">
                <!-- Engraved text effect -->
                <h1 class="text-7xl md:text-9xl font-bold tracking-wider relative">
                    <!-- Engraved shadow -->
                    <span class="absolute inset-0 text-gray-400 transform translate-x-1 translate-y-1">AABCCN</span>

                    <!-- Main text -->
                    <span class="relative text-gray-700"
                        style="text-shadow: -1px -1px 0 rgba(255,255,255,0.8), 1px 1px 2px rgba(0,0,0,0.3);">
                        AABCCN
                    </span>
                </h1>

                <!-- Decorative elements -->
                <div class="mt-8 flex justify-center items-center space-x-4">
                    <div class="w-8 h-px bg-gradient-to-r from-transparent to-gray-500"></div>
                    <div class="w-2 h-2 bg-gray-600 rounded-full"></div>
                    <div class="w-8 h-px bg-gradient-to-l from-transparent to-gray-500"></div>
                </div>
            </div>
        </div>

        <!-- Marble polish shine -->
        <div class="absolute top-8 left-8 w-32 h-32 bg-white/20 rounded-full blur-3xl"></div>
    </div> --}}

    <div class="flex">
        <!-- Sidebar -->
        @include('themes.admin.parts.sidebar')
        <!-- Main Content -->
        <div class="flex-1 ">
            <!-- Header -->
            @include('themes.admin.parts.header')
            <!-- Content -->
            <main class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold">Coupons</h2>
                        <p class="text-gray-400 mt-1">Manage your discount coupons and promotions</p>
                    </div>
                    <a href="{{route('admin.coupons.create']}}"
                        class="bg-primary text-gray-900 px-4 py-2 rounded-button flex items-center whitespace-nowrap hover:bg-primary/90">
                        <div class="w-5 h-5 flex items-center justify-center ml-1">
                            <i class="ri-add-line"></i>
                        </div>
                        Add New Coupon
                    </a>
                </div>
                <!-- Filters -->
                <div class="flex flex-wrap items-center justify-between bg-gray-800 p-4 rounded-button mb-6">
                    <div class="flex space-x-3">
                        <div class="relative">
                            <button class="flex items-center bg-gray-700 px-4 py-2 rounded-button whitespace-nowrap">
                                <div class="w-5 h-5 flex items-center justify-center ml-1">
                                    <i class="ri-sort-desc"></i>
                                </div>
                                <span>Sort By: Newest</span>
                            </button>
                        </div>
                        <button class="flex items-center bg-gray-700 px-4 py-2 rounded-button whitespace-nowrap">
                            <div class="w-5 h-5 flex items-center justify-center ml-1">
                                <i class="ri-delete-bin-line"></i>
                            </div>
                            <span>Bulk Delete</span>
                        </button>
                        <button class="flex items-center bg-gray-700 px-4 py-2 rounded-button whitespace-nowrap">
                            <div class="w-5 h-5 flex items-center justify-center ml-1">
                                <i class="ri-refresh-line"></i>
                            </div>
                            <span>Refresh</span>
                        </button>
                    </div>
                    <div class="flex space-x-3 mt-3 sm:mt-0">
                        <button class="flex items-center bg-gray-700 px-4 py-2 rounded-button whitespace-nowrap">
                            <div class="w-5 h-5 flex items-center justify-center ml-1">
                                <i class="ri-calendar-line"></i>
                            </div>
                            <span>Date Range</span>
                        </button>
                        <button class="flex items-center bg-gray-700 px-4 py-2 rounded-button whitespace-nowrap">
                            <div class="w-5 h-5 flex items-center justify-center ml-1">
                                <i class="ri-filter-line"></i>
                            </div>
                            <span>All Types</span>
                        </button>
                        <button class="flex items-center bg-gray-700 px-4 py-2 rounded-button whitespace-nowrap">
                            <div class="w-5 h-5 flex items-center justify-center ml-1">
                                <i class="ri-checkbox-multiple-line"></i>
                            </div>
                            <span>All Status</span>
                        </button>
                    </div>
                </div>
                <!-- Coupon Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                  
                    
                    @livewire('coupon-card')

                    <!-- Coupon  -->
                    <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg">
                        <div class="coupon-card">
                            <!-- Replace this div content with your custom Tailwind designs -->
                            <div class="coupon-background relative h-44 w-full">
                                <!-- Your new Tailwind code goes here -->
                                <div class="relative w-full h-full bg-black rounded-t-lg overflow-hidden">
                                    <!-- Holographic background -->
                                    <div
                                        class="absolute inset-0 bg-gradient-to-r from-purple-600 via-blue-500 via-green-400 via-yellow-400 via-red-500 to-purple-600 opacity-30 animate-pulse">
                                    </div>

                                    <!-- Prismatic overlay -->
                                    <div class="absolute inset-0"
                                        style="background: conic-gradient(from 0deg, #ff0080, #00ff80, #8000ff, #ff8000, #0080ff, #ff0080); opacity: 0.1;">
                                    </div>

                                    <!-- Content -->
                                    <div class="relative flex items-center justify-center h-full">
                                        <div class="text-center">
                                            <!-- Holographic text -->
                                            <h1
                                                class="text-4xl md:text-5xl font-black tracking-wider select-none relative">
                                                <span
                                                    class="absolute inset-0 bg-gradient-to-r from-pink-400 via-cyan-400 via-purple-400 to-pink-400 bg-clip-text text-transparent animate-pulse">
                                                    FLASH50
                                                </span>
                                                <span
                                                    class="bg-gradient-to-r from-white via-blue-200 to-white bg-clip-text text-transparent"
                                                    style="text-shadow: 0 0 30px rgba(255,255,255,0.5);">
                                                    FLASH50
                                                </span>
                                            </h1>

                                            <!-- Rainbow reflection line -->
                                            <div
                                                class="mt-2 h-1 w-24 mx-auto rounded-full bg-gradient-to-r from-purple-500 via-blue-500 via-green-400 via-yellow-400 to-red-500 opacity-60 blur-sm">
                                            </div>

                                            <!-- Floating particles -->
                                            <div
                                                class="absolute top-1/4 left-1/4 w-1 h-1 bg-white rounded-full animate-ping">
                                            </div>
                                            <div
                                                class="absolute top-3/4 right-1/3 w-1 h-1 bg-cyan-400 rounded-full animate-ping animation-delay-300">
                                            </div>
                                            <div
                                                class="absolute bottom-1/4 left-1/2 w-1 h-1 bg-purple-400 rounded-full animate-ping animation-delay-700">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="coupon-content p-4 relative">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <span class="status-badge status-active">Active</span>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" class="mr-2">
                                    </div>
                                </div>
                                <div class="absolute bottom-4 left-4">
                                    <h3 class="text-xl font-bold text-white">FLASH50</h3>
                                    <p class="text-gray-300 mt-1">Off 50%</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 bg-gray-800">
                            <div class="flex justify-between text-sm mb-3">
                                <div>
                                    <p class="text-gray-400">Valid Until</p>
                                    <p>Jun 7, 2025</p>
                                </div>
                                <div class="text-left">
                                    <p class="text-gray-400">Valid From</p>
                                    <p>Jun 5, 2025</p>
                                </div>
                            </div>
                            <div class="flex justify-between text-sm">
                                <div>
                                    <p class="text-gray-400">Used</p>
                                    <p>89</p>
                                </div>
                                <div class="text-left">
                                    <p class="text-gray-400">Usage Limit</p>
                                    <p>200</p>
                                </div>
                            </div>
                            <div class="mt-3 flex justify-between items-center">
                                <span
                                    class="text-xs bg-orange-900 text-orange-300 px-3 py-1 rounded-full">Percentage</span>
                                <div class="flex space-x-2">
                                    <button  onclick="openCouponModal()" class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-300">
                                            <i class="ri-edit-line"></i>
                                        </div>
                                    </button>
                                    <button class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-300">
                                            <i class="ri-delete-bin-line"></i>
                                        </div>
                                    </button>
                                    <button class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-300">
                                            <i class="ri-file-copy-line"></i>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>


                     {{-- <button class="coupon-open-modal-gradient fixed bottom-8 left-8 text-white border-none w-14 h-14 rounded-full cursor-pointer shadow-lg transition-all duration-300 hover:scale-110 hover:shadow-xl z-50 flex items-center justify-center" onclick="openCouponModal()">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </button> --}}

                    {{-- coupon --}}
                    <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg">
                        <div class="coupon-card">
                            <!-- Replace this div content with your custom Tailwind designs -->
                            <div
                                class="relative  h-44  w-full mx-auto bg-gradient-to-b from-purple-900 via-pink-900 to-blackerflow-hidden shadow-2xl">
                                <!-- Grid lines -->
                                <div class="absolute inset-0"
                                    style="background-image: linear-gradient(rgba(236, 72, 153, 0.3) 1px, transparent 1px), linear-gradient(90deg, rgba(236, 72, 153, 0.3) 1px, transparent 1px); background-size: 30px 30px;">
                                </div>

                                <!-- Horizon line -->
                                <div
                                    class="absolute bottom-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-pink-500 to-transparent">
                                </div>

                                <!-- Sun -->
                                <div
                                    class="absolute bottom-16 left-1/2 transform -translate-x-1/2 w-32 h-32 bg-gradient-radial from-yellow-400 via-orange-500 to-pink-600 rounded-full opacity-80">
                                </div>

                                <!-- Content -->
                                <div class="relative flex items-center justify-center h-full">
                                    <div class="text-center">
                                        <!-- Retro text with chrome effect -->
                                        <h1 class="text-xl md:text-5xl font-black text-transparent bg-gradient-to-b from-pink-300 via-purple-400 to-cyan-400 bg-clip-text tracking-wider mb-4 transform perspective-1000 rotateX-12"
                                            style="text-shadow: 0 1px 0 #c084fc, 0 2px 0 #a855f7, 0 3px 0 #9333ea, 0 4px 0 #7c3aed, 0 5px 0 #6d28d9, 0 6px 1px rgba(0,0,0,.1), 0 0 5px rgba(0,0,0,.1), 0 1px 3px rgba(0,0,0,.3), 0 3px 5px rgba(0,0,0,.2), 0 5px 10px rgba(0,0,0,.25);">
                                            AABCCN
                                        </h1>

                                        <!-- Retro subtitle -->
                                        <div
                                            class="text-cyan-400 font-mono text-xl tracking-widest opacity-80 animate-pulse">
                                            ::::: RETRO WAVE :::::
                                        </div>

                                        <!-- Scan lines -->
                                        <div class="absolute inset-0 pointer-events-none"
                                            style="background: repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(255,255,255,0.03) 2px, rgba(255,255,255,0.03) 4px);">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="coupon-content p-4 relative">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <span class="status-badge status-active">Active</span>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" class="mr-2">
                                    </div>
                                </div>
                                <div class="absolute bottom-4 left-4">
                                    <h3 class="text-xl font-bold text-white">FLASH50</h3>
                                    <p class="text-gray-300 mt-1">Off 50%</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 bg-gray-800">
                            <div class="flex justify-between text-sm mb-3">
                                <div>
                                    <p class="text-gray-400">Valid Until</p>
                                    <p>Jun 7, 2025</p>
                                </div>
                                <div class="text-left">
                                    <p class="text-gray-400">Valid From</p>
                                    <p>Jun 5, 2025</p>
                                </div>
                            </div>
                            <div class="flex justify-between text-sm">
                                <div>
                                    <p class="text-gray-400">Used</p>
                                    <p>89</p>
                                </div>
                                <div class="text-left">
                                    <p class="text-gray-400">Usage Limit</p>
                                    <p>200</p>
                                </div>
                            </div>
                            <div class="mt-3 flex justify-between items-center">
                                <span
                                    class="text-xs bg-orange-900 text-orange-300 px-3 py-1 rounded-full">Percentage</span>
                                <div class="flex space-x-2">
                                    <button class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-300">
                                            <i class="ri-edit-line"></i>
                                        </div>
                                    </button>
                                    <button class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-300">
                                            <i class="ri-delete-bin-line"></i>
                                        </div>
                                    </button>
                                    <button class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-300">
                                            <i class="ri-file-copy-line"></i>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>



                    {{-- coupon Option 10: Marble Texture --}}
                    <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg">
                        <div class="coupon-card">
                            <!-- Replace this div content with your custom Tailwind designs -->
                            {{-- <div
                                class="relative  h-44  w-full mx-auto bg-gradient-to-b from-purple-900 via-pink-900 to-blackerflow-hidden shadow-2xl">
                                <!-- Grid lines -->
                                <div class="absolute inset-0"
                                    style="background-image: linear-gradient(rgba(236, 72, 153, 0.3) 1px, transparent 1px), linear-gradient(90deg, rgba(236, 72, 153, 0.3) 1px, transparent 1px); background-size: 30px 30px;">
                                </div>

                                <!-- Horizon line -->
                                <div
                                    class="absolute bottom-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-pink-500 to-transparent">
                                </div>

                                <!-- Sun -->
                                <div
                                    class="absolute bottom-16 left-1/2 transform -translate-x-1/2 w-32 h-32 bg-gradient-radial from-yellow-400 via-orange-500 to-pink-600 rounded-full opacity-80">
                                </div>

                                <!-- Content -->
                                <div class="relative flex items-center justify-center h-full">
                                    <div class="text-center">
                                        <!-- Retro text with chrome effect -->
                                        <h1 class="text-xl md:text-5xl font-black text-transparent bg-gradient-to-b from-pink-300 via-purple-400 to-cyan-400 bg-clip-text tracking-wider mb-4 transform perspective-1000 rotateX-12"
                                            style="text-shadow: 0 1px 0 #c084fc, 0 2px 0 #a855f7, 0 3px 0 #9333ea, 0 4px 0 #7c3aed, 0 5px 0 #6d28d9, 0 6px 1px rgba(0,0,0,.1), 0 0 5px rgba(0,0,0,.1), 0 1px 3px rgba(0,0,0,.3), 0 3px 5px rgba(0,0,0,.2), 0 5px 10px rgba(0,0,0,.25);">
                                            AABCCN
                                        </h1>

                                        <!-- Retro subtitle -->
                                        <div
                                            class="text-cyan-400 font-mono text-xl tracking-widest opacity-80 animate-pulse">
                                            ::::: RETRO WAVE :::::
                                        </div>

                                        <!-- Scan lines -->
                                        <div class="absolute inset-0 pointer-events-none"
                                            style="background: repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(255,255,255,0.03) 2px, rgba(255,255,255,0.03) 4px);">
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div
                                class="relative w-full  h-44 mx-auto bg-gradient-to-br from-gray-100 via-gray-200 to-gray-300  shadow-2xl overflow-hidden">
                                <!-- Marble veining -->
                                <div class="absolute inset-0 opacity-40">
                                    <div
                                        class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-gray-600 to-transparent transform rotate-12 scale-150">
                                    </div>
                                    <div
                                        class="absolute top-12 left-0 w-full h-px bg-gradient-to-r from-gray-500 via-transparent to-gray-600 transform -rotate-6 scale-125">
                                    </div>
                                    <div
                                        class="absolute top-24 left-0 w-full h-px bg-gradient-to-r from-transparent via-gray-700 to-gray-500 transform rotate-3 scale-110">
                                    </div>
                                    <div
                                        class="absolute bottom-16 left-0 w-full h-px bg-gradient-to-r from-gray-600 via-gray-400 to-transparent transform -rotate-12 scale-140">
                                    </div>
                                </div>

                                <!-- Marble highlights -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-tr from-white/30 via-transparent to-white/20">
                                </div>

                                <!-- Content -->
                                <div class="relative flex items-center justify-center h-full">
                                    <div class="text-center">
                                        <!-- Engraved text effect -->
                                        <h1 class="text-7xl md:text-6xl font-bold tracking-wider relative">
                                            <!-- Engraved shadow -->
                                            <span
                                                class="absolute inset-0 text-gray-400 transform translate-x-1 translate-y-1">AABCCN</span>

                                            <!-- Main text -->
                                            <span class="relative text-gray-700"
                                                style="text-shadow: -1px -1px 0 rgba(255,255,255,0.8), 1px 1px 2px rgba(0,0,0,0.3);">
                                                AABCCN
                                            </span>
                                        </h1>

                                        <!-- Decorative elements -->
                                        <div class="mt-8 flex justify-center items-center space-x-4">
                                            <div class="w-8 h-px bg-gradient-to-r from-transparent to-gray-500"></div>
                                            <div class="w-2 h-2 bg-gray-600 rounded-full"></div>
                                            <div class="w-8 h-px bg-gradient-to-l from-transparent to-gray-500"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Marble polish shine -->
                                <div class="absolute top-8 left-8 w-32 h-32 bg-white/20 rounded-full blur-3xl"></div>
                            </div>



                            <div class="coupon-content p-4 relative">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <span class="status-badge status-active">Active</span>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" class="mr-2">
                                    </div>
                                </div>
                                <div class="absolute bottom-4 left-4">
                                    <h3 class="text-xl font-bold text-white">FLASH50</h3>
                                    <p class="text-gray-300 mt-1">Off 50%</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 bg-gray-800">
                            <div class="flex justify-between text-sm mb-3">
                                <div>
                                    <p class="text-gray-400">Valid Until</p>
                                    <p>Jun 7, 2025</p>
                                </div>
                                <div class="text-left">
                                    <p class="text-gray-400">Valid From</p>
                                    <p>Jun 5, 2025</p>
                                </div>
                            </div>
                            <div class="flex justify-between text-sm">
                                <div>
                                    <p class="text-gray-400">Used</p>
                                    <p>89</p>
                                </div>
                                <div class="text-left">
                                    <p class="text-gray-400">Usage Limit</p>
                                    <p>200</p>
                                </div>
                            </div>
                            <div class="mt-3 flex justify-between items-center">
                                <span
                                    class="text-xs bg-orange-900 text-orange-300 px-3 py-1 rounded-full">Percentage</span>
                                <div class="flex space-x-2">
                                    <button class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-300">
                                            <i class="ri-edit-line"></i>
                                        </div>
                                    </button>
                                    <button class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-300">
                                            <i class="ri-delete-bin-line"></i>
                                        </div>
                                    </button>
                                    <button class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-300">
                                            <i class="ri-file-copy-line"></i>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>



                    {{-- coupon Option 9: Cosmic Nebula --}}
                    <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg">
                        <div class="coupon-card">
                            <!-- Replace this div content with your custom Tailwind designs -->

                            <div class="relative w-full  h-44 mx-auto bg-black overflow-hidden shadow-2xl">
                                <!-- Nebula background -->
                                <div
                                    class="absolute inset-0 bg-gradient-radial from-purple-600/40 via-blue-800/30 to-transparent">
                                </div>
                                <div
                                    class="absolute top-0 right-0 w-2/3 h-2/3 bg-gradient-radial from-pink-500/30 via-red-600/20 to-transparent">
                                </div>
                                <div
                                    class="absolute bottom-0 left-0 w-1/2 h-1/2 bg-gradient-radial from-cyan-400/40 via-blue-500/20 to-transparent">
                                </div>

                                <!-- Stars -->
                                <div class="absolute top-12 left-16 w-1 h-1 bg-white rounded-full animate-twinkle">
                                </div>
                                <div
                                    class="absolute top-20 right-24 w-px h-px bg-yellow-300 rounded-full animate-twinkle-delayed">
                                </div>
                                <div
                                    class="absolute bottom-16 left-32 w-1 h-1 bg-blue-200 rounded-full animate-twinkle-slow">
                                </div>
                                <div class="absolute top-32 left-2/3 w-px h-px bg-white rounded-full animate-twinkle">
                                </div>
                                <div
                                    class="absolute bottom-24 right-16 w-1 h-1 bg-purple-200 rounded-full animate-twinkle-delayed">
                                </div>

                                <!-- Content -->
                                <div class="relative flex items-center justify-center h-full">
                                    <div class="text-center">
                                        <!-- Cosmic text -->
                                        <h1 class="text-8xl md:text-6xl font-black tracking-widest relative">
                                            <!-- Glow effect -->
                                            <span
                                                class="absolute inset-0 text-transparent bg-gradient-to-r from-purple-400 via-pink-400 to-cyan-400 bg-clip-text blur-sm">
                                                AABCCN
                                            </span>

                                            <!-- Main text -->
                                            <span
                                                class="relative bg-gradient-to-r from-purple-300 via-pink-300 to-cyan-300 bg-clip-text text-transparent"
                                                style="text-shadow: 0 0 20px rgba(147, 51, 234, 0.5), 0 0 40px rgba(147, 51, 234, 0.3);">
                                                AABCCN
                                            </span>
                                        </h1>

                                        <!-- Cosmic dust trail -->
                                        <div
                                            class="mt-8 h-px w-64 mx-auto bg-gradient-to-r from-transparent via-purple-400 via-pink-400 via-cyan-400 to-transparent opacity-60 animate-pulse">
                                        </div>

                                        <!-- Orbital rings -->
                                        <div
                                            class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 border border-purple-400/20 rounded-full animate-spin-slow">
                                        </div>
                                        <div
                                            class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 border border-pink-400/15 rounded-full animate-spin-reverse">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <style>
                                @keyframes twinkle {

                                    0%,
                                    100% {
                                        opacity: 0.3;
                                    }

                                    50% {
                                        opacity: 1;
                                    }
                                }

                                @keyframes twinkle-delayed {

                                    0%,
                                    100% {
                                        opacity: 0.5;
                                    }

                                    50% {
                                        opacity: 1;
                                    }
                                }

                                @keyframes twinkle-slow {

                                    0%,
                                    100% {
                                        opacity: 0.2;
                                    }

                                    50% {
                                        opacity: 0.8;
                                    }
                                }

                                @keyframes spin-slow {
                                    from {
                                        transform: translate(-50%, -50%) rotate(0deg);
                                    }

                                    to {
                                        transform: translate(-50%, -50%) rotate(360deg);
                                    }
                                }

                                @keyframes spin-reverse {
                                    from {
                                        transform: translate(-50%, -50%) rotate(360deg);
                                    }

                                    to {
                                        transform: translate(-50%, -50%) rotate(0deg);
                                    }
                                }

                                .animate-twinkle {
                                    animation: twinkle 2s ease-in-out infinite;
                                }

                                .animate-twinkle-delayed {
                                    animation: twinkle-delayed 3s ease-in-out infinite 1s;
                                }

                                .animate-twinkle-slow {
                                    animation: twinkle-slow 4s ease-in-out infinite 2s;
                                }

                                .animate-spin-slow {
                                    animation: spin-slow 20s linear infinite;
                                }

                                .animate-spin-reverse {
                                    animation: spin-reverse 15s linear infinite;
                                }
                            </style>



                            <div class="coupon-content p-4 relative">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <span class="status-badge status-active">Active</span>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" class="mr-2">
                                    </div>
                                </div>
                                <div class="absolute bottom-4 left-4">
                                    <h3 class="text-xl font-bold text-white">FLASH50</h3>
                                    <p class="text-gray-300 mt-1">Off 50%</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 bg-gray-800">
                            <div class="flex justify-between text-sm mb-3">
                                <div>
                                    <p class="text-gray-400">Valid Until</p>
                                    <p>Jun 7, 2025</p>
                                </div>
                                <div class="text-left">
                                    <p class="text-gray-400">Valid From</p>
                                    <p>Jun 5, 2025</p>
                                </div>
                            </div>
                            <div class="flex justify-between text-sm">
                                <div>
                                    <p class="text-gray-400">Used</p>
                                    <p>89</p>
                                </div>
                                <div class="text-left">
                                    <p class="text-gray-400">Usage Limit</p>
                                    <p>200</p>
                                </div>
                            </div>
                            <div class="mt-3 flex justify-between items-center">
                                <span
                                    class="text-xs bg-orange-900 text-orange-300 px-3 py-1 rounded-full">Percentage</span>
                                <div class="flex space-x-2">
                                    <button class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-300">
                                            <i class="ri-edit-line"></i>
                                        </div>
                                    </button>
                                    <button class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-300">
                                            <i class="ri-delete-bin-line"></i>
                                        </div>
                                    </button>
                                    <button class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-300">
                                            <i class="ri-file-copy-line"></i>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- coupon Option 8: Paper Cut Art Style --}}
                    <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg">
                        <div class="coupon-card">
                            <!-- Replace this div content with your custom Tailwind designs -->

                            <div
                                class="relative w-full  h-44 mx-auto bg-gradient-to-br from-blue-50 to-indigo-100  shadow-2xl overflow-hidden">
                                <!-- Paper layers background -->
                                <div
                                    class="absolute top-8 left-8 w-48 h-32 bg-rose-200 rounded-2xl transform rotate-12 shadow-lg opacity-60">
                                </div>
                                <div
                                    class="absolute top-16 right-12 w-40 h-40 bg-emerald-200 rounded-full shadow-lg opacity-50">
                                </div>
                                <div
                                    class="absolute bottom-12 left-16 w-56 h-24 bg-amber-200 rounded-3xl transform -rotate-6 shadow-lg opacity-70">
                                </div>

                                <!-- Main paper layer -->
                                <div class="absolute inset-8 bg-white rounded-2xl shadow-xl">
                                    <!-- Paper texture -->
                                    <div class="absolute inset-0 opacity-10"
                                        style="background-image: radial-gradient(circle at 25% 25%, #000 1px, transparent 1px), radial-gradient(circle at 75% 75%, #000 1px, transparent 1px); background-size: 20px 20px;">
                                    </div>

                                    <!-- Content -->
                                    <div class="relative flex items-center justify-center h-full">
                                        <div class="text-center">
                                            <!-- Paper cut text effect -->
                                            <h1
                                                class="text-6xl md:text-6l font-black text-gray-800 tracking-wide relative">
                                                <!-- Multiple shadow layers for paper cut effect -->
                                                <span
                                                    class="absolute inset-0 text-rose-300 transform translate-x-1 translate-y-1">AABCCN</span>
                                                <span
                                                    class="absolute inset-0 text-emerald-300 transform translate-x-2 translate-y-2">AABCCN</span>
                                                <span
                                                    class="absolute inset-0 text-amber-300 transform translate-x-3 translate-y-3">AABCCN</span>
                                                <span class="relative z-10">AABCCN</span>
                                            </h1>

                                            <!-- Paper craft details -->
                                            <div class="mt-8 flex justify-center space-x-4">
                                                <div class="w-3 h-3 bg-rose-400 rounded-full shadow-sm"></div>
                                                {{-- <div class="w-3 h-3 bg-emerald-400 rounded-full shadow-sm"></div>
                                                --}}
                                                <div class="w-3 h-3 bg-amber-400 rounded-full shadow-sm"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Paper fold lines -->
                                <div
                                    class="absolute top-0 left-1/3 w-px h-full bg-gradient-to-b from-transparent via-gray-300 to-transparent opacity-30">
                                </div>
                                <div
                                    class="absolute top-1/3 left-0 w-full h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent opacity-30">
                                </div>
                            </div>


                            <div class="coupon-content p-4 relative">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <span class="status-badge status-active">Active</span>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" class="mr-2">
                                    </div>
                                </div>
                                <div class="absolute bottom-4 left-4">
                                    <h3 class="text-xl font-bold text-white">FLASH50</h3>
                                    <p class="text-gray-300 mt-1">Off 50%</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 bg-gray-800">
                            <div class="flex justify-between text-sm mb-3">
                                <div>
                                    <p class="text-gray-400">Valid Until</p>
                                    <p>Jun 7, 2025</p>
                                </div>
                                <div class="text-left">
                                    <p class="text-gray-400">Valid From</p>
                                    <p>Jun 5, 2025</p>
                                </div>
                            </div>
                            <div class="flex justify-between text-sm">
                                <div>
                                    <p class="text-gray-400">Used</p>
                                    <p>89</p>
                                </div>
                                <div class="text-left">
                                    <p class="text-gray-400">Usage Limit</p>
                                    <p>200</p>
                                </div>
                            </div>
                            <div class="mt-3 flex justify-between items-center">
                                <span
                                    class="text-xs bg-orange-900 text-orange-300 px-3 py-1 rounded-full">Percentage</span>
                                <div class="flex space-x-2">
                                    <button class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-300">
                                            <i class="ri-edit-line"></i>
                                        </div>
                                    </button>
                                    <button class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-300">
                                            <i class="ri-delete-bin-line"></i>
                                        </div>
                                    </button>
                                    <button class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-300">
                                            <i class="ri-file-copy-line"></i>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>




                    {{-- coupon Option 1: Glassmorphism with Animated Gradient--}}
                    {{-- <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg">
                        <div class="coupon-card">
                            <!-- Replace this div content with your custom Tailwind designs -->


                            <div class="relative w-full  h-44 mx-auto overflow-hidden  shadow-2xl">
                                <!-- Animated gradient background -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-br from-violet-600 via-blue-600 to-cyan-400 animate-pulse">
                                </div>

                                <!-- Glass overlay -->
                                <div class="absolute inset-0 backdrop-blur-sm bg-white/10 border border-white/20">
                                    <!-- Decorative elements -->
                                    <div class="absolute top-6 right-6 w-20 h-20 bg-white/5 rounded-full blur-xl"></div>
                                    <div
                                        class="absolute bottom-8 left-8 w-32 h-32 bg-purple-300/10 rounded-full blur-2xl">
                                    </div>

                                    <!-- Text container -->
                                    <div class="flex items-center justify-center h-full">
                                        <div class="text-center">
                                            <h1
                                                class="text-6xl md:text-6xl font-black text-white tracking-wider mb-4 drop-shadow-2xl transform hover:scale-105 transition-transform duration-300">
                                                AABCCN
                                            </h1>
                                            <div
                                                class="h-1 w-32 bg-gradient-to-r from-transparent via-white to-transparent mx-auto opacity-60">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>





                            <div class="coupon-content p-4 relative">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <span class="status-badge status-active">Active</span>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" class="mr-2">
                                    </div>
                                </div>
                                <div class="absolute bottom-4 left-4">
                                    <h3 class="text-xl font-bold text-white">FLASH50</h3>
                                    <p class="text-gray-300 mt-1">Off 50%</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 bg-gray-800">
                            <div class="flex justify-between text-sm mb-3">
                                <div>
                                    <p class="text-gray-400">Valid Until</p>
                                    <p>Jun 7, 2025</p>
                                </div>
                                <div class="text-left">
                                    <p class="text-gray-400">Valid From</p>
                                    <p>Jun 5, 2025</p>
                                </div>
                            </div>
                            <div class="flex justify-between text-sm">
                                <div>
                                    <p class="text-gray-400">Used</p>
                                    <p>89</p>
                                </div>
                                <div class="text-left">
                                    <p class="text-gray-400">Usage Limit</p>
                                    <p>200</p>
                                </div>
                            </div>
                            <div class="mt-3 flex justify-between items-center">
                                <span
                                    class="text-xs bg-orange-900 text-orange-300 px-3 py-1 rounded-full">Percentage</span>
                                <div class="flex space-x-2">
                                    <button class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-300">
                                            <i class="ri-edit-line"></i>
                                        </div>
                                    </button>
                                    <button class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-300">
                                            <i class="ri-delete-bin-line"></i>
                                        </div>
                                    </button>
                                    <button class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-300">
                                            <i class="ri-file-copy-line"></i>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div> --}}





                    {{-- coupon Option 2: Neon Cyberpunk Style --}}
                    {{-- <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg">
                        <div class="coupon-card">
                            <!-- Replace this div content with your custom Tailwind designs -->

                            <div
                                class="relative w-full  h-44 mx-auto overflow-hidden  bg-gray-900 border border-cyan-500/30 shadow-2xl shadow-cyan-500/20">
                                <!-- Grid pattern overlay -->
                                <div class="absolute inset-0 opacity-10"
                                    style="background-image: radial-gradient(circle, #06b6d4 1px, transparent 1px); background-size: 30px 30px;">
                                </div>

                                <!-- Neon glow effects -->
                                <div
                                    class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-transparent via-cyan-400 to-transparent opacity-60">
                                </div>
                                <div
                                    class="absolute bottom-0 left-0 w-full h-2 bg-gradient-to-r from-transparent via-purple-400 to-transparent opacity-60">
                                </div>

                                <!-- Content -->
                                <div class="relative flex items-center justify-center h-full">
                                    <div class="text-center">
                                        <!-- Main text with multiple shadows for neon effect -->
                                        <h1 class="text-7xl md:text-6xl font-bold text-cyan-300 tracking-widest mb-6 select-none"
                                            style="text-shadow: 0 0 10px #06b6d4, 0 0 20px #06b6d4, 0 0 40px #06b6d4, 0 0 80px #06b6d4;">
                                            AABCCN
                                        </h1>

                                        <!-- Subtitle -->
                                        <p class="text-gray-400 text-lg tracking-wider font-mono opacity-80">// DIGITAL
                                            MATRIX //</p>

                                        <!-- Animated underline -->
                                        <div
                                            class="mt-4 h-px bg-gradient-to-r from-transparent via-cyan-400 to-transparent animate-pulse">
                                        </div>
                                    </div>
                                </div>

                                <!-- Corner decorations -->
                                <div class="absolute top-4 left-4 w-8 h-8 border-l-2 border-t-2 border-cyan-400/60">
                                </div>
                                <div class="absolute top-4 right-4 w-8 h-8 border-r-2 border-t-2 border-cyan-400/60">
                                </div>
                                <div class="absolute bottom-4 left-4 w-8 h-8 border-l-2 border-b-2 border-cyan-400/60">
                                </div>
                                <div class="absolute bottom-4 right-4 w-8 h-8 border-r-2 border-b-2 border-cyan-400/60">
                                </div>
                            </div>




                            <div class="coupon-content p-4 relative">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <span class="status-badge status-active">Active</span>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" class="mr-2">
                                    </div>
                                </div>
                                <div class="absolute bottom-4 left-4">
                                    <h3 class="text-xl font-bold text-white">FLASH50</h3>
                                    <p class="text-gray-300 mt-1">Off 50%</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 bg-gray-800">
                            <div class="flex justify-between text-sm mb-3">
                                <div>
                                    <p class="text-gray-400">Valid Until</p>
                                    <p>Jun 7, 2025</p>
                                </div>
                                <div class="text-left">
                                    <p class="text-gray-400">Valid From</p>
                                    <p>Jun 5, 2025</p>
                                </div>
                            </div>
                            <div class="flex justify-between text-sm">
                                <div>
                                    <p class="text-gray-400">Used</p>
                                    <p>89</p>
                                </div>
                                <div class="text-left">
                                    <p class="text-gray-400">Usage Limit</p>
                                    <p>200</p>
                                </div>
                            </div>
                            <div class="mt-3 flex justify-between items-center">
                                <span
                                    class="text-xs bg-orange-900 text-orange-300 px-3 py-1 rounded-full">Percentage</span>
                                <div class="flex space-x-2">
                                    <button class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-300">
                                            <i class="ri-edit-line"></i>
                                        </div>
                                    </button>
                                    <button class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-300">
                                            <i class="ri-delete-bin-line"></i>
                                        </div>
                                    </button>
                                    <button class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-300">
                                            <i class="ri-file-copy-line"></i>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                  --}}




                    {{-- coupon Option 3: Luxury Card with 3D Effect --}}
                    {{-- <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg">
                        <div class="coupon-card">
                            <!-- Replace this div content with your custom Tailwind designs -->

                            <div class="relative w-full  h-44 mx-auto perspective-1000">
                                <div
                                    class="relative w-full h-full transform-gpu transition-transform duration-500 hover:rotateY-12 preserve-3d">
                                    <!-- Card background -->
                                    <div
                                        class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900  shadow-2xl overflow-hidden">
                                        <!-- Metallic texture overlay -->
                                        <div
                                            class="absolute inset-0 bg-gradient-to-br from-white/5 via-transparent to-black/20">
                                        </div>

                                        <!-- Animated light streak -->
                                        <div
                                            class="absolute -top-20 -left-20 w-40 h-40 bg-gradient-radial from-white/20 to-transparent rounded-full blur-3xl animate-pulse">
                                        </div>

                                        <!-- Content area -->
                                        <div class="relative flex items-center justify-center h-full p-8">
                                            <div class="text-center">
                                                <!-- Main text with gradient -->
                                                <h1
                                                    class="text-6xl md:text-6xl font-black bg-gradient-to-r from-amber-200 via-yellow-300 to-amber-200 bg-clip-text text-transparent tracking-wider mb-6 transform hover:scale-110 transition-transform duration-300">
                                                    AABCCN
                                                </h1>

                                                <!-- Decorative elements -->
                                                <div class="flex justify-center space-x-2 mb-4">
                                                    <div class="w-2 h-2 bg-amber-400 rounded-full animate-ping"></div>
                                                    <div
                                                        class="w-2 h-2 bg-amber-400 rounded-full animate-ping animation-delay-200">
                                                    </div>
                                                    <div
                                                        class="w-2 h-2 bg-amber-400 rounded-full animate-ping animation-delay-400">
                                                    </div>
                                                </div>

                                                <!-- Premium badge -->
                                                <div
                                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-amber-600/20 to-yellow-600/20 rounded-full border border-amber-400/30">
                                                    <span
                                                        class="text-amber-200 text-sm font-medium tracking-wide">PREMIUM
                                                        EDITION</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Edge highlights -->
                                        <div
                                            class="absolute inset-0 rounded-3xl border border-gradient-to-r from-transparent via-white/20 to-transparent pointer-events-none">
                                        </div>
                                    </div>
                                </div>
                            </div>




                            <div class="coupon-content p-4 relative">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <span class="status-badge status-active">Active</span>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" class="mr-2">
                                    </div>
                                </div>
                                <div class="absolute bottom-4 left-4">
                                    <h3 class="text-xl font-bold text-white">FLASH50</h3>
                                    <p class="text-gray-300 mt-1">Off 50%</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 bg-gray-800">
                            <div class="flex justify-between text-sm mb-3">
                                <div>
                                    <p class="text-gray-400">Valid Until</p>
                                    <p>Jun 7, 2025</p>
                                </div>
                                <div class="text-left">
                                    <p class="text-gray-400">Valid From</p>
                                    <p>Jun 5, 2025</p>
                                </div>
                            </div>
                            <div class="flex justify-between text-sm">
                                <div>
                                    <p class="text-gray-400">Used</p>
                                    <p>89</p>
                                </div>
                                <div class="text-left">
                                    <p class="text-gray-400">Usage Limit</p>
                                    <p>200</p>
                                </div>
                            </div>
                            <div class="mt-3 flex justify-between items-center">
                                <span
                                    class="text-xs bg-orange-900 text-orange-300 px-3 py-1 rounded-full">Percentage</span>
                                <div class="flex space-x-2">
                                    <button class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-300">
                                            <i class="ri-edit-line"></i>
                                        </div>
                                    </button>
                                    <button class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-300">
                                            <i class="ri-delete-bin-line"></i>
                                        </div>
                                    </button>
                                    <button class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-300">
                                            <i class="ri-file-copy-line"></i>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div> --}}




                    {{-- coupon Option 4: Minimalist with Floating Elements --}}
                    {{-- <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg">
                        <div class="coupon-card">
                            <!-- Replace this div content with your custom Tailwind designs -->

                            <div class="relative w-full m h-44 mx-auto bg-white  shadow-2xl overflow-hidden">
                                <!-- Floating geometric shapes -->
                                <div
                                    class="absolute top-8 left-12 w-16 h-16 bg-gradient-to-br from-rose-400 to-pink-500 rounded-2xl rotate-12 opacity-20 animate-float">
                                </div>
                                <div
                                    class="absolute top-20 right-16 w-12 h-12 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full opacity-30 animate-float-delayed">
                                </div>
                                <div
                                    class="absolute bottom-16 left-20 w-20 h-20 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-3xl -rotate-12 opacity-25 animate-float-slow">
                                </div>

                                <!-- Main content -->
                                <div class="relative flex items-center justify-center h-full">
                                    <div class="text-center">
                                        <!-- Text with subtle shadow -->
                                        <h1
                                            class="text-7xl md:text-6xl font-black text-gray-800 tracking-tight mb-4 leading-none">
                                            AABCCN
                                        </h1>

                                        <!-- Elegant underline -->
                                        <div
                                            class="w-24 h-1 bg-gradient-to-r from-gray-300 via-gray-600 to-gray-300 mx-auto rounded-full">
                                        </div>

                                        <!-- Minimal details -->
                                        <p class="text-gray-500 text-sm font-medium tracking-widest mt-6 uppercase">
                                            Modern Typography</p>
                                    </div>
                                </div>

                                <!-- Subtle gradient overlay -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-gray-50/50 to-transparent pointer-events-none">
                                </div>
                            </div>

                            <!-- Custom animations -->
                            <style>
                                @keyframes float {

                                    0%,
                                    100% {
                                        transform: translateY(0px) rotate(12deg);
                                    }

                                    50% {
                                        transform: translateY(-20px) rotate(12deg);
                                    }
                                }

                                @keyframes float-delayed {

                                    0%,
                                    100% {
                                        transform: translateY(0px);
                                    }

                                    50% {
                                        transform: translateY(-15px);
                                    }
                                }

                                @keyframes float-slow {

                                    0%,
                                    100% {
                                        transform: translateY(0px) rotate(-12deg);
                                    }

                                    50% {
                                        transform: translateY(-10px) rotate(-12deg);
                                    }
                                }

                                .animate-float {
                                    animation: float 3s ease-in-out infinite;
                                }

                                .animate-float-delayed {
                                    animation: float-delayed 4s ease-in-out infinite 1s;
                                }

                                .animate-float-slow {
                                    animation: float-slow 5s ease-in-out infinite 2s;
                                }
                            </style>









                            <div class="coupon-content p-4 relative">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <span class="status-badge status-active">Active</span>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" class="mr-2">
                                    </div>
                                </div>
                                <div class="absolute bottom-4 left-4">
                                    <h3 class="text-xl font-bold text-white">FLASH50</h3>
                                    <p class="text-gray-300 mt-1">Off 50%</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 bg-gray-800">
                            <div class="flex justify-between text-sm mb-3">
                                <div>
                                    <p class="text-gray-400">Valid Until</p>
                                    <p>Jun 7, 2025</p>
                                </div>
                                <div class="text-left">
                                    <p class="text-gray-400">Valid From</p>
                                    <p>Jun 5, 2025</p>
                                </div>
                            </div>
                            <div class="flex justify-between text-sm">
                                <div>
                                    <p class="text-gray-400">Used</p>
                                    <p>89</p>
                                </div>
                                <div class="text-left">
                                    <p class="text-gray-400">Usage Limit</p>
                                    <p>200</p>
                                </div>
                            </div>
                            <div class="mt-3 flex justify-between items-center">
                                <span
                                    class="text-xs bg-orange-900 text-orange-300 px-3 py-1 rounded-full">Percentage</span>
                                <div class="flex space-x-2">
                                    <button class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-300">
                                            <i class="ri-edit-line"></i>
                                        </div>
                                    </button>
                                    <button class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-300">
                                            <i class="ri-delete-bin-line"></i>
                                        </div>
                                    </button>
                                    <button class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-300">
                                            <i class="ri-file-copy-line"></i>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div> --}}



                    {{-- Option 6: Retro Synthwave --}}

                    {{-- <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg">
                        <div class="coupon-card">
                            <!-- Replace this div content with your custom Tailwind designs -->

                            <div class="relative w-full h-44 mx-auto overflow-hidden  shadow-2xl">
                                <!-- Liquid metal background -->
                                <div class="absolute inset-0 bg-gradient-to-br from-gray-700 via-gray-500 to-gray-800">
                                </div>

                                <!-- Metallic reflections -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-tr from-white/20 via-transparent to-white/10">
                                </div>
                                <div
                                    class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-transparent via-white/5 to-transparent transform rotate-45 scale-150">
                                </div>

                                <!-- Liquid ripples -->
                                <div
                                    class="absolute top-8 left-12 w-24 h-24 bg-white/10 rounded-full blur-xl animate-ping">
                                </div>
                                <div
                                    class="absolute bottom-12 right-16 w-32 h-32 bg-white/5 rounded-full blur-2xl animate-pulse">
                                </div>

                                <!-- Content -->
                                <div class="relative flex items-center justify-center h-full">
                                    <div class="text-center">
                                        <!-- Liquid metal text -->
                                        <h1 class="text-7xl md:text-6xl font-black tracking-wider select-none relative">
                                            <!-- Shadow layers for depth -->
                                            <span
                                                class="absolute inset-0 text-black/30 transform translate-x-2 translate-y-2">AABCCN</span>
                                            <span
                                                class="absolute inset-0 text-black/20 transform translate-x-4 translate-y-4">AABCCN</span>

                                            <!-- Main text with chrome gradient -->
                                            <span
                                                class="relative bg-gradient-to-b from-gray-100 via-gray-300 to-gray-600 bg-clip-text text-transparent"
                                                style="text-shadow: 0 1px 0 rgba(255,255,255,0.8), 0 2px 0 rgba(255,255,255,0.6), 0 3px 0 rgba(255,255,255,0.4);">
                                                AABCCN
                                            </span>
                                        </h1>

                                        <!-- Metallic accent line -->
                                        <div
                                            class="mt-6 h-1 w-40 mx-auto bg-gradient-to-r from-transparent via-gray-300 to-transparent rounded-full">
                                        </div>
                                    </div>
                                </div>

                                <!-- Edge highlight -->
                                <div class="absolute inset-0 rounded-3xl border border-white/20 pointer-events-none">
                                </div>
                            </div>




                            <div class="coupon-content p-4 relative">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <span class="status-badge status-active">Active</span>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" class="mr-2">
                                    </div>
                                </div>
                                <div class="absolute bottom-4 left-4">
                                    <h3 class="text-xl font-bold text-white">FLASH50</h3>
                                    <p class="text-gray-300 mt-1">Off 50%</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 bg-gray-800">
                            <div class="flex justify-between text-sm mb-3">
                                <div>
                                    <p class="text-gray-400">Valid Until</p>
                                    <p>Jun 7, 2025</p>
                                </div>
                                <div class="text-left">
                                    <p class="text-gray-400">Valid From</p>
                                    <p>Jun 5, 2025</p>
                                </div>
                            </div>
                            <div class="flex justify-between text-sm">
                                <div>
                                    <p class="text-gray-400">Used</p>
                                    <p>89</p>
                                </div>
                                <div class="text-left">
                                    <p class="text-gray-400">Usage Limit</p>
                                    <p>200</p>
                                </div>
                            </div>
                            <div class="mt-3 flex justify-between items-center">
                                <span
                                    class="text-xs bg-orange-900 text-orange-300 px-3 py-1 rounded-full">Percentage</span>
                                <div class="flex space-x-2">
                                    <button class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-300">
                                            <i class="ri-edit-line"></i>
                                        </div>
                                    </button>
                                    <button class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-300">
                                            <i class="ri-delete-bin-line"></i>
                                        </div>
                                    </button>
                                    <button class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center">
                                        <div class="w-4 h-4 flex items-center justify-center text-gray-300">
                                            <i class="ri-file-copy-line"></i>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div> --}}




















                </div>
                <!-- Pagination -->
                <div class="flex justify-center mt-8">
                    <nav class="flex items-center">
                        <button class="pagination-item mr-2 bg-gray-700">
                            <div class="w-5 h-5 flex items-center justify-center">
                                <i class="ri-arrow-left-s-line"></i>
                            </div>
                        </button>
                        <button class="pagination-item mr-2 bg-gray-700">3</button>
                        <button class="pagination-item mr-2 bg-gray-700">2</button>
                        <button class="pagination-item mr-2 active">1</button>
                        <button class="pagination-item bg-gray-700">
                            <div class="w-5 h-5 flex items-center justify-center">
                                <i class="ri-arrow-right-s-line"></i>
                            </div>
                        </button>
                    </nav>
                </div>
            </main>
        </div>











































   



































{{-- modal --}}



    <!-- Open Modal Button -->
    {{-- <button class="coupon-open-modal-gradient fixed bottom-8 left-8 text-white border-none w-14 h-14 rounded-full cursor-pointer shadow-lg transition-all duration-300 hover:scale-110 hover:shadow-xl z-50 flex items-center justify-center" onclick="openCouponModal()">
        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
    </button> --}}

   

    <!-- Wizard Guide Overlay -->
    {{-- <div id="couponWizardOverlay" class="coupon-wizard-overlay">
        <div id="couponWizardSpotlight" class="coupon-wizard-spotlight"></div>
        <div id="couponWizardTooltip" class="coupon-wizard-tooltip">
            <div class="coupon-wizard-header">
                <div class="coupon-wizard-icon" id="wizardStepIcon">1</div>
                <h3 class="coupon-wizard-title" id="wizardTitle">مرحباً بك في إعدادات الكوبون</h3>
            </div>
            <p class="coupon-wizard-description" id="wizardDescription">
                دعنا نأخذ جولة سريعة في نافذة إعدادات الكوبون لمساعدتك في فهم جميع الميزات المتاحة.
            </p>
            <div class="coupon-wizard-controls">
                <div class="coupon-wizard-progress">
                    <span id="wizardProgressText">1 / 6</span>
                    <div class="coupon-wizard-progress-bar">
                        <div class="coupon-wizard-progress-fill" id="wizardProgressFill" style="width: 16.67%"></div>
                    </div>
                </div>
                <div class="coupon-wizard-buttons">
                    <button class="coupon-wizard-btn coupon-wizard-btn-skip" onclick="skipWizard()">تخطي الجولة</button>
                    <button class="coupon-wizard-btn coupon-wizard-btn-prev" id="wizardPrevBtn" onclick="previousWizardStep()" style="display: none;">السابق</button>
                    <button class="coupon-wizard-btn coupon-wizard-btn-next" id="wizardNextBtn" onclick="nextWizardStep()">التالي</button>
                </div>
            </div>
        </div>
    </div> --}}

               <!-- Wizard Guide Floating Button -->
    {{-- <button class=" absolute right-100" onclick="startWizardGuide()" title="بدء الجولة المُوجهة">
        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </button> --}}








    <!-- Coupon Settings Modal -->
    <div id="couponModal" class="coupon-modal fixed inset-0 w-full h-full z-50 hidden items-center justify-center p-4">
        <div class="coupon-modal-content coupon-gradient-bg rounded-2xl w-full max-w-3xl max-h-[85vh] overflow-hidden shadow-2xl">
            <!-- Header -->
            <div class="coupon-header-gradient p-6 text-white relative" id="modalHeader">
                <button class="coupon-close-btn absolute top-4 left-4 text-white w-10 h-10 rounded-full cursor-pointer flex items-center justify-center" onclick="closeCouponModal()">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>


  


                <h2 class="text-2xl font-bold mb-2 bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent rtl-text">إعدادات الكوبون</h2>
                <p class="opacity-90 text-sm text-gray-300 rtl-text">قم بتكوين كوبون التخفيض السريع الخاص بك</p>
            </div>

            <!-- Body -->
            <div class="coupon-scrollbar p-6 max-h-[60vh] overflow-y-auto" id="modalBody">
                <form>
                    <!-- Basic Settings Section -->
                    <div class="coupon-section-card" id="basicSettings">
                        <h3 class="text-white text-lg font-bold mb-4 flex items-center rtl-text">
                            <div class="coupon-section-indicator-1 w-2 h-6 rounded-full ml-3"></div>
                            الإعدادات الأساسية
                        </h3>
                        
                        <!-- Coupon Code & Active Status -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-300 text-xs font-semibold mb-2 rtl-text">رمز الكوبون</label>
                                <input type="text" value="FLASH50" class="coupon-input w-full p-3 rounded-xl text-sm">
                            </div>
                            <div>
                                <label class="block text-gray-300 text-xs font-semibold mb-2 rtl-text">الحالة</label>
                                <div class="coupon-glass flex items-center justify-between p-3 rounded-xl">
                                    <span class="text-white text-sm font-medium rtl-text">نشط</span>
                                    <div class="coupon-toggle active" onclick="toggleSwitch(this)">
                                        <div class="coupon-toggle-thumb"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Dates -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-300 text-xs font-semibold mb-2 rtl-text">تاريخ البداية</label>
                                <input type="datetime-local" value="2025-06-05T00:00" class="coupon-input w-full p-3 rounded-xl text-sm">
                            </div>
                            <div>
                                <label class="block text-gray-300 text-xs font-semibold mb-2 rtl-text">تاريخ النهاية</label>
                                <input type="datetime-local" value="2025-06-07T23:59" class="coupon-input w-full p-3 rounded-xl text-sm">
                            </div>
                        </div>

                        <!-- Limits -->
                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <label class="block text-gray-300 text-xs font-semibold mb-2 rtl-text">الحد الأقصى للاستخدام</label>
                                <input type="number" value="200" class="coupon-input w-full p-3 rounded-xl text-sm" id="maxUses">
                            </div>
                            <div>
                                <label class="block text-gray-300 text-xs font-semibold mb-2 rtl-text">المُستخدم</label>
                                <input type="number" value="89" readonly class="coupon-input w-full p-3 rounded-xl text-sm opacity-60 cursor-not-allowed" id="usedCount">
                            </div>
                            <div>
                                <label class="block text-gray-300 text-xs font-semibold mb-2 rtl-text">مدة البقاء (ث)</label>
                                <input type="number" value="300" class="coupon-input w-full p-3 rounded-xl text-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Discount Settings -->
                    <div class="coupon-section-card" id="discountSettings">
                        <h3 class="text-white text-lg font-bold mb-4 flex items-center rtl-text">
                            <div class="coupon-section-indicator-2 w-2 h-6 rounded-full ml-3"></div>
                            إعدادات الخصم
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-300 text-xs font-semibold mb-2 rtl-text">النوع</label>
                                <select class="coupon-select w-full p-3 rounded-xl text-sm cursor-pointer">
                                    <option value="percentage">نسبة مئوية</option>
                                    <option value="fixed">مبلغ ثابت</option>
                                    <option value="free_shipping">شحن مجاني</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-300 text-xs font-semibold mb-2 rtl-text">القيمة</label>
                                <input type="number" value="50" class="coupon-input w-full p-3 rounded-xl text-sm">
                            </div>
                            <div>
                                <label class="block text-gray-300 text-xs font-semibold mb-2 rtl-text">الحد الأدنى للطلب</label>
                                <input type="number" value="100" class="coupon-input w-full p-3 rounded-xl text-sm">
                            </div>
                            <div>
                                <label class="block text-gray-300 text-xs font-semibold mb-2 rtl-text">الحد الأقصى للخصم</label>
                                <input type="number" value="500" class="coupon-input w-full p-3 rounded-xl text-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Categories & Products -->
                    <div class="coupon-section-card" id="categoriesProducts">
                        <h3 class="text-white text-lg font-bold mb-4 flex items-center rtl-text">
                            <div class="coupon-section-indicator-3 w-2 h-6 rounded-full ml-3"></div>
                            الفئات والمنتجات
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-300 text-xs font-semibold mb-2 rtl-text">الفئات</label>
                                <div class="relative mb-3">
                                    <input type="text" placeholder="البحث في الفئات..." class="coupon-input w-full p-3 pl-10 rounded-xl text-sm" id="categorySearch" onkeyup="filterCategories()">
                                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 search-icon-container">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex flex-wrap gap-2" id="selectedCategories">
                                    <span class="coupon-tag px-3 py-1 rounded-full text-xs" data-category="electronics">
                                        الإلكترونيات
                                        <span class="coupon-tag-remove" onclick="removeCategory('electronics')">×</span>
                                    </span>
                                    <span class="coupon-tag px-3 py-1 rounded-full text-xs" data-category="fashion">
                                        الأزياء
                                        <span class="coupon-tag-remove" onclick="removeCategory('fashion')">×</span>
                                    </span>
                                </div>
                                <div class="mt-2 space-y-1 max-h-32 overflow-y-auto coupon-scrollbar" id="categoryList">
                                    <div class="coupon-checkbox-card flex items-center p-2 rounded-lg cursor-pointer text-sm" onclick="addCategory('home-garden', 'المنزل والحديقة')">
                                        <span class="text-white rtl-text">المنزل والحديقة</span>
                                    </div>
                                    <div class="coupon-checkbox-card flex items-center p-2 rounded-lg cursor-pointer text-sm" onclick="addCategory('sports', 'الرياضة والهواء الطلق')">
                                        <span class="text-white rtl-text">الرياضة والهواء الطلق</span>
                                    </div>
                                    <div class="coupon-checkbox-card flex items-center p-2 rounded-lg cursor-pointer text-sm" onclick="addCategory('books', 'الكتب والوسائط')">
                                        <span class="text-white rtl-text">الكتب والوسائط</span>
                                    </div>
                                    <div class="coupon-checkbox-card flex items-center p-2 rounded-lg cursor-pointer text-sm" onclick="addCategory('automotive', 'السيارات')">
                                        <span class="text-white rtl-text">السيارات</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-gray-300 text-xs font-semibold mb-2 rtl-text">المنتجات</label>
                                <div class="relative mb-3">
                                    <input type="text" placeholder="البحث في المنتجات..." class="coupon-input w-full p-3 pl-10 rounded-xl text-sm" id="productSearch" onkeyup="filterProducts()">
                                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 search-icon-container">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex flex-wrap gap-2" id="selectedProducts">
                                    <span class="coupon-tag px-3 py-1 rounded-full text-xs" data-product="iphone-15">
                                        آيفون 15
                                        <span class="coupon-tag-remove" onclick="removeProduct('iphone-15')">×</span>
                                    </span>
                                    <span class="coupon-tag px-3 py-1 rounded-full text-xs" data-product="macbook">
                                        ماك بوك
                                        <span class="coupon-tag-remove" onclick="removeProduct('macbook')">×</span>
                                    </span>
                                </div>
                                <div class="mt-2 space-y-1 max-h-32 overflow-y-auto coupon-scrollbar" id="productList">
                                    <div class="coupon-checkbox-card flex items-center p-2 rounded-lg cursor-pointer text-sm" onclick="addProduct('ipad-pro', 'آيباد برو')">
                                        <span class="text-white rtl-text">آيباد برو</span>
                                    </div>
                                    <div class="coupon-checkbox-card flex items-center p-2 rounded-lg cursor-pointer text-sm" onclick="addProduct('airpods', 'إيربودز برو')">
                                        <span class="text-white rtl-text">إيربودز برو</span>
                                    </div>
                                    <div class="coupon-checkbox-card flex items-center p-2 rounded-lg cursor-pointer text-sm" onclick="addProduct('samsung-tv', 'تلفزيون سامسونج 4K')">
                                        <span class="text-white rtl-text">تلفزيون سامسونج 4K</span>
                                    </div>
                                    <div class="coupon-checkbox-card flex items-center p-2 rounded-lg cursor-pointer text-sm" onclick="addProduct('nike-shoes', 'نايك إير ماكس')">
                                        <span class="text-white rtl-text">نايك إير ماكس</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Advanced Settings -->
                    <div class="coupon-section-card" id="advancedSettings">
                        <h3 class="text-white text-lg font-bold mb-4 flex items-center rtl-text">
                            <div class="coupon-section-indicator-4 w-2 h-6 rounded-full ml-3"></div>
                            الإعدادات المتقدمة
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-300 text-xs font-semibold mb-2 rtl-text">حد المستخدم الواحد</label>
                                <input type="number" value="1" class="coupon-input w-full p-3 rounded-xl text-sm">
                            </div>
                            <div>
                                <label class="block text-gray-300 text-xs font-semibold mb-2 rtl-text">الأولوية</label>
                                <select class="coupon-select w-full p-3 rounded-xl text-sm cursor-pointer">
                                    <option value="high">عالية</option>
                                    <option value="medium">متوسطة</option>
                                    <option value="low">منخفضة</option>
                                </select>
                            </div>
                        </div>

                        <!-- Feature Toggles -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="coupon-glass flex items-center justify-between p-3 rounded-xl">
                                <span class="text-white text-sm rtl-text">تطبيق تلقائي</span>
                                <div class="coupon-toggle" onclick="toggleSwitch(this)">
                                    <div class="coupon-toggle-thumb"></div>
                                </div>
                            </div>
                            <div class="coupon-glass flex items-center justify-between p-3 rounded-xl">
                                <span class="text-white text-sm rtl-text">تكديس الكوبونات</span>
                                <div class="coupon-toggle active" onclick="toggleSwitch(this)">
                                    <div class="coupon-toggle-thumb"></div>
                                </div>
                            </div>
                            <div class="coupon-glass flex items-center justify-between p-3 rounded-xl">
                                <span class="text-white text-sm rtl-text">إشعارات البريد الإلكتروني</span>
                                <div class="coupon-toggle active" onclick="toggleSwitch(this)">
                                    <div class="coupon-toggle-thumb"></div>
                                </div>
                            </div>
                            <div class="coupon-glass flex items-center justify-between p-3 rounded-xl">
                                <span class="text-white text-sm rtl-text">عرض في الصفحة الرئيسية</span>
                                <div class="coupon-toggle" onclick="toggleSwitch(this)">
                                    <div class="coupon-toggle-thumb"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Usage Statistics -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6" id="usageStats">
                        <div class="coupon-stat-card-1 p-4 rounded-xl">
                            <div class="text-xl font-bold mb-1 text-[#00e1c0] rtl-text" id="usageCount">89</div>
                            <div class="text-xs text-gray-400 rtl-text">مُستخدم</div>
                        </div>
                        <div class="coupon-stat-card-2 p-4 rounded-xl">
                            <div class="text-xl font-bold mb-1 text-green-400 rtl-text">12 ألف ر.س</div>
                            <div class="text-xs text-gray-400 rtl-text">وفورات</div>
                        </div>
                        <div class="coupon-stat-card-3 p-4 rounded-xl">
                            <div class="text-xl font-bold mb-1 text-orange-400 rtl-text" id="usageRate">44.5%</div>
                            <div class="text-xs text-gray-400 rtl-text">معدل</div>
                        </div>
                        <div class="coupon-stat-card-4 p-4 rounded-xl">
                            <div class="text-xl font-bold mb-1 text-purple-400 rtl-text">2ي 15س</div>
                            <div class="text-xs text-gray-400 rtl-text">متبقي</div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3" id="actionButtons">
                        <button type="submit" class="coupon-btn-primary flex-1 px-6 py-3 font-semibold rounded-xl transition-all rtl-text">حفظ الإعدادات</button>
                        <button type="button" class="coupon-btn-secondary flex-1 px-6 py-3 font-medium rounded-xl transition-all rtl-text">معاينة</button>
                        <button type="button" class="coupon-btn-secondary flex-1 px-6 py-3 font-medium rounded-xl transition-all rtl-text">إعادة تعيين</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Modal Functions
        function openCouponModal() {
            document.getElementById('couponModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeCouponModal() {
            document.getElementById('couponModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Toggle Switch Function
        function toggleSwitch(element) {
            element.classList.toggle('active');
        }

        // Categories functionality
        function addCategory(categoryId, categoryName) {
            const selectedCategories = document.getElementById('selectedCategories');
            const existingCategory = selectedCategories.querySelector(`[data-category="${categoryId}"]`);
            
            if (!existingCategory) {
                const categoryTag = document.createElement('span');
                categoryTag.className = 'coupon-tag px-3 py-1 rounded-full text-xs';
                categoryTag.setAttribute('data-category', categoryId);
                categoryTag.innerHTML = `
                    ${categoryName}
                    <span class="coupon-tag-remove" onclick="removeCategory('${categoryId}')">×</span>
                `;
                selectedCategories.appendChild(categoryTag);
            }
        }

        function removeCategory(categoryId) {
            const categoryTag = document.querySelector(`[data-category="${categoryId}"]`);
            if (categoryTag) {
                categoryTag.remove();
            }
        }

        function filterCategories() {
            const searchTerm = document.getElementById('categorySearch').value.toLowerCase();
            const categoryItems = document.querySelectorAll('#categoryList .coupon-checkbox-card');
            
            categoryItems.forEach(item => {
                const categoryName = item.textContent.toLowerCase();
                if (categoryName.includes(searchTerm)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        // Products functionality
        function addProduct(productId, productName) {
            const selectedProducts = document.getElementById('selectedProducts');
            const existingProduct = selectedProducts.querySelector(`[data-product="${productId}"]`);
            
            if (!existingProduct) {
                const productTag = document.createElement('span');
                productTag.className = 'coupon-tag px-3 py-1 rounded-full text-xs';
                productTag.setAttribute('data-product', productId);
                productTag.innerHTML = `
                    ${productName}
                    <span class="coupon-tag-remove" onclick="removeProduct('${productId}')">×</span>
                `;
                selectedProducts.appendChild(productTag);
            }
        }

        function removeProduct(productId) {
            const productTag = document.querySelector(`[data-product="${productId}"]`);
            if (productTag) {
                productTag.remove();
            }
        }

        function filterProducts() {
            const searchTerm = document.getElementById('productSearch').value.toLowerCase();
            const productItems = document.querySelectorAll('#productList .coupon-checkbox-card');
            
            productItems.forEach(item => {
                const productName = item.textContent.toLowerCase();
                if (productName.includes(searchTerm)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        // Close modal when clicking outside
        document.getElementById('couponModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCouponModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeCouponModal();
                if (wizardActive) {
                    skipWizard();
                }
            }
        });

        // Real-time usage percentage calculation
        function updateUsageRate() {
            const used = parseInt(document.getElementById('usedCount').value) || 0;
            const max = parseInt(document.getElementById('maxUses').value) || 1;
            const percentage = ((used / max) * 100).toFixed(1);
            document.getElementById('usageRate').textContent = percentage + '%';
            document.getElementById('usageCount').textContent = used;
        }

        // Add event listeners for real-time updates
        document.addEventListener('DOMContentLoaded', function() {
            const maxUsesInput = document.getElementById('maxUses');
            const usedCountInput = document.getElementById('usedCount');
            
            if (maxUsesInput) {
                maxUsesInput.addEventListener('input', updateUsageRate);
            }
            if (usedCountInput) {
                usedCountInput.addEventListener('input', updateUsageRate);
            }

            // Initialize usage rate
            updateUsageRate();
        });

        // Form submission handler
        document.querySelector('.coupon-modal form').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('تم حفظ إعدادات الكوبون بنجاح!');
            closeCouponModal();
        });

        // Wizard Guide System
        let wizardActive = false;
        let currentWizardStep = 0;

        const wizardSteps = [
            {
                target: 'modalHeader',
                title: 'مرحباً بك في إعدادات الكوبون',
                description: 'تتيح لك هذه النافذة تكوين جميع جوانب كوبونات التخفيض السريع الخاصة بك. دعنا نستكشف كل قسم لمساعدتك في الحصول على أقصى استفادة من حملات الكوبون الخاصة بك.',
                position: 'bottom'
            },
            {
                target: 'basicSettings',
                title: 'الإعدادات الأساسية',
                description: 'ابدأ من هنا لإعداد رمز الكوبون الخاص بك وحالة التفعيل والتواريخ الصالحة وحدود الاستخدام. هذه هي الإعدادات الأساسية التي تحدد كيفية عمل الكوبون الخاص بك.',
                position: 'top'
            },
            {
                target: 'discountSettings',
                title: 'تكوين الخصم',
                description: 'قم بتكوين نوع الخصم (نسبة مئوية أو مبلغ ثابت أو شحن مجاني) وقيمة الخصم والحد الأدنى لمتطلبات الطلب والحد الأقصى لسقف الخصم للتحكم في تأثير عرضك.',
                position: 'top'
            },
            {
                target: 'categoriesProducts',
                title: 'الفئات والمنتجات',
                description: 'حدد فئات المنتجات والمنتجات الفردية التي ينطبق عليها هذا الكوبون. استخدم وظيفة البحث للعثور بسرعة على العناصر وتحديدها، أو اتركها فارغة للتطبيق على جميع المنتجات.',
                position: 'top'
            },
            {
                target: 'advancedSettings',
                title: 'الخيارات المتقدمة',
                description: 'قم بضبط الكوبون الخاص بك بدقة مع حدود المستخدم الواحد وإعدادات الأولوية والميزات الخاصة مثل التطبيق التلقائي وتكديس الكوبونات وإشعارات البريد الإلكتروني ورؤية الصفحة الرئيسية.',
                position: 'top'
            },
            {
                target: 'usageStats',
                title: 'إحصائيات الاستخدام والإجراءات',
                description: 'راقب أداء الكوبون الخاص بك مع الإحصائيات في الوقت الفعلي التي تظهر عدد الاستخدامات والوفورات الإجمالية ومعدل التحويل والوقت المتبقي. استخدم أزرار الإجراء لحفظ أو معاينة أو إعادة تعيين إعداداتك.',
                position: 'top'
            }
        ];

        function startWizardGuide() {
            if (!document.getElementById('couponModal').classList.contains('active')) {
                openCouponModal();
                setTimeout(() => {
                    initializeWizard();
                }, 500);
            } else {
                initializeWizard();
            }
        }

        function initializeWizard() {
            wizardActive = true;
            currentWizardStep = 0;
            document.getElementById('couponWizardOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
            showWizardStep(currentWizardStep);
        }

        function showWizardStep(stepIndex) {
            const step = wizardSteps[stepIndex];
            const targetElement = document.getElementById(step.target);
            const spotlight = document.getElementById('couponWizardSpotlight');
            const tooltip = document.getElementById('couponWizardTooltip');

            if (!targetElement) return;

            // Scroll target into view within modal
            const modalBody = document.getElementById('modalBody');
            targetElement.scrollIntoView({ behavior: 'smooth', block: 'center' });

            // Highlight the target section
            document.querySelectorAll('.coupon-section-card').forEach(card => {
                card.classList.remove('highlighted');
            });
            
            if (targetElement.classList.contains('coupon-section-card')) {
                targetElement.classList.add('highlighted');
            }

            // Position spotlight
            setTimeout(() => {
                const rect = targetElement.getBoundingClientRect();
                spotlight.style.left = (rect.left - 10) + 'px';
                spotlight.style.top = (rect.top - 10) + 'px';
                spotlight.style.width = (rect.width + 20) + 'px';
                spotlight.style.height = (rect.height + 20) + 'px';

                // Position tooltip
                positionTooltip(tooltip, rect, step.position);

                // Update tooltip content
                updateTooltipContent(stepIndex, step);
            }, 300);
        }

        function positionTooltip(tooltip, targetRect, preferredPosition) {
            const tooltipRect = tooltip.getBoundingClientRect();
            const viewportWidth = window.innerWidth;
            const viewportHeight = window.innerHeight;
            
            tooltip.className = 'coupon-wizard-tooltip';

            let left, top, position = preferredPosition;

            // Calculate position based on available space
            switch (position) {
                case 'top':
                    left = targetRect.left + (targetRect.width / 2) - (tooltipRect.width / 2);
                    top = targetRect.top - tooltipRect.height - 20;
                    if (top < 20) position = 'bottom';
                    break;
                case 'bottom':
                    left = targetRect.left + (targetRect.width / 2) - (tooltipRect.width / 2);
                    top = targetRect.bottom + 20;
                    if (top + tooltipRect.height > viewportHeight - 20) position = 'top';
                    break;
                case 'left':
                    left = targetRect.left - tooltipRect.width - 20;
                    top = targetRect.top + (targetRect.height / 2) - (tooltipRect.height / 2);
                    if (left < 20) position = 'right';
                    break;
                case 'right':
                    left = targetRect.right + 20;
                    top = targetRect.top + (targetRect.height / 2) - (tooltipRect.height / 2);
                    if (left + tooltipRect.width > viewportWidth - 20) position = 'left';
                    break;
            }

            // Recalculate if position changed
            if (position !== preferredPosition) {
                switch (position) {
                    case 'top':
                        left = targetRect.left + (targetRect.width / 2) - (tooltipRect.width / 2);
                        top = targetRect.top - tooltipRect.height - 20;
                        break;
                    case 'bottom':
                        left = targetRect.left + (targetRect.width / 2) - (tooltipRect.width / 2);
                        top = targetRect.bottom + 20;
                        break;
                    case 'left':
                        left = targetRect.left - tooltipRect.width - 20;
                        top = targetRect.top + (targetRect.height / 2) - (tooltipRect.height / 2);
                        break;
                    case 'right':
                        left = targetRect.right + 20;
                        top = targetRect.top + (targetRect.height / 2) - (tooltipRect.height / 2);
                        break;
                }
            }

            // Ensure tooltip stays within viewport
            left = Math.max(20, Math.min(left, viewportWidth - tooltipRect.width - 20));
            top = Math.max(20, Math.min(top, viewportHeight - tooltipRect.height - 20));

            tooltip.style.left = left + 'px';
            tooltip.style.top = top + 'px';
            tooltip.classList.add(position);
        }

        function updateTooltipContent(stepIndex, step) {
            document.getElementById('wizardStepIcon').textContent = stepIndex + 1;
            document.getElementById('wizardTitle').textContent = step.title;
            document.getElementById('wizardDescription').textContent = step.description;
            document.getElementById('wizardProgressText').textContent = `${stepIndex + 1} / ${wizardSteps.length}`;
            
            const progressPercent = ((stepIndex + 1) / wizardSteps.length) * 100;
            document.getElementById('wizardProgressFill').style.width = progressPercent + '%';

            // Update button states
            const prevBtn = document.getElementById('wizardPrevBtn');
            const nextBtn = document.getElementById('wizardNextBtn');

            if (stepIndex === 0) {
                prevBtn.style.display = 'none';
            } else {
                prevBtn.style.display = 'inline-block';
            }

            if (stepIndex === wizardSteps.length - 1) {
                nextBtn.textContent = 'إنهاء';
                nextBtn.className = 'coupon-wizard-btn coupon-wizard-btn-finish';
            } else {
                nextBtn.textContent = 'التالي';
                nextBtn.className = 'coupon-wizard-btn coupon-wizard-btn-next';
            }
        }

        function nextWizardStep() {
            if (currentWizardStep < wizardSteps.length - 1) {
                currentWizardStep++;
                showWizardStep(currentWizardStep);
            } else {
                finishWizard();
            }
        }

        function previousWizardStep() {
            if (currentWizardStep > 0) {
                currentWizardStep--;
                showWizardStep(currentWizardStep);
            }
        }

        function skipWizard() {
            finishWizard();
        }

        function finishWizard() {
            wizardActive = false;
            document.getElementById('couponWizardOverlay').classList.remove('active');
            
            // Remove highlights
            document.querySelectorAll('.coupon-section-card').forEach(card => {
                card.classList.remove('highlighted');
            });

            // Reset body overflow if modal is also closed
            if (!document.getElementById('couponModal').classList.contains('active')) {
                document.body.style.overflow = 'auto';
            }
        }

        // Close wizard when clicking outside tooltip
        document.getElementById('couponWizardOverlay').addEventListener('click', function(e) {
            if (e.target === this) {
                skipWizard();
            }
        });
    </script> 

{{-- end modal --}}



    








    </div>
    <script id="checkboxScript">
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const couponCard = this.closest('.bg-gray-800');
                    if (this.checked) {
                        couponCard.classList.add('ring-2', 'ring-primary');
                    } else {
                        couponCard.classList.remove('ring-2', 'ring-primary');
                    }
                });
            });
        });
    </script>
    <script id="paginationScript">
        document.addEventListener('DOMContentLoaded', function() {
            const paginationItems = document.querySelectorAll('.pagination-item');
            paginationItems.forEach(item => {
                item.addEventListener('click', function() {
                    paginationItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });
    </script>
    <script id="buttonsScript">
        document.addEventListener('DOMContentLoaded', function() {
            const actionButtons = document.querySelectorAll('.bg-gray-700');
            actionButtons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.classList.add('bg-gray-600');
                });
                button.addEventListener('mouseleave', function() {
                    this.classList.remove('bg-gray-600');
                });
            });
        });
    </script>
















































{{-- model setting  --}}














</body>

</html>
































{{-- @extends('themes.admin.layouts.app')

@section('title', 'إدارة كوبونات الخصم')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">إدارة كوبونات الخصم</h1>
        <a href="{{ route('admin.coupons.create') }}"
            class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded shadow dark:bg-green-700 dark:hover:bg-green-800">
            <i class="fas fa-plus ml-1"></i> إضافة كوبون جديد
        </a>
    </div>

    @if (session('success'))
    <div
        class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-200 px-4 py-3 rounded relative">
        {{ session('success') }}
    </div>

    @endif

    @if (session('error'))
    <div
        class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-200 px-4 py-3 rounded relative">
        {{ session('error') }}
    </div>
    @endif

    <!-- Coupons Table -->
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            #
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            الكود
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            نوع الخصم
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            قيمة الخصم
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            تاريخ البدء
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            تاريخ الانتهاء
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            الحد الأقصى
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            الاستخدام
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            الحالة
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            الإجراءات
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($coupons as $coupon)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $coupon->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <code
                                class="text-sm font-medium bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded">{{ $coupon->code }}</code>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($coupon->type == 'fixed')
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                مبلغ ثابت
                            </span>
                            @else
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                نسبة مئوية
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if ($coupon->type == 'fixed')
                            {{ $coupon->value }} ر.س
                            @else
                            {{ $coupon->value }}%
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $coupon->starts_at ? $coupon->starts_at->format('Y-m-d') : 'غير محدد' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $coupon->expires_at ? $coupon->expires_at->format('Y-m-d') : 'غير محدد' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $coupon->max_uses ?: 'غير محدد' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $coupon->orders()->where('status', 'completed')->count() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $coupon->is_active ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' }}">
                                {{ $coupon->is_active ? 'نشط' : 'غير نشط' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex items-center justify-center space-x-3 space-x-reverse">
                                <a href="{{ route('admin.coupons.show', $coupon->id) }}"
                                    class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>

                                <a href="{{ route('admin.coupons.edit', $coupon->id) }}"
                                    class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-900 dark:hover:text-yellow-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST"
                                    class="inline-block delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="px-6 py-8 text-center text-gray-500 dark:text-gray-300">
                            لا توجد كوبونات خصم حالياً. <a href="{{ route('admin.coupons.create') }}"
                                class="text-blue-600 hover:underline">إضافة كوبون جديد</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($coupons->count() > 0)
        <div class="bg-white dark:bg-gray-900 px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-6">
            <div class="flex justify-center">
                {{ $coupons->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    // تأكيد الحذف
    document.addEventListener('DOMContentLoaded', function () {
        const deleteForms = document.querySelectorAll('.delete-form');
        
        deleteForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                
                if (confirm('هل أنت متأكد من رغبتك في حذف هذا الكوبون؟')) {
                    this.submit();
                }
            });
        });
    });

    // تبديل حالة الكوبون (نشط/غير نشط) عبر AJAX
    $('.toggle-status').on('change', function() {
        const couponId = $(this).data('id');
        const isChecked = $(this).prop('checked');
        
        $.ajax({
            url: `{{ route('admin.coupons.toggle-status', '') }}/${couponId}`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                } else {
                    // إعادة الحالة إلى ما كانت عليه
                    $(this).prop('checked', !isChecked);
                    toastr.error('حدث خطأ أثناء تغيير الحالة');
                }
            },
            error: function() {
                // إعادة الحالة إلى ما كانت عليه
                $(this).prop('checked', !isChecked);
                toastr.error('حدث خطأ أثناء تغيير الحالة');
            }
        });
    });
</script>
@endpush --}}