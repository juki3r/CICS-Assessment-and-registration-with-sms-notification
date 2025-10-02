<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase">
            {{ __('Students Interview') }}
        </h2>
    </x-slot>

    <div class="py-12 d-flex justify-content-center">
        <div class="border rounded w-75 mt-5 p-3 shadow">
            <div class="responsive-table px-3">
                <div class="text-end pb-3">
                    <!-- Button trigger modal -->
                    
                </div>

                <h3 class="fs-3">List of Student</h3>
                
                {{-- Error Messages --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Success & Danger Alerts --}}
                @if(session('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif

                @if(session('alert'))
                    <div class="alert alert-danger">{{ session('alert') }}</div>
                @endif

                <!-- Search Input -->
                <div class="mb-3">
                    <input type="text" id="search" class="form-control" placeholder="Search Students...">
                </div>

                <!-- Table Container (will be replaced by AJAX) -->
                <div id="studentsTable">
                    @include('admin.partials.interview_table', ['registrations' => $registrations])
                </div>
            </div>         
        </div>
    </div>

    {{-- AJAX Script for Live Search --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function(){
            // Live Search
            $('#search').on('keyup', function(){
                let search = $(this).val();
                $.ajax({
                    // url: "{{ route('admin.registrations.search') }}",
                    url: "{{ route('admin.interview') }}",
                    type: "GET",
                    data: { search: search },
                    success: function(data){
                        $('#studentsTable').html(data);
                    }
                });
            });

            // Handle pagination click dynamically
            $(document).on('click', '.pagination a', function(e){
                e.preventDefault();
                let url = $(this).attr('href');
                $.ajax({
                    url: url,
                    success: function(data){
                        $('#studentsTable').html(data);
                    }
                });
            });
        });
    </script>
</x-app-layout>
