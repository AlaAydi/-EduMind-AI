<x-app-layout :title="$course->title . ' - Classroom'">
    
    <!-- Header -->
    <div class="mb-6 flex items-center justify-between gap-4 relative z-10">
        <a href="{{ route('courses.index') }}" class="text-xs text-purple-400 hover:underline flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Catalog
        </a>

        @if ($enrollment)
            <div class="flex items-center gap-3">
                <span class="text-xs text-slate-500 font-bold uppercase tracking-wider">Status:</span>
                <x-gradient-badge type="{{ $enrollment->status == 'completed' ? 'emerald' : 'blue' }}">
                    {{ ucfirst($enrollment->status) }}
                </x-gradient-badge>
            </div>
        @endif
        
        @if(Auth::id() === $course->teacher_id || Auth::user()->isAdmin())
            <div class="flex gap-2">
                <a href="{{ route('courses.edit', $course->id) }}" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white text-xs font-bold rounded-xl transition-all">Edit</a>
                <form action="{{ route('courses.destroy', $course->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this course?');" class="m-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500/20 text-red-400 hover:bg-red-500 hover:text-white text-xs font-bold rounded-xl transition-all border border-red-500/30">Delete</button>
                </form>
            </div>
        @endif
    </div>

    <!-- Main Scaffolding -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 relative z-10">
        
        <!-- Left: Classroom Video Player & Lesson Info (Col Span 8) -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- Video Mock Player -->
            <x-glass-card class="overflow-hidden border-purple-550/15" glow="true">
                <div class="aspect-video w-full bg-slate-950/95 flex flex-col items-center justify-center relative group cursor-pointer">
                    <!-- Background glows -->
                    <div class="absolute inset-0 bg-gradient-to-tr from-purple-900/10 to-indigo-900/5 z-0"></div>
                    <div class="absolute w-24 h-24 rounded-full bg-purple-500/10 blur-xl pointer-events-none group-hover:scale-125 transition-transform duration-300 z-0"></div>

                    <!-- Glowing Play Button -->
                    <div class="w-16 h-16 rounded-full bg-gradient-to-tr from-purple-500 to-indigo-500 flex items-center justify-center shadow-lg shadow-purple-500/30 group-hover:scale-110 transition-transform duration-300 relative z-10">
                        <svg class="w-7 h-7 text-white translate-x-0.5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </div>

                    <!-- Overlay metadata -->
                    <div class="absolute bottom-4 left-6 right-6 flex items-center justify-between text-xs text-slate-400 z-10">
                        <span class="font-bold">Module 1: Introduction and Core Framework Structure</span>
                        <span>0:00 / 12:45</span>
                    </div>
                </div>
            </x-glass-card>

            <!-- Lesson Content -->
            <x-glass-card class="p-6 space-y-4">
                <div class="flex items-center gap-3">
                    <span class="text-xs font-bold text-purple-400 uppercase tracking-widest">{{ $course->category->name ?? 'Uncategorized' }}</span>
                    <span class="w-1 h-1 rounded-full bg-slate-700"></span>
                    <span class="text-xs text-slate-500 font-bold uppercase tracking-wider">Lesson 1 of 5</span>
                </div>
                <h3 class="text-xl font-extrabold text-white">{{ $course->title }}</h3>
                <p class="text-xs text-slate-400 leading-relaxed">
                    This module walks you through the core conceptual schemas and architecture foundations. Follow along with the instructor slides, test inputs inside the sandbox sandbox environment, and pass the final evaluation quizzes to claim completion credits.
                </p>
            </x-glass-card>

            <!-- Quiz / Evaluation list -->
            @if ($quizzes->count() > 0)
                <x-glass-card class="p-6 border-pink-500/15">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Required Evaluations</h3>
                    <div class="space-y-4">
                        @foreach ($quizzes as $quiz)
                            <div class="p-4 bg-slate-950/40 border border-slate-900 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-200">{{ $quiz->title }}</h4>
                                    <p class="text-xs text-slate-500 mt-1">Required score: {{ $quiz->passing_score }}% to unlock credit node.</p>
                                </div>
                                <a href="{{ route('quizzes.show', $quiz->id) }}" class="px-5 py-2.5 bg-gradient-to-r from-pink-500 to-purple-500 text-white text-xs font-extrabold rounded-xl shadow-glow shadow-pink-500/10 hover:shadow-pink-500/20 hover:-translate-y-0.5 transition-all text-center">
                                    Start Evaluation
                                </a>
                            </div>
                        @endforeach
                    </div>
                </x-glass-card>
            @endif

        </div>

        <!-- Right: Syllabus Navigation Checklist & Progress controls (Col Span 4) -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Student Progress Controller -->
            @if ($enrollment)
                <x-glass-card class="p-6">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Syllabus Progress</h3>
                    
                    <!-- Progress meter -->
                    <div class="space-y-4">
                        <div class="flex justify-between items-center text-xs font-bold">
                            <span class="text-slate-555">Syllabus Node</span>
                            <span class="text-purple-400">{{ $enrollment->progress }}% Completed</span>
                        </div>
                        <div class="w-full h-2 bg-slate-950 border border-slate-900 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-purple-500 to-indigo-500 rounded-full shadow-glow" style="width: {{ $enrollment->progress }}%"></div>
                        </div>

                        <!-- Update Progress Form -->
                        <form action="{{ route('courses.progress', $course->id) }}" method="POST" class="m-0 p-0 pt-2">
                            @csrf
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Simulate Progress</label>
                            <div class="flex gap-2">
                                <select name="progress" class="flex-1 text-xs bg-slate-950/80 border border-slate-800 focus:border-purple-500 text-slate-350 rounded-xl py-2 px-3 focus:outline-none">
                                    <option value="0" {{ $enrollment->progress == 0 ? 'selected' : '' }}>0% Start</option>
                                    <option value="20" {{ $enrollment->progress == 20 ? 'selected' : '' }}>20% Lecture 1</option>
                                    <option value="40" {{ $enrollment->progress == 40 ? 'selected' : '' }}>40% Lecture 2</option>
                                    <option value="60" {{ $enrollment->progress == 60 ? 'selected' : '' }}>60% Lecture 3</option>
                                    <option value="80" {{ $enrollment->progress == 80 ? 'selected' : '' }}>80% Lecture 4</option>
                                    <option value="100" {{ $enrollment->progress == 100 ? 'selected' : '' }}>100% Complete</option>
                                </select>
                                <button type="submit" class="px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white text-xs font-bold rounded-xl shadow-glow shadow-purple-500/10 hover:shadow-purple-500/20 transition-all">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </x-glass-card>
            @endif

            <!-- Chapters/Lessons Navigation Menu -->
            <x-glass-card class="p-6">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Syllabus Index</h3>
                
                <div class="space-y-4">
                    @foreach ($lessons as $index => $les)
                        <div class="p-3 rounded-2xl flex justify-between items-center gap-3 border transition-colors cursor-pointer {{ $index === 0 ? 'bg-purple-500/5 border-purple-500/20 text-purple-400' : 'bg-slate-950/20 border-slate-900 text-slate-350 hover:bg-slate-900/40 hover:text-slate-200' }}">
                            <div class="flex items-center gap-3 overflow-hidden">
                                <!-- play icon or check -->
                                <div class="w-6 h-6 rounded-lg bg-slate-900 border border-slate-800 flex items-center justify-center flex-shrink-0">
                                    @if ($enrollment && $enrollment->progress >= (($index + 1) * 20))
                                        <!-- check -->
                                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    @else
                                        <!-- play -->
                                        <svg class="w-3 h-3 {{ $index === 0 ? 'text-purple-400' : 'text-slate-555' }}" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                    @endif
                                </div>
                                <span class="text-xs font-bold truncate leading-none mt-0.5">{{ $les->title }}</span>
                            </div>
                            <span class="text-[10px] font-semibold text-slate-500 flex-shrink-0 uppercase">{{ $les->type }}</span>
                        </div>
                    @endforeach
                </div>
            </x-glass-card>

        </div>

    </div>

</x-app-layout>
