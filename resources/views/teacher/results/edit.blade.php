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
                <div class="col-sm-12">
                    <h3 class="mb-0">Edit Result</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- App Content -->
    <div class="app-content">
        <div class="container-fluid">
            <form action="{{ route('teacher.results.update', ['id' => $result->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="classes" style="margin-top: 20px;">Class</label>
                            <select name="classes" id="classes" class="form-control" style="margin-top: 20px;" required>
                                <option value="">Select Class</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}" {{ isset($result) && $result->classes == $class->id ? 'selected' : '' }}>{{ $class->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="sections" style="margin-top: 10px;">Section</label>
                            <select name="sections" id="sections" class="form-control" style="margin-top: 20px;" required>
                                <option value="">Select Section</option>
                                @if(isset($sections) && $sections->isNotEmpty())
                                    @foreach ($sections as $section)
                                    <option value="{{ $section->id }}" 
                                        {{ isset($result) && $result->sections == $section->id ? 'selected' : '' }}>
                                        {{ $section->title }}
                                    </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="student_name" style="margin-top: 20px;">Student Name</label>
                            <select name="student_id" id="student_name" class="form-control" style="margin-top: 20px;" required>
                                <option value="">Select Student</option>
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}" 
                                        {{ isset($selectedStudent) && $selectedStudent->id == $student->id ? 'selected' : '' }}>
                                        {{ $student->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exam_name" style="margin-top: 20px;">Exam Name</label>
                            <select name="exam_name" id="exam_name" class="form-control" style="margin-top: 20px;" required>
                                <option value="">Select Exam</option>
                                @foreach ($examform as $examforms)
                                    <option value="{{ $examforms->id }}" {{ isset($result) && $result->exam_name == $examforms->id ? 'selected' : '' }}>{{ $examforms->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="subjectContainer">
                            <!-- Subjects will be dynamically inserted here -->
                        </div>
                        <!-- Submit Button -->
                        <button type="submit" id="submitBtn" class="btn btn-success" style="margin-top: 20px;">
                        Update
                        </button>
                        <a href="{{ route('teacher.results') }}" class="btn btn-danger" style="margin-top: 20px;">Cancel</a>
                    </div>
                </div>
            </form>
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

<!-- Script for getting students only after selecting the class and section -->
<script>
    $(document).ready(function () {
        let selectedStudentId = "{{ $selectedStudent->id ?? '' }}"; // Preload selected student

        $('#classes, #sections').on('change', function () {
            let classId = $('#classes').val();
            let sectionId = $('#sections').val();

            if (classId && sectionId) {

                $.ajax({
                    url: `/teacher/get-students/${classId}/${sectionId}`,
                    type: 'GET',
                    success: function (data) {
                        $('#student_name').empty().append('<option value="">Select Student</option>');

                        if (Object.keys(data).length > 0) {
                            $.each(data, function (id, name) {
                                let isSelected = id == selectedStudentId ? "selected" : "";
                                $('#student_name').append(
                                    `<option value="${id}" ${isSelected}>${name}</option>`
                                );
                            });
                        } else {
                            $('#student_name').append('<option value="">No students found</option>');
                        }
                    },
                    error: function () {
                        $('#student_name').html('<option value="">Failed to load students</option>');
                    }
                });
            } else {
                $('#student_name').html('<option value="">Select Student</option>');
            }
        });

        // Trigger change to pre-load selected student if available
        $('#classes').trigger('change');
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
        let selectedExam = $('#exam_name').val();

        if (selectedExam) {
            let existingSubjects = @json($result->subjects).split(',');
            let obtainedMarks = @json($result->obtained_marks).split(',');
            let totalMarks = @json($result->total_marks).split(',');
            let percentage = @json($result->percentage).split(',');
            let grade = @json($result->grade).split(',');

            loadSubjects(selectedExam, existingSubjects, obtainedMarks, totalMarks, percentage, grade);
        }

        $('#exam_name').on('change', function () {
            loadSubjects($(this).val());
        });

        function loadSubjects(examId, existingSubjects = [], obtainedMarks = [], totalMarks = [], percentage = [], grade = []) {
            if (examId) {
                $.getJSON('/teacher/get-subjects/' + examId, function (data) {
                    $('#subjectContainer').empty();

                    data.forEach((subject, index) => {
                        let subjectName = (existingSubjects[index] || subject.name).trim();
                        let obtainedMark = (obtainedMarks[index] || '').trim();
                        let totalMark = (totalMarks[index] || subject.total_marks).trim();
                        let percent = (percentage[index] || '').trim();
                        let gradeValue = (grade[index] || '').trim();

                        let subjectHtml = `
                            <div class="subject-group">
                                <div class="form-group">
                                    <label style="margin-top: 20px;">Subject Name</label>
                                    <input style="margin-top: 20px;" type="text" class="form-control" name="subjects[]" value="${subjectName}" readonly>
                                </div>
                                <div class="form-group">
                                    <label style="margin-top: 20px;">Total Marks</label>
                                    <input style="margin-top: 20px;" type="number" class="form-control total_marks" name="total_marks[]" value="${totalMark}" readonly>
                                </div>
                                <div class="form-group">
                                    <label style="margin-top: 20px;">Obtained Marks</label>
                                    <input style="margin-top: 20px;" type="number" class="form-control obtained_marks" name="obtained_marks[]" value="${obtainedMark}" oninput="calculatePercentage(${index})">
                                </div>
                                <div class="form-group">
                                    <label style="margin-top: 20px;">Percentage</label>
                                    <input style="margin-top: 20px;" type="text" class="form-control percentage" name="percentage[]" value="${percent}" readonly>
                                </div>
                                <div class="form-group">
                                    <label style="margin-top: 20px;">Grade</label>
                                    <input style="margin-top: 20px;" type="text" class="form-control grade" name="grade[]" value="${gradeValue}" readonly>
                                </div>
                            </div>`;
                        $('#subjectContainer').append(subjectHtml);
                    });

                    // Ensure percentage and grade calculation works after loading new subjects
                    $('.obtained_marks').on('input', function () {
                        let index = $('.obtained_marks').index(this);
                        calculatePercentage(index);
                    });
                });
            }
        }

        function calculatePercentage(index) {
            let totalMarks = parseFloat(document.querySelectorAll('.total_marks')[index].value) || 0;
            let obtainedMarks = parseFloat(document.querySelectorAll('.obtained_marks')[index].value) || 0;
            let percentageField = document.querySelectorAll('.percentage')[index];
            let gradeField = document.querySelectorAll('.grade')[index];

            if (totalMarks > 0 && obtainedMarks >= 0) {
                let percentage = (obtainedMarks / totalMarks) * 100;
                percentageField.value = percentage.toFixed(2);

                gradeField.value = getGrade(percentage);
            } else {
                percentageField.value = '0.00';
                gradeField.value = 'F';
            }
        }

        function getGrade(percentage) {
            if (percentage >= 90) return "A+";
            if (percentage >= 80) return "A";
            if (percentage >= 70) return "B";
            if (percentage >= 60) return "C";
            if (percentage >= 50) return "D";
            return "F";
        }
    });

</script>

@include('layouts.a_footer')