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
                    <h3 class="mb-0">Admit Card</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">Admit Card</li>
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
                    <h3 class="card-title">Admit Card</h3>
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
                                        <th>Fees Paid</th>
                                        <th>Admit Card</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(empty($admitcards) || count($admitcards) == 0)
                                        <tr>
                                            <td colspan="5" class="text-center">Select class and section to view admit cards</td>
                                        </tr>
                                    @else
                                        @foreach ($admitcards as $admitcard)
                                            <tr>
                                                <td>{{ $admitcard->id }}</td>
                                                <td>{{ $admitcard->student_name }}</td>
                                                <td>{{ $admitcard->fees_paid }}</td>
                                                <td>
                                                    @if($admitcard->admit_card)
                                                        <a href="{{ asset('storage/' . $admitcard->admit_card) }}" target="_blank">Download</a>
                                                    @else
                                                        Not Available
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.admitcards.destroy', $admitcard->id) }}" class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('Are you sure you want to delete this admit card?');">
                                                    <i class="fa fa-trash fa-fw"></i>
                                                    </a>
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
<script>
    function showLoadingAndRedirect() {
        // Show the spinner
        document.getElementById('loadingOverlay').style.display = 'flex';

        // Redirect to the Add New Class page after a short delay
        setTimeout(function () {
            window.location.href = "{{ route('admin.admitcards.create') }}"; // Redirect to the "Add New Class" page
        }, 500); // Delay in milliseconds (500ms for the spinner to show)
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
    $(document).ready(function() {
        // Initially, clear the table
        $('#courses-table tbody').empty().append('<tr><td colspan="5" class="text-center">Select class and section to view admit cards</td></tr>');

        $('#classes, #sections').on('change', function() {
            var classId = $('#classes').val();
            var sectionId = $('#sections').val();
            var tbody = $('#courses-table tbody');

            // If both class and section are selected, fetch data
            if (classId && sectionId) {
                $.ajax({
                    url: '{{ route("admin.admitcards.filter") }}',
                    type: 'GET',
                    data: { class_id: classId, section_id: sectionId },
                    dataType: 'json',
                    success: function(data) {
                        tbody.empty();

                        if (data.length > 0) {
                            $.each(data, function(index, admitcard) {
                                var row = `<tr>
                                    <td>${index + 1}</td>
                                    <td>${admitcard.student_name}</td>
                                    <td>${admitcard.fees_paid}</td>
                                    <td>${admitcard.admit_card ? 
                                        `<a href="{{ asset('storage/') }}/${admitcard.admit_card}" target="_blank">Download</a>` 
                                        : 'Not Available'}
                                    </td>
                                    <td>
                                        <a href="/admin/admitcards/destroy/${admitcard.id}" class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Are you sure you want to delete this admit card?');">
                                           <i class="fa fa-trash fa-fw"></i>
                                        </a>
                                    </td>
                                </tr>`;
                                tbody.append(row);
                            });
                        } else {
                            tbody.append('<tr><td colspan="5" class="text-center">No admit cards found</td></tr>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert('Unable to fetch filtered admit cards.');
                    }
                });
            } else {
                // If either class or section is not selected, clear the table and show message
                tbody.empty().append('<tr><td colspan="5" class="text-center">Select class and section to view admit cards</td></tr>');
            }
        });
    });
</script>


@include('layouts.a_footer')
