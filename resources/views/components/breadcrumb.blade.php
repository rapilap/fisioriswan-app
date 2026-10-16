<nav aria-label="Breadcrumb" class="flex flex-wrap items-center gap-2 text-[14px] text-b4">
    <a href="{{ route('beranda') }}" class="transition hover:text-b1">
        Beranda
    </a>
    @include('components.icon', ['name' => 'chevron-right', 'class' => 'w-3.5 h-3.5'])

    @if (request()->routeIs('layanan'))
        <span>Layanan Kami</span>
    @elseif (request()->routeIs('event'))
        <span>Event & Kolaborasi</span>
    @elseif (request()->routeIs('testimoni'))
        <span>Testimoni</span>
    @elseif (request()->routeIs('inputTestimoni'))
        <a href="{{ route('testimoni') }}" class="transition hover:text-b1">Testimoni</a>
        @include('components.icon', ['name' => 'chevron-right', 'class' => 'w-3.5 h-3.5'])
        <span>Input Testimoni</span>
    @endif
</nav>
