<x-app-layout :title="'Evaluation - ' . $quiz->title">
    
    <!-- Breadcrumbs -->
    <div class="mb-6 relative z-10">
        <a href="{{ route('quizzes.index') }}" class="text-xs text-purple-400 hover:underline flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Evaluations
        </a>
    </div>

    <!-- Scaffolding -->
    <div class="max-w-2xl mx-auto relative z-10">
        
        <x-glass-card class="p-8 border-purple-500/10 shadow-glow shadow-purple-500/5">
            <div class="mb-8 border-b border-slate-900 pb-5 text-center">
                <div class="w-12 h-12 rounded-2xl bg-purple-500/10 border border-purple-500/20 text-purple-400 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2-2 2 0 002 2h2a2 2 0 002-2"/>
                    </svg>
                </div>
                <span class="text-[10px] text-purple-450 font-bold uppercase tracking-widest">{{ $quiz->course->title }}</span>
                <h2 class="text-xl font-extrabold text-white mt-2">{{ $quiz->title }}</h2>
                <p class="text-xs text-slate-550 mt-1">Please read the syllabus exam instructions below before initiating execution.</p>
            </div>

            <!-- Exam Details Specs -->
            <div class="grid grid-cols-3 gap-6 mb-8 border-b border-slate-900 pb-6 text-center">
                <div class="p-4 bg-slate-950/40 border border-slate-900 rounded-2xl">
                    <span class="text-[10px] text-slate-500 font-extrabold uppercase tracking-wider block">Questions</span>
                    <span class="text-base font-extrabold text-white block mt-1.5">{{ $quiz->questions->count() }} MCQs</span>
                </div>
                <div class="p-4 bg-slate-950/40 border border-slate-900 rounded-2xl">
                    <span class="text-[10px] text-slate-500 font-extrabold uppercase tracking-wider block">Time Limit</span>
                    <span class="text-base font-extrabold text-white block mt-1.5">No Limit</span>
                </div>
                <div class="p-4 bg-slate-950/40 border border-slate-900 rounded-2xl">
                    <span class="text-[10px] text-slate-500 font-extrabold uppercase tracking-wider block">Required</span>
                    <span class="text-base font-extrabold text-purple-400 block mt-1.5">{{ $quiz->passing_score }}% Score</span>
                </div>
            </div>

            <!-- Instructions list -->
            <div class="space-y-4 text-xs text-slate-350 leading-relaxed mb-8">
                <h4 class="font-bold text-slate-200">Evaluation Instructions:</h4>
                <ul class="list-disc pl-5 space-y-2.5">
                    <li>This evaluation checks knowledge nodes accumulated throughout the corresponding chapters.</li>
                    <li>Questions are multiple-choice options (A, B, C, or D). Pick the single most accurate option.</li>
                    <li>You can take this quiz multiple times; however, only scoring above <span class="text-purple-450 font-bold">{{ $quiz->passing_score }}%</span> unlocks XP certificates.</li>
                </ul>
            </div>

            <!-- Action buttons -->
            <div class="flex flex-col gap-3">
                <a href="{{ route('quizzes.take', $quiz->id) }}" class="w-full py-3 bg-gradient-to-r from-purple-500 to-indigo-500 hover:from-purple-650 hover:to-indigo-650 text-white font-extrabold text-sm rounded-xl text-center shadow-glow shadow-purple-500/10 hover:shadow-purple-500/20 hover:-translate-y-0.5 transition-all duration-300">
                    Begin Examination
                </a>
                <a href="{{ route('quizzes.index') }}" class="w-full py-3 bg-slate-950 border border-slate-850 hover:bg-slate-900 text-slate-400 hover:text-white font-bold text-xs rounded-xl text-center transition-all">
                    Cancel and Return
                </a>
            </div>

        </x-glass-card>

    </div>

</x-app-layout>
