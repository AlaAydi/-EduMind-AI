<x-app-layout :title="'Edit Course Syllabus - EduMind AI'">
    
    <!-- Breadcrumbs -->
    <div class="mb-6 relative z-10">
        <a href="{{ route('courses.show', $course->id) }}" class="text-xs text-purple-400 hover:underline flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Course
        </a>
    </div>

    <!-- Scaffolding -->
    <div class="max-w-3xl mx-auto relative z-10">
        
        <x-glass-card class="p-8">
            <div class="mb-8 border-b border-slate-900 pb-5">
                <h2 class="text-xl font-extrabold text-white">Edit Course Syllabus</h2>
                <p class="text-xs text-slate-500 mt-1">Update parameters for {{ $course->title }}.</p>
            </div>

            <form action="{{ route('courses.update', $course->id) }}" method="POST" class="space-y-6 m-0 p-0">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div>
                    <x-input-label for="title" :value="__('Course Title')" />
                    <x-text-input id="title" name="title" class="block w-full text-xs py-2.5 px-3" type="text" required value="{{ $course->title }}" />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <!-- Grid columns -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Category -->
                    <div>
                        <x-input-label for="category_id" :value="__('Syllabus Category')" />
                        <select id="category_id" name="category_id" class="bg-slate-950/80 border-slate-800 text-slate-350 focus:border-purple-500 focus:ring-purple-500/30 rounded-xl shadow-sm transition-all duration-300 w-full text-xs font-semibold py-2.5 px-3 focus:outline-none" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $course->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <!-- Level -->
                    <div>
                        <x-input-label for="level" :value="__('Difficulty Level')" />
                        <select id="level" name="level" class="bg-slate-950/80 border-slate-800 text-slate-355 focus:border-purple-500 focus:ring-purple-500/30 rounded-xl shadow-sm transition-all duration-300 w-full text-xs font-semibold py-2.5 px-3 focus:outline-none" required>
                            <option value="Beginner" {{ $course->level == 'Beginner' ? 'selected' : '' }}>Beginner</option>
                            <option value="Intermediate" {{ $course->level == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                            <option value="Advanced" {{ $course->level == 'Advanced' ? 'selected' : '' }}>Advanced</option>
                        </select>
                        <x-input-error :messages="$errors->get('level')" class="mt-2" />
                    </div>
                </div>

                <!-- Duration and Thumbnail -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Duration -->
                    <div>
                        <x-input-label for="duration" :value="__('Syllabus Duration')" />
                        <x-text-input id="duration" name="duration" class="block w-full text-xs py-2.5 px-3" type="text" required value="{{ $course->duration }}" />
                        <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                    </div>

                    <!-- Thumbnail URL -->
                    <div>
                        <x-input-label for="thumbnail" :value="__('Thumbnail Image URL')" />
                        <x-text-input id="thumbnail" name="thumbnail" class="block w-full text-xs py-2.5 px-3" type="url" value="{{ $course->thumbnail }}" />
                        <x-input-error :messages="$errors->get('thumbnail')" class="mt-2" />
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <x-input-label for="description" :value="__('Description')" />
                    <textarea id="description" name="description" rows="5" class="bg-slate-950/80 border-slate-800 text-slate-200 placeholder-slate-700 focus:border-purple-500 focus:ring-purple-500/30 rounded-xl shadow-sm transition-all duration-300 w-full text-xs p-3 focus:outline-none" required>{{ $course->description }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <!-- CTAs -->
                <div class="pt-4 border-t border-slate-900/60 flex items-center justify-end gap-3">
                    <a href="{{ route('courses.show', $course->id) }}" class="px-5 py-2.5 rounded-xl border border-slate-850 hover:bg-slate-900 text-slate-400 hover:text-white transition-colors text-xs font-bold">
                        Cancel
                    </a>
                    <x-primary-button>
                        Update Syllabus
                    </x-primary-button>
                </div>
            </form>
        </x-glass-card>

    </div>

</x-app-layout>
