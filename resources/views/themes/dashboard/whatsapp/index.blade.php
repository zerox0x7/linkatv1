@extends('themes.admin.layouts.app')

@section('title', 'لوحة تحكم واتساب')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h3 class="text-gray-700 dark:text-gray-100 text-3xl font-medium">لوحة تحكم واتساب</h3>

    <div class="mt-4 mb-8 bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-md p-6 flex flex-col items-center justify-center shadow-sm text-center">
        <div class="flex items-center justify-center mb-3">
            <svg class="h-10 w-10 text-green-500 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.72 11.06a8.94 8.94 0 01-4.72 4.72l-2.12-.71a1 1 0 00-1.01.24l-1.12 1.12a9.94 9.94 0 01-4.24-4.24l1.12-1.12a1 1 0 00.24-1.01l-.71-2.12A8.94 8.94 0 0112 3c2.21 0 4.26.8 5.86 2.14l-1.12 1.12a1 1 0 00-.24 1.01l.71 2.12z" />
            </svg>
            <span class="text-green-800 dark:text-green-200 font-semibold text-xl">معلومات الربط مع خدمة واتساب</span>
        </div>
        <div class="mb-2 text-green-700 dark:text-green-100 text-base font-medium">
            للاشتراك في خدمة الواتساب يمكنك الاشتراك وربط رقمك من خلال <span class="font-bold">واتسدل</span>.
        </div>
        <a href="https://dl1s.co/payment/index/de39a2bd852/1" target="_blank" class="mt-4 px-7 py-2 bg-green-600 dark:bg-green-800 text-white rounded-md font-semibold shadow hover:bg-green-700 dark:hover:bg-green-900 transition text-lg">الانتقال إلى الاشتراك في واتسدل</a>
    </div>

    <div class="mt-4">
        <div class="flex flex-wrap -mx-6">
            <div class="w-full px-6 sm:w-1/2 xl:w-1/4">
                <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white dark:bg-gray-800">
                    <div class="p-3 rounded-full bg-indigo-600 bg-opacity-75">
                        <svg class="h-8 w-8 text-white" viewBox="0 0 28 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.2 9.08889C18.2 11.5373 16.3196 13.5222 14 13.5222C11.6804 13.5222 9.79999 11.5373 9.79999 9.08889C9.79999 6.64043 11.6804 4.65556 14 4.65556C16.3196 4.65556 18.2 6.64043 18.2 9.08889Z" fill="currentColor"></path>
                            <path d="M25.2 12.0444C25.2 13.6768 23.9464 15 22.4 15C20.8536 15 19.6 13.6768 19.6 12.0444C19.6 10.4121 20.8536 9.08889 22.4 9.08889C23.9464 9.08889 25.2 10.4121 25.2 12.0444Z" fill="currentColor"></path>
                            <path d="M19.6 22.3889C19.6 19.1243 17.0927 16.4778 14 16.4778C10.9072 16.4778 8.39999 19.1243 8.39999 22.3889H19.6Z" fill="currentColor"></path>
                            <path d="M8.39999 12.0444C8.39999 13.6768 7.14639 15 5.59999 15C4.05359 15 2.79999 13.6768 2.79999 12.0444C2.79999 10.4121 4.05359 9.08889 5.59999 9.08889C7.14639 9.08889 8.39999 10.4121 8.39999 12.0444Z" fill="currentColor"></path>
                            <path d="M22.4 22.3889C22.4 19.6243 24.6072 17.3778 27.2 17.3778V22.3889H22.4Z" fill="currentColor"></path>
                            <path d="M5.59999 22.3889C5.59999 19.6243 3.39279 17.3778 0.799988 17.3778V22.3889H5.59999Z" fill="currentColor"></path>
                        </svg>
                    </div>

                    <div class="mx-5">
                        <h4 class="text-2xl font-semibold text-gray-700 dark:text-gray-100">{{ $stats['templatesCount'] }}</h4>
                        <div class="text-gray-500 dark:text-gray-300">القوالب</div>
                    </div>
                </div>
            </div>

            <div class="w-full mt-6 px-6 sm:w-1/2 xl:w-1/4 sm:mt-0">
                <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white dark:bg-gray-800">
                    <div class="p-3 rounded-full bg-green-600 bg-opacity-75">
                        <svg class="h-8 w-8 text-white" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.19999 1.4C3.4268 1.4 2.79999 2.02681 2.79999 2.8C2.79999 3.57319 3.4268 4.2 4.19999 4.2H5.9069L6.33468 5.91114C6.33917 5.93092 6.34409 5.95055 6.34941 5.97001L8.24953 13.5705L6.99992 14.8201C5.23602 16.584 6.48528 19.6 8.97981 19.6H21C21.7731 19.6 22.4 18.9732 22.4 18.2C22.4 17.4268 21.7731 16.8 21 16.8H8.97983L10.3798 15.4H19.6C20.1303 15.4 20.615 15.1004 20.8521 14.6261L25.0521 6.22609C25.2691 5.79212 25.246 5.27673 24.991 4.86398C24.7357 4.45123 24.2852 4.2 23.8 4.2H8.79308L8.35818 2.46044C8.20238 1.83722 7.64241 1.4 6.99999 1.4H4.19999Z" fill="currentColor"></path>
                            <path d="M22.4 23.1C22.4 24.2598 21.4598 25.2 20.3 25.2C19.1403 25.2 18.2 24.2598 18.2 23.1C18.2 21.9402 19.1403 21 20.3 21C21.4598 21 22.4 21.9402 22.4 23.1Z" fill="currentColor"></path>
                            <path d="M9.1 25.2C10.2598 25.2 11.2 24.2598 11.2 23.1C11.2 21.9402 10.2598 21 9.1 21C7.9402 21 7 21.9402 7 23.1C7 24.2598 7.9402 25.2 9.1 25.2Z" fill="currentColor"></path>
                        </svg>
                    </div>

                    <div class="mx-5">
                        <h4 class="text-2xl font-semibold text-gray-700 dark:text-gray-100">{{ $stats['logsCount'] }}</h4>
                        <div class="text-gray-500 dark:text-gray-300">الرسائل المرسلة</div>
                    </div>
                </div>
            </div>

            <div class="w-full mt-6 px-6 sm:w-1/2 xl:w-1/4 xl:mt-0">
                <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white dark:bg-gray-800">
                    <div class="p-3 rounded-full bg-blue-600 bg-opacity-75">
                        <svg class="h-8 w-8 text-white" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.99998 11.2H21L22.4 23.8H5.59998L6.99998 11.2Z" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linejoin="round"></path>
                            <path d="M9.79999 8.4C9.79999 6.08041 11.6804 4.2 14 4.2C16.3196 4.2 18.2 6.08041 18.2 8.4V12.6C18.2 14.9197 16.3196 16.8 14 16.8C11.6804 16.8 9.79999 14.9197 9.79999 12.6V8.4Z" stroke="currentColor" stroke-width="2"></path>
                        </svg>
                    </div>

                    <div class="mx-5">
                        <h4 class="text-2xl font-semibold text-gray-700 dark:text-gray-100">{{ $stats['sentToday'] }}</h4>
                        <div class="text-gray-500 dark:text-gray-300">الرسائل اليوم</div>
                    </div>
                </div>
            </div>

            <div class="w-full mt-6 px-6 sm:w-1/2 xl:w-1/4 xl:mt-0">
                <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white dark:bg-gray-800">
                    <div class="p-3 rounded-full bg-yellow-600 bg-opacity-75">
                        <svg class="h-8 w-8 text-white" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.99998 11.2H21L22.4 23.8H5.59998L6.99998 11.2Z" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linejoin="round"></path>
                            <path d="M9.79999 8.4C9.79999 6.08041 11.6804 4.2 14 4.2C16.3196 4.2 18.2 6.08041 18.2 8.4V12.6C18.2 14.9197 16.3196 16.8 14 16.8C11.6804 16.8 9.79999 14.9197 9.79999 12.6V8.4Z" stroke="currentColor" stroke-width="2"></path>
                        </svg>
                    </div>

                    <div class="mx-5">
                        <h4 class="text-2xl font-semibold text-gray-700 dark:text-gray-100">{{ $stats['successRate'] }}</h4>
                        <div class="text-gray-500 dark:text-gray-300">الرسائل الناجحة (أسبوعيًا)</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8">
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div class="p-6 bg-white dark:bg-gray-800 rounded-md shadow-md">
                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-100 mb-4">روابط سريعة</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('admin.whatsapp.settings') }}" class="flex items-center p-4 bg-blue-50 dark:bg-blue-900 rounded-md">
                        <svg class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <div class="mr-4">
                            <h3 class="text-md font-medium text-gray-700 dark:text-gray-100">إعدادات الواتساب</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-300">تكوين API الواتساب والإعدادات الأخرى</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('admin.whatsapp.templates') }}" class="flex items-center p-4 bg-purple-50 dark:bg-purple-900 rounded-md">
                        <svg class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                        </svg>
                        <div class="mr-4">
                            <h3 class="text-md font-medium text-gray-700 dark:text-gray-100">قوالب الرسائل</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-300">إدارة قوالب الرسائل المستخدمة</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('admin.whatsapp.test') }}" class="flex items-center p-4 bg-green-50 dark:bg-green-900 rounded-md">
                        <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        <div class="mr-4">
                            <h3 class="text-md font-medium text-gray-700 dark:text-gray-100">اختبار الإرسال</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-300">إرسال رسائل اختبار للتحقق من الإعداد</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('admin.whatsapp.logs') }}" class="flex items-center p-4 bg-red-50 dark:bg-red-900 rounded-md">
                        <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <div class="mr-4">
                            <h3 class="text-md font-medium text-gray-700 dark:text-gray-100">سجلات الإرسال</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-300">عرض سجل الرسائل المرسلة وحالتها</p>
                        </div>
                    </a>
                </div>
            </div>
            
            <div class="p-6 bg-white dark:bg-gray-800 rounded-md shadow-md">
                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-100 mb-4">أنواع الإشعارات المتاحة</h2>
                
                <ul class="space-y-3">
                    <li class="flex items-center text-gray-600 dark:text-gray-300">
                        <svg class="h-5 w-5 text-green-500 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span><strong>حالة الطلب:</strong> إشعارات تغيير حالة الطلب للعملاء</span>
                    </li>
                    <li class="flex items-center text-gray-600 dark:text-gray-300">
                        <svg class="h-5 w-5 text-green-500 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span><strong>رمز التحقق (OTP):</strong> إرسال رموز التحقق للمستخدمين</span>
                    </li>
                    <li class="flex items-center text-gray-600 dark:text-gray-300">
                        <svg class="h-5 w-5 text-green-500 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span><strong>تسليم الطلب:</strong> إخطارات عند تسليم المنتجات</span>
                    </li>
                    <li class="flex items-center text-gray-600 dark:text-gray-300">
                        <svg class="h-5 w-5 text-green-500 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span><strong>تسجيل الدخول:</strong> رموز تسجيل الدخول عبر رقم الهاتف</span>
                    </li>
                </ul>
                
                <div class="mt-6 bg-blue-50 dark:bg-blue-900 p-4 rounded-md">
                    <p class="text-blue-800 dark:text-blue-200 text-sm">
                        <span class="font-bold block mb-1">ملاحظة:</span>
                        لاستخدام هذه الميزات، تأكد من تكوين إعدادات API الواتساب أولاً وإنشاء القوالب المناسبة لكل نوع من أنواع الإشعارات.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 