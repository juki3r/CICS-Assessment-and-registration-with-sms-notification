<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="mb-6 text-lg font-semibold">Student Registrations by Course & Remarks</h3>

                @php
                    $courses = ['BSIT', 'BSCS', 'BLIS'];
                @endphp

                <div class="d-flex justify-content-between">
                    @foreach($courses as $course)
                        <div style="width: 32%;">
                            <h4 class="mb-2 font-semibold text-center">{{ $course }}</h4>
                            <!-- Fixed height container -->
                            <div style="height: 350px;">
                                <canvas id="chart-{{ $course }}"></canvas>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const chartData = @json($chartData);
        const courses = ['BSIT', 'BSCS', 'BLIS'];

        courses.forEach(course => {
            const ctx = document.getElementById('chart-' + course).getContext('2d');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Students'],
                    datasets: [
                        {
                            label: 'Passed',
                            data: [chartData[course].passed],
                            backgroundColor: 'rgba(244, 9, 217, 0.96)'
                        },
                        {
                            label: 'Failed',
                            data: [chartData[course].failed],
                            backgroundColor: 'rgba(246, 6, 6, 0.7)'
                        },
                        {
                            label: 'Pending',
                            data: [chartData[course].pending],
                            backgroundColor: 'rgba(6, 248, 78, 0.55)'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // fills the 200px container
                    plugins: {
                        legend: { position: 'top', labels: { boxWidth: 12, boxHeight: 12, font: { size: 12 } } },
                        title: { display: true, text: course + ' Registrations', font: { size: 14 } }
                    },
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1 } }
                    }
                }
            });
        });
    </script>
</x-app-layout>
