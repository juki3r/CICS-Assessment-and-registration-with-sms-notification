<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase">
            {{ __('User accounts') }}
        </h2>
    </x-slot>

    <div class="py-12 d-flex justify-content-center">
        <div class="border rounded w-50 mt-5 p-3 shadow">
            <div class="responsive-table px-3">
                <div class="text-end pb-3">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Add Faculty
                    </button>
                </div>

                <h3 class="fs-3">List of Faculty</h3>
                
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
                    <input type="text" id="search" class="form-control w-50" placeholder="Search Sub Admins...">
                </div>

                <!-- Table Container (will be replaced by AJAX) -->
                <div id="subAdminsTable">
                    @include('admin.partials.subadmins-table', ['subAdmins' => $subAdmins])
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Faculty</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('add.admin.user') }}" method="POST">
                                @csrf
                                <div class="py-2">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" required>
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
            
            
            <!-- EDIT MODAL -->
            <div class="modal fade" id="editModal" tabindex="-1">
            <div class="modal-dialog">
                <form id="editForm" method="POST">
                    @csrf

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Sub Admin</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" id="editName" name="name" class="form-control" required>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Update
                            </button>
                        </div>
                    </div>
                </form>
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
                    url: "{{ route('admin.users.search') }}",
                    type: "GET",
                    data: { search: search },
                    success: function(data){
                        $('#subAdminsTable').html(data);
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
                        $('#subAdminsTable').html(data);
                    }
                });
            });
        });


        document.addEventListener("DOMContentLoaded", function () {

    // When edit button clicked
    document.querySelectorAll(".editBtn").forEach(btn => {
        btn.addEventListener("click", function () {

            let id = this.dataset.id;
            let name = this.dataset.name;
            let url = this.dataset.updateUrl;

            // Set input value
            document.getElementById("editName").value = name;

            // Set form action URL
            document.getElementById("editForm").action = url;

            // Show modal
            let modal = new bootstrap.Modal(document.getElementById("editModal"));
            modal.show();
        });
    });

});
    </script>
</x-app-layout>
