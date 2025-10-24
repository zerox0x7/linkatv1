<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>لوحة تحكم المتجر</title>
<script src="https://cdn.tailwindcss.com/3.4.16"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
<style>
:where([class^="ri-"])::before { content: "\f3c2"; }
body {
font-family: 'Cairo', sans-serif;
background-color: #0f172a;
color: #fff;
}
.dragging {
opacity: 0.8;
background: #1e293b;
box-shadow: 0 4px 20px rgba(0, 229, 187, 0.2);
transform: scale(1.02);
transition: all 0.2s ease;
}
.drag-over {
border: 2px dashed #00e5bb;
position: relative;
}
.drag-over::after {
content: '';
position: absolute;
inset: 0;
background: rgba(0, 229, 187, 0.05);
border-radius: 6px;
pointer-events: none;
}
.drag-handle {
cursor: grab;
}
.drag-handle:active {
cursor: grabbing;
}
.toast {
position: fixed;
bottom: 20px;
right: 20px;
background: rgba(0, 229, 187, 0.9);
color: #0f172a;
padding: 1rem;
border-radius: 8px;
z-index: 50;
transform: translateY(100px);
opacity: 0;
transition: all 0.3s ease;
}
.toast.show {
transform: translateY(0);
opacity: 1;
}
.draggable-item {
cursor: move;
}
.primary-color {
color: #00e5bb;
}
.primary-bg {
background-color: #00e5bb;
}
.sidebar-item.active {
background-color: rgba(0, 229, 187, 0.1);
border-right: 3px solid #00e5bb;
}
.sidebar-item:hover:not(.active) {
background-color: rgba(255, 255, 255, 0.05);
}
.section-card {
background-color: #1e293b;
border-radius: 8px;
}
.section-header {
border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}
input[type="checkbox"] {
appearance: none;
width: 3.5rem;
height: 1.75rem;
background-color: rgba(255, 255, 255, 0.1);
border-radius: 9999px;
position: relative;
transition: all 0.3s;
}
input[type="checkbox"]::before {
content: "";
position: absolute;
width: 1.25rem;
height: 1.25rem;
border-radius: 50%;
top: 0.25rem;
right: 0.25rem;
background-color: white;
transition: all 0.3s;
}
input[type="checkbox"]:checked {
background-color: #00e5bb;
}
input[type="checkbox"]:checked::before {
right: 2rem;
}
.custom-input {
background-color: rgba(255, 255, 255, 0.05);
border: 1px solid rgba(255, 255, 255, 0.1);
color: white;
}
.custom-input:focus {
border-color: #00e5bb;
outline: none;
}
.color-picker {
appearance: none;
width: 2rem;
height: 2rem;
border: none;
border-radius: 4px;
cursor: pointer;
}
.color-picker::-webkit-color-swatch-wrapper {
padding: 0;
}
.color-picker::-webkit-color-swatch {
border: none;
border-radius: 4px;
}
</style>
<script>tailwind.config={theme:{extend:{colors:{primary:'#00e5bb',secondary:'#0f172a'},borderRadius:{'none':'0px','sm':'4px',DEFAULT:'8px','md':'12px','lg':'16px','xl':'20px','2xl':'24px','3xl':'32px','full':'9999px','button':'8px'}}}}</script>
</head>
<body class="min-h-screen flex">
<!-- Sidebar -->
<div class="w-64 bg-[#0f172a] border-l border-gray-700 flex flex-col">
<div class="p-4 border-b border-gray-700 flex justify-end">
<span class="text-xl font-['Pacifico'] text-primary">logo</span>
</div>
<div class="flex-1 overflow-y-auto py-4">
<div class="space-y-1 px-3">
<div class="sidebar-item flex items-center justify-end gap-3 p-3 rounded-md text-gray-300">
<span>لوحة التحكم</span>
<div class="w-6 h-6 flex items-center justify-center">
<i class="ri-dashboard-line"></i>
</div>
</div>
<div class="sidebar-item flex items-center justify-end gap-3 p-3 rounded-md text-gray-300">
<span>إدارة المتجر</span>
<div class="w-6 h-6 flex items-center justify-center">
<i class="ri-store-line"></i>
</div>
</div>
<div class="sidebar-item flex items-center justify-end gap-3 p-3 rounded-md text-gray-300">
<span>المنتجات</span>
<div class="w-6 h-6 flex items-center justify-center">
<i class="ri-shopping-bag-line"></i>
</div>
</div>
<div class="sidebar-item flex items-center justify-end gap-3 p-3 rounded-md text-gray-300">
<span>الطلبات</span>
<div class="w-6 h-6 flex items-center justify-center">
<i class="ri-shopping-cart-line"></i>
</div>
</div>
<div class="sidebar-item active flex items-center justify-end gap-3 p-3 rounded-md text-primary">
<span>التصنيفات</span>
<div class="w-6 h-6 flex items-center justify-center">
<i class="ri-price-tag-3-line"></i>
</div>
</div>
<div class="sidebar-item flex items-center justify-end gap-3 p-3 rounded-md text-gray-300">
<span>أكواد الخصم</span>
<div class="w-6 h-6 flex items-center justify-center">
<i class="ri-coupon-line"></i>
</div>
</div>
<div class="sidebar-item flex items-center justify-end gap-3 p-3 rounded-md text-gray-300">
<span>العملاء</span>
<div class="w-6 h-6 flex items-center justify-center">
<i class="ri-user-line"></i>
</div>
</div>
<div class="sidebar-item flex items-center justify-end gap-3 p-3 rounded-md text-gray-300">
<span>طرق الدفع</span>
<div class="w-6 h-6 flex items-center justify-center">
<i class="ri-bank-card-line"></i>
</div>
</div>
<div class="sidebar-item flex items-center justify-end gap-3 p-3 rounded-md text-gray-300">
<span>تقييمات المنتجات</span>
<div class="w-6 h-6 flex items-center justify-center">
<i class="ri-star-line"></i>
</div>
</div>
<div class="sidebar-item flex items-center justify-end gap-3 p-3 rounded-md text-gray-300">
<span>تقييمات المتجر</span>
<div class="w-6 h-6 flex items-center justify-center">
<i class="ri-store-2-line"></i>
</div>
</div>
<div class="sidebar-item flex items-center justify-end gap-3 p-3 rounded-md text-gray-300">
<span>إدارة واجهة المتجر</span>
<div class="w-6 h-6 flex items-center justify-center">
<i class="ri-layout-line"></i>
</div>
</div>
<div class="sidebar-item flex items-center justify-end gap-3 p-3 rounded-md text-primary">
<span>الرئيسية</span>
<div class="w-6 h-6 flex items-center justify-center">
<i class="ri-home-line"></i>
</div>
</div>
</div>
</div>
<div class="p-4 border-t border-gray-700 flex items-center justify-end gap-3">
<div class="text-right">
<p class="text-sm font-medium">test33</p>
<p class="text-xs text-gray-400">مدير المتجر</p>
</div>
<div class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center">
<i class="ri-user-line text-lg"></i>
</div>
</div>
</div>
<!-- Main Content -->
<div class="flex-1 flex flex-col">
<!-- Top Bar -->
<div class="bg-[#0f172a] border-b border-gray-700 p-4 flex justify-between items-center">
<div class="flex items-center gap-4">
<div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center cursor-pointer">
<i class="ri-notification-3-line"></i>
</div>
<div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center cursor-pointer">
<i class="ri-global-line"></i>
<span class="text-xs mr-1">AR</span>
</div>
</div>
<div class="relative">
<input type="text" placeholder="بحث..." class="bg-[#1e293b] border-none rounded-md py-2 px-4 text-sm text-white w-64 focus:outline-none focus:ring-1 focus:ring-primary">
<div class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 flex items-center justify-center">
<i class="ri-search-line text-gray-400"></i>
</div>
</div>
</div>
<!-- Content Area -->
<div class="flex-1 overflow-y-auto bg-[#111827] p-6">
<div class="max-w-6xl mx-auto">
<!-- Page Header -->
<div class="mb-8">
<h1 class="text-2xl font-bold mb-2">تخصيص الصفحة الرئيسية</h1>
<p class="text-gray-400">قم بتخصيص وتعديل محتوى الصفحة الرئيسية لمتجرك</p>
</div>
<!-- Store Info Section -->
<div class="section-card mb-8 overflow-hidden">
<div class="section-header p-4 flex justify-between items-center">
<div class="flex items-center gap-2">
<button class="bg-primary text-[#0f172a] py-2 px-4 rounded-button text-sm font-medium whitespace-nowrap">حفظ التغييرات</button>
<button class="bg-gray-700 text-white py-2 px-4 rounded-button text-sm font-medium whitespace-nowrap">معاينة</button>
</div>
<div class="flex items-center gap-3">
<h2 class="text-lg font-medium">معلومات المتجر</h2>
<div class="w-6 h-6 flex items-center justify-center text-primary">
<i class="ri-store-line"></i>
</div>
</div>
</div>
<div class="p-6 space-y-6">
<div class="flex flex-col gap-2">
<label class="text-sm font-medium text-right">اسم المتجر</label>
<input type="text" value="متجر الإلكترونيات الحديثة" class="custom-input p-3 rounded-md w-full">
</div>
<div class="flex flex-col gap-2">
<label class="text-sm font-medium text-right">وصف المتجر</label>
<textarea rows="3" class="custom-input p-3 rounded-md w-full">متجرك الأول للإلكترونيات والأجهزة الذكية بأفضل الأسعار وأعلى جودة. نوفر منتجات أصلية مع ضمان وخدمة توصيل سريعة لجميع أنحاء المملكة.</textarea>
</div>
<div class="flex flex-col gap-2">
<label class="text-sm font-medium text-right">شعار المتجر</label>
<div class="flex items-center gap-4">
<button class="bg-gray-700 text-white py-2 px-4 rounded-button text-sm font-medium whitespace-nowrap">تغيير الشعار</button>
<div class="w-16 h-16 bg-gray-800 rounded-md flex items-center justify-center">
<span class="text-xl font-['Pacifico'] text-primary">logo</span>
</div>
</div>
</div>
</div>
</div>
<!-- Hero Section -->
<div class="section-card mb-8 overflow-hidden">
<div class="section-header p-4 flex justify-between items-center">
<div class="flex items-center gap-2">
<label class="inline-flex items-center cursor-pointer">
<input type="checkbox" class="sr-only peer" checked>
<div class="relative w-14 h-7 bg-gray-700 peer-checked:bg-primary rounded-full peer-checked:after:translate-x-10 rtl:peer-checked:after:-translate-x-10 after:content-[''] after:absolute after:top-1 after:right-1 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
<span class="mr-3 text-sm font-medium text-gray-300">عرض القسم</span>
</label>
</div>
<div class="flex items-center gap-3">
<h2 class="text-lg font-medium">القسم البطولي (Hero Section)</h2>
<div class="w-6 h-6 flex items-center justify-center text-primary">
<i class="ri-layout-top-line"></i>
</div>
</div>
</div>
<div class="p-6 space-y-6">
<div class="flex flex-col gap-2">
<label class="text-sm font-medium text-right">العنوان الرئيسي</label>
<input type="text" value="أحدث الأجهزة الإلكترونية بأفضل الأسعار" class="custom-input p-3 rounded-md w-full">
</div>
<div class="flex flex-col gap-2">
<label class="text-sm font-medium text-right">العنوان الفرعي</label>
<input type="text" value="اكتشف تشكيلة واسعة من المنتجات الأصلية مع ضمان وخدمة توصيل سريعة" class="custom-input p-3 rounded-md w-full">
</div>
<div class="grid grid-cols-2 gap-6">
<div class="flex flex-col gap-2">
<label class="text-sm font-medium text-right">نص الزر الأول</label>
<input type="text" value="تسوق الآن" class="custom-input p-3 rounded-md w-full">
</div>
<div class="flex flex-col gap-2">
<label class="text-sm font-medium text-right">رابط الزر الأول</label>
<input type="text" value="/products" class="custom-input p-3 rounded-md w-full">
</div>
<div class="flex flex-col gap-2">
<label class="text-sm font-medium text-right">نص الزر الثاني</label>
<input type="text" value="تواصل معنا" class="custom-input p-3 rounded-md w-full">
</div>
<div class="flex flex-col gap-2">
<label class="text-sm font-medium text-right">رابط الزر الثاني</label>
<input type="text" value="/contact" class="custom-input p-3 rounded-md w-full">
</div>
</div>
<div class="flex flex-col gap-2">
<label class="text-sm font-medium text-right">صورة الخلفية</label>
<div class="flex items-center gap-4">
<button class="bg-gray-700 text-white py-2 px-4 rounded-button text-sm font-medium whitespace-nowrap">تغيير الصورة</button>
<div class="w-full h-40 bg-gray-800 rounded-md overflow-hidden">
<img src="https://readdy.ai/api/search-image?query=modern%20electronics%20store%20with%20latest%20gadgets%20and%20smartphones%20displayed%20in%20a%20clean%20minimalist%20setting%20with%20soft%20lighting%20and%20a%20simple%20background&width=800&height=400&seq=1&orientation=landscape" alt="Hero Background" class="w-full h-full object-cover object-top">
</div>
</div>
</div>
</div>
</div>
<!-- Categories Section -->
<div class="section-card mb-8 overflow-hidden">
<div class="section-header p-4 flex justify-between items-center">
<div class="flex items-center gap-2">
<label class="inline-flex items-center cursor-pointer">
<input type="checkbox" class="sr-only peer" checked>
<div class="relative w-14 h-7 bg-gray-700 peer-checked:bg-primary rounded-full peer-checked:after:translate-x-10 rtl:peer-checked:after:-translate-x-10 after:content-[''] after:absolute after:top-1 after:right-1 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
<span class="mr-3 text-sm font-medium text-gray-300">عرض القسم</span>
</label>
</div>
<div class="flex items-center gap-3">
<h2 class="text-lg font-medium">قسم الفئات</h2>
<div class="w-6 h-6 flex items-center justify-center text-primary">
<i class="ri-grid-line"></i>
</div>
</div>
</div>
<div class="p-6 space-y-6">
<div class="flex flex-col gap-2">
<label class="text-sm font-medium text-right">عنوان القسم</label>
<input type="text" value="تصفح حسب الفئات" class="custom-input p-3 rounded-md w-full">
</div>
<div class="flex flex-col gap-2">
<div class="flex justify-between items-center mb-2">
<button id="addCategoryBtn" class="bg-primary text-[#0f172a] py-2 px-4 rounded-button text-sm font-medium whitespace-nowrap">إضافة فئة</button>
<label class="text-sm font-medium text-right">الفئات المعروضة</label>
</div>
<div class="space-y-4">
<div class="bg-[#111827] rounded-md p-4 flex justify-between items-center draggable-item" draggable="true">
<div class="flex items-center gap-3">
<button class="text-gray-400 hover:text-red-500">
<i class="ri-delete-bin-line"></i>
</button>
<button class="text-gray-400 hover:text-gray-200 drag-handle">
<i class="ri-drag-move-line"></i>
</button>
</div>
<div class="flex items-center gap-4">
<div class="text-right">
<p class="font-medium">الهواتف الذكية</p>
<p class="text-sm text-gray-400">23 منتج</p>
</div>
<div class="w-12 h-12 bg-gray-700 rounded-md flex items-center justify-center">
<i class="ri-smartphone-line text-xl"></i>
</div>
</div>
</div>
<div class="bg-[#111827] rounded-md p-4 flex justify-between items-center draggable-item" draggable="true">
<div class="flex items-center gap-3">
<button class="text-gray-400 hover:text-red-500">
<i class="ri-delete-bin-line"></i>
</button>
<button class="text-gray-400 hover:text-gray-200 drag-handle">
<i class="ri-drag-move-line"></i>
</button>
</div>
<div class="flex items-center gap-4">
<div class="text-right">
<p class="font-medium">أجهزة الكمبيوتر المحمولة</p>
<p class="text-sm text-gray-400">17 منتج</p>
</div>
<div class="w-12 h-12 bg-gray-700 rounded-md flex items-center justify-center">
<i class="ri-macbook-line text-xl"></i>
</div>
</div>
</div>
<div class="bg-[#111827] rounded-md p-4 flex justify-between items-center draggable-item" draggable="true">
<div class="flex items-center gap-3">
<button class="text-gray-400 hover:text-red-500">
<i class="ri-delete-bin-line"></i>
</button>
<button class="text-gray-400 hover:text-gray-200 drag-handle">
<i class="ri-drag-move-line"></i>
</button>
</div>
<div class="flex items-center gap-4">
<div class="text-right">
<p class="font-medium">الساعات الذكية</p>
<p class="text-sm text-gray-400">9 منتجات</p>
</div>
<div class="w-12 h-12 bg-gray-700 rounded-md flex items-center justify-center">
<i class="ri-watch-line text-xl"></i>
</div>
</div>
</div>
<div class="bg-[#111827] rounded-md p-4 flex justify-between items-center draggable-item" draggable="true">
<div class="flex items-center gap-3">
<button class="text-gray-400 hover:text-red-500">
<i class="ri-delete-bin-line"></i>
</button>
<button class="text-gray-400 hover:text-gray-200 drag-handle">
<i class="ri-drag-move-line"></i>
</button>
</div>
<div class="flex items-center gap-4">
<div class="text-right">
<p class="font-medium">سماعات الرأس</p>
<p class="text-sm text-gray-400">14 منتج</p>
</div>
<div class="w-12 h-12 bg-gray-700 rounded-md flex items-center justify-center">
<i class="ri-headphone-line text-xl"></i>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- Featured Products Section -->
<div class="section-card mb-8 overflow-hidden">
<div class="section-header p-4 flex justify-between items-center">
<div class="flex items-center gap-2">
<label class="inline-flex items-center cursor-pointer">
<input type="checkbox" class="sr-only peer" checked>
<div class="relative w-14 h-7 bg-gray-700 peer-checked:bg-primary rounded-full peer-checked:after:translate-x-10 rtl:peer-checked:after:-translate-x-10 after:content-[''] after:absolute after:top-1 after:right-1 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
<span class="mr-3 text-sm font-medium text-gray-300">عرض القسم</span>
</label>
</div>
<div class="flex items-center gap-3">
<h2 class="text-lg font-medium">المنتجات المميزة</h2>
<div class="w-6 h-6 flex items-center justify-center text-primary">
<i class="ri-award-line"></i>
</div>
</div>
</div>
<div class="p-6 space-y-6">
<div class="flex flex-col gap-2">
<label class="text-sm font-medium text-right">عنوان القسم</label>
<input type="text" value="منتجاتنا المميزة" class="custom-input p-3 rounded-md w-full">
</div>
<div class="flex flex-col gap-2">
<div class="flex justify-between items-center mb-2">
<div class="flex items-center gap-2">
<button id="selectProductsBtn" class="bg-primary text-[#0f172a] py-2 px-4 rounded-button text-sm font-medium whitespace-nowrap">اختيار المنتجات</button>
<select class="custom-input p-3 rounded-md text-sm pr-8">
<option>عرض 4 منتجات</option>
<option>عرض 8 منتجات</option>
<option>عرض 12 منتج</option>
</select>
</div>
<label class="text-sm font-medium text-right">المنتجات المعروضة</label>
</div>
<div class="grid grid-cols-2 gap-4">
<div class="bg-[#111827] rounded-md p-4 flex justify-between items-center">
<div class="flex items-center gap-3">
<button class="text-gray-400 hover:text-red-500">
<i class="ri-delete-bin-line"></i>
</button>
</div>
<div class="flex items-center gap-4">
<div class="text-right">
<p class="font-medium">آيفون 15 برو ماكس</p>
<p class="text-sm text-primary">4,999 ريال</p>
</div>
<div class="w-12 h-12 bg-gray-700 rounded-md overflow-hidden">
<img src="https://readdy.ai/api/search-image?query=iphone%2015%20pro%20max%20on%20clean%20white%20background%2C%20product%20photography&width=100&height=100&seq=2&orientation=squarish" alt="iPhone" class="w-full h-full object-cover object-top">
</div>
</div>
</div>
<div class="bg-[#111827] rounded-md p-4 flex justify-between items-center">
<div class="flex items-center gap-3">
<button class="text-gray-400 hover:text-red-500">
<i class="ri-delete-bin-line"></i>
</button>
</div>
<div class="flex items-center gap-4">
<div class="text-right">
<p class="font-medium">سامسونج جالاكسي S24 ألترا</p>
<p class="text-sm text-primary">4,799 ريال</p>
</div>
<div class="w-12 h-12 bg-gray-700 rounded-md overflow-hidden">
<img src="https://readdy.ai/api/search-image?query=samsung%20galaxy%20s24%20ultra%20on%20clean%20white%20background%2C%20product%20photography&width=100&height=100&seq=3&orientation=squarish" alt="Samsung" class="w-full h-full object-cover object-top">
</div>
</div>
</div>
<div class="bg-[#111827] rounded-md p-4 flex justify-between items-center">
<div class="flex items-center gap-3">
<button class="text-gray-400 hover:text-red-500">
<i class="ri-delete-bin-line"></i>
</button>
</div>
<div class="flex items-center gap-4">
<div class="text-right">
<p class="font-medium">ماك بوك برو M3</p>
<p class="text-sm text-primary">7,999 ريال</p>
</div>
<div class="w-12 h-12 bg-gray-700 rounded-md overflow-hidden">
<img src="https://readdy.ai/api/search-image?query=macbook%20pro%20m3%20on%20clean%20white%20background%2C%20product%20photography&width=100&height=100&seq=4&orientation=squarish" alt="MacBook" class="w-full h-full object-cover object-top">
</div>
</div>
</div>
<div class="bg-[#111827] rounded-md p-4 flex justify-between items-center">
<div class="flex items-center gap-3">
<button class="text-gray-400 hover:text-red-500">
<i class="ri-delete-bin-line"></i>
</button>
</div>
<div class="flex items-center gap-4">
<div class="text-right">
<p class="font-medium">ابل واتش سيريس 9</p>
<p class="text-sm text-primary">1,899 ريال</p>
</div>
<div class="w-12 h-12 bg-gray-700 rounded-md overflow-hidden">
<img src="https://readdy.ai/api/search-image?query=apple%20watch%20series%209%20on%20clean%20white%20background%2C%20product%20photography&width=100&height=100&seq=5&orientation=squarish" alt="Apple Watch" class="w-full h-full object-cover object-top">
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- Services Section -->
<div class="section-card mb-8 overflow-hidden">
<div class="section-header p-4 flex justify-between items-center">
<div class="flex items-center gap-2">
<label class="inline-flex items-center cursor-pointer">
<input type="checkbox" class="sr-only peer" checked>
<div class="relative w-14 h-7 bg-gray-700 peer-checked:bg-primary rounded-full peer-checked:after:translate-x-10 rtl:peer-checked:after:-translate-x-10 after:content-[''] after:absolute after:top-1 after:right-1 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
<span class="mr-3 text-sm font-medium text-gray-300">عرض القسم</span>
</label>
</div>
<div class="flex items-center gap-3">
<h2 class="text-lg font-medium">خدمات المتجر</h2>
<div class="w-6 h-6 flex items-center justify-center text-primary">
<i class="ri-customer-service-line"></i>
</div>
</div>
</div>
<div class="p-6 space-y-6">
<div class="flex flex-col gap-2">
<label class="text-sm font-medium text-right">عنوان القسم</label>
<input type="text" value="لماذا تختارنا" class="custom-input p-3 rounded-md w-full">
</div>
<div class="flex flex-col gap-2">
<div class="flex justify-between items-center mb-2">
<button class="bg-primary text-[#0f172a] py-2 px-4 rounded-button text-sm font-medium whitespace-nowrap">إضافة خدمة</button>
<label class="text-sm font-medium text-right">الخدمات المعروضة</label>
</div>
<div class="space-y-4">
<div class="bg-[#111827] rounded-md p-4 flex justify-between items-center draggable-item" draggable="true">
<div class="flex items-center gap-3">
<button class="text-gray-400 hover:text-red-500">
<i class="ri-delete-bin-line"></i>
</button>
<button class="text-gray-400 hover:text-gray-200 drag-handle">
<i class="ri-drag-move-line"></i>
</button>
</div>
<div class="flex items-center gap-4">
<div class="text-right">
<p class="font-medium">توصيل سريع</p>
<p class="text-sm text-gray-400">توصيل لجميع مناطق المملكة خلال 24-48 ساعة</p>
</div>
<div class="w-12 h-12 bg-gray-700 rounded-md flex items-center justify-center">
<i class="ri-truck-line text-xl"></i>
</div>
</div>
</div>
<div class="bg-[#111827] rounded-md p-4 flex justify-between items-center draggable-item" draggable="true">
<div class="flex items-center gap-3">
<button class="text-gray-400 hover:text-red-500">
<i class="ri-delete-bin-line"></i>
</button>
<button class="text-gray-400 hover:text-gray-200 drag-handle">
<i class="ri-drag-move-line"></i>
</button>
</div>
<div class="flex items-center gap-4">
<div class="text-right">
<p class="font-medium">ضمان أصلي</p>
<p class="text-sm text-gray-400">جميع منتجاتنا أصلية 100% مع ضمان الوكيل</p>
</div>
<div class="w-12 h-12 bg-gray-700 rounded-md flex items-center justify-center">
<i class="ri-shield-check-line text-xl"></i>
</div>
</div>
</div>
<div class="bg-[#111827] rounded-md p-4 flex justify-between items-center draggable-item" draggable="true">
<div class="flex items-center gap-3">
<button class="text-gray-400 hover:text-red-500">
<i class="ri-delete-bin-line"></i>
</button>
<button class="text-gray-400 hover:text-gray-200 drag-handle">
<i class="ri-drag-move-line"></i>
</button>
</div>
<div class="flex items-center gap-4">
<div class="text-right">
<p class="font-medium">دعم فني 24/7</p>
<p class="text-sm text-gray-400">فريق دعم فني متاح على مدار الساعة لمساعدتك</p>
</div>
<div class="w-12 h-12 bg-gray-700 rounded-md flex items-center justify-center">
<i class="ri-customer-service-2-line text-xl"></i>
</div>
</div>
</div>
<div class="bg-[#111827] rounded-md p-4 flex justify-between items-center draggable-item" draggable="true">
<div class="flex items-center gap-3">
<button class="text-gray-400 hover:text-red-500">
<i class="ri-delete-bin-line"></i>
</button>
<button class="text-gray-400 hover:text-gray-200 drag-handle">
<i class="ri-drag-move-line"></i>
</button>
</div>
<div class="flex items-center gap-4">
<div class="text-right">
<p class="font-medium">استرجاع مجاني</p>
<p class="text-sm text-gray-400">استرجاع مجاني خلال 14 يوم من الشراء</p>
</div>
<div class="w-12 h-12 bg-gray-700 rounded-md flex items-center justify-center">
<i class="ri-refund-2-line text-xl"></i>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- Reviews Section -->
<div class="section-card mb-8 overflow-hidden">
<div class="section-header p-4 flex justify-between items-center">
<div class="flex items-center gap-2">
<label class="inline-flex items-center cursor-pointer">
<input type="checkbox" class="sr-only peer" checked>
<div class="relative w-14 h-7 bg-gray-700 peer-checked:bg-primary rounded-full peer-checked:after:translate-x-10 rtl:peer-checked:after:-translate-x-10 after:content-[''] after:absolute after:top-1 after:right-1 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
<span class="mr-3 text-sm font-medium text-gray-300">عرض القسم</span>
</label>
</div>
<div class="flex items-center gap-3">
<h2 class="text-lg font-medium">آراء العملاء</h2>
<div class="w-6 h-6 flex items-center justify-center text-primary">
<i class="ri-chat-quote-line"></i>
</div>
</div>
</div>
<div class="p-6 space-y-6">
<div class="flex flex-col gap-2">
<label class="text-sm font-medium text-right">عنوان القسم</label>
<input type="text" value="ماذا يقول عملاؤنا" class="custom-input p-3 rounded-md w-full">
</div>
<div class="flex flex-col gap-2">
<div class="flex justify-between items-center mb-2">
<div class="flex items-center gap-2">
<button id="addReviewBtn" class="bg-primary text-[#0f172a] py-2 px-4 rounded-button text-sm font-medium whitespace-nowrap">إضافة تقييم</button>
<select class="custom-input p-3 rounded-md text-sm pr-8">
<option>عرض 3 تقييمات</option>
<option>عرض 6 تقييمات</option>
<option>عرض 9 تقييمات</option>
</select>
</div>
<label class="text-sm font-medium text-right">التقييمات المعروضة</label>
</div>
<div class="space-y-4">
<div class="bg-[#111827] rounded-md p-4">
<div class="flex justify-between items-start mb-3">
<div class="flex items-center gap-1">
<i class="ri-star-fill text-yellow-400"></i>
<i class="ri-star-fill text-yellow-400"></i>
<i class="ri-star-fill text-yellow-400"></i>
<i class="ri-star-fill text-yellow-400"></i>
<i class="ri-star-fill text-yellow-400"></i>
</div>
<div class="flex items-center gap-3">
<div class="text-right">
<p class="font-medium">عبدالله الشمري</p>
<p class="text-sm text-gray-400">الرياض</p>
</div>
<div class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center">
<i class="ri-user-line"></i>
</div>
</div>
</div>
<p class="text-sm text-gray-300 text-right">اشتريت آيفون 15 برو من المتجر وكانت التجربة ممتازة من البداية للنهاية. المنتج أصلي والتوصيل كان سريع جداً. سأتعامل معهم مرة أخرى بالتأكيد.</p>
<div class="flex justify-end mt-3">
<button class="text-gray-400 hover:text-red-500">
<i class="ri-delete-bin-line"></i>
</button>
</div>
</div>
<div class="bg-[#111827] rounded-md p-4">
<div class="flex justify-between items-start mb-3">
<div class="flex items-center gap-1">
<i class="ri-star-fill text-yellow-400"></i>
<i class="ri-star-fill text-yellow-400"></i>
<i class="ri-star-fill text-yellow-400"></i>
<i class="ri-star-fill text-yellow-400"></i>
<i class="ri-star-line text-yellow-400"></i>
</div>
<div class="flex items-center gap-3">
<div class="text-right">
<p class="font-medium">سارة العتيبي</p>
<p class="text-sm text-gray-400">جدة</p>
</div>
<div class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center">
<i class="ri-user-line"></i>
</div>
</div>
</div>
<p class="text-sm text-gray-300 text-right">خدمة عملاء ممتازة وسرعة في الرد على الاستفسارات. المنتج وصل بحالة ممتازة والتغليف كان آمن جداً. أنصح بالتعامل معهم.</p>
<div class="flex justify-end mt-3">
<button class="text-gray-400 hover:text-red-500">
<i class="ri-delete-bin-line"></i>
</button>
</div>
</div>
<div class="bg-[#111827] rounded-md p-4">
<div class="flex justify-between items-start mb-3">
<div class="flex items-center gap-1">
<i class="ri-star-fill text-yellow-400"></i>
<i class="ri-star-fill text-yellow-400"></i>
<i class="ri-star-fill text-yellow-400"></i>
<i class="ri-star-fill text-yellow-400"></i>
<i class="ri-star-half-line text-yellow-400"></i>
</div>
<div class="flex items-center gap-3">
<div class="text-right">
<p class="font-medium">محمد القحطاني</p>
<p class="text-sm text-gray-400">الدمام</p>
</div>
<div class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center">
<i class="ri-user-line"></i>
</div>
</div>
</div>
<p class="text-sm text-gray-300 text-right">اشتريت لابتوب ماك بوك برو وكان السعر منافس جداً مقارنة بالمتاجر الأخرى. التوصيل كان سريع والمنتج أصلي 100%. سأعود للشراء منهم مرة أخرى.</p>
<div class="flex justify-end mt-3">
<button class="text-gray-400 hover:text-red-500">
<i class="ri-delete-bin-line"></i>
</button>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- Location Section -->
<div class="section-card mb-8 overflow-hidden">
<div class="section-header p-4 flex justify-between items-center">
<div class="flex items-center gap-2">
<label class="inline-flex items-center cursor-pointer">
<input type="checkbox" class="sr-only peer" checked>
<div class="relative w-14 h-7 bg-gray-700 peer-checked:bg-primary rounded-full peer-checked:after:translate-x-10 rtl:peer-checked:after:-translate-x-10 after:content-[''] after:absolute after:top-1 after:right-1 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
<span class="mr-3 text-sm font-medium text-gray-300">عرض القسم</span>
</label>
</div>
<div class="flex items-center gap-3">
<h2 class="text-lg font-medium">موقعنا</h2>
<div class="w-6 h-6 flex items-center justify-center text-primary">
<i class="ri-map-pin-line"></i>
</div>
</div>
</div>
<div class="p-6 space-y-6">
<div class="flex flex-col gap-2">
<label class="text-sm font-medium text-right">عنوان القسم</label>
<input type="text" value="تواصل معنا" class="custom-input p-3 rounded-md w-full">
</div>
<div class="grid grid-cols-2 gap-6">
<div class="flex flex-col gap-2">
<label class="text-sm font-medium text-right">العنوان</label>
<input type="text" value="شارع الملك فهد، حي العليا، الرياض" class="custom-input p-3 rounded-md w-full">
</div>
<div class="flex flex-col gap-2">
<label class="text-sm font-medium text-right">رقم الهاتف</label>
<input type="text" value="+966 55 123 4567" class="custom-input p-3 rounded-md w-full">
</div>
<div class="flex flex-col gap-2">
<label class="text-sm font-medium text-right">البريد الإلكتروني</label>
<input type="text" value="info@electronics-store.com" class="custom-input p-3 rounded-md w-full">
</div>
<div class="flex flex-col gap-2">
<label class="text-sm font-medium text-right">ساعات العمل</label>
<input type="text" value="السبت - الخميس: 10:00 ص - 10:00 م" class="custom-input p-3 rounded-md w-full">
</div>
</div>
<div class="flex flex-col gap-2">
<label class="text-sm font-medium text-right">الخريطة</label>
<div class="w-full h-64 bg-gray-800 rounded-md overflow-hidden">
<img src="https://public.readdy.ai/gen_page/map_placeholder_1280x720.png" alt="Store Location Map" class="w-full h-full object-cover object-top">
</div>
</div>
</div>
</div>
<!-- Footer Section -->
<div class="section-card mb-8 overflow-hidden">
<div class="section-header p-4 flex justify-between items-center">
<div class="flex items-center gap-2">
<label class="inline-flex items-center cursor-pointer">
<input type="checkbox" class="sr-only peer" checked>
<div class="relative w-14 h-7 bg-gray-700 peer-checked:bg-primary rounded-full peer-checked:after:translate-x-10 rtl:peer-checked:after:-translate-x-10 after:content-[''] after:absolute after:top-1 after:right-1 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
<span class="mr-3 text-sm font-medium text-gray-300">عرض القسم</span>
</label>
</div>
<div class="flex items-center gap-3">
<h2 class="text-lg font-medium">تذييل الصفحة</h2>
<div class="w-6 h-6 flex items-center justify-center text-primary">
<i class="ri-layout-bottom-line"></i>
</div>
</div>
</div>
<div class="p-6 space-y-6">
<div class="flex flex-col gap-2">
<label class="text-sm font-medium text-right">وصف المتجر في التذييل</label>
<textarea rows="3" class="custom-input p-3 rounded-md w-full">متجر الإلكترونيات الحديثة هو وجهتك الأولى للحصول على أحدث الأجهزة الإلكترونية والهواتف الذكية بأفضل الأسعار وأعلى جودة. نوفر منتجات أصلية مع ضمان الوكيل وخدمة توصيل سريعة لجميع أنحاء المملكة.</textarea>
</div>
<div class="flex flex-col gap-2">
<div class="flex justify-between items-center mb-2">
<button class="bg-primary text-[#0f172a] py-2 px-4 rounded-button text-sm font-medium whitespace-nowrap">إضافة رابط</button>
<label class="text-sm font-medium text-right">روابط سريعة</label>
</div>
<div class="space-y-2" id="quickLinksContainer">
<div class="bg-[#111827] rounded-md p-3 flex justify-between items-center draggable-item" draggable="true">
<div class="flex items-center gap-3">
<button class="text-gray-400 hover:text-red-500">
<i class="ri-delete-bin-line"></i>
</button>
<button class="text-gray-400 hover:text-gray-200 drag-handle">
<i class="ri-drag-move-line"></i>
</button>
</div>
<div class="flex items-center gap-4">
<div class="text-right">
<p class="font-medium">من نحن</p>
<p class="text-xs text-gray-400">/about</p>
</div>
</div>
</div>
<div class="bg-[#111827] rounded-md p-3 flex justify-between items-center draggable-item" draggable="true">
<div class="flex items-center gap-3">
<button class="text-gray-400 hover:text-red-500">
<i class="ri-delete-bin-line"></i>
</button>
<button class="text-gray-400 hover:text-gray-200 drag-handle">
<i class="ri-drag-move-line"></i>
</button>
</div>
<div class="flex items-center gap-4">
<div class="text-right">
<p class="font-medium">سياسة الخصوصية</p>
<p class="text-xs text-gray-400">/privacy</p>
</div>
</div>
</div>
<div class="bg-[#111827] rounded-md p-3 flex justify-between items-center draggable-item" draggable="true">
<div class="flex items-center gap-3">
<button class="text-gray-400 hover:text-red-500">
<i class="ri-delete-bin-line"></i>
</button>
<button class="text-gray-400 hover:text-gray-200 drag-handle">
<i class="ri-drag-move-line"></i>
</button>
</div>
<div class="flex items-center gap-4">
<div class="text-right">
<p class="font-medium">الشروط والأحكام</p>
<p class="text-xs text-gray-400">/terms</p>
</div>
</div>
</div>
<div class="bg-[#111827] rounded-md p-3 flex justify-between items-center draggable-item" draggable="true">
<div class="flex items-center gap-3">
<button class="text-gray-400 hover:text-red-500">
<i class="ri-delete-bin-line"></i>
</button>
<button class="text-gray-400 hover:text-gray-200 drag-handle">
<i class="ri-drag-move-line"></i>
</button>
</div>
<div class="flex items-center gap-4">
<div class="text-right">
<p class="font-medium">اتصل بنا</p>
<p class="text-xs text-gray-400">/contact</p>
</div>
</div>
</div>
</div>
</div>
<div class="flex flex-col gap-2">
<div class="flex justify-between items-center mb-2">
<button id="addPaymentMethodBtn" class="bg-primary text-[#0f172a] py-2 px-4 rounded-button text-sm font-medium whitespace-nowrap">إضافة وسيلة دفع</button>
<label class="text-sm font-medium text-right">وسائل الدفع</label>
</div>
<div id="paymentMethodsContainer" class="flex gap-3 justify-end">
<div class="w-12 h-8 bg-gray-700 rounded-md flex items-center justify-center">
<i class="ri-visa-fill text-xl"></i>
</div>
<div class="w-12 h-8 bg-gray-700 rounded-md flex items-center justify-center">
<i class="ri-mastercard-fill text-xl"></i>
</div>
<div class="w-12 h-8 bg-gray-700 rounded-md flex items-center justify-center">
<i class="ri-paypal-fill text-xl"></i>
</div>
<div class="w-12 h-8 bg-gray-700 rounded-md flex items-center justify-center">
<i class="ri-apple-fill text-xl"></i>
</div>
<div class="w-12 h-8 bg-gray-700 rounded-md flex items-center justify-center">
<i class="ri-bank-card-fill text-xl"></i>
</div>
</div>
</div>
<div class="flex flex-col gap-2">
<div class="flex justify-between items-center mb-2">
<button class="bg-primary text-[#0f172a] py-2 px-4 rounded-button text-sm font-medium whitespace-nowrap">إضافة منصة</button>
<label class="text-sm font-medium text-right">وسائل التواصل الاجتماعي</label>
</div>
<div class="flex gap-3 justify-end">
<div class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center">
<i class="ri-instagram-line text-lg"></i>
</div>
<div class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center">
<i class="ri-twitter-x-line text-lg"></i>
</div>
<div class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center">
<i class="ri-facebook-line text-lg"></i>
</div>
<div class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center">
<i class="ri-youtube-line text-lg"></i>
</div>
<div class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center">
<i class="ri-snapchat-line text-lg"></i>
</div>
</div>
</div>
<div class="flex flex-col gap-2">
<label class="text-sm font-medium text-right">حقوق النشر</label>
<input type="text" value="© 2025 متجر الإلكترونيات الحديثة. جميع الحقوق محفوظة." class="custom-input p-3 rounded-md w-full">
</div>
</div>
</div>
<!-- Theme Colors Section -->
<div class="section-card mb-8 overflow-hidden">
<div class="section-header p-4 flex justify-between items-center">
<div class="flex items-center gap-2">
<button class="bg-primary text-[#0f172a] py-2 px-4 rounded-button text-sm font-medium whitespace-nowrap">حفظ الألوان</button>
</div>
<div class="flex items-center gap-3">
<h2 class="text-lg font-medium">ألوان المتجر</h2>
<div class="w-6 h-6 flex items-center justify-center text-primary">
<i class="ri-palette-line"></i>
</div>
</div>
</div>
<div class="p-6 space-y-6">
<div class="grid grid-cols-2 gap-6">
<div class="flex flex-col gap-2">
<label class="text-sm font-medium text-right">اللون الرئيسي</label>
<div class="flex items-center gap-3">
<input type="text" value="#00e5bb" class="custom-input p-3 rounded-md w-full">
<input type="color" value="#00e5bb" class="color-picker">
</div>
</div>
<div class="flex flex-col gap-2">
<label class="text-sm font-medium text-right">لون الخلفية</label>
<div class="flex items-center gap-3">
<input type="text" value="#0f172a" class="custom-input p-3 rounded-md w-full">
<input type="color" value="#0f172a" class="color-picker">
</div>
</div>
<div class="flex flex-col gap-2">
<label class="text-sm font-medium text-right">لون النص</label>
<div class="flex items-center gap-3">
<input type="text" value="#ffffff" class="custom-input p-3 rounded-md w-full">
<input type="color" value="#ffffff" class="color-picker">
</div>
</div>
<div class="flex flex-col gap-2">
<label class="text-sm font-medium text-right">لون النص الثانوي</label>
<div class="flex items-center gap-3">
<input type="text" value="#94a3b8" class="custom-input p-3 rounded-md w-full">
<input type="color" value="#94a3b8" class="color-picker">
</div>
</div>
</div>
<div class="flex flex-col gap-2">
<label class="text-sm font-medium text-right">معاينة الألوان</label>
<div class="grid grid-cols-4 gap-4">
<div class="h-20 rounded-md" style="background-color: #00e5bb;"></div>
<div class="h-20 rounded-md" style="background-color: #0f172a;"></div>
<div class="h-20 rounded-md flex items-center justify-center" style="background-color: #ffffff; color: #0f172a;">نص</div>
<div class="h-20 rounded-md flex items-center justify-center" style="background-color: #0f172a; color: #94a3b8;">نص ثانوي</div>
</div>
</div>
</div>
</div>
<!-- Save Changes Button -->
<div class="flex justify-between mb-8">
<button class="bg-gray-700 text-white py-3 px-6 rounded-button text-sm font-medium whitespace-nowrap">إلغاء التغييرات</button>
<button class="bg-primary text-[#0f172a] py-3 px-6 rounded-button text-sm font-medium whitespace-nowrap">حفظ جميع التغييرات</button>
</div>
</div>
</div>
</div>
<div id="toast" class="toast" role="alert"></div>
<div id="productSelectionDialog" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
<div class="bg-[#1e293b] rounded-lg p-6 w-full max-w-4xl mx-4 max-h-[80vh] flex flex-col">
<div class="flex justify-between items-center mb-4">
<button id="closeProductDialog" class="text-gray-400 hover:text-white">
<i class="ri-close-line text-xl"></i>
</button>
<h3 class="text-lg font-medium">اختيار المنتجات المميزة</h3>
</div>
<div class="flex gap-4 mb-4">
<div class="flex-1 relative">
<input type="text" id="productSearch" placeholder="البحث عن منتج..." class="custom-input p-3 rounded-md w-full pl-10">
<div class="absolute left-3 top-1/2 transform -translate-y-1/2">
<i class="ri-search-line text-gray-400"></i>
</div>
</div>
<select id="categoryFilter" class="custom-input p-3 rounded-md pr-8">
<option value="">جميع الفئات</option>
<option value="phones">الهواتف الذكية</option>
<option value="laptops">أجهزة الكمبيوتر المحمولة</option>
<option value="watches">الساعات الذكية</option>
<option value="headphones">سماعات الرأس</option>
</select>
</div>
<div class="flex-1 overflow-y-auto">
<div id="productsList" class="space-y-2">
</div>
</div>
<div class="flex justify-end gap-3 mt-4 pt-4 border-t border-gray-700">
<button id="cancelProductSelection" class="bg-gray-700 text-white py-2 px-4 rounded-button text-sm font-medium whitespace-nowrap">إلغاء</button>
<button id="confirmProductSelection" class="bg-primary text-[#0f172a] py-2 px-4 rounded-button text-sm font-medium whitespace-nowrap">تأكيد الاختيار</button>
</div>
</div>
</div>
<div id="categoryDialog" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
<div class="bg-[#1e293b] rounded-lg p-6 w-full max-w-md mx-4">
<div class="flex justify-between items-center mb-4">
<button id="closeCategoryDialog" class="text-gray-400 hover:text-white">
<i class="ri-close-line text-xl"></i>
</button>
<h3 class="text-lg font-medium">إضافة فئة جديدة</h3>
</div>
<div class="space-y-4">
<div class="flex flex-col gap-2">
<label class="text-sm font-medium text-right">اسم الفئة</label>
<input type="text" id="categoryName" class="custom-input p-3 rounded-md w-full" placeholder="أدخل اسم الفئة">
</div>
<div class="flex flex-col gap-2">
<label class="text-sm font-medium text-right">أيقونة الفئة</label>
<select id="categoryIcon" class="custom-input p-3 rounded-md w-full pr-8">
<option value="ri-smartphone-line">هاتف ذكي</option>
<option value="ri-macbook-line">لابتوب</option>
<option value="ri-watch-line">ساعة ذكية</option>
<option value="ri-headphone-line">سماعات</option>
<option value="ri-gamepad-line">ألعاب</option>
<option value="ri-camera-line">كاميرا</option>
<option value="ri-tv-line">تلفاز</option>
<option value="ri-computer-line">كمبيوتر</option>
</select>
</div>
<div class="flex flex-col gap-2">
<label class="text-sm font-medium text-right">صورة الفئة (اختياري)</label>
<div class="flex items-center gap-3">
<button id="uploadCategoryImage" class="bg-gray-700 text-white py-2 px-4 rounded-button text-sm font-medium whitespace-nowrap">اختيار صورة</button>
<div id="selectedImagePreview" class="w-12 h-12 bg-gray-700 rounded-md flex items-center justify-center">
<i class="ri-image-line text-xl"></i>
</div>
</div>
</div>
<div class="flex justify-end gap-3 mt-6">
<button id="cancelCategory" class="bg-gray-700 text-white py-2 px-4 rounded-button text-sm font-medium whitespace-nowrap">إلغاء</button>
<button id="addNewCategory" class="bg-primary text-[#0f172a] py-2 px-4 rounded-button text-sm font-medium whitespace-nowrap">إضافة</button>
</div>
</div>
</div>
</div>
<div id="reviewDialog" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
<div class="bg-[#1e293b] rounded-lg p-6 w-full max-w-md mx-4">
<div class="flex justify-between items-center mb-4">
<button id="closeReviewDialog" class="text-gray-400 hover:text-white">
<i class="ri-close-line text-xl"></i>
</button>
<h3 class="text-lg font-medium">إضافة تقييم جديد</h3>
</div>
<div class="space-y-4">
<div class="flex flex-col gap-2">
<label class="text-sm font-medium text-right">اسم العميل</label>
<input type="text" id="reviewName" class="custom-input p-3 rounded-md w-full" placeholder="أدخل اسم العميل">
</div>
<div class="flex flex-col gap-2">
<label class="text-sm font-medium text-right">المدينة</label>
<input type="text" id="reviewCity" class="custom-input p-3 rounded-md w-full" placeholder="أدخل اسم المدينة">
</div>
<div class="flex flex-col gap-2">
<label class="text-sm font-medium text-right">نص التقييم</label>
<textarea id="reviewText" rows="3" class="custom-input p-3 rounded-md w-full" placeholder="أدخل نص التقييم"></textarea>
</div>
<div class="flex flex-col gap-2">
<label class="text-sm font-medium text-right">التقييم</label>
<div class="flex gap-2 justify-end" id="starRating">
<i class="ri-star-line text-2xl text-yellow-400 cursor-pointer hover:text-yellow-300" data-rating="1"></i>
<i class="ri-star-line text-2xl text-yellow-400 cursor-pointer hover:text-yellow-300" data-rating="2"></i>
<i class="ri-star-line text-2xl text-yellow-400 cursor-pointer hover:text-yellow-300" data-rating="3"></i>
<i class="ri-star-line text-2xl text-yellow-400 cursor-pointer hover:text-yellow-300" data-rating="4"></i>
<i class="ri-star-line text-2xl text-yellow-400 cursor-pointer hover:text-yellow-300" data-rating="5"></i>
</div>
</div>
<div class="flex justify-end gap-3 mt-6">
<button id="cancelReview" class="bg-gray-700 text-white py-2 px-4 rounded-button text-sm font-medium whitespace-nowrap">إلغاء</button>
<button id="addNewReview" class="bg-primary text-[#0f172a] py-2 px-4 rounded-button text-sm font-medium whitespace-nowrap">إضافة</button>
</div>
</div>
</div>
</div>
<div id="paymentMethodDialog" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
<div class="bg-[#1e293b] rounded-lg p-6 w-full max-w-md mx-4">
<div class="flex justify-between items-center mb-4">
<button id="closePaymentDialog" class="text-gray-400 hover:text-white">
<i class="ri-close-line text-xl"></i>
</button>
<h3 class="text-lg font-medium">إضافة وسيلة دفع جديدة</h3>
</div>
<div class="space-y-4">
<div class="flex flex-col gap-2">
<label class="text-sm font-medium text-right">نوع وسيلة الدفع</label>
<select id="paymentType" class="custom-input p-3 rounded-md w-full pr-8">
<option value="ri-visa-fill">Visa</option>
<option value="ri-mastercard-fill">Mastercard</option>
<option value="ri-paypal-fill">PayPal</option>
<option value="ri-apple-fill">Apple Pay</option>
<option value="ri-bank-card-fill">Bank Card</option>
</select>
</div>
<div class="flex justify-end gap-3 mt-6">
<button id="cancelPaymentMethod" class="bg-gray-700 text-white py-2 px-4 rounded-button text-sm font-medium whitespace-nowrap">إلغاء</button>
<button id="addNewPaymentMethod" class="bg-primary text-[#0f172a] py-2 px-4 rounded-button text-sm font-medium whitespace-nowrap">إضافة</button>
</div>
</div>
</div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
const reviewDialog = document.getElementById('reviewDialog');
const addReviewBtn = document.getElementById('addReviewBtn');
const closeReviewDialog = document.getElementById('closeReviewDialog');
const cancelReview = document.getElementById('cancelReview');
const addNewReview = document.getElementById('addNewReview');
const reviewName = document.getElementById('reviewName');
const reviewCity = document.getElementById('reviewCity');
const reviewText = document.getElementById('reviewText');
const starRating = document.getElementById('starRating');
let selectedRating = 0;
function showReviewDialog() {
    reviewDialog.style.display = 'flex';
    reviewName.value = '';
    reviewCity.value = '';
    reviewText.value = '';
    selectedRating = 0;
    updateStarRating();
}
function hideReviewDialog() {
    reviewDialog.style.display = 'none';
}
function updateStarRating() {
    const stars = starRating.querySelectorAll('i');
    stars.forEach((star, index) => {
        star.className = index < selectedRating ? 
            'ri-star-fill text-2xl text-yellow-400 cursor-pointer hover:text-yellow-300' :
            'ri-star-line text-2xl text-yellow-400 cursor-pointer hover:text-yellow-300';
    });
}
starRating.addEventListener('click', (e) => {
    if (e.target.matches('i')) {
        selectedRating = parseInt(e.target.dataset.rating);
        updateStarRating();
    }
});
function addReview() {
    if (!reviewName.value.trim() || !reviewCity.value.trim() || !reviewText.value.trim() || selectedRating === 0) {
        showToast('الرجاء إكمال جميع الحقول المطلوبة');
        return;
    }
    const reviewsContainer = document.querySelector('.space-y-4');
    const newReview = document.createElement('div');
    newReview.className = 'bg-[#111827] rounded-md p-4';
    newReview.innerHTML = `
        <div class="flex justify-between items-start mb-3">
            <div class="flex items-center gap-1">
                ${Array(5).fill().map((_, i) => `<i class="ri-star-${i < selectedRating ? 'fill' : 'line'} text-yellow-400"></i>`).join('')}
            </div>
            <div class="flex items-center gap-3">
                <div class="text-right">
                    <p class="font-medium">${reviewName.value}</p>
                    <p class="text-sm text-gray-400">${reviewCity.value}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center">
                    <i class="ri-user-line"></i>
                </div>
            </div>
        </div>
        <p class="text-sm text-gray-300 text-right">${reviewText.value}</p>
        <div class="flex justify-end mt-3">
            <button class="text-gray-400 hover:text-red-500">
                <i class="ri-delete-bin-line"></i>
            </button>
        </div>
    `;
    reviewsContainer.insertBefore(newReview, reviewsContainer.firstChild);
    
    newReview.querySelector('.hover\\:text-red-500').addEventListener('click', function() {
        newReview.remove();
        showToast('تم حذف التقييم بنجاح');
    });
    hideReviewDialog();
    showToast('تمت إضافة التقييم بنجاح');
}
addReviewBtn.addEventListener('click', showReviewDialog);
closeReviewDialog.addEventListener('click', hideReviewDialog);
cancelReview.addEventListener('click', hideReviewDialog);
addNewReview.addEventListener('click', addReview);
const categoryDialog = document.getElementById('categoryDialog');
const addCategoryBtn = document.getElementById('addCategoryBtn');
const closeCategoryDialog = document.getElementById('closeCategoryDialog');
const cancelCategory = document.getElementById('cancelCategory');
const addNewCategory = document.getElementById('addNewCategory');
const categoryName = document.getElementById('categoryName');
const categoryIcon = document.getElementById('categoryIcon');
const uploadCategoryImage = document.getElementById('uploadCategoryImage');
const selectedImagePreview = document.getElementById('selectedImagePreview');
function showCategoryDialog() {
categoryDialog.style.display = 'flex';
categoryName.value = '';
categoryIcon.selectedIndex = 0;
selectedImagePreview.innerHTML = '<i class="ri-image-line text-xl"></i>';
}
function hideCategoryDialog() {
categoryDialog.style.display = 'none';
}
function addCategory() {
if (!categoryName.value.trim()) {
showToast('الرجاء إدخال اسم الفئة');
return;
}
const categoriesContainer = document.querySelector('.space-y-4');
const newCategory = document.createElement('div');
newCategory.className = 'bg-[#111827] rounded-md p-4 flex justify-between items-center draggable-item';
newCategory.draggable = true;
newCategory.innerHTML = `
<div class="flex items-center gap-3">
<button class="text-gray-400 hover:text-red-500">
<i class="ri-delete-bin-line"></i>
</button>
<button class="text-gray-400 hover:text-gray-200 drag-handle">
<i class="ri-drag-move-line"></i>
</button>
</div>
<div class="flex items-center gap-4">
<div class="text-right">
<p class="font-medium">${categoryName.value}</p>
<p class="text-sm text-gray-400">0 منتج</p>
</div>
<div class="w-12 h-12 bg-gray-700 rounded-md flex items-center justify-center">
<i class="${categoryIcon.value} text-xl"></i>
</div>
</div>
`;
categoriesContainer.appendChild(newCategory);
initDraggable(categoriesContainer);
newCategory.querySelector('.hover\\:text-red-500').addEventListener('click', function() {
newCategory.remove();
showToast('تم حذف الفئة بنجاح');
});
hideCategoryDialog();
showToast('تمت إضافة الفئة بنجاح');
}
addCategoryBtn.addEventListener('click', showCategoryDialog);
closeCategoryDialog.addEventListener('click', hideCategoryDialog);
cancelCategory.addEventListener('click', hideCategoryDialog);
addNewCategory.addEventListener('click', addCategory);
uploadCategoryImage.addEventListener('click', function() {
showToast('سيتم إضافة خاصية تحميل الصور قريباً');
});
const products = [
{
id: 1,
name: 'آيفون 15 برو ماكس',
price: '4,999 ريال',
category: 'phones',
image: 'https://readdy.ai/api/search-image?query=iphone%2015%20pro%20max%20on%20clean%20white%20background%2C%20product%20photography&width=100&height=100&seq=2&orientation=squarish'
},
{
id: 2,
name: 'سامسونج جالاكسي S24 ألترا',
price: '4,799 ريال',
category: 'phones',
image: 'https://readdy.ai/api/search-image?query=samsung%20galaxy%20s24%20ultra%20on%20clean%20white%20background%2C%20product%20photography&width=100&height=100&seq=3&orientation=squarish'
},
{
id: 3,
name: 'ماك بوك برو M3',
price: '7,999 ريال',
category: 'laptops',
image: 'https://readdy.ai/api/search-image?query=macbook%20pro%20m3%20on%20clean%20white%20background%2C%20product%20photography&width=100&height=100&seq=4&orientation=squarish'
},
{
id: 4,
name: 'ابل واتش سيريس 9',
price: '1,899 ريال',
category: 'watches',
image: 'https://readdy.ai/api/search-image?query=apple%20watch%20series%209%20on%20clean%20white%20background%2C%20product%20photography&width=100&height=100&seq=5&orientation=squarish'
}
];
const productSelectionDialog = document.getElementById('productSelectionDialog');
const selectProductsBtn = document.getElementById('selectProductsBtn');
const closeProductDialog = document.getElementById('closeProductDialog');
const cancelProductSelection = document.getElementById('cancelProductSelection');
const confirmProductSelection = document.getElementById('confirmProductSelection');
const productSearch = document.getElementById('productSearch');
const categoryFilter = document.getElementById('categoryFilter');
const productsList = document.getElementById('productsList');
function showProductDialog() {
productSelectionDialog.style.display = 'flex';
renderProducts(products);
}
function hideProductDialog() {
productSelectionDialog.style.display = 'none';
}
function renderProducts(productsToRender) {
productsList.innerHTML = '';
productsToRender.forEach(product => {
const productElement = document.createElement('div');
productElement.className = 'bg-[#111827] rounded-md p-4 flex justify-between items-center';
productElement.innerHTML = `
<div class="flex items-center gap-4">
<input type="checkbox" class="w-5 h-5 rounded-md" data-product-id="${product.id}">
<div class="w-12 h-12 bg-gray-700 rounded-md overflow-hidden">
<img src="${product.image}" alt="${product.name}" class="w-full h-full object-cover object-top">
</div>
<div class="text-right">
<p class="font-medium">${product.name}</p>
<p class="text-sm text-primary">${product.price}</p>
</div>
</div>
`;
productsList.appendChild(productElement);
});
}
function filterProducts() {
const searchTerm = productSearch.value.toLowerCase();
const selectedCategory = categoryFilter.value;
const filteredProducts = products.filter(product => {
const matchesSearch = product.name.toLowerCase().includes(searchTerm);
const matchesCategory = !selectedCategory || product.category === selectedCategory;
return matchesSearch && matchesCategory;
});
renderProducts(filteredProducts);
}
function handleProductSelection() {
const selectedProducts = Array.from(productsList.querySelectorAll('input[type="checkbox"]:checked')).map(checkbox => {
const productId = parseInt(checkbox.dataset.productId);
return products.find(p => p.id === productId);
});
const featuredProductsContainer = document.querySelector('.grid.grid-cols-2.gap-4');
featuredProductsContainer.innerHTML = '';
selectedProducts.forEach(product => {
const productElement = document.createElement('div');
productElement.className = 'bg-[#111827] rounded-md p-4 flex justify-between items-center';
productElement.innerHTML = `
<div class="flex items-center gap-3">
<button class="text-gray-400 hover:text-red-500">
<i class="ri-delete-bin-line"></i>
</button>
</div>
<div class="flex items-center gap-4">
<div class="text-right">
<p class="font-medium">${product.name}</p>
<p class="text-sm text-primary">${product.price}</p>
</div>
<div class="w-12 h-12 bg-gray-700 rounded-md overflow-hidden">
<img src="${product.image}" alt="${product.name}" class="w-full h-full object-cover object-top">
</div>
</div>
`;
featuredProductsContainer.appendChild(productElement);
});
hideProductDialog();
showToast('تم تحديث المنتجات المميزة بنجاح');
}
selectProductsBtn.addEventListener('click', showProductDialog);
closeProductDialog.addEventListener('click', hideProductDialog);
cancelProductSelection.addEventListener('click', hideProductDialog);
confirmProductSelection.addEventListener('click', handleProductSelection);
productSearch.addEventListener('input', filterProducts);
categoryFilter.addEventListener('change', filterProducts);
const paymentMethodDialog = document.getElementById('paymentMethodDialog');
const addPaymentMethodBtn = document.getElementById('addPaymentMethodBtn');
const closePaymentDialog = document.getElementById('closePaymentDialog');
const cancelPaymentMethod = document.getElementById('cancelPaymentMethod');
const addNewPaymentMethod = document.getElementById('addNewPaymentMethod');
const paymentMethodsContainer = document.getElementById('paymentMethodsContainer');
function showPaymentDialog() {
paymentMethodDialog.style.display = 'flex';
}
function hidePaymentDialog() {
paymentMethodDialog.style.display = 'none';
}
function addPaymentMethod() {
const paymentType = document.getElementById('paymentType');
const iconClass = paymentType.value;
const newPayment = document.createElement('div');
newPayment.className = 'w-12 h-8 bg-gray-700 rounded-md flex items-center justify-center';
newPayment.innerHTML = `<i class="${iconClass} text-xl"></i>`;
paymentMethodsContainer.insertBefore(newPayment, paymentMethodsContainer.firstChild);
hidePaymentDialog();
showToast('تمت إضافة وسيلة الدفع بنجاح');
}
addPaymentMethodBtn.addEventListener('click', showPaymentDialog);
closePaymentDialog.addEventListener('click', hidePaymentDialog);
cancelPaymentMethod.addEventListener('click', hidePaymentDialog);
addNewPaymentMethod.addEventListener('click', addPaymentMethod);
const categoriesContainer = document.querySelector('.space-y-4');
const quickLinksContainer = document.getElementById('quickLinksContainer');
const draggableItems = document.querySelectorAll('.draggable-item');
const toast = document.getElementById('toast');
let draggedItem = null;
function initDraggable(container) {
if (!container) return;
const items = container.querySelectorAll('.draggable-item');
items.forEach(item => {
item.addEventListener('dragstart', handleDragStart);
item.addEventListener('dragend', handleDragEnd);
item.addEventListener('dragover', handleDragOver);
item.addEventListener('drop', handleDrop);
item.addEventListener('dragenter', handleDragEnter);
item.addEventListener('dragleave', handleDragLeave);
});
}
initDraggable(categoriesContainer);
initDraggable(quickLinksContainer);
draggableItems.forEach(item => {
item.addEventListener('dragstart', handleDragStart);
item.addEventListener('dragend', handleDragEnd);
item.addEventListener('dragover', handleDragOver);
item.addEventListener('drop', handleDrop);
item.addEventListener('dragenter', handleDragEnter);
item.addEventListener('dragleave', handleDragLeave);
});
function handleDragStart(e) {
draggedItem = this;
this.classList.add('dragging');
document.body.style.cursor = 'grabbing';
}
function handleDragEnd(e) {
this.classList.remove('dragging');
document.body.style.cursor = '';
const message = this.closest('#quickLinksContainer') ?
'تم تغيير ترتيب الروابط بنجاح' :
'تم تغيير ترتيب العناصر بنجاح';
showToast(message);
}
function handleDragOver(e) {
e.preventDefault();
}
function handleDragEnter(e) {
e.preventDefault();
if (this !== draggedItem) {
this.classList.add('drag-over');
}
}
function handleDragLeave(e) {
this.classList.remove('drag-over');
}
function handleDrop(e) {
e.preventDefault();
if (this !== draggedItem) {
let allItems = [...draggableItems];
let draggedIndex = allItems.indexOf(draggedItem);
let droppedIndex = allItems.indexOf(this);
if (draggedIndex < droppedIndex) {
this.parentNode.insertBefore(draggedItem, this.nextSibling);
} else {
this.parentNode.insertBefore(draggedItem, this);
}
}
this.classList.remove('drag-over');
}
function showToast(message) {
toast.textContent = message;
toast.classList.add('show');
setTimeout(() => {
toast.classList.remove('show');
}, 3000);
}
});
</script>
</body>
</html>