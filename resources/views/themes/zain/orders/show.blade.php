@extends('themes.default.layouts.app')

@section('title', 'تفاصيل الطلب #' . $order->order_number)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumbs -->
    <div class="flex items-center text-sm text-gray-400 mb-6">
        <a href="{{ route('home') }}" class="hover:text-primary">الرئيسية</a>
        <i class="ri-arrow-left-s-line mx-2"></i>
        <a href="{{ route('orders.index') }}" class="hover:text-primary">طلباتي</a>
        <i class="ri-arrow-left-s-line mx-2"></i>
        <span class="text-gray-300">تفاصيل الطلب #{{ $order->order_number }}</span>
    </div>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white">تفاصيل الطلب <span class="text-primary">#{{ $order->order_number }}</span></h1>
        <p class="text-gray-400">تاريخ الطلب: {{ $order->created_at->format('Y-m-d H:i') }}</p>
    </div>

    <!-- حالة الطلب -->
    <div class="glass-effect rounded-lg p-5 mb-6">
        <div class="flex flex-wrap justify-between items-center mb-4">
            <div>
                <h3 class="text-xl font-bold text-white mb-1">حالة الطلب</h3>
                @php
                    $statusClasses = [
                        'pending' => 'bg-yellow-600 bg-opacity-20 border-yellow-600 text-yellow-100',
                        'processing' => 'bg-blue-600 bg-opacity-20 border-blue-600 text-blue-100',
                        'completed' => 'bg-green-600 bg-opacity-20 border-green-600 text-green-100',
                        'cancelled' => 'bg-red-600 bg-opacity-20 border-red-600 text-red-100',
                        'payment_failed' => 'bg-red-600 bg-opacity-20 border-red-600 text-red-100',
                        'pending_confirmation' => 'bg-purple-600 bg-opacity-20 border-purple-600 text-purple-100',
                    ];
                    $statusText = [
                        'pending' => 'قيد الانتظار',
                        'processing' => 'قيد المعالجة',
                        'completed' => 'مكتمل',
                        'cancelled' => 'ملغي',
                        'payment_failed' => 'فشل الدفع',
                        'pending_confirmation' => 'بانتظار تأكيد الدفع',
                    ];
                @endphp
                <span class="inline-block py-1 px-3 rounded border {{ $statusClasses[$order->status] ?? 'bg-gray-600 bg-opacity-20 border-gray-600 text-gray-100' }}">
                    {{ $statusText[$order->status] ?? $order->status }}
                </span>
            </div>
            <div>
                <span class="text-white mr-2">حالة الدفع:</span>
                <span class="inline-block py-1 px-3 rounded border {{ $order->payment_status == 'paid' ? 'bg-green-600 bg-opacity-20 border-green-600 text-green-100' : 'bg-yellow-600 bg-opacity-20 border-yellow-600 text-yellow-100' }}">
                    {{ $order->payment_status == 'paid' ? 'مدفوع' : 'غير مدفوع' }}
                </span>
            </div>
            
            <!-- زر إلغاء الطلب -->
            @if($order->status == 'pending' || $order->status == 'pending_confirmation')
            <div class="mt-4 sm:mt-0">
                <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من رغبتك في إلغاء هذا الطلب؟');">
                    @csrf
                    <button type="submit" class="bg-gradient-to-r from-red-600 to-red-700 text-white px-4 py-2 rounded-button flex items-center hover:opacity-90 transition-all">
                        <i class="ri-close-circle-line ml-2"></i>إلغاء الطلب
                    </button>
                </form>
            </div>
            @endif
        </div>

        <!-- خط زمني للطلب -->
        <div class="relative mt-8">
            <div class="absolute left-0 right-0 top-1/2 -translate-y-1/2 h-1 bg-gray-700"></div>
            <div class="flex justify-between relative z-10">
                <div class="text-center">
                    <div class="w-8 h-8 rounded-full {{ $order->created_at ? 'bg-primary' : 'bg-gray-700' }} text-white inline-flex items-center justify-center mb-2">
                        <i class="ri-checkbox-circle-fill"></i>
                    </div>
                    <div class="text-xs text-gray-400">الطلب</div>
                </div>
                <div class="text-center">
                    <div class="w-8 h-8 rounded-full {{ in_array($order->status, ['processing', 'completed']) ? 'bg-primary' : 'bg-gray-700' }} text-white inline-flex items-center justify-center mb-2">
                        <i class="ri-checkbox-circle-fill"></i>
                    </div>
                    <div class="text-xs text-gray-400">المعالجة</div>
                </div>
                <div class="text-center">
                    <div class="w-8 h-8 rounded-full {{ $order->status == 'completed' ? 'bg-primary' : 'bg-gray-700' }} text-white inline-flex items-center justify-center mb-2">
                        <i class="ri-checkbox-circle-fill"></i>
                    </div>
                    <div class="text-xs text-gray-400">إتمام</div>
                </div>
            </div>
        </div>
    </div>

    <!-- معلومات الطلب الأساسية - تم تصغيره -->
    <div class="glass-effect rounded-lg p-5 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gray-800 bg-opacity-50 p-3 rounded-lg">
                <p class="text-gray-400 mb-1">رقم الطلب:</p>
                <p class="text-white font-bold">#{{ $order->id }}</p>
            </div>
            <div class="bg-gray-800 bg-opacity-50 p-3 rounded-lg">
                <p class="text-gray-400 mb-1">تاريخ الطلب:</p>
                <p class="text-white font-bold">{{ $order->created_at->format('Y-m-d H:i') }}</p>
            </div>
            <div class="bg-gray-800 bg-opacity-50 p-3 rounded-lg">
                <p class="text-gray-400 mb-1">طريقة الدفع:</p>
                <p class="text-white font-bold">
                    @php
                        $paymentMethods = [
                            'credit_card' => 'بطاقة ائتمان',
                            'clickpay' => 'كليك باي',
                            'bank_transfer' => 'تحويل بنكي',
                            'cash_on_delivery' => 'الدفع عند الاستلام',
                        ];
                    @endphp
                    {{ $paymentMethods[$order->payment_method] ?? $order->payment_method }}
                </p>
            </div>
        </div>

        <!-- إذا لم يتم الدفع وحالة الطلب معلقة، اعرض أزرار الدفع -->
        @if($order->payment_status !== 'paid' && !in_array($order->status, ['cancelled', 'completed']))
        <div class="mt-6">
            <h4 class="text-white mb-3">إتمام الدفع:</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <a href="{{ route('payment.clickpay', $order->id) }}" class="bg-gradient-to-r from-green-600 to-green-700 text-white text-center py-2 px-4 rounded-button neon-glow flex items-center justify-center hover:opacity-90 transition-all">
                    <i class="ri-bank-card-line ml-2"></i>الدفع بالبطاقة
                </a>
                <a href="{{ route('payment.bank_transfer', $order->id) }}" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white text-center py-2 px-4 rounded-button neon-glow flex items-center justify-center hover:opacity-90 transition-all">
                    <i class="ri-bank-line ml-2"></i>تحويل بنكي
                </a>
            </div>
        </div>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- بيانات الطلب -->
        <div class="glass-effect rounded-lg p-5 md:col-span-3">
            <h3 class="text-xl font-bold text-white mb-4">منتجات الطلب</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-gray-700">
                            <th class="py-3 text-right text-gray-400">المنتج</th>
                            <th class="py-3 text-center text-gray-400">الكمية</th>
                            <th class="py-3 text-center text-gray-400">السعر</th>
                            <th class="py-3 text-center text-gray-400">المجموع</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr class="border-b border-gray-800">
                            <td class="py-4">
                                <div class="flex items-center">
                                    @if($item->orderable->image)
                                    <img src="{{ asset('storage/' . $item->orderable->image) }}" alt="{{ $item->name }}" class="w-12 h-12 rounded object-cover mr-3">
                                    @else
                                    <div class="w-12 h-12 rounded bg-gray-800 flex items-center justify-center mr-3">
                                        <i class="ri-image-line text-gray-500"></i>
                                    </div>
                                    @endif
                                    <div>
                                        <p class="text-white">{{ $item->name }}</p>
                                        <p class="text-xs text-gray-400">{{ $item->orderable_type }}</p>
                                        
                                        @if(isset($item->options) && !empty($item->options))
                                            @if(isset($item->options['selected_option_name']) || isset($item->options['selected_price']))
                                            <div class="mt-2 bg-blue-900 bg-opacity-20 border border-blue-700 rounded p-2 text-xs">
                                                <span class="text-blue-300 font-bold">الخدمة المطلوبة:</span>
                                                <p class="text-blue-100 mt-1">{{ $item->options['selected_option_name'] ?? 'غير محدد' }}</p>
                                                @if(isset($item->options['selected_price']))
                                                <p class="text-green-300 mt-1">سعر الخدمة: {{ $item->options['selected_price'] }} ر.س</p>
                                                @endif
                                            </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 text-center text-white">{{ $item->quantity }}</td>
                            <td class="py-4 text-center text-white">{{ number_format($item->price, 2) }} ر.س</td>
                            <td class="py-4 text-center text-white">{{ number_format($item->price * $item->quantity, 2) }} ر.س</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-900 bg-opacity-50">
                            <td colspan="3" class="py-3 text-left text-white font-bold">المجموع الإجمالي:</td>
                            <td class="py-3 text-center text-white font-bold">{{ number_format($order->total, 2) }} ر.س</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- الأكواد الرقمية إذا وجدت -->
            @if(count($digitalCodes) > 0)
            <div class="mt-8">
                <div class="bg-green-600 bg-opacity-20 border border-green-600 text-green-100 px-6 py-4 rounded-lg mb-6">
                    <div class="flex items-start">
                        <i class="ri-checkbox-circle-line text-3xl mr-4"></i>
                        <div>
                            <h4 class="text-lg font-bold mb-2">تم تسليم المنتجات الرقمية بنجاح!</h4>
                            <p>تم تسليم أكواد البطاقات الرقمية التي قمت بشرائها تلقائياً. يمكنك الاطلاع على الأكواد أدناه.</p>
                            @if($order->status == 'completed')
                            <p class="mt-2">تم اكتمال الطلب تلقائياً نظراً لكونه يحتوي على منتجات رقمية فقط.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <h3 class="text-xl font-bold text-white mb-4 flex items-center">
                    <i class="ri-key-line text-primary mr-2"></i>
                    الأكواد الرقمية المشتراة
                </h3>
                
                @foreach($digitalCodes as $itemId => $codes)
                    @php
                        $item = $order->items->firstWhere('id', $itemId);
                        $allCodes = [];
                        
                        // Collect all codes with labels for better readability
                        foreach ($codes as $index => $code) {
                            $allCodes[] = "كود #" . ($index + 1) . ": " . $code->code;
                            
                            if (isset($code->serial_number) && $code->serial_number) {
                                $allCodes[] = "الرقم التسلسلي: " . $code->serial_number;
                            }
                            
                            if (!$loop->last) {
                                $allCodes[] = "-------------------";
                            }
                        }
                        
                        $allCodesText = implode("\n", $allCodes);
                    @endphp
                    
                    <div class="mb-6 bg-gray-900 bg-opacity-50 rounded-lg p-5 border-r-4 border-primary">
                        <div class="flex items-center mb-4">
                            @if($item->orderable->image)
                            <img src="{{ asset('storage/' . $item->orderable->image) }}" alt="{{ $item->name }}" class="w-16 h-16 rounded object-cover mr-4">
                            @else
                            <div class="w-16 h-16 rounded bg-gray-800 flex items-center justify-center mr-4">
                                <i class="ri-gamepad-line text-2xl text-gray-500"></i>
                            </div>
                            @endif
                            <div>
                                <h4 class="text-lg font-bold text-white">{{ $item->name }}</h4>
                                <p class="text-gray-400">{{ $item->quantity }} × {{ number_format($item->price, 2) }} ر.س</p>
                                
                                @if(isset($item->options) && !empty($item->options))
                                    @if(isset($item->options['selected_option_name']) || isset($item->options['selected_price']))
                                    <div class="mt-2 bg-blue-900 bg-opacity-20 border border-blue-700 rounded-md p-2 text-sm">
                                        <span class="text-blue-300 font-bold">الخدمة المطلوبة:</span>
                                        <p class="text-blue-100 mt-1">{{ $item->options['selected_option_name'] ?? 'غير محدد' }}</p>
                                    </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                        
                        <!-- عرض جميع الأكواد في قائمة بسيطة -->
                        <div class="bg-gray-800 rounded-lg p-4 border border-gray-700 hover:border-primary transition-all">
                            <div class="flex justify-between items-center mb-3">
                                <p class="text-lg text-gray-300 font-bold">جميع الأكواد ({{ count($codes) }})</p>
                                <button type="button" class="bg-primary hover:bg-primary/80 p-2 rounded ml-2 flex items-center" 
                                        onclick="copyAllCodes_{{ $itemId }}()" 
                                        title="نسخ جميع الأكواد">
                                    <i class="ri-file-copy-line text-white ml-1"></i>
                                    <span class="text-white">نسخ الكل</span>
                                </button>
                            </div>
                            
                            <!-- خط فاصل -->
                            <div class="w-full h-px bg-gray-700 my-3"></div>
                            
                            <!-- قائمة الأكواد -->
                            <div class="space-y-2">
                                @foreach($codes as $index => $code)
                                <div class="flex justify-between items-center bg-gray-900 p-3 rounded-md">
                                    <div class="font-mono text-primary font-bold select-all flex-grow" id="code-{{ $itemId }}-{{ $index }}">{{ $code->code }}</div>
                                    <button type="button" class="bg-gray-700 hover:bg-gray-600 p-2 rounded ml-2" 
                                            onclick="copySpecificText('code-{{ $itemId }}-{{ $index }}')" 
                                            title="نسخ الكود">
                                        <i class="ri-file-copy-line text-gray-300"></i>
                                    </button>
                                </div>
                                
                                @if(isset($code->serial_number) && $code->serial_number)
                                <div class="flex justify-between items-center bg-gray-900 p-3 rounded-md">
                                    <div class="font-mono text-primary font-bold select-all flex-grow" id="serial-{{ $itemId }}-{{ $index }}">{{ $code->serial_number }}</div>
                                    <button type="button" class="bg-gray-700 hover:bg-gray-600 p-2 rounded ml-2" 
                                            onclick="copySpecificText('serial-{{ $itemId }}-{{ $index }}')" 
                                            title="نسخ الرقم التسلسلي">
                                        <i class="ri-file-copy-line text-gray-300"></i>
                                    </button>
                                </div>
                                @endif
                                
                                @if(isset($code->expiry_date) && $code->expiry_date)
                                <div class="text-sm text-gray-400 mb-2">
                                    تاريخ الانتهاء: 
                                    <span class="text-white">
                                        @if(is_object($code->expiry_date) && method_exists($code->expiry_date, 'format'))
                                            {{ $code->expiry_date->format('Y-m-d') }}
                                        @else
                                            {{ $code->expiry_date }}
                                        @endif
                                    </span>
                                </div>
                                @endif
                                
                                <!-- خط فاصل بين الأكواد -->
                                @if(!$loop->last)
                                <div class="w-full h-px bg-gray-700 my-2"></div>
                                @endif
                                @endforeach
                            </div>
                            
                            <!-- خط فاصل -->
                            <div class="w-full h-px bg-gray-700 my-3"></div>
                            
                            <script>
                                // وظيفة نسخ جميع الأكواد لهذا العنصر فقط
                                function copyAllCodes_{{ $itemId }}() {
                                    let allCodesText = "";
                                    @foreach($codes as $index => $code)
                                        allCodesText += "كود #{{ $index + 1 }}: {{ $code->code }}\n";
                                        @if(isset($code->serial_number) && $code->serial_number)
                                            allCodesText += "الرقم التسلسلي: {{ $code->serial_number }}\n";
                                        @endif
                                        @if(!$loop->last)
                                            allCodesText += "-------------------\n";
                                        @endif
                                    @endforeach
                                    
                                    copyToClipboard(allCodesText, 'تم نسخ جميع الأكواد بنجاح');
                                }
                            </script>
                        </div>
                        
                        @if($item->orderable->instructions)
                        <div class="mt-4 bg-blue-900 bg-opacity-20 border border-blue-700 rounded-lg p-4">
                            <h5 class="text-blue-300 font-bold mb-2 flex items-center">
                                <i class="ri-information-line mr-2"></i>
                                تعليمات الاستخدام
                            </h5>
                            <div class="text-blue-100">
                                {!! nl2br(e($item->orderable->instructions)) !!}
                            </div>
                        </div>
                        @endif
                    </div>
                @endforeach
            </div>
            @endif
            
            <!-- بيانات المواصفات المخصصة إذا وجدت -->
            @if($order->has_custom_products)
            <div class="mt-6">
                <h3 class="text-xl font-bold text-white mb-4 flex items-center">
                    <i class="ri-file-list-3-line text-primary mr-2"></i>
                    معرفات العميل والمواصفات المخصصة
                </h3>
                
                <div class="bg-gray-900 bg-opacity-50 rounded-lg p-5 border-r-4 border-primary">
                    @foreach($order->getPlayerIdentifiers() as $item)
                    <div class="mb-4 pb-4 {{ !$loop->last ? 'border-b border-gray-700' : '' }}">
                        <div class="flex justify-between items-start mb-3">
                            <h4 class="text-lg font-bold text-primary">{{ $item['product_name'] }}</h4>
                            @if(isset($item['service']))
                            <div class="bg-blue-900 bg-opacity-20 border border-blue-700 rounded px-3 py-1 text-sm">
                                <span class="text-blue-100">{{ $item['service']['name'] }} - {{ $item['service']['price'] }} ر.س</span>
                            </div>
                            @endif
                        </div>
                        
                        @if(!empty($item['identifiers']))
                        <div class="bg-gray-800 rounded-lg p-4">
                            <h5 class="text-white mb-3">بيانات المستخدم:</h5>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($item['identifiers'] as $key => $value)
                                <div class="flex">
                                    <span class="w-1/3 text-gray-400">
                                        @if(is_array($value) && isset($value['label']))
                                            {{ $value['label'] }}:
                                        @else
                                            {{ $key }}:
                                        @endif
                                    </span>
                                    <div class="w-2/3 font-mono bg-gray-900 text-primary font-bold p-2 rounded select-all">
                                        @if(is_array($value))
                                            @if(isset($value['value']))
                                                {{ $value['value'] }}
                                            @else
                                                {{ is_array($value) ? implode(', ', array_map(function($v) { return is_array($v) ? json_encode($v) : $v; }, $value)) : $value }}
                                            @endif
                                        @else
                                            {{ $value }}
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- قسم تقييم المنتجات غير المقيمة -->
            @if(isset($unratedItems) && $unratedItems->count() > 0 && $order->status === 'completed')
            <div class="mt-6">
                <h3 class="text-xl font-bold text-white mb-4 flex items-center">
                    <i class="ri-star-line text-yellow-500 mr-2"></i>
                    تقييم المنتجات
                </h3>
                
                <div class="bg-gray-800 bg-opacity-50 rounded-lg p-5">
                    <p class="text-gray-300 mb-4">قم بتقييم المنتجات التي اشتريتها لمساعدة العملاء الآخرين:</p>
                    
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($unratedItems as $item)
                        <div class="border border-gray-700 rounded-lg p-4 bg-gray-800 bg-opacity-50 hover:border-primary transition product-rating-card" id="product-item-{{ $item->id }}">
                            <div class="flex flex-col md:flex-row items-start">
                                <div class="w-full md:w-1/4 mb-4 md:mb-0">
                                    <div class="h-24 w-24 mx-auto md:mx-0 overflow-hidden rounded-md border border-gray-700 bg-gray-900">
                                        @if($item->orderable && $item->orderable->image)
                                            @php
                                                $imagePath = $item->orderable->image;
                                                if (is_string($imagePath) && !filter_var($imagePath, FILTER_VALIDATE_URL)) {
                                                    $imagePath = asset('storage/' . $imagePath);
                                                }
                                            @endphp
                                            <img src="{{ $imagePath }}" alt="{{ $item->name }}" class="h-full w-full object-cover object-center">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-gray-700 text-gray-300">
                                                <i class="ri-image-line text-3xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="w-full md:w-3/4 md:pr-4">
                                    <h4 class="text-lg font-bold text-white mb-2">{{ $item->name }}</h4>
                                    
                                    <div class="flex flex-wrap items-center">
                                        <div class="w-full mb-3">
                                            <div class="rating-stars-container flex items-center">
                                                <input type="hidden" name="product_id_{{ $item->id }}" value="{{ $item->orderable_id }}">
                                                <input type="hidden" name="product_type_{{ $item->id }}" value="{{ $item->orderable_type }}">
                                                <input type="hidden" name="order_item_id_{{ $item->id }}" value="{{ $item->id }}">
                                                <input type="hidden" name="rating_{{ $item->id }}" id="rating-value-{{ $item->id }}" value="0">
                                                
                                                <div class="rating-stars flex">
                                                    @for($i = 1; $i <= 5; $i++)
                                                    <button type="button" class="star-btn p-1" 
                                                            data-item-id="{{ $item->id }}" 
                                                            data-rating="{{ $i }}" 
                                                            onclick="setRating({{ $item->id }}, {{ $i }})">
                                                        <i class="ri-star-line text-2xl text-gray-400 hover:text-yellow-500"></i>
                                                    </button>
                                                    @endfor
                                                </div>
                                                
                                                <div class="ml-2 text-sm text-gray-400 rating-text-{{ $item->id }}">
                                                    قم بتقييم هذا المنتج
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="w-full mb-3 hidden" id="review-container-{{ $item->id }}">
                                            <textarea 
                                                id="review-{{ $item->id }}" 
                                                class="w-full bg-gray-900 border border-gray-700 rounded px-3 py-2 text-white focus:outline-none focus:border-primary"
                                                placeholder="اكتب تعليقك حول المنتج (اختياري)" 
                                                rows="3"></textarea>
                                        </div>
                                        
                                        <div class="w-full mt-2">
                                            <button 
                                                type="button" 
                                                id="submit-rating-{{ $item->id }}" 
                                                onclick="submitRating({{ $item->id }})" 
                                                class="bg-primary text-white px-4 py-2 rounded opacity-50 cursor-not-allowed" 
                                                disabled>
                                                إرسال التقييم
                                            </button>
                                            
                                            <span id="rating-success-{{ $item->id }}" class="hidden ml-2 text-green-500">
                                                <i class="ri-check-line"></i> تم إرسال تقييمك بنجاح
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// وظيفة نسخ النصوص إلى الحافظة
function copyToClipboard(text, message) {
    // استخدام واجهة برمجة التطبيقات clipboard الحديثة
    navigator.clipboard.writeText(text)
        .then(function() {
            // إظهار إشعار نجاح النسخ
            showNotification(message || 'تم نسخ النص بنجاح');
        })
        .catch(function(err) {
            // استخدام الطريقة البديلة في حالة عدم دعم المتصفح
            fallbackCopyTextToClipboard(text, message);
        });
}

