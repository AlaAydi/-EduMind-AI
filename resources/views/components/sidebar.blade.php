<div class="fixed top-0 bottom-0 left-0 z-40 w-64 bg-slate-950/80 border-r border-slate-900/80 backdrop-blur-xl flex flex-col justify-between py-6">
    <div>
        <!-- Logo -->
        <div class="px-6 mb-8">
            <a href="/" class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center shadow-lg shadow-purple-500/30 animate-pulse">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <div>
                    <span class="text-lg font-extrabold bg-gradient-to-r from-white via-slate-200 to-purple-400 bg-clip-text text-transparent tracking-wide">EduMind AI</span>
                    <span class="block text-[10px] text-purple-400/80 font-bold uppercase tracking-widest mt-[-2px]">E-Learning Portal</span>
                </div>
            </a>
        </div>

        <!-- Navigation Menu -->
        <nav class="space-y-1.5 px-4">
            <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-3 mb-2">Main Menu</div>

            @if (auth()->user()->isTeacher())
                <!-- Teacher Links -->
                <a href="{{ route('dashboard') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-purple-500/10 to-indigo-500/10 text-purple-400 border-l-2 border-purple-500 shadow-glow' : 'text-slate-400 hover:bg-slate-900/60 hover:text-slate-200' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/>
                        </svg>
                        Teacher Dashboard
                    </div>
                </a>

                <a href="{{ route('courses.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('courses.*') ? 'bg-gradient-to-r from-purple-500/10 to-indigo-500/10 text-purple-400 border-l-2 border-purple-500 shadow-glow' : 'text-slate-400 hover:bg-slate-900/60 hover:text-slate-200' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Manage Courses
                    </div>
                    <span class="px-2 py-0.5 text-[10px] font-bold bg-purple-500/10 text-purple-400 border border-purple-500/20 rounded-full">HQ</span>
                </a>

                <a href="{{ route('quizzes.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('quizzes.*') ? 'bg-gradient-to-r from-purple-500/10 to-indigo-500/10 text-purple-400 border-l-2 border-purple-500 shadow-glow' : 'text-slate-400 hover:bg-slate-900/60 hover:text-slate-200' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16.01H9"/>
                        </svg>
                        Manage Quizzes
                    </div>
                </a>

                <a href="{{ route('analytics') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('analytics') ? 'bg-gradient-to-r from-purple-500/10 to-indigo-500/10 text-purple-400 border-l-2 border-purple-500 shadow-glow' : 'text-slate-400 hover:bg-slate-900/60 hover:text-slate-200' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2"/>
                        </svg>
                        Analytics
                    </div>
                </a>
            @else
                <!-- Student Links -->
                <a href="{{ route('dashboard') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-purple-500/10 to-indigo-500/10 text-purple-400 border-l-2 border-purple-500 shadow-glow' : 'text-slate-400 hover:bg-slate-900/60 hover:text-slate-200' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard
                    </div>
                </a>

                <a href="{{ route('courses.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('courses.*') ? 'bg-gradient-to-r from-purple-500/10 to-indigo-500/10 text-purple-400 border-l-2 border-purple-500 shadow-glow' : 'text-slate-400 hover:bg-slate-900/60 hover:text-slate-200' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Browse Courses
                    </div>
                </a>

                <a href="{{ route('quizzes.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('quizzes.*') ? 'bg-gradient-to-r from-purple-500/10 to-indigo-500/10 text-purple-400 border-l-2 border-purple-500 shadow-glow' : 'text-slate-400 hover:bg-slate-900/60 hover:text-slate-200' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16.01H9"/>
                        </svg>
                        Quizzes & Exams
                    </div>
                </a>

                <a href="{{ route('ai-chatbot') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('ai-chatbot') ? 'bg-gradient-to-r from-purple-500/10 to-indigo-500/10 text-purple-400 border-l-2 border-purple-500 shadow-glow' : 'text-slate-400 hover:bg-slate-900/60 hover:text-slate-200' }}">
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                            <span class="absolute top-0 right-0 w-2 h-2 rounded-full bg-purple-500 animate-ping"></span>
                        </div>
                        EduMind AI Tutor
                    </div>
                    <span class="px-2 py-0.5 text-[9px] font-extrabold bg-gradient-to-r from-purple-500 to-indigo-500 text-white rounded-full uppercase tracking-wider scale-90">AI</span>
                </a>

                <a href="{{ route('progression') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('progression') ? 'bg-gradient-to-r from-purple-500/10 to-indigo-500/10 text-purple-400 border-l-2 border-purple-500 shadow-glow' : 'text-slate-400 hover:bg-slate-900/60 hover:text-slate-200' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Progression & XP
                    </div>
                </a>

                <a href="{{ route('analytics') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 {{ request()->routeIs('analytics') ? 'bg-gradient-to-r from-purple-500/10 to-indigo-500/10 text-purple-400 border-l-2 border-purple-500 shadow-glow' : 'text-slate-400 hover:bg-slate-900/60 hover:text-slate-200' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2"/>
                        </svg>
                        Analytics
                    </div>
                </a>
            @endif
        </nav>
    </div>

    <!-- User Section -->
    <div class="px-4">
        <div class="p-3 bg-slate-900/60 border border-slate-800 rounded-2xl flex items-center justify-between gap-3 shadow-inner">
            <div class="flex items-center gap-3 overflow-hidden">
                <img class="w-9 h-9 rounded-xl border border-purple-500/30 object-cover flex-shrink-0" src="{{ auth()->user()->avatar ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=100&q=80' }}" alt="Avatar">
                <div class="truncate leading-none">
                    <span class="text-xs font-bold text-slate-200 block truncate">{{ auth()->user()->name }}</span>
                    <span class="text-[9px] text-purple-400/80 font-bold uppercase tracking-wider block mt-1">{{ auth()->user()->role }}</span>
                </div>
            </div>
            
            <form method="POST" action="{{ route('logout') }}" class="flex-shrink-0 m-0 p-0">
                @csrf
                <button type="submit" class="p-1.5 rounded-lg text-slate-500 hover:bg-slate-800 hover:text-rose-400 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>
