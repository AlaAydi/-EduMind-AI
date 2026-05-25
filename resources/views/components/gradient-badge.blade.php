@props(['type' => 'purple'])

@php
    $classes = match($type) {
        'purple' => 'bg-purple-500/10 text-purple-400 border-purple-500/20 shadow-purple-500/5',
        'blue' => 'bg-blue-500/10 text-blue-400 border-blue-500/20 shadow-blue-500/5',
        'emerald' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20 shadow-emerald-500/5',
        'rose' => 'bg-rose-500/10 text-rose-400 border-rose-500/20 shadow-rose-500/5',
        'amber' => 'bg-amber-500/10 text-amber-400 border-amber-500/20 shadow-amber-500/5',
        default => 'bg-slate-500/10 text-slate-400 border-slate-500/20',
    };
@endphp

<span {{ $attributes->merge([
    'class' => 'px-3 py-1 text-xs font-semibold rounded-full border shadow-sm transition-all duration-300 ' . $classes
]) }}>
    {{ $slot }}
</span>
