<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase">
            {{ __('SMS Logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('message'))
                <div class="mb-4 text-green-600 font-semibold">{{ session('message') }}</div>
            @elseif (session('alert_message'))
                <div class="mb-4 text-red-600 font-semibold">{{ session('alert_message') }}</div>
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
                                    <a class="dropdown-item" href="{{ route('smslogs.sent', array_merge(request()->query(), ['course' => $c, 'status' => 'passed'])) }}">
                                        {{ $c }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                {{-- Send SMS Form --}}
                <form id="sendSmsForm" method="POST" action="{{ route('sendSmsFromClient') }}">
                    @csrf

                    <div class="table-responsive p-3">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    
                                    <th>#</th>
                                    <th>Name of student</th>
                                    <th>Mobile No.</th>
                                    <th>
                                        <input type="checkbox" id="selectAll">
                                         <label for="">Select all</label>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($registrations as $index => $reg)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="text-capitalize">{{ $reg->fullname }}</td>
                                        <td style="display: none">{{ $reg->course }}</td>
                                        <td>{{ $reg->contact_details }}</td>
                                        <td>
                                            <input type="checkbox" name="selected[]" value="{{ $reg->id }}" class="select-item">
                                           
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No student found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary" id="sendBtn">Send Selected</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- JavaScript for Select All --}}
    <script>
        document.getElementById('selectAll').addEventListener('change', function() {
            const checked = this.checked;
            document.querySelectorAll('.select-item').forEach(cb => cb.checked = checked);
        });
    </script>
</x-app-layout>
