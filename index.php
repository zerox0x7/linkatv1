<?php

/**
 * ملف تحويل المسار إلى مجلد public
 * 
 * هذا الملف يقوم بتحويل طلبات الزوار من المجلد الجذر إلى مجلد public
 * ليتمكنوا من الوصول للموقع مباشرة عبر الرابط الرئيسي http://localhost/
 */

// تحديد مسار مجلد public
$publicPath = __DIR__ . '/public';

// التحقق من وجود المسار وإلا استخدم المسار الافتراضي
if (!is_dir($publicPath)) {
    die('مجلد public غير موجود. الرجاء التأكد من تثبيت التطبيق بشكل صحيح.');
}

// الحصول على المسار المطلوب وتحويله إلى مجلد public
$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

// تجاهل الملف الحالي
if ($uri === '/' || $uri === '/index.php') {
    require_once $publicPath . '/index.php';
    return;
}

// التحقق إذا كان الملف موجوداً في مجلد public
if (file_exists($publicPath . $uri)) {
    // إذا كان الملف موجوداً، قم بتقديمه مباشرة
    $extension = pathinfo($uri, PATHINFO_EXTENSION);
    // تعيين نوع المحتوى بناءً على الامتداد
    $contentTypes = [
        'css' => 'text/css',
        'js' => 'application/javascript',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        'ico' => 'image/x-icon',
    ];
    
    if (isset($contentTypes[$extension])) {
        header('Content-Type: ' . $contentTypes[$extension]);
    }
    
    readfile($publicPath . $uri);
    return;
}

// إذا لم يكن الملف موجوداً، قم بتشغيل تطبيق Laravel
require_once $publicPath . '/index.php'; 