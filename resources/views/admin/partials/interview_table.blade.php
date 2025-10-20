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
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('registrations.updateInterviewResult', $registration->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title text-capitalize">Interview - {{ $registration->fullname }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="container-fluid">
                        @if($registration->interview_result == null)
                        <div class="row">
                            {{-- LEFT SIDE --}}
                            <div class="col-6 px-4" style="border-right: 2px solid grey">
                                <h3 class="fs-5">Personal Details</h3>

                                <div class="mb-3">
                                    <label class="form-label">Fullname:</label>
                                    <input type="text" class="form-control text-capitalize" value="{{ $registration->fullname }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Address:</label>
                                    <input type="text" class="form-control" name="address" value="{{ $registration->address }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Contact details (.e.g, 09xxx):</label>
                                 <input type="text" pattern="\d{11}" maxlength="11" minlength="11"
                                    class="form-control"
                                    name="contact_details"
                                    value="{{ $registration->contact_details }}"
                                    required
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    title="Please enter exactly 11 digits">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">GWA:</label>
                                    <input type="number" step="0.01" class="form-control" name="gwa" value="{{ $registration->gwa }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Name of school (last attended):</label>
                                    <input type="text" class="form-control" name="school" value="{{ $registration->school }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Strand:</label>
                                    <select name="strand" class="form-select" required>
                                        <option value="">-- Select Strand --</option>
                                        <option value="GAS" {{ $registration->strand == 'GAS' ? 'selected' : '' }}>GAS</option>
                                        <option value="HUMSS" {{ $registration->strand == 'HUMSS' ? 'selected' : '' }}>HUMSS</option>
                                        <option value="STEM" {{ $registration->strand == 'STEM' ? 'selected' : '' }}>STEM</option>
                                        <option value="TVL" {{ $registration->strand == 'TVL' ? 'selected' : '' }}>TVL</option>
                                        <option value="ICT" {{ $registration->strand == 'ICT' ? 'selected' : '' }}>ICT</option>
                                        <option value="ABM" {{ $registration->strand == 'ABM' ? 'selected' : '' }}>ABM</option>
                                        <option value="SMAW" {{ $registration->strand == 'SMAW' ? 'selected' : '' }}>SMAW</option>
                                        <option value="Others" {{ $registration->strand == 'Others' ? 'selected' : '' }}>Others</option>
                                    </select>
                                </div>
                            </div>

                            {{-- RIGHT SIDE --}}
                            <div class="col-6 px-4">
                                <h4 class="fs-5">Interview Questions</h4>
                                <p class="m-0">1. Tell something about yourself.</p>
                                <p class="m-0">2. Why do you want to study at NISU?</p>
                                <p class="m-0">3. Why are you interested in taking up this course?</p>
                                <p class="m-0">4. What are your academic strengths? (highest grade subject)</p>
                                <p class="m-0">5. What subject in SHS did you find most challenging?</p>
                                <h5 class="fs-5 mt-3">Interview Scoring Sheet</h5>
                                    <p p-0 m-0>Rating scale:</p>
                                    <div class="row d-flex text-center mb-3" style="font-size: 14px">
                                        <div class="col p-0 m-0">5-Excellent</div>
                                        <div class="col p-0 m-0">4-Good</div>
                                        <div class="col p-0 m-0">3-Average</div>
                                        <div class="col p-0 m-0">2-below average</div>
                                        <div class="col p-0 m-0">1-Poor</div>
                                    </div>
                                <div class="table-responsive mt-3">
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                            <tr>
                                                <th>Criteria</th>
                                                <th>Score</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Tone of voice</td>
                                                <td>
                                                    <select name="rating_communication" class="form-select rating" required>
                                                        <option value="">Select</option>
                                                        <option value="5">5 - Excellent</option>
                                                        <option value="4">4 - Good</option>
                                                        <option value="3">3 - Average</option>
                                                        <option value="2">2 - Below Average</option>
                                                        <option value="1">1 - Poor</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Choice of words</td>
                                                <td>
                                                    <select name="rating_confidence" class="form-select rating" required>
                                                        <option value="">Select</option>
                                                        <option value="5">5 - Excellent</option>
                                                        <option value="4">4 - Good</option>
                                                        <option value="3">3 - Average</option>
                                                        <option value="2">2 - Below Average</option>
                                                        <option value="1">1 - Poor</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Ability to present ideas</td>
                                                <td>
                                                    <select name="rating_thinking" class="form-select rating" required>
                                                        <option value="">Select</option>
                                                        <option value="5">5 - Excellent</option>
                                                        <option value="4">4 - Good</option>
                                                        <option value="3">3 - Average</option>
                                                        <option value="2">2 - Below Average</option>
                                                        <option value="1">1 - Poor</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Overall Rating</td>
                                                <td>
                                                    <span class="overall fw-bold">N/A</span>
                                                    <input type="hidden" name="overall_rating" class="overall_input">
                                                </td>
                                            </tr>
                                        </tbody>

                                        <script>

                                        // document.addEventListener("DOMContentLoaded", function () {
                                        //     const ratings = document.querySelectorAll(".rating");
                                        //     const overallSpan = document.querySelector(".overall");
                                        //     const overallInput = document.querySelector(".overall_input");

                                        //     ratings.forEach(select => {
                                        //         select.addEventListener("change", () => {
                                        //             let sum = 0;
                                        //             let count = 0;
                                        //             console.log('selected');

                                        //             ratings.forEach(r => {
                                                        
                                        //                 if (r.value) {
                                        //                     sum += parseInt(r.value);
                                        //                     count++;
                                        //                 }
                                        //             });

                                        //             if (count > 0) {
                                        //                 let avg = (sum / count).toFixed(2);
                                        //                 overallSpan.textContent = avg;
                                        //                 overallInput.value = avg;
                                        //             } else {
                                        //                 overallSpan.textContent = "N/A";
                                        //                 overallInput.value = "";
                                        //             }
                                        //         });
                                        //     });
                                        // });

                                    //     document.addEventListener("DOMContentLoaded", function () {
                                    //     // Loop through all modals
                                    //     document.querySelectorAll('.modal').forEach(modal => {
                                    //         const ratings = modal.querySelectorAll(".rating");
                                    //         const overallSpan = modal.querySelector(".overall");
                                    //         const overallInput = modal.querySelector(".overall_input");

                                    //         if (!ratings.length || !overallSpan || !overallInput) return;

                                    //         ratings.forEach(select => {
                                    //             select.addEventListener("change", () => {
                                    //                 let sum = 0;
                                    //                 let count = 0;

                                    //                 ratings.forEach(r => {
                                    //                     if (r.value) {
                                    //                         sum += parseInt(r.value);
                                    //                         count++;
                                    //                     }
                                    //                 });

                                    //                 if (count > 0) {
                                    //                     const avg = (sum / count).toFixed(2);
                                    //                     overallSpan.textContent = avg;
                                    //                     overallInput.value = avg;
                                    //                 } else {
                                    //                     overallSpan.textContent = "N/A";
                                    //                     overallInput.value = "";
                                    //                 }
                                    //             });
                                    //         });
                                    //     });
                                    // });

                                         </script>


                                    </table>
                                </div>
                                <div class="mt-3 text-center d-flex flex-column justify-content-center align-items-center">
                                    <input type="text" 
                                    name="" id="" 
                                    class="text-center w-75" 
                                    value="{{ Auth::guard('admin')->check() ? Auth::guard('admin')->user()->fullname : (session('subadmin_name') ?? 'Guest') }}" 
                                     readonly style="border: none; border-bottom:1px solid grey">
                                    <span class="mt-2"><strong>Interviewer</strong></span>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="row">
                            <h3 class="fs-3">
                                This student has already been interviewed !
                            </h3>
                        </div>
                        @endif
                    </div> 
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                     @if($registration->interview_result == null)
                    <button type="submit" class="btn btn-primary">Save</button>
                    @endif
                </div>

            </form>
        </div>
    </div>
</div>


@endforeach
