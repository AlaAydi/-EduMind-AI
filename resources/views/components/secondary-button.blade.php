<button {{ $attributes->merge([
    'type' => 'button', 
    'class' => 'inline-flex items-center justify-center px-5 py-2.5 bg-slate-900 border border-slate-800 rounded-xl font-bold text-xs text-slate-350 uppercase tracking-wider hover:bg-slate-800 hover:text-white active:translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-slate-900 transition-all duration-150'
]) }}>
    {{ $slot }}
</button>
