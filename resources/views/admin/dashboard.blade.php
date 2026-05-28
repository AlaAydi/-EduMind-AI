<x-admin-layout>
<div class="space-y-8">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-white">Admin Dashboard</h1>
            <p class="text-gray-400 mt-1">Vue d'ensemble de la plateforme EduMind AI</p>
        </div>
        <div class="text-right">
            <p class="text-gray-500 text-sm">{{ now()->format('d M Y, H:i') }}</p>
            <p class="text-violet-400 text-sm font-medium">{{ Auth::user()->email }}</p>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Students -->
        <div class="admin-card p-5 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-emerald-500/10 rounded-full blur-2xl"></div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-xs font-medium uppercase tracking-wider">Étudiants</p>
                    <p class="text-3xl font-bold text-white mt-1">{{ number_format($totalStudents) }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-500/20 flex items-center justify-center text-xl border border-emerald-500/30">👥</div>
            </div>
        </div>

        <!-- Teachers -->
        <div class="admin-card p-5 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-blue-500/10 rounded-full blur-2xl"></div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-xs font-medium uppercase tracking-wider">Enseignants</p>
                    <p class="text-3xl font-bold text-white mt-1">{{ number_format($totalTeachers) }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center text-xl border border-blue-500/30">🎓</div>
            </div>
        </div>

        <!-- Courses -->
        <div class="admin-card p-5 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-violet-500/10 rounded-full blur-2xl"></div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-xs font-medium uppercase tracking-wider">Cours</p>
                    <p class="text-3xl font-bold text-white mt-1">{{ number_format($totalCourses) }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-violet-500/20 flex items-center justify-center text-xl border border-violet-500/30">📚</div>
            </div>
        </div>

        <!-- Pending -->
        <div class="admin-card p-5 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-amber-500/10 rounded-full blur-2xl"></div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-xs font-medium uppercase tracking-wider">En attente</p>
                    <p class="text-3xl font-bold text-white mt-1">{{ number_format($pendingApprovals) }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-500/20 flex items-center justify-center text-xl border border-amber-500/30">⏳</div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Enrollment Chart -->
        <div class="admin-card p-6">
            <h3 class="text-white font-semibold text-base mb-4">📈 Inscriptions (7 derniers mois)</h3>
            <div id="enrollmentChart"></div>
        </div>

        <!-- Category Popularity -->
        <div class="admin-card p-6">
            <h3 class="text-white font-semibold text-base mb-4">🏷️ Popularité des catégories</h3>
            @if(count($popularityLabels) > 0)
                <div id="popularityChart"></div>
            @else
                <div class="flex items-center justify-center h-48 text-gray-500 text-sm">
                    Aucune catégorie avec des cours pour l'instant
                </div>
            @endif
        </div>
    </div>

    <!-- Extra stats row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Completion Rate -->
        <div class="admin-card p-6 text-center">
            <p class="text-gray-400 text-sm mb-2">Taux de complétion</p>
            <div class="text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-blue-400">
                {{ $completionRate }}%
            </div>
            <p class="text-gray-500 text-xs mt-2">{{ $totalEnrollments }} inscriptions totales</p>
        </div>

        <!-- Categories count -->
        <div class="admin-card p-6 text-center">
            <p class="text-gray-400 text-sm mb-2">Catégories actives</p>
            <div class="text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-violet-400 to-pink-400">
                {{ $totalCategories }}
            </div>
            <a href="{{ route('admin.categories.create') }}" class="text-violet-400 text-xs mt-2 inline-block hover:text-violet-300">+ Créer une catégorie</a>
        </div>

        <!-- Quick links -->
        <div class="admin-card p-6">
            <p class="text-gray-400 text-sm mb-4 font-medium">Actions rapides</p>
            <div class="space-y-3">
                <a href="{{ route('admin.users.index', ['status' => 'pending']) }}" class="flex items-center gap-3 text-amber-400 hover:text-amber-300 text-sm font-medium">
                    <span>⏳</span> Voir comptes en attente ({{ $pendingApprovals }})
                </a>
                <a href="{{ route('admin.categories.create') }}" class="flex items-center gap-3 text-violet-400 hover:text-violet-300 text-sm font-medium">
                    <span>➕</span> Nouvelle catégorie
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 text-blue-400 hover:text-blue-300 text-sm font-medium">
                    <span>👥</span> Gérer les utilisateurs
                </a>
            </div>
        </div>
    </div>

    <!-- Pending Approvals Table -->
    @if($recentPending->count() > 0)
    <div class="admin-card p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-white font-semibold text-base">⚠️ Comptes en attente d'approbation</h3>
            <a href="{{ route('admin.users.index', ['status' => 'pending']) }}" class="text-violet-400 text-sm hover:text-violet-300">Voir tous →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-white/5">
                        <th class="text-left text-gray-500 font-medium py-3 pr-4">Nom</th>
                        <th class="text-left text-gray-500 font-medium py-3 pr-4">Email</th>
                        <th class="text-left text-gray-500 font-medium py-3 pr-4">Rôle</th>
                        <th class="text-left text-gray-500 font-medium py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentPending as $u)
                    <tr class="border-b border-white/5 table-row">
                        <td class="py-3 pr-4 text-white font-medium">{{ $u->name }}</td>
                        <td class="py-3 pr-4 text-gray-400">{{ $u->email }}</td>
                        <td class="py-3 pr-4">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $u->role === 'teacher' ? 'badge-teacher' : 'badge-student' }}">
                                {{ ucfirst($u->role) }}
                            </span>
                        </td>
                        <td class="py-3">
                            <form method="POST" action="{{ route('admin.users.approve', $u) }}" class="inline">
                                @csrf
                                <button type="submit" class="btn-success" style="padding:4px 12px;font-size:12px;">
                                    ✓ Approuver
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enrollment Chart
    var enrollmentChart = new ApexCharts(document.querySelector("#enrollmentChart"), {
        series: [{ name: 'Inscriptions', data: @json($enrollmentCounts) }],
        chart: { type: 'area', height: 240, toolbar: { show: false }, background: 'transparent', foreColor: '#9ca3af' },
        colors: ['#8b5cf6'],
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.6, opacityTo: 0.05, stops: [0, 90, 100] } },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 2 },
        xaxis: { categories: @json($months), axisBorder: { show: false }, axisTicks: { show: false } },
        grid: { borderColor: '#1f2937', strokeDashArray: 4 },
        tooltip: { theme: 'dark' }
    });
    enrollmentChart.render();

    @if(count($popularityLabels) > 0)
    var popularityChart = new ApexCharts(document.querySelector("#popularityChart"), {
        series: @json($popularityValues),
        chart: { type: 'donut', height: 240, background: 'transparent', foreColor: '#9ca3af' },
        labels: @json($popularityLabels),
        colors: ['#8b5cf6', '#3b82f6', '#10b981', '#ec4899', '#f59e0b'],
        plotOptions: { pie: { donut: { size: '65%', background: 'transparent' } } },
        dataLabels: { enabled: false },
        stroke: { show: false },
        legend: { position: 'bottom', fontSize: '12px' },
        tooltip: { theme: 'dark' }
    });
    popularityChart.render();
    @endif
});
</script>
</x-admin-layout>
