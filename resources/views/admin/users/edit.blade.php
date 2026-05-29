<x-admin-layout>
<div class="max-w-2xl space-y-6">

    <div class="flex items-center gap-4">
        <a href="{{ route('admin.users.index') }}" class="text-gray-400 hover:text-white text-sm">← Retour</a>
        <h1 class="text-2xl font-bold text-white">Éditer l'utilisateur</h1>
    </div>

    <div class="admin-card p-8">
        <div class="flex items-center gap-4 mb-8 pb-6 border-b border-white/5">
            @if($user->avatar)
                <img src="{{ $user->avatar }}" class="w-16 h-16 rounded-2xl object-cover" alt="Avatar utilisateur">
            @else
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-violet-500 to-blue-500 flex items-center justify-center text-white font-bold text-2xl">
                    {{ substr($user->name, 0, 1) }}
                </div>
            @endif
            <div>
                <p class="text-white font-bold text-lg">{{ $user->name }}</p>
                <p class="text-gray-400 text-sm">{{ $user->email }}</p>
                <span class="px-2 py-0.5 rounded-full text-xs font-medium mt-1 inline-block
                    {{ $user->role === 'teacher' ? 'badge-teacher' : 'badge-student' }}">
                    {{ ucfirst($user->role) }}
                </span>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-5">
            @csrf
            @method('PUT')

            @if($errors->any())
            <div class="alert-error">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- NAME -->
            <div>
                <label for="name" class="form-label">Nom complet</label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    class="form-input"
                    required
                >
            </div>

            <!-- EMAIL -->
            <div>
                <label for="email" class="form-label">Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    class="form-input"
                    required
                >
            </div>

            <!-- ROLE -->
            <div>
                <label for="role" class="form-label">Rôle</label>
                <select id="role" name="role" class="form-input">
                    <option value="student" {{ $user->role === 'student' ? 'selected' : '' }}>
                        🎒 Étudiant
                    </option>
                    <option value="teacher" {{ $user->role === 'teacher' ? 'selected' : '' }}>
                        🎓 Enseignant
                    </option>
                </select>
            </div>

            <!-- APPROVAL -->
            <div class="flex items-center gap-4 p-4 rounded-xl"
                 style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07)">

                <input type="hidden" name="is_approved" value="0">

                <input
                    type="checkbox"
                    name="is_approved"
                    id="is_approved"
                    value="1"
                    {{ $user->is_approved ? 'checked' : '' }}
                    class="w-5 h-5 accent-violet-500"
                >

                <div>
                    <label for="is_approved" class="text-white font-medium text-sm cursor-pointer">
                        Compte approuvé
                    </label>
                    <p class="text-gray-500 text-xs mt-0.5">
                        L'utilisateur peut se connecter
                    </p>
                </div>
            </div>

            <!-- PASSWORD -->
            <div>
                <label for="password" class="form-label">
                    Nouveau mot de passe
                    <span class="text-gray-600">(laisser vide pour garder l'actuel)</span>
                </label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    class="form-input"
                    placeholder="••••••••"
                >
            </div>

            <!-- ACTIONS -->
            <div class="flex items-center gap-3 pt-4">
                <button type="submit" class="btn-primary">💾 Enregistrer</button>
                <a href="{{ route('admin.users.index') }}" class="btn-edit">Annuler</a>
            </div>
        </form>
    </div>
</div>
</x-admin-layout>
