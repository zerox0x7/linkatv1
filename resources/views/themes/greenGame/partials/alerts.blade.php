@if(session('success'))
<div id="successAlert" class="fixed top-5 right-5 z-50 bg-gradient-to-r from-green-500 to-green-600 text-white p-4 rounded-lg shadow-lg flex items-center glass-effect max-w-md" role="alert">
    <i class="ri-check-line text-xl ml-3"></i>
    <div>{{ session('success') }}</div>
    <button type="button" class="text-white hover:text-gray-200 mr-auto" onclick="closeAlert('successAlert')">
        <i class="ri-close-line"></i>
    </button>
</div>
@endif

@if(session('error'))
<div id="errorAlert" class="fixed top-5 right-5 z-50 bg-gradient-to-r from-red-500 to-red-600 text-white p-4 rounded-lg shadow-lg flex items-center glass-effect max-w-md" role="alert">
    <i class="ri-error-warning-line text-xl ml-3"></i>
    <div>{{ session('error') }}</div>
    <button type="button" class="text-white hover:text-gray-200 mr-auto" onclick="closeAlert('errorAlert')">
        <i class="ri-close-line"></i>
    </button>
</div>
@endif

@if(session('warning'))
<div id="warningAlert" class="fixed top-5 right-5 z-50 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white p-4 rounded-lg shadow-lg flex items-center glass-effect max-w-md" role="alert">
    <i class="ri-alert-line text-xl ml-3"></i>
    <div>{{ session('warning') }}</div>
    <button type="button" class="text-white hover:text-gray-200 mr-auto" onclick="closeAlert('warningAlert')">
        <i class="ri-close-line"></i>
    </button>
</div>
@endif

@if(session('info'))
<div id="infoAlert" class="fixed top-5 right-5 z-50 bg-gradient-to-r from-blue-500 to-blue-600 text-white p-4 rounded-lg shadow-lg flex items-center glass-effect max-w-md" role="alert">
    <i class="ri-information-line text-xl ml-3"></i>
    <div>{{ session('info') }}</div>
    <button type="button" class="text-white hover:text-gray-200 mr-auto" onclick="closeAlert('infoAlert')">
        <i class="ri-close-line"></i>
    </button>
</div>
@endif

@if($errors->any())
<div id="validationAlert" class="fixed top-5 right-5 z-50 bg-gradient-to-r from-red-500 to-red-600 text-white p-4 rounded-lg shadow-lg flex items-center glass-effect max-w-md" role="alert">
    <i class="ri-error-warning-line text-xl ml-3 self-start mt-1"></i>
    <div>
        <p class="font-bold">يرجى تصحيح الأخطاء التالية:</p>
        <ul class="mr-4 mt-2 list-disc">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    <button type="button" class="text-white hover:text-gray-200 mr-auto self-start" onclick="closeAlert('validationAlert')">
        <i class="ri-close-line"></i>
    </button>
</div>
@endif

<script>
    function closeAlert(alertId) {
        document.getElementById(alertId).remove();
    }
    
    // Auto close alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('[id$="Alert"]');
        alerts.forEach(alert => {
            setTimeout(() => {
                if (alert && alert.parentNode) {
                    alert.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                    setTimeout(() => {
                        if (alert && alert.parentNode) {
                            alert.remove();
                        }
                    }, 500);
                }
            }, 5000);
        });
    });
</script> 