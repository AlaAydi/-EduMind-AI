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
    <div x-data="classroomData()" class="grid grid-cols-1 lg:grid-cols-12 gap-8 relative z-10">
        
        <!-- Left: Classroom Video Player & Lesson Info (Col Span 8) -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- Dynamic Player Area -->
            <x-glass-card class="overflow-hidden border-purple-550/15" glow="true">
                <template x-if="currentLesson && currentLesson.type === 'video'">
                    <iframe class="w-full aspect-video bg-slate-950/95" :src="getEmbedUrl(currentLesson.file_path)" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </template>
                
                <template x-if="currentLesson && currentLesson.type !== 'video'">
                    <div class="aspect-video w-full bg-slate-950/95 flex flex-col items-center justify-center relative group">
                        <div class="absolute inset-0 bg-gradient-to-tr from-purple-900/10 to-indigo-900/5 z-0"></div>
                        <svg class="w-16 h-16 text-slate-500 mb-4 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <h3 class="text-white font-bold relative z-10" x-text="currentLesson.title"></h3>
                        <a :href="currentLesson.file_path" target="_blank" class="mt-4 px-6 py-2.5 bg-purple-500 hover:bg-purple-600 text-white rounded-xl text-xs font-bold transition-all relative z-10 shadow-glow">Open Document</a>
                    </div>
                </template>

                <template x-if="!currentLesson">
                    <div class="aspect-video w-full bg-slate-950/95 flex flex-col items-center justify-center">
                        <span class="text-slate-500 font-bold">No content selected or available</span>
                    </div>
                </template>
            </x-glass-card>

            <!-- Lesson Content -->
            <x-glass-card class="p-6 space-y-4">
                <div class="flex items-center gap-3">
                    <span class="text-xs font-bold text-purple-400 uppercase tracking-widest">{{ $course->category->name ?? 'Uncategorized' }}</span>
                    <span class="w-1 h-1 rounded-full bg-slate-700"></span>
                    <span class="text-xs text-slate-500 font-bold uppercase tracking-wider" x-text="currentLesson ? 'Selected Lesson' : 'Course Overview'"></span>
                </div>
                <h3 class="text-xl font-extrabold text-white" x-text="currentLesson ? currentLesson.title : '{{ addslashes($course->title) }}'"></h3>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Click on a resource in the syllabus index on the right to view it. Video links (YouTube) will embed automatically, while documents and other links will provide a button to open them securely.
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
                        <div @click='currentLesson = @json($les)' 
                             class="p-3 rounded-2xl flex justify-between items-center gap-3 border transition-colors cursor-pointer" 
                             :class="currentLesson && currentLesson.id === {{ $les->id }} ? 'bg-purple-500/10 border-purple-500/30 text-purple-300' : 'bg-slate-950/20 border-slate-900 text-slate-350 hover:bg-slate-900/40 hover:text-slate-200'">
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
                                        <svg class="w-3 h-3" :class="currentLesson && currentLesson.id === {{ $les->id }} ? 'text-purple-400' : 'text-slate-555'" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                    @endif
                                </div>
                                <span class="text-xs font-bold truncate leading-none mt-0.5">{{ $les->title }}</span>
                            </div>
                                <span class="text-[10px] font-semibold text-slate-500 flex-shrink-0 uppercase">{{ $les->type }}</span>
                                @if(Auth::id() === $course->teacher_id || Auth::user()->isAdmin())
                                    <form action="{{ route('courses.documents.destroy', $les->id) }}" method="POST" onsubmit="return confirm('Delete this lesson?');" class="m-0 ml-2 flex-shrink-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-400 bg-red-500/10 p-1.5 rounded-lg">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                
                @if(Auth::id() === $course->teacher_id || Auth::user()->isAdmin())
                    <div class="mt-4 pt-4 border-t border-slate-900">
                        <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-3">Add Lesson</h4>
                        <form action="{{ route('courses.documents.store', $course->id) }}" method="POST" class="space-y-3">
                            @csrf
                            <input type="text" name="title" placeholder="Lesson Title" required class="w-full text-xs bg-slate-950/80 border border-slate-800 focus:border-purple-500 text-slate-350 rounded-xl py-2 px-3 focus:outline-none">
                            <input type="text" name="file_path" placeholder="URL or Path (e.g. https://...)" required class="w-full text-xs bg-slate-950/80 border border-slate-800 focus:border-purple-500 text-slate-350 rounded-xl py-2 px-3 focus:outline-none">
                            <div class="flex gap-2">
                                <select name="type" class="flex-1 text-xs bg-slate-950/80 border border-slate-800 focus:border-purple-500 text-slate-350 rounded-xl py-2 px-3 focus:outline-none">
                                    <option value="video">Video</option>
                                    <option value="pdf">PDF</option>
                                    <option value="link">Link</option>
                                </select>
                                <button type="submit" class="px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white text-xs font-bold rounded-xl shadow-glow transition-all">+</button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="mt-4 pt-4 border-t border-slate-900 text-center">
                        @if ($quizzes->count() == 0)
                            <a href="{{ route('quizzes.create', ['course_id' => $course->id]) }}" class="w-full inline-block px-4 py-2.5 bg-gradient-to-r from-pink-500 to-purple-500 hover:from-pink-400 hover:to-purple-400 text-white text-xs font-bold rounded-xl shadow-glow transition-all">
                                + Add Evaluation Quiz
                            </a>
                        @else
                            <a href="{{ route('quizzes.edit', $quizzes->first()->id) }}" class="w-full inline-block px-4 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-bold rounded-xl transition-all border border-slate-700">
                                Edit Course Evaluation
                            </a>
                        @endif
                    </div>
                @endif
            </x-glass-card>

        </div>

    </div>

</x-app-layout>

<script>
    function classroomData() {
        return {
            currentLesson: @json($lessons->first() ?? null),
            getEmbedUrl(url) {
                if (!url) return '';
                if (url.includes('youtube.com/watch?v=')) return url.replace('watch?v=', 'embed/').split('&')[0];
                if (url.includes('youtu.be/')) return url.replace('youtu.be/', 'youtube.com/embed/').split('?')[0];
                return url;
            }
        }
    }
</script>
