@props(['fullName' => 'User', 'city' => '', 'image' => null, 'testimonial' => null])

<article {{ $attributes->class(['flex h-[355px] w-[331px] flex-col rounded-xl bg-white p-7 sm:p-6']) }}>

    {{-- Profil user --}}
    <div class="flex items-center gap-3">

        {{-- Foto atau inisial nama --}}
        @if ($image)
            <img src="{{ $image }}" alt="Foto {{ $fullName }}"
                class="h-12 w-12 shrink-0 rounded-full object-cover">
        @else
            <x-pill-icon>
                {{ mb_strtoupper(mb_substr(trim($fullName), 0, 1)) }}
            </x-pill-icon>
        @endif

        {{-- Nama dan kota --}}
        <div class="min-w-0">
            <h3 class="truncate font-semibold text-gray-900">
                {{ $fullName }}
            </h3>

            <p class="text-sm text-gray-500">
                {{ $city }}
            </p>
        </div>
    </div>

    {{-- Rating bintang --}}
    <div class="mt-4 flex gap-1 text-lg leading-none text-g1" aria-label="5 dari 5 bintang">
        @for ($i = 0; $i < 5; $i++)
            <span aria-hidden="true">★</span>
        @endfor
    </div>

    {{-- Isi testimoni --}}
    <p class="my-5 text-md leading-relaxed text-secondary">
        “{{ $testimonial }}”
    </p>

</article>
