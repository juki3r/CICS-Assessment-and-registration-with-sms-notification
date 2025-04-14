<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add BSIT Student') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Add New Student</h3>

                    <form action="{{ route('students.store') }}" method="POST">
                    @csrf

                    <div class="row mb-4">
                        <div class="col">
                            <label for="fullname" class="block font-medium">Full Name</label>
                            <input type="text" name="fullname" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('fullname') }}" required>
                            @error('fullname')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col">
                            <label for="address" class="block font-medium">Address</label>
                            <input type="text" name="address" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('address') }}" required>
                            @error('address')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col">
                            <label for="contact_number" class="block font-medium">Contact Number</label>
                            <input type="number" name="contact_number" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('contact_number') }}" required>
                            @error('contact_number')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col">
                            <label for="school" class="block font-medium">Name of School (Last Attended)</label>
                            <input type="text" name="school" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('school') }}" required>
                            @error('school')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col">
                            <label for="strand" class="block font-medium">Strand</label>
                            <input type="text" name="strand" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('strand') }}" required>
                            @error('strand')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col">
                            <label for="age" class="block font-medium">Age</label>
                            <input type="number" name="age" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('age') }}" required>
                            @error('age')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="exam" class="block font-medium">Exam</label>
                            <input type="number" name="exam" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('exam') }}" required>
                            @error('exam')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="interview" class="block font-medium">Interview</label>
                            <input type="number" name="interview" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('interview') }}" required>
                            @error('interview')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="skill_test" class="block font-medium">Skill Test</label>
                            <input type="number" name="skill_test" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('skill_test') }}" required>
                            @error('skill_test')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="gwa" class="block font-medium">GWA</label>
                            <input type="number" step="0.01" name="gwa" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('gwa') }}" required>
                            @error('gwa')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Student</button>
                        <a href="{{ route('bsit') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</a>
                    </div>
                </form>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>






<!-- <div class="border col-12 col-md-6 p-2 mx-lg-1">
                        <h3 class="text-lg font-semibold mb-4">Add New Student</h3>

                        <form action="{{ route('students.store') }}" method="POST">
                        @csrf

                        <div class="row mb-4">

                            <div class="col-12 col-md-6 mb-2">
                                <label for="fullname" class="block font-medium">Full Name</label>
                                <input type="text" name="fullname" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('fullname') }}" required>
                                @error('fullname')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6 mb-2">
                                <label for="address" class="block font-medium">Address</label>
                                <input type="text" name="address" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('address') }}" required>
                                @error('address')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6 mb-2">
                                <label for="contact_number" class="block font-medium">Contact Number</label>
                                <input type="number" name="contact_number" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('contact_number') }}" required>
                                @error('contact_number')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6 mb-2">
                                <label for="school" class="block font-medium">Name of School (Last Attended)</label>
                                <input type="text" name="school" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('school') }}" required>
                                @error('school')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6 mb-2">
                                <label for="strand" class="block font-medium">Strand</label>
                                <input type="text" name="strand" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('strand') }}" required>
                                @error('strand')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6 mb-2">
                                <label for="age" class="block font-medium">Age</label>
                                <input type="number" name="age" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('age') }}" required>
                                @error('age')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6 mb-2">
                                <label for="skill_test" class="block font-medium">Skill Test</label>
                                <input type="number" name="skill_test" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('skill_test') }}" required>
                                @error('skill_test')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6 mb-2">
                                <label for="gwa" class="block font-medium">GWA</label>
                                <input type="number" step="0.01" name="gwa" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('gwa') }}" required>
                                @error('gwa')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>


                        </div>

                        <div class="mt-4">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Student</button>
                            <a href="{{ route('bsit') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</a>
                        </div>
                    </form>

                </div>

                <div class="col-12 col-md-6 border mt-5 mt-lg-0 mx-lg-1 p-3">
                    <h3 class="fs-3 text-center">INTERVIEW</h3>
                </div> -->
