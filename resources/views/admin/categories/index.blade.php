<x-admin-layout>
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Gestion des catégories</h1>
            <p class="text-gray-400 text-sm mt-1">{{ $categories->total() }} catégories</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn-primary">➕ Nouvelle catégorie</a>
    </div>

    <!-- Categories Table -->
    <div class="admin-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-white/5">
                        <th class="text-left text-gray-500 font-medium py-4 px-5">Catégorie</th>
                        <th class="text-left text-gray-500 font-medium py-4 px-5">Slug</th>
                        <th class="text-left text-gray-500 font-medium py-4 px-5">Cours</th>
                        <th class="text-left text-gray-500 font-medium py-4 px-5">Utilisateurs affectés</th>
                        <th class="text-left text-gray-500 font-medium py-4 px-5">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr class="border-b border-white/5 table-row">
                        <td class="py-4 px-5">
                            <span class="text-white font-semibold">{{ $category->name }}</span>
                        </td>
                        <td class="py-4 px-5">
                            <code class="text-xs text-gray-500 bg-white/5 px-2 py-1 rounded">{{ $category->slug }}</code>
                        </td>
                        <td class="py-4 px-5">
                            <span class="text-gray-300 font-medium">{{ $category->courses_count }}</span>
                        </td>
                        <td class="py-4 px-5">
                            <span class="text-gray-300 font-medium">{{ $category->users_count }}</span>
                            <span class="text-gray-600 text-xs ml-1">utilisateurs</span>
                        </td>
                        <td class="py-4 px-5">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn-edit" style="padding:4px 12px;font-size:12px;">✏️ Éditer</a>
                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="inline"
                                      onsubmit="return confirm('Supprimer la catégorie « {{ addslashes($category->name) }} » ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-danger" style="padding:4px 12px;font-size:12px;">🗑 Suppr.</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-16 text-gray-500">
                            Aucune catégorie. <a href="{{ route('admin.categories.create') }}" class="text-violet-400 hover:underline">Créer la première →</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($categories->hasPages())
        <div class="p-5 border-t border-white/5">
            {{ $categories->links() }}
        </div>
        @endif
    </div>

</div>
</x-admin-layout>
