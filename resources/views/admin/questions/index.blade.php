<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase">
            {{ __('Exam Questions') }}
        </h2>
    </x-slot>

    <div class="py-12 d-flex justify-content-center">
        <div class="border rounded w-75 mt-5 p-3 shadow bg-white">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="p-6 text-gray-900">

                <h1 class="d-flex justify-content-between">
                    <span class="fs-3">Questions</span>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                        Add New Question
                    </button>
                </h1>

                {{-- Questions Table --}}
                <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Question</th>
                            <th>Correct Answer</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($questions as $question)
                            <tr>
                                <td>{{ $loop->iteration }}</td>  
                                <td>
                                    @if($question->image)
                                        <img src="{{ asset('storage/' . $question->image) }}"
                                             alt="Question Image"
                                             class="img-thumbnail"
                                             style="width:60px; height:60px; object-fit:cover;">
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </td>
                                <td  class="text-wrap" style="max-width: 300px; white-space: normal; word-wrap: break-word;">
                                    {{ $question->question }}
                                </td>
                                <td class="fw-bold">{{ strtoupper($question->correct_answer) }}</td>
                                <td>
                                    <button type="button"
                                            class="btn btn-sm btn-warning"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $question->id }}">
                                        Edit
                                    </button>
                                    <form action="{{ route('questions.destroy', $question->id) }}"
                                          method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Delete this question?')">Delete</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal{{ $question->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5">Edit Question</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="{{ route('questions.update', $question->id) }}" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                                <div class="mb-3">
                                                    <label>Question</label>
                                                    <input type="text" name="question" class="form-control" value="{{ $question->question }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Image (optional)</label><br>
                                                    @if($question->image)
                                                        <img src="{{ asset('storage/' . $question->image) }}" class="img-thumbnail mb-2" style="width:100px; height:100px;">
                                                    @endif
                                                    <input type="file" name="image" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label>Option A</label>
                                                    <input type="text" name="option_a" class="form-control" value="{{ $question->option_a }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Option B</label>
                                                    <input type="text" name="option_b" class="form-control" value="{{ $question->option_b }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Option C</label>
                                                    <input type="text" name="option_c" class="form-control" value="{{ $question->option_c }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Option D</label>
                                                    <input type="text" name="option_d" class="form-control" value="{{ $question->option_d }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Option E</label>
                                                    <input type="text" name="option_e" class="form-control" value="{{ $question->option_e }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label>Correct Answer</label>
                                                    <select name="correct_answer" class="form-control" required>
                                                        <option value="">--Select--</option>
                                                        <option value="a" {{ $question->correct_answer == 'a' ? 'selected' : '' }}>A</option>
                                                        <option value="b" {{ $question->correct_answer == 'b' ? 'selected' : '' }}>B</option>
                                                        <option value="c" {{ $question->correct_answer == 'c' ? 'selected' : '' }}>C</option>
                                                        <option value="d" {{ $question->correct_answer == 'd' ? 'selected' : '' }}>D</option>
                                                        <option value="e" {{ $question->correct_answer == 'e' ? 'selected' : '' }}>E</option>
                                                    </select>
                                                </div>

                                                <div class="d-flex justify-content-between">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
                </div>

                <div class="d-flex justify-content-center">
                    {{ $questions->links() }}
                </div>

                <!-- Add Modal -->
                <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Add New Question</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('questions.store') }}" enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-3">
                                        <label>Question</label>
                                        <input type="text" name="question" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Image (optional)</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label>Option A</label>
                                        <input type="text" name="option_a" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Option B</label>
                                        <input type="text" name="option_b" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Option C</label>
                                        <input type="text" name="option_c" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Option D</label>
                                        <input type="text" name="option_d" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Option E</label>
                                        <input type="text" name="option_e" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label>Correct Answer</label>
                                        <select name="correct_answer" class="form-control" required>
                                            <option value="">--Select--</option>
                                            <option value="a">A</option>
                                            <option value="b">B</option>
                                            <option value="c">C</option>
                                            <option value="d">D</option>
                                            <option value="e">E</option>
                                        </select>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-success">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- /p-6 -->
        </div>
    </div>
</x-app-layout>
