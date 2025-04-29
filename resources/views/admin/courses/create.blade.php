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
                    <h3 class="mb-0">Add New Course</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.courses') }}" id="backToCourses">Courses</a></li>
                        <li class="breadcrumb-item active">Add New Course</li>
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
                    <h3 class="card-title">Add New Course</h3>
                </div>
                <div class="card-body">
                    <form id="addCourseForm" enctype="multipart/form-data" method="#" action="#">
                        @csrf
                        <div class="form-group">
                            <label for="name">Course Name</label>
                            <input type="text" name="name" class="form-control" id="name" maxlength="50" style="margin-top: 20px;" placeholder="Course Name" required oninput="updateCounter('name', 'nameCounter')">
                            <span id="nameCounter" class="char-counter">0/50</span>
                        </div>
                        <div class="form-group">
                            <label for="category" style="margin-top: 20px;">Course Category</label>
                            <select name="category" id="category" class="form-control" style="margin-top: 20px;">
                                <option value="">Select Category</option>
                                <option value="web-design-and-development">Web Design & Development</option>
                                <option value="app-developement">App Development</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="duration" style="margin-top: 20px;">Course Duration</label>
                            <input type="text" id="duration" name="duration" style="margin-top: 20px;" placeholder="Duration" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="date" style="margin-top: 20px;">Course Start Date</label>
                            <input type="date" id="date" name="date" style="margin-top: 20px; padding-right: 10px;" required class="form-control" min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="form-group">
                            <label for="image" style="margin-top: 20px;">Course Image</label>
                            <input type="file" id="image" name="image" style="margin-top: 20px;" class="form-control">
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

<!-- Script for updating counters -->
<script>
    function updateCounter(inputId, counterId) {
        let inputElement = document.getElementById(inputId);
        let counterElement = document.getElementById(counterId);
        counterElement.textContent = `${inputElement.value.length}/${inputElement.maxLength}`;
    }
</script>

<script>
    $(document).ready(function() {
        $('#addCourseForm').on('submit', function(event) {
            event.preventDefault(); // Stop default Laravel form submission
            
            $('#loadingOverlay').show(); // Show spinner
            
            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('admin.courses.store') }}",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#loadingOverlay').hide(); 
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Course added successfully!',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#loadingOverlay').show();
                            window.location.href = "{{ route('admin.courses') }}";
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
