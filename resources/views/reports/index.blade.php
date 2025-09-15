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

                {{-- Mini Navigation --}}
                @php
                    $courses = ['BSIT', 'BSCS', 'BLIS'];
                @endphp
                <div class="mb-4">
                    <a href="{{ route('reports') }}"
                       class="btn btn-sm {{ request('course') === null ? 'btn-primary' : 'btn-outline-primary' }} mx-1">
                        All
                    </a>
                    @foreach ($courses as $c)
                        <a href="{{ route('reports', ['course' => $c]) }}"
                           class="btn btn-sm {{ request('course') === $c ? 'btn-primary' : 'btn-outline-primary' }} mx-1">
                            {{ $c }}
                        </a>
                    @endforeach
                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Fullname</th>
                                <th>Course</th>
                                <th>Strand</th>
                                <th>GWA</th>
                                <th>Address</th>
                                <th>Contact Details</th>
                                <th>School</th>
                                <th>Interview Result</th>
                                <th>Skill Test Result</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($registrations as $index => $reg)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $reg->fullname }}</td>
                                    <td>{{ $reg->course }}</td>
                                    <td>{{ $reg->strand }}</td>
                                    <td>{{ $reg->gwa }}</td>
                                    <td>{{ $reg->address }}</td>
                                    <td>{{ $reg->contact_details }}</td>
                                    <td>{{ $reg->school }}</td>
                                    <td>{{ $reg->interview_result ?? 'Pending' }}</td>
                                    <td>{{ $reg->skill_test_result ?? 'Pending' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">No registrations found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
