{{-- Navbar khusus admin. Dipakai oleh layouts/admin.blade.php --}}
@php
    $menu = [
        ['label' => 'Daftar Testimoni', 'route' => 'admin.testimoni.index'],
        ['label' => 'Testimoni Pending', 'route' => 'admin.testimoni.pending'],
    ];
@endphp

<header class="bg-sage shadow-md">
    <div class="mx-auto flex min-h-[83px] max-w-6xl flex-wrap items-center gap-x-6 gap-y-3 px-6 py-3">
        {{-- Logo --}}
        <a href="{{ route('admin.testimoni.index') }}" class="flex items-center gap-2.5">
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-b1 text-white">
                @include('components.icon', ['name' => 'home', 'class' => 'w-[18px] h-[18px]'])
            </span>
            <span class="font-fraunces text-[32px] font-bold leading-none text-primary">Pulihkan</span>
        </a>

        {{-- Menu --}}
        <nav aria-label="Menu admin" class="flex items-center gap-12 lg:ml-44">
            @foreach ($menu as $item)
                @php $aktif = request()->routeIs($item['route']); @endphp
                <a href="{{ route($item['route']) }}" @if ($aktif) aria-current="page" @endif
                    class="border-b-2 pb-0.5 text-[15px] font-medium transition-colors
                    {{ $aktif ? 'border-g1 text-b1' : 'border-transparent text-b4 hover:text-b1' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        {{-- Sign out --}}
        {{-- TODO: ganti dengan form POST logout saat autentikasi admin sudah ada --}}
        <a href="{{ route('beranda') }}"
            class="ml-auto inline-flex items-center rounded-full bg-b1 px-5 py-3 text-[14px] font-semibold uppercase leading-none text-white transition hover:opacity-90">
            Sign Out
        </a>
    </div>
</header>
