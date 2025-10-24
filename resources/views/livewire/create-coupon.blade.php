<div>
<style>
        /* Custom CSS with coupon- prefix for RTL specific styling needs */
        .coupon-page-container {
            direction: rtl;
            background: #1a202c;
            padding: 2rem;
        }

        .coupon-content-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            max-height: calc(100vh - 140px); /* Adjust for header height */
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* Custom Scrollbar Design for content wrapper */
        .coupon-content-wrapper::-webkit-scrollbar {
            width: 12px;
        }

        .coupon-content-wrapper::-webkit-scrollbar-track {
            background: linear-gradient(180deg, #1a1f2e 0%, #232b3e 50%, #1a1f2e 100%);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        }

        .coupon-content-wrapper::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #00e1c0 0%, #00c4a7 50%, #00a691 100%);
            border-radius: 10px;
            border: 2px solid #1a1f2e;
            box-shadow: 
                0 0 10px rgba(0, 225, 192, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.2),
                inset 0 -1px 0 rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .coupon-content-wrapper::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #00f5d4 0%, #00e1c0 50%, #00c4a7 100%);
            box-shadow: 
                0 0 15px rgba(0, 225, 192, 0.6),
                inset 0 1px 0 rgba(255, 255, 255, 0.3),
                inset 0 -1px 0 rgba(0, 0, 0, 0.3);
            transform: scaleX(1.1);
        }

        .coupon-content-wrapper::-webkit-scrollbar-thumb:active {
            background: linear-gradient(180deg, #00c4a7 0%, #00a691 50%, #008f7a 100%);
            box-shadow: 
                0 0 8px rgba(0, 225, 192, 0.8),
                inset 0 2px 4px rgba(0, 0, 0, 0.4);
        }

        /* Firefox Scrollbar for content wrapper */
        .coupon-content-wrapper {
            scrollbar-width: thin;
            scrollbar-color: #00e1c0 #1a1f2e;
            scroll-behavior: smooth;
        }

        .coupon-page-header {
            background: linear-gradient(135deg, #232b3e 0%, #2a3441 50%, #1a1f2e 100%);
            border: 1px solid rgba(0, 225, 192, 0.2);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            position: relative;
        }

        .coupon-page-header::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, #00e1c0, transparent);
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

        .coupon-section-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
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

        /* Glass morphism effect */
        .coupon-glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
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

        .coupon-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 1rem;
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
        }

        .coupon-breadcrumb a {
            color: #00e1c0;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .coupon-breadcrumb a:hover {
            color: #00c4a7;
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

        .coupon-section-card.highlighted {
            border: 2px solid #00e1c0 !important;
            box-shadow: 0 0 20px rgba(0, 225, 192, 0.3) !important;
            background: rgba(0, 225, 192, 0.05) !important;
            transition: all 0.4s ease !important;
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

        /* Scrollbar styles */
        .coupon-scrollbar::-webkit-scrollbar {
            width: 12px;
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

        /* Scroll Features */
        .scroll-features {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .scroll-progress {
            width: 300px;
            height: 4px;
            background: #333;
            border-radius: 2px;
            overflow: hidden;
        }

        .scroll-progress-fill {
            height: 100%;
            background: #00e1c0;
            transition: width 0.3s ease;
        }

        .scroll-to-top {
            display: none;
            background: #00e1c0;
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            font-size: 1.5rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .scroll-to-top:hover {
            background: #00c4a7;
        }

        /* Popup Notification Styles */
        .notification-popup {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            max-width: 400px;
            background: linear-gradient(135deg, #232b3e, #1a1f2e);
            border-radius: 12px;
            padding: 16px 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5), 0 0 20px rgba(0, 225, 192, 0.2);
            backdrop-filter: blur(20px);
            transform: translateX(100%);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(0, 225, 192, 0.3);
            direction: rtl;
        }

        .notification-popup.show {
            transform: translateX(0);
            opacity: 1;
        }

        .notification-popup.success {
            border-color: rgba(34, 197, 94, 0.4);
        }

        .notification-popup.success::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, #22c55e, #16a34a);
            border-radius: 0 12px 12px 0;
        }

        .notification-popup.error {
            border-color: rgba(239, 68, 68, 0.4);
        }

        .notification-popup.error::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, #ef4444, #dc2626);
            border-radius: 0 12px 12px 0;
        }

        .notification-content {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-right: 8px;
        }

        .notification-icon {
            width: 24px;
            height: 24px;
            flex-shrink: 0;
        }

        .notification-message {
            flex: 1;
            color: #ffffff;
            font-size: 14px;
            line-height: 1.4;
            text-align: right;
        }

        .notification-close {
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.1);
            border: none;
            border-radius: 50%;
            color: rgba(255, 255, 255, 0.6);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .notification-close:hover {
            background: rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.9);
        }

        .notification-progress {
            position: absolute;
            bottom: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #00e1c0, #00c4a7);
            transition: width 0.1s linear;
            border-radius: 0 0 12px 0;
        }

        .notification-popup.success .notification-progress {
            background: linear-gradient(90deg, #22c55e, #16a34a);
        }

        .notification-popup.error .notification-progress {
            background: linear-gradient(90deg, #ef4444, #dc2626);
        }
    </style>

<!-- Main Content Container -->
<div class="coupon-page-container">
    <!-- Scroll Progress Indicator -->
    <div class="scroll-indicator">
        <div class="scroll-progress" id="scrollProgress"></div>
    </div>

    <div class="coupon-content-wrapper">
        <!-- Breadcrumb -->
        <div class="coupon-breadcrumb rtl-text">
            <a href="{{ route('admin.dashboard') }}">لوحة التحكم</a>
            <span>/</span>
            <a href="{{ route('admin.coupons.index') }}">الكوبونات</a>
            <span>/</span>
            <span>إنشاء كوبون</span>
        </div>

        <!-- Page Header -->
        <div class="coupon-page-header text-white" id="pageHeader">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2 bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent rtl-text">إنشاء كوبون جديد</h1>
                    <p class="opacity-90 text-sm text-gray-300 rtl-text">قم بتكوين كوبون التخفيض السريع الخاص بك</p>
                </div>
                <div class="flex gap-3">
                    <button onclick="startWizardGuide()" class="coupon-btn-secondary px-4 py-2 rounded-lg text-sm font-medium transition-all rtl-text">
                        <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        الجولة المُوجهة
                    </button>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="coupon-glass border border-green-500 bg-green-500/10 text-green-400 p-4 rounded-xl mb-6 rtl-text">
                <div class="flex items-center">
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ session('message') }}
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="coupon-glass border border-red-500 bg-red-500/10 text-red-400 p-4 rounded-xl mb-6 rtl-text">
                <div class="flex items-center">
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <!-- Main Content -->
        <form wire:submit.prevent="createCoupon">
            <!-- Basic Settings Section -->
            <div class="coupon-section-card" id="basicSettings">
                <h3 class="text-white text-xl font-bold mb-6 flex items-center rtl-text">
                    <div class="coupon-section-indicator-1 w-3 h-8 rounded-full ml-4"></div>
                    الإعدادات الأساسية
                </h3>
                
                <!-- Coupon Code & Active Status -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-300 text-sm font-semibold mb-3 rtl-text">رمز الكوبون</label>
                        <input type="text" wire:model="code" class="coupon-input w-full p-4 rounded-xl text-sm">
                        @error('coupon.code') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-300 text-sm font-semibold mb-3 rtl-text">الحالة</label>
                        <div class="coupon-glass flex items-center justify-between p-4 rounded-xl">
                            <span class="text-white text-sm font-medium rtl-text">نشط</span>
                            <div class="coupon-toggle {{$isActive ? 'active' : ''}}" wire:click="toggleActive">
                                <div class="coupon-toggle-thumb"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dates -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-300 text-sm font-semibold mb-3 rtl-text">تاريخ البداية</label>
                        <input type="datetime-local" wire:model="startsAt" class="coupon-input w-full p-4 rounded-xl text-sm">
                        @error('startsAt') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-300 text-sm font-semibold mb-3 rtl-text">تاريخ النهاية</label>
                        <input type="datetime-local" wire:model="expiresAt" class="coupon-input w-full p-4 rounded-xl text-sm">
                        @error('expiresAt') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Limits -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-gray-300 text-sm font-semibold mb-3 rtl-text">الحد الأقصى للاستخدام</label>
                        <input type="number" wire:model="maxUses" class="coupon-input w-full p-4 rounded-xl text-sm" id="maxUses">
                        @error('maxUses') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-300 text-sm font-semibold mb-3 rtl-text">المُستخدم</label>
                        <input type="number" value="0" readonly class="coupon-input w-full p-4 rounded-xl text-sm opacity-60 cursor-not-allowed" id="usedCount">
                        <small class="text-gray-400 text-xs rtl-text">سيبدأ من 0 عند إنشاء الكوبون</small>
                    </div>
                    <div>
                        <label class="block text-gray-300 text-sm font-semibold mb-3 rtl-text">حد المستخدم الواحد</label>
                        <input type="number" wire:model="userLimit" class="coupon-input w-full p-4 rounded-xl text-sm">
                        @error('userLimit') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Discount Settings -->
            <div class="coupon-section-card" id="discountSettings">
                <h3 class="text-white text-xl font-bold mb-6 flex items-center rtl-text">
                    <div class="coupon-section-indicator-2 w-3 h-8 rounded-full ml-4"></div>
                    إعدادات الخصم
                </h3>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-300 text-sm font-semibold mb-3 rtl-text">النوع</label>
                        <select wire:model="type" wire:change="updateDiscountType" class="coupon-select w-full p-4 rounded-xl text-sm cursor-pointer">
                            <option value="percentage">نسبة مئوية</option>
                            <option value="fixed">مبلغ ثابت</option>
                            <option value="free_shipping">شحن مجاني</option>
                        </select>
                        @error('type') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-300 text-sm font-semibold mb-3 rtl-text">
                            القيمة
                            @if($type === 'percentage')
                                <span class="text-xs text-gray-400">(نسبة مئوية %)</span>
                            @elseif($type === 'fixed')
                                <span class="text-xs text-gray-400">(مبلغ ثابت ر.س)</span>
                            @else
                                <span class="text-xs text-gray-400">(غير مطلوب للشحن المجاني)</span>
                            @endif
                        </label>
                        <input type="number" step="0.01" wire:model="value" 
                               class="coupon-input w-full p-4 rounded-xl text-sm {{ $type === 'free_shipping' ? 'opacity-50 cursor-not-allowed' : '' }}"
                               {{ $type === 'free_shipping' ? 'disabled' : '' }}
                               placeholder="{{ $type === 'percentage' ? 'أدخل النسبة المئوية' : ($type === 'fixed' ? 'أدخل المبلغ بالريال' : 'غير مطلوب') }}">
                        @error('value') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-300 text-sm font-semibold mb-3 rtl-text">الحد الأدنى للطلب</label>
                        <input type="number" step="0.01" wire:model="minOrderAmount" 
                               class="coupon-input w-full p-4 rounded-xl text-sm"
                               placeholder="أدخل الحد الأدنى لقيمة الطلب">
                        @error('minOrderAmount') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-300 text-sm font-semibold mb-3 rtl-text">
                            الحد الأقصى للخصم
                            @if($type === 'free_shipping')
                                <span class="text-xs text-gray-400">(غير مطلوب للشحن المجاني)</span>
                            @else
                                <span class="text-xs text-gray-400">(اختياري)</span>
                            @endif
                        </label>
                        <input type="number" step="0.01" wire:model="maxDiscountAmount" 
                               class="coupon-input w-full p-4 rounded-xl text-sm {{ $type === 'free_shipping' ? 'opacity-50 cursor-not-allowed' : '' }}"
                               {{ $type === 'free_shipping' ? 'disabled' : '' }}
                               placeholder="{{ $type === 'free_shipping' ? 'غير مطلوب' : 'أدخل الحد الأقصى للخصم' }}">
                        @error('maxDiscountAmount') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Discount Type Information -->
                <div class="mt-6 p-4 rounded-xl border border-gray-600 bg-gray-800/30">
                    @if($type === 'percentage')
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-blue-400 font-medium text-sm rtl-text">خصم نسبة مئوية</h4>
                                <p class="text-gray-400 text-xs mt-1 rtl-text">سيتم خصم النسبة المحددة من إجمالي قيمة الطلب. يمكنك تحديد حد أقصى للخصم لتجنب الخصومات الكبيرة.</p>
                            </div>
                        </div>
                    @elseif($type === 'fixed')
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-green-400 font-medium text-sm rtl-text">خصم مبلغ ثابت</h4>
                                <p class="text-gray-400 text-xs mt-1 rtl-text">سيتم خصم المبلغ المحدد من إجمالي قيمة الطلب. المبلغ ثابت بغض النظر عن قيمة الطلب.</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-purple-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-purple-400 font-medium text-sm rtl-text">شحن مجاني</h4>
                                <p class="text-gray-400 text-xs mt-1 rtl-text">سيتم إلغاء رسوم الشحن للطلبات التي تستوفي الشروط. لا حاجة لتحديد قيمة أو حد أقصى للخصم.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Categories & Products -->
            <div class="coupon-section-card" id="categoriesProducts">
                <h3 class="text-white text-xl font-bold mb-6 flex items-center rtl-text">
                    <div class="coupon-section-indicator-3 w-3 h-8 rounded-full ml-4"></div>
                    الفئات والمنتجات
                </h3>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-300 text-sm font-semibold mb-3 rtl-text">الفئات</label>
                        <div class="relative mb-4">
                            <input type="text" wire:model.live="searchCategories" placeholder="البحث في الفئات..." class="coupon-input w-full p-4 pl-12 rounded-xl text-sm">
                            <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 search-icon-container">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-2 mb-4" id="selectedCategories">
                            @foreach($this->selectedCategoriesModels as $category)
                                <span class="coupon-tag px-3 py-2 rounded-full text-sm" data-category="{{$category->id}}" wire:key="selected-category-{{$category->id}}">
                                    {{$category->name}}
                                    <span class="coupon-tag-remove" wire:click="removeCategory({{$category->id}})">×</span>
                                </span>
                            @endforeach
                        </div>
                        <div class="space-y-2 max-h-40 overflow-y-auto coupon-scrollbar">
                            @foreach($this->availableCategories as $category)
                                @if(!in_array($category->id, $selectedCategories))
                                    <div class="coupon-checkbox-card flex items-center p-3 rounded-lg cursor-pointer text-sm" wire:click="toggleCategory({{$category->id}})" wire:key="available-category-{{$category->id}}">
                                        <span class="text-white rtl-text">{{$category->name}}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-gray-300 text-sm font-semibold mb-3 rtl-text">المنتجات</label>
                        <div class="relative mb-4">
                            <input type="text" wire:model.live="searchProducts" placeholder="البحث في المنتجات..." class="coupon-input w-full p-4 pl-12 rounded-xl text-sm">
                            <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 search-icon-container">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-2 mb-4" id="selectedProducts">
                            @foreach($this->selectedProductsModels as $product)
                                <span class="coupon-tag px-3 py-2 rounded-full text-sm" data-product="{{$product->id}}" wire:key="selected-product-{{$product->id}}">
                                    {{$product->name}}
                                    <span class="coupon-tag-remove" wire:click="removeProduct({{$product->id}})">×</span>
                                </span>
                            @endforeach
                        </div>
                        <div class="space-y-2 max-h-40 overflow-y-auto coupon-scrollbar">
                            @foreach($this->availableProducts as $product)
                                @if(!in_array($product->id, $selectedProducts))
                                    <div class="coupon-checkbox-card flex items-center p-3 rounded-lg cursor-pointer text-sm" wire:click="toggleProduct({{$product->id}})" wire:key="available-product-{{$product->id}}">
                                        <span class="text-white rtl-text">{{$product->name}}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Advanced Settings -->
            <div class="coupon-section-card" id="advancedSettings">
                <h3 class="text-white text-xl font-bold mb-6 flex items-center rtl-text">
                    <div class="coupon-section-indicator-4 w-3 h-8 rounded-full ml-4"></div>
                    الإعدادات المتقدمة
                </h3>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-300 text-sm font-semibold mb-3 rtl-text">الأولوية</label>
                        <select wire:model="priority" class="coupon-select w-full p-4 rounded-xl text-sm cursor-pointer">
                            <option value="high">عالية</option>
                            <option value="medium">متوسطة</option>
                            <option value="low">منخفضة</option>
                        </select>
                        @error('priority') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-300 text-sm font-semibold mb-3 rtl-text">معرف المتجر</label>
                        <input type="number" wire:model="storeId" class="coupon-input w-full p-4 rounded-xl text-sm">
                        @error('storeId') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Feature Toggles -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div class="coupon-glass flex items-center justify-between p-4 rounded-xl">
                        <span class="text-white text-sm rtl-text">تطبيق تلقائي</span>
                        <div class="coupon-toggle {{$autoApply ? 'active' : ''}}" wire:click="toggleAutoApply">
                            <div class="coupon-toggle-thumb"></div>
                        </div>
                    </div>
                    <div class="coupon-glass flex items-center justify-between p-4 rounded-xl">
                        <span class="text-white text-sm rtl-text">تكديس الكوبونات</span>
                        <div class="coupon-toggle {{$stackable ? 'active' : ''}}" wire:click="toggleStackable">
                            <div class="coupon-toggle-thumb"></div>
                        </div>
                    </div>
                    <div class="coupon-glass flex items-center justify-between p-4 rounded-xl">
                        <span class="text-white text-sm rtl-text">إشعارات البريد الإلكتروني</span>
                        <div class="coupon-toggle {{$emailNotifications ? 'active' : ''}}" wire:click="toggleEmailNotifications">
                            <div class="coupon-toggle-thumb"></div>
                        </div>
                    </div>
                    <div class="coupon-glass flex items-center justify-between p-4 rounded-xl">
                        <span class="text-white text-sm rtl-text">عرض في الصفحة الرئيسية</span>
                        <div class="coupon-toggle {{$showOnHomepage ? 'active' : ''}}" wire:click="toggleShowOnHomepage">
                            <div class="coupon-toggle-thumb"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Usage Statistics -->
            <!-- Statistics will be available after the coupon is created -->

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4" id="actionButtons">
                <button type="submit" class="coupon-btn-primary flex-1 px-8 py-4 font-semibold rounded-xl transition-all rtl-text text-lg" onclick="console.log('Create button clicked');">
                    <span wire:loading.remove wire:target="createCoupon">إنشاء الكوبون</span>
                    <span wire:loading wire:target="createCoupon">جاري الإنشاء...</span>
                </button>
                <button type="button" class="coupon-btn-secondary flex-1 px-8 py-4 font-medium rounded-xl transition-all rtl-text text-lg">معاينة</button>
                <button type="button" wire:click="resetForm" class="coupon-btn-secondary flex-1 px-8 py-4 font-medium rounded-xl transition-all rtl-text text-lg">إعادة تعيين</button>
            </div>
        </form>
    </div>
</div>

<!-- Wizard Guide Overlay -->
<div id="couponWizardOverlay" class="coupon-wizard-overlay">
    <div id="couponWizardSpotlight" class="coupon-wizard-spotlight"></div>
    <div id="couponWizardTooltip" class="coupon-wizard-tooltip">
        <div class="coupon-wizard-header">
            <div class="coupon-wizard-icon" id="wizardStepIcon">1</div>
            <h3 class="coupon-wizard-title" id="wizardTitle">مرحباً بك في صفحة إنشاء الكوبون</h3>
        </div>
        <p class="coupon-wizard-description" id="wizardDescription">
            تتيح لك هذه الصفحة إنشاء كوبونات التخفيض الجديدة بجميع الميزات المتاحة. دعنا نستكشف كل قسم لمساعدتك في إنشاء كوبون فعال.
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
                <!-- <button class="coupon-wizard-btn coupon-wizard-btn-prev" id="wizardPrevBtn" onclick="previousWizardStep()" style="display: none;">السابق</button> -->
                <button class="coupon-wizard-btn coupon-wizard-btn-next" id="wizardNextBtn" onclick="nextWizardStep()">التالي</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Real-time usage percentage calculation
    function updateUsageRate() {
        const used = parseInt(document.getElementById('usedCount').value) || 0;
        const max = parseInt(document.getElementById('maxUses').value) || 1;
        const percentage = ((used / max) * 100).toFixed(1);
        const usageRateElement = document.getElementById('usageRate');
        const usageCountElement = document.getElementById('usageCount');
        
        if (usageRateElement) {
            usageRateElement.textContent = percentage + '%';
        }
        if (usageCountElement) {
            usageCountElement.textContent = used;
        }
    }

    // Add event listeners for real-time updates
    document.addEventListener('DOMContentLoaded', function() {
        const maxUsesInput = document.getElementById('maxUses');
        
        if (maxUsesInput) {
            maxUsesInput.addEventListener('input', updateUsageRate);
        }

        // Initialize usage rate
        updateUsageRate();
    });

    // Wizard Guide System
    let wizardActive = false;
    let currentWizardStep = 0;

    const wizardSteps = [
        {
            target: 'pageHeader',
            title: 'مرحباً بك في صفحة إنشاء الكوبون',
            description: 'تتيح لك هذه الصفحة إنشاء كوبونات التخفيض الجديدة بجميع الميزات المتاحة. دعنا نستكشف كل قسم لمساعدتك في إنشاء كوبون فعال.',
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
            description: 'قم بضبط الكوبون الخاص بك بدقة مع إعدادات الأولوية والميزات الخاصة مثل التطبيق التلقائي وتكديس الكوبونات وإشعارات البريد الإلكتروني ورؤية الصفحة الرئيسية.',
            position: 'top'
        },
        {
            target: 'actionButtons',
            title: 'إنشاء الكوبون',
            description: 'بعد تكوين جميع الإعدادات، استخدم زر "إنشاء الكوبون" لحفظ الكوبون الجديد. يمكنك أيضاً معاينة الإعدادات أو إعادة تعيين النموذج إذا لزم الأمر.',
            position: 'top'
        }
    ];

    function startWizardGuide() {
        initializeWizard();
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
        const targetElement = document.getElementById(step.target) || document.querySelector('.' + step.target);
        const spotlight = document.getElementById('couponWizardSpotlight');
        const tooltip = document.getElementById('couponWizardTooltip');

        if (!targetElement) return;

        // Scroll target into view
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

        document.body.style.overflow = 'auto';
    }

    // Close wizard when clicking outside tooltip
    document.getElementById('couponWizardOverlay').addEventListener('click', function(e) {
        if (e.target === this) {
            skipWizard();
        }
    });

    // Close wizard with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && wizardActive) {
            skipWizard();
        }
    });

    // Scroll Features
    function initializeScrollFeatures() {
        const scrollContainer = document.querySelector('.coupon-content-wrapper');
        const scrollProgress = document.getElementById('scrollProgress');
        const scrollToTopBtn = document.getElementById('scrollToTop');

        // Update scroll progress
        function updateScrollProgress() {
            if (scrollContainer) {
                const scrollTop = scrollContainer.scrollTop;
                const scrollHeight = scrollContainer.scrollHeight - scrollContainer.clientHeight;
                const scrollPercentage = (scrollTop / scrollHeight) * 100;
                
                if (scrollProgress) {
                    scrollProgress.style.width = scrollPercentage + '%';
                }

                // Show/hide scroll to top button
                if (scrollToTopBtn) {
                    if (scrollTop > 300) {
                        scrollToTopBtn.classList.add('visible');
                    } else {
                        scrollToTopBtn.classList.remove('visible');
                    }
                }
            }
        }

        // Add scroll event listener
        if (scrollContainer) {
            scrollContainer.addEventListener('scroll', updateScrollProgress);
        }

        // Smooth scroll to sections
        window.scrollToSection = function(sectionId) {
            const section = document.getElementById(sectionId);
            if (section && scrollContainer) {
                const offsetTop = section.offsetTop - 100; // Adjust for header
                scrollContainer.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        };

        // Add keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (!scrollContainer) return;

            switch(e.key) {
                case 'Home':
                    if (e.ctrlKey) {
                        e.preventDefault();
                        scrollContainer.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                    break;
                case 'End':
                    if (e.ctrlKey) {
                        e.preventDefault();
                        scrollContainer.scrollTo({ 
                            top: scrollContainer.scrollHeight, 
                            behavior: 'smooth' 
                        });
                    }
                    break;
                case 'PageUp':
                    e.preventDefault();
                    scrollContainer.scrollBy({ top: -400, behavior: 'smooth' });
                    break;
                case 'PageDown':
                    e.preventDefault();
                    scrollContainer.scrollBy({ top: 400, behavior: 'smooth' });
                    break;
            }
        });

        // Add mouse wheel smooth scrolling
        if (scrollContainer) {
            scrollContainer.addEventListener('wheel', function(e) {
                e.preventDefault();
                const delta = e.deltaY;
                const scrollAmount = delta * 0.8; // Smooth factor
                
                scrollContainer.scrollBy({
                    top: scrollAmount,
                    behavior: 'auto'
                });
            }, { passive: false });
        }
    }

    // Scroll to top function
    function scrollToTop() {
        const scrollContainer = document.querySelector('.coupon-content-wrapper');
        if (scrollContainer) {
            scrollContainer.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    }

    // Enhanced section navigation
    function navigateToSection(direction) {
        const sections = document.querySelectorAll('.coupon-section-card');
        const scrollContainer = document.querySelector('.coupon-content-wrapper');
        
        if (!scrollContainer || sections.length === 0) return;

        const currentScroll = scrollContainer.scrollTop;
        let targetSection = null;

        if (direction === 'next') {
            for (let section of sections) {
                if (section.offsetTop > currentScroll + 50) {
                    targetSection = section;
                    break;
                }
            }
        } else if (direction === 'prev') {
            for (let i = sections.length - 1; i >= 0; i--) {
                if (sections[i].offsetTop < currentScroll - 50) {
                    targetSection = sections[i];
                    break;
                }
            }
        }

        if (targetSection) {
            const offsetTop = targetSection.offsetTop - 100; // Adjust for header
            scrollContainer.scrollTo({
                top: offsetTop,
                behavior: 'smooth'
            });
        }
    }

    // Initialize scroll features when page loads
    document.addEventListener('DOMContentLoaded', function() {
        initializeScrollFeatures();
    });

    // Popup Notification System
    function showNotification(message, type = 'success', duration = 5000) {
        // Remove any existing notifications
        const existingNotifications = document.querySelectorAll('.notification-popup');
        existingNotifications.forEach(notification => {
            removeNotification(notification);
        });

        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification-popup ${type}`;
        
        // Create notification content
        const notificationContent = document.createElement('div');
        notificationContent.className = 'notification-content';
        
        // Create icon based on type
        const icon = document.createElement('div');
        icon.className = 'notification-icon';
        
        if (type === 'success') {
            icon.innerHTML = `
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #22c55e;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            `;
        } else if (type === 'error') {
            icon.innerHTML = `
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #ef4444;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            `;
        }
        
        // Create message
        const messageDiv = document.createElement('div');
        messageDiv.className = 'notification-message';
        messageDiv.textContent = message;
        
        // Create close button
        const closeBtn = document.createElement('button');
        closeBtn.className = 'notification-close';
        closeBtn.innerHTML = '×';
        closeBtn.onclick = () => removeNotification(notification);
        
        // Create progress bar
        const progressBar = document.createElement('div');
        progressBar.className = 'notification-progress';
        progressBar.style.width = '100%';
        
        // Assemble notification
        notificationContent.appendChild(icon);
        notificationContent.appendChild(messageDiv);
        notificationContent.appendChild(closeBtn);
        notification.appendChild(notificationContent);
        notification.appendChild(progressBar);
        
        // Add to body
        document.body.appendChild(notification);
        
        // Trigger animation
        setTimeout(() => {
            notification.classList.add('show');
        }, 100);
        
        // Start progress bar animation
        let progress = 100;
        const interval = setInterval(() => {
            progress -= (100 / (duration / 100));
            progressBar.style.width = progress + '%';
            
            if (progress <= 0) {
                clearInterval(interval);
                removeNotification(notification);
            }
        }, 100);
        
        // Store interval for cleanup
        notification.progressInterval = interval;
        
        return notification;
    }

    function removeNotification(notification) {
        if (notification.progressInterval) {
            clearInterval(notification.progressInterval);
        }
        
        notification.classList.remove('show');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 400);
    }

    // Listen for Livewire notification events
    document.addEventListener('DOMContentLoaded', function() {
        window.addEventListener('showNotification', (event) => {
            const data = event.detail;
            showNotification(data.message, data.type || 'success');
        });
    });
</script>

</div> 