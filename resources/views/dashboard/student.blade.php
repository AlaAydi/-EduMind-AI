<x-app-layout :title="'Student Hub - EduMind AI'">
    
    <!-- Welcome Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6 relative z-10">
        <div>
            <span class="text-xs font-bold text-purple-400 uppercase tracking-widest">Portal Overview</span>
            <h2 class="text-3xl font-extrabold text-white mt-1">Welcome back, {{ auth()->user()->name }}!</h2>
            <p class="text-xs text-slate-450 mt-1 leading-relaxed">Here is your neural study progress. You have completed <span class="text-purple-400 font-bold">{{ $completedCount }}</span> course modules this semester.</p>
        </div>
        
        <!-- Quick XP Stats badge -->
        <div class="p-3 bg-slate-900/60 border border-slate-800 rounded-2xl flex items-center gap-4 shadow-lg backdrop-blur-md">
            <div class="w-10 h-10 rounded-xl bg-purple-500/10 border border-purple-500/20 text-purple-400 flex items-center justify-center text-sm font-black">
                {{ $currentLevel }}
            </div>
            <div>
                <span class="text-[10px] text-slate-500 font-extrabold uppercase tracking-wider block">Current Rank</span>
                <span class="text-sm font-bold text-slate-200 block">Level {{ $currentLevel }} Explorer</span>
            </div>
        </div>
    </div>

    <!-- Main Grid Scaffolding -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 relative z-10">
        
        <!-- LEFT PANEL: Stats, Charts, Courses (Col Span 8) -->
        <div class="lg:col-span-8 space-y-8">
            
            <!-- Level Progression Bar Card -->
            <x-glass-card class="p-6">
                <div class="flex justify-between items-center mb-3">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-purple-500 animate-pulse"></span>
                        <span class="text-xs font-bold text-slate-300 uppercase tracking-wider">Experience Curve</span>
                    </div>
                    <span class="text-xs font-bold text-purple-400">{{ $totalXP }} / {{ $xpForNextLevel }} XP</span>
                </div>
                
                <div class="w-full h-3 bg-slate-950 border border-slate-900 rounded-full overflow-hidden mb-3">
                    <div class="h-full bg-gradient-to-r from-purple-500 to-indigo-500 rounded-full shadow-glow" style="width: {{ $levelProgressPercentage }}%"></div>
                </div>
                
                <p class="text-[10px] text-slate-500 font-semibold leading-relaxed">
                    Earn another <span class="text-slate-350 font-bold">{{ $xpForNextLevel - $totalXP }} XP</span> to unlock Level {{ $currentLevel + 1 }} and claim your next academic node.
                </p>
            </x-glass-card>

            <!-- Grid of 4 Core Stats Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <!-- Stat 1: Active Courses -->
                <x-glass-card class="p-5 hover:border-purple-500/20 transition-all duration-300" hover="true">
                    <div class="w-9 h-9 rounded-xl bg-blue-500/10 border border-blue-500/20 text-blue-400 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <span class="block text-2xl font-black text-white leading-tight">{{ $activeCount }}</span>
                    <span class="text-[10px] text-slate-500 font-bold uppercase tracking-wider block mt-1">Ongoing modules</span>
                </x-glass-card>

                <!-- Stat 2: Completed Courses -->
                <x-glass-card class="p-5 hover:border-emerald-500/20 transition-all duration-300" hover="true">
                    <div class="w-9 h-9 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="block text-2xl font-black text-white leading-tight">{{ $completedCount }}</span>
                    <span class="text-[10px] text-slate-500 font-bold uppercase tracking-wider block mt-1">Certificates won</span>
                </x-glass-card>

                <!-- Stat 3: Study Hours -->
                <x-glass-card class="p-5 hover:border-purple-500/20 transition-all duration-300" hover="true">
                    <div class="w-9 h-9 rounded-xl bg-purple-500/10 border border-purple-500/20 text-purple-400 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="block text-2xl font-black text-white leading-tight">{{ $totalStudyHours }}h</span>
                    <span class="text-[10px] text-slate-500 font-bold uppercase tracking-wider block mt-1">Study time</span>
                </x-glass-card>

                <!-- Stat 4: Quizzes Passed -->
                <x-glass-card class="p-5 hover:border-pink-500/20 transition-all duration-300" hover="true">
                    <div class="w-9 h-9 rounded-xl bg-pink-500/10 border border-pink-500/20 text-pink-400 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16.01H9"/>
                        </svg>
                    </div>
                    <span class="block text-2xl font-black text-white leading-tight">{{ $passedQuizzesCount }}</span>
                    <span class="text-[10px] text-slate-500 font-bold uppercase tracking-wider block mt-1">Quizzes Passed</span>
                </x-glass-card>
            </div>

            <!-- Charts Section: Weekly Study Velocity -->
            <x-glass-card class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-sm font-bold text-white uppercase tracking-wider">Study Velocity</h3>
                        <p class="text-[11px] text-slate-500 mt-0.5 leading-relaxed">Weekly study hours recorded across enrolled modules.</p>
                    </div>
                    <span class="px-2.5 py-1 text-[10px] font-bold border border-slate-800 bg-slate-900 text-slate-350 rounded-xl">Last 7 Days</span>
                </div>
                <div id="study-velocity-chart" class="w-full"></div>
            </x-glass-card>

            <!-- Active Enrolled Courses Gallery -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">My Current Modules</h3>
                    <a href="{{ route('courses.index') }}" class="text-xs text-purple-400 hover:underline">View All</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse ($enrollments as $enrollment)
                        <x-glass-card class="overflow-hidden flex flex-col justify-between hover:border-purple-500/20 shadow-lg hover:shadow-purple-500/5 transition-all duration-300" hover="true">
                            <div>
                                <!-- Image & Tags -->
                                <div class="h-36 relative overflow-hidden">
                                    <img src="{{ $enrollment->course->thumbnail ?? 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=500&q=80' }}" class="w-full h-full object-cover" alt="Course Thumbnail">
                                    <div class="absolute top-3 left-3">
                                        <x-gradient-badge type="{{ $enrollment->status == 'completed' ? 'emerald' : 'blue' }}">
                                            {{ ucfirst($enrollment->status) }}
                                        </x-gradient-badge>
                                    </div>
                                </div>

                                <!-- Text -->
                                <div class="p-5 space-y-3">
                                    <span class="text-[9px] font-bold text-slate-500 uppercase tracking-wider block">{{ $enrollment->course->category }}</span>
                                    <h4 class="text-sm font-bold text-white leading-snug line-clamp-1">
                                        <a href="{{ route('courses.show', $enrollment->course->id) }}" class="hover:text-purple-400 transition-colors">{{ $enrollment->course->title }}</a>
                                    </h4>
                                    
                                    <!-- progress bar -->
                                    <div class="space-y-1.5 pt-1.5">
                                        <div class="flex justify-between text-[10px] font-semibold text-slate-400">
                                            <span>Progress</span>
                                            <span>{{ $enrollment->progress }}%</span>
                                        </div>
                                        <div class="w-full h-1.5 bg-slate-950 rounded-full overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-purple-500 to-indigo-500 rounded-full shadow-glow" style="width: {{ $enrollment->progress }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer CTA -->
                            <div class="p-5 border-t border-slate-900/60 bg-slate-950/20 flex items-center justify-between">
                                <span class="text-[10px] text-slate-500 font-semibold">Taught by {{ $enrollment->course->teacher->name }}</span>
                                <a href="{{ route('courses.show', $enrollment->course->id) }}" class="text-xs font-bold text-purple-400 hover:text-purple-300 flex items-center gap-1.5 transition-colors">
                                    Continue
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </x-glass-card>
                    @empty
                        <div class="col-span-2 text-center p-8 bg-slate-900/30 border border-slate-850 rounded-3xl">
                            <p class="text-slate-400 text-xs">You are not enrolled in any modules yet. Browse the catalog to start learning!</p>
                            <a href="{{ route('courses.index') }}" class="mt-4 inline-block px-4 py-2 rounded-xl bg-purple-500 text-white font-bold text-xs hover:bg-purple-650 transition-colors shadow-glow shadow-purple-500/10">Browse Catalog</a>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- RIGHT PANEL: AI Tutor, Recommendations, Activity Timeline (Col Span 4) -->
        <div class="lg:col-span-4 space-y-8">
            
            <!-- AI Mini-Chatbot Console widget -->
            <x-glass-card class="p-6 border-purple-500/15" glow="true">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-purple-500 to-indigo-500 flex items-center justify-center text-white shadow-glow">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-white uppercase tracking-wider">AI Learning Assistant</h3>
                        <span class="text-[9px] text-purple-400 font-extrabold uppercase tracking-widest">Active System</span>
                    </div>
                </div>

                <!-- Chat log snippet -->
                <div class="p-3 bg-slate-950/80 border border-slate-900 rounded-xl text-[11px] leading-relaxed text-slate-450 space-y-2 mb-4 max-h-[120px] overflow-y-auto">
                    <p class="text-purple-400/90 font-bold block mb-1">EduMind AI:</p>
                    "Hello! Need assistance with prompt parameters, blade component layouts, or viz databases? Type your question below."
                </div>

                <!-- Input form redirect -->
                <form action="{{ route('ai-chatbot') }}" method="GET" class="m-0 p-0">
                    <div class="relative flex items-center">
                        <input type="text" name="msg" placeholder="Ask AI a quick query..." class="w-full text-xs bg-slate-950/80 border border-slate-850 rounded-xl pr-10 pl-3 py-2 text-slate-350 focus:outline-none focus:border-purple-500/50 placeholder-slate-700">
                        <button type="submit" class="absolute right-2 p-1 text-purple-400 hover:text-white transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>
                    </div>
                </form>
            </x-glass-card>

            <!-- AI Recommended Courses list -->
            <x-glass-card class="p-6">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Recommended For You</h3>
                
                <div class="space-y-4">
                    @forelse ($recommendations as $rec)
                        <div class="p-3 bg-slate-950/30 border border-slate-850 rounded-2xl flex gap-3 hover:border-purple-500/10 transition-colors group">
                            <img class="w-14 h-14 rounded-xl object-cover flex-shrink-0" src="{{ $rec->thumbnail ?? 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=150&q=80' }}" alt="Recommended Course Thumbnail">
                            <div class="overflow-hidden space-y-1.5 flex-1">
                                <h4 class="text-xs font-bold text-white leading-tight truncate group-hover:text-purple-400 transition-colors">
                                    <a href="{{ route('courses.show', $rec->id) }}">{{ $rec->title }}</a>
                                </h4>
                                <div class="flex justify-between items-center text-[10px] font-semibold">
                                    <span class="text-slate-500">{{ $rec->category }}</span>
                                    <form action="{{ route('courses.enroll', $rec->id) }}" method="POST" class="m-0 p-0">
                                        @csrf
                                        <button type="submit" class="text-purple-400 font-extrabold hover:text-purple-300">Enroll</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-[11px] text-slate-500">No recommended courses remaining. You are enrolled in all modules!</p>
                    @endforelse
                </div>
            </x-glass-card>

            <!-- Recent Activity Timeline Log -->
            <x-glass-card class="p-6">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-5">Recent Activity Feed</h3>

                <div class="relative border-l border-slate-850 pl-4 space-y-6">
                    @forelse ($activities as $act)
                        <div class="relative">
                            <!-- Bullet Indicator -->
                            @php
                                $bulletColor = match($act->activity_type) {
                                    'certificate' => 'bg-emerald-500 shadow-emerald-500/20 border-emerald-500/30',
                                    'quiz_completion' => 'bg-pink-500 shadow-pink-500/20 border-pink-500/30',
                                    'course_started' => 'bg-blue-500 shadow-blue-500/20 border-blue-500/30',
                                    'ai_chat' => 'bg-purple-500 shadow-purple-500/20 border-purple-500/30',
                                    default => 'bg-slate-500 border-slate-500/30',
                                };
                            @endphp
                            <span class="absolute top-1.5 left-[-21px] w-2.5 h-2.5 rounded-full border ring-4 ring-slate-950 {{ $bulletColor }}"></span>
                            
                            <div>
                                <p class="text-xs font-semibold text-slate-350 leading-tight">{{ $act->description }}</p>
                                <span class="text-[9px] text-slate-500 font-bold block mt-1">{{ $act->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-[11px] text-slate-500 py-3">No activity logged. Complete modules or pass quizzes to fill this feed!</p>
                    @endforelse
                </div>
            </x-glass-card>

        </div>

    </div>

    <!-- Area Chart Scripts -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var options = {
                chart: {
                    type: 'area',
                    height: 180,
                    toolbar: { show: false },
                    sparkline: { enabled: false },
                    background: 'transparent',
                    foreColor: '#64748b'
                },
                series: [{
                    name: 'Study Hours',
                    data: @json($studyVelocity['hours'])
                }],
                xaxis: {
                    categories: @json($studyVelocity['days']),
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    labels: { show: true }
                },
                grid: {
                    borderColor: '#1e293b',
                    strokeDashArray: 4
                },
                stroke: {
                    curve: 'smooth',
                    width: 3,
                    colors: ['#a78bfa']
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.45,
                        opacityTo: 0.05,
                        colorStops: [
                            { offset: 0, color: '#8b5cf6', opacity: 0.4 },
                            { offset: 100, color: '#6366f1', opacity: 0.0 }
                        ]
                    }
                },
                theme: { mode: 'dark' },
                tooltip: {
                    theme: 'dark',
                    y: { formatter: function(val) { return val + " hrs" } }
                }
            };

            var chart = new ApexCharts(document.querySelector("#study-velocity-chart"), options);
            chart.render();
        });
    </script>

</x-app-layout>
