<button {{ $attributes->merge([
    'type' => 'submit', 
    'class' => 'inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-purple-500 to-indigo-500 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-wider hover:from-purple-650 hover:to-indigo-650 hover:shadow-glow hover:shadow-purple-500/20 active:translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-slate-900 transition-all duration-150'
]) }}>
    {{ $slot }}
</button>
