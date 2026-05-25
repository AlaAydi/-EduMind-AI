<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'EduMind AI - Premium AI E-Learning' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- ApexCharts for modern charts -->
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#05030a] text-slate-100 min-h-screen overflow-x-hidden">
        <!-- Glowing Orbits in Background -->
        <div class="fixed top-[-10%] left-[-10%] w-[50%] h-[50%] rounded-full bg-indigo-900/15 blur-[120px] pointer-events-none z-0"></div>
        <div class="fixed bottom-[-10%] right-[-10%] w-[50%] h-[50%] rounded-full bg-purple-900/15 blur-[120px] pointer-events-none z-0"></div>
        <div class="fixed top-[40%] right-[20%] w-[30%] h-[30%] rounded-full bg-pink-900/10 blur-[100px] pointer-events-none z-0"></div>

        <div class="relative z-10 min-h-screen flex">
            <!-- Sidebar -->
            <x-sidebar />

            <!-- Main Content Area -->
            <div class="flex-1 pl-64 flex flex-col min-h-screen">
                <!-- Top Navbar -->
                <x-navbar :title="$title ?? 'Dashboard'" />

                <!-- Page Content -->
                <main class="flex-1 p-6 lg:p-8">
                    @if (session('success'))
                        <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-xl flex items-center justify-between shadow-glow">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-sm font-semibold">{{ session('success') }}</span>
                            </div>
                            <button @click="show = false" class="text-emerald-400 hover:text-emerald-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 p-4 bg-rose-500/10 border border-rose-500/20 text-rose-400 rounded-xl flex items-center justify-between shadow-glow">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <span class="text-sm font-semibold">{{ session('error') }}</span>
                            </div>
                            <button @click="show = false" class="text-rose-400 hover:text-rose-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    @endif

                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
