<x-app-layout :title="'Browse Modules - EduMind AI'">
    
    <!-- Header -->
    <div class="mb-8 relative z-10">
        <span class="text-xs font-bold text-purple-400 uppercase tracking-widest">Syllabus Library</span>
        <h2 class="text-3xl font-extrabold text-white mt-1">Explore Courses</h2>
        <p class="text-xs text-slate-450 mt-1">Filter modules, review difficulty tiers, and pick up where you left off.</p>
    </div>

    <!-- Filters Panel -->
    <x-glass-card class="p-5 mb-8 relative z-10">
        <form action="{{ route('courses.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 m-0 p-0 items-center">
            
            <!-- Search Keyword -->
            <div class="md:col-span-5 relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search courses or keywords..." class="w-full text-xs bg-slate-950/80 border border-slate-800 focus:border-purple-500 focus:ring-purple-500/20 text-slate-200 placeholder-slate-655 rounded-xl py-2.5 px-3">
            </div>

            <!-- Category Filter -->
            <div class="md:col-span-3">
                <select name="category" class="w-full text-xs bg-slate-950/80 border border-slate-800 focus:border-purple-500 focus:ring-purple-500/20 text-slate-350 rounded-xl py-2.5 px-3">
                    <option value="">All Categories</option>
                    <option value="Artificial Intelligence" {{ request('category') == 'Artificial Intelligence' ? 'selected' : '' }}>Artificial Intelligence</option>
                    <option value="Web Development" {{ request('category') == 'Web Development' ? 'selected' : '' }}>Web Development</option>
                    <option value="Data Science" {{ request('category') == 'Data Science' ? 'selected' : '' }}>Data Science</option>
                    <option value="Design Systems" {{ request('category') == 'Design Systems' ? 'selected' : '' }}>Design Systems</option>
                </select>
            </div>

            <!-- Level Filter -->
            <div class="md:col-span-2">
                <select name="level" class="w-full text-xs bg-slate-950/80 border border-slate-800 focus:border-purple-500 focus:ring-purple-500/20 text-slate-350 rounded-xl py-2.5 px-3">
                    <option value="">All Levels</option>
                    <option value="Beginner" {{ request('level') == 'Beginner' ? 'selected' : '' }}>Beginner</option>
                    <option value="Intermediate" {{ request('level') == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                    <option value="Advanced" {{ request('level') == 'Advanced' ? 'selected' : '' }}>Advanced</option>
                </select>
            </div>

            <!-- Action buttons -->
            <div class="md:col-span-2 flex gap-2 w-full">
                <button type="submit" class="flex-1 py-2.5 bg-gradient-to-r from-purple-500 to-indigo-500 text-white text-xs font-bold rounded-xl hover:shadow-glow transition-all">Filter</button>
                <a href="{{ route('courses.index') }}" class="px-3 py-2.5 bg-slate-950 border border-slate-850 hover:bg-slate-900 text-xs text-slate-400 font-bold rounded-xl transition-colors flex items-center justify-center">Reset</a>
            </div>

        </form>
    </x-glass-card>

    <!-- Course Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 relative z-10">
        @forelse ($courses as $course)
            <div class="bg-slate-900/60 border border-slate-800 rounded-3xl overflow-hidden flex flex-col justify-between hover:border-purple-500/20 hover:shadow-glow hover:shadow-purple-500/5 transition-all duration-300">
                <div>
                    <!-- Thumbnail -->
                    <div class="h-44 overflow-hidden relative">
                        <img src="{{ $course->thumbnail ?? 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=600&q=80' }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105" alt="Course Thumbnail">
                        <div class="absolute top-4 left-4">
                            <x-gradient-badge type="{{ $course->level == 'Beginner' ? 'emerald' : ($course->level == 'Intermediate' ? 'blue' : 'purple') }}">
                                {{ $course->level }}
                            </x-gradient-badge>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-[9px] font-bold text-slate-500 uppercase tracking-wider">{{ $course->category }}</span>
                            @if (isset($userEnrollments[$course->id]))
                                <span class="px-2 py-0.5 text-[9px] font-bold bg-purple-500/10 text-purple-400 border border-purple-500/25 rounded-md">Enrolled</span>
                            @endif
                        </div>
                        <h3 class="text-base font-bold text-white hover:text-purple-400 transition-colors line-clamp-1">
                            <a href="{{ route('courses.show', $course->id) }}">{{ $course->title }}</a>
                        </h3>
                        <p class="text-xs text-slate-400 line-clamp-3 leading-relaxed">
                            {{ $course->description }}
                        </p>

                        <!-- Progress Bar (If Enrolled) -->
                        @if (isset($userEnrollments[$course->id]))
                            <div class="space-y-1.5 pt-2">
                                <div class="flex justify-between text-[10px] text-slate-500 font-bold">
                                    <span>Course Progress</span>
                                    <span>{{ $userEnrollments[$course->id] }}%</span>
                                </div>
                                <div class="w-full h-1 bg-slate-950 rounded-full overflow-hidden">
                                    <div class="h-full bg-purple-500 rounded-full shadow-glow" style="width: {{ $userEnrollments[$course->id] }}%"></div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Footer -->
                <div class="p-6 border-t border-slate-800/60 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <img class="w-7 h-7 rounded-full border border-purple-500/10 object-cover" src="{{ $course->teacher->avatar ?? 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=80&q=80' }}" alt="Teacher Avatar">
                        <span class="text-xs font-semibold text-slate-350 truncate max-w-[100px]">{{ $course->teacher->name }}</span>
                    </div>
                    
                    <a href="{{ route('courses.show', $course->id) }}" class="px-4 py-2 rounded-xl bg-slate-950 border border-slate-850 hover:bg-slate-900 text-xs font-bold text-slate-300 hover:text-white transition-all flex items-center gap-1.5">
                        {{ isset($userEnrollments[$course->id]) ? 'Resume' : 'View Course' }}
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-16 bg-slate-900/30 border border-slate-850 rounded-3xl">
                <p class="text-slate-400 text-xs font-semibold">No courses match your active search filters.</p>
                <a href="{{ route('courses.index') }}" class="mt-4 inline-block px-4 py-2 rounded-xl bg-purple-500 text-white font-bold text-xs hover:bg-purple-650 transition-colors">Clear Filters</a>
            </div>
        @endforelse
    </div>
</x-app-layout>
