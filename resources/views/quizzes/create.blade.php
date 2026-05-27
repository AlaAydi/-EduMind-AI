<x-app-layout :title="'Create Quiz - EduMind AI'">
    <div class="mb-6 relative z-10">
        <a href="{{ route('quizzes.index') }}" class="text-xs text-purple-400 hover:underline flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Quizzes
        </a>
    </div>

    <div class="max-w-3xl mx-auto relative z-10">
        <x-glass-card class="p-8">
            <div class="mb-8 border-b border-slate-900 pb-5">
                <h2 class="text-xl font-extrabold text-white">Design New Quiz Evaluation</h2>
                <p class="text-xs text-slate-500 mt-1">Specify parameters for a new course evaluation.</p>
            </div>

            <form action="{{ route('quizzes.store') }}" method="POST" class="space-y-6 m-0 p-0">
                @csrf
                <div>
                    <x-input-label for="title" :value="__('Quiz Title')" />
                    <x-text-input id="title" name="title" class="block w-full text-xs py-2.5 px-3" type="text" required autofocus placeholder="e.g. Midterm Evaluation" />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="course_id" :value="__('Linked Course')" />
                        <select id="course_id" name="course_id" required class="bg-slate-950/80 border-slate-800 text-slate-350 focus:border-purple-500 focus:ring-purple-500 rounded-xl w-full text-xs font-semibold py-2.5 px-3 focus:outline-none">
                            <option value="">Select a course...</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}" {{ (isset($selectedCourseId) && $selectedCourseId == $course->id) ? 'selected' : '' }}>
                                    {{ $course->title }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('course_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="passing_score" :value="__('Passing Score (%)')" />
                        <x-text-input id="passing_score" name="passing_score" class="block w-full text-xs py-2.5 px-3" type="number" min="0" max="100" required value="70" />
                        <x-input-error :messages="$errors->get('passing_score')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="description" :value="__('Description')" />
                    <textarea id="description" name="description" rows="3" class="bg-slate-950/80 border-slate-800 text-slate-200 placeholder-slate-700 focus:border-purple-500 focus:ring-purple-500/30 rounded-xl shadow-sm transition-all duration-300 w-full text-xs p-3 focus:outline-none" required placeholder="Write a description..."></textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <!-- Questions Section -->
                <div x-data="{
                    questions: [
                        {
                            question_text: '',
                            option_a: '',
                            option_b: '',
                            option_c: '',
                            option_d: '',
                            correct_options: []
                        }
                    ],
                    addQuestion() {
                        this.questions.push({
                            question_text: '',
                            option_a: '',
                            option_b: '',
                            option_c: '',
                            option_d: '',
                            correct_options: []
                        });
                    },
                    removeQuestion(index) {
                        this.questions.splice(index, 1);
                    }
                }" class="space-y-6 pt-6 border-t border-slate-900">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-bold text-white uppercase tracking-wider">Evaluation Questions</h3>
                        <button type="button" @click="addQuestion()" class="px-3 py-1.5 bg-purple-500/10 border border-purple-500/20 text-purple-400 hover:bg-purple-500/20 rounded-xl text-xs font-extrabold transition-all flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add Question
                        </button>
                    </div>

                    <div class="space-y-6">
                        <template x-for="(question, index) in questions" :key="index">
                            <div class="p-6 bg-slate-950/40 border border-slate-900/60 rounded-2xl space-y-4 relative">
                                <!-- Remove Button -->
                                <button type="button" @click="removeQuestion(index)" x-show="questions.length > 1" class="absolute top-4 right-4 text-slate-500 hover:text-red-400 transition-colors" title="Remove question">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>

                                <div class="flex items-center gap-2 mb-2">
                                    <span class="w-6 h-6 rounded-lg bg-purple-500/10 border border-purple-500/20 flex items-center justify-center font-bold text-xs text-purple-400" x-text="index + 1"></span>
                                    <span class="text-xs font-bold text-slate-300">Question Details</span>
                                </div>

                                <!-- Question Text -->
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 mb-1.5">Question Text</label>
                                    <input type="text" :name="'questions[' + index + '][question_text]'" x-model="question.question_text" class="bg-slate-950/80 border-slate-800 text-slate-200 placeholder-slate-700 focus:border-purple-500 focus:ring-purple-500/30 rounded-xl shadow-sm transition-all duration-300 w-full text-xs p-2.5 focus:outline-none" required placeholder="e.g. What are the principles of OOP?">
                                </div>

                                <!-- Options Grid -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Option A -->
                                    <div>
                                        <label class="block text-xs font-bold text-slate-400 mb-1.5">Option A</label>
                                        <input type="text" :name="'questions[' + index + '][option_a]'" x-model="question.option_a" class="bg-slate-950/80 border-slate-800 text-slate-200 placeholder-slate-700 focus:border-purple-500 focus:ring-purple-500/30 rounded-xl shadow-sm transition-all duration-300 w-full text-xs p-2.5 focus:outline-none" required placeholder="First option">
                                    </div>
                                    <!-- Option B -->
                                    <div>
                                        <label class="block text-xs font-bold text-slate-400 mb-1.5">Option B</label>
                                        <input type="text" :name="'questions[' + index + '][option_b]'" x-model="question.option_b" class="bg-slate-950/80 border-slate-800 text-slate-200 placeholder-slate-700 focus:border-purple-500 focus:ring-purple-500/30 rounded-xl shadow-sm transition-all duration-300 w-full text-xs p-2.5 focus:outline-none" required placeholder="Second option">
                                    </div>
                                    <!-- Option C -->
                                    <div>
                                        <label class="block text-xs font-bold text-slate-400 mb-1.5">Option C</label>
                                        <input type="text" :name="'questions[' + index + '][option_c]'" x-model="question.option_c" class="bg-slate-950/80 border-slate-800 text-slate-200 placeholder-slate-700 focus:border-purple-500 focus:ring-purple-500/30 rounded-xl shadow-sm transition-all duration-300 w-full text-xs p-2.5 focus:outline-none" required placeholder="Third option">
                                    </div>
                                    <!-- Option D -->
                                    <div>
                                        <label class="block text-xs font-bold text-slate-400 mb-1.5">Option D</label>
                                        <input type="text" :name="'questions[' + index + '][option_d]'" x-model="question.option_d" class="bg-slate-950/80 border-slate-800 text-slate-200 placeholder-slate-700 focus:border-purple-500 focus:ring-purple-500/30 rounded-xl shadow-sm transition-all duration-300 w-full text-xs p-2.5 focus:outline-none" required placeholder="Fourth option">
                                    </div>
                                </div>

                                <!-- Correct Options (Checkboxes) -->
                                <div>
                                    <span class="block text-xs font-bold text-slate-400 mb-2">Select Correct Option(s)</span>
                                    <div class="flex flex-wrap gap-4">
                                        <label class="inline-flex items-center gap-2 cursor-pointer bg-slate-950/80 border border-slate-850 hover:border-purple-500/35 px-4 py-2 rounded-xl text-xs text-slate-300 transition-all">
                                            <input type="checkbox" :name="'questions[' + index + '][correct_options][]'" value="A" x-model="question.correct_options" class="rounded border-slate-800 text-purple-600 focus:ring-purple-500 bg-slate-950">
                                            <span>Option A</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2 cursor-pointer bg-slate-950/80 border border-slate-850 hover:border-purple-500/35 px-4 py-2 rounded-xl text-xs text-slate-300 transition-all">
                                            <input type="checkbox" :name="'questions[' + index + '][correct_options][]'" value="B" x-model="question.correct_options" class="rounded border-slate-800 text-purple-600 focus:ring-purple-500 bg-slate-950">
                                            <span>Option B</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2 cursor-pointer bg-slate-950/80 border border-slate-850 hover:border-purple-500/35 px-4 py-2 rounded-xl text-xs text-slate-300 transition-all">
                                            <input type="checkbox" :name="'questions[' + index + '][correct_options][]'" value="C" x-model="question.correct_options" class="rounded border-slate-800 text-purple-600 focus:ring-purple-500 bg-slate-950">
                                            <span>Option C</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2 cursor-pointer bg-slate-950/80 border border-slate-850 hover:border-purple-500/35 px-4 py-2 rounded-xl text-xs text-slate-300 transition-all">
                                            <input type="checkbox" :name="'questions[' + index + '][correct_options][]'" value="D" x-model="question.correct_options" class="rounded border-slate-800 text-purple-600 focus:ring-purple-500 bg-slate-950">
                                            <span>Option D</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-900/60 flex items-center justify-end gap-3">
                    <a href="{{ route('quizzes.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-850 hover:bg-slate-900 text-slate-400 hover:text-white transition-colors text-xs font-bold">
                        Cancel
                    </a>
                    <x-primary-button>
                        Create Quiz
                    </x-primary-button>
                </div>
            </form>
        </x-glass-card>
    </div>
</x-app-layout>
