<span
    {{ $attributes->merge([
        'class' => 'inline-flex items-center justify-center rounded-full
                            bg-[var(--color-pill)] px-[12px] py-[5px]
                            text-[var(--color-g1)] font-semibold text-[12.5px]',
    ]) }}>
    {{ $slot }}
</span>
