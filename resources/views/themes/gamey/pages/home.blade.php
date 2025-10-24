@extends('themes.gamey.layouts.app')

@section('title', 'Gamey Store - Gaming Paradise')
@section('description', 'Your ultimate destination for gaming accounts, in-game currency, and premium digital goods')

@push('head')
<style>
    .hero-gradient {
        background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 50%, #0a0a0a 100%);
    }
    .glow-text {
        text-shadow: 0 0 10px rgba(0, 191, 255, 0.5);
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-gradient relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-neon-blue/10 to-neon-purple/10"></div>
    <div class="container mx-auto px-4 py-20 relative z-10">
        <div class="text-center">
            <h1 class="font-gaming text-5xl md:text-7xl font-bold text-white mb-6 glow-text animate-pulse-slow">
                GAME ON!
            </h1>
            <p class="text-xl md:text-2xl text-gray-300 mb-8 max-w-3xl mx-auto">
                Level up your gaming experience with premium accounts, rare items, and instant currency
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                <a href="{{ url('/products') }}" class="bg-gradient-to-r from-neon-blue to-neon-purple text-white px-8 py-4 rounded-lg font-bold text-lg hover:scale-105 transition-transform duration-200 animate-glow">
                    <i class="fas fa-shopping-cart mr-2"></i>
                    Shop Now
                </a>
                <a href="#featured" class="border border-neon-green text-neon-green px-8 py-4 rounded-lg font-bold text-lg hover:bg-neon-green hover:text-black transition-colors duration-200">
                    <i class="fas fa-star mr-2"></i>
                    Featured Items
                </a>
            </div>
        </div>
        
        <!-- Floating Game Icons -->
        <div class="absolute top-10 left-10 animate-float">
            <i class="fas fa-gamepad text-neon-blue text-3xl opacity-20"></i>
        </div>
        <div class="absolute top-20 right-20 animate-float" style="animation-delay: 1s;">
            <i class="fas fa-trophy text-neon-green text-4xl opacity-20"></i>
        </div>
        <div class="absolute bottom-20 left-1/4 animate-float" style="animation-delay: 2s;">
            <i class="fas fa-coins text-neon-orange text-2xl opacity-20"></i>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="bg-dark-surface py-16">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="bg-gradient-to-r from-neon-blue to-neon-purple p-4 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
                <h3 class="font-gaming text-2xl font-bold text-neon-blue mb-2">50K+</h3>
                <p class="text-gray-400">Happy Gamers</p>
            </div>
            <div class="text-center">
                <div class="bg-gradient-to-r from-neon-green to-neon-blue p-4 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-shopping-bag text-white text-2xl"></i>
                </div>
                <h3 class="font-gaming text-2xl font-bold text-neon-green mb-2">100K+</h3>
                <p class="text-gray-400">Orders Delivered</p>
            </div>
            <div class="text-center">
                <div class="bg-gradient-to-r from-neon-purple to-neon-orange p-4 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-gamepad text-white text-2xl"></i>
                </div>
                <h3 class="font-gaming text-2xl font-bold text-neon-purple mb-2">500+</h3>
                <p class="text-gray-400">Games Supported</p>
            </div>
            <div class="text-center">
                <div class="bg-gradient-to-r from-neon-orange to-neon-green p-4 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-clock text-white text-2xl"></i>
                </div>
                <h3 class="font-gaming text-2xl font-bold text-neon-orange mb-2">24/7</h3>
                <p class="text-gray-400">Support</p>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="font-gaming text-4xl font-bold text-white mb-4">Game Categories</h2>
            <p class="text-gray-400 text-lg">Choose your battleground</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @if(isset($categories) && count($categories) > 0)
                @foreach($categories as $category)
                    <div class="bg-dark-card border border-gray-700 rounded-xl p-6 hover:border-neon-blue transition-all duration-300 group cursor-pointer">
                        <div class="text-center">
                            <div class="bg-gradient-to-r from-neon-blue to-neon-purple p-4 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="fas fa-gamepad text-white text-2xl"></i>
                            </div>
                            <h3 class="text-white font-bold text-lg mb-2 group-hover:text-neon-blue transition-colors">{{ $category->name }}</h3>
                            <p class="text-gray-400 text-sm mb-4">{{ $category->description ?? 'Premium gaming items' }}</p>
                            <div class="text-neon-green font-bold">{{ $category->products_count ?? 0 }} Items</div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="bg-dark-card border border-gray-700 rounded-xl p-6 hover:border-neon-blue transition-all duration-300 group cursor-pointer">
                    <div class="text-center">
                        <div class="bg-gradient-to-r from-neon-blue to-neon-purple p-4 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fas fa-gamepad text-white text-2xl"></i>
                        </div>
                        <h3 class="text-white font-bold text-lg mb-2 group-hover:text-neon-blue transition-colors">Gaming Accounts</h3>
                        <p class="text-gray-400 text-sm mb-4">Premium gaming accounts</p>
                        <div class="text-neon-green font-bold">50+ Items</div>
                    </div>
                </div>
                <div class="bg-dark-card border border-gray-700 rounded-xl p-6 hover:border-neon-green transition-all duration-300 group cursor-pointer">
                    <div class="text-center">
                        <div class="bg-gradient-to-r from-neon-green to-neon-blue p-4 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fas fa-coins text-white text-2xl"></i>
                        </div>
                        <h3 class="text-white font-bold text-lg mb-2 group-hover:text-neon-green transition-colors">Game Currency</h3>
                        <p class="text-gray-400 text-sm mb-4">UC, Diamonds, Gold</p>
                        <div class="text-neon-green font-bold">100+ Items</div>
                    </div>
                </div>
                <div class="bg-dark-card border border-gray-700 rounded-xl p-6 hover:border-neon-purple transition-all duration-300 group cursor-pointer">
                    <div class="text-center">
                        <div class="bg-gradient-to-r from-neon-purple to-neon-orange p-4 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fas fa-trophy text-white text-2xl"></i>
                        </div>
                        <h3 class="text-white font-bold text-lg mb-2 group-hover:text-neon-purple transition-colors">Boosting</h3>
                        <p class="text-gray-400 text-sm mb-4">Rank boosting services</p>
                        <div class="text-neon-green font-bold">25+ Services</div>
                    </div>
                </div>
                <div class="bg-dark-card border border-gray-700 rounded-xl p-6 hover:border-neon-orange transition-all duration-300 group cursor-pointer">
                    <div class="text-center">
                        <div class="bg-gradient-to-r from-neon-orange to-neon-green p-4 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fas fa-gem text-white text-2xl"></i>
                        </div>
                        <h3 class="text-white font-bold text-lg mb-2 group-hover:text-neon-orange transition-colors">Premium Items</h3>
                        <p class="text-gray-400 text-sm mb-4">Rare collectibles</p>
                        <div class="text-neon-green font-bold">75+ Items</div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section id="featured" class="bg-dark-surface py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="font-gaming text-4xl font-bold text-white mb-4">Featured Products</h2>
            <p class="text-gray-400 text-lg">Top picks for serious gamers</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @include('themes.gamey.components.product-card')
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ url('/products') }}" class="bg-gradient-to-r from-neon-blue to-neon-purple text-white px-8 py-3 rounded-lg font-bold hover:scale-105 transition-transform duration-200">
                View All Products
            </a>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="font-gaming text-4xl font-bold text-white mb-4">Why Choose Gamey?</h2>
            <p class="text-gray-400 text-lg">We're the ultimate gaming marketplace</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="bg-gradient-to-r from-neon-blue to-neon-purple p-6 rounded-full w-20 h-20 mx-auto mb-6 flex items-center justify-center">
                    <i class="fas fa-shield-alt text-white text-3xl"></i>
                </div>
                <h3 class="text-white font-bold text-xl mb-4">100% Secure</h3>
                <p class="text-gray-400">All transactions are protected with advanced security measures</p>
            </div>
            <div class="text-center">
                <div class="bg-gradient-to-r from-neon-green to-neon-blue p-6 rounded-full w-20 h-20 mx-auto mb-6 flex items-center justify-center">
                    <i class="fas fa-bolt text-white text-3xl"></i>
                </div>
                <h3 class="text-white font-bold text-xl mb-4">Instant Delivery</h3>
                <p class="text-gray-400">Get your digital goods delivered instantly after purchase</p>
            </div>
            <div class="text-center">
                <div class="bg-gradient-to-r from-neon-purple to-neon-orange p-6 rounded-full w-20 h-20 mx-auto mb-6 flex items-center justify-center">
                    <i class="fas fa-headset text-white text-3xl"></i>
                </div>
                <h3 class="text-white font-bold text-xl mb-4">24/7 Support</h3>
                <p class="text-gray-400">Our gaming experts are always ready to help you</p>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
</script>
@endpush 