@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-3 border-l-4 border-red-500 text-start text-base font-black uppercase tracking-widest text-red-500 bg-red-500/10 focus:outline-none focus:text-red-400 focus:bg-red-500/20 focus:border-red-400 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-3 border-l-4 border-transparent text-start text-base font-bold uppercase tracking-widest text-slate-400 hover:text-white hover:bg-slate-800 hover:border-slate-600 focus:outline-none focus:text-white focus:bg-slate-800 focus:border-slate-600 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