// وظيفة نسخ نص من عنصر محدد بالصفحة
function copySpecificText(textId) {
    const element = document.getElementById(textId);
    if (element) {
        const text = element.textContent.trim();
        copyToClipboard(text, 'تم نسخ النص بنجاح');
    } else {
        showNotification('خطأ: لم يتم العثور على النص');
    }
}

// طريقة بديلة للنسخ تعمل في المتصفحات القديمة
function fallbackCopyTextToClipboard(text, message) {
    // إنشاء عنصر textarea مؤقت
    const textArea = document.createElement("textarea");
    textArea.value = text;
    
    // جعله غير مرئي ولكن جزء من الصفحة
    document.body.appendChild(textArea);
    textArea.style.position = "fixed";
    textArea.style.top = "0";
    textArea.style.left = "0";
    textArea.style.width = "2em";
    textArea.style.height = "2em";
    textArea.style.padding = "0";
    textArea.style.border = "none";
    textArea.style.outline = "none";
    textArea.style.boxShadow = "none";
    textArea.style.background = "transparent";
    
    // تحديد النص ونسخه
    textArea.focus();
    textArea.select();
    
    try {
        const successful = document.execCommand('copy');
        showNotification(successful ? (message || 'تم نسخ النص بنجاح') : 'فشل النسخ، حاول مرة أخرى');
    } catch (err) {
        showNotification('فشل النسخ، حاول مرة أخرى');
        console.error('فشل في نسخ النص: ', err);
    }
    
    // إزالة العنصر المؤقت
    document.body.removeChild(textArea);
}

