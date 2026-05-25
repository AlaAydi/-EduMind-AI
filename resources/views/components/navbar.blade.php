@props(['title' => 'Dashboard'])

<header class="h-16 bg-slate-950/40 border-b border-slate-900/60 backdrop-blur-md sticky top-0 z-30 px-6 flex items-center justify-between">
    <!-- Search Bar / Dynamic Title -->
    <div class="flex items-center gap-6">
        <h1 class="text-lg font-bold text-white tracking-tight">{{ $title }}</h1>
        <div class="hidden md:flex items-center gap-2 px-3 py-1.5 bg-slate-900/60 border border-slate-800 rounded-xl w-64 focus-within:border-purple-500/50 transition-all duration-300">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" placeholder="Search courses, files, AI..." class="bg-transparent border-none text-xs text-slate-300 focus:outline-none focus:ring-0 p-0 w-full placeholder-slate-600">
        </div>
    </div>

    <!-- Actions & Profile -->
    <div class="flex items-center gap-4">
        
        <!-- Demo Role Switcher Button -->
        <form action="{{ route('demo.switch-role') }}" method="POST" class="m-0 p-0">
            @csrf
            <button type="submit" class="flex items-center gap-2 px-3 py-1.5 rounded-xl border border-purple-500/30 bg-purple-500/10 text-purple-300 text-xs font-bold hover:bg-purple-500/20 hover:text-white transition-all shadow-glow duration-300">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                </svg>
                Switch to {{ auth()->user()->isTeacher() ? 'Student' : 'Teacher' }}
            </button>
        </form>

        <!-- Notifications Dropdown -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="p-2 bg-slate-900/60 border border-slate-850 hover:border-slate-800 rounded-xl text-slate-400 hover:text-slate-200 transition-all relative">
                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.003 6.003 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span class="absolute top-1.5 right-1.5 w-1.5 h-1.5 rounded-full bg-purple-500 ring-2 ring-slate-900"></span>
            </button>

            <!-- Dropdown Content -->
            <div x-show="open" @click.outside="open = false" x-transition class="absolute right-0 mt-2 w-80 bg-slate-900/95 border border-slate-800 rounded-2xl shadow-2xl p-4 backdrop-blur-xl z-50" style="display: none;">
                <div class="flex items-center justify-between border-b border-slate-800 pb-2 mb-3">
                    <h3 class="text-xs font-extrabold text-slate-200 uppercase tracking-wider">Notifications</h3>
                    <span class="text-[10px] text-purple-400 font-bold hover:underline cursor-pointer">Clear All</span>
                </div>
                <div class="space-y-3">
                    <div class="flex gap-3 items-start border-b border-slate-850 pb-2">
                        <div class="w-2 h-2 mt-1.5 rounded-full bg-purple-500 flex-shrink-0"></div>
                        <div>
                            <p class="text-xs font-semibold text-slate-200 leading-tight">AI recommendation ready</p>
                            <p class="text-[10px] text-slate-500 mt-0.5">EduMind AI has analyzed your progression and recommended 2 new modules.</p>
                        </div>
                    </div>
                    <div class="flex gap-3 items-start border-b border-slate-850 pb-2">
                        <div class="w-2 h-2 mt-1.5 rounded-full bg-blue-500 flex-shrink-0"></div>
                        <div>
                            <p class="text-xs font-semibold text-slate-200 leading-tight">Database Visualization Quiz Passed!</p>
                            <p class="text-[10px] text-slate-500 mt-0.5">Congratulations, you scored 100% and unlocked the "Analytics Pioneer" badge.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Cog -->
        <a href="{{ route('profile.edit') }}" class="p-2 bg-slate-900/60 border border-slate-850 hover:border-slate-800 rounded-xl text-slate-400 hover:text-slate-200 transition-all">
            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </a>

    </div>
</header>
