@extends('themes.admin.layouts.app')

@section('title', 'إدارة الشريط المتحرك')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-gray-700 dark:text-gray-100 text-3xl font-medium">إدارة الشريط المتحرك</h3>
        <a href="{{ route('admin.dashboard') }}" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-100 px-4 py-2 rounded-md">
            العودة للوحة التحكم
        </a>
    </div>

    <div class="mt-8">
        <div id="marquee-settings-alert" class="hidden mb-4 p-4 rounded-md"></div>
        <form action="{{ route('admin.marquee.save') }}" method="POST" class="bg-white dark:bg-gray-800 rounded-md shadow-md p-4 md:p-6">
            @csrf
            @if ($errors->any())
            <div class="bg-red-100 dark:bg-red-900 border-l-4 border-red-500 text-red-700 dark:text-red-100 p-4 mb-6" role="alert">
                <p class="font-bold">يرجى تصحيح الأخطاء التالية:</p>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 md:gap-6 items-end">
                <div>
                    <label class="text-gray-700 dark:text-gray-200 font-medium mb-1 block text-sm">لون النص</label>
                    <input type="color" name="marquee_color" class="form-input w-12 h-8 p-0 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-md" value="{{ old('marquee_color', \App\Models\Setting::get('marquee_color', '#ffffff')) }}">
                </div>
                <div>
                    <label class="text-gray-700 dark:text-gray-200 font-medium mb-1 block text-sm">لون بداية الخلفية</label>
                    <input type="color" name="marquee_bg_start" class="form-input w-12 h-8 p-0 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-md" value="{{ old('marquee_bg_start', \App\Models\Setting::get('marquee_bg_start', '#2196F3')) }}">
                </div>
                <div>
                    <label class="text-gray-700 dark:text-gray-200 font-medium mb-1 block text-sm">لون نهاية الخلفية</label>
                    <input type="color" name="marquee_bg_end" class="form-input w-12 h-8 p-0 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-md" value="{{ old('marquee_bg_end', \App\Models\Setting::get('marquee_bg_end', '#9C27B0')) }}">
                </div>
                <div>
                    <label class="text-gray-700 dark:text-gray-200 font-medium mb-1 block text-sm">سرعة الحركة (ث)</label>
                    <input type="number" name="marquee_speed" class="form-input w-full px-2 py-1 border rounded-md bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 border-gray-300 dark:border-gray-700 text-sm" min="5" max="60" value="{{ old('marquee_speed', \App\Models\Setting::get('marquee_speed', 25)) }}">
                </div>
                <div class="flex items-center gap-4 mt-2 md:mt-0 col-span-2 md:col-span-4">
                    <label class="flex items-center text-gray-700 dark:text-gray-200 text-sm">
                        <input type="checkbox" name="marquee_bold" value="1" {{ old('marquee_bold', \App\Models\Setting::get('marquee_bold')) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 border-gray-300 dark:border-gray-600 rounded focus:ring-blue-500">
                        <span class="ml-2">نص بولد</span>
                    </label>
                    <label class="flex items-center text-gray-700 dark:text-gray-200 text-sm">
                        <input type="checkbox" name="marquee_enabled" value="1" {{ old('marquee_enabled', \App\Models\Setting::get('marquee_enabled', 1)) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 border-gray-300 dark:border-gray-600 rounded focus:ring-blue-500">
                        <span class="ml-2">تفعيل الشريط</span>
                    </label>
                </div>
            </div>
            <div class="mt-6 flex justify-end">
                <button type="submit" class="px-6 py-2 bg-blue-600 dark:bg-blue-800 text-white rounded-md hover:bg-blue-700 dark:hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-opacity-50 text-sm">
                    حفظ الإعدادات
                </button>
            </div>
        </form>
    </div>

    @php
        $marqueeItems = [];
        $json = \App\Models\Setting::get('marquee_texts');
        if ($json) {
            // حاول فك JSON أولاً
            $marqueeItems = json_decode($json, true);
            // إذا لم يكن JSON أو كان فارغاً، اعتبره نصوص مفصولة بـ |
            if (!is_array($marqueeItems)) {
                $marqueeItems = [];
                $parts = array_filter(array_map('trim', explode('|', $json)));
                foreach ($parts as $part) {
                    $marqueeItems[] = [
                        'text' => $part,
                        'url' => '',
                        'enabled' => true
                    ];
                }
            }
        }
    @endphp

    <div class="mt-10 bg-gray-50 dark:bg-gray-800 rounded-md p-6">
        <h2 class="text-lg font-bold text-gray-700 dark:text-gray-200 mb-4">الرسائل الحالية في الشريط:</h2>
        <div class="space-y-3" id="marquee-items-list">
            @foreach($marqueeItems as $i => $item)
                <div class="flex items-center justify-between bg-white dark:bg-gray-900 rounded p-3 border border-gray-200 dark:border-gray-700" data-index="{{ $i }}">
                    <div class="flex items-center gap-2">
                        @if(!empty($item['icon']))
                            <span class="marquee-icon">{!! $item['icon'] !!}</span>
                        @endif
                        <span class="font-bold text-gray-800 dark:text-gray-100 marquee-text">{{ $item['text'] }}</span>
                        @if(!empty($item['url']))
                            <a href="{{ $item['url'] }}" target="_blank" class="text-blue-600 hover:underline ml-2 marquee-url">{{ $item['url'] }}</a>
                        @endif
                        @if(empty($item['enabled']) || !$item['enabled'])
                            <span class="text-xs text-red-500 ml-2 marquee-status">معطل</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" class="edit-marquee-btn bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded" data-index="{{ $i }}">تعديل</button>
                        <button type="button" class="delete-marquee-btn bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded" data-index="{{ $i }}">حذف</button>
                        <button type="button" class="toggle-marquee-btn bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded" data-index="{{ $i }}">
                            {{ (!empty($item['enabled']) && $item['enabled']) ? 'تعطيل' : 'تفعيل' }}
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6 flex justify-end">
            <button type="button" id="add-marquee-btn" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md">إضافة رسالة جديدة</button>
        </div>
    </div>

    <!-- Modal for editing/adding -->
    <div id="marquee-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-8 w-full max-w-md">
            <h3 class="text-lg font-bold mb-4 text-gray-800 dark:text-gray-100" id="modal-title">تعديل الرسالة</h3>
            <form id="marquee-edit-form">
                <input type="hidden" name="index" id="modal-index">
                <div class="mb-4">
                    <label class="block font-bold mb-2 text-gray-700 dark:text-gray-200">النص</label>
                    <input type="text" name="text" id="modal-text" class="form-input w-full bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 border border-gray-300 dark:border-gray-700 rounded-md p-3">
                </div>
                <div class="mb-4">
                    <label class="block font-bold mb-2 text-gray-700 dark:text-gray-200">الأيقونة (اختياري)</label>
                    <input type="text" name="icon" id="modal-icon" class="form-input w-full bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 border border-gray-300 dark:border-gray-700 rounded-md p-3" placeholder="مثال: 🔥 أو <i class='fa fa-star'></i>">
                </div>
                <div class="mb-4">
                    <label class="block font-bold mb-2 text-gray-700 dark:text-gray-200">الرابط (اختياري)</label>
                    <input type="text" name="url" id="modal-url" class="form-input w-full bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 border border-gray-300 dark:border-gray-700 rounded-md p-3">
                </div>
                <div class="mb-4 flex items-center">
                    <input type="checkbox" name="enabled" id="modal-enabled" class="mr-2">
                    <label for="modal-enabled" class="text-gray-700 dark:text-gray-200">مفعل</label>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" id="modal-cancel" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">إلغاء</button>
                    <button type="submit" class="bg-blue-600 dark:bg-blue-800 text-white px-6 py-2 rounded hover:bg-blue-700 dark:hover:bg-blue-900 transition">حفظ التعديل</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // إضافة رسالة جديدة
    document.getElementById('add-marquee-btn').onclick = function() {
        document.getElementById('modal-title').textContent = 'إضافة رسالة جديدة';
        document.getElementById('modal-index').value = '';
        document.getElementById('modal-text').value = '';
        document.getElementById('modal-url').value = '';
        document.getElementById('modal-icon').value = '';
        document.getElementById('modal-enabled').checked = true;
        document.getElementById('marquee-modal').classList.remove('hidden');
    };
    // فتح المودال مع تعبئة البيانات
    document.querySelectorAll('.edit-marquee-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var index = btn.getAttribute('data-index');
            var row = btn.closest('[data-index]');
            var text = row.querySelector('.marquee-text').textContent.trim();
            var url = row.querySelector('.marquee-url') ? row.querySelector('.marquee-url').textContent.trim() : '';
            var icon = row.querySelector('.marquee-icon') ? row.querySelector('.marquee-icon').innerHTML.trim() : '';
            var enabled = !row.querySelector('.marquee-status');
            document.getElementById('modal-index').value = index;
            document.getElementById('modal-text').value = text;
            document.getElementById('modal-url').value = url;
            document.getElementById('modal-icon').value = icon;
            document.getElementById('modal-enabled').checked = enabled;
            document.getElementById('marquee-modal').classList.remove('hidden');
        });
    });
    // إغلاق المودال
    document.getElementById('modal-cancel').onclick = function() {
        document.getElementById('marquee-modal').classList.add('hidden');
    };
    // حفظ التعديل أو الإضافة من المودال
    document.getElementById('marquee-edit-form').onsubmit = function(e) {
        e.preventDefault();
        var index = document.getElementById('modal-index').value;
        var text = document.getElementById('modal-text').value;
        var url = document.getElementById('modal-url').value;
        var icon = document.getElementById('modal-icon').value;
        var enabled = document.getElementById('modal-enabled').checked ? 1 : 0;
        var route = index === '' ? "{{ route('admin.marquee.update-item') }}" : "{{ route('admin.marquee.update-item') }}";
        var data = {text, url, icon, enabled};
        if(index !== '') data.index = index;
        else data.add = 1;
        fetch(route, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
            },
            body: JSON.stringify(data)
        })
        .then(r => r.json())
        .then(data => {
            if(data.success) {
                location.reload();
            } else {
                alert('خطأ: ' + (data.error || 'تعذر الحفظ'));
            }
        });
    };
    // تفعيل/تعطيل الرسالة
    document.querySelectorAll('.toggle-marquee-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var index = btn.getAttribute('data-index');
            fetch("{{ route('admin.marquee.toggle-item') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                },
                body: JSON.stringify({index})
            })
            .then(r => r.json())
            .then(data => {
                if(data.success) {
                    location.reload();
                } else {
                    alert('خطأ: ' + (data.error || 'تعذر التفعيل/التعطيل'));
                }
            });
        });
    });
    // حذف الرسالة
    document.querySelectorAll('.delete-marquee-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            if(!confirm('هل أنت متأكد من حذف هذه الرسالة؟')) return;
            var index = btn.getAttribute('data-index');
            fetch("{{ route('admin.marquee.delete-item') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                },
                body: JSON.stringify({index})
            })
            .then(r => r.json())
            .then(data => {
                if(data.success) {
                    location.reload();
                } else {
                    alert('خطأ: ' + (data.error || 'تعذر الحذف'));
                }
            });
        });
    });

    // حفظ إعدادات الشريط عبر AJAX
    document.querySelector('form[action="{{ route('admin.marquee.save') }}"]').onsubmit = function(e) {
        e.preventDefault();
        var form = this;
        var formData = new FormData(form);
        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
            },
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            var alertBox = document.getElementById('marquee-settings-alert');
            if(data.success) {
                alertBox.className = 'mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md';
                alertBox.textContent = 'تم حفظ إعدادات الشريط بنجاح';
            } else {
                alertBox.className = 'mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md';
                alertBox.textContent = data.error || 'تعذر الحفظ';
            }
            alertBox.classList.remove('hidden');
            setTimeout(function(){ alertBox.classList.add('hidden'); }, 2500);
        });
    };
});
</script>
@endpush 