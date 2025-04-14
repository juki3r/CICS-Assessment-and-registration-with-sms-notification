<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Student') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-lg font-semibold mb-4">Edit Student</h2>

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Update Form --}}
                    <form action="{{ route('students.update', $student->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium">Fullname</label>
                            <input type="text" name="fullname" value="{{ old('fullname', $student->fullname) }}" class="w-full p-2 border rounded">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium">Exam</label>
                            <input type="number" step="0.01" name="exam" value="{{ old('exam', $student->exam) }}" class="w-full p-2 border rounded">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium">Interview</label>
                            <input type="number" step="0.01" name="interview" value="{{ old('interview', $student->interview) }}" class="w-full p-2 border rounded">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium">Skill Test</label>
                            <input type="number" step="0.01" name="skill_test" value="{{ old('skill_test', $student->skill_test) }}" class="w-full p-2 border rounded">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium">GWA</label>
                            <input type="number" step="0.01" name="gwa" value="{{ old('gwa', $student->gwa) }}" class="w-full p-2 border rounded">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium">Total</label>
                            <input type="number" step="0.01" name="total" value="{{ old('total', $student->total) }}" class="w-full p-2 border rounded">
                        </div>

                        <div class="flex space-x-2">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Update</button>
                            <a href="{{ route('main') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Cancel</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
