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
                    <h3 class="mb-0">Result</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">Result</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Full Page Loading Spinner -->
    <div id="loadingOverlay" style="display: none;">
        <div class="spinner-box">
            <img src="{{ asset('assets/img/admin/users/loading.gif') }}" alt="Loading..." width="80">
            <p><b>Loading, please wait...</b></p>
        </div>
    </div>

    <!-- App Content -->
    <div class="app-content">
        <div class="container-fluid">
            <div class="card" style="margin-bottom: 20px;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                        <label for="classes" style="margin-bottom:10px;"><b>Select Class</b></label>
                            <div class="form-group">
                                <select name="classes" id="classes" class="form-control" required>
                                    <option value="">Select Class</option>
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                        <label for="sections" style="margin-bottom:10px;"><b>Select Section</b></label>
                            <div class="form-group">
                                <select name="sections" id="sections" class="form-control" required>
                                    <option value="">Select Section</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Courses List -->
            <div class="card">
                <div class="card-header py-2">
                    <h3 class="card-title">Results</h3>
                    <div class="card-tools">
                        <!-- Add New Button with onclick event to show the spinner -->
                        <a href="javascript:void(0);" onclick="showLoadingAndRedirect()" class="btn btn-success btn-xs">
                            <i class="fa fa-plus mr-2"></i>Generate New
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <!-- Courses Table -->
                        <div class="col-12">
                            <table class="table table-bordered" id="courses-table" width="100%">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Student Name</th>
                                        <th>Exam Name</th>
                                        <th>Result</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(empty($results) || count($results) == 0)
                                        <tr>
                                            <td colspan="5" class="text-center">Select class and section to view results</td>
                                        </tr>
                                    @else
                                        @foreach ($results as $result)
                                            <tr>
                                                <td>{{ $result->id }}</td>
                                                <td>{{ $result->student_name }}</td>
                                                <td>{{ $result->exam_name }}</td>
                                                <td>
                                                    @if($result->results)
                                                        <a href="{{ asset('storage/' . $result->results) }}" target="_blank">Download</a>
                                                    @else
                                                        Not Available
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.results.edit', $result->id) }}" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    <form action="{{ route('admin.results.destroy', $result->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this result?');">
                                                            <i class="fa fa-trash fa-fw"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Script for spinner redirection -->
<script>
    function showLoadingAndRedirect() {
        // Show the spinner
        document.getElementById('loadingOverlay').style.display = 'flex';

        // Redirect to the Add New Class page after a short delay
        setTimeout(function () {
            window.location.href = "{{ route('admin.results.create') }}"; // Redirect to the "Add New Class" page
        }, 500); // Delay in milliseconds (500ms for the spinner to show)
    }
</script>

<!-- Script for getting section on selecting the class-->
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

<!-- Script for getting results only after selecting the class and section -->
<script>
    $(document).ready(function () {
        // Initially, clear the table
        $('#courses-table tbody').html('<tr><td colspan="5" class="text-center">Select class and section to view results</td></tr>');

        // Trigger on class & section selection
        $('#classes, #sections').on('change', function () {
            let classId = $('#classes').val();
            let sectionId = $('#sections').val();
            let tbody = $('#courses-table tbody');

            if (classId && sectionId) {
                // Show the spinner

                $.ajax({
                    url: '{{ route("admin.results.filter") }}',
                    type: 'GET',
                    data: { class_id: classId, section_id: sectionId },
                    dataType: 'json',
                    success: function (data) {
                        tbody.empty(); // Clear old data

                        if (data.length > 0) {
                            $.each(data, function (index, result) {
                                let row = `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${result.student_name}</td>
                                        <td>${result.exam_name}</td> <!-- Already formatted -->
                                        <td>${result.results ? `<a href="{{ asset('storage/') }}/${result.results}" target="_blank">Download</a>` : 'Not Available'}</td>
                                        <td>
                                            <a href="{{ route('admin.results.edit', '') }}/${result.id}" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>
                                            <form action="{{ route('admin.results.destroy', '') }}/${result.id}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');"><i class="fa fa-trash fa-fw"></i></button>
                                            </form>
                                        </td>
                                    </tr>`;
                                tbody.append(row);
                            });
                        } else {
                            tbody.html('<tr><td colspan="5" class="text-center">No results found</td></tr>');
                        }
                    },
                    error: function () {
                        alert('Failed to fetch results');
                    },
                });

            } else {
                tbody.html('<tr><td colspan="5" class="text-center">Select class and section to view results</td></tr>');
            }
        });
    });

</script>

@include('layouts.a_footer')