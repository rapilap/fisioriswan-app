{{-- Bintang rating (1–5). Pemakaian: <x-rating-stars :rating="$item->rating" size="w-4 h-4" class="mt-3" /> --}}
@props(['rating' => 5, 'size' => 'w-3.5 h-3.5'])

@php $rating = max(0, min(5, (int) $rating)); @endphp

<div {{ $attributes->class(['flex gap-1']) }} role="img" aria-label="{{ $rating }} dari 5 bintang">
    @for ($i = 1; $i <= 5; $i++)
        <span class="{{ $i <= $rating ? 'text-g1' : 'text-line' }}">
            @include('components.icon', ['name' => 'star', 'fill' => 'currentColor', 'stroke' => 1, 'class' => $size])
        </span>
    @endfor
</div>
