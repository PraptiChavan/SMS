<style>
    .form-group {
        position: relative; /* Make sure form-group is relatively positioned to position the counter */
    }

    .form-control {
        padding-right: 50px; /* Leaves space for the counter */
    }

    .char-counter {
        position: absolute;
        right: 10px; /* Shift the counter to the right */
        top: 81%; /* Vertically align the counter */
        transform: translateY(-50%); /* Ensure the counter is perfectly centered vertically */
        font-size: 13px;
        color: gray;
        background: transparent;
        padding: 10px;
        pointer-events: none;
    }

    #loadingOverlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(255, 255, 255, 0.5); /* Dark transparent background */
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999; /* Ensure it's above all other elements */
        display: none; /* Initially hidden */
    }

    .spinner-box {
        background: transparent; /* Slightly visible background */
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        color:#0000cd;
    }

    /* New styles for legend */
    fieldset {
        position: relative;
        border-top: 2px solid #000; /* Horizontal line */
        margin-top: 20px;
        padding-top: 20px;
    }

    legend {
        position: absolute;
        top: -10px; /* Adjusts vertical alignment */
        left: 10px; /* Adjusts horizontal alignment */
        background: #fff; /* Cuts through the horizontal line */
        padding: 0 10px; /* Adds spacing around text */
        font-size: 14px; /* Adjust font size */
        color: #000; /* Adjust text color */
    }
</style> 

