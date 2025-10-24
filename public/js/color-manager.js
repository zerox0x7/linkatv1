/**
 * إدارة الألوان المخصصة
 * 
 * يقوم هذا الملف بضبط متغيرات CSS للألوان بناءً على قيم الإعدادات المستلمة من الخادم
 */

document.addEventListener('DOMContentLoaded', function() {
    // الحصول على قيم الألوان من الصفحة
    const primaryColor = document.querySelector('meta[name="primary-color"]')?.getAttribute('content') || '#2196F3';
    const secondaryColor = document.querySelector('meta[name="secondary-color"]')?.getAttribute('content') || '#9C27B0';
    
    // تحديث متغيرات CSS
    document.documentElement.style.setProperty('--primary-color', primaryColor.startsWith('#') ? primaryColor : '#' + primaryColor);
    document.documentElement.style.setProperty('--secondary-color', secondaryColor.startsWith('#') ? secondaryColor : '#' + secondaryColor);
    
    // تحديث لوحة الألوان عند تغيير الإعدادات
    const colorPicker = document.querySelectorAll('.color-picker');
    
    if (colorPicker) {
        colorPicker.forEach(picker => {
            picker.addEventListener('input', function() {
                const colorType = this.getAttribute('data-color-type'); // primary أو secondary
                const colorValue = this.value;
                
                if (colorType === 'primary') {
                    document.documentElement.style.setProperty('--primary-color', colorValue);
                } else if (colorType === 'secondary') {
                    document.documentElement.style.setProperty('--secondary-color', colorValue);
                }
            });
        });
    }
}); 