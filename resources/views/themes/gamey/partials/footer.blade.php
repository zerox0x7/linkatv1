<!-- Footer -->
<footer class="bg-dark-surface border-t border-gray-700 mt-16">
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Company Info -->
            <div>
                <div class="flex items-center mb-6">
                    @if(isset($themeConfig['settings']['logos']['logo']))
                        <img src="{{ $themeConfig['settings']['logos']['logo'] }}" alt="Gamey Store" class="h-8 w-auto">
                    @else
                        <div class="flex items-center">
                            <div class="bg-gradient-to-r from-neon-blue to-neon-purple p-2 rounded-lg mr-3">
                                <i class="fas fa-gamepad text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-gaming text-xl font-bold text-white">GAMEY</h3>
                                <p class="text-xs text-gray-400">Gaming Paradise</p>
                            </div>
                        </div>
                    @endif
                </div>
                <p class="text-gray-400 mb-6">Your ultimate destination for premium gaming accounts, in-game currency, and digital goods. Level up your gaming experience with us!</p>
                
                <!-- Social Links -->
                <div class="flex space-x-4">
                    @if(isset($themeConfig['settings']['integrations']['social_links']))
                        @foreach($themeConfig['settings']['integrations']['social_links'] as $platform => $link)
                            <a href="{{ $link }}" class="bg-dark-card text-gray-400 hover:text-neon-blue hover:bg-gray-700 p-3 rounded-lg transition-colors" target="_blank">
                                <i class="fab fa-{{ $platform }}"></i>
                            </a>
                        @endforeach
                    @else
                        <a href="#" class="bg-dark-card text-gray-400 hover:text-neon-blue hover:bg-gray-700 p-3 rounded-lg transition-colors">
                            <i class="fab fa-discord"></i>
                        </a>
                        <a href="#" class="bg-dark-card text-gray-400 hover:text-neon-green hover:bg-gray-700 p-3 rounded-lg transition-colors">
                            <i class="fab fa-telegram"></i>
                        </a>
                        <a href="#" class="bg-dark-card text-gray-400 hover:text-neon-purple hover:bg-gray-700 p-3 rounded-lg transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="bg-dark-card text-gray-400 hover:text-neon-orange hover:bg-gray-700 p-3 rounded-lg transition-colors">
                            <i class="fab fa-youtube"></i>
                        </a>
                    @endif
                </div>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h4 class="font-gaming text-lg font-bold text-white mb-6">Quick Links</h4>
                <ul class="space-y-3">
                    <li><a href="{{ url('/') }}" class="text-gray-400 hover:text-neon-blue transition-colors flex items-center"><i class="fas fa-home mr-2"></i>Home</a></li>
                    <li><a href="{{ url('/products') }}" class="text-gray-400 hover:text-neon-blue transition-colors flex items-center"><i class="fas fa-shopping-bag mr-2"></i>Products</a></li>
                    <li><a href="{{ url('/categories') }}" class="text-gray-400 hover:text-neon-blue transition-colors flex items-center"><i class="fas fa-th-large mr-2"></i>Categories</a></li>
                    <li><a href="{{ url('/deals') }}" class="text-gray-400 hover:text-neon-green transition-colors flex items-center"><i class="fas fa-fire mr-2"></i>Hot Deals</a></li>
                    <li><a href="{{ url('/new-arrivals') }}" class="text-gray-400 hover:text-neon-purple transition-colors flex items-center"><i class="fas fa-star mr-2"></i>New Arrivals</a></li>
                </ul>
            </div>
            
            <!-- Customer Support -->
            <div>
                <h4 class="font-gaming text-lg font-bold text-white mb-6">Support</h4>
                <ul class="space-y-3">
                    <li><a href="{{ url('/support') }}" class="text-gray-400 hover:text-neon-blue transition-colors flex items-center"><i class="fas fa-headset mr-2"></i>24/7 Support</a></li>
                    <li><a href="{{ url('/faq') }}" class="text-gray-400 hover:text-neon-blue transition-colors flex items-center"><i class="fas fa-question-circle mr-2"></i>FAQ</a></li>
                    <li><a href="{{ url('/how-it-works') }}" class="text-gray-400 hover:text-neon-blue transition-colors flex items-center"><i class="fas fa-play-circle mr-2"></i>How It Works</a></li>
                    <li><a href="{{ url('/safety') }}" class="text-gray-400 hover:text-neon-blue transition-colors flex items-center"><i class="fas fa-shield-alt mr-2"></i>Safety & Security</a></li>
                    <li><a href="{{ url('/contact') }}" class="text-gray-400 hover:text-neon-blue transition-colors flex items-center"><i class="fas fa-envelope mr-2"></i>Contact Us</a></li>
                </ul>
            </div>
            
            <!-- Newsletter & Contact -->
            <div>
                <h4 class="font-gaming text-lg font-bold text-white mb-6">Stay Connected</h4>
                <p class="text-gray-400 mb-4">Get the latest gaming deals and updates!</p>
                
                <form class="mb-6">
                    <div class="flex">
                        <input type="email" 
                               placeholder="Your email address" 
                               class="flex-1 bg-dark-card border border-gray-600 rounded-l-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:border-neon-blue">
                        <button type="submit" 
                                class="bg-gradient-to-r from-neon-blue to-neon-purple text-white px-4 py-2 rounded-r-lg hover:scale-105 transition-transform">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
                
                <!-- Contact Info -->
                <div class="space-y-3">
                    <div class="flex items-center text-gray-400">
                        <i class="fas fa-envelope text-neon-blue mr-3"></i>
                        <span>support@gameystore.com</span>
                    </div>
                    <div class="flex items-center text-gray-400">
                        <i class="fas fa-phone text-neon-green mr-3"></i>
                        <span>+1 (555) 123-GAME</span>
                    </div>
                    <div class="flex items-center text-gray-400">
                        <i class="fas fa-clock text-neon-purple mr-3"></i>
                        <span>24/7 Available</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Trust Badges -->
        <div class="border-t border-gray-700 mt-12 pt-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                <div class="flex items-center justify-center p-4 bg-dark-card rounded-lg border border-gray-700">
                    <div class="text-center">
                        <i class="fas fa-shield-alt text-neon-blue text-2xl mb-2"></i>
                        <p class="text-gray-400 text-sm">100% Secure</p>
                    </div>
                </div>
                <div class="flex items-center justify-center p-4 bg-dark-card rounded-lg border border-gray-700">
                    <div class="text-center">
                        <i class="fas fa-bolt text-neon-green text-2xl mb-2"></i>
                        <p class="text-gray-400 text-sm">Instant Delivery</p>
                    </div>
                </div>
                <div class="flex items-center justify-center p-4 bg-dark-card rounded-lg border border-gray-700">
                    <div class="text-center">
                        <i class="fas fa-undo text-neon-purple text-2xl mb-2"></i>
                        <p class="text-gray-400 text-sm">Money Back</p>
                    </div>
                </div>
                <div class="flex items-center justify-center p-4 bg-dark-card rounded-lg border border-gray-700">
                    <div class="text-center">
                        <i class="fas fa-headset text-neon-orange text-2xl mb-2"></i>
                        <p class="text-gray-400 text-sm">24/7 Support</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bottom Footer -->
        <div class="border-t border-gray-700 pt-8">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="text-gray-400 text-sm mb-4 md:mb-0">
                    © {{ date('Y') }} Gamey Store. All rights reserved. | Powered by Zain Theme System
                </div>
                <div class="flex items-center space-x-6 text-sm">
                    <a href="{{ url('/privacy') }}" class="text-gray-400 hover:text-neon-blue transition-colors">Privacy Policy</a>
                    <a href="{{ url('/terms') }}" class="text-gray-400 hover:text-neon-blue transition-colors">Terms of Service</a>
                    <a href="{{ url('/refund') }}" class="text-gray-400 hover:text-neon-blue transition-colors">Refund Policy</a>
                </div>
            </div>
        </div>
    </div>
</footer> 