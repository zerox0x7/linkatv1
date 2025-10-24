@php
    $enabled = \App\Models\Setting::get('marquee_enabled', true);
    if (!$enabled) return;
    $color = \App\Models\Setting::get('marquee_color', '#fff');
    $bgStart = \App\Models\Setting::get('marquee_bg_start', '#2196F3');
    $bgEnd = \App\Models\Setting::get('marquee_bg_end', '#9C27B0');
    $speed = (int) \App\Models\Setting::get('marquee_speed', 25);
    $bold = \App\Models\Setting::get('marquee_bold', false);
    $json = \App\Models\Setting::get('marquee_texts');
    $items = $json ? json_decode($json, true) : [];
    if (!is_array($items)) $items = [];
    // فلترة الرسائل المفعلة فقط
    $items = array_filter($items, function($item) { return empty($item['enabled']) || $item['enabled']; });
@endphp
@if(count($items))
<div class="w-full py-1 overflow-hidden relative" style="background: linear-gradient(to left, {{ $bgStart }}, {{ $bgEnd }}); min-height: 36px;">
    <div class="whitespace-nowrap flex items-center animate-marquee-custom group-marquee text-sm md:text-base" style="color: {{ $color }}; font-weight: {{ $bold ? 'bold' : 'normal' }}; animation-duration: {{ $speed }}s; line-height: 1.7; min-height: 34px;" dir="ltr">
        @foreach($items as $item)
            @if(!empty($item['icon']))
                <span class="mx-1 text-base md:text-lg marquee-icon">{!! $item['icon'] !!}</span>
            @endif
            @if(!empty($item['url']))
                <a href="{{ $item['url'] }}" class="mx-2 md:mx-4 hover:underline marquee-link" target="_blank">{!! $item['text'] !!}</a>
            @else
                <span class="mx-2 md:mx-4 marquee-text">{!! $item['text'] !!}</span>
            @endif
            @if(!$loop->last)
                <span class="mx-1 text-base md:text-lg">|</span>
            @endif
        @endforeach
    </div>
</div>
<style>
@keyframes marquee-custom {
  0%   { transform: translateX(-100%); }
  100% { transform: translateX(100%); }
}
.animate-marquee-custom {
  animation-name: marquee-custom;
  animation-timing-function: linear;
  animation-iteration-count: infinite;
}
.animate-marquee-custom:hover {
  animation-play-state: paused;
}
</style>
@endif 