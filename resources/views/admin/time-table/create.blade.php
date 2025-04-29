@include('layouts.a_header')
@include('layouts.a_sidebar')

<style>
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
</style>

<main class="app-main">
    <!-- App Content Header -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Add New Time-Table</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.time-table') }}" id="backToTime">Time Table</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- App Content -->
    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form id="addTimeTableForm" method="#" action="#">
                     @csrf
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="classes" class="mb-3"><b>Select Class</b></label>
                                    <select name="req_classes" id="classes" class="form-control" required>
                                        <option value="">Select Class</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}">{{ $class->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="sections" class="mb-3"><b>Select Section</b></label>
                                    <select name="req_sections" id="sections" class="form-control" required>
                                        <option value="">Select Section</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="teachers" class="mb-3"><b>Select Teacher</b></label>
                                    <select name="req_teachers" id="teachers" class="form-control" required>
                                        <option value="">Select Teacher</option>
                                        @foreach ($accounts as $account)
                                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="periods" class="mb-3"><b>Select Periods</b></label>
                                    <select name="req_periods" id="periods" class="form-control" required>
                                        <option value="">Select Periods</option>
                                        @foreach ($periods as $period)
                                            <option value="{{ $period->id }}">{{ $period->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="weekdays" class="mb-3"><b>Select Weekdays</b></label>
                                    <select name="req_weekdays" id="weekdays" class="form-control" required>
                                        <option value="">Select Weekdays</option>
                                        @foreach ($weekdays as $weekday)
                                            <option value="{{ $weekday->id }}">{{ $weekday->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="subjects" class="mb-3"><b>Select Subjects</b></label>
                                    <select name="req_subjects" id="subjects" class="form-control" required>
                                        <option value="">Select Subjects</option>
                                        @foreach ($subjects as $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- Submit Button -->
                        <button type="submit" id="submitBtn" class="btn btn-success" style="margin-top: 20px;">
                            Submit
                        </button>

                        <!-- Loading Spinner -->
                        <!-- Full-Screen Loading Overlay -->
                        <div id="loadingOverlay" style="display: none !important;">
                            <div class="spinner-box">
                                <img src="{{ asset('assets/img/admin/users/loading.gif') }}" alt="Loading..." width="80">
                                <p><b>Processing, please wait...</b></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $('#addTimeTableForm').on('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            // Show loading spinner
            $('#loadingOverlay').show();

            // Collect form data
            let formData = new FormData(this);

            // Perform AJAX request to check if there's a conflict
            $.ajax({
                url: "{{ route('admin.time-table.store') }}",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#loadingOverlay').hide(); // Hide spinner
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Time table entry added successfully!',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('admin.time-table') }}"; // Redirect to time-table page
                        }
                    });
                },
                error: function(xhr) {
                    $('#loadingOverlay').hide(); // Hide spinner
                    if (xhr.status === 400) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: xhr.responseJSON.error || 'Something went wrong.',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Unable to process request. Please try again later.',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            });

            return false; // Prevent normal form submission
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#classes').on('change', function() {
            var classId = $(this).val();
            if (classId) {
                $.ajax({
                    url: '{{ url("get-sections") }}/' + classId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#sections').empty().append('<option value="">Select Section</option>');
                        $.each(data, function(id, title) {
                            $('#sections').append('<option value="' + id + '">' + title + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        alert('Unable to fetch sections.');
                    }
                });
            } else {
                $('#sections').empty().append('<option value="">Select Section</option>');
            }
        });
    });
</script>

@include('layouts.a_footer')