document.documentElement.classList.add('js');

// Animasi muncul saat elemen .reveal masuk ke layar (dari atas maupun bawah),
// dan di-reset saat keluar layar agar teranimasi lagi setiap kali di-scroll.
const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        entry.target.classList.toggle('is-visible', entry.isIntersecting);
    });
}, { threshold: 0.15 });

document.querySelectorAll('.reveal').forEach((el) => revealObserver.observe(el));

// Slider: [data-slider] > [data-slider-track] > [data-slide]
document.querySelectorAll('[data-slider]').forEach((slider) => {
    const track = slider.querySelector('[data-slider-track]');
    const slides = [...track.querySelectorAll('[data-slide]')];
    const prev = slider.querySelector('[data-slider-prev]');
    const next = slider.querySelector('[data-slider-next]');
    const dotsWrap = slider.querySelector('[data-slider-dots]');
    if (!slides.length) return;

    const step = () => slides[0].offsetWidth + parseFloat(getComputedStyle(track).columnGap || 0);
    const visibleCount = () => Math.max(1, Math.round(track.clientWidth / step()));
    const pageCount = () => slides.length - visibleCount() + 1;
    const currentIndex = () => Math.round(track.scrollLeft / step());
    const goTo = (i) => track.scrollTo({ left: i * step(), behavior: 'smooth' });

    let dots = [];
    const buildDots = () => {
        dotsWrap.innerHTML = '';
        dots = Array.from({ length: pageCount() }, (_, i) => {
            const dot = document.createElement('button');
            dot.type = 'button';
            dot.setAttribute('aria-label', `Slide ${i + 1}`);
            dot.className = 'h-2 rounded-full transition-all duration-300';
            dot.addEventListener('click', () => goTo(i));
            dotsWrap.appendChild(dot);
            return dot;
        });
        dotsWrap.hidden = dots.length <= 1;
    };

    const update = () => {
        const i = currentIndex();
        const last = pageCount() - 1;
        dots.forEach((dot, d) => {
            dot.classList.toggle('w-6', d === i);
            dot.classList.toggle('bg-b1', d === i);
            dot.classList.toggle('w-2', d !== i);
            dot.classList.toggle('bg-b5', d !== i);
        });
        if (prev) prev.disabled = i <= 0;
        if (next) next.disabled = i >= last;
    };

    prev?.addEventListener('click', () => goTo(Math.max(0, currentIndex() - 1)));
    next?.addEventListener('click', () => goTo(Math.min(pageCount() - 1, currentIndex() + 1)));
    track.addEventListener('scroll', () => requestAnimationFrame(update), { passive: true });
    window.addEventListener('resize', () => { buildDots(); update(); });

    // Geser dengan mouse (sentuh sudah ditangani browser)
    let startX = 0, startScroll = 0, dragging = false, moved = false;
    track.addEventListener('pointerdown', (e) => {
        if (e.pointerType !== 'mouse') return;
        dragging = true;
        moved = false;
        startX = e.clientX;
        startScroll = track.scrollLeft;
        track.classList.add('is-dragging');
    });
    window.addEventListener('pointermove', (e) => {
        if (!dragging) return;
        const dx = e.clientX - startX;
        if (Math.abs(dx) > 5) moved = true;
        track.scrollLeft = startScroll - dx;
    });
    window.addEventListener('pointerup', () => {
        if (!dragging) return;
        dragging = false;
        track.classList.remove('is-dragging');
        goTo(currentIndex());
    });
    // Jangan ikuti link kalau user sedang menggeser
    track.addEventListener('click', (e) => {
        if (moved) {
            e.preventDefault();
            moved = false;
        }
    }, true);
    track.addEventListener('dragstart', (e) => e.preventDefault());

    buildDots();
    update();
});
