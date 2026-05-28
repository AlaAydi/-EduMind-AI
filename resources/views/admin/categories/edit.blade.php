<x-admin-layout>
<div class="max-w-3xl space-y-6">

    <div class="flex items-center gap-4">
        <a href="{{ route('admin.categories.index') }}" class="text-gray-400 hover:text-white text-sm">← Retour</a>
        <h1 class="text-2xl font-bold text-white">Éditer : {{ $category->name }}</h1>
    </div>

    <div class="admin-card p-8">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="space-y-6">
            @csrf @method('PUT')

            @if($errors->any())
            <div class="alert-error">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Name -->
            <div>
                <label class="form-label">Nom de la catégorie *</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" class="form-input" required>
            </div>

            <!-- Assign Teachers -->
            <div>
                <label class="form-label">🎓 Enseignants affectés</label>
                @if($teachers->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-2 max-h-64 overflow-y-auto pr-1">
                    @foreach($teachers as $teacher)
                    @php $checked = in_array($teacher->id, old('teacher_ids', $assignedUserIds)); @endphp
                    <label class="flex items-center gap-3 p-3 rounded-xl cursor-pointer transition-all"
                           style="background: rgba(255,255,255,0.03); border: 1px solid {{ $checked ? 'rgba(139,92,246,0.4)' : 'rgba(255,255,255,0.07)' }};"
                           onmouseover="this.style.borderColor='rgba(139,92,246,0.3)'"
                           onmouseout="this.style.borderColor='{{ $checked ? 'rgba(139,92,246,0.4)' : 'rgba(255,255,255,0.07)' }}'">
                        <input type="checkbox" name="teacher_ids[]" value="{{ $teacher->id }}"
                               {{ $checked ? 'checked' : '' }}
                               class="w-4 h-4 accent-violet-500">
                        @if($teacher->avatar)
                            <img src="{{ $teacher->avatar }}" class="w-8 h-8 rounded-full object-cover" alt="">
                        @else
                            <div class="w-8 h-8 rounded-full bg-violet-500/30 flex items-center justify-center text-violet-300 text-sm font-bold">
                                {{ substr($teacher->name, 0, 1) }}
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="text-white text-sm font-medium truncate">{{ $teacher->name }}</p>
                            <p class="text-gray-500 text-xs truncate">{{ $teacher->email }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
                @else
                <p class="text-gray-500 text-sm mt-2">Aucun enseignant approuvé disponible.</p>
                @endif
            </div>

            <!-- Assign Students -->
            <div>
                <label class="form-label">🎒 Étudiants affectés</label>
                @if($students->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-2 max-h-64 overflow-y-auto pr-1">
                    @foreach($students as $student)
                    @php $checked = in_array($student->id, old('student_ids', $assignedUserIds)); @endphp
                    <label class="flex items-center gap-3 p-3 rounded-xl cursor-pointer transition-all"
                           style="background: rgba(255,255,255,0.03); border: 1px solid {{ $checked ? 'rgba(16,185,129,0.4)' : 'rgba(255,255,255,0.07)' }};"
                           onmouseover="this.style.borderColor='rgba(16,185,129,0.3)'"
                           onmouseout="this.style.borderColor='{{ $checked ? 'rgba(16,185,129,0.4)' : 'rgba(255,255,255,0.07)' }}'">
                        <input type="checkbox" name="student_ids[]" value="{{ $student->id }}"
                               {{ $checked ? 'checked' : '' }}
                               class="w-4 h-4 accent-emerald-500">
                        @if($student->avatar)
                            <img src="{{ $student->avatar }}" class="w-8 h-8 rounded-full object-cover" alt="">
                        @else
                            <div class="w-8 h-8 rounded-full bg-emerald-500/30 flex items-center justify-center text-emerald-300 text-sm font-bold">
                                {{ substr($student->name, 0, 1) }}
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="text-white text-sm font-medium truncate">{{ $student->name }}</p>
                            <p class="text-gray-500 text-xs truncate">{{ $student->email }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
                @else
                <p class="text-gray-500 text-sm mt-2">Aucun étudiant approuvé disponible.</p>
                @endif
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary">💾 Mettre à jour</button>
                <a href="{{ route('admin.categories.index') }}" class="btn-edit">Annuler</a>
            </div>
        </form>
    </div>
</div>
</x-admin-layout>
