@include('layouts.s_header')
@include('layouts.s_sidebar')

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
                        <li class="breadcrumb-item"><a href="#">Students</a></li>
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
                            <tbody>
                                @foreach ($subjects as $subject)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $subject->name }}</td>
                                        <td>{{ $subject->classTitle }}</td>
                                        <td>{{ implode(', ', $subject->sectionTitles) }}</td>
                                    </tr>
                                @endforeach
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
@include('layouts.a_footer')