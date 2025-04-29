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
                    <h3 class="mb-0">Generate New Admit Card</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.admitcards') }}" id="backToAdmit-Cards">Admit-Cards</a></li>
                        <li class="breadcrumb-item active">Generate New Admit-Card</li>
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
                    <h3 class="card-title">Generate New Admit-Card</h3>
                </div>
                <div class="card-body">
                    <form id="addAdmit-CardForm" enctype="multipart/form-data" method="POST" action="{{ route('admin.admitcards.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="classes" style="margin-top: 10px;">Class</label>
                            <select name="classes" id="classes" style="margin-top: 20px;" class="form-control" style="margin-top: 20px;" required>
                                <option value="">Select Category</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="sections" style="margin-top: 20px;">Section</label>
                            <select name="sections" id="sections" style="margin-top: 20px;" class="form-control" style="margin-top: 20px;">
                                <option value="">Select Category</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="student_name" style="margin-top: 20px;">Student Name</label>
                            <select name="student_id" id="student_name" class="form-control" style="margin-top: 20px;" required>
                                <option value="">Select Student</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fees_paid" style="margin-top: 20px;">Fees Paid</label><br>
                            <input type="radio" name="fees_paid" value="Yes" style="margin-top: 20px;"> Yes
                            <input type="radio" name="fees_paid" value="No" style="margin-top: 20px; margin-left: 10px;"> No
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

<script>
    $(document).ready(function () {
        $('#classes, #sections').on('change', function () {
            var classId = $('#classes').val();
            var sectionId = $('#sections').val();

            if (classId && sectionId) {
                $.ajax({
                    url: '/admin/get-students/' + classId + '/' + sectionId, 
                    type: 'GET',
                    success: function (response) {
                        $('#student_name').empty().append('<option value="">Select Student</option>');
                        $.each(response, function (key, value) {
                            $('#student_name').append('<option value="' + key + '">' + value + '</option>');
                        });
                    }
                });
            }
        });
    });
</script>

<script>
    $(document).ready(function () {

        $('input[name="fees_paid"]').on('change', function () {
            if ($(this).val() === 'Yes') {
                $('#submitBtn').prop('disabled', false); // Enable button if Yes is selected
            } else {
                $('#submitBtn').prop('disabled', true);  // Disable button if No is selected

                // Show an error message
                Swal.fire({
                    icon: 'error',
                    title: 'Fees Not Paid',
                    text: 'Admit card cannot be generated because the fees are not paid!',
                });
            }
        });
    });
</script>

@include('layouts.a_footer')