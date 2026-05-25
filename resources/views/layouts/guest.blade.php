<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'EduMind AI') }} - Portal</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#05030a] text-slate-100 min-h-screen overflow-x-hidden flex flex-col justify-center items-center py-6 px-4">
        <!-- Glowing Orbits in Background -->
        <div class="fixed top-[-10%] left-[-10%] w-[50%] h-[50%] rounded-full bg-indigo-900/20 blur-[120px] pointer-events-none z-0"></div>
        <div class="fixed bottom-[-10%] right-[-10%] w-[50%] h-[50%] rounded-full bg-purple-900/20 blur-[120px] pointer-events-none z-0"></div>

        <div class="relative z-10 w-full max-w-md flex flex-col items-center">
            <!-- Logo Section -->
            <div class="mb-8 flex flex-col items-center">
                <a href="/" class="flex flex-col items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center shadow-lg shadow-purple-500/40 animate-pulse">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <div class="text-center">
                        <span class="text-2xl font-black bg-gradient-to-r from-white via-slate-200 to-purple-400 bg-clip-text text-transparent tracking-wide">EduMind AI</span>
                        <span class="block text-[11px] text-purple-400/80 font-bold uppercase tracking-widest mt-0.5">E-Learning Portal</span>
                    </div>
                </a>
            </div>

            <!-- Content Card -->
            <div class="w-full bg-slate-900/60 backdrop-blur-xl border border-slate-800 rounded-3xl p-8 shadow-glow shadow-purple-500/5">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
