<!-- قسم المنتجات المخصصة (إذا وجدت) -->
@if($order->has_custom_products && !empty($order->custom_data))
<div class="bg-white rounded-lg shadow overflow-hidden mt-6">
    <div class="bg-gray-50 px-4 py-3 border-b flex items-center">
        <h3 class="text-lg font-medium text-gray-800">بيانات المنتجات المخصصة</h3>
        <span class="mr-2 px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">معلومات هامة</span>
    </div>
    <div class="p-4">
        <div class="space-y-4">
            @foreach($order->custom_data as $itemId => $productData)
                @php
                    // الحصول على المنتج المرتبط إذا كان متوفراً
                    $product = null;
                    if(isset($productData['product_id'])) {
                        $product = \App\Models\Product::find($productData['product_id']);
                    }
                    
                    // استخراج تعريفات الحقول المخصصة من المنتج
                    $fieldDefinitions = [];
                    if($product && $product->custom_fields) {
                        $customFields = is_string($product->custom_fields) ? 
                                        json_decode($product->custom_fields, true) : 
                                        $product->custom_fields;
                        foreach($customFields as $field) {
                            if(isset($field['name']) && isset($field['label'])) {
                                $fieldDefinitions[$field['name']] = $field['label'];
                            }
                        }
                    }
                    
                    // استخراج تعريفات خيارات السعر من المنتج
                    $priceOptions = [];
                    if($product && $product->price_options) {
                        $priceOptionsData = is_string($product->price_options) ? 
                                        json_decode($product->price_options, true) : 
                                        $product->price_options;
                        foreach($priceOptionsData as $option) {
                            $optionName = '';
                            $optionId = $option['id'] ?? '';
                            
                            if(isset($option['quantity'])) {
                                $optionName = $option['quantity'];
                            } elseif(isset($option['name'])) {
                                $optionName = $option['name'];
                            } elseif(isset($option['description'])) {
                                $optionName = $option['description'];
                            }
                            
                            if($optionId && $optionName) {
                                $priceOptions[$optionId] = $optionName;
                            }
                        }
                    }
                @endphp
                <div class="mb-4 border-r-4 border-yellow-500 bg-yellow-50 rounded-lg overflow-hidden">
                    <div class="p-4">
                        <h4 class="text-lg font-medium text-gray-900 mb-3">{{ $productData['name'] }}</h4>
                        
                        @if(isset($productData['service_option']))
                        <div class="mb-4 bg-blue-50 rounded-md p-3 border border-blue-200">
                            <h5 class="font-medium text-blue-700 mb-2">الخدمة المطلوبة:</h5>
                            <div class="flex flex-wrap">
                                @php
                                    $optionId = $productData['service_option']['option_id'] ?? '';
                                    $displayName = $priceOptions[$optionId] ?? $productData['service_option']['name'] ?? 'خيار السعر';
                                @endphp
                                <div class="px-3 py-1 bg-white rounded border border-blue-100 text-blue-800 ml-2 mb-2">
                                    <span class="font-medium">الخدمة:</span> {{ $displayName }}
                                </div>
                                @if(isset($productData['service_option']['price']))
                                <div class="px-3 py-1 bg-white rounded border border-green-100 text-green-800 ml-2 mb-2">
                                    <span class="font-medium">السعر:</span> {{ $productData['service_option']['price'] }} ر.س
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                        
                        @if(isset($productData['player_data']) && !empty($productData['player_data']))
                        <div class="bg-white rounded-md border border-gray-200 p-3">
                            <h5 class="font-medium text-gray-700 mb-2">البيانات المخصصة:</h5>
                            <div class="space-y-2">
                                @foreach($productData['player_data'] as $key => $field)
                                    @php
                                        $fieldValue = is_array($field) && isset($field['value']) ? $field['value'] : $field;
                                        // استخدام العنوان من تعريف الحقل إذا كان متوفراً، وإلا استخدام العنوان من البيانات أو اسم الحقل
                                        $fieldLabel = $fieldDefinitions[$key] ?? (is_array($field) && isset($field['label']) ? $field['label'] : $key);
                                    @endphp
                                    <div class="border border-gray-100 rounded bg-gray-50 p-3">
                                        <div class="flex">
                                            <span class="text-sm font-medium text-gray-700 ml-2">{{ $fieldLabel }}:</span>
                                            <span class="text-sm text-gray-600">
                                            @if(is_array($fieldValue) || is_object($fieldValue))
                                                {{ json_encode($fieldValue, JSON_UNESCAPED_UNICODE) }}
                                            @elseif(filter_var($fieldValue, FILTER_VALIDATE_URL))
                                                <a href="{{ $fieldValue }}" target="_blank" class="text-blue-600 hover:underline break-all">{{ $fieldValue }}</a>
                                            @elseif(strpos($fieldValue, '@') !== false && filter_var($fieldValue, FILTER_VALIDATE_EMAIL))
                                                <a href="mailto:{{ $fieldValue }}" class="text-blue-600 hover:underline">{{ $fieldValue }}</a>
                                            @else
                                                {{ $fieldValue }}
                                            @endif
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @elseif(!empty($productData['data']))
                        <div class="bg-white rounded-md border border-gray-200 p-3">
                            <h5 class="font-medium text-gray-700 mb-2">البيانات المخصصة:</h5>
                            <div class="space-y-2">
                                @foreach($productData['data'] as $key => $value)
                                <div class="border border-gray-100 rounded bg-gray-50 p-3">
                                    <div class="flex">
                                        <span class="text-sm font-medium text-gray-700 ml-2">{{ $fieldDefinitions[$key] ?? $key }}:</span>
                                        <span class="text-sm text-gray-600">
                                        @if(is_array($value) || is_object($value))
                                            {{ json_encode($value, JSON_UNESCAPED_UNICODE) }}
                                        @elseif(filter_var($value, FILTER_VALIDATE_URL))
                                            <a href="{{ $value }}" target="_blank" class="text-blue-600 hover:underline break-all">{{ $value }}</a>
                                        @elseif(strpos($value, '@') !== false && filter_var($value, FILTER_VALIDATE_EMAIL))
                                            <a href="mailto:{{ $value }}" class="text-blue-600 hover:underline">{{ $value }}</a>
                                        @else
                                            {{ $value }}
                                        @endif
                                        </span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif 