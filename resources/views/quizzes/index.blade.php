<x-app-layout :title="'Active Evaluations - EduMind AI'">
    
    <!-- Header -->
    <div class="mb-8 relative z-10">
        <span class="text-xs font-bold text-purple-400 uppercase tracking-widest">Academic Testing</span>
        <h2 class="text-3xl font-extrabold text-white mt-1">Quizzes & Evaluations</h2>
        <p class="text-xs text-slate-450 mt-1">Complete course quizzes to unlock certified credentials and earn progression XP.</p>
    </div>

    <!-- Main Grid scaffolding -->
    <div class="relative z-10 space-y-6">
        
        <!-- Table Card -->
        <x-glass-card class="overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-slate-950/60 text-slate-450 border-b border-slate-900 uppercase font-bold text-[10px] tracking-wider">
                            <th class="py-4 px-5">Quiz Title</th>
                            <th class="py-4 px-5">Course Syllabus</th>
                            <th class="py-4 px-5 text-center">Passing Requirement</th>
                            @if (auth()->user()->isStudent())
                                <th class="py-4 px-5 text-center">Status</th>
                                <th class="py-4 px-5 text-center">Attempts</th>
                                <th class="py-4 px-5 text-center">Highest Score</th>
                            @endif
                            <th class="py-4 px-5 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-900/60">
                        @forelse ($quizzes as $quiz)
                            @php
                                $quizAttempts = isset($attempts[$quiz->id]) ? $attempts[$quiz->id] : collect();
                                $hasPassed = $quizAttempts->where('passed', true)->isNotEmpty();
                                $highestScore = $quizAttempts->max('score');
                                $attemptsCount = $quizAttempts->count();
                            @endphp
                            <tr class="hover:bg-slate-900/10 transition-colors">
                                <td class="py-4 px-5 font-bold text-slate-200">{{ $quiz->title }}</td>
                                <td class="py-4 px-5 text-slate-400 font-semibold">{{ $quiz->course->title }}</td>
                                <td class="py-4 px-5 text-center text-slate-400 font-bold">{{ $quiz->passing_score }}%</td>
                                
                                @if (auth()->user()->isStudent())
                                    <td class="py-4 px-5 text-center">
                                        @if ($attemptsCount == 0)
                                            <x-gradient-badge type="slate">Unattempted</x-gradient-badge>
                                        @elseif ($hasPassed)
                                            <x-gradient-badge type="emerald">Passed</x-gradient-badge>
                                        @else
                                            <x-gradient-badge type="rose">Failed</x-gradient-badge>
                                        @endif
                                    </td>
                                    <td class="py-4 px-5 text-center text-slate-500 font-bold">{{ $attemptsCount }}</td>
                                    <td class="py-4 px-5 text-center font-bold {{ $hasPassed ? 'text-emerald-450' : ($attemptsCount > 0 ? 'text-rose-400' : 'text-slate-500') }}">
                                        {{ $attemptsCount > 0 ? $highestScore . '%' : '-' }}
                                    </td>
                                @endif

                                <td class="py-4 px-5 text-center">
                                    @if (auth()->user()->isTeacher())
                                        <a href="{{ route('quizzes.show', $quiz->id) }}" class="px-3.5 py-1.5 rounded-lg border border-slate-800 bg-slate-950 hover:bg-slate-900 text-[11px] font-bold text-slate-350 hover:text-white transition-all inline-block">
                                            Preview
                                        </a>
                                    @else
                                        <a href="{{ route('quizzes.show', $quiz->id) }}" class="px-3.5 py-1.5 rounded-lg text-[11px] font-bold text-white transition-all inline-block {{ $hasPassed ? 'border border-emerald-500/20 bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/25' : 'bg-purple-500 hover:bg-purple-600 shadow-glow shadow-purple-500/10 hover:shadow-purple-500/20' }}">
                                            {{ $hasPassed ? 'Retake (Pass)' : ($attemptsCount > 0 ? 'Try Again' : 'Take Exam') }}
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->isStudent() ? 7 : 4 }}" class="py-8 text-center text-slate-500">
                                    No evaluations available. Make sure you enroll in courses to see their quizzes.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-glass-card>

    </div>

</x-app-layout>
