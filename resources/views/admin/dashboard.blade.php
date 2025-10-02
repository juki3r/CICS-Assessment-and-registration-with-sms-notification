<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="mb-6 text-lg font-semibold text-center">Student Registrations Overview</h3>
                <br>
                <br>
                <br>
                <br>

                @php
                    $courses = ['BSIT', 'BSCS', 'BLIS'];
                @endphp

                <div class="d-flex justify-content-between">
                    @foreach($courses as $course)
                        <div style="width: 32%;">
                            <h4 class="mb-2 font-semibold d-flex justify-content-center align-items-center gap-2">
                                @if($course == "BSIT")
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-filetype-html text-warning" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M14 4.5V11h-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zm-9.736 7.35v3.999h-.791v-1.714H1.79v1.714H1V11.85h.791v1.626h1.682V11.85h.79Zm2.251.662v3.337h-.794v-3.337H4.588v-.662h3.064v.662zm2.176 3.337v-2.66h.038l.952 2.159h.516l.946-2.16h.038v2.661h.715V11.85h-.8l-1.14 2.596H9.93L8.79 11.85h-.805v3.999zm4.71-.674h1.696v.674H12.61V11.85h.79v3.325Z"/>
                                    </svg>
                                @elseif($course == "BSCS")
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-laptop text-primary" viewBox="0 0 16 16">
                                    <path d="M13.5 3a.5.5 0 0 1 .5.5V11H2V3.5a.5.5 0 0 1 .5-.5zm-11-1A1.5 1.5 0 0 0 1 3.5V12h14V3.5A1.5 1.5 0 0 0 13.5 2zM0 12.5h16a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 12.5"/>
                                    </svg>
                                 @elseif($course == "BLIS")
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-book-half" viewBox="0 0 16 16">
                                    <path d="M8.5 2.687c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783"/>
                                    </svg>
                                @endif
                                  {{ $course }}
                            </h4>
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
                            backgroundColor: 'rgba(5, 9, 242, 1)'
                        },
                        {
                            label: 'Failed',
                            data: [chartData[course].failed],
                            backgroundColor: 'rgba(245, 19, 7, 1)'
                        },
                        {
                            label: 'Pending',
                            data: [chartData[course].pending],
                            backgroundColor: 'rgba(250, 246, 1, 0.7)'
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
