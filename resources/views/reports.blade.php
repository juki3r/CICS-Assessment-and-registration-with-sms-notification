<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-uppercase">
           REPORTS
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Report List</h3>

                    <!-- Student Table -->
                    <table class="table table-striped w-full border-collapse border border-gray-300">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border border-gray-300 px-4 py-2">By</th>
                                <th class="border border-gray-300 px-4 py-2">Activity</th>
                                <th class="border border-gray-300 px-4 py-2">Name of student</th>
                                <th class="border border-gray-300 px-4 py-2">Task</th>
                                <th class="border border-gray-300 px-4 py-2">Course</th>
                                <th class="border border-gray-300 px-4 py-2">Date & Time</th>
                                <th class="border border-gray-300 px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reports as $index => $report)
                                <tr class="hover:bg-gray-100">
                                    <td class="border border-gray-300 px-4 py-2">{{ $report->firstname }} {{ $report->lastname }}</td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">{{ $report->activity }}</td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">{{ $report->name_of_student }}</td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">{{ $report->task}}</td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">{{ $report->course }}</td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">{{ $report->created_at }}</td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        <a href="" class="btn btn-warning">Edit</a>
                                        <form action="" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
