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

    /* Reduce padding inside table cells */
    #tt-table th, 
    #tt-table td {
        padding: 5px !important; /* Adjust as needed */
        text-align: left; /* Ensures text alignment */
        vertical-align: middle; /* Ensures content is centered vertically */
        white-space: nowrap; /* Prevents excessive wrapping */
    }

    /* Adjust table width */
    #tt-table {
        width: 100%;
        table-layout: fixed; /* Ensures equal column widths */
    }

    /* Reduce bottom space of text inside cells */
    #tt-table td p {
        margin: 2px 0; /* Adjust as needed */
        font-size: 12px; /* Reduce font size slightly */
    }

    /* Remove extra space at the right */
    .card-body {
        padding: 10px !important; /* Reduce card padding */
    }
</style>

<main class="app-main">
    <!-- App Content Header -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Manage Time Table</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">Time Table</li>
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
            <div class="card">
                <div class="card-body">
                    <div class="card-tools mb-3">
                        <!-- Add New Button with onclick event to show the spinner -->
                        <a href="javascript:void(0);" onclick="showLoadingAndRedirect()" class="btn btn-success btn-xs">
                            <i class="fa fa-plus mr-2"></i>Add New
                        </a>
                    </div>
                    <div class="row">
                        <h6 style="margin-top: 5px; margin-bottom: 10px;"><b>Filter with Class & Section</b></h6>
                        <div class="col-lg-6">
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
                            <div class="form-group">
                                <select name="sections" id="sections" class="form-control" required>
                                    <option value="">Select Section</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <h6 style="margin-top: 10px; margin-bottom: 10px;"><b>Filter with Teacher Name</b></h6>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <select name="teachers" id="teachers" class="form-control">
                                    <option value="">Select Teacher</option>
                                    @foreach ($accounts as $teacher)
                                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card" style="margin-top: 20px;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered" id="tt-table" width="100%" style="font-size: 13px;">
                                <thead>
                                    <tr>
                                        <th>Timings</th>
                                        <th>Monday</th>
                                        <th>Tuesday</th>
                                        <th>Wednesday</th>
                                        <th>Thursday</th>
                                        <th>Friday</th>
                                        <th>Saturday</th>
                                    </tr>
                                </thead>
                                <tbody id="timetable-body">
                                    @foreach ($periods as $period)
                                        <tr>
                                            <!-- Period time formatted with Carbon -->
                                            <td>{{ \Carbon\Carbon::parse($period->from)->format('h:i A') }} - {{ \Carbon\Carbon::parse($period->to)->format('h:i A') }}</td>
                                            @foreach ($weekdays as $weekday)
                                                <td>
                                                </td> {{-- Initially empty cells --}}
                                            @endforeach
                                        </tr>
                                    @endforeach
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

<!-- Script for getting the selected sections by class -->
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

<!-- Script for showing the loading redirect -->
<script>
    function showLoadingAndRedirect() {
        // Show the spinner
        document.getElementById('loadingOverlay').style.display = 'flex';

        // Redirect to the Add New Class page after a short delay
        setTimeout(function () {
            window.location.href = "{{ route('admin.time-table.create') }}"; // Redirect to the "Add New Class" page
        }, 500); // Delay in milliseconds (500ms for the spinner to show)
    }
</script>

