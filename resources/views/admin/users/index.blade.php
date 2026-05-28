<x-admin-layout>
<div class="space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Gestion des utilisateurs</h1>
            <p class="text-gray-400 text-sm mt-1">{{ $users->total() }} utilisateurs au total</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="admin-card p-5">
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-48">
                <label class="form-label">Recherche</label>
                <input name="search" type="text" value="{{ request('search') }}" placeholder="Nom ou email..." class="form-input">
            </div>
            <div>
                <label class="form-label">Rôle</label>
                <select name="role" class="form-input" style="width:150px">
                    <option value="">Tous</option>
                    <option value="teacher" {{ request('role') === 'teacher' ? 'selected' : '' }}>Enseignant</option>
                    <option value="student" {{ request('role') === 'student' ? 'selected' : '' }}>Étudiant</option>
                </select>
            </div>
            <div>
                <label class="form-label">Statut</label>
                <select name="status" class="form-input" style="width:160px">
                    <option value="">Tous</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approuvés</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>En attente</option>
                </select>
            </div>
            <button type="submit" class="btn-primary">🔍 Filtrer</button>
            <a href="{{ route('admin.users.index') }}" class="btn-edit">Réinitialiser</a>
        </form>
    </div>

    <!-- Users Table -->
    <div class="admin-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-white/5">
                        <th class="text-left text-gray-500 font-medium py-4 px-5">Utilisateur</th>
                        <th class="text-left text-gray-500 font-medium py-4 px-5">Email</th>
                        <th class="text-left text-gray-500 font-medium py-4 px-5">Rôle</th>
                        <th class="text-left text-gray-500 font-medium py-4 px-5">Statut</th>
                        <th class="text-left text-gray-500 font-medium py-4 px-5">Inscrit le</th>
                        <th class="text-left text-gray-500 font-medium py-4 px-5">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr class="border-b border-white/5 table-row">
                        <td class="py-3 px-5">
                            <div class="flex items-center gap-3">
                                @if($user->avatar)
                                    <img src="{{ $user->avatar }}" class="w-9 h-9 rounded-full object-cover" alt="">
                                @else
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-violet-500 to-blue-500 flex items-center justify-center text-white font-bold text-sm">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                @endif
                                <span class="text-white font-medium">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="py-3 px-5 text-gray-400">{{ $user->email }}</td>
                        <td class="py-3 px-5">
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium
                                {{ $user->role === 'teacher' ? 'badge-teacher' : 'badge-student' }}">
                                {{ $user->role === 'teacher' ? '🎓 Enseignant' : '🎒 Étudiant' }}
                            </span>
                        </td>
                        <td class="py-3 px-5">
                            @if($user->is_approved)
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium badge-approved">✓ Approuvé</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium badge-pending">⏳ En attente</span>
                            @endif
                        </td>
                        <td class="py-3 px-5 text-gray-500 text-xs">{{ $user->created_at->format('d/m/Y') }}</td>
                        <td class="py-3 px-5">
                            <div class="flex items-center gap-2">
                                @if(!$user->is_approved)
                                <form method="POST" action="{{ route('admin.users.approve', $user) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="btn-success" style="padding:4px 10px;font-size:11px;">✓ Approuver</button>
                                </form>
                                @endif
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn-edit" style="padding:4px 10px;font-size:11px;">✏️ Éditer</a>
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline"
                                      onsubmit="return confirm('Supprimer {{ addslashes($user->name) }} ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-danger" style="padding:4px 10px;font-size:11px;">🗑 Suppr.</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-16 text-gray-500">Aucun utilisateur trouvé.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
        <div class="p-5 border-t border-white/5">
            {{ $users->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

</div>
</x-admin-layout>
