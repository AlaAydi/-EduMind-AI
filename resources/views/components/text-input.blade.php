@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge([
    'class' => 'bg-slate-950/80 border-slate-800 text-slate-200 placeholder-slate-600 focus:border-purple-500 focus:ring-purple-500/30 rounded-xl shadow-sm transition-all duration-300 w-full'
]) }}>
