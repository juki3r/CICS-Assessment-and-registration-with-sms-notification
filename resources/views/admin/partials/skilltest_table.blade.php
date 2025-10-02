<div class="table-responsive">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Full name</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($registrations as $registration)
                <tr data-bs-toggle="modal" data-bs-target="#studentModal{{ $registration->id }}" style="cursor:pointer;">
                    <td class="text-capitalize">{{ $registration->fullname }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="text-center">No Students found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modern Pagination -->
<div class="d-flex justify-content-center">
    {!! $registrations->links() !!}
</div>

{{-- ================== ALL STUDENT MODALS ================== --}}
@foreach ($registrations as $registration)
<div class="modal fade " id="studentModal{{ $registration->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="{{ route('registrations.updateSkilltest', $registration->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title text-capitalize">Skill Test - {{ $registration->fullname }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="container-fluid">
                        @if($registration->skilltest == null)
                            <div class="mb-3">
                                <label for="skilltest" class="form-label">Skill test:</label>
                                <select name="skilltest" class="form-control" required>
                                        @for ($i = 10; $i >= 1; $i--)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                            </div>
                            
                        @else
                        <div class="row">
                            <h3 class="fs-3">
                                This student has already been done !
                            </h3>
                        </div>
                        @endif
                    </div> 
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                     @if($registration->skilltest == null)
                    <button type="submit" class="btn btn-primary">Save</button>
                    @endif
                </div>

            </form>
        </div>
    </div>
</div>
@endforeach
