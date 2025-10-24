// Gamey Theme JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize theme
    initializeGameyTheme();
    
    // Loading screen
    handleLoadingScreen();
    
    // Navigation functionality
    initializeNavigation();
    
    // Cart functionality
    initializeCart();
    
    // Back to top button
    initializeBackToTop();
    
    // Gaming effects
    initializeGamingEffects();
    
    // Smooth animations
    initializeAnimations();
});

// Main theme initialization
function initializeGameyTheme() {
    console.log('🎮 Gamey Theme Initialized');
    
    // Add gaming classes to elements
    addGamingClasses();
    
    // Initialize particles effect
    createParticlesBackground();
    
    // Initialize sound effects (optional)
    initializeSoundEffects();
}

// Loading screen handler
function handleLoadingScreen() {
    const loadingScreen = document.getElementById('loading-screen');
    if (loadingScreen) {
        console.log('Loading screen found, hiding after 1.5 seconds...');
        // Simulate loading time
        setTimeout(() => {
            loadingScreen.style.opacity = '0';
            loadingScreen.style.transition = 'opacity 0.5s ease-out';
            setTimeout(() => {
                loadingScreen.style.display = 'none';
                console.log('Loading screen hidden');
            }, 500);
        }, 1000); // Reduced to 1 second for faster loading
    } else {
        console.log('Loading screen element not found');
    }
}

// Navigation functionality
function initializeNavigation() {
    // Mobile menu toggle
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
            
            // Animate hamburger icon
            const icon = this.querySelector('i');
            if (mobileMenu.classList.contains('hidden')) {
                icon.className = 'fas fa-bars text-xl';
            } else {
                icon.className = 'fas fa-times text-xl';
            }
        });
    }
    
    // Smooth scroll for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// Cart functionality
function initializeCart() {
    const cartToggle = document.getElementById('cart-toggle');
    const cartSidebar = document.getElementById('cart-sidebar');
    const closeCart = document.getElementById('close-cart');
    const overlay = document.getElementById('overlay');
    
    if (cartToggle && cartSidebar) {
        // Open cart
        cartToggle.addEventListener('click', function() {
            cartSidebar.classList.remove('translate-x-full');
            overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });
        
        // Close cart
        function closeCartSidebar() {
            cartSidebar.classList.add('translate-x-full');
            overlay.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        
        if (closeCart) {
            closeCart.addEventListener('click', closeCartSidebar);
        }
        
        if (overlay) {
            overlay.addEventListener('click', closeCartSidebar);
        }
    }
    
    // Add to cart buttons
    document.addEventListener('click', function(e) {
        if (e.target.closest('.add-to-cart') || e.target.closest('button[class*="shopping-cart"]')) {
            e.preventDefault();
            handleAddToCart(e.target);
        }
    });
}

// Handle add to cart functionality
function handleAddToCart(button) {
    // Gaming feedback effect
    button.style.transform = 'scale(0.95)';
    button.innerHTML = '<i class="fas fa-check mr-2"></i>Added!';
    
    setTimeout(() => {
        button.style.transform = 'scale(1)';
        button.innerHTML = '<i class="fas fa-shopping-cart mr-2"></i>Add to Cart';
    }, 1000);
    
    // Update cart counter
    updateCartCounter();
    
    // Show success notification
    showNotification('Item added to cart!', 'success');
}

// Update cart counter
function updateCartCounter() {
    const cartCounters = document.querySelectorAll('.cart-counter');
    cartCounters.forEach(counter => {
        const currentCount = parseInt(counter.textContent) || 0;
        counter.textContent = currentCount + 1;
        
        // Animate counter
        counter.style.transform = 'scale(1.2)';
        setTimeout(() => {
            counter.style.transform = 'scale(1)';
        }, 200);
    });
}

// Back to top button
function initializeBackToTop() {
    const backToTopBtn = document.getElementById('back-to-top');
    
    if (backToTopBtn) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopBtn.style.opacity = '1';
                backToTopBtn.style.transform = 'translateY(0)';
            } else {
                backToTopBtn.style.opacity = '0';
                backToTopBtn.style.transform = 'translateY(10px)';
            }
        });
        
        backToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
}

