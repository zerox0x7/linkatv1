<div class="theme-links-dropdown">
    @if($activeTheme && count($themeLinks) > 0)
        <div class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl border border-[#2a3548] shadow-lg overflow-hidden">
            <!-- Dropdown Header -->
            <div class="p-4 cursor-pointer" onclick="toggleThemeLinks()">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center">
                            <i class="ri-links-line text-blue-400"></i>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold text-sm">{{ $activeTheme->name ?? 'Theme Links' }}</h3>
                            <p class="text-gray-400 text-xs">Click to view and copy theme links</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="bg-green-500/10 text-green-400 px-2 py-1 rounded-lg text-xs font-medium border border-green-500/20">
                            <i class="ri-check-line mr-1"></i>Active
                        </span>
                        <i class="ri-arrow-down-s-line text-gray-400 transition-transform duration-300" id="theme-links-arrow"></i>
                    </div>
                </div>
            </div>

            <!-- Dropdown Content -->
            <div class="hidden border-t border-[#2a3548]" id="theme-links-content">
                <div class="p-4 bg-[#0f1623]/50">
                    @if($activeTheme->description)
                        <p class="text-gray-400 text-xs mb-4 leading-relaxed">{{ $activeTheme->description }}</p>
                    @endif
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($themeLinks as $index => $link)
                            <div wire:key="theme-link-{{ $index }}" class="bg-[#111827] rounded-lg p-3 border border-[#2a3548] hover:border-[#3a4558] transition-all duration-300 group">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="w-6 h-6 rounded bg-gradient-to-br from-blue-500/20 to-purple-500/20 flex items-center justify-center flex-shrink-0">
                                        @if(isset($link['icon']))
                                            <i class="{{ $link['icon'] }} text-blue-400 text-xs"></i>
                                        @else
                                            <i class="ri-link text-blue-400 text-xs"></i>
                                        @endif
                                    </div>
                                    <h4 class="text-white font-medium text-xs truncate flex-1">{{ $link['name'] ?? 'Link' }}</h4>
                                </div>
                                
                                @if(isset($link['description']))
                                    <p class="text-gray-400 text-xs leading-relaxed mb-2">{{ $link['description'] }}</p>
                                @endif
                                
                                <div class="bg-[#0f1623] border border-[#2a3548] rounded px-2 py-1 mb-3">
                                    <span class="text-gray-300 text-xs font-mono">{{ $link['route'] ?? '#' }}</span>
                                </div>
                                
                                <div class="flex items-center gap-1">
                                    @if(isset($link['route']))
                                        <a href="{{ $link['route'] }}" 
                                           class="flex-1 bg-gradient-to-r from-blue-600/20 to-blue-700/20 border border-blue-500/30 text-blue-400 text-xs font-medium py-1.5 px-2 rounded hover:from-blue-600/30 hover:to-blue-700/30 transition-all duration-300 flex items-center justify-center gap-1"
                                           target="_blank" 
                                           title="Visit Link">
                                            <i class="ri-external-link-line text-xs"></i>
                                            <span>Visit</span>
                                        </a>
                                        
                                        <button wire:click="copyToClipboard('{{ $link['route'] }}')" 
                                                class="bg-[#2a3548] text-gray-300 hover:text-white hover:bg-[#3a4558] p-1.5 rounded transition-all duration-300 flex items-center justify-center"
                                                title="Copy Route">
                                            <i class="ri-file-copy-line text-xs"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="bg-gradient-to-r from-[#121827] to-[#1a2234] rounded-xl p-4 border border-[#2a3548] shadow-lg">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-gray-500/10 flex items-center justify-center">
                    <i class="ri-links-line text-gray-400"></i>
                </div>
                <div>
                    <h3 class="text-white font-semibold text-sm">No Active Theme Links</h3>
                    <p class="text-gray-400 text-xs">Configure your theme links to display them here</p>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
function toggleThemeLinks() {
    const content = document.getElementById('theme-links-content');
    const arrow = document.getElementById('theme-links-arrow');
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        arrow.style.transform = 'rotate(180deg)';
    } else {
        content.classList.add('hidden');
        arrow.style.transform = 'rotate(0deg)';
    }
}

document.addEventListener('livewire:initialized', () => {
    Livewire.on('copy-to-clipboard', (event) => {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(event.url).then(() => {
                // Show success notification if available
                if (window.showNotification) {
                    window.showNotification('Route copied to clipboard!', 'success');
                } else {
                    // Simple fallback notification
                    const notification = document.createElement('div');
                    notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                    notification.textContent = 'Route copied to clipboard!';
                    document.body.appendChild(notification);
                    setTimeout(() => {
                        notification.remove();
                    }, 3000);
                }
            }).catch(err => {
                console.error('Failed to copy URL: ', err);
                fallbackCopyTextToClipboard(event.url);
            });
        } else {
            fallbackCopyTextToClipboard(event.url);
        }
    });
});

function fallbackCopyTextToClipboard(text) {
    const textArea = document.createElement("textarea");
    textArea.value = text;
    textArea.style.top = "0";
    textArea.style.left = "0";
    textArea.style.position = "fixed";
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    
    try {
        document.execCommand('copy');
        if (window.showNotification) {
            window.showNotification('Route copied to clipboard!', 'success');
        } else {
            // Simple fallback notification
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
            notification.textContent = 'Route copied to clipboard!';
            document.body.appendChild(notification);
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
    } catch (err) {
        console.error('Fallback: Failed to copy URL: ', err);
    }
    
    document.body.removeChild(textArea);
}
</script>
