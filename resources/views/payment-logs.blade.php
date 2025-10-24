@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">سجلات بوابة الدفع</h5>
                        <div>
                            <a href="/api/payment-logs" target="_blank" class="btn btn-sm btn-outline-primary me-2">عرض كJSON</a>
                            <a href="/view-payment-logs" class="btn btn-sm btn-outline-secondary">تحديث</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="alert alert-info">
                        <h4>معلومات هامة عن حالات الدفع:</h4>
                        <ul>
                            <li><strong>A</strong>: عملية دفع ناجحة (Authorized)</li>
                            <li><strong>C</strong>: ملغية (Cancelled)</li>
                            <li><strong>D</strong>: تم الرفض (Declined)</li>
                            <li><strong>E</strong>: خطأ (Error)</li>
                        </ul>
                        <p>فقط حالة <strong>A</strong> تعني أن عملية الدفع ناجحة.</p>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5 class="card-title">فلترة السجلات</h5>
                                    <div class="form-inline">
                                        <input type="text" id="logSearch" class="form-control mb-2 me-2" placeholder="بحث في السجلات..." style="width: 300px;">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="checkbox" id="filterRespStatus" checked>
                                            <label class="form-check-label" for="filterRespStatus">respStatus</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="checkbox" id="filterTransRef" checked>
                                            <label class="form-check-label" for="filterTransRef">tran_ref</label>
                                        </div>
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="checkbox" id="filterVerification" checked>
                                            <label class="form-check-label" for="filterVerification">نتيجة التحقق</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <h3>آخر سجلات بوابة الدفع ({{ count($logs) }} سجل)</h3>
                    
                    @if(count($logs) > 0)
                        <div id="logsList">
                        @foreach($logs as $index => $log)
                            <div class="card mb-3 log-item" data-log="{{ $log['log'] }}">
                                <div class="card-header bg-light">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <strong>سجل #{{ $index + 1 }}</strong>
                                        <div>
                                            @if(strpos($log['log'], 'respStatus') !== false)
                                                <span class="badge bg-info">respStatus</span>
                                            @endif
                                            
                                            @if(strpos($log['log'], 'tran_ref') !== false)
                                                <span class="badge bg-primary">tran_ref</span>
                                            @endif
                                            
                                            @if(strpos($log['log'], 'نتيجة التحقق من الدفع') !== false)
                                                <span class="badge bg-success">نتيجة التحقق</span>
                                            @endif
                                            
                                            @if(strpos($log['log'], 'استجابة استعلام') !== false)
                                                <span class="badge bg-secondary">استجابة استعلام</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="border p-3 mb-3" style="direction: ltr; text-align: left; overflow-x: auto; background-color: #f8f9fa;">
                                                <code>{{ $log['log'] }}</code>
                                            </div>
                                            <div class="border p-3" style="direction: ltr; text-align: left; background-color: #f8f9fa; overflow-x: auto;">
                                                <pre>{{ json_encode(json_decode($log['data']), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    @else
                        <div class="alert alert-info">
                            لم يتم العثور على سجلات لبوابة الدفع.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('logSearch');
    const logItems = document.querySelectorAll('.log-item');
    const filterRespStatus = document.getElementById('filterRespStatus');
    const filterTransRef = document.getElementById('filterTransRef');
    const filterVerification = document.getElementById('filterVerification');
    
    // وظيفة الفلترة
    function filterLogs() {
        const searchText = searchInput.value.toLowerCase();
        const showRespStatus = filterRespStatus.checked;
        const showTransRef = filterTransRef.checked;
        const showVerification = filterVerification.checked;
        
        logItems.forEach(item => {
            const logText = item.getAttribute('data-log').toLowerCase();
            const hasRespStatus = item.querySelector('.badge.bg-info') !== null;
            const hasTransRef = item.querySelector('.badge.bg-primary') !== null;
            const hasVerification = item.querySelector('.badge.bg-success') !== null;
            
            // فلترة نوع السجل
            let showByType = (showRespStatus && hasRespStatus) || 
                           (showTransRef && hasTransRef) || 
                           (showVerification && hasVerification) ||
                           (!hasRespStatus && !hasTransRef && !hasVerification);
            
            // فلترة نص البحث
            const showBySearch = searchText === '' || logText.includes(searchText);
            
            // عرض/إخفاء العنصر
            item.style.display = (showByType && showBySearch) ? 'block' : 'none';
        });
    }
    
    // تفعيل أحداث البحث
    searchInput.addEventListener('input', filterLogs);
    filterRespStatus.addEventListener('change', filterLogs);
    filterTransRef.addEventListener('change', filterLogs);
    filterVerification.addEventListener('change', filterLogs);
});
</script>
@endsection 