<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase">
            {{ __('SMS Logs') }}
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
                <div class="mb-4 d-flex align-items-center gap-3 p-3">

                  {{-- Course Dropdown --}}
                    <div class="dropdown">
                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="courseDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ request('course', 'BSIT') }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="courseDropdown">
                            @foreach(['BSIT', 'BSCS', 'BLIS'] as $c)
                                <li>
                                    <a class="dropdown-item" href="{{ route('smslogs.logs', array_merge(request()->query(), ['course' => $c, 'status' => 'passed'])) }}">
                                        {{ $c }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>


                    {{-- Status Dropdown --}}
                    <div class="dropdown d-none">
                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="statusDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ ucfirst(request('status') ?? 'Passed') }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="statusDropdown">
                            <li><a class="dropdown-item" href="{{ route('smslogs.logs', array_merge(request()->query(), ['status' => null])) }}">All Status</a></li>
                            <li><a class="dropdown-item" href="{{ route('smslogs.logs', array_merge(request()->query(), ['status' => 'passed'])) }}">Passed</a></li>
                            <li><a class="dropdown-item" href="{{ route('smslogs.logs', array_merge(request()->query(), ['status' => 'failed'])) }}">Failed</a></li>
                        </ul>
                    </div>


                </div>

                {{-- Table --}}
                <div class="table-responsive p-3">
                    <table class="table table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name of student</th>
                                <th>Mobile No.</th>
                                <th>Status</th>
                                <th>Message</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($registrations as $index => $reg)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="text-capitalize">{{ $reg->fullname }}</td>
                                    <td>{{ $reg->contact_details }}</td>
                                    <td></td>
                                    <td>
                                        <p>
                                            Congratulations <strong>{{$reg->fullname}}</strong>, you are qualified incoming <br>
                                            First year student in <strong class="text-uppercase">{{$reg->course}} </strong>A.Y 2025-2026. <br>
                                            Don't reply to this message, system generated. Thanks!
                                        </p>
                                    </td>
                                    <td></td> 
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No student found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
