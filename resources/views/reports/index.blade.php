<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase">
            {{ __('Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('message'))
                <div class="mb-4 text-green-600 font-semibold">
                    {{ session('message') }}
                </div>
            @elseif (session('alert_message'))
                <div class="mb-4 text-red-600 font-semibold">
                    {{ session('alert_message') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Filters --}}
                <div class="mb-4 d-flex align-items-center gap-3">

                    {{-- Course Dropdown --}}
                    <div class="dropdown">
                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="courseDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ request('course') ?? 'All Courses' }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="courseDropdown">
                            <li><a class="dropdown-item" href="{{ route('reports', array_merge(request()->query(), ['course' => null])) }}">All Courses</a></li>
                            @foreach(['BSIT', 'BSCS', 'BLIS'] as $c)
                                <li>
                                    <a class="dropdown-item" href="{{ route('reports', array_merge(request()->query(), ['course' => $c])) }}">
                                        {{ $c }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Status Dropdown --}}
                    <div class="dropdown">
                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="statusDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ ucfirst(request('status') ?? 'All Status') }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="statusDropdown">
                            <li><a class="dropdown-item" href="{{ route('reports', array_merge(request()->query(), ['status' => null])) }}">All Status</a></li>
                            <li><a class="dropdown-item" href="{{ route('reports', array_merge(request()->query(), ['status' => 'passed'])) }}">Passed</a></li>
                            <li><a class="dropdown-item" href="{{ route('reports', array_merge(request()->query(), ['status' => 'failed'])) }}">Failed</a></li>
                        </ul>
                    </div>

                    {{-- Ranking Checkbox --}}
                    <div class="form-check ms-3">
                        <input class="form-check-input" type="checkbox" value="1" id="rankingCheck"
                               onchange="location = this.checked ? '{{ route('reports', array_merge(request()->query(), ['rank' => 1])) }}' : '{{ route('reports', array_merge(request()->query(), ['rank' => null])) }}';"
                               {{ request()->has('rank') ? 'checked' : '' }}>
                        <label class="form-check-label" for="rankingCheck">
                            Rank by Total
                        </label>
                    </div>

                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Fullname</th>
                                <th>Course</th>
                                <th>Exam</th>
                                <th>GWA</th>
                                <th>Interview</th>
                                <th>Skill Test</th>
                                <th>Total</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($registrations as $index => $reg)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="text-capitalize">{{ $reg->fullname }}</td>
                                    <td>{{ $reg->course }}</td>
                                    <td>{{ $reg->exam_result ?? 'Pending' }}</td>
                                    <td>{{ $reg->gwa ?? 'Pending'}}</td>
                                    <td>{{ $reg->interview_result ?? 'Pending' }}</td>
                                    <td>{{ $reg->skilltest ?? 'Pending' }}</td>
                                    <td>{{ $reg->total ?? 'Pending' }}</td>
                                    <td>{{ $reg->remarks ?? 'Pending' }}</td>   
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No registrations found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
