<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('BSIT Students') }}
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
                    <h3 class="text-lg font-semibold mb-4">Student List</h3>

                    <!-- Add Student Button (Modal Trigger) -->
                    <div class="mb-4">
                        <button onclick="openModal()" class="btn btn-primary">
                            Add Student
                        </button>
                    </div>

                    <!-- Student Table -->
                    <table class="table table-striped w-full border-collapse border border-gray-300">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border border-gray-300 px-4 py-2">No</th>
                                <th class="border border-gray-300 px-4 py-2">Fullname</th>
                                <th class="border border-gray-300 px-4 py-2">Exam</th>
                                <th class="border border-gray-300 px-4 py-2">Interview</th>
                                <th class="border border-gray-300 px-4 py-2">Skill Test</th>
                                <th class="border border-gray-300 px-4 py-2">GWA</th>
                                <th class="border border-gray-300 px-4 py-2">Total</th>
                                <th class="border border-gray-300 px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $index => $student)
                                <tr class="hover:bg-gray-100">
                                    <td class="border border-gray-300 px-4 py-2 text-center">{{ $index + 1 }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $student->fullname }}</td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">{{ $student->exam }}</td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">{{ $student->interview }}</td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">{{ $student->skill_test }}</td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">{{ $student->gwa }}</td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">{{ $student->total }}</td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning">Edit</a>
                                        <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="inline-block">
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

    <!-- Modal -->
    <div id="taskModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-lg font-semibold mb-4 text-center">Select Task</h2>
            <div class="space-y-3">
                <a href="{{ route('students_add', ['task' => 'INTERVIEW', 'student_course' => $student_course]) }}"
                class="block text-center py-2 px-4 bg-sky-600 text-dark rounded-lg hover:bg-sky-700">
                INTERVIEW
                </a>
                <a href="{{ route('students_add', ['task' => 'SKILL_TEST', 'student_course' => $student_course]) }}"
                class="block text-center py-2 px-4 bg-emerald-600 text-dark rounded-lg hover:bg-success">
                SKILL TEST
                </a>
                <a href="{{ route('students_add', ['task' => 'GWA', 'student_course' => $student_course]) }}"
                class="block text-center py-2 px-4 bg-indigo-600 text-dark rounded-lg hover:bg-indigo-700">
                GWA
                </a>
            </div>
            <button onclick="closeModal()"
                    class="mt-6 w-full py-2 px-4 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                Cancel
            </button>
        </div>
    </div>


    <!-- JavaScript to Control Modal -->
    <script>
        function openModal() {
            document.getElementById('taskModal').classList.remove('hidden');
            document.getElementById('taskModal').classList.add('flex');
        }
        function closeModal() {
            document.getElementById('taskModal').classList.add('hidden');
            document.getElementById('taskModal').classList.remove('flex');
        }
    </script>
</x-app-layout>
