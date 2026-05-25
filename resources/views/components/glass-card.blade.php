@props(['hover' => false, 'glow' => false])

<div {{ $attributes->merge([
    'class' => 'bg-slate-900/60 backdrop-blur-xl border border-slate-800/80 rounded-2xl shadow-xl transition-all duration-300 ' . 
    ($hover ? 'hover:border-purple-500/30 hover:shadow-purple-500/5 hover:-translate-y-0.5 ' : '') .
    ($glow ? 'shadow-glow border-purple-500/20 ' : '')
]) }}>
    {{ $slot }}
</div>
