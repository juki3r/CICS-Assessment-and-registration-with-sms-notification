<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase">
            {{ __('Students Registration') }}
        </h2>
    </x-slot>

    <div class="py-12 d-flex justify-content-center">
        <div class="border rounded w-75 mt-5 p-3 shadow">
            <div class="responsive-table px-3">
                <div class="text-end pb-3">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Add Student
                    </button>
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
                    @include('admin.partials.registrations_table', ['registrations' => $registrations])
                </div>
            </div>
             <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Student</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('add.registration') }}" method="POST">
                                @csrf
                                <div class="py-2">
                                    <label for="name">Fullname</label>
                                    <input type="text" class="form-control" name="fullname" required>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                            </form>
                    </div>
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
                    url: "{{ route('admin.registrations.search') }}",
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
        
    </script>
</x-app-layout>