<!-- Script for filtering the time-table by class & section -->
<script>
    $(document).ready(function () {
        function fetchFilteredTimeTable() {
            var classId = $('#classes').val();
            var sectionId = $('#sections').val();

            if (classId && sectionId) {
                $.ajax({
                    url: '{{ url("filter-time-table") }}',
                    type: 'GET',
                    data: { class_id: classId, section_id: sectionId },
                    dataType: 'json',
                    success: function (data) {
                        updateTimeTable(data);
                    },
                    error: function () {
                        alert('Error fetching timetable data.');
                    }
                });
            }
        }

        function updateTimeTable(data) {
            $('#timetable-body').empty(); // Clear existing table data

            @foreach ($periods as $period)
            var row = `<tr>
                <td>{{ \Carbon\Carbon::parse($period->from)->format('h:i A') }} - {{ \Carbon\Carbon::parse($period->to)->format('h:i A') }}</td>`;
            
            @foreach ($weekdays as $weekday)
            var cellData = "";
            data.forEach(entry => {
                if (entry.weekdays.includes("{{ $weekday->id }}") && entry.periods.includes("{{ $period->id }}")) {
                    cellData += `<p><b>Teachers:</b> ${entry.teachers} <br>
                                <b>Subjects:</b> ${entry.subjects} <br>
                                </p>
                                <a href="{{ route('admin.time-table.edit', '') }}/${entry.id}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <a href="{{ route('admin.time-table.destroy', '') }}/${entry.id}" 
                                   class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Are you sure you want to delete this entry?');">
                                    <i class="fa fa-trash fa-fw"></i>
                                </a>`;
                }
            });

            row += `<td>${cellData}</td>`;
            @endforeach
            
            row += `</tr>`;
            $('#tt-table tbody').append(row);
            @endforeach

            // After populating the table, show the buttons
            $('.edit-btn, .delete-btn').show();
        }

        // Trigger filtering when class or section is selected
        $('#classes, #sections').change(fetchFilteredTimeTable);
    });
</script>

<!-- Script for emptying the table when the filters are changed -->
<script>
    $(document).ready(function () {
        $('#teachers').change(function () {
            // Reset class and section filters when teacher filter is selected
            $('#classes').val('');
            $('#sections').empty().append('<option value="">Select Section</option>');
        });

        $('#classes, #sections').change(function () {
            // Reset teacher filter when class or section is selected
            $('#teachers').val('');
        });
    });
</script>

<!-- Script for filtering the time-table by teacher's name -->
<script>
    $(document).ready(function () {
        function fetchFilteredTimeTableByTeacher() {
            var teacherId = $('#teachers').val();

            if (teacherId) {
                $.ajax({
                    url: '{{ url("filter-time-table-by-teacher") }}',
                    type: 'GET',
                    data: { teacher_id: teacherId },
                    dataType: 'json',
                    success: function (data) {
                        updateTeacherTimeTable(data);
                    },
                    error: function () {
                        alert('Error fetching timetable data for the selected teacher.');
                    }
                });
            }
        }

        function updateTeacherTimeTable(data) {
            $('#timetable-body').empty(); // Clear existing table data

            @foreach ($periods as $period)
            var row = `<tr>
                <td>{{ \Carbon\Carbon::parse($period->from)->format('h:i A') }} - {{ \Carbon\Carbon::parse($period->to)->format('h:i A') }}</td>`;

            @foreach ($weekdays as $weekday)
            var cellData = "";
            data.forEach(entry => {
                if (entry.weekdays.includes("{{ $weekday->id }}") && entry.periods.includes("{{ $period->id }}")) {
                    cellData += `<p><b>Class:</b> ${entry.class_title} <br>
                                 <b>Section:</b> ${entry.section_title} <br>
                                 <b>Subjects:</b> ${entry.subjects} <br>
                                 </p>
                                 <a href="{{ route('admin.time-table.edit', '') }}/${entry.id}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-pencil-alt"></i>
                                 </a>
                                 <a href="{{ route('admin.time-table.destroy', '') }}/${entry.id}" 
                                 class="btn btn-sm btn-danger" 
                                 onclick="return confirm('Are you sure you want to delete this entry?');">
                                    <i class="fa fa-trash fa-fw"></i>
                                 </a>`;
                }
            });

            row += `<td>${cellData}</td>`;
            @endforeach

            row += `</tr>`;
            $('#tt-table tbody').append(row);
            @endforeach
        }

        // Trigger filtering when teacher is selected
        $('#teachers').change(fetchFilteredTimeTableByTeacher);
    });
</script>

@include('layouts.a_footer')