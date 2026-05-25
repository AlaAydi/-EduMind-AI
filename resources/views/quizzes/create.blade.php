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
                        <select id="course_id" name="course_id" class="bg-slate-950/80 border-slate-800 text-slate-350 focus:border-purple-500 focus:ring-purple-500/30 rounded-xl shadow-sm transition-all duration-300 w-full text-xs font-semibold py-2.5 px-3 focus:outline-none" required>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->title }}</option>
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
