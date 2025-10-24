@extends('themes.admin.layouts.app')

@section('title', 'المتواجدون الآن')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">المتواجدون الآن</h1>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300">
                    <i class="ri-eye-line text-2xl"></i>
                </div>
                <div class="mr-4">
                    <h3 class="text-gray-500 dark:text-gray-400 text-sm">إجمالي الزوار</h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $totalVisits }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300">
                    <i class="ri-user-line text-2xl"></i>
                </div>
                <div class="mr-4">
                    <h3 class="text-gray-500 dark:text-gray-400 text-sm">إجمالي المتواجدين الآن</h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Online Users Table -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            المستخدم
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            النوع
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            الصفحة الحالية
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            آخر نشاط
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            IP
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($onlineUsers as $user)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($user->user)
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full" src="{{ $user->user->avatar_url }}" alt="{{ $user->user->name }}">
                                    </div>
                                    <div class="mr-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $user->user->name }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $user->user->email }}
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center bg-gray-200 dark:bg-gray-700 rounded-full">
                                        @if($user->user_type === 'bot')
                                            <i class="ri-robot-2-line text-xl text-yellow-500"></i>
                                        @else
                                            <i class="ri-user-3-line text-xl text-gray-400"></i>
                                        @endif
                                    </div>
                                    <div class="mr-3">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            @if($user->user_type === 'bot')
                                                زائر (عناكب البحث)
                                            @else
                                                زائر
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $user->user_type === 'admin' ? 'bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200' :
                                   ($user->user_type === 'user' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' :
                                    'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200') }}">
                                {{ $user->user_type === 'admin' ? 'مشرف' :
                                   ($user->user_type === 'user' ? 'مستخدم' : 'زائر') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            <a href="{{ $user->page_url }}" target="_blank" class="text-primary hover:underline">
                                {{ $user->page_name }}
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $user->last_activity->diffForHumans() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $user->ip_address }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            لا يوجد متواجدين حالياً
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $onlineUsers->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // تحديث حالة النشاط كل دقيقتين
    let isUpdating = false;
    let lastUrl = window.location.href;
    
    function getPageTitle() {
        // محاولة جلب العنوان من meta tags
        const metaTitle = document.querySelector('meta[property="og:title"]')?.content ||
                         document.querySelector('meta[name="title"]')?.content;
        
        if (metaTitle) {
            return metaTitle;
        }
        
        // إذا لم نجد في meta tags، نستخدم عنوان الصفحة
        return document.title;
    }

    // مراقبة تغييرات المسار
    function observeUrlChanges() {
        let currentUrl = window.location.href;
        if (currentUrl !== lastUrl) {
            lastUrl = currentUrl;
            updateActivity();
        }
    }

    // تحديث النشاط
    function updateActivity() {
        if (isUpdating) return;
        
        isUpdating = true;
        const currentUrl = window.location.href;
        
        // تجاهل مسار تحديث النشاط
        if (currentUrl.includes('update-activity')) {
            isUpdating = false;
            return;
        }

        fetch('{{ route("admin.online-users.update-activity") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                page_title: getPageTitle(),
                current_url: currentUrl
            })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                console.error('Error updating activity:', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        })
        .finally(() => {
            isUpdating = false;
        });
    }
    
    // مراقبة تغييرات المسار كل ثانية
    setInterval(observeUrlChanges, 1000);
    
    // تحديث النشاط كل دقيقتين
    setInterval(updateActivity, 120000);
</script>
@endpush 