{{-- Navbar khusus admin. Dipakai oleh layouts/admin.blade.php --}}
@php
    // 'match' = pola route yang menandai menu aktif (default: route itu sendiri)
    $menu = [
        ['label' => 'Daftar Testimoni', 'route' => 'admin.testimoni.index'],
        ['label' => 'Testimoni Pending', 'route' => 'admin.testimoni.pending'],
        ['label' => 'Event', 'route' => 'admin.event.index', 'match' => 'admin.event.*'],
        ['label' => 'Sorotan Event', 'route' => 'admin.sorotan.index', 'match' => 'admin.sorotan.*'],
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
        <nav aria-label="Menu admin" class="flex flex-wrap items-center gap-x-8 gap-y-2 lg:ml-16 xl:gap-x-10">
            @foreach ($menu as $item)
                @php $aktif = request()->routeIs($item['match'] ?? $item['route']); @endphp
                <a href="{{ route($item['route']) }}" @if ($aktif) aria-current="page" @endif
                    class="border-b-2 pb-0.5 text-[15px] font-medium transition-colors
                    {{ $aktif ? 'border-g1 text-b1' : 'border-transparent text-b4 hover:text-b1' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        {{-- Sign out --}}
        {{-- TODO: ganti dengan form POST logout saat autentikasi admin sudah ada --}}
        <form action="{{ route('admin.logout') }}" method="POST"
            class="ml-auto inline-flex items-center rounded-full bg-b1 px-5 py-3 text-[14px] font-semibold uppercase leading-none text-white transition hover:opacity-90 cursor-pointer">
            @csrf
            <button type="submit" class="cursor-pointer">

                Sign Out
            </button>
        </form>
    </div>
</header>
