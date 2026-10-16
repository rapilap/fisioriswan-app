@if ($paginator->hasPages())
    @php
        $bulat = 'flex h-10 w-10 items-center justify-center rounded-full border text-[14px] font-semibold transition';
    @endphp
    <nav role="navigation" aria-label="Paginasi" class="mt-12 flex items-center justify-center gap-2">
        @unless ($paginator->onFirstPage())
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Halaman sebelumnya"
                class="{{ $bulat }} border-line text-secondary hover:border-b1 hover:text-b1">
                @include('components.icon', ['name' => 'chevron-left', 'class' => 'w-4 h-4'])
            </a>
        @endunless

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-1 text-secondary">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page" class="{{ $bulat }} border-b1 bg-b1 text-white">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" aria-label="Ke halaman {{ $page }}"
                            class="{{ $bulat }} border-line text-secondary hover:border-b1 hover:text-b1">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Halaman berikutnya"
                class="{{ $bulat }} border-line text-secondary hover:border-b1 hover:text-b1">
                @include('components.icon', ['name' => 'chevron-right', 'class' => 'w-4 h-4'])
            </a>
        @endif
    </nav>
@endif
