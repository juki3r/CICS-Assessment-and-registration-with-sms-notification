<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase">
            {{ __('exam results') }}
        </h2>

        @if(Auth::user()->role == "admin")
        <a href="{{route('admin.notification')}}" class="relative ms-auto text-gray-700 hover:text-gray-900 p-1">
            <!-- Bell Icon (you can use Heroicons or FontAwesome) -->
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-bell-fill {{$notificationCount > 0 ? 'text-danger' : ''}}" viewBox="0 0 16 16">
                <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2m.995-14.901a1 1 0 1 0-1.99 0A5 5 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901"/>
              </svg>
        
            <!-- Badge -->
            <span class="absolute top-0 right-0 inline-flex items-center justify-center 
                         px-1.5 text-sm font-bold leading-none 
                         transform translate-x-1/2 -translate-y-1/2 text-dark rounded-full ">
                @if($notificationCount > 0)
                    {{ $notificationCount }}
                @else()
                @endif
            </span>
        </a>
        @endif
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('message'))
                <div class="mb-4 text-green-600 font-semibold">
                    {{ session('message') }}
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(Auth::user()->role == "admin")
                        <div class="responsive-table">
                            <div class="students_nav  py-1">
                                <x-nav-link :href="route('exam_results', ['course' => 'bsit'])" :active="request()->routeIs('exam_results') && in_array(request()->route('course'), ['bsit'])" class="my-2 fs-4">
                                    {{ __('BSIT') }}
                                </x-nav-link>
                                <x-nav-link :href="route('exam_results', ['course' => 'bscs'])" :active="request()->routeIs('exam_results') && in_array(request()->route('course'), ['bscs'])" class="my-2 mx-3 fs-4">
                                    {{ __('BSCS') }}
                                </x-nav-link>
                                <x-nav-link :href="route('exam_results', ['course' => 'blis'])" :active="request()->routeIs('exam_results') && in_array(request()->route('course'), ['blis'])" class="my-2 fs-4">
                                    {{ __('BLIS') }}
                                </x-nav-link>
                            </div>
                            <h3 class="fs-5 mb-3 mt-3">
                                @if(request()->routeIs('exam_results') && in_array(request()->route('course'), ['bsit']))
                                    BSIT STUDENTS EXAM RESULTS
                                @elseif(request()->routeIs('exam_results') && in_array(request()->route('course'), ['bscs']))
                                    BSCS STUDENTS EXAM RESULTS
                                @elseif(request()->routeIs('exam_results') && in_array(request()->route('course'), ['blis']))
                                    BLIS STUDENTS EXAM RESULTS
                                @endif
                            </h3>
                            <span class="text-success" style="font-style: ">Click student to view more details</span>
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Exam</th>
                                        <th>Interview</th>
                                        <th>GWA</th>
                                        <th>Course</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($students as $student)
                                        @foreach ($student->examResults as $result)
                                            <tr
                                                style="cursor: pointer;"
                                                onmouseover="this.style.backgroundColor='#dbeafe';" 
                                                onmouseout="this.style.backgroundColor='';"
                                            >
                                                <td class="text-capitalize">{{ $result->user_id }}</td>
                                                <td class="text-capitalize">{{ $student->fullname ?? $student->name }}</td>
                                                <td class="editable"
                                                    contenteditable="true"
                                                    data-id="{{ $result->id }}"
                                                    data-field="exam">{{ $result->exam }}</td>

                                                <td class="editable"
                                                    contenteditable="true"
                                                    data-id="{{ $result->id }}"
                                                    data-field="interview">{{ $result->interview }}</td>

                                                <td class="editable"
                                                    contenteditable="true"
                                                    data-id="{{ $result->id }}"
                                                    data-field="gwa">{{ $result->gwa }}</td>

                                                <td class="text-uppercase">{{ $result->course }}</td>
                                            </tr>
                                            <script>
                                                document.querySelectorAll('.editable').forEach(cell => {
                                                    cell.addEventListener('blur', () => {
                                                        const id = cell.dataset.id;
                                                        const field = cell.dataset.field;
                                                        const value = cell.innerText.trim();
                                                
                                                        // Optional validation (number only for exam/interview/gwa)
                                                        const numericFields = ['exam', 'interview', 'gwa'];
                                                        if (numericFields.includes(field) && isNaN(value)) {
                                                            alert('Please enter a numeric value.');
                                                            return;
                                                        }
                                                
                                                        fetch("{{ route('admin.update_exam_field') }}", {
                                                            method: 'POST',
                                                            headers: {
                                                                'Content-Type': 'application/json',
                                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                            },
                                                            body: JSON.stringify({ id, field, value })
                                                        })
                                                        .then(res => res.json())
                                                        .then(data => {
                                                            if (data.success) {
                                                                cell.style.backgroundColor = "#d1fae5"; // green highlight
                                                                setTimeout(() => cell.style.backgroundColor = "", 1000);
                                                            } else {
                                                                alert('Update failed.');
                                                            }
                                                        });
                                                    });
                                                });
                                                </script>
                                                
                                        @endforeach
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">No student found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                
                                
                            </table>
                            
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