<form action="{{ route('user.account.store') }}" method="POST" id="registerForm">
    @csrf
    <input type="hidden" name="type" value="{{ $account->type ?? $user }}">
    <div class="card">
        <div class="card-body">
            <fieldset class="border border-secondary p-3 form-group">
                <legend class="d-inline w-auto h6"><b>Student Information</b></legend>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="name" style="margin-top: 10px;">Full Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" maxlength="50" style="margin-top: 20px;" placeholder="Full Name" 
                                    name="name" id="name"required oninput="updateCounter('name', 'nameCounter')" value="{{ old('name', $student->name ?? '') }}">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <span id="nameCounter" class="char-counter">0/50</span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email" style="margin-top: 10px;">Email</label>
                            <input type="email" style="margin-top: 20px;" maxlength="50" required class="form-control @error('email') is-invalid @enderror" 
                                    placeholder="Email Address" name="email" id="email" required oninput="updateCounter('email', 'emailCounter')" value="{{ old('email', $student->email ?? '') }}">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <span id="emailCounter" class="char-counter">0/50</span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="dob" style="margin-top: 20px;">DOB</label>
                            <input type="date" style="margin-top: 20px; padding-right: 10px;" required class="form-control @error('dob') is-invalid @enderror" 
                                    name="dob" id="dob" value="{{ old('dob', $student->dob ?? '') }}">
                            @error('dob') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="mobile" style="margin-top: 20px;">Mobile</label>
                            <input type="text" style="margin-top: 20px;" maxlength="10" class="form-control @error('mobile') is-invalid @enderror" 
                                    placeholder="Mobile" name="mobile" id="mobile" value="{{ old('mobile', $student->mobile ?? '') }}" oninput="validateMobile(this)">
                            @error('mobile') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <!-- Address Fields -->
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="address" style="margin-top: 20px;">Address</label>
                            <input type="text" style="margin-top: 20px;" maxlength="50" class="form-control @error('address') is-invalid @enderror" 
                                    placeholder="Address" name="address" id="address" required oninput="updateCounter('address', 'addressCounter')" value="{{ old('address', $student->address ?? '') }}">
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <span id="addressCounter" class="char-counter">0/50</span>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="country" style="margin-top: 20px;">Country</label>
                            <input type="text" style="margin-top: 20px;" class="form-control @error('country') is-invalid @enderror" 
                                    placeholder="Country" name="country" id="country" value="{{ old('country', $student->country ?? '') }}">
                            @error('country') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="state" style="margin-top: 20px;">State</label>
                            <input type="text" style="margin-top: 20px;" class="form-control @error('state') is-invalid @enderror" 
                                    placeholder="State" name="state" id="state" value="{{ old('state', $student->state ?? '') }}">
                            @error('state') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="zip" style="margin-top: 20px;">Pin/Zip Code</label>
                            <input type="text" style="margin-top: 20px;" class="form-control @error('zip') is-invalid @enderror" 
                                    placeholder="Pin/Zip Code" name="zip" id="zip" value="{{ old('zip', $student->zip ?? '') }}">
                            @error('zip') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset class="border border-secondary p-3 form-group" style="margin-top: 30px;">
                <legend class="d-inline w-auto h6"><b>Parent Information</b></legend>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="father_name" style="margin-top: 10px;">Father's Name</label>
                            <input type="text" class="form-control @error('father_name') is-invalid @enderror" maxlength="50" style="margin-top: 20px;" placeholder="Father's Name" 
                                    name="father_name" id="father_name"required oninput="updateCounter('father_name', 'father_nameCounter')" value="{{ old('father_name', $student->father_name ?? '') }}">
                            @error('father_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <span id="father_nameCounter" class="char-counter">0/50</span>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="father_mobile" style="margin-top: 10px;">Father's Mobile</label>
                            <input type="text" style="margin-top: 20px;" maxlength="10" class="form-control @error('father_mobile') is-invalid @enderror" 
                                    placeholder="Father's Mobile" name="father_mobile" id="father_mobile" value="{{ old('father_mobile', $student->father_mobile ?? '') }}" oninput="validateMobile(this)">
                            @error('father_mobile') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="father_email" style="margin-top: 10px;">Father's Email</label>
                            <input type="email" style="margin-top: 20px;" maxlength="50" required class="form-control @error('father_email') is-invalid @enderror" 
                                    placeholder="Email Address" name="father_email" id="father_email" required oninput="updateCounter('father_email', 'father_emailCounter')" value="{{ old('father_email', $student->father_email ?? '') }}">
                            @error('father_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <span id="father_emailCounter" class="char-counter">0/50</span>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="mother_name" style="margin-top: 20px;">Mother's Name</label>
                            <input type="text" class="form-control @error('mother_name') is-invalid @enderror" maxlength="50" style="margin-top: 20px;" placeholder="Mother's Name" 
                                    name="mother_name" id="mother_name"required oninput="updateCounter('mother_name', 'mother_nameCounter')" value="{{ old('mother_name', $student->mother_name ?? '') }}">
                            @error('mother_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <span id="mother_nameCounter" class="char-counter">0/50</span>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="mother_mobile" style="margin-top: 20px;">Mother's Mobile</label>
                            <input type="text" style="margin-top: 20px;" maxlength="10" class="form-control @error('mother_mobile') is-invalid @enderror" 
                                    placeholder="Mother's Mobile" name="mother_mobile" id="mother_mobile" value="{{ old('mother_mobile', $student->mother_mobile ?? '') }}" oninput="validateMobile(this)">
                            @error('mother_mobile') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="mother_email" style="margin-top: 20px;">Mother's Email</label>
                            <input type="email" style="margin-top: 20px;" maxlength="50" required class="form-control @error('mother_email') is-invalid @enderror" 
                                    placeholder="Email Address" name="mother_email" id="mother_email" required oninput="updateCounter('mother_email', 'mother_emailCounter')" value="{{ old('mother_email', $student->mother_email ?? '') }}">
                            @error('mother_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <span id="mother_emailCounter" class="char-counter">0/50</span>
                        </div>
                    </div>
                    <!-- Address Fields -->
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="parents_address" style="margin-top: 20px;">Address</label>
                            <input type="text" style="margin-top: 20px;" maxlength="50" class="form-control @error('parents_address') is-invalid @enderror" 
                                    placeholder="Address" name="parents_address" id="parents_address" required oninput="updateCounter('parents_address', 'parents_addressCounter')" value="{{ old('parents_address', $student->parents_address ?? '') }}">
                            @error('parents_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <span id="parents_addressCounter" class="char-counter">0/50</span>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="parents_country" style="margin-top: 20px;">Country</label>
                            <input type="text" style="margin-top: 20px;" class="form-control @error('parents_country') is-invalid @enderror" 
                                    placeholder="Country" name="parents_country" id="parents_country" value="{{ old('parents_country', $student->parents_country ?? '') }}">
                            @error('parents_country') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="parents_state" style="margin-top: 20px;">State</label>
                            <input type="text" style="margin-top: 20px;" class="form-control @error('parents_state') is-invalid @enderror" 
                                    placeholder="State" name="parents_state" id="parents_state" value="{{ old('parents_state', $student->parents_state ?? '') }}">
                            @error('parents_state') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="parents_zip" style="margin-top: 20px;">Pin/Zip Code</label>
                            <input type="text" style="margin-top: 20px;" class="form-control @error('parents_zip') is-invalid @enderror" 
                                    placeholder="Pin/Zip Code" name="parents_zip" id="parents_zip" value="{{ old('parents_zip', $student->parents_zip ?? '') }}">
                            @error('parents_zip') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset class="border border-secondary p-3 form-group" style="margin-top: 30px;">
                <legend class="d-inline w-auto h6"><b>Last Qualification</b></legend>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="school_name" style="margin-top: 10px;">School Name</label>
                            <input type="text" style="margin-top: 20px;" maxlength="50" class="form-control @error('school_name') is-invalid @enderror" 
                                    placeholder="School Name" name="school_name" id="school_name" required oninput="updateCounter('school_name', 'school_nameCounter')" value="{{ old('school_name', $student->school_name ?? '') }}">
                            @error('school_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <span id="school_nameCounter" class="char-counter">0/50</span>
                        </div>
                    </div>
                    <div class="col-lg">
                        <div class="form-group">
                            <label for="previous_class" style="margin-top: 20px;">Class</label>
                            <input type="text" style="margin-top: 20px;" class="form-control @error('previous_class') is-invalid @enderror" 
                                    placeholder="Class" name="previous_class" id="previous_class" value="{{ old('previous_class', $student->previous_class ?? '') }}">
                            @error('previous_class') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-lg">
                        <div class="form-group">
                            <label for="status" style="margin-top: 20px;">Status</label>
                            <select style="margin-top: 20px;" class="form-control @error('status') is-invalid @enderror" 
                                    name="status" id="status" value="{{ old('status', $student->status ?? '') }}">
                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror>
                                <option value="">Select Status</option>
                                <option value="passed">Passed</option>
                                <option value="failed">Failed</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg">
                        <div class="form-group">
                            <label for="total_marks" style="margin-top: 20px;">Total Marks</label>
                            <input type="number" style="margin-top: 20px; padding-right: 10px;" class="form-control @error('total_marks') is-invalid @enderror" 
                                    placeholder="Total Marks" name="total_marks" id="total_marks" value="{{ old('total_marks', $student->total_marks ?? '') }}" oninput="calculatePercentage()">
                            @error('total_marks') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-lg">
                        <div class="form-group">
                            <label for="obtain_marks" style="margin-top: 20px;">Obtain Marks</label>
                            <input type="number" style="margin-top: 20px; padding-right: 10px;" class="form-control @error('obtain_marks') is-invalid @enderror" 
                                    placeholder="Obtain Marks" name="obtain_marks" id="obtain_marks" value="{{ old('obtain_marks', $student->obtain_marks ?? '') }}" oninput="calculatePercentage()">
                            <div id="marks-error" class="text-danger" style="margin-top: 5px; display: none; font-size: 12px; line-height: 1; width: 100%; white-space: nowrap;">
                                Obtain Marks cannot exceed Total Marks.
                            </div>
                            @error('obtain_marks') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-lg">
                        <div class="form-group">
                            <label for="previous_percentage" style="margin-top: 20px;">Percentage</label>
                            <input type="text" style="margin-top: 20px;" class="form-control @error('previous_percentage') is-invalid @enderror" 
                                    placeholder="Percentage" name="previous_percentage" id="previous_percentage" value="{{ old('previous_percentage', $student->previous_percentage ?? '') }}" readonly>
                            @error('previous_percentage') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset class="border border-secondary p-3 form-group" style="margin-top: 30px;">
                <legend class="d-inline w-auto h6"><b>Admission Details</b></legend>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="classes" style="margin-top: 10px;">Select Class</label>
                            <select name="classes" id="classes" class="form-control" style="margin-top: 20px;" required>
                                <option value="">Select Class</option>
                                @if(isset($classes) && $classes->isNotEmpty())
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}" 
                                            {{ old('classes', $student->classes ?? '') == $class->id ? 'selected' : '' }}>
                                            {{ $class->title }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="">No Classes Available</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="sections" style="margin-top: 10px;">Select Section</label>
                            <select name="sections" id="sections" class="form-control" style="margin-top: 20px;" required>
                                <option value="">Select Section</option>
                                @if(isset($sections) && $sections->isNotEmpty())
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}" 
                                            {{ old('sections', $student->sections ?? '') == $section->id ? 'selected' : '' }}>
                                            {{ $section->title }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="stream" style="margin-top: 20px;">Stream</label>
                            <input type="text" style="margin-top: 20px;" maxlength="50" class="form-control @error('stream') is-invalid @enderror" 
                                    placeholder="Stream" name="stream" id="stream" required oninput="updateCounter('stream', 'streamCounter')" value="{{ old('stream', $student->stream ?? '') }}">
                            @error('stream') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <span id="streamCounter" class="char-counter">0/50</span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="doa" style="margin-top: 20px;">Date of Admission</label>
                            <input type="date" style="margin-top: 20px; padding-right: 10px;" required class="form-control @error('doa') is-invalid @enderror" 
                                    name="doa" id="doa" value="{{ old('doa', $student->doa ?? '') }}" min="{{ date('Y-m-d') }}">
                            @error('doa') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </fieldset>

            <div class="form-group">
                <label for="online-payment" style="margin-top: 20px;">
                    <input type="radio" name="payment_method" value="Online" id="online-payment"> Online Payment
                </label>
                <label for="offline-payment" style="margin-top: 20px; margin-left: 20px">
                    <input type="radio" name="payment_method" value="Offline" id="offline-payment"> Offline Payment
                </label>
            </div>
        </div>
    </div>
</form>


<form action="{{ route('user.account.store') }}" method="POST" id="offlinePaymentForm" style="display: none;">
    @csrf
    <input type="hidden" name="student_id" value="{{ request()->student_id }}">
    <div class="card">
        <div class="card-body">
            <h4>Offline Payment Details</h4>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="receipt_number" style="margin-top: 20px;">Receipt Number</label>
                        <input type="text" name="receipt_number" style="margin-top: 20px;" class="form-control" id="receipt_number" maxlength="50" placeholder="Enter Receipt Number" required>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="registration_fee" style="margin-top: 20px;">Registration Fee</label>
                        <input type="number" name="registration_fee" style="margin-top: 20px; padding-right: 10px;" class="form-control" id="registration_fee" maxlength="100" placeholder="Enter Registration Fee" required>
                    </div>
                </div>
            </div>
            <!-- Submit Button -->
            <button type="submit" id="submitBtn" class="btn btn-success" style="margin-top: 20px;">
                Submit Payment
            </button>
            <!-- Loading Spinner -->
            <!-- Full-Screen Loading Overlay -->
            <div id="loadingOverlay" style="display: none !important;">
                <div class="spinner-box">
                    <img src="{{ asset('assets/img/admin/users/loading.gif') }}" alt="Loading..." width="80">
                    <p><b>Processing, please wait...</b></p>
                </div>
            </div>
        </div>
    </div>
</form>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Script for Hiding the Form on Radio Button Click -->
<script>
    $(document).ready(function() {
        $('input[name="payment_method"]').change(function() {
            let selectedValue = $(this).val();

            // Ensure the selected radio button visually updates
            $(this).prop("checked", true);

            // Add a small delay to let the selection be visible before switching forms
            setTimeout(function() {
                if (selectedValue === 'Offline') {
                    $('#registerForm').fadeOut(300, function() {
                        $('#offlinePaymentForm').fadeIn(300);
                    });
                } else {
                    $('#offlinePaymentForm').fadeOut(300, function() {
                        $('#registerForm').fadeIn(300);
                    });
                }
            }, 300); // Delay to allow radio button selection animation
        });

        $('#offlinePaymentForm').on('submit', function(event) {
            event.preventDefault();

            // Show the loading spinner immediately when the form is submitted
            $('#loadingOverlay').fadeIn();

            // Get data from both forms
            let formData = $('#registerForm').serialize() + '&' + $('#offlinePaymentForm').serialize();

            $.ajax({
                url: "{{ route('user.account.store') }}",
                type: "POST",
                data: formData,
                dataType: "json",
                success: function(response) {
                    $('#loadingOverlay').fadeOut(); // Hide spinner before showing pop-up
                    
                    if (!response.success) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.message,
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Payment Recorded',
                            text: response.message,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false, // Prevent users from dismissing it accidentally
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Show spinner before redirecting
                                $('#loadingOverlay').fadeIn();
                                setTimeout(function() {
                                    window.location.href = "{{ route('user.account', ['user' => $user]) }}";
                                }, 1500);
                            }
                        });
                    }
                },
                error: function(xhr) {
                    $('#loadingOverlay').fadeOut(); // Hide spinner before showing pop-up
                    let errorMsg = xhr.responseJSON?.message || 'An error occurred. Please try again.';
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMsg,
                    });
                }
            });
        });
    });
