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
        top: 78%; /* Vertically align the counter */
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
</style>

<main class="app-main">
    <!-- App Content Header -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Add New Exam Schedule</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.examform') }}" id="backToExam-Form">Exam-Schedule</a></li>
                        <li class="breadcrumb-item active">Add New Exam-Schedule</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- App Content -->
    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header py-2">
                    <h3 class="card-title">Add New Exam-Schedule</h3>
                </div>
                <div class="card-body">
                    <form id="addExam-ScheduleForm" enctype="multipart/form-data" method="POST" action="{{ route('admin.examform.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="name" maxlength="50" style="margin-top: 20px;" placeholder="Name" required oninput="updateCounter('name', 'nameCounter')">
                            <span id="nameCounter" class="char-counter">0/50</span>
                        </div>
                        <div class="form-group">
                            <label for="classes" style="margin-top: 20px;">Class</label>
                            <select name="classes" id="classes" class="form-control" style="margin-top: 20px;" required>
                                <option value="">Select Class</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="subjects" style="margin-top: 20px;">Subject</label>
                            <select name="subjects" id="subjects" class="form-control" style="margin-top: 20px;" required>
                                <option value="">Select Subject</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="date" style="margin-top: 20px;">Date</label>
                            <input type="date" name="date" id="date" style="margin-top: 20px; padding-right: 10px;" required class="form-control" min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="form-group">
                            <label for="start_time" style="margin-top: 20px;">Start Time</label>
                            <input type="time" id="start_time" name="start_time" style="margin-top: 20px; margin-bottom: 20px; padding-right: 10px;" placeholder="Start Time" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="end_time">End Time</label>
                            <input type="time" id="end_time" name="end_time" style="margin-top: 20px; padding-right: 10px;" placeholder="End Time" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="total_marks" style="margin-top: 20px;">Total Marks</label>
                            <input type="number" style="margin-top: 20px; padding-right: 10px;" class="form-control" placeholder="Total Marks" name="total_marks" id="total_marks" required>
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
    function updateCounter(inputId, counterId) {
        let inputElement = document.getElementById(inputId);
        let counterElement = document.getElementById(counterId);
        counterElement.textContent = `${inputElement.value.length}/${inputElement.maxLength}`;
    }
</script>

<script>
    $(document).ready(function() {
        $('#addExam-ScheduleForm').on('submit', function(event) {
            event.preventDefault(); // Stop default Laravel form submission
            
            $('#loadingOverlay').show(); // Show spinner
            
            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('admin.examform.store') }}",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#loadingOverlay').hide(); 
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Exam-Schedule added successfully!',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#loadingOverlay').show();
                            window.location.href = "{{ route('admin.examform') }}";
                        }
                    });
                },
                error: function(xhr) {
                    $('#loadingOverlay').hide();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: xhr.responseJSON.error || 'Something went wrong. Please try again.',
                    });
                }
            });

            return false; // Ensure form does not submit normally
        });
    });

</script>

@include('layouts.a_footer')
