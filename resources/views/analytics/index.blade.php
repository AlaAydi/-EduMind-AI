<x-app-layout>
    <div class="space-y-6">

        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-purple-500">
                Analytics Dashboard
            </h1>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <x-glass-card class="p-6 relative overflow-hidden">
                <p class="text-gray-400 text-sm">Total Students</p>
                <p class="text-3xl font-bold text-white mt-2">{{ number_format($totalStudents) }}</p>
            </x-glass-card>

            <x-glass-card class="p-6 relative overflow-hidden">
                <p class="text-gray-400 text-sm">Active Courses</p>
                <p class="text-3xl font-bold text-white mt-2">{{ $totalCourses }}</p>
            </x-glass-card>

            <x-glass-card class="p-6 relative overflow-hidden">
                <p class="text-gray-400 text-sm">Completion Rate</p>
                <p class="text-3xl font-bold text-white mt-2">{{ $completionRate }}%</p>
            </x-glass-card>

            <x-glass-card class="p-6 relative overflow-hidden">
                <p class="text-gray-400 text-sm">Active Learners</p>
                <p class="text-3xl font-bold text-white mt-2">{{ $activeLearners }}</p>
            </x-glass-card>

        </div>

        <!-- Charts -->
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

    <!-- ✅ IMPORTANT : pas de CDN = pas de Sonar warning -->
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // Enrollment Chart
            const enrollmentChart = new ApexCharts(document.querySelector("#enrollmentChart"), {
                series: [{
                    name: 'Enrollments',
                    data: @json($enrollmentData ?? [31, 40, 28, 51, 42, 109, 100])
                }],
                chart: {
                    height: 320,
                    type: 'area',
                    toolbar: { show: false },
                    background: 'transparent',
                    foreColor: '#9ca3af'
                },
                colors: ['#8b5cf6'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.1
                    }
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 2 },
                xaxis: {
                    categories: @json($months ?? ['Jan','Feb','Mar','Apr','May','Jun','Jul']),
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                grid: {
                    borderColor: '#374151',
                    strokeDashArray: 4
                },
                tooltip: { theme: 'dark' }
            });

            enrollmentChart.render();

            // Popularity Chart
            const popularityChart = new ApexCharts(document.querySelector("#popularityChart"), {
                series: @json($popularityValues ?? [44, 55, 41, 17, 15]),
                chart: {
                    type: 'donut',
                    height: 320,
                    foreColor: '#9ca3af',
                    background: 'transparent'
                },
                labels: @json($popularityLabels ?? ['ML','Web','Data','Design','Marketing']),
                colors: ['#3b82f6', '#8b5cf6', '#ec4899', '#10b981', '#f59e0b'],
                plotOptions: {
                    pie: {
                        donut: { size: '70%' }
                    }
                },
                dataLabels: { enabled: false },
                stroke: { show: false },
                legend: { position: 'bottom' },
                tooltip: { theme: 'dark' }
            });

            popularityChart.render();

        });
    </script>
    @endpush

</x-app-layout>
