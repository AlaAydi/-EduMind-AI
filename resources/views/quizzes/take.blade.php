<x-app-layout :title="'Active Exam - ' . $quiz->title">
    
    <!-- Title and Status -->
    <div class="mb-8 flex items-center justify-between gap-6 relative z-10">
        <div>
            <span class="text-xs font-bold text-pink-400 uppercase tracking-widest animate-pulse">EXAM IN PROGRESS</span>
            <h2 class="text-xl font-extrabold text-white mt-1">{{ $quiz->title }}</h2>
        </div>
        
        <!-- Live status pill -->
        <div class="px-3.5 py-1.5 rounded-full bg-slate-900 border border-slate-800 text-[10px] font-bold text-slate-400 flex items-center gap-2">
            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-ping"></span>
            Auto-Saving Node
        </div>
    </div>

    <!-- Active Form Wrapper -->
    <form action="{{ route('quizzes.submit', $quiz->id) }}" method="POST" class="max-w-3xl mx-auto relative z-10 m-0 p-0">
        @csrf

        <div class="space-y-8">
            @foreach ($questions as $index => $q)
                <x-glass-card class="p-6 md:p-8" x-data="{ selected: [] }">
                    
                    <!-- Question Header -->
                    <div class="flex items-start gap-4 mb-6 border-b border-slate-900 pb-4">
                        <div class="w-7 h-7 rounded-lg bg-purple-500/10 border border-purple-500/25 flex items-center justify-center font-bold text-xs text-purple-400 flex-shrink-0">
                            {{ $index + 1 }}
                        </div>
                        <h3 class="text-sm font-bold text-slate-200 leading-relaxed mt-0.5">{{ $q->question_text }}</h3>
                    </div>

                    <!-- Options Grid -->
                    <div class="space-y-3.5">
                        
                        <!-- Option A -->
                        <label class="block cursor-pointer">
                            <input type="checkbox" name="answers[{{ $q->id }}][]" value="A" class="hidden" x-model="selected">
                            <div class="p-4 rounded-2xl border text-xs font-semibold flex items-center gap-4 transition-all duration-300" 
                                 :class="selected.includes('A') ? 'bg-purple-500/10 border-purple-500 text-purple-300 shadow-glow shadow-purple-500/5' : 'bg-slate-950/40 border-slate-900 hover:bg-slate-900/30 text-slate-400 hover:text-slate-300'">
                                <div class="w-6 h-6 rounded-lg bg-slate-900 border border-slate-850 flex items-center justify-center font-bold text-[10px] flex-shrink-0"
                                     :class="selected.includes('A') ? 'border-purple-450 text-purple-450' : 'text-slate-600'">A</div>
                                <span class="leading-relaxed">{{ $q->option_a }}</span>
                            </div>
                        </label>

                        <!-- Option B -->
                        <label class="block cursor-pointer">
                            <input type="checkbox" name="answers[{{ $q->id }}][]" value="B" class="hidden" x-model="selected">
                            <div class="p-4 rounded-2xl border text-xs font-semibold flex items-center gap-4 transition-all duration-300" 
                                 :class="selected.includes('B') ? 'bg-purple-500/10 border-purple-500 text-purple-300 shadow-glow shadow-purple-500/5' : 'bg-slate-950/40 border-slate-900 hover:bg-slate-900/30 text-slate-400 hover:text-slate-300'">
                                <div class="w-6 h-6 rounded-lg bg-slate-900 border border-slate-850 flex items-center justify-center font-bold text-[10px] flex-shrink-0"
                                     :class="selected.includes('B') ? 'border-purple-450 text-purple-450' : 'text-slate-600'">B</div>
                                <span class="leading-relaxed">{{ $q->option_b }}</span>
                            </div>
                        </label>

                        <!-- Option C -->
                        <label class="block cursor-pointer">
                            <input type="checkbox" name="answers[{{ $q->id }}][]" value="C" class="hidden" x-model="selected">
                            <div class="p-4 rounded-2xl border text-xs font-semibold flex items-center gap-4 transition-all duration-300" 
                                 :class="selected.includes('C') ? 'bg-purple-500/10 border-purple-500 text-purple-300 shadow-glow shadow-purple-500/5' : 'bg-slate-950/40 border-slate-900 hover:bg-slate-900/30 text-slate-400 hover:text-slate-300'">
                                <div class="w-6 h-6 rounded-lg bg-slate-900 border border-slate-850 flex items-center justify-center font-bold text-[10px] flex-shrink-0"
                                     :class="selected.includes('C') ? 'border-purple-450 text-purple-450' : 'text-slate-600'">C</div>
                                <span class="leading-relaxed">{{ $q->option_c }}</span>
                            </div>
                        </label>

                        <!-- Option D -->
                        <label class="block cursor-pointer">
                            <input type="checkbox" name="answers[{{ $q->id }}][]" value="D" class="hidden" x-model="selected">
                            <div class="p-4 rounded-2xl border text-xs font-semibold flex items-center gap-4 transition-all duration-300" 
                                 :class="selected.includes('D') ? 'bg-purple-500/10 border-purple-500 text-purple-300 shadow-glow shadow-purple-500/5' : 'bg-slate-950/40 border-slate-900 hover:bg-slate-900/30 text-slate-400 hover:text-slate-300'">
                                <div class="w-6 h-6 rounded-lg bg-slate-900 border border-slate-850 flex items-center justify-center font-bold text-[10px] flex-shrink-0"
                                     :class="selected.includes('D') ? 'border-purple-450 text-purple-450' : 'text-slate-600'">D</div>
                                <span class="leading-relaxed">{{ $q->option_d }}</span>
                            </div>
                        </label>

                    </div>

                </x-glass-card>
            @endforeach

            <!-- Action submit card -->
            <x-glass-card class="p-6 flex items-center justify-between gap-4">
                <span class="text-xs text-slate-500 font-bold">Answer all questions to finish the submission.</span>
                
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-500 to-indigo-500 text-white font-extrabold text-xs rounded-xl hover:shadow-glow shadow-lg transition-all">
                    Submit and Grade
                </button>
            </x-glass-card>
        </div>

    </form>

</x-app-layout>
