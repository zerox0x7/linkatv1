<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الملف الشخصي</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#57b5e7',
                    secondary: '#8dd3c7'
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
        background-color: #0a1525;
        color: #fff;
        font-family: 'Inter', sans-serif;
        direction: rtl;
    }

    [class*="space-x-"]:not(.flex-row-reverse)> :not([hidden])~ :not([hidden]) {
        --tw-space-x-reverse: 1;
    }

    .flex:not(.flex-row-reverse)>.space-x-1> :not([hidden])~ :not([hidden]) {
        --tw-space-x-reverse: 1;
    }

    .flex:not(.flex-row-reverse)>.space-x-2> :not([hidden])~ :not([hidden]) {
        --tw-space-x-reverse: 1;
    }

    .flex:not(.flex-row-reverse)>.space-x-4> :not([hidden])~ :not([hidden]) {
        --tw-space-x-reverse: 1;
    }

    .flex:not(.flex-row-reverse)>.space-x-6> :not([hidden])~ :not([hidden]) {
        --tw-space-x-reverse: 1;
    }

    .flex:not(.flex-row-reverse)>.space-x-8> :not([hidden])~ :not([hidden]) {
        --tw-space-x-reverse: 1;
    }

    .glow-effect {
        box-shadow: 0 0 8px rgba(87, 181, 231, 0.15);
    }

    .card-gradient {
        background: linear-gradient(180deg, rgba(30, 41, 59, 0.8) 0%, rgba(15, 23, 42, 0.9) 100%);
    }

    .profile-card {
        transition: all 0.3s ease;
    }

    .profile-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 3px 8px rgba(87, 181, 231, 0.1);
    }

    .glass-effect {
        background: linear-gradient(180deg, rgba(30, 41, 59, 0.8) 0%, rgba(15, 23, 42, 0.9) 100%);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(87, 181, 231, 0.1);
    }

    .neon-glow {
        box-shadow: 0 0 5px rgba(87, 181, 231, 0.2);
    }

    .neon-glow:hover {
        box-shadow: 0 0 10px rgba(87, 181, 231, 0.3);
    }

    input[type="text"], input[type="email"], input[type="password"], input[type="file"] {
        background-color: #1e293b;
        border: 1px solid #374151;
        transition: all 0.3s ease;
    }

    input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus, input[type="file"]:focus {
        border-color: #57b5e7;
        box-shadow: 0 0 0 2px rgba(87, 181, 231, 0.08);
    }

    .status-badge {
        text-shadow: 0 0 3px rgba(0, 0, 0, 0.3);
    }
    </style>
</head>

