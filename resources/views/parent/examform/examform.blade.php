@include('layouts.p_header')
@include('layouts.p_sidebar')

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Exam Schedule</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Parent</a></li>
                        <li class="breadcrumb-item active">Exam Schedule</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                        <div class="row">
                            <h6 style="margin-top: 10px; margin-bottom: 10px;"><b>Find Student's Exam Schedule</b></h6>
                            <div class="col-lg-12" style="margin-bottom:20px;">
                                <div class="form-group">
                                    <select name="students" id="students" class="form-control">
                                        <option value="">Select Student</option>
                                        @foreach ($students as $student)
                                            <option value="{{ $student->id }}">{{ $student->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                    <!-- Exam Table -->
                    <div class="col-12">
                        <table class="table table-bordered" id="exam-table" width="100%">
                            <thead>
                                <tr>
                                    <th>Exam Name</th>
                                    <th>Class</th>
                                    <th>Subject</th>
                                    <th>Date</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Total Marks</th>
                                </tr>
                            </thead>
                            <tbody id="exam-body">
                                <tr>
                                    <td colspan="7" class="text-center">Select a student to view exam details.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {
    $('#students').change(function () {
        let studentId = $(this).val();

        if (studentId) {
            $.ajax({
                url: "{{ url('/parent/fetch-examform') }}",
                type: "POST",
                data: {
                    student_id: studentId,
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    let examBody = $('#exam-body');
                    examBody.empty();

                    if (response.status === 'success') {
                        let exams = response.data;

                        if (exams.length > 0) {
                            $.each(exams, function (index, exam) {
                                let row = `
                                    <tr>
                                        <td>${exam.name}</td>
                                        <td>${exam.class}</td>
                                        <td>${exam.subjects}</td>
                                        <td>${exam.date}</td>
                                        <td>${exam.start_time}</td>
                                        <td>${exam.end_time}</td>
                                        <td>${exam.total_marks}</td>
                                    </tr>`;
                                examBody.append(row);
                            });
                        } else {
                            examBody.append('<tr><td colspan="7" class="text-center">No exams found for this class.</td></tr>');
                        }
                    } else {
                        alert(response.message);
                    }
                },
                error: function () {
                    alert('Failed to load exams. Please try again.');
                }
            });
        } else {
            $('#exam-body').html('<tr><td colspan="7" class="text-center">Select a student to view exam details.</td></tr>');
        }
    });
});
</script>

@include('layouts.a_footer')