// Gaming effects
function initializeGamingEffects() {
    // Hover effects for gaming cards
    document.querySelectorAll('.gaming-card, .bg-dark-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 10px 30px rgba(0, 191, 255, 0.3)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });
    });
    
    // Button click effects
    document.querySelectorAll('button, .btn').forEach(button => {
        button.addEventListener('click', function(e) {
            // Create ripple effect
            createRippleEffect(e, this);
        });
    });
    
    // Gaming cursor trail effect
    initializeCursorTrail();
}

// Create ripple effect
function createRippleEffect(event, element) {
    const ripple = document.createElement('span');
    const rect = element.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    const x = event.clientX - rect.left - size / 2;
    const y = event.clientY - rect.top - size / 2;
    
    ripple.style.cssText = `
        position: absolute;
        width: ${size}px;
        height: ${size}px;
        left: ${x}px;
        top: ${y}px;
        background: rgba(0, 191, 255, 0.3);
        border-radius: 50%;
        transform: scale(0);
        animation: ripple 0.6s linear;
        pointer-events: none;
    `;
    
    element.style.position = 'relative';
    element.style.overflow = 'hidden';
    element.appendChild(ripple);
    
    setTimeout(() => {
        ripple.remove();
    }, 600);
}

// Add gaming classes to elements
function addGamingClasses() {
    // Add fade-in animation to main sections
    document.querySelectorAll('section').forEach((section, index) => {
        setTimeout(() => {
            section.classList.add('fade-in');
        }, index * 100);
    });
    
    // Add hover effects to interactive elements
    document.querySelectorAll('a, button').forEach(element => {
        element.classList.add('hover-glow');
    });
}

// Create particles background
function createParticlesBackground() {
    const hero = document.querySelector('.hero-gradient');
    if (!hero) return;
    
    const particlesContainer = document.createElement('div');
    particlesContainer.className = 'particles-bg';
    hero.appendChild(particlesContainer);
    
    // Create particles
    for (let i = 0; i < 50; i++) {
        setTimeout(() => {
            createParticle(particlesContainer);
        }, i * 100);
    }
    
    // Continue creating particles
    setInterval(() => {
        createParticle(particlesContainer);
    }, 2000);
}

// Create individual particle
function createParticle(container) {
    const particle = document.createElement('div');
    particle.className = 'particle';
    
    // Random position and properties
    particle.style.left = Math.random() * 100 + '%';
    particle.style.animationDelay = Math.random() * 10 + 's';
    particle.style.animationDuration = (Math.random() * 10 + 10) + 's';
    
    // Random color
    const colors = ['#00BFFF', '#39FF14', '#BF00FF', '#FF6600'];
    particle.style.background = colors[Math.floor(Math.random() * colors.length)];
    
    container.appendChild(particle);
    
    // Remove particle after animation
    setTimeout(() => {
        if (particle && particle.parentNode) {
            particle.parentNode.removeChild(particle);
        }
    }, 20000);
}

// Initialize cursor trail
function initializeCursorTrail() {
    const trail = [];
    const trailLength = 10;
    
    document.addEventListener('mousemove', function(e) {
        trail.push({ x: e.clientX, y: e.clientY });
        
        if (trail.length > trailLength) {
            trail.shift();
        }
        
        updateCursorTrail(trail);
    });
}

// Update cursor trail
function updateCursorTrail(trail) {
    // Remove existing trail elements
    document.querySelectorAll('.cursor-trail').forEach(el => el.remove());
    
    trail.forEach((point, index) => {
        const trailElement = document.createElement('div');
        trailElement.className = 'cursor-trail';
        trailElement.style.cssText = `
            position: fixed;
            pointer-events: none;
            width: ${5 - (index * 0.5)}px;
            height: ${5 - (index * 0.5)}px;
            background: rgba(0, 191, 255, ${0.5 - (index * 0.05)});
            border-radius: 50%;
            left: ${point.x}px;
            top: ${point.y}px;
            z-index: 9999;
            transform: translate(-50%, -50%);
            transition: all 0.1s ease;
        `;
        
        document.body.appendChild(trailElement);
        
        // Remove after short time
        setTimeout(() => {
            if (trailElement && trailElement.parentNode) {
                trailElement.parentNode.removeChild(trailElement);
            }
        }, 100);
    });
}

