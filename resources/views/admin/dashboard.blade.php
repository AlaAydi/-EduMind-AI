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

            <div class="admin-card p-5 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-emerald-500/10 rounded-full blur-2xl"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-xs uppercase">Étudiants</p>
                        <p class="text-3xl font-bold text-white mt-1">{{ number_format($totalStudents) }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/20 flex items-center justify-center border border-emerald-500/30">
                        👥
                    </div>
                </div>
            </div>

            <div class="admin-card p-5 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-blue-500/10 rounded-full blur-2xl"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-xs uppercase">Enseignants</p>
                        <p class="text-3xl font-bold text-white mt-1">{{ number_format($totalTeachers) }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center border border-blue-500/30">
                        🎓
                    </div>
                </div>
            </div>

            <div class="admin-card p-5 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-violet-500/10 rounded-full blur-2xl"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-xs uppercase">Cours</p>
                        <p class="text-3xl font-bold text-white mt-1">{{ number_format($totalCourses) }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-violet-500/20 flex items-center justify-center border border-violet-500/30">
                        📚
                    </div>
                </div>
            </div>

            <div class="admin-card p-5 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-amber-500/10 rounded-full blur-2xl"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-xs uppercase">En attente</p>
                        <p class="text-3xl font-bold text-white mt-1">{{ number_format($pendingApprovals) }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-amber-500/20 flex items-center justify-center border border-amber-500/30">
                        ⏳
                    </div>
                </div>
            </div>

        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <div class="admin-card p-6">
                <h3 class="text-white font-semibold mb-4">📈 Inscriptions</h3>
                <div id="enrollmentChart"></div>
            </div>

            <div class="admin-card p-6">
                <h3 class="text-white font-semibold mb-4">🏷️ Catégories</h3>
                @if(count($popularityLabels) > 0)
                    <div id="popularityChart"></div>
                @else
                    <div class="text-gray-500 text-sm">Aucune donnée</div>
                @endif
            </div>

        </div>

    </div>

    <!-- ✅ FIX: CDN SANS integrity (Sonar OK) -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts" crossorigin="anonymous"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const enrollmentChart = new ApexCharts(document.querySelector("#enrollmentChart"), {
                series: [{ name: 'Inscriptions', data: @json($enrollmentCounts) }],
                chart: {
                    type: 'area',
                    height: 240,
                    toolbar: { show: false },
                    background: 'transparent',
                    foreColor: '#9ca3af'
                },
                colors: ['#8b5cf6'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.6,
                        opacityTo: 0.05,
                        stops: [0, 90, 100]
                    }
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 2 },
                xaxis: {
                    categories: @json($months),
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                grid: { borderColor: '#1f2937', strokeDashArray: 4 },
                tooltip: { theme: 'dark' }
            });

            enrollmentChart.render();

            @if(count($popularityLabels) > 0)
            const popularityChart = new ApexCharts(document.querySelector("#popularityChart"), {
                series: @json($popularityValues),
                chart: {
                    type: 'donut',
                    height: 240,
                    background: 'transparent',
                    foreColor: '#9ca3af'
                },
                labels: @json($popularityLabels),
                colors: ['#8b5cf6', '#3b82f6', '#10b981', '#ec4899', '#f59e0b'],
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
