<x-app-layout :title="'Instructor Control Center - EduMind AI'">
    
    <!-- Welcome Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6 relative z-10">
        <div>
            <span class="text-xs font-bold text-purple-400 uppercase tracking-widest">Instructor HQ</span>
            <h2 class="text-3xl font-extrabold text-white mt-1">Hello, {{ auth()->user()->name }}!</h2>
            <p class="text-xs text-slate-450 mt-1 leading-relaxed">Manage your syllabus, edit quizzes, and review cohort growth metrics.</p>
        </div>
        
        <!-- CTA to create new course -->
        <a href="{{ route('courses.create') }}" class="flex items-center gap-2 px-5 py-3 rounded-2xl bg-gradient-to-r from-purple-500 to-indigo-500 hover:from-purple-600 hover:to-indigo-600 text-white font-extrabold text-xs shadow-glow hover:shadow-purple-500/20 hover:-translate-y-0.5 transition-all duration-300">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Create New Course
        </a>
    </div>

    <!-- Main Grid Scaffolding -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 relative z-10">
        
        <!-- LEFT PANEL: Stats, Chart, Course Matrix (Col Span 8) -->
        <div class="lg:col-span-8 space-y-8">
            
            <!-- Grid of 4 Core Stats Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <!-- Stat 1: Total Courses -->
                <x-glass-card class="p-5 hover:border-blue-500/20 transition-all duration-300" hover="true">
                    <div class="w-9 h-9 rounded-xl bg-blue-500/10 border border-blue-500/20 text-blue-400 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <span class="block text-2xl font-black text-white leading-tight">{{ $activeCoursesCount }}</span>
                    <span class="text-[10px] text-slate-500 font-bold uppercase tracking-wider block mt-1">Active Modules</span>
                </x-glass-card>

                <!-- Stat 2: Total Enrolled Students -->
                <x-glass-card class="p-5 hover:border-purple-500/20 transition-all duration-300" hover="true">
                    <div class="w-9 h-9 rounded-xl bg-purple-500/10 border border-purple-500/20 text-purple-400 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <span class="block text-2xl font-black text-white leading-tight">{{ $totalStudents }}</span>
                    <span class="text-[10px] text-slate-500 font-bold uppercase tracking-wider block mt-1">Total Enrolled</span>
                </x-glass-card>

                <!-- Stat 3: Quiz Pass Rate -->
                <x-glass-card class="p-5 hover:border-pink-500/20 transition-all duration-300" hover="true">
                    <div class="w-9 h-9 rounded-xl bg-pink-500/10 border border-pink-500/20 text-pink-400 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <span class="block text-2xl font-black text-white leading-tight">{{ $quizPassRate }}%</span>
                    <span class="text-[10px] text-slate-500 font-bold uppercase tracking-wider block mt-1">Quiz Pass Ratio</span>
                </x-glass-card>

                <!-- Stat 4: SaaS Revenue Share -->
                <x-glass-card class="p-5 hover:border-emerald-500/20 transition-all duration-300" hover="true">
                    <div class="w-9 h-9 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16v1m0-1c1.657 0 3-.895 3-2s-1.343-2-3-2-3-.895-3-2 1.343-2 3-2"/>
                        </svg>
                    </div>
                    <span class="block text-2xl font-black text-white leading-tight">${{ number_format($revenue, 2) }}</span>
                    <span class="text-[10px] text-slate-500 font-bold uppercase tracking-wider block mt-1">SaaS Revenue</span>
                </x-glass-card>
            </div>

            <!-- Enrollment Trend Chart -->
            <x-glass-card class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-sm font-bold text-white uppercase tracking-wider">Cohort Signup Trend</h3>
                        <p class="text-[11px] text-slate-500 mt-0.5">Growth curve for students joining your classes.</p>
                    </div>
                    <span class="px-2.5 py-1 text-[10px] font-bold border border-slate-800 bg-slate-900 text-slate-350 rounded-xl">Year-to-date</span>
                </div>
                <div id="cohort-trend-chart" class="w-full"></div>
            </x-glass-card>

            <!-- Course Matrix (Responsive Table of Managed Courses) -->
            <div class="space-y-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Course Matrix</h3>
                
                <x-glass-card class="overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="bg-slate-950/60 text-slate-450 border-b border-slate-900 uppercase font-bold text-[10px] tracking-wider">
                                    <th class="py-4 px-5">Course Title</th>
                                    <th class="py-4 px-5">Category</th>
                                    <th class="py-4 px-5 text-center">Level</th>
                                    <th class="py-4 px-5 text-center">Duration</th>
                                    <th class="py-4 px-5 text-center">Enrolled</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-900/60">
                                @forelse ($courses as $c)
                                    <tr class="hover:bg-slate-900/20 transition-colors">
                                        <td class="py-4 px-5 font-bold text-slate-200">
                                            <a href="{{ route('courses.show', $c->id) }}" class="hover:text-purple-400 transition-colors">{{ $c->title }}</a>
                                        </td>
                                        <td class="py-4 px-5 text-slate-400">{{ $c->category }}</td>
                                        <td class="py-4 px-5 text-center">
                                            <x-gradient-badge type="{{ $c->level == 'Beginner' ? 'emerald' : ($c->level == 'Intermediate' ? 'blue' : 'purple') }}">
                                                {{ $c->level }}
                                            </x-gradient-badge>
                                        </td>
                                        <td class="py-4 px-5 text-center text-slate-400 font-semibold">{{ $c->duration }}</td>
                                        <td class="py-4 px-5 text-center text-purple-400 font-bold">{{ $c->enrollments->count() }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-8 text-center text-slate-500">
                                            You haven't created any courses yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </x-glass-card>
            </div>

        </div>

        <!-- RIGHT PANEL: Recent Enrollments timeline (Col Span 4) -->
        <div class="lg:col-span-4 space-y-8">
            
            <x-glass-card class="p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-8 rounded-xl bg-purple-500/10 border border-purple-500/20 text-purple-400 flex items-center justify-center">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-white uppercase tracking-wider">Recent Cohort Signups</h3>
                        <span class="text-[9px] text-slate-500 font-semibold block mt-0.5">Real-time alerts</span>
                    </div>
                </div>

                <div class="space-y-4">
                    @forelse ($recentEnrollments as $re)
                        <div class="p-4 bg-slate-950/40 border border-slate-900 rounded-2xl flex items-center gap-3 hover:border-purple-500/10 transition-colors">
                            <img class="w-10 h-10 rounded-xl object-cover border border-purple-500/10" src="{{ $re->user->avatar ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=100&q=80' }}" alt="Student Avatar">
                            <div class="overflow-hidden flex-1 leading-none">
                                <span class="text-xs font-bold text-slate-200 block truncate">{{ $re->user->name }}</span>
                                <span class="text-[9px] text-slate-550 block mt-1 truncate">Enrolled in: {{ $re->course->title }}</span>
                                <span class="text-[9px] text-purple-400 font-semibold block mt-1">{{ $re->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-[11px] text-slate-500 py-3 text-center">No students registered recently.</p>
                    @endforelse
                </div>
            </x-glass-card>

            <!-- Quiz Settings Summary card -->
            <x-glass-card class="p-6">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Quiz Administration</h3>
                <p class="text-xs text-slate-450 leading-relaxed mb-4">You have set up quizzes across your active modules. Ensure your questions remain refreshed.</p>
                <div class="space-y-2">
                    <a href="{{ route('quizzes.index') }}" class="w-full py-2.5 rounded-xl border border-slate-800 hover:bg-slate-900 text-center font-bold text-xs text-slate-200 block transition-colors">
                        Configure Quizzes
                    </a>
                </div>
            </x-glass-card>

        </div>

    </div>

    <!-- Chart Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var options = {
                chart: {
                    type: 'bar',
                    height: 180,
                    toolbar: { show: false },
                    sparkline: { enabled: false },
                    background: 'transparent',
                    foreColor: '#64748b'
                },
                plotOptions: {
                    bar: {
                        borderRadius: 5,
                        columnWidth: '40%',
                        distributed: false
                    }
                },
                series: [{
                    name: 'Monthly Signups',
                    data: @json($enrollmentTrend['signups'])
                }],
                xaxis: {
                    categories: @json($enrollmentTrend['months']),
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
                colors: ['#8b5cf6'],
                theme: { mode: 'dark' },
                tooltip: {
                    theme: 'dark',
                    y: { formatter: function(val) { return val + " students" } }
                }
            };

            var chart = new ApexCharts(document.querySelector("#cohort-trend-chart"), options);
            chart.render();
        });
    </script>

</x-app-layout>