<body class="min-h-screen">
    @include('themes.greenGame.partials.header')

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-6">
        <div class="max-w-6xl mx-auto">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-white mb-2">الملف الشخصي</h1>
                <p class="text-gray-400">إدارة معلوماتك الشخصية وإعداداتك</p>
            </div>

            @if(session('success'))
            <div class="bg-green-800/25 border border-green-600 text-green-100 px-4 py-3 rounded-xl mb-6 flex items-center space-x-2 flex-row-reverse">
                <i class="ri-check-line text-green-400"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            <!-- Profile Information Card -->
            <div class="profile-card bg-[#1e293b] rounded-xl overflow-hidden mb-8 glow-effect">
                <div class="p-6">
                    <div class="flex items-center space-x-4 mb-6 flex-row-reverse">
                        <i class="ri-user-3-line text-primary text-2xl"></i>
                        <h2 class="text-xl font-bold text-white">معلومات الملف الشخصي</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Avatar Section -->
                        <div class="flex flex-col items-center">
                            <div class="w-32 h-32 rounded-full overflow-hidden bg-[#0f172a] mb-4 border-4 border-primary/20">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-[#1e293b] text-gray-300">
                                        <i class="ri-user-3-line ri-3x text-primary"></i>
                                    </div>
                                @endif
                            </div>
                            <h3 class="text-xl font-semibold text-white mb-2">{{ $user->name }}</h3>
                            <div class="flex items-center space-x-2 flex-row-reverse text-gray-400 mb-4">
                                <i class="ri-calendar-line text-sm"></i>
                                <span class="text-sm">عضو منذ {{ $user->created_at->format('Y/m/d') }}</span>
                            </div>
                            
                            <!-- Logout Button -->
                            <form action="{{ route('logout') }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-button font-medium transition-all neon-glow flex items-center justify-center space-x-2 flex-row-reverse">
                                    <i class="ri-logout-circle-line"></i>
                                    <span>تسجيل الخروج</span>
                                </button>
                            </form>
                        </div>
                        
                        <!-- Profile Form -->
                        <div class="lg:col-span-2">
                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="name" class="block text-gray-300 mb-2 flex items-center space-x-2 flex-row-reverse">
                                            <i class="ri-user-line text-primary"></i>
                                            <span>الاسم</span>
                                        </label>
                                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                                            class="w-full bg-[#1e293b] border border-gray-600 rounded-button py-3 px-4 text-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                                        @error('name')
                                            <p class="text-red-400 text-sm mt-1 flex items-center space-x-1 flex-row-reverse">
                                                <i class="ri-error-warning-line"></i>
                                                <span>{{ $message }}</span>
                                            </p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="email" class="block text-gray-300 mb-2 flex items-center space-x-2 flex-row-reverse">
                                            <i class="ri-mail-line text-primary"></i>
                                            <span>البريد الإلكتروني</span>
                                        </label>
                                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                                            class="w-full bg-[#1e293b] border border-gray-600 rounded-button py-3 px-4 text-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                                        @error('email')
                                            <p class="text-red-400 text-sm mt-1 flex items-center space-x-1 flex-row-reverse">
                                                <i class="ri-error-warning-line"></i>
                                                <span>{{ $message }}</span>
                                            </p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="phone" class="block text-gray-300 mb-2 flex items-center space-x-2 flex-row-reverse">
                                            <i class="ri-phone-line text-primary"></i>
                                            <span>رقم الهاتف</span>
                                        </label>
                                        <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" 
                                            class="w-full bg-[#1e293b] border border-gray-600 rounded-button py-3 px-4 text-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                                        @error('phone')
                                            <p class="text-red-400 text-sm mt-1 flex items-center space-x-1 flex-row-reverse">
                                                <i class="ri-error-warning-line"></i>
                                                <span>{{ $message }}</span>
                                            </p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="avatar" class="block text-gray-300 mb-2 flex items-center space-x-2 flex-row-reverse">
                                            <i class="ri-image-line text-primary"></i>
                                            <span>تغيير الصورة الشخصية</span>
                                        </label>
                                        <input type="file" name="avatar" id="avatar" 
                                            class="w-full bg-[#1e293b] border border-gray-600 rounded-button py-3 px-4 text-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                                        @error('avatar')
                                            <p class="text-red-400 text-sm mt-1 flex items-center space-x-1 flex-row-reverse">
                                                <i class="ri-error-warning-line"></i>
                                                <span>{{ $message }}</span>
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="mt-6">
                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-button font-medium transition-all neon-glow flex items-center space-x-2 flex-row-reverse">
                                        <i class="ri-save-line"></i>
                                        <span>حفظ التغييرات</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Password Change Card -->
            <div class="profile-card bg-[#1e293b] rounded-xl overflow-hidden mb-8 glow-effect">
                <div class="p-6">
                    <div class="flex items-center space-x-4 mb-6 flex-row-reverse">
                        <i class="ri-lock-password-line text-primary text-2xl"></i>
                        <h2 class="text-xl font-bold text-white">تغيير كلمة المرور</h2>
                    </div>
                    
                    <form action="{{ route('profile.update-password') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="current_password" class="block text-gray-300 mb-2 flex items-center space-x-2 flex-row-reverse">
                                    <i class="ri-lock-line text-primary"></i>
                                    <span>كلمة المرور الحالية</span>
                                </label>
                                <input type="password" name="current_password" id="current_password" 
                                    class="w-full bg-[#1e293b] border border-gray-600 rounded-button py-3 px-4 text-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                                @error('current_password')
                                    <p class="text-red-400 text-sm mt-1 flex items-center space-x-1 flex-row-reverse">
                                        <i class="ri-error-warning-line"></i>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="password" class="block text-gray-300 mb-2 flex items-center space-x-2 flex-row-reverse">
                                    <i class="ri-lock-2-line text-primary"></i>
                                    <span>كلمة المرور الجديدة</span>
                                </label>
                                <input type="password" name="password" id="password" 
                                    class="w-full bg-[#1e293b] border border-gray-600 rounded-button py-3 px-4 text-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                                @error('password')
                                    <p class="text-red-400 text-sm mt-1 flex items-center space-x-1 flex-row-reverse">
                                        <i class="ri-error-warning-line"></i>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="password_confirmation" class="block text-gray-300 mb-2 flex items-center space-x-2 flex-row-reverse">
                                    <i class="ri-lock-2-line text-primary"></i>
                                    <span>تأكيد كلمة المرور الجديدة</span>
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation" 
                                    class="w-full bg-[#1e293b] border border-gray-600 rounded-button py-3 px-4 text-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-button font-medium transition-all neon-glow flex items-center space-x-2 flex-row-reverse">
                                <i class="ri-refresh-line"></i>
                                <span>تحديث كلمة المرور</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Recent Orders Card -->
            <div class="profile-card bg-[#1e293b] rounded-xl overflow-hidden mb-8 glow-effect">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-4 flex-row-reverse">
                            <i class="ri-shopping-bag-line text-primary text-2xl"></i>
                            <h2 class="text-xl font-bold text-white">آخر الطلبات</h2>
                        </div>
                        @if(isset($orders) && $orders && $orders->count() > 0)
                        <a href="{{ route('orders.index') }}" class="text-primary hover:text-blue-400 flex items-center space-x-1 text-sm flex-row-reverse">
                            <span>عرض الكل</span>
                            <i class="ri-arrow-left-s-line"></i>
                        </a>
                        @endif
                    </div>
                    
                    @if(isset($orders) && $orders && $orders->count() > 0)
                        <!-- Desktop Table View -->
                        <div class="hidden lg:block overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-gray-700">
                                        <th class="py-4 px-4 text-right text-gray-300 font-medium">رقم الطلب</th>
                                        <th class="py-4 px-4 text-right text-gray-300 font-medium">التاريخ</th>
                                        <th class="py-4 px-4 text-right text-gray-300 font-medium">المبلغ</th>
                                        <th class="py-4 px-4 text-right text-gray-300 font-medium">الحالة</th>
                                        <th class="py-4 px-4 text-right text-gray-300 font-medium">الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr class="border-b border-gray-800/50 hover:bg-gray-800/30 transition-colors">
                                        <td class="py-4 px-4 text-white font-medium">#{{ $order->order_number }}</td>
                                        <td class="py-4 px-4 text-gray-300">{{ $order->created_at->format('Y-m-d') }}</td>
                                        <td class="py-4 px-4 text-green-400 font-semibold">{{ $order->total }} {{ \App\Models\Setting::get('currency_symbol', 'ر.س') }}</td>
                                        <td class="py-4 px-4">
                                            <span class="status-badge inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                                @if($order->status === 'completed') bg-green-500/20 text-green-400 border border-green-500/30
                                                @elseif($order->status === 'pending') bg-yellow-500/20 text-yellow-400 border border-yellow-500/30
                                                @elseif($order->status === 'cancelled') bg-red-500/20 text-red-400 border border-red-500/30
                                                @else bg-blue-500/20 text-blue-400 border border-blue-500/30 @endif">
                                                @if($order->status === 'completed')
                                                    <i class="ri-check-line mr-1"></i>
                                                    مكتمل
                                                @elseif($order->status === 'pending')
                                                    <i class="ri-time-line mr-1"></i>
                                                    قيد الانتظار
                                                @elseif($order->status === 'cancelled')
                                                    <i class="ri-close-line mr-1"></i>
                                                    ملغي
                                                @else
                                                    <i class="ri-loader-line mr-1"></i>
                                                    قيد المعالجة
                                                @endif
                                            </span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <a href="{{ route('orders.show', $order->id) }}" class="bg-primary/20 hover:bg-primary/30 text-primary px-4 py-2 rounded-button text-sm font-medium transition-all flex items-center space-x-1 flex-row-reverse w-fit">
                                                <i class="ri-eye-line"></i>
                                                <span>عرض التفاصيل</span>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Mobile Card View -->
                        <div class="lg:hidden space-y-4">
                            @foreach($orders as $order)
                            <div class="bg-[#0f172a] rounded-xl p-4 border border-gray-800/50 hover:border-primary/30 transition-all">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h3 class="text-white font-bold text-lg">#{{ $order->order_number }}</h3>
                                        <div class="flex items-center space-x-2 flex-row-reverse text-gray-400 text-sm mt-1">
                                            <i class="ri-calendar-line"></i>
                                            <span>{{ $order->created_at->format('Y-m-d') }}</span>
                                        </div>
                                    </div>
                                    <span class="status-badge inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                        @if($order->status === 'completed') bg-green-500/20 text-green-400 border border-green-500/30
                                        @elseif($order->status === 'pending') bg-yellow-500/20 text-yellow-400 border border-yellow-500/30
                                        @elseif($order->status === 'cancelled') bg-red-500/20 text-red-400 border border-red-500/30
                                        @else bg-blue-500/20 text-blue-400 border border-blue-500/30 @endif">
                                        {{ $order->status === 'completed' ? 'مكتمل' : 
                                          ($order->status === 'pending' ? 'قيد الانتظار' : 
                                          ($order->status === 'cancelled' ? 'ملغي' : 'قيد المعالجة')) }}
                                    </span>
                                </div>
                                
                                @if($order->items && $order->items->count() > 0)
                                <div class="mb-3">
                                    <div class="text-xs text-gray-400 mb-2 flex items-center space-x-1 flex-row-reverse">
                                        <i class="ri-shopping-cart-line"></i>
                                        <span>المنتجات:</span>
                                    </div>
                                    <div class="space-y-1">
                                        @foreach($order->items->take(2) as $index => $item)
                                            <div class="text-sm text-gray-300 truncate bg-gray-800/50 px-2 py-1 rounded">{{ $item->name ?? 'منتج #' . $index }}</div>
                                        @endforeach
                                        @if($order->items->count() > 2)
                                            <div class="text-xs text-gray-400 px-2">+ {{ $order->items->count() - 2 }} منتجات أخرى</div>
                                        @endif
                                    </div>
                                </div>
                                @endif
                                
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center space-x-2 flex-row-reverse">
                                        <i class="ri-money-dollar-circle-line text-green-400"></i>
                                        <span class="text-green-400 font-bold text-lg">{{ $order->total }} {{ \App\Models\Setting::get('currency_symbol', 'ر.س') }}</span>
                                    </div>
                                    <a href="{{ route('orders.show', $order->id) }}" class="bg-primary/20 hover:bg-primary/30 text-primary px-4 py-2 rounded-button text-sm font-medium transition-all flex items-center space-x-1 flex-row-reverse">
                                        <i class="ri-eye-line"></i>
                                        <span>عرض</span>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-[#0f172a] rounded-xl p-8 text-center border border-gray-800/50">
                            <i class="ri-shopping-bag-line text-5xl text-gray-400 mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-300 mb-2">لا توجد طلبات سابقة</h3>
                            <p class="text-gray-400 mb-4">لم تقم بإجراء أي طلبات حتى الآن</p>
                            <a href="{{ route('home') }}" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-button font-medium transition-all neon-glow inline-flex items-center space-x-2 flex-row-reverse">
                                <i class="ri-shopping-cart-line"></i>
                                <span>تصفح المنتجات</span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    @include('themes.greenGame.partials.footer')

    <script>
    // Form validation and interaction effects
    document.addEventListener('DOMContentLoaded', function() {
        // Add loading state to forms
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML = '<i class="ri-loader-2-line animate-spin"></i><span>جاري الحفظ...</span>';
                    submitBtn.disabled = true;
                }
            });
        });

        // File input preview
        const avatarInput = document.getElementById('avatar');
        if (avatarInput) {
            avatarInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const avatarImg = document.querySelector('.rounded-full img');
                        if (avatarImg) {
                            avatarImg.src = e.target.result;
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });
    </script>
</body>

</html>