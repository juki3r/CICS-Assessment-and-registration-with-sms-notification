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

                <div class="d-flex justify-content-between align-items-center mb-4">
                <!-- Left: Title -->
                <h1 class="fs-3 m-0">Questions</h1>

                <!-- Center: Timer with edit button -->
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-clock-history fs-4 text-primary"></i>
                    <span class="fs-5">Time limit: <strong>{{ $timers }}</strong> minutes</span>
                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Edit
                    </button>
                </div>

                <!-- Right: Action buttons -->
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="bi bi-plus-circle"></i> Add Question
                    </button>
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#percentModal">
                        <i class="bi bi-percent"></i> Scoring
                    </button>
                </div>
            </div>

 
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

                <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-2" id="exampleModalLabel">Edit time limit</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('edit.timer')}}" method="POST">
                                @csrf
                                <h3 class="fs-4">Enter Minutes</h3>
                                <input type="number" class="form-control" name="timer" id="" placeholder="Enter time limit in minutes" required>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                        </form>
                        </div>
                    </div>
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


                <!-- Percentage Scoring Modal -->
                <div class="modal fade" id="percentModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg">
                            <div class="modal-header bg-primary text-white">
                                <h1 class="modal-title fs-5">
                                    <i class="bi bi-percent me-2"></i> Percentage Scoring
                                </h1>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body p-4">
                                @if (session('status'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('status') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('scoring.update') }}">
                                    @csrf

                                    <div class="row g-3">
                                        <!-- Interview -->
                                        <div class="col-md-6">
                                            <label for="interview" class="form-label fw-semibold">
                                                Interview <span class="text-muted">(e.g., 20)</span>
                                            </label>
                                            <input type="number" step="0.1" name="interview" id="interview"
                                                value="{{ old('interview', $scoring->interview *100 ?? 0) }}"
                                                class="form-control form-control-lg @error('interview') is-invalid @enderror" required>
                                            @error('interview')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- GWA -->
                                        <div class="col-md-6">
                                            <label for="gwa" class="form-label fw-semibold">
                                                GWA <span class="text-muted">(e.g., 30)</span>
                                            </label>
                                            <input type="number" step="0.1" name="gwa" id="gwa"
                                                value="{{ old('gwa', $scoring->gwa*100 ?? 0) }}"
                                                class="form-control form-control-lg @error('gwa') is-invalid @enderror" required>
                                            @error('gwa')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Skill Test -->
                                        <div class="col-md-6">
                                            <label for="skilltest" class="form-label fw-semibold">
                                                Skill Test <span class="text-muted">(e.g., 25)</span>
                                            </label>
                                            <input type="number" step="0.1" name="skilltest" id="skilltest"
                                                value="{{ old('skilltest', (int)$scoring->skilltest ?? 0) }}"
                                                class="form-control form-control-lg @error('skilltest') is-invalid @enderror" required>
                                            @error('skilltest')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Exam -->
                                        <div class="col-md-6">
                                            <label for="exam" class="form-label fw-semibold">
                                                Exam <span class="text-muted">(e.g., 25)</span>
                                            </label>
                                            <input type="number" step="0.1" name="exam" id="exam"
                                                value="{{ old('exam', $scoring->exam*100 ?? 0) }}"
                                                class="form-control form-control-lg @error('exam') is-invalid @enderror" required>
                                            @error('exam')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="text-end mt-4">
                                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">
                                            <i class="bi bi-x-circle"></i> Cancel
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-save2"></i> Save Changes
                                        </button>
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