// Initialize animations
function initializeAnimations() {
    // Intersection Observer for animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, { threshold: 0.1 });
    
    // Observe elements for animation
    document.querySelectorAll('.gaming-card, .stat-card, .category-card').forEach(el => {
        observer.observe(el);
    });
}

// Initialize sound effects
function initializeSoundEffects() {
    // Optional: Add gaming sound effects
    const sounds = {
        click: new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+D2u2UeBC2O1fPVfCkGIYG+7+OZUQ0PVqzh0qp0kh8ELIzS8dWMFQUdgcvw34lJHQUrjdX+RzL1NDYRU8F86lhQS2ZR04ZHUU4Biv8UOTBH'),
        hover: new Audio('data:audio/wav;base64,UklGRkgBAABXQVZFZm10IBAAAAABAAEARKwAAIhYAQACABAAZGF0YSQBAABUdmWNpGLRDxFGqvCKhGUeED+Vy/zHi0ByF3St5+iWOQYPZsTbm4xKCRBKqpR3gmsQETaHzfzNjEByGXGr6+iVOgUOZMPcnYtKCg9HqZV4g2oRETOKzfPOjD9yG3Ko6OmURhEOY8LenYhODAkKw3E5tF1hUkMJEUvUWQHFOwEJW6UHDkwKGU+6vdJ6PwcO2gDVfgCAZAoJCwSKU6FqGCFUiGdAB4k7CwiLbKJiNA9hgHHKqTsLCYhpuBNqmRkOYoB+zP7F0g0PZOOVYAhRzOwn25MHT5bwV0H+7YZHLjxDmrJxRK1VFRM+N3OcGgOD8wUXfqBj'); 
    };
    
    // Add click sound to buttons
    document.addEventListener('click', function(e) {
        if (e.target.matches('button, .btn, a[href]')) {
            if (sounds.click) {
                sounds.click.currentTime = 0;
                sounds.click.volume = 0.1;
                sounds.click.play().catch(() => {}); // Ignore errors
            }
        }
    });
    
    // Add hover sound to gaming elements
    document.querySelectorAll('.gaming-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            if (sounds.hover) {
                sounds.hover.currentTime = 0;
                sounds.hover.volume = 0.05;
                sounds.hover.play().catch(() => {}); // Ignore errors
            }
        });
    });
}

// Show notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg text-white font-bold transform translate-x-full transition-transform duration-300`;
    
    // Set color based on type
    switch (type) {
        case 'success':
            notification.classList.add('bg-gradient-to-r', 'from-green-500', 'to-green-600');
            break;
        case 'error':
            notification.classList.add('bg-gradient-to-r', 'from-red-500', 'to-red-600');
            break;
        default:
            notification.classList.add('bg-gradient-to-r', 'from-blue-500', 'to-blue-600');
    }
    
    notification.innerHTML = `
        <div class="flex items-center space-x-2">
            <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'times' : 'info'}-circle"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Slide in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Slide out and remove
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            if (notification && notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

// Gaming utility functions
function getRandomNeonColor() {
    const colors = ['#00BFFF', '#39FF14', '#BF00FF', '#FF6600'];
    return colors[Math.floor(Math.random() * colors.length)];
}

function createGlowEffect(element, color = '#00BFFF') {
    element.style.boxShadow = `0 0 20px ${color}`;
    element.style.transition = 'box-shadow 0.3s ease';
}

// Add CSS for ripple animation
const rippleCSS = `
@keyframes ripple {
    to {
        transform: scale(4);
        opacity: 0;
    }
}
`;

const style = document.createElement('style');
style.textContent = rippleCSS;
document.head.appendChild(style); 