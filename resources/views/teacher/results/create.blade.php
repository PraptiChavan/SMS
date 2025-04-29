@include('layouts.t_header')
@include('layouts.t_sidebar')

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

    /* Horizontal scroll styling for subject container */
    #subjectContainer {
        display: flex;
        flex-wrap: wrap; /* Wrap subjects into rows when space runs out */
        gap: 10px; /* Space between each subject card */
        justify-content: space-between; /* Keep cards evenly spaced */
    }

    #subjectContainer .subject-group {
        flex: 0 0 calc(50% - 5px); /* Each subject takes 50% width minus the gap */
        box-sizing: border-box;
    }

    /* Optional scrollbar styling for a cleaner look */
    #subjectContainer::-webkit-scrollbar {
        height: 8px;
    }

    #subjectContainer::-webkit-scrollbar-thumb {
        background-color: #ddd;
        border-radius: 10px;
    }

    #subjectContainer::-webkit-scrollbar-thumb:hover {
        background-color: #aaa;
    }
</style>

<main class="app-main">
    <!-- App Content Header -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Generate New Result</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Teacher</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('teacher.results') }}" id="backToResults">Result</a></li>
                        <li class="breadcrumb-item active">Generate New Result</li>
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
                    <h3 class="card-title">Generate New Result</h3>
                </div>
                <div class="card-body">
                    <form id="addResultForm" enctype="multipart/form-data" method="POST" action="{{ route('teacher.results.store') }}">
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
                            <label for="exam_name" style="margin-top: 20px;">Exam Name</label>
                            <select name="exam_name" id="exam_name" class="form-control" style="margin-top: 20px;" required>
                                <option value="">Select Exam</option>
                                @foreach ($examform as $examforms)
                                    <option value="{{ $examforms->id }}">{{ $examforms->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="subjectContainer">
                            <!-- Subjects will be dynamically inserted here -->
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
    $(document).ready(function () {
        $('#exam_name').on('change', function () {
            var examId = $(this).val();
            if (examId) {
                $.ajax({
                    url: '/teacher/get-exam-total/' + examId,
                    type: 'GET',
                    success: function (response) {
                        $('#total_marks').val(response.total_marks);
                    },
                    error: function () {
                        $('#total_marks').val('');
                        alert('Failed to fetch total marks.');
                    }
                });
            } else {
                $('#total_marks').val('');
            }
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

<script>
    $(document).ready(function () {
        $('#classes, #sections').on('change', function () {
            var classId = $('#classes').val();
            var sectionId = $('#sections').val();

            if (classId && sectionId) {
                $.ajax({
                    url: '/teacher/get-students/' + classId + '/' + sectionId, 
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
        $('#classes').on('change', function () {
            let classId = $(this).val();

            if (classId) {
                // Clear old exam options to avoid duplicates
                $('#exam_name').empty().append('<option value="">Select Exam</option>');

                // Fetch exams based on the selected class
                $.ajax({
                    url: '/teacher/get-exams/' + classId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        let uniqueExams = new Set(); // Ensure uniqueness
                        $.each(data, function (key, value) {
                            if (!uniqueExams.has(value)) {
                                uniqueExams.add(value);
                                $('#exam_name').append('<option value="' + key + '">' + value + '</option>');
                            }
                        });

                        if (uniqueExams.size === 0) {
                            $('#exam_name').append('<option value="">No exams available</option>');
                        }
                    },
                    error: function () {
                        $('#exam_name').append('<option value="">Failed to load exams</option>');
                    }
                });
            } else {
                $('#exam_name').empty().append('<option value="">Select Exam</option>');
            }
        });

    });
</script>

<script>
    $(document).ready(function () {
        $('#exam_name').on('change', function () {
            let examId = $(this).val();
            if (examId) {
                $.ajax({
                    url: '/teacher/get-subjects/' + examId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#subjectContainer').empty();

                        if (data.length > 0) {
                            data.forEach((subject, index) => {
                                let subjectHtml = `
                                    <div class="subject-group">
                                        <div class="form-group">
                                            <label for="subjects_${index}" style="margin-top: 20px;">Subject Name</label>
                                            <input type="text" style="margin-top: 20px;" class="form-control" id="subjects_${index}" name="subjects[]" value="${subject.name}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="total_marks_${index}" style="margin-top: 20px;">Total Marks</label>
                                            <input type="number" style="margin-top: 20px;" class="form-control total_marks" id="total_marks_${index}" name="total_marks[]" value="${subject.total_marks}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="obtained_marks_${index}" style="margin-top: 20px;">Obtain Marks</label>
                                            <input type="number" style="margin-top: 20px; padding-right: 10px;" class="form-control obtained_marks" id="obtained_marks_${index}" name="obtained_marks[]" oninput="calculatePercentage(${index})">
                                            <div class="text-danger marks-error" id="marks-error_${index}" style="display: none; font-size: 12px;">
                                                Obtain Marks cannot exceed Total Marks.
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="percentage_${index}" style="margin-top: 20px;">Percentage</label>
                                            <input type="text" style="margin-top: 20px;" class="form-control percentage" id="percentage_${index}" name="percentage[]" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="grade_${index}" style="margin-top: 20px;">Grade</label>
                                            <input type="text" style="margin-top: 20px;" class="form-control grade" id="grade_${index}" name="grade[]" readonly>
                                        </div>
                                    </div>
                                `;

                                $('#subjectContainer').append(subjectHtml);
                            });
                        } else {
                            $('#subjectContainer').append('<p>No subjects found for this exam.</p>');
                        }
                    },
                    error: function () {
                        alert('Failed to fetch subjects.');
                    }
                });
            } else {
                $('#subjectContainer').empty();
            }
        });
    });

    // Calculate percentage and grade for each subject row
    function calculatePercentage(index) {
        let totalMarks = parseFloat(document.getElementById(`total_marks_${index}`).value);
        let obtainedMarks = parseFloat(document.getElementById(`obtained_marks_${index}`).value);
        let percentageField = document.getElementById(`percentage_${index}`);
        let gradeField = document.getElementById(`grade_${index}`);
        let errorDiv = document.getElementById(`marks-error_${index}`);

        if (obtainedMarks > totalMarks) {
            errorDiv.style.display = "block";
            percentageField.value = "";
            gradeField.value = "";
        } else {
            errorDiv.style.display = "none";
            let percentage = (obtainedMarks / totalMarks) * 100;
            percentageField.value = percentage.toFixed(2);

            // Calculate grade based on percentage
            gradeField.value = getGrade(percentage);
        }
    }

    // Function to get grade based on percentage
    function getGrade(percentage) {
        if (percentage >= 90) return "A+";
        if (percentage >= 80) return "A";
        if (percentage >= 70) return "B";
        if (percentage >= 60) return "C";
        if (percentage >= 50) return "D";
        return "F";
    }
</script>

<script>
    $(document).ready(function () {
        $('#student_name, #classes, #sections, #exam_name').on('change', function () {
            let studentName = $('#student_name').val();
            let classId = $('#classes').val();
            let sectionId = $('#sections').val();
            let examId = $('#exam_name').val();

            if (studentName && classId && sectionId && examId) {
                $.ajax({
                    url: "{{ route('teacher.results.checkDuplicate') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        student_name: studentName,
                        classes: classId,
                        sections: sectionId,
                        exam_name: examId
                    },
                    success: function (response) {
                        if (response.exists) {
                            Swal.fire({
                                icon: "error",
                                title: "Duplicate Entry!",
                                text: "Result for this student in this exam already exists.",
                            });
                            $('#submitBtn').prop('disabled', true);
                        } else {
                            $('#submitBtn').prop('disabled', false);
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: "error",
                            title: "Error!",
                            text: "Something went wrong while checking duplicates.",
                        });
                        $('#submitBtn').prop('disabled', false);
                    }
                });
            }
        });
    });
</script>

@include('layouts.a_footer')