// وظيفة عرض الإشعارات
function showNotification(message) {
    // إزالة أي إشعارات سابقة
    const oldNotifications = document.querySelectorAll('.copy-notification');
    oldNotifications.forEach(n => n.remove());
    
    // إنشاء إشعار جديد
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 left-1/2 -translate-x-1/2 bg-green-600 text-white px-4 py-2 rounded shadow-lg z-50 copy-notification';
    notification.textContent = message;
    document.body.appendChild(notification);
    
    // إزالة الإشعار بعد 2 ثانية
    setTimeout(() => {
        notification.remove();
    }, 2000);
}

// وظائف نظام التقييم
function setRating(itemId, rating) {
    // تعيين قيمة التقييم
    document.getElementById('rating-value-' + itemId).value = rating;
    
    // تحديث مظهر النجوم
    const stars = document.querySelectorAll(`.star-btn[data-item-id="${itemId}"] i`);
    stars.forEach((star, index) => {
        if (index < rating) {
            star.classList.remove('ri-star-line');
            star.classList.add('ri-star-fill');
            star.classList.add('text-yellow-500');
            star.classList.remove('text-gray-400');
        } else {
            star.classList.add('ri-star-line');
            star.classList.remove('ri-star-fill');
            star.classList.remove('text-yellow-500');
            star.classList.add('text-gray-400');
        }
    });
    
    // تحديث نص التقييم
    const ratingTexts = [
        'قم بتقييم هذا المنتج', 
        'سيء', 
        'متوسط',
        'جيد',
        'جيد جداً',
        'ممتاز'
    ];
    document.querySelector(`.rating-text-${itemId}`).textContent = ratingTexts[rating];
    
    // إظهار حقل التعليق
    document.getElementById('review-container-' + itemId).classList.remove('hidden');
    
    // تفعيل زر الإرسال
    const submitButton = document.getElementById('submit-rating-' + itemId);
    submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
    submitButton.disabled = false;
}

