<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="0;url={{ $redirect_url }}">
    <title>جاري التحويل إلى بوابة الدفع</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
        }
        .ltr {
            direction: ltr;
        }
    </style>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center" onload="redirectNow()">
    <div class="bg-white p-8 rounded-lg shadow-md max-w-md w-full text-center">
        <div class="mb-6">
            <svg class="animate-spin mx-auto h-12 w-12 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
        
        <h1 class="text-2xl font-bold text-gray-800 mb-4">جاري التحويل إلى بوابة الدفع</h1>
        
        <p class="text-gray-600 mb-6">{{ $message ?? 'جاري تحويلك إلى صفحة الدفع. إذا لم يتم تحويلك تلقائياً، يرجى النقر على الزر أدناه.' }}</p>
        
        <a href="{{ $redirect_url }}" id="payment-button" class="bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 inline-block" onclick="redirectToPayment()">
            {{ $button_text ?? 'الانتقال إلى صفحة الدفع' }}
        </a>
        
        <p class="mt-4 text-gray-500 text-sm ltr">
            <a href="{{ $redirect_url }}" class="break-all">{{ $redirect_url }}</a>
        </p>
    </div>
    
    <script>
        // توجيه فوري عند تحميل الصفحة
        function redirectNow() {
            window.location.href = "{{ $redirect_url }}";
        }
        
        // نسخة احتياطية تعمل عند النقر على الزر
        function redirectToPayment() {
            document.getElementById('payment-button').innerHTML = 'جاري التحويل...';
            window.location.href = "{{ $redirect_url }}";
            return false;
        }
        
        // توجيه إضافي بعد نصف ثانية للتأكد من العمل
        setTimeout(function() {
            window.location.href = "{{ $redirect_url }}";
        }, 500);
        
        // محاولة أخرى باستخدام window.open
        setTimeout(function() {
            window.open("{{ $redirect_url }}", "_self");
        }, 1000);
    </script>
</body>
</html> 