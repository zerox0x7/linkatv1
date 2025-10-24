@extends('themes.admin.layouts.app')

@section('title', 'إدارة الحسابات للمنتج: ' . $product->name)

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">إدارة الحسابات للمنتج: {{ $product->name }}</h1>
        <a href="{{ route('admin.products.show', $product) }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded shadow">عودة لتفاصيل المنتج</a>
    </div>

    <!-- فورم إضافة حساب جديد -->
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-4 mb-6">
        <form method="POST" action="{{ route('admin.products.accounts.store', $product) }}" id="multiAccountsForm">
            @csrf
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">بيانات الحسابات الجديدة</label>
            <div id="accountsInputs">
                <div class="mb-2">
                    <textarea name="accounts[]" rows="2" class="block w-full border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100" placeholder="أدخل بيانات الحساب" required></textarea>
                </div>
            </div>
            <button type="button" onclick="addAccountTextarea()" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-3 py-1 rounded mb-2">+ إضافة حساب آخر</button>
            <br>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">إضافة</button>
        </form>
    </div>

    <!-- جدول الحسابات -->
    <div class="mb-4 flex gap-2">
        <button onclick="filterAccounts('all')" class="filter-btn bg-blue-600 text-white px-3 py-1 rounded">الكل</button>
        <button onclick="filterAccounts('available')" class="filter-btn bg-green-600 text-white px-3 py-1 rounded">المتاحة</button>
        <button onclick="filterAccounts('sold')" class="filter-btn bg-red-600 text-white px-3 py-1 rounded">المباعة</button>
    </div>
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-4">
        <table id="accountsTable" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">#</th>
                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">بيانات الحساب</th>
                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">الحالة</th>
                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">تاريخ الإضافة</th>
                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">إجراءات</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($product->account_digetals as $account)
                <tr data-status="{{ $account->status }}">
                    <td class="px-4 py-2">{{ $account->id }}</td>
                    <td class="px-4 py-2">
                        <form method="POST" action="{{ route('admin.products.accounts.update', ['product' => $product->id, 'account' => $account->id]) }}" class="flex gap-2 items-center">
                            @csrf
                            @method('PUT')
                            @php
                                $accountText = '';
                                if (isset($account->meta['lines'])) {
                                    if (is_array($account->meta['lines'])) {
                                        $accountText = implode("\n", $account->meta['lines']);
                                    } else {
                                        $accountText = $account->meta['lines'];
                                    }
                                } elseif (isset($account->meta['text'])) {
                                    // للتوافق مع البيانات القديمة
                                    try {
                                        $accountText = \Illuminate\Support\Facades\Crypt::decryptString($account->meta['text']);
                                    } catch (\Exception $e) {
                                        $accountText = $account->meta['text'];
                                    }
                                }
                            @endphp
                            <textarea name="text" rows="2" class="block w-full border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">{{ $accountText }}</textarea>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">تحديث</button>
                        </form>
                    </td>
                    <td class="px-4 py-2 text-sm" data-status="{{ $account->status }}">
                        @if($account->status == 'available')
                            <span class="px-2 py-0.5 rounded text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">متاح</span>
                        @else
                            <span class="px-2 py-0.5 rounded text-xs font-medium bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200">
                                مباع
                                @if($account->order_id)
                                    <br>
                                    <span class="text-xs text-gray-500 dark:text-gray-300">
                                        طلب رقم:
                                        <a href="{{ route('admin.orders.show', $account->order_id) }}" class="underline text-blue-600 dark:text-blue-300" target="_blank">
                                            #{{ $account->order_id }}
                                        </a>
                                    </span>
                                @endif
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-2 text-sm">{{ $account->created_at->format('Y-m-d H:i') }}</td>
                    <td class="px-4 py-2 text-center">
                        <form method="POST" action="{{ route('admin.products.accounts.destroy', ['product' => $product->id, 'account' => $account->id]) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">حذف</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-gray-400 dark:text-gray-500 py-6">لا توجد حسابات حالياً</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
function addAccountTextarea() {
    const container = document.getElementById('accountsInputs');
    const div = document.createElement('div');
    div.className = 'mb-2';
    div.innerHTML = `<textarea name="accounts[]" rows="2" class="block w-full border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100" placeholder="أدخل بيانات الحساب" required></textarea>`;
    container.appendChild(div);
}

function filterAccounts(status) {
    document.querySelectorAll('#accountsTable tbody tr').forEach(function(row) {
        if (status === 'all') {
            row.style.display = '';
        } else {
            if (row.getAttribute('data-status') === status) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
}
</script>
@endpush
