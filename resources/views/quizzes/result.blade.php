<x-app-layout :title="'Scorecard - ' . $quiz->title">
    
    <!-- Scaffolding -->
    <div class="max-w-xl mx-auto relative z-10 py-6">
        
        <x-glass-card class="p-8 text-center {{ $attempt->passed ? 'border-emerald-500/10 shadow-glow shadow-emerald-500/5' : 'border-rose-500/10 shadow-glow shadow-rose-500/5' }}">
            
            <div class="mb-6">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">{{ $quiz->course->title }}</span>
                <h2 class="text-lg font-extrabold text-white mt-1">{{ $quiz->title }}</h2>
            </div>

            <!-- Score Circle -->
            <div class="w-36 h-36 rounded-full flex flex-col items-center justify-center mx-auto mb-8 border relative z-10 {{ $attempt->passed ? 'border-emerald-500/20 bg-emerald-500/5 text-emerald-400' : 'border-rose-500/20 bg-rose-500/5 text-rose-450' }}">
                <span class="text-3xl font-black">{{ $attempt->score }}%</span>
                <span class="text-[9px] font-bold uppercase tracking-wider mt-1">Syllabus Score</span>
                <!-- glowing backdrop -->
                <div class="absolute inset-0 rounded-full blur-xl opacity-30 z-0 {{ $attempt->passed ? 'bg-emerald-500' : 'bg-rose-500' }}"></div>
            </div>

            <!-- Result Header Banner -->
            <div class="mb-8">
                @if ($attempt->passed)
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-full text-xs font-extrabold uppercase tracking-wide">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Evaluation Passed
                    </div>
                    <p class="text-xs text-slate-400 mt-4 leading-relaxed max-w-sm mx-auto">
                        Excellent job! You have surpassed the <span class="font-bold text-slate-300">{{ $quiz->passing_score }}%</span> requirement, updating your syllabus completion metrics.
                    </p>
                @else
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-rose-500/10 border border-rose-500/20 text-rose-400 rounded-full text-xs font-extrabold uppercase tracking-wide">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        Evaluation Failed
                    </div>
                    <p class="text-xs text-slate-400 mt-4 leading-relaxed max-w-sm mx-auto">
                        Your score is below the <span class="font-bold text-slate-350">{{ $quiz->passing_score }}%</span> passing threshold. Review lesson files and try again to unlock XP milestones.
                    </p>
                @endif
            </div>

            <!-- Stats grid -->
            <div class="grid grid-cols-2 gap-4 mb-8 text-center text-xs border-y border-slate-900 py-4">
                <div>
                    <span class="text-slate-500 font-bold uppercase tracking-wider block text-[9px]">Attempts logs</span>
                    <span class="text-sm font-bold text-slate-300 mt-1 block">Attempt #{{ auth()->user()->quizAttempts->where('quiz_id', $quiz->id)->count() }}</span>
                </div>
                <div>
                    <span class="text-slate-500 font-bold uppercase tracking-wider block text-[9px]">XP Accumulated</span>
                    <span class="text-sm font-bold text-purple-400 mt-1 block">+{{ $attempt->passed ? '200 XP' : '0 XP' }}</span>
                </div>
            </div>

            <!-- CTA Actions -->
            <div class="space-y-3">
                <a href="{{ route('courses.show', $quiz->course_id) }}" class="w-full py-3 bg-gradient-to-r from-purple-500 to-indigo-500 text-white font-extrabold text-xs rounded-xl text-center block shadow-glow shadow-purple-500/10 hover:shadow-purple-500/20 hover:-translate-y-0.5 transition-all">
                    Return to Classroom
                </a>
                @if (!$attempt->passed)
                    <a href="{{ route('quizzes.take', $quiz->id) }}" class="w-full py-3 bg-slate-950 border border-slate-850 hover:bg-slate-900 text-slate-300 hover:text-white font-bold text-xs rounded-xl text-center block transition-all">
                        Retake Assessment
                    </a>
                @endif
                <a href="{{ route('quizzes.index') }}" class="w-full py-2.5 text-xs text-slate-500 hover:text-slate-300 font-bold text-center block transition-colors">
                    Back to Quizzes
                </a>
            </div>

        </x-glass-card>

    </div>

</x-app-layout>
