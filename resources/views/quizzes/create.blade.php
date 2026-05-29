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

            <form action="{{ route('quizzes.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- TITLE -->
                <div>
                    <label for="title" class="block text-xs font-bold text-slate-400 mb-1">
                        Quiz Title
                    </label>
                    <input id="title" name="title" type="text"
                        class="w-full text-xs p-2.5 rounded-xl bg-slate-950/80 border border-slate-800"
                        required placeholder="e.g. Midterm Evaluation">
                </div>

                <!-- COURSE -->
                <div>
                    <label for="course_id" class="block text-xs font-bold text-slate-400 mb-1">
                        Linked Course
                    </label>
                    <select id="course_id" name="course_id"
                        class="w-full text-xs p-2.5 rounded-xl bg-slate-950/80 border border-slate-800"
                        required>
                        <option value="">Select a course...</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- SCORE -->
                <div>
                    <label for="passing_score" class="block text-xs font-bold text-slate-400 mb-1">
                        Passing Score (%)
                    </label>
                    <input id="passing_score" name="passing_score" type="number" min="0" max="100"
                        value="70"
                        class="w-full text-xs p-2.5 rounded-xl bg-slate-950/80 border border-slate-800">
                </div>

                <!-- DESCRIPTION -->
                <div>
                    <label for="description" class="block text-xs font-bold text-slate-400 mb-1">
                        Description
                    </label>
                    <textarea id="description" name="description" rows="3"
                        class="w-full text-xs p-2.5 rounded-xl bg-slate-950/80 border border-slate-800"
                        placeholder="Write a description..."></textarea>
                </div>

                <!-- QUESTIONS -->
                <div x-data="{
                    questions: [{
                        question_text: '',
                        option_a: '',
                        option_b: '',
                        option_c: '',
                        option_d: '',
                        correct_options: []
                    }],
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

                    <div class="flex justify-between items-center">
                        <h3 class="text-sm font-bold text-white">Questions</h3>

                        <button type="button" @click="addQuestion()"
                            class="px-3 py-1.5 text-xs text-purple-400 border border-purple-500/20 rounded-xl">
                            + Add Question
                        </button>
                    </div>

                    <template x-for="(question, index) in questions" :key="index">

                        <div class="p-6 bg-slate-950/40 border border-slate-900 rounded-xl space-y-4">

                            <!-- QUESTION -->
                            <div>
                                <label :for="'q_' + index" class="block text-xs text-slate-400">
                                    Question Text
                                </label>
                                <input :id="'q_' + index"
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

                            <!-- CHECKBOXES -->
                            <div>
                                <span class="block text-xs text-slate-400 mb-2">
                                    Correct Options
                                </span>

                                <label :for="'a_c_' + index">
                                    <input :id="'a_c_' + index" type="checkbox"
                                        value="A"
                                        :name="'questions[' + index + '][correct_options][]'"
                                        x-model="question.correct_options">
                                    A
                                </label>

                                <label :for="'b_c_' + index">
                                    <input :id="'b_c_' + index" type="checkbox"
                                        value="B"
                                        :name="'questions[' + index + '][correct_options][]'"
                                        x-model="question.correct_options">
                                    B
                                </label>

                                <label :for="'c_c_' + index">
                                    <input :id="'c_c_' + index" type="checkbox"
                                        value="C"
                                        :name="'questions[' + index + '][correct_options][]'"
                                        x-model="question.correct_options">
                                    C
                                </label>

                                <label :for="'d_c_' + index">
                                    <input :id="'d_c_' + index" type="checkbox"
                                        value="D"
                                        :name="'questions[' + index + '][correct_options][]'"
                                        x-model="question.correct_options">
                                    D
                                </label>
                            </div>

                        </div>

                    </template>

                </div>

                <!-- BUTTON -->
                <div class="pt-4 flex justify-end">
                    <button class="px-5 py-2 text-xs bg-purple-600 text-white rounded-xl">
                        Create Quiz
                    </button>
                </div>

            </form>

        </x-glass-card>
    </div>
</x-app-layout>