function submitRating(itemId) {
    const productId = document.querySelector(`input[name="product_id_${itemId}"]`).value;
    const productType = document.querySelector(`input[name="product_type_${itemId}"]`).value;
    const orderItemId = document.querySelector(`input[name="order_item_id_${itemId}"]`).value;
    const rating = document.getElementById('rating-value-' + itemId).value;
    const review = document.getElementById('review-' + itemId).value;
    
    // تعطيل الزر أثناء الإرسال
    const submitButton = document.getElementById('submit-rating-' + itemId);
    submitButton.disabled = true;
    submitButton.textContent = 'جاري الإرسال...';
    
    // إرسال البيانات عبر طلب AJAX
    fetch('/product/rate', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            product_id: productId,
            product_type: productType,
            order_item_id: orderItemId,
            rating: rating,
            review: review
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // إخفاء النموذج وإظهار رسالة النجاح
            document.getElementById('rating-success-' + itemId).classList.remove('hidden');
            submitButton.textContent = 'تم التقييم';
            
            // إضافة تأثير بصري للتقييم الناجح
            const card = document.getElementById('product-item-' + itemId);
            card.classList.add('border-green-500');
            
            // بعد فترة، إخفاء البطاقة
            setTimeout(() => {
                card.style.opacity = '0.5';
                card.style.pointerEvents = 'none';
            }, 2000);
        } else {
            // إظهار رسالة الخطأ
            submitButton.textContent = 'حدث خطأ، حاول مرة أخرى';
            submitButton.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        submitButton.textContent = 'حدث خطأ، حاول مرة أخرى';
        submitButton.disabled = false;
    });
}
</script>
@endsection 