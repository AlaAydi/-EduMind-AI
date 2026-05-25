<x-app-layout>
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-purple-500">Analytics Dashboard</h1>
        </div>

        <!-- Top Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <x-glass-card class="p-6 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-500/10 rounded-full blur-2xl"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm font-medium">Total Students</p>
                        <p class="text-3xl font-bold text-white mt-2">{{ number_format($totalStudents) }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center text-blue-400 text-xl border border-blue-500/30 shadow-[0_0_15px_rgba(59,130,246,0.3)]">
                        👥
                    </div>
                </div>
            </x-glass-card>

            <x-glass-card class="p-6 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-purple-500/10 rounded-full blur-2xl"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm font-medium">Active Courses</p>
                        <p class="text-3xl font-bold text-white mt-2">{{ $totalCourses }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-purple-500/20 flex items-center justify-center text-purple-400 text-xl border border-purple-500/30 shadow-[0_0_15px_rgba(168,85,247,0.3)]">
                        📚
                    </div>
                </div>
            </x-glass-card>

            <x-glass-card class="p-6 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-500/10 rounded-full blur-2xl"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm font-medium">Completion Rate</p>
                        <p class="text-3xl font-bold text-white mt-2">{{ $completionRate }}%</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/20 flex items-center justify-center text-emerald-400 text-xl border border-emerald-500/30 shadow-[0_0_15px_rgba(16,185,129,0.3)]">
                        🎯
                    </div>
                </div>
            </x-glass-card>

            <x-glass-card class="p-6 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-pink-500/10 rounded-full blur-2xl"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm font-medium">Active Learners</p>
                        <p class="text-3xl font-bold text-white mt-2">{{ $activeLearners }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-pink-500/20 flex items-center justify-center text-pink-400 text-xl border border-pink-500/30 shadow-[0_0_15px_rgba(236,72,153,0.3)]">
                        🔥
                    </div>
                </div>
            </x-glass-card>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <x-glass-card class="p-6">
                <h3 class="text-lg font-semibold text-white mb-4">Enrollment Trends</h3>
                <div id="enrollmentChart" class="h-80"></div>
            </x-glass-card>

            <x-glass-card class="p-6">
                <h3 class="text-lg font-semibold text-white mb-4">Course Popularity</h3>
                <div id="popularityChart" class="h-80"></div>
            </x-glass-card>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Enrollment Chart
            var enrollmentOptions = {
                series: [{
                    name: 'Enrollments',
                    data: [31, 40, 28, 51, 42, 109, 100]
                }],
                chart: {
                    height: 320,
                    type: 'area',
                    toolbar: { show: false },
                    foreColor: '#9ca3af',
                    background: 'transparent'
                },
                colors: ['#8b5cf6'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.1,
                        stops: [0, 90, 100]
                    }
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 2 },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                grid: {
                    borderColor: '#374151',
                    strokeDashArray: 4,
                    yaxis: { lines: { show: true } }
                },
                tooltip: { theme: 'dark' }
            };
            var enrollmentChart = new ApexCharts(document.querySelector("#enrollmentChart"), enrollmentOptions);
            enrollmentChart.render();

            // Popularity Chart
            var popularityOptions = {
                series: [44, 55, 41, 17, 15],
                chart: {
                    type: 'donut',
                    height: 320,
                    foreColor: '#9ca3af',
                    background: 'transparent'
                },
                labels: ['Machine Learning', 'Web Dev', 'Data Science', 'Design', 'Marketing'],
                colors: ['#3b82f6', '#8b5cf6', '#ec4899', '#10b981', '#f59e0b'],
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%',
                            background: 'transparent'
                        }
                    }
                },
                dataLabels: { enabled: false },
                stroke: { show: false },
                legend: { position: 'bottom' },
                tooltip: { theme: 'dark' }
            };
            var popularityChart = new ApexCharts(document.querySelector("#popularityChart"), popularityOptions);
            popularityChart.render();
        });
    </script>
    @endpush
</x-app-layout>
