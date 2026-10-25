<span
    {{ $attributes->merge([
        'class' => 'inline-block items-center justify-center rounded-full
                                    bg-[var(--color-pill)] px-3 py-2 leading-3.25
                                    text-[var(--color-g2)] font-semibold text-[12px]',
    ]) }}>
    {{ $slot }}
</span>
