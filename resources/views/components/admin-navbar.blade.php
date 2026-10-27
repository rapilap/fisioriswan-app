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

<header class="relative z-50 w-full bg-(--bg-primary) text-(--text-primary) flex flex-col drop-shadow-md">
    <div
        class="flex items-center justify-between gap-3 w-full py-3 px-4 sm:px-6 lg:grow lg:py-4 lg:px-[max(1.5rem,calc((100%-72rem)/2))]">
        {{-- Logo --}}
        <a href="{{ route('admin.testimoni.index') }}" class="flex items-center gap-2.5">
            <span class="flex p-2 items-center justify-center rounded-lg bg-b1 text-white">
                @include('components.icon', ['name' => 'home', 'class' => 'w-[1em] h-[1em]'])
            </span>
            <span class="font-fraunces text-[20px] font-bold leading-none text-(--text-primary)">Ermaya Physio</span>
        </a>

        {{-- Menu --}}
        <nav aria-label="Menu admin" class="hidden lg:flex flex-wrap items-center gap-x-8 gap-y-2 xl:gap-x-10">
            @foreach ($menu as $item)
                @php $aktif = request()->routeIs($item['match'] ?? $item['route']); @endphp
                <a href="{{ route($item['route']) }}" @if ($aktif) aria-current="page" @endif
                    class="pb-0.5 text-[13px] font-medium transition-colors
                    {{ $aktif ? 'border-b-2 bg-(--bg-card) text-(--text-navselect) font-semibold' : 'text-(--text-navunhover) hover:bg-(--bg-card) hover:text-(--text-navselect)' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="hidden lg:flex items-center justify-center gap-4">
            <button type="button" data-theme-toggle id="desktop-theme-toggle" aria-label="Aktifkan dark mode"
                title="Ganti tema"
                class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-line/50 transition hover:bg-(--bg-card) focus:outline-none focus-visible:ring-2 focus-visible:ring-g1">
                <svg id="desktop-theme-moon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                    stroke-linejoin="round" aria-hidden="true">
                    <path d="M20.9 13A8.5 8.5 0 0 1 11 3.1 8.5 8.5 0 1 0 20.9 13Z" />
                </svg>
                <svg id="desktop-theme-sun" xmlns="http://www.w3.org/2000/svg" class="hidden h-5 w-5"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                    stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="12" r="4" />
                    <path
                        d="M12 2v2m0 16v2M4.93 4.93l1.42 1.42m11.3 11.3 1.42 1.42M2 12h2m16 0h2M4.93 19.07l1.42-1.42m11.3-11.3 1.42-1.42" />
                </svg>
            </button>

            {{-- Sign out --}}
            <form action="{{ route('admin.logout') }}" method="POST"
                class="inline-flex items-center rounded-full bg-b1 px-5 py-3 text-[14px] font-semibold uppercase leading-none text-white transition hover:opacity-90 cursor-pointer">
                @csrf
                <button type="submit" class="cursor-pointer">

                    Sign Out
                </button>
            </form>
        </div>

        <button type="button" id="mobile-menu-toggle"
            class="inline-flex lg:hidden items-center justify-center rounded-lg border border-line/50 p-2.5 transition hover:bg-(--bg-card) focus:outline-none focus-visible:ring-2 focus-visible:ring-g1"
            aria-controls="mobile-navigation" aria-expanded="false" aria-label="Buka menu navigasi">
            <svg id="mobile-menu-open-icon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                aria-hidden="true">
                <path d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg id="mobile-menu-close-icon" xmlns="http://www.w3.org/2000/svg" class="hidden h-6 w-6"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" aria-hidden="true">
                <path d="m18 6-12 12M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div id="mobile-navigation"
        class="hidden lg:hidden w-full border-t border-line/50 bg-(--bg-primary) px-4 pb-5 pt-3 sm:px-6" hidden>
        <div class="flex flex-col gap-1">
            @foreach ($menu as $item)
                @php $aktif = request()->routeIs($item['match'] ?? $item['route']); @endphp
                <a href="{{ route($item['route']) }}" @if ($aktif) aria-current="page" @endif
                    class="rounded-lg px-3 py-3 text-sm transition
                {{ $aktif ? 'bg-(--bg-card) text-(--text-navselect) font-semibold' : 'text-(--text-navunhover) hover:bg-(--bg-card) hover:text-(--text-navselect)' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </div>

        <div class="mt-4 flex flex-col gap-3 border-t border-line/50 pt-4">

            <form action="{{ route('admin.logout') }}" method="POST"
                class="inline-flex items-center rounded-full bg-b1 px-5 py-3 text-[14px] font-semibold uppercase leading-none text-white transition hover:opacity-90 cursor-pointer w-full text-center">
                @csrf
                <button type="submit" class="cursor-pointer w-full">

                    Sign Out
                </button>
            </form>

            <button type="button" id="mobile-theme-toggle" aria-label="Aktifkan dark mode" title="Ganti tema"
                class="flex w-full items-center justify-center rounded-lg border border-line/50 px-4 py-3 transition hover:bg-(--bg-card)">
                <svg id="mobile-theme-moon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                    stroke-linejoin="round" aria-hidden="true">
                    <path d="M20.9 13A8.5 8.5 0 0 1 11 3.1 8.5 8.5 0 1 0 20.9 13Z" />
                </svg>
                <svg id="mobile-theme-sun" xmlns="http://www.w3.org/2000/svg" class="hidden h-5 w-5" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                    stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="12" r="4" />
                    <path
                        d="M12 2v2m0 16v2M4.93 4.93l1.42 1.42m11.3 11.3 1.42 1.42M2 12h2m16 0h2M4.93 19.07l1.42-1.42m11.3-11.3 1.42-1.42" />
                </svg>
            </button>
        </div>
    </div>
</header>

<script>
    (() => {
        const toggle = document.getElementById('mobile-menu-toggle');
        const menu = document.getElementById('mobile-navigation');
        const openIcon = document.getElementById('mobile-menu-open-icon');
        const closeIcon = document.getElementById('mobile-menu-close-icon');
        const mobileThemeToggle = document.getElementById('mobile-theme-toggle');
        const desktopThemeToggle = document.getElementById('desktop-theme-toggle');
        const themeButtons = [desktopThemeToggle, mobileThemeToggle].filter(Boolean);
        const themeIcons = [
            document.getElementById('desktop-theme-moon'),
            document.getElementById('desktop-theme-sun'),
            document.getElementById('mobile-theme-moon'),
            document.getElementById('mobile-theme-sun'),
        ];

        const syncThemeIcons = () => {
            const isDark = document.documentElement.classList.contains('dark');

            document.getElementById('desktop-theme-moon')?.classList.toggle('hidden', isDark);
            document.getElementById('desktop-theme-sun')?.classList.toggle('hidden', !isDark);
            document.getElementById('mobile-theme-moon')?.classList.toggle('hidden', isDark);
            document.getElementById('mobile-theme-sun')?.classList.toggle('hidden', !isDark);

            themeButtons.forEach((button) => {
                button.setAttribute('aria-label', isDark ? 'Aktifkan light mode' :
                    'Aktifkan dark mode');
                button.setAttribute('title', isDark ? 'Beralih ke light mode' : 'Beralih ke dark mode');
            });
        };

        const themeObserver = new MutationObserver(syncThemeIcons);
        themeObserver.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['class'],
        });
        syncThemeIcons();

        if (!toggle || !menu) return;

        const setMenuOpen = (isOpen) => {
            menu.hidden = !isOpen;
            menu.classList.toggle('hidden', !isOpen);
            toggle.setAttribute('aria-expanded', String(isOpen));
            toggle.setAttribute('aria-label', isOpen ? 'Tutup menu navigasi' : 'Buka menu navigasi');
            openIcon?.classList.toggle('hidden', isOpen);
            closeIcon?.classList.toggle('hidden', !isOpen);
        };

        toggle.addEventListener('click', () => {
            setMenuOpen(toggle.getAttribute('aria-expanded') !== 'true');
        });

        // Reuse the existing theme-toggle handler so the mobile control works
        // even if app.js attaches its listener to the desktop button only.
        mobileThemeToggle?.addEventListener('click', () => desktopThemeToggle?.click());

        menu.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => setMenuOpen(false));
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') setMenuOpen(false);
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) setMenuOpen(false);
        });
    })();
</script>
