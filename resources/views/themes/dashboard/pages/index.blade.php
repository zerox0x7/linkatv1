@extends('themes.dashboard.layouts.app')
@section('title', 'إدارة الصفحات')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">إدارة الصفحات</h1>
        <div class="flex space-x-2 space-x-reverse">
            <a href="{{ route('dashboard.pages.home-manager') }}" class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white py-2 px-4 rounded shadow">
                <i class="fas fa-home ml-1"></i> إدارة الصفحة الرئيسية
            </a>
            <a href="{{ route('dashboard.pages.create') }}" class="bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-800 text-white py-2 px-4 rounded shadow">
                <i class="fas fa-plus ml-1"></i> إضافة صفحة جديدة
            </a>
        </div>
    </div>
    
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative dark:bg-green-900 dark:border-green-700 dark:text-green-200">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative dark:bg-red-900 dark:border-red-700 dark:text-red-200">
            {{ session('error') }}
        </div>
    @endif
    
    <!-- Home Sections Management (Moved to Top) -->
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-medium text-gray-800 dark:text-gray-100">إدارة أقسام الصفحة الرئيسية</h2>
        </div>
        <div class="p-6">
            <div class="flex justify-between items-center">
                <p class="text-gray-600 dark:text-gray-300">تخصيص أقسام الصفحة الرئيسية، تفعيل/تعطيل الأقسام، وضبط عدد المنتجات المعروضة في كل قسم.</p>
                <div class="flex space-x-2 space-x-reverse">
                    <a href="{{ route('dashboard.home-sections.index') }}" class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white py-2 px-4 rounded shadow">
                        <i class="fas fa-th-large ml-1"></i> إدارة الأقسام
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="my-6"></div>
    <!-- Marquee Control Section -->
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow overflow-hidden mb-6">
        <div class="px-6 py-4 flex items-center justify-between">
            <div class="flex items-center">
                <i class="ri-megaphone-line text-2xl text-primary ml-3"></i>
                <span class="text-lg font-bold text-gray-800 dark:text-gray-100">التحكم في شريط القوائم</span>
            </div>
            <a href="{{ route('dashboard.marquee') }}" class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white py-2 px-4 rounded shadow flex items-center">
                <i class="ri-settings-3-line ml-1"></i> انتقل للإعدادات
            </a>
        </div>
    </div>
    <!-- Sliders Section (Moved below Home Sections) -->
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-medium text-gray-800 dark:text-gray-100">إدارة السلايدر</h2>
        </div>
        <div class="p-6">
            <div class="flex justify-between items-center">
                <p class="text-gray-600 dark:text-gray-300">إدارة صور السلايدر الرئيسي وتنظيم ترتيب وعرض الشرائح.</p>
                <div class="flex space-x-2 space-x-reverse">
                    <a href="{{ route('dashboard.home-sliders.index') }}" class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white py-2 px-4 rounded shadow">
                        <i class="fas fa-images ml-1"></i> إدارة السلايدر
                    </a>
                    <a href="{{ route('dashboard.home-sliders.create') }}" class="bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-800 text-white py-2 px-4 rounded shadow">
                        <i class="fas fa-plus ml-1"></i> إضافة سلايد جديد
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Pages Table -->
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
            <h2 class="text-lg font-medium text-gray-800 dark:text-gray-100">إدارة الصفحات</h2>
            <a href="{{ route('dashboard.pages.create') }}" class="bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-800 text-white py-2 px-4 rounded shadow text-sm flex items-center">
                <i class="fas fa-plus ml-1"></i> إضافة صفحة جديدة
            </a>
        </div>
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            #
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            العنوان
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            الرابط المختصر
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            تاريخ الإنشاء
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            الحالة
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            الإجراءات
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($pages as $page)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $page->title }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <code class="text-sm bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded">{{ $page->slug }}</code>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ $page->created_at->format('Y/m/d') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $page->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                    {{ $page->is_active ? 'منشورة' : 'مسودة' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex items-center justify-center space-x-3 space-x-reverse">
                                    <a href="{{ url('/page/' . $page->slug) }}" target="_blank" class="text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    
                                    <a href="{{ route('dashboard.pages.edit', $page) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    
                                    <form action="{{ route('dashboard.pages.destroy', $page) }}" method="POST" class="inline-block delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-300">
                                لا توجد صفحات حتى الآن. <a href="{{ route('dashboard.pages.create') }}" class="text-blue-600 hover:underline dark:text-blue-400">إضافة صفحة جديدة</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Footer Quick Links Management -->
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
            <div class="flex flex-col gap-1 w-full">
                <div class="flex items-center gap-2">
                    <input type="text" id="footer_links_title_input" value="{{ $footer_links_title }}" placeholder="يمكنك تعديل اسم القسم هنا" class="bg-white dark:bg-gray-700 border border-blue-400 dark:border-blue-600 rounded px-3 py-2 text-lg font-medium text-gray-800 dark:text-gray-100 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 focus:outline-none transition" style="width: 280px; min-width: 120px;" oninput="showSaveBtn('footer_links_title')">
                    <button id="footer_links_title_save" onclick="saveFooterTitle('footer_links_title')" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm transition" type="button">حفظ</button>
                    <span id="footer_links_title_success" class="text-green-600 text-xs ml-2 hidden">تم الحفظ</span>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <p class="text-gray-600 dark:text-gray-300">إدارة الروابط السريعة التي تظهر في تذييل الموقع.</p>
                <a href="{{ route('dashboard.menu-links.create', ['section' => 'quick_links']) }}" class="bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-800 text-white py-2 px-4 rounded shadow">
                    <i class="fas fa-plus ml-1"></i> إضافة رابط جديد
                </a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                #
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                العنوان
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                الرابط
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                الترتيب
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                الحالة
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                الإجراءات
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                        @php
                            $quickLinks = \App\Models\MenuLink::where('section', 'quick_links')->orderBy('order')->get();
                        @endphp
                        
                        @forelse($quickLinks as $link)
                            @php
                                $displayUrl = $link->url;
                                if (preg_match('/^\//', $displayUrl)) {
                                    $displayUrl = url($displayUrl);
                                }
                            @endphp
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $link->title }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <code class="text-sm bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded">{{ $link->url }}</code>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ $link->order }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $link->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                        {{ $link->is_active ? 'مفعل' : 'معطل' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center space-x-3 space-x-reverse">
                                        <a href="{{ $displayUrl }}" target="_blank" class="text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        
                                        <a href="{{ route('dashboard.menu-links.edit', $link) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        
                                        <form action="{{ route('dashboard.menu-links.destroy', $link) }}" method="POST" class="inline-block delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-300">
                                    لا توجد روابط سريعة حتى الآن. <a href="{{ route('dashboard.menu-links.create', ['section' => 'quick_links']) }}" class="text-blue-600 hover:underline dark:text-blue-400">إضافة رابط جديد</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Footer Policies Links Management -->
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
            <div class="flex flex-col gap-1 w-full">
                <div class="flex items-center gap-2">
                    <input type="text" id="footer_policies_title_input" value="{{ $footer_policies_title }}" placeholder="يمكنك تعديل اسم القسم هنا" class="bg-white dark:bg-gray-700 border border-blue-400 dark:border-blue-600 rounded px-3 py-2 text-lg font-medium text-gray-800 dark:text-gray-100 focus:ring-2 focus:ring-blue-400 focus:border-blue-500 focus:outline-none transition" style="width: 280px; min-width: 120px;" oninput="showSaveBtn('footer_policies_title')">
                    <button id="footer_policies_title_save" onclick="saveFooterTitle('footer_policies_title')" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm transition" type="button">حفظ</button>
                    <span id="footer_policies_title_success" class="text-green-600 text-xs ml-2 hidden">تم الحفظ</span>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <p class="text-gray-600 dark:text-gray-300">إدارة روابط سياسات المتجر التي تظهر في تذييل الموقع.</p>
                <a href="{{ route('dashboard.menu-links.create', ['section' => 'policies']) }}" class="bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-800 text-white py-2 px-4 rounded shadow">
                    <i class="fas fa-plus ml-1"></i> إضافة رابط جديد
                </a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                #
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                العنوان
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                الرابط
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                الترتيب
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                الحالة
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                الإجراءات
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                        @php
                            $policyLinks = \App\Models\MenuLink::where('section', 'policies')->orderBy('order')->get();
                        @endphp
                        
                        @forelse($policyLinks as $link)
                            @php
                                $displayUrl = $link->url;
                                if (preg_match('/^\//', $displayUrl)) {
                                    $displayUrl = url($displayUrl);
                                }
                            @endphp
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $link->title }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <code class="text-sm bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded">{{ $link->url }}</code>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ $link->order }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $link->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                        {{ $link->is_active ? 'مفعل' : 'معطل' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center space-x-3 space-x-reverse">
                                        <a href="{{ $displayUrl }}" target="_blank" class="text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        
                                        <a href="{{ route('dashboard.menu-links.edit', $link) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        
                                        <form action="{{ route('dashboard.menu-links.destroy', $link) }}" method="POST" class="inline-block delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-300">
                                    لا توجد روابط للسياسات حتى الآن. <a href="{{ route('dashboard.menu-links.create', ['section' => 'policies']) }}" class="text-blue-600 hover:underline dark:text-blue-400">إضافة رابط جديد</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Payment Methods Icons Management -->
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow overflow-hidden mt-8">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
            <h2 class="text-lg font-medium text-gray-800 dark:text-gray-100">إدارة أيقونات وسائل الدفع (الفوتر)</h2>
        </div>
        <div class="p-6">
            <form action="{{ route('dashboard.settings.payment-icons.upload') }}" method="POST" enctype="multipart/form-data" class="mb-6">
                @csrf
                <div class="flex flex-col md:flex-row items-center gap-4">
                    <input type="file" name="payment_icons[]" accept="image/*" multiple class="block w-full text-sm text-gray-700 dark:text-gray-200 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-gray-800 dark:file:text-blue-300 dark:hover:file:bg-gray-700" required>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">رفع الصور</button>
                </div>
                <small class="block mt-2 text-xs text-gray-500 dark:text-gray-400">يمكنك رفع عدة صور (PNG, JPG, SVG). ستظهر هذه الأيقونات في تذييل الموقع.</small>
            </form>
            <div>
                <h3 class="text-md font-semibold text-gray-700 dark:text-gray-200 mb-3">الأيقونات الحالية:</h3>
                <div class="flex flex-wrap gap-4">
                    @php
                        $paymentIcons = json_decode(\App\Models\Setting::get('footer_payment_icons', '[]'), true);
                    @endphp
                    @forelse($paymentIcons as $icon)
                        <div class="relative group border border-gray-200 dark:border-gray-700 rounded-lg p-2 bg-gray-50 dark:bg-gray-800 flex flex-col items-center justify-center">
                            <img src="{{ asset('storage/' . $icon) }}" alt="Payment Icon" class="h-12 w-auto object-contain mb-2">
                            <form action="{{ route('dashboard.settings.payment-icons.delete') }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذه الأيقونة؟');">
                                @csrf
                                <input type="hidden" name="icon" value="{{ $icon }}">
                                <button type="submit" class="text-red-600 hover:text-red-800 text-xs bg-red-100 dark:bg-red-900 dark:text-red-300 px-2 py-1 rounded">حذف</button>
                            </form>
                        </div>
                    @empty
                        <span class="text-gray-500 dark:text-gray-400">لا توجد أيقونات مضافة بعد.</span>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <!-- نهاية قسم إدارة أيقونات وسائل الدفع -->
</div>
@endsection

@push('scripts')
<script>
    // تأكيد الحذف
    document.addEventListener('DOMContentLoaded', function () {
        const deleteForms = document.querySelectorAll('.delete-form');
        
        deleteForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                
                if (confirm('هل أنت متأكد من رغبتك في حذف هذا العنصر؟')) {
                    this.submit();
                }
            });
        });
    });

    function showSaveBtn(key) {
        // لم يعد هناك حاجة لإظهار/إخفاء الزر، الزر ظاهر دائماً
    }

    function saveFooterTitle(key) {
        const input = document.getElementById(key + '_input');
        const value = input.value;
        fetch("{{ route('dashboard.settings.updateFooterTitle') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
            },
            body: JSON.stringify({key, value})
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                const successId = key + '_success';
                const el = document.getElementById(successId);
                input.setAttribute('data-original', value);
                if(el) {
                    el.classList.remove('hidden');
                    setTimeout(() => el.classList.add('hidden'), 1200);
                }
            }
        });
    }

    // عند تحميل الصفحة، احفظ القيمة الأصلية في data-original
    ['footer_links_title', 'footer_policies_title'].forEach(function(key) {
        const input = document.getElementById(key + '_input');
        if(input) input.setAttribute('data-original', input.value);
    });
</script>
@endpush 