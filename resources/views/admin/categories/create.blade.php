<x-admin-layout>
<div class="max-w-3xl space-y-6">

    <!-- HEADER -->
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.categories.index') }}" class="text-gray-400 hover:text-white text-sm">
            ← Retour
        </a>
        <h1 class="text-2xl font-bold text-white">Nouvelle catégorie</h1>
    </div>

    <!-- CARD -->
    <div class="admin-card p-8">
        <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-6">
            @csrf

            <!-- ERRORS -->
            @if($errors->any())
                <div class="alert-error">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- CATEGORY NAME -->
            <div>
                <label for="name" class="form-label">
                    Nom de la catégorie *
                </label>

                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="form-input"
                    placeholder="Ex : Intelligence Artificielle"
                    required
                >
            </div>

            <!-- TEACHERS -->
            <fieldset>
                <legend class="form-label mb-2">🎓 Affecter des enseignants</legend>

                @if($teachers->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-64 overflow-y-auto pr-1">

                        @foreach($teachers as $teacher)
                            <div class="flex items-center gap-3 p-3 rounded-xl"
                                 style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07);">

                                <!-- CHECKBOX -->
                                <input
                                    id="teacher-{{ $teacher->id }}"
                                    type="checkbox"
                                    name="teacher_ids[]"
                                    value="{{ $teacher->id }}"
                                    {{ in_array($teacher->id, old('teacher_ids', [])) ? 'checked' : '' }}
                                    class="w-4 h-4 accent-violet-500"
                                >

                                <!-- LABEL (accessible only) -->
                                <label for="teacher-{{ $teacher->id }}" class="flex items-center gap-3 cursor-pointer w-full">

                                    @if($teacher->avatar)
                                        <img
                                            src="{{ $teacher->avatar }}"
                                            class="w-8 h-8 rounded-full object-cover"
                                            alt="Avatar de {{ $teacher->name }}"
                                        >
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-violet-500/30 flex items-center justify-center text-violet-300 text-sm font-bold">
                                            {{ substr($teacher->name, 0, 1) }}
                                        </div>
                                    @endif

                                    <div class="flex-1 min-w-0">
                                        <p class="text-white text-sm font-medium truncate">
                                            {{ $teacher->name }}
                                        </p>
                                        <p class="text-gray-500 text-xs truncate">
                                            {{ $teacher->email }}
                                        </p>
                                    </div>

                                </label>

                            </div>
                        @endforeach

                    </div>
                @else
                    <p class="text-gray-500 text-sm mt-2">
                        Aucun enseignant approuvé disponible.
                    </p>
                @endif
            </fieldset>

            <!-- STUDENTS -->
            <fieldset>
                <legend class="form-label mb-2">🎒 Affecter des étudiants</legend>

                @if($students->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-64 overflow-y-auto pr-1">

                        @foreach($students as $student)
                            <div class="flex items-center gap-3 p-3 rounded-xl"
                                 style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07);">

                                <!-- CHECKBOX -->
                                <input
                                    id="student-{{ $student->id }}"
                                    type="checkbox"
                                    name="student_ids[]"
                                    value="{{ $student->id }}"
                                    {{ in_array($student->id, old('student_ids', [])) ? 'checked' : '' }}
                                    class="w-4 h-4 accent-emerald-500"
                                >

                                <!-- LABEL -->
                                <label for="student-{{ $student->id }}" class="flex items-center gap-3 cursor-pointer w-full">

                                    @if($student->avatar)
                                        <img
                                            src="{{ $student->avatar }}"
                                            class="w-8 h-8 rounded-full object-cover"
                                            alt="Avatar de {{ $student->name }}"
                                        >
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-emerald-500/30 flex items-center justify-center text-emerald-300 text-sm font-bold">
                                            {{ substr($student->name, 0, 1) }}
                                        </div>
                                    @endif

                                    <div class="flex-1 min-w-0">
                                        <p class="text-white text-sm font-medium truncate">
                                            {{ $student->name }}
                                        </p>
                                        <p class="text-gray-500 text-xs truncate">
                                            {{ $student->email }}
                                        </p>
                                    </div>

                                </label>

                            </div>
                        @endforeach

                    </div>
                @else
                    <p class="text-gray-500 text-sm mt-2">
                        Aucun étudiant approuvé disponible.
                    </p>
                @endif
            </fieldset>

            <!-- ACTIONS -->
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary">
                    ✅ Créer la catégorie
                </button>

                <a href="{{ route('admin.categories.index') }}" class="btn-edit">
                    Annuler
                </a>
            </div>

        </form>
    </div>
</div>
</x-admin-layout>
