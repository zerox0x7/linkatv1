<!DOCTYPE html>
<html lang="ar" dir="rtl" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>@yield('title', config('app.name'))</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('description', config('app.name'))">
    <meta name="keywords" content="@yield('keywords', 'متجر إلكتروني, منتجات عضوية')">
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('themes/torganic/assets/images/favicon.png') }}" type="image/x-icon">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('themes/torganic/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/torganic/assets/css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/torganic/assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/torganic/assets/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/torganic/assets/css/style.css') }}">
    
    <!-- Remix Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.0.0/fonts/remixicon.css" rel="stylesheet">
    
    <!-- Custom Styles for RTL -->
    <style>
        body {
            direction: rtl;
            text-align: right;
        }
        .menu-section--style-2 {
            direction: rtl;
        }
        .trk-btn {
            direction: rtl;
        }
        /* Additional RTL adjustments */
        .swiper-button-next {
            left: 10px;
            right: auto;
        }
        .swiper-button-prev {
            right: 10px;
            left: auto;
        }
    </style>
    
    @stack('styles')
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <img src="{{ asset('themes/torganic/assets/images/logo/preloader.png') }}" alt="preloader icon">
    </div>

    <!-- Header -->
    @include('themes.torganic.partials.header')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('themes.torganic.partials.footer')

    <!-- Scroll to Top -->
    <a href="#" class="scrollToTop scrollToTop--style1">
        <i class="fa-solid fa-arrow-up-from-bracket"></i>
    </a>

    <!-- Scripts -->
    <script src="{{ asset('themes/torganic/assets/js/metismenujs.min.js') }}"></script>
    <script src="{{ asset('themes/torganic/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('themes/torganic/assets/js/all.min.js') }}"></script>
    <script src="{{ asset('themes/torganic/assets/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('themes/torganic/assets/js/aos.js') }}"></script>
    <script src="{{ asset('themes/torganic/assets/js/fslightbox.js') }}"></script>
    <script src="{{ asset('themes/torganic/assets/js/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('themes/torganic/assets/js/trk-menu.js') }}"></script>
    <script src="{{ asset('themes/torganic/assets/js/custom.js') }}"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true
        });

        // Add to Cart AJAX Handler
        document.addEventListener('DOMContentLoaded', function() {
            // Handle all add to cart forms
            document.querySelectorAll('form[action*="cart.add"], form[action*="cart/add"]').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    const button = this.querySelector('button[type="submit"]');
                    const originalButtonText = button.innerHTML;
                    
                    // Disable button and show loading
                    button.disabled = true;
                    button.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> جاري الإضافة...';
                    
                    fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update cart count in header
                            if (window.CartManager && typeof window.CartManager.updateCartCount === 'function') {
                                window.CartManager.updateCartCount(data.cart_count);
                            }
                            
                            // Show/update cart badges
                            const cartBadges = document.querySelectorAll('.cart-count');
                            if (cartBadges.length > 0 && data.cart_count > 0) {
                                cartBadges.forEach(badge => {
                                    badge.textContent = data.cart_count;
                                    badge.style.display = '';
                                });
                            } else if (data.cart_count == 0) {
                                cartBadges.forEach(badge => badge.style.display = 'none');
                            }
                            
                            // Show success message
                            showNotification('تمت إضافة المنتج إلى السلة بنجاح', 'success');
                            
                            // Change button text temporarily
                            button.innerHTML = '<i class="fa-solid fa-check"></i> تمت الإضافة';
                            setTimeout(() => {
                                button.innerHTML = originalButtonText;
                                button.disabled = false;
                            }, 2000);
                        } else {
                            showNotification(data.message || 'حدث خطأ أثناء إضافة المنتج', 'error');
                            button.innerHTML = originalButtonText;
                            button.disabled = false;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('حدث خطأ أثناء إضافة المنتج', 'error');
                        button.innerHTML = originalButtonText;
                        button.disabled = false;
                    });
                });
            });
        });

        // Notification function
        function showNotification(message, type = 'success') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
            notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);';
            notification.innerHTML = `
                <i class="fa-solid fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            
            document.body.appendChild(notification);
            
            // Auto dismiss after 3 seconds
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => notification.remove(), 150);
            }, 3000);
        }
    </script>
    
    @stack('scripts')
</body>

</html>