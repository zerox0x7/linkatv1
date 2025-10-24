<div class="checkout-review-item">
    <div class="product-details">
        <h4>{{ $item->name }}</h4>
        <div class="product-info">
            <span class="quantity">{{ $item->qty }}</span> x <span class="price">{{ $item->price }}</span>
        </div>
        
        <!-- عرض بيانات المنتج المخصص في مراجعة الطلب -->
        @if(isset($item->options['custom_fields_data']) && is_array($item->options['custom_fields_data']))
        <div class="mt-2 mb-2">
            <div class="bg-gray-50 p-2 rounded text-sm">
                <div class="font-medium mb-1">البيانات المخصصة:</div>
                <ul class="list-disc list-inside text-xs">
                    @foreach($item->options['custom_fields_data'] as $fieldName => $fieldValue)
                        <li>
                            <span class="font-medium">{{ $fieldName }}:</span>
                            @if(is_array($fieldValue))
                                {{ json_encode($fieldValue, JSON_UNESCAPED_UNICODE) }}
                            @else
                                {{ $fieldValue }}
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
        
        <!-- عرض الخدمة المطلوبة -->
        @if(isset($item->options['selected_option_name']) || isset($item->options['selected_price_option']))
        <div class="mt-2 mb-2">
            <div class="bg-blue-50 p-2 rounded text-sm">
                <div class="font-medium mb-1">الخدمة المطلوبة:</div>
                <div class="text-xs flex items-center">
                    <span class="ml-2">{{ $item->options['selected_option_name'] ?? 'خدمة مخصصة' }}</span>
                    @if(isset($item->options['selected_price']))
                    <span class="text-green-600">({{ $item->options['selected_price'] }} ر.س)</span>
                    @endif
                </div>
            </div>
        </div>
        @endif
        
        <!-- عرض البيانات المخصصة الأخرى -->
        @php
            $fieldsToIgnore = ['selected_price_option', 'selected_option_name', 'selected_price', 
                            'other_options', 'custom_fields_data', 'custom_data', 'quantity', 
                            'id', 'product_id'];
            $customDataFound = false;
        @endphp
        
        @foreach($item->options as $key => $value)
            @if(!in_array($key, $fieldsToIgnore) && !empty($value))
                @php $customDataFound = true; @endphp
            @endif
        @endforeach
        
        @if($customDataFound)
        <div class="mt-2 mb-2">
            <div class="bg-yellow-50 p-2 rounded text-sm">
                <div class="font-medium mb-1">بيانات إضافية:</div>
                <ul class="list-disc list-inside text-xs">
                    @foreach($item->options as $key => $value)
                        @if(!in_array($key, $fieldsToIgnore) && !empty($value))
                            <li>
                                <span class="font-medium">{{ $key }}:</span>
                                @if(is_array($value))
                                    {{ json_encode($value, JSON_UNESCAPED_UNICODE) }}
                                @else
                                    {{ $value }}
                                @endif
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
    </div>
</div> 