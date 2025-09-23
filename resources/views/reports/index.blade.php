<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase">
            {{ __('Reports') }}
        </h2>
    </x-slot>

    {{-- PRINT VIEW --}}
    @if(request()->has('print'))
    <html>
    <head>
        <title>Passed Students List @if($course) ({{ $course }}) @endif</title>
        <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <style>
            
            ol { font-size: 16px; margin-bottom: 0; }
            .page-break { page-break-after: always; }

             @media print {
                    * {
                        -webkit-print-color-adjust: exact !important;
                        color-adjust: exact !important;
                    }
                    .bg-black {
                        background-color: black !important;
                        color: white !important;
                    }
                }
        </style>
    </head>
    <body onload="window.print()">

         <div class="d-flex justify-content-center py-3">
            <div class="pe-4 text-center">
                <img src="{{asset('logo.png')}}" alt="" width="100px">
            </div>
            <div class="">
                <h6 class="text-center">Republic of the Philippines</h6>
                <h3 class="fs-3 text-center">
                    NORTHERN ILOILO STATE UNIVERSITY
                </h3>
                <h6 class="text-center" style="font-weight: light !important">
                    NISU Main Campus, V Cudilla Sr. Ave, Estancia, Iloilo
                </h6>
            </div>
            <div class="ps-4 text-center">
            <img src="{{asset('cics.png')}}" alt="" width="100px">
            </div>
        </div>
        <div class="text-center bg-black py-1">
            <strong>COLLEGE OF INFORMATION AND COMPUTING STUDIES</strong>
        </div>

        

        <h4 class="text-center mt-3 mb-5">
            LIST OF QUALIFIED INCOMING FIRST YEAR STUDENT
            <br>
            @if($course == 'BSIT')
                BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY
            @elseif($course == 'BSCS')
                BACHELOR OF SCIENCE IN COMPUTER SCIENCE
            @elseif($course == 'BLIS')
                BACHELOR OF LIBRARY AND INFORMATION SCIENCE
            @endif
        </h4>

        <div>
            @php $counter = 0; @endphp
            <table class="table table-bordered" style="width:50%; margin:0 auto; border-collapse: collapse; font-size: 16px;">
                <thead>
                    <tr>
                        <th style="border: 1px solid #000; padding: 6px; text-align: center;">#</th>
                        <th style="border: 1px solid #000; padding: 6px;">Fullname</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registrations as $reg)
                        <tr>
                            <td style="border: 1px solid #000; padding: 6px; text-align: center;">
                                {{ $counter + 1 }}
                            </td>
                            <td style="border: 1px solid #000; padding: 6px;" class="text-uppercase">
                                {{ $reg->fullname }}
                            </td>
                        </tr>
                        @php $counter++; @endphp

                        {{-- Insert page break every 30 students --}}
                        @if($counter % 30 === 0 && !$loop->last)
                            </tbody>
                        </table>

                        <div class="page-break"></div>

                        <table class="table table-bordered" style="width:50%; margin:0 auto; border-collapse: collapse; font-size: 16px;">
                            <thead>
                                <tr>
                                    <th style="border: 1px solid #000; padding: 6px; text-align: center;">#</th>
                                    <th style="border: 1px solid #000; padding: 6px;">Fullname</th>
                                </tr>
                            </thead>
                            <tbody>
                        @endif
                    @empty
                        <tr>
                            <td colspan="2" style="text-align:center; padding:10px;">No students found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <style>
            .page-break { page-break-after: always; }
        </style>



    </body>
    </html>
    @php return; @endphp
@endif

    {{-- END PRINT VIEW --}}

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

                    {{-- Print Button: show only if a course is selected AND status is passed --}}
                    @if(request('course') && request('status') === 'passed')
                        <button class="btn btn-sm btn-primary ms-auto"
                                onclick="window.open('{{ route('reports', array_merge(request()->query(), ['print' => 1])) }}', '_blank')">
                            Print
                        </button>
                    @endif


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
                                    <td>{{ $reg->fullname }}</td>
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
