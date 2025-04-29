@include('layouts.p_header')
@include('layouts.p_sidebar')

<main class="app-main">
    <!-- App Content Header -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Results</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Parent</a></li>
                        <li class="breadcrumb-item active">Results</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- App Content -->
    <div class="app-content">
        <div class="container-fluid">
            <!-- Student Dropdown -->
            <div class="card mb-3">
                <div class="card-body">
                    <h6><b>Select Student to View Results</b></h6>
                    <div class="form-group">
                        <select name="students" id="students" class="form-control">
                            <option value="">Select Student</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}" data-class="{{ $student->classes }}">{{ $student->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Results Table -->
            <div class="card">
                <div class="card-header py-2">
                    <h3 class="card-title">Results</h3>
                </div>
                <div class="card-body">
                    <div class="col-12">
                        <table class="table table-bordered" id="results-table" width="100%">
                            <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <th>Exam Name</th>
                                    <th>Result</th>
                                </tr>
                            </thead>
                            <tbody id="results-body">
                                <tr>
                                    <td colspan="6" class="text-center">Select a student to view results.</td>
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
    $(document).ready(function() {
        $('#students').change(function() {
            let studentId = $(this).val();

            if (studentId) {
                $.ajax({
                    url: "{{ url('/parent/fetch-results') }}",
                    type: "POST",
                    data: {
                        student_id: studentId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        let tableBody = $('#results-body');
                        tableBody.empty();

                        if (response.status === 'success' && response.data.length > 0) {
                            $.each(response.data, function(index, result) {
                                let row = `<tr>
                                    <td>${result.student_name}</td>
                                    <td>${result.exam_name}</td>
                                    <td><a href="${result.result_url}" target="_blank">Download</a></td>
                                </tr>`;
                                tableBody.append(row);
                            });
                        } else {
                            tableBody.append('<tr><td colspan="6" class="text-center">No results found for this student.</td></tr>');
                        }
                    },
                    error: function() {
                        alert('Failed to fetch results. Please try again.');
                    }
                });
            } else {
                $('#results-body').html('<tr><td colspan="6" class="text-center">Select a student to view results.</td></tr>');
            }
        });
    });
</script>

@include('layouts.a_footer')