</script>

<!-- Script for validating marks -->
<script>
    function validateMarks() {
        let totalMarks = document.getElementById("total_marks").value;
        let obtainMarks = document.getElementById("obtain_marks").value;
        let errorDiv = document.getElementById("marks-error");

        if (parseFloat(obtainMarks) > parseFloat(totalMarks)) {
            errorDiv.style.display = "block";
            document.getElementById("obtain_marks").classList.add("is-invalid");
        } else {
            errorDiv.style.display = "none";
            document.getElementById("obtain_marks").classList.remove("is-invalid");
        }
    }
</script>

<!-- Script for calculating the percentage -->
<script>
    function calculatePercentage() {
        let totalMarks = document.getElementById("total_marks").value;
        let obtainMarks = document.getElementById("obtain_marks").value;
        let percentageField = document.getElementById("previous_percentage");
        let errorDiv = document.getElementById("marks-error");

        if (totalMarks && obtainMarks) {
            totalMarks = parseFloat(totalMarks);
            obtainMarks = parseFloat(obtainMarks);

            if (obtainMarks > totalMarks) {
                errorDiv.style.display = "block";
                percentageField.value = "";
            } else {
                errorDiv.style.display = "none";
                let percentage = (obtainMarks / totalMarks) * 100;
                percentageField.value = percentage.toFixed(2);
            }
        } else {
            percentageField.value = "";
            errorDiv.style.display = "none";
        }
    }
