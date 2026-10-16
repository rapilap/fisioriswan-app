{{-- Bingkai foto dengan placeholder. Taruh file gambar di public/{{ $src }}
     Opsi: icon, caption, class (ukuran), radius, iconClass,
           load => true (animasi saat halaman dimuat), delay => ms, reveal => false --}}
@php
    $anim = ($load ?? false) ? 'load-in' : (($reveal ?? true) ? 'reveal' : '');
@endphp
<div class="{{ $anim }} relative overflow-hidden {{ $radius ?? 'rounded-3xl' }} border border-line bg-linear-to-br from-photo-from to-photo-to {{ $class ?? '' }}"
    title="Letakkan foto di public/{{ $src }}"
    @if ($load ?? false) style="--load-delay: {{ $delay ?? 0 }}ms" @endif>
    <div class="absolute inset-0 flex items-center justify-center text-g3">
        @include('components.icon', [
            'name' => $icon ?? 'image',
            'class' => $iconClass ?? 'w-16 h-16',
            'stroke' => 1.5,
        ])
    </div>
    <span class="absolute left-4 bottom-4 text-[12px] font-medium text-g3">{{ $caption ?? $alt }}</span>
    <img src="{{ asset($src) }}" alt="{{ $alt }}" loading="lazy" onerror="this.remove()"
        class="absolute inset-0 w-full h-full object-cover">
</div>
