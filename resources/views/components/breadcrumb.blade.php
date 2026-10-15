<a href="{{ route('beranda') }}" class="text-gray-500 mx-2">
    Beranda
</a>
<span class="text-gray-500">></span>

@if (request()->routeIs('layanan'))
    <span class="mx-2 text-gray-500">Layanan Kami</span>
@elseif (request()->routeIs('event'))
    <span class="mx-2 text-gray-500">Event & Kolaborasi</span>
@elseif (request()->routeIs('testimoni'))
    <span class="mx-2 text-gray-500">Testimoni</span>
@elseif (request()->routeIs('inputTestimoni'))
    <span class="mx-2 text-gray-500">Input Testimoni</span>
@endif