</script>

<!-- Script for getting the selected sections in case of edit function and getting sections by class -->
<script>
    $(document).ready(function() {
        var selectedSection = "{{ old('sections', $student->sections ?? '') }}"; // Get previous section

        $('#classes').on('change', function() {
            var classId = $(this).val();
            console.log("Selected Class ID:", classId);

            if (classId) {
                $.ajax({
                    url: '{{ url("get-sections") }}/' + classId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log("Sections Received:", data);
                        
                        $('#sections').empty().append('<option value="">Select Section</option>');
                        $.each(data, function(id, title) {
                            var selected = (id == selectedSection) ? 'selected' : ''; // Check if it's the previously selected section
                            $('#sections').append('<option value="' + id + '" ' + selected + '>' + title + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                        alert('Unable to fetch sections.');
                    }
                });
            } else {
                $('#sections').empty().append('<option value="">Select Section</option>');
            }
        });

        // Trigger change event to reload sections if a class was already selected
        if ($('#classes').val()) {
            $('#classes').trigger('change');
        }
    });

</script>

<!-- Script for updating counters -->
<script>
    function updateCounter(inputId, counterId) {
        let inputElement = document.getElementById(inputId);
        let counterElement = document.getElementById(counterId);
        counterElement.textContent = `${inputElement.value.length}/${inputElement.maxLength}`;
    }
</script>

<!-- Script for validating the mobile number to be between 0-9 and 10 numbers only -->
<script>
    function validateMobile(input) {
        // Remove all non-numeric characters
        input.value = input.value.replace(/[^0-9]/g, '');
        // Limit the length to 10 digits
        if (input.value.length > 10) {
            input.value = input.value.slice(0, 10);
        }
    }
</script>