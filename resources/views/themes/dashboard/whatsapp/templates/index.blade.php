@extends('themes.admin.layouts.app')

@section('title', 'قوالب رسائل واتساب')

@section('content')
@php
    use App\Constants\WhatsAppTemplates;
    $fixedTemplates = [
        [
            'type' => WhatsAppTemplates::ORDER_PENDING,
            'label' => 'قيد الانتظار',
        ],
        [
            'type' => WhatsAppTemplates::ORDER_PROCESSING,
            'label' => 'قيد المعالجة',
        ],
        [
            'type' => WhatsAppTemplates::ORDER_COMPLETED,
            'label' => 'مكتمل',
        ],
        [
            'type' => WhatsAppTemplates::ORDER_CANCELLED,
            'label' => 'ملغي',
        ],
        [
            'type' => WhatsAppTemplates::ORDER_REFUNDED,
            'label' => 'مسترجع',
        ],
        [
            'type' => WhatsAppTemplates::ADMIN_NOTIFICATION,
            'label' => 'تنبيه الإدارة',
        ],
    ];
    $dbTemplates = $templates->keyBy('type');
@endphp
<div class="container mx-auto px-6 py-8">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <h3 class="text-gray-700 dark:text-gray-100 text-3xl font-medium">قوالب رسائل واتساب</h3>
            <a href="{{ route('admin.whatsapp.index') }}" class="mr-4 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-100 px-4 py-2 rounded-md">
                <i class="ri-arrow-go-back-line ml-1"></i>العودة للسابق
            </a>
        </div>
        {{-- تم إخفاء زر إضافة قالب جديد --}}
    </div>
    <div class="mt-8">
        @if (session('success'))
        <div class="bg-green-100 dark:bg-green-900 border-l-4 border-green-500 text-green-700 dark:text-green-100 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
        @endif
        <div class="bg-white dark:bg-gray-800 rounded-md shadow-md overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">#</th>
                        <!--<th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">النوع البرمجي</th>-->
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">الوصف</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">الحالة</th>
                        <!--<th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">تاريخ الإنشاء</th>-->
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($fixedTemplates as $i => $tpl)
                        @php $template = $dbTemplates[$tpl['type']] ?? null; @endphp
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $i+1 }}</td>
                            <!--<td class="px-6 py-4 whitespace-nowrap text-sm font-mono">{{ $tpl['type'] }}</td>-->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $tpl['label'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($template)
                                    <form action="{{ route('admin.whatsapp.templates.toggle', $template->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        @method('PATCH')
                                        <div class="inline-flex items-center gap-2 justify-center">
                                            <button type="submit" class="focus:outline-none" title="تفعيل/تعطيل">
                                                <span class="relative inline-block w-12 h-6 align-middle select-none transition duration-200 ease-in">
                                                    <span class="block w-12 h-6 rounded-full transition bg-gray-300 {{ $template->is_active ? 'bg-green-400' : 'bg-gray-300' }}"></span>
                                                    <span class="absolute left-0 top-0 w-6 h-6 bg-white border border-gray-300 rounded-full shadow transition-transform duration-200 ease-in transform {{ $template->is_active ? 'translate-x-6 border-green-500' : '' }}"></span>
                                                </span>
                                            </button>
                                    <span class="text-xs font-semibold rounded-full px-2 py-1 {{ $template->is_active ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' }}">
                                        {{ $template->is_active ? 'مفعل' : 'غير مفعل' }}
                                    </span>
                                </div>
                            </form>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">قم بإنشاء القالب أولاً</span>
                                @endif
                            </td>
                            <!--<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $template?->created_at?->format('Y-m-d H:i') ?? '-' }}
                            </td>-->
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ $template ? route('admin.whatsapp.templates.edit', $template->id) : route('admin.whatsapp.templates.edit', ['template' => $tpl['type']]) }}" 
                                   class="bg-indigo-100 dark:bg-indigo-900 hover:bg-indigo-200 dark:hover:bg-indigo-800 text-indigo-700 dark:text-indigo-200 px-2 py-1 rounded-md flex items-center">
                                    <i class="ri-edit-line text-lg ml-1"></i>
                                    تعديل
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 