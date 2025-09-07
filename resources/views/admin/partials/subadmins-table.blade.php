<div class="table-responsive">
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Name</th>
            <th style="width: 10%">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($subAdmins as $admin)
            <tr>
                <td class="text-capitalize">{{ $admin->name }}</td>
                <td class="text-center">
                    <a href="{{ route('subadmin.delete', ['id' => $admin->id]) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-trash text-danger" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                        </svg>
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="2" class="text-center">No Sub Admins found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
</div>
<div class="d-flex justify-content-center">
    {!! $subAdmins->links() !!}
</div>
