<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>EduMind AI - The Future of Intelligent E-Learning</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#05030a] text-slate-100 min-h-screen overflow-x-hidden">
        
        <!-- Background Glowing Circles -->
        <div class="absolute top-[-20%] left-[-20%] w-[60%] h-[60%] rounded-full bg-indigo-900/20 blur-[130px] pointer-events-none z-0"></div>
        <div class="absolute top-[30%] right-[-10%] w-[50%] h-[50%] rounded-full bg-purple-900/15 blur-[120px] pointer-events-none z-0"></div>
        <div class="absolute bottom-[-10%] left-[10%] w-[50%] h-[50%] rounded-full bg-pink-900/10 blur-[110px] pointer-events-none z-0"></div>

        <!-- Navigation -->
        <header class="relative z-10 max-w-7xl mx-auto px-6 py-6 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center shadow-lg shadow-purple-500/30">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <div>
                    <span class="text-xl font-black bg-gradient-to-r from-white via-slate-200 to-purple-400 bg-clip-text text-transparent tracking-wide">EduMind AI</span>
                    <span class="block text-[10px] text-purple-400 font-bold uppercase tracking-widest mt-[-2px]">Intelligence E-Learning</span>
                </div>
            </a>

            <!-- Nav Links -->
            <nav class="hidden md:flex items-center gap-8">
                <a href="#features" class="text-sm font-semibold text-slate-400 hover:text-white transition-colors">Features</a>
                <a href="#courses" class="text-sm font-semibold text-slate-400 hover:text-white transition-colors">Featured Courses</a>
                <a href="#pricing" class="text-sm font-semibold text-slate-400 hover:text-white transition-colors">Pricing</a>
                <a href="#about" class="text-sm font-semibold text-slate-400 hover:text-white transition-colors">About AI</a>
            </nav>

            <!-- Auth Buttons -->
            <div class="flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold text-sm hover:shadow-glow hover:shadow-purple-500/20 hover:-translate-y-0.5 transition-all duration-300">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-slate-300 hover:text-white transition-colors">Log In</a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl bg-white text-slate-950 font-bold text-sm hover:bg-slate-200 hover:-translate-y-0.5 transition-all duration-300">
                            Sign Up
                        </a>
                    @endauth
                @endif
            </div>
        </header>

        <!-- Hero Section -->
        <section class="relative z-10 max-w-7xl mx-auto px-6 pt-16 pb-20 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
            <div class="lg:col-span-7 space-y-8">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-purple-500/10 border border-purple-500/20 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-purple-400 animate-ping"></span>
                    <span class="text-xs font-bold text-purple-400 uppercase tracking-widest">Version 2.0 is Live</span>
                </div>
                
                <h1 class="text-5xl lg:text-7xl font-black tracking-tight leading-[1.05] text-white">
                    Unlock Your Mind <br>
                    With <span class="bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">Neural Learning</span>
                </h1>

                <p class="text-lg text-slate-400 max-w-xl leading-relaxed">
                    Welcome to EduMind AI. A premium e-learning platform embedding real-time AI tutors, gamified progression systems, and interactive dashboards. Created for modern developers, designers, and innovators.
                </p>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('register') }}" class="px-8 py-4 rounded-2xl bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-extrabold text-base shadow-glow shadow-purple-500/30 hover:shadow-purple-500/40 hover:-translate-y-1 transition-all duration-300 text-center">
                        Start Learning Free
                    </a>
                    <a href="#courses" class="px-8 py-4 rounded-2xl border border-slate-800 bg-slate-900/40 text-slate-300 font-bold text-base hover:bg-slate-900 hover:text-white hover:-translate-y-1 transition-all duration-300 text-center">
                        Explore Courses
                    </a>
                </div>

                <!-- Trust Stats -->
                <div class="pt-8 border-t border-slate-900/60 grid grid-cols-3 gap-6">
                    <div>
                        <span class="block text-3xl font-extrabold text-white">18k+</span>
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider mt-1 block">Active Users</span>
                    </div>
                    <div>
                        <span class="block text-3xl font-extrabold text-white">96%</span>
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider mt-1 block">Completion Rate</span>
                    </div>
                    <div>
                        <span class="block text-3xl font-extrabold text-white">4.9/5</span>
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider mt-1 block">Satisfaction</span>
                    </div>
                </div>
            </div>

            <!-- Hero Graphics (Glassmorphic Mockup) -->
            <div class="lg:col-span-5 relative">
                <!-- Outer floating glow -->
                <div class="absolute inset-0 bg-gradient-to-tr from-purple-500/20 to-indigo-500/10 rounded-3xl blur-2xl z-0 scale-95 animate-pulse"></div>

                <!-- The Dashboard Mockup -->
                <div class="relative z-10 bg-slate-900/60 border border-slate-800 rounded-3xl p-6 shadow-2xl backdrop-blur-xl">
                    <div class="flex items-center justify-between border-b border-slate-800/80 pb-4 mb-6">
                        <div class="flex gap-2">
                            <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                            <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                            <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                        </div>
                        <span class="text-[10px] font-extrabold text-purple-400 bg-purple-500/10 border border-purple-500/20 px-3 py-0.5 rounded-full uppercase tracking-wider">AI RECOMMENDATIONS</span>
                    </div>

                    <!-- AI Chat Mockup -->
                    <div class="space-y-4">
                        <div class="p-4 bg-slate-950/80 border border-slate-900 rounded-2xl">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-5 h-5 rounded bg-purple-500 flex items-center justify-center text-[10px] font-bold text-white uppercase">AI</div>
                                <span class="text-xs font-extrabold text-slate-300">EduMind AI Tutor</span>
                            </div>
                            <p class="text-[11px] text-slate-400 leading-relaxed">
                                "Based on your 85% score in the prompt structure quiz, I recommend studying <span class="text-purple-400 font-semibold">Chained Logic Nodes</span>. This will improve context engineering skills by 24%."
                            </p>
                        </div>

                        <!-- Progress Bar Mockup -->
                        <div class="p-4 bg-slate-950/40 border border-slate-900 rounded-2xl">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-xs font-bold text-slate-300">Course Progress</span>
                                <span class="text-xs font-bold text-indigo-400">76% Completed</span>
                            </div>
                            <div class="w-full h-2 bg-slate-900 rounded-full overflow-hidden">
                                <div class="w-[76%] h-full bg-gradient-to-r from-purple-500 to-indigo-500 rounded-full shadow-glow"></div>
                            </div>
                        </div>

                        <!-- Interactive Chart Wireframe -->
                        <div class="p-4 bg-slate-950/40 border border-slate-900 rounded-2xl">
                            <span class="text-xs font-bold text-slate-300 block mb-3">Weekly Study Velocity</span>
                            <div class="flex items-end gap-3 h-20 pt-4">
                                <div class="flex-1 bg-slate-900 hover:bg-purple-500/40 h-[40%] rounded-t-md transition-all duration-300"></div>
                                <div class="flex-1 bg-slate-900 hover:bg-purple-500/40 h-[65%] rounded-t-md transition-all duration-300"></div>
                                <div class="flex-1 bg-gradient-to-t from-indigo-500 to-purple-500 h-[90%] rounded-t-md shadow-glow"></div>
                                <div class="flex-1 bg-slate-900 hover:bg-purple-500/40 h-[50%] rounded-t-md transition-all duration-300"></div>
                                <div class="flex-1 bg-slate-900 hover:bg-purple-500/40 h-[80%] rounded-t-md transition-all duration-300"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Floating decorations -->
                <div class="absolute bottom-[-20px] left-[-30px] z-20 bg-slate-900/80 border border-slate-800 px-4 py-3 rounded-2xl shadow-xl backdrop-blur-md flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="block text-[11px] font-extrabold text-slate-200">Alex Rivers</span>
                        <span class="text-[9px] text-slate-500 block leading-tight">Unlocked Cert: LLM Pioneer</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="relative z-10 max-w-7xl mx-auto px-6 py-24 border-t border-slate-950">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-4">
                <span class="text-xs font-bold text-purple-400 uppercase tracking-widest">Next-Gen Capabilities</span>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-white">Engage in a Highly Intelligent Classroom</h2>
                <p class="text-sm text-slate-400 leading-relaxed">
                    We designed EduMind AI around the Linear and Stripe design system, matching state of the art startup portals.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="p-8 bg-slate-900/40 border border-slate-900 rounded-3xl hover:border-purple-500/30 transition-all duration-300 group">
                    <div class="w-12 h-12 rounded-2xl bg-purple-500/10 border border-purple-500/20 text-purple-400 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">24/7 AI Classroom Tutor</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Query the EduMind chatbot at any time. Get code breakdowns, conceptual advice, and course progress suggestions formatted cleanly.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="p-8 bg-slate-900/40 border border-slate-900 rounded-3xl hover:border-indigo-500/30 transition-all duration-300 group">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">XP Progression System</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Earn experience points by finishing course modules and scoring high in quizzes. Climb the ranks and unlock premium certificates.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="p-8 bg-slate-900/40 border border-slate-900 rounded-3xl hover:border-pink-500/30 transition-all duration-300 group">
                    <div class="w-12 h-12 rounded-2xl bg-pink-500/10 border border-pink-500/20 text-pink-400 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Interactive Analytics</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Track your daily study velocity and quiz grade curves using dark-themed, highly interactive ApexCharts visualizations.
                    </p>
                </div>
            </div>
        </section>

        <!-- Courses Section -->
        <section id="courses" class="relative z-10 max-w-7xl mx-auto px-6 py-24 border-t border-slate-900/50">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
                <div class="space-y-4">
                    <span class="text-xs font-bold text-purple-400 uppercase tracking-widest">Our Catalog</span>
                    <h2 class="text-3xl lg:text-4xl font-extrabold text-white">Explore Premium Featured Courses</h2>
                    <p class="text-sm text-slate-400 max-w-xl">
                        Acquire cutting-edge credentials designed by technology leaders and evaluated automatically by neural AI validators.
                    </p>
                </div>
                <a href="{{ route('courses.index') }}" class="px-6 py-3 rounded-xl border border-slate-800 bg-slate-900/60 text-sm font-bold text-slate-300 hover:bg-slate-900 hover:text-white transition-all">
                    View All Courses ({{ count($courses) }})
                </a>
            </div>

            <!-- Dynamic Course Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($courses as $course)
                    <div class="bg-slate-900/60 border border-slate-800 rounded-3xl overflow-hidden flex flex-col justify-between hover:border-purple-500/20 hover:shadow-glow hover:shadow-purple-500/5 transition-all duration-300">
                        <div>
                            <!-- Thumbnail -->
                            <div class="h-48 overflow-hidden relative">
                                <img src="{{ $course->thumbnail ?? 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=600&q=80' }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105" alt="Course Thumbnail">
                                <div class="absolute top-4 left-4">
                                    <x-gradient-badge type="{{ $course->level == 'Beginner' ? 'emerald' : ($course->level == 'Intermediate' ? 'blue' : 'purple') }}">
                                        {{ $course->level }}
                                    </x-gradient-badge>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-6 space-y-4">
                                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">{{ $course->category }}</span>
                                <h3 class="text-lg font-bold text-white hover:text-purple-400 transition-colors line-clamp-1">
                                    <a href="{{ route('courses.show', $course->id) }}">{{ $course->title }}</a>
                                </h3>
                                <p class="text-xs text-slate-400 line-clamp-3 leading-relaxed">
                                    {{ $course->description }}
                                </p>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="p-6 border-t border-slate-800/60 flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <img class="w-7 h-7 rounded-full border border-purple-500/20 object-cover" src="{{ $course->teacher->avatar ?? 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=80&q=80' }}" alt="Teacher Avatar">
                                <span class="text-xs font-semibold text-slate-300 truncate max-w-[120px]">{{ $course->teacher->name }}</span>
                            </div>
                            <span class="text-xs font-bold text-slate-500 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $course->duration }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12 bg-slate-900/30 border border-slate-850 rounded-3xl">
                        <p class="text-slate-400 text-sm">No courses available. Run `php artisan db:seed` to populate the database.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Pricing Section -->
        <section id="pricing" class="relative z-10 max-w-7xl mx-auto px-6 py-24 border-t border-slate-900/50">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-4">
                <span class="text-xs font-bold text-purple-400 uppercase tracking-widest">SaaS Plans</span>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-white">Simple, Transparent Pricing</h2>
                <p class="text-sm text-slate-400 leading-relaxed">
                    Start learning for free today, or unlock unrestricted AI compute nodes and premium certifications.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 max-w-4xl mx-auto gap-8">
                <!-- Free Plan -->
                <div class="p-8 bg-slate-900/30 border border-slate-900/80 rounded-3xl flex flex-col justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-white mb-2">Free Starter</h3>
                        <p class="text-xs text-slate-500 mb-6">Perfect for exploring the platform features.</p>
                        <div class="mb-6">
                            <span class="text-4xl font-extrabold text-white">$0</span>
                            <span class="text-slate-500 text-sm">/ month</span>
                        </div>
                        <ul class="space-y-3.5 mb-8 text-xs text-slate-300">
                            <li class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Access to Beginner tier courses
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                5 AI Chatbot prompts per day
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Basic quiz attempts tracking
                            </li>
                        </ul>
                    </div>
                    <a href="{{ route('register') }}" class="py-3 px-6 rounded-xl border border-slate-800 hover:bg-slate-900 text-center font-bold text-xs text-slate-200 transition-all">
                        Sign Up Free
                    </a>
                </div>

                <!-- Premium Pro -->
                <div class="p-8 bg-gradient-to-tr from-purple-950/40 to-slate-900/60 border border-purple-500/20 rounded-3xl flex flex-col justify-between relative shadow-glow shadow-purple-500/5">
                    <div class="absolute top-4 right-4 bg-purple-500 text-white font-bold text-[9px] uppercase tracking-widest px-3 py-0.5 rounded-full">POPULAR</div>
                    <div>
                        <h3 class="text-lg font-bold text-white mb-2">Pro E-Learner</h3>
                        <p class="text-xs text-purple-400/80 mb-6">Everything you need to master AI & Software Engineering.</p>
                        <div class="mb-6">
                            <span class="text-4xl font-extrabold text-white">$29</span>
                            <span class="text-slate-500 text-sm">/ month</span>
                        </div>
                        <ul class="space-y-3.5 mb-8 text-xs text-slate-300">
                            <li class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Unlimited access to all course tiers
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Unlimited AI Chatbot Tutor compute
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Verified Completion Certificates
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Cohort leaderboard placement
                            </li>
                        </ul>
                    </div>
                    <a href="{{ route('register') }}" class="py-3 px-6 rounded-xl bg-gradient-to-r from-purple-500 to-indigo-500 hover:shadow-glow hover:-translate-y-0.5 text-center font-bold text-xs text-white transition-all shadow-lg shadow-purple-500/20 duration-300">
                        Unlock Pro Now
                    </a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="border-t border-slate-900/60 bg-slate-950/30 relative z-10">
            <div class="max-w-7xl mx-auto px-6 py-12 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center text-white">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-extrabold text-white">EduMind AI</span>
                </div>
                <span class="text-xs text-slate-600">&copy; 2026 EduMind AI. Built with Laravel + Blade. All rights reserved.</span>
            </div>
        </footer>

    </body>
</html>
