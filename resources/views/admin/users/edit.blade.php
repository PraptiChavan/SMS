@include('layouts.a_header')
@include('layouts.a_sidebar')

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

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="mb-0">Edit User</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <form action="{{ route('user.account.update', ['id' => $account->id]) }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="{{ $account->type }}">
                <div class="card">
                    <div class="card-body">
                        <fieldset class="border border-secondary p-3 form-group">
                            <legend class="d-inline w-auto h6"><b>User Information</b></legend>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="name" style="margin-top: 10px;">Name</label>
                                            <input type="text" name="name" value="{{ $account->name }}" class="form-control @error('name') is-invalid @enderror" id="name" maxlength="50" style="margin-top: 20px;" placeholder="Full Name" required oninput="updateCounter('name', 'nameCounter')">
                                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            <span id="nameCounter" class="char-counter">0/50</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="email" style="margin-top: 10px;">Email</label>
                                            <input type="email" style="margin-top: 20px;" name="email" value="{{ $account->email }}" class="form-control @error('email') is-invalid @enderror" id="email" maxlength="100" style="margin-top: 20px;" placeholder="Email Address" required oninput="updateCounter('email', 'emailCounter')">
                                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            <span id="emailCounter" class="char-counter">0/100</span>
                                        </div>
                                    </div>
                                    @if ($account->type === 'student' && isset($student))
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="dob" style="margin-top: 20px;">DOB</label>
                                                <input type="date" style="margin-top: 20px; padding-right: 10px;" name="dob" value="{{ $student->dob }}" class="form-control @error('dob') is-invalid @enderror" id="dob" required>
                                                @error('dob') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="mobile" style="margin-top: 20px;">Mobile</label>
                                                <input type="text" style="margin-top: 20px;" name="mobile" value="{{ $student->mobile }}" class="form-control @error('mobile') is-invalid @enderror"  placeholder="Mobile" id="mobile" maxlength="10" oninput="validateMobile(this)" required>
                                                @error('mobile') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <!-- Address Fields -->
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="address" style="margin-top: 20px;">Address</label>
                                                <input type="text" style="margin-top: 20px;" maxlength="50" class="form-control @error('address') is-invalid @enderror" 
                                                        placeholder="Address" name="address" id="address" required oninput="updateCounter('address', 'addressCounter')" value="{{ $student->address }}">
                                                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                <span id="addressCounter" class="char-counter">0/50</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="country" style="margin-top: 20px;">Country</label>
                                                <input type="text" style="margin-top: 20px;" class="form-control @error('country') is-invalid @enderror" 
                                                        placeholder="Country" name="country" id="country" value="{{ $student->country }}">
                                                @error('country') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="state" style="margin-top: 20px;">State</label>
                                                <input type="text" style="margin-top: 20px;" class="form-control @error('state') is-invalid @enderror" 
                                                        placeholder="State" name="state" id="state" value="{{ $student->state }}">
                                                @error('state') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="zip" style="margin-top: 20px;">Pin/Zip Code</label>
                                                <input type="text" style="margin-top: 20px;" class="form-control @error('zip') is-invalid @enderror" 
                                                        placeholder="Pin/Zip Code" name="zip" id="zip" value="{{ $student->zip }}">
                                                @error('zip') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    @endif
                                </div>
                        </fieldset>
                        @if ($account->type === 'student' && isset($student))
                            <fieldset class="border border-secondary p-3 form-group">
                                <legend class="d-inline w-auto h6"><b>Parent Information</b></legend>
                                <div class="row">
                                    <!-- Parent's information -->
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="father_name" style="margin-top: 10px;">Father's Name</label>
                                            <input type="text" class="form-control @error('father_name') is-invalid @enderror" maxlength="50" style="margin-top: 20px;" placeholder="Father's Name" 
                                                    name="father_name" id="father_name"required oninput="updateCounter('father_name', 'father_nameCounter')" value="{{ $student->father_name }}">
                                            @error('father_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            <span id="father_nameCounter" class="char-counter">0/50</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="father_mobile" style="margin-top: 10px;">Father's Mobile</label>
                                            <input type="text" style="margin-top: 20px;" maxlength="10" class="form-control @error('father_mobile') is-invalid @enderror" 
                                                    placeholder="Father's Mobile" name="father_mobile" id="father_mobile" value="{{ $student->father_mobile }}" oninput="validateMobile(this)">
                                            @error('father_mobile') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="father_email" style="margin-top: 10px;">Father's Email</label>
                                            <input type="email" style="margin-top: 20px;" maxlength="50" required class="form-control @error('father_email') is-invalid @enderror" 
                                                    placeholder="Email Address" name="father_email" id="father_email" required oninput="updateCounter('father_email', 'father_emailCounter')" value="{{ $student->father_email }}">
                                            @error('father_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            <span id="father_emailCounter" class="char-counter">0/50</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="mother_name" style="margin-top: 20px;">Mother's Name</label>
                                            <input type="text" class="form-control @error('mother_name') is-invalid @enderror" maxlength="50" style="margin-top: 20px;" placeholder="Mother's Name" 
                                                    name="mother_name" id="mother_name"required oninput="updateCounter('mother_name', 'mother_nameCounter')" value="{{ $student->mother_name }}">
                                            @error('mother_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            <span id="mother_nameCounter" class="char-counter">0/50</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="mother_mobile" style="margin-top: 20px;">Mother's Mobile</label>
                                            <input type="text" style="margin-top: 20px;" maxlength="10" class="form-control @error('mother_mobile') is-invalid @enderror" 
                                                    placeholder="Mother's Mobile" name="mother_mobile" id="mother_mobile" value="{{ $student->mother_mobile }}" oninput="validateMobile(this)">
                                            @error('mother_mobile') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="mother_email" style="margin-top: 20px;">Mother's Email</label>
                                            <input type="email" style="margin-top: 20px;" maxlength="50" required class="form-control @error('mother_email') is-invalid @enderror" 
                                                    placeholder="Email Address" name="mother_email" id="mother_email" required oninput="updateCounter('mother_email', 'mother_emailCounter')" value="{{ $student->mother_email }}">
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
                                                    placeholder="School Name" name="school_name" id="school_name" required oninput="updateCounter('school_name', 'school_nameCounter')" value="{{ $student->school_name }}">
                                            @error('school_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            <span id="school_nameCounter" class="char-counter">0/50</span>
                                        </div>
                                    </div>
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="previous_class" style="margin-top: 20px;">Class</label>
                                            <input type="text" style="margin-top: 20px;" class="form-control @error('previous_class') is-invalid @enderror" 
                                                    placeholder="Class" name="previous_class" id="previous_class" value="{{ $student->previous_class }}">
                                            @error('previous_class') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="status" style="margin-top: 20px;">Status</label>
                                            <select style="margin-top: 20px;" class="form-control @error('status') is-invalid @enderror" 
                                                    name="status" id="status">
                                                <option value="">Select Status</option>
                                                <option value="passed" {{ isset($student) && $student->status == 'passed' ? 'selected' : '' }}>Passed</option>
                                                <option value="failed" {{ isset($student) && $student->status == 'failed' ? 'selected' : '' }}>Failed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="total_marks" style="margin-top: 20px;">Total Marks</label>
                                            <input type="number" style="margin-top: 20px; padding-right: 10px;" class="form-control @error('total_marks') is-invalid @enderror" 
                                                    placeholder="Total Marks" name="total_marks" id="total_marks" value="{{ $student->total_marks }}" oninput="validateMarks(); calculatePercentage()">
                                            @error('total_marks') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg">
                                        <div class="form-group">
                                            <label for="obtain_marks" style="margin-top: 20px;">Obtain Marks</label>
                                            <input type="number" style="margin-top: 20px; padding-right: 10px;" class="form-control @error('obtain_marks') is-invalid @enderror" 
                                                    placeholder="Obtain Marks" name="obtain_marks" id="obtain_marks" value="{{ $student->obtain_marks }}" oninput="validateMarks(); calculatePercentage()">
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
                                                    placeholder="Percentage" name="previous_percentage" id="previous_percentage" value="{{ $student->previous_percentage }}" readonly>
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
                                                        {{ isset($student) && $student->classes == $class->id ? 'selected' : '' }}>
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
                                                        {{ isset($student) && $student->sections == $section->id ? 'selected' : '' }}>
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
                                                    placeholder="Stream" name="stream" id="stream" required oninput="updateCounter('stream', 'streamCounter')" value="{{ $student->stream }}">
                                            @error('stream') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            <span id="streamCounter" class="char-counter">0/50</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="doa" style="margin-top: 20px;">Date of Admission</label>
                                            <input type="date" style="margin-top: 20px; padding-right: 10px;" required class="form-control @error('doa') is-invalid @enderror" 
                                                    name="doa" id="doa" value="{{ $student->doa }}">
                                            @error('doa') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            <div class="form-group">
                                <label for="online-payment" style="margin-top: 20px;">
                                    <input type="radio" name="payment_method" value="Online" id="online-payment"
                                        {{ isset($student) && $student->payment_method == 'Online' ? 'checked' : '' }} onchange="toggleOfflinePaymentFields()">
                                    Online Payment
                                </label>
                                <label for="offline-payment" style="margin-top: 20px; margin-left: 20px">
                                    <input type="radio" name="payment_method" value="Offline" id="offline-payment"
                                        {{ isset($student) && $student->payment_method == 'Offline' ? 'checked' : '' }} onchange="toggleOfflinePaymentFields()">
                                    Offline Payment
                                </label>
                            </div>

                            <fieldset id="offline-payment-fields" class="border border-secondary p-3 form-group" style="margin-top: 30px;">
                                <legend class="d-inline w-auto h6"><b>Offline Payment Details</b></legend>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="receipt_number" style="margin-top: 20px;">Receipt Number</label>
                                            <input type="text" value="{{ $student->receipt_number }}" name="receipt_number" style="margin-top: 20px;" class="form-control" id="receipt_number" maxlength="50" placeholder="Enter Receipt Number" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="registration_fee" style="margin-top: 20px;">Registration Fee</label>
                                            <input type="number" value="{{ $student->registration_fee }}" name="registration_fee" style="margin-top: 20px; padding-right: 10px;" class="form-control" id="registration_fee" maxlength="100" placeholder="Enter Registration Fee" required>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        @endif     
                        <!-- Submit Button -->
                        <button type="submit" id="submitBtn" class="btn btn-success" style="margin-top: 20px;">
                        Update
                        </button>
                        <a href="{{ route('user.account', ['user' => $account->type]) }}" class="btn btn-danger" style="margin-top: 20px;">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Script for updating counters -->
<script>
    function updateCounter(inputId, counterId) {
        let inputElement = document.getElementById(inputId);
        let counterElement = document.getElementById(counterId);
        counterElement.textContent = `${inputElement.value.length}/${inputElement.maxLength}`;
    }
</script>

<!-- Script for getting the selected sections in case of edit function and getting sections by class -->
<script>
    $(document).ready(function() {
        var selectedSection = "{{ old('sections', $student->sections ?? '') }}"; // Get previous section

        function loadSections(classId, selectedSection) {
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
        }

        $('#classes').on('change', function() {
            var classId = $(this).val();
            console.log("Selected Class ID:", classId);
            loadSections(classId, "");
        });

        // Trigger change event to reload sections if a class was already selected in edit mode
        var selectedClass = $('#classes').val();
        if (selectedClass) {
            loadSections(selectedClass, selectedSection);
        }
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

<!-- Script for handling offline form appearance-->
<script>
    function toggleOfflinePaymentFields() {
        let offlineFields = document.getElementById("offline-payment-fields");
        let isOfflineSelected = document.getElementById("offline-payment").checked;
        
        if (isOfflineSelected) {
            offlineFields.style.display = "block";
        } else {
            offlineFields.style.display = "none";
        }
    }

    // Call function on page load to maintain state
    document.addEventListener("DOMContentLoaded", toggleOfflinePaymentFields);
</script>

@include('layouts.a_footer')