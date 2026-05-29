<x-app-layout :title="'Edit Quiz - EduMind AI'">
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
                <h2 class="text-xl font-extrabold text-white">Edit Quiz Evaluation</h2>
                <p class="text-xs text-slate-500 mt-1">Update parameters for {{ $quiz->title }}.</p>
            </div>

            <form action="{{ route('quizzes.update', $quiz->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- TITLE -->
                <div>
                    <x-input-label for="title" :value="__('Quiz Title')" />
                    <x-text-input id="title" name="title" class="block w-full text-xs py-2.5 px-3" type="text" required value="{{ $quiz->title }}" />
                </div>

                <!-- COURSE + SCORE -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <x-input-label for="course_id" :value="__('Linked Course')" />
                        <select id="course_id" name="course_id" class="bg-slate-950/80 border-slate-800 rounded-xl w-full text-xs py-2.5 px-3">
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ $quiz->course_id == $course->id ? 'selected' : '' }}>
                                    {{ $course->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="passing_score" :value="__('Passing Score (%)')" />
                        <x-text-input id="passing_score" name="passing_score" type="number" min="0" max="100"
                            class="block w-full text-xs py-2.5 px-3"
                            value="{{ $quiz->passing_score }}" />
                    </div>

                </div>

                <!-- DESCRIPTION -->
                <div>
                    <x-input-label for="description" :value="__('Description')" />
                    <textarea id="description" name="description" rows="3"
                        class="bg-slate-950/80 border-slate-800 text-slate-200 rounded-xl w-full text-xs p-3">
                        {{ $quiz->description }}
                    </textarea>
                </div>

                @php
                    $initialQuestions = $quiz->questions->map(function ($q) {
                        return [
                            'question_text' => $q->question_text,
                            'option_a' => $q->option_a,
                            'option_b' => $q->option_b,
                            'option_c' => $q->option_c,
                            'option_d' => $q->option_d,
                            'correct_options' => explode(',', $q->correct_option),
                        ];
                    });

                    if ($initialQuestions->isEmpty()) {
                        $initialQuestions = [[
                            'question_text' => '',
                            'option_a' => '',
                            'option_b' => '',
                            'option_c' => '',
                            'option_d' => '',
                            'correct_options' => []
                        ]];
                    }
                @endphp

                <!-- QUESTIONS -->
                <div x-data="{
                    questions: @json($initialQuestions),
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

                    <h3 class="text-sm font-bold text-white">Questions</h3>

                    <template x-for="(question, index) in questions" :key="index">
                        <div class="p-6 bg-slate-950/40 border border-slate-900 rounded-xl space-y-4">

                            <!-- QUESTION -->
                            <div>
                                <label :for="'question_' + index" class="block text-xs font-bold text-slate-400">
                                    Question Text
                                </label>
                                <input
                                    :id="'question_' + index"
                                    type="text"
                                    :name="'questions[' + index + '][question_text]'"
                                    x-model="question.question_text"
                                    class="w-full text-xs p-2.5 rounded-xl bg-slate-950/80 border border-slate-800"
                                    required>
                            </div>

                            <!-- OPTIONS -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                <div>
                                    <label :for="'a_' + index">Option A</label>
                                    <input :id="'a_' + index"
                                           :name="'questions[' + index + '][option_a]'"
                                           x-model="question.option_a"
                                           class="w-full text-xs p-2.5 rounded-xl bg-slate-950/80 border border-slate-800">
                                </div>

                                <div>
                                    <label :for="'b_' + index">Option B</label>
                                    <input :id="'b_' + index"
                                           :name="'questions[' + index + '][option_b]'"
                                           x-model="question.option_b"
                                           class="w-full text-xs p-2.5 rounded-xl bg-slate-950/80 border border-slate-800">
                                </div>

                                <div>
                                    <label :for="'c_' + index">Option C</label>
                                    <input :id="'c_' + index"
                                           :name="'questions[' + index + '][option_c]'"
                                           x-model="question.option_c"
                                           class="w-full text-xs p-2.5 rounded-xl bg-slate-950/80 border border-slate-800">
                                </div>

                                <div>
                                    <label :for="'d_' + index">Option D</label>
                                    <input :id="'d_' + index"
                                           :name="'questions[' + index + '][option_d]'"
                                           x-model="question.option_d"
                                           class="w-full text-xs p-2.5 rounded-xl bg-slate-950/80 border border-slate-800">
                                </div>
                            </div>

                            <!-- CORRECT OPTIONS -->
                            <div>
                                <span class="block text-xs font-bold text-slate-400 mb-2">
                                    Select Correct Option(s)
                                </span>

                                <label>
                                    <input type="checkbox"
                                           :name="'questions[' + index + '][correct_options][]'"
                                           value="A"
                                           x-model="question.correct_options">
                                    A
                                </label>

                                <label>
                                    <input type="checkbox"
                                           :name="'questions[' + index + '][correct_options][]'"
                                           value="B"
                                           x-model="question.correct_options">
                                    B
                                </label>

                                <label>
                                    <input type="checkbox"
                                           :name="'questions[' + index + '][correct_options][]'"
                                           value="C"
                                           x-model="question.correct_options">
                                    C
                                </label>

                                <label>
                                    <input type="checkbox"
                                           :name="'questions[' + index + '][correct_options][]'"
                                           value="D"
                                           x-model="question.correct_options">
                                    D
                                </label>
                            </div>

                        </div>
                    </template>
                </div>

                <!-- BUTTONS -->
                <div class="flex justify-end gap-3 pt-6">
                    <a href="{{ route('quizzes.index') }}" class="px-5 py-2 rounded-xl border text-xs">
                        Cancel
                    </a>
                    <button class="px-5 py-2 rounded-xl bg-purple-600 text-white text-xs font-bold">
                        Update Quiz
                    </button>
                </div>

            </form>
        </x-glass-card>
    </div>
</x-app-layout>
