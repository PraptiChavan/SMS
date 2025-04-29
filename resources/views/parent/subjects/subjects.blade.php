@include('layouts.p_header')
@include('layouts.p_sidebar')

<style>
    #subjects-table {
        table-layout: fixed; /* Fixes table layout */
        width: 100%;
    }

    #subjects-table th, #subjects-table td {
        text-align: left; /* Centers text */
        vertical-align: middle; /* Keeps alignment */
        min-width: 150px; /* Ensures columns don't shrink */
        word-wrap: break-word; /* Prevents long text overflow */
    }
</style>

<main class="app-main">
    <!-- App Content Header -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Subjects</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Parent</a></li>
                        <li class="breadcrumb-item active">Subjects</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- App Content -->
    <div class="app-content">
        <div class="container-fluid">
            <!-- Courses List -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                    <h6 style="margin-top: 10px; margin-bottom: 10px;"><b>Find Student's Subjects</b></h6>
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
                    <!-- Courses Table -->
                    <div class="col-12">
                        <!-- Subjects List -->
                        <table class="table table-bordered" id="subjects-table" width="100%">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Subject Name</th>
                                    <th>Class</th>
                                    <th>Section</th>
                                </tr>
                            </thead>
                            <tbody id="subjects-body">
                            </tbody>
                        </table>          
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Script for getting sections by class -->
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
                        console.error('AJAX Error:', xhr.responseText);
                        alert('Unable to fetch sections.');
                    }
                });
            } else {
                $('#sections').empty().append('<option value="">Select Section</option>');
            }
        });
    });
</script>

<!-- Script for getting subjects by students -->
<script>
    $(document).ready(function() {
        $('#students').on('change', function() {
            var studentId = $(this).val();
            if (studentId) {
                $.ajax({
                    url: '{{ url("parent/get-subjects") }}/' + studentId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#subjects-body').empty();

                        if (data.length > 0) {
                            $.each(data, function(index, subject) {
                                var sections = subject.sectionTitles ? subject.sectionTitles.join(', ') : 'N/A';
                                $('#subjects-body').append('<tr>' +
                                    '<td>' + (index + 1) + '</td>' +
                                    '<td>' + subject.name + '</td>' +
                                    '<td>' + subject.classTitle + '</td>' +
                                    '<td>' + sections + '</td>' +
                                    '</tr>');
                            });
                        } else {
                            $('#subjects-body').append('<tr><td colspan="4"><center>No subjects found.</center></td></tr>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', xhr.responseText);
                        alert('Unable to fetch subjects.');
                    }
                });
            } else {
                $('#subjects-body').empty().append('<tr><td colspan="4"><center>Please select a student.</center></td></tr>');
            }
        });
    });
</script>
@include('layouts.a_footer')