@include('layouts.a_header')
@include('layouts.a_sidebar')

<style>
    .card {
        width: 100%; /* Make the card stretch full width */
        overflow-x: auto; /* Allow horizontal scrolling if needed */
        white-space: nowrap;
    }
    .equal-height {
        height: 38px; /* Ensuring equal height for both buttons and input */
    }

    .grey-text {
        color: #aaa; /* Light grey */
    }

    .present-day {
        background-color: #28a745 !important; /* Dark Green */
        color: white;
    }

    .absent-day {
        background-color: #dc3545 !important; /* Dark Red */
        color: white;
    }

    #attendance-table {
        table-layout: fixed;
        width: 100%;
    }

    #attendance-table th,
    #attendance-table td {
        width: 50px;  /* Adjust size as needed */
        height: 50px; /* Ensures square shape */
        text-align: center;
        vertical-align: middle;
    }

    #attendance-table th:first-child,
    #attendance-table td:first-child {
        width: 200px; /* Increases space for "Student Names" */
        text-align: left; /* Aligns student names to the left */
        padding-left: 10px; /* Adds some padding for better readability */
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
                    <h3 class="mb-0">Manage Student Attendance</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Student</a></li>
                        <li class="breadcrumb-item active">Attendance</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Spinner -->
    <!-- Full-Screen Loading Overlay -->
    <div id="loadingOverlay" style="display: none !important;">
        <div class="spinner-box">
            <img src="{{ asset('assets/img/admin/users/loading.gif') }}" alt="Loading..." width="80">
            <p><b>Processing, please wait...</b></p>
        </div>
    </div>

    <!-- App Content -->
    <div class="app-content">
        <div class="container-fluid">
            <div class="card" style="margin-bottom: 20px;">
                <div class="card-header">
                    <h3 class="card-title">Student Details</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
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
                        <div class="col-lg-4">
                        <label for="sections" style="margin-bottom:10px;"><b>Select Section</b></label>
                            <div class="form-group">
                                <select name="sections" id="sections" class="form-control" required>
                                    <option value="">Select Section</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                        <label for="periods" style="margin-bottom:10px;"><b>Select Period</b></label>
                            <div class="form-group">
                                <select name="periods" id="periods" class="form-control" required>
                                    <option value="">Select Period</option>
                                    @foreach ($periods as $period)
                                        @if ($period->id != 5) {{-- Exclude lunch break --}}
                                            <option value="{{ $period->id }}">{{ $period->title }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Courses List -->
            <div class="card">
                @php
                    use Carbon\Carbon;
                    $today = Carbon::now();
                @endphp
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Attendance Summary</h3>

                    <!-- Month Selector -->
                    <div class="d-flex align-items-center ms-auto">
                        <button class="btn btn-sm btn-outline-primary equal-height" onclick="changeMonth(-1)">&#60;</button>
                        <input type="text" id="monthDisplay" class="form-control text-center mx-2 equal-height" style="width: 150px;" value="{{ $today->format('F Y') }}" readonly>
                        <button class="btn btn-sm btn-outline-primary equal-height" onclick="changeMonth(1)">&#62;</button>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Courses Table -->
                    <div style="overflow-x: auto; width: 100%;">
                        <table class="table table-bordered" id="attendance-table" style="font-size: 13px; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Student Names</th>
                                    @for ($day = 1; $day <= $daysInMonth; $day++)
                                        <th>{{ $day }}</th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                    <form action="{{ route('save.attendance') }}" method="POST" style="margin-top:20px;">
                        @csrf
                        <input type="hidden" name="year" value="{{ $currentYear }}">
                        <input type="hidden" name="month" value="{{ $currentMonth }}">
                        <input type="hidden" name="period_id" id="selectedPeriod">
                        <button type="submit" class="btn btn-success mt-3">Save Attendance</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let currentMonth = {{ $today->month }};
    let currentYear = {{ $today->year }};

    function changeMonth(direction) {
        currentMonth += direction;
        if (currentMonth < 1) {
            currentMonth = 12;
            currentYear--;
        } else if (currentMonth > 12) {
            currentMonth = 1;
            currentYear++;
        }

        // Update the displayed month
        let newDate = new Date(currentYear, currentMonth - 1);
        let monthName = newDate.toLocaleString('default', { month: 'long' });
        document.getElementById('monthDisplay').value = `${monthName} ${currentYear}`;

        // Update the attendance table dynamically
        updateTableHeaders();
        loadAttendanceData();
    }

    function updateTableHeaders() {
        let daysInMonth = new Date(currentYear, currentMonth, 0).getDate(); // Get total days in month
        let tableHead = $("#attendance-table thead tr");

        tableHead.empty(); // Clear the existing header
        tableHead.append('<th>Student Names</th>');

        for (let day = 1; day <= daysInMonth; day++) {
            tableHead.append(`<th>${day}</th>`);
        }

        updateStudentRows(daysInMonth);
    }

    function updateStudentRows(daysInMonth) {
        let tableBody = $("#attendance-table tbody");

        tableBody.find("tr").each(function () {
            let studentId = $(this).data("student");
            let newRow = `<td>${$(this).find("td:first").text()}</td>`; // Preserve Student Name

            for (let day = 1; day <= daysInMonth; day++) {
                newRow += `<td data-day="${day}" class="attendance-cell">-</td>`;
            }

            $(this).html(newRow); // Update row with new days
        });
    }

    function loadAttendanceData() {
        let classId = $('#classes').val();
        let sectionId = $('#sections').val();
        let periodId = $('#periods').val();

        if (!classId || !sectionId || !periodId) return;

        $.ajax({
            url: `{{ url('get-attendance') }}/${classId}/${sectionId}?month=${currentMonth}&year=${currentYear}&period_id=${periodId}`,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                let tableBody = $("#attendance-table tbody");
                tableBody.find("td.attendance-cell").text('-').removeClass('present-day absent-day'); // Reset table

                data.forEach(record => {
                    let cell = $(`tr[data-student="${record.student_id}"] td[data-day="${record.day}"]`);
                    cell.text(record.status === 'P' ? '✅' : '❌');
                    cell.addClass(record.status === 'P' ? 'present-day' : 'absent-day');
                });
            }
        });
    }
</script>

<script>
    $('#periods').on('change', function() {
        $('#selectedPeriod').val($(this).val()); // Store the selected period ID
    });
    
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
        $('#classes, #sections').on('change', function() {
            let classId = $('#classes').val();
            let sectionId = $('#sections').val();

            if (classId && sectionId) {
                $.ajax({
                    url: '{{ url("get-students") }}/' + classId + '/' + sectionId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(students) {
                        updateStudentTable(students);
                    },
                    error: function() {
                        alert('Unable to fetch students.');
                    }
                });
            }
        });

        function updateStudentTable(students) {
            let daysInMonth = {{ $daysInMonth }};
            let tableBody = $("#attendance-table tbody");
            tableBody.empty();

            students.forEach(student => {
                let row = `<tr data-student="${student.id}"><td>${student.name}</td>`;
                for (let day = 1; day <= daysInMonth; day++) {
                    row += `<td data-day="${day}" class="attendance-cell">-</td>`;
                }
                row += `</tr>`;
                tableBody.append(row);
            });

            loadAttendanceData();
        }
    });
</script>

<script>
    $('#periods').on('change', function() {
        $('#selectedPeriod').val($(this).val()); // Store the selected period ID

         // Reset the attendance table
        let tableBody = $("#attendance-table tbody");
        tableBody.find("td.attendance-cell").text('-').removeClass('present-day absent-day');

        // Load attendance data for the newly selected period
        loadAttendanceData();
    });
</script>

<script>
    let attendanceData = []; // Store updated attendance entries
    $(document).on('click', '.attendance-cell', function () {
        let cell = $(this);
        let studentId = cell.closest('tr').data('student');
        let day = cell.data('day');
        let newStatus = cell.text() === '✅' ? 'A' : 'P';

        // Update UI
        cell.text(newStatus === 'P' ? '✅' : '❌');
        cell.removeClass('present-day absent-day').addClass(newStatus === 'P' ? 'present-day' : 'absent-day');

        // Store data for later submission
        attendanceData = attendanceData.filter(entry => !(entry.student_id === studentId && entry.day === day)); // Remove existing entry
        attendanceData.push({ student_id: studentId, day: day, status: newStatus }); // Add updated entry
    });

    // Save Attendance - Submitting the Collected Data
    $('form').on('submit', function (event) {
        event.preventDefault();

        if (attendanceData.length === 0) {
            Swal.fire({ icon: 'warning', title: 'No Changes', text: 'No attendance changes to save.' });
            return;
        }

        $("#loadingOverlay").fadeIn(); // Show loader

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: {
                _token: $('input[name="_token"]').val(), // CSRF Token
                attendance: attendanceData,
                year: $('input[name="year"]').val(),
                month: $('input[name="month"]').val(),
                period_id: $('#selectedPeriod').val(), // Ensure period_id is sent
            },
            success: function (response) {
                $("#loadingOverlay").fadeOut();
                Swal.fire({ icon: 'success', title: 'Success!', text: 'Attendance saved successfully!', timer: 2000, showConfirmButton: false });
                attendanceData = []; // Clear stored changes
            },
            error: function () {
                $("#loadingOverlay").fadeOut();
                Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to save attendance. Try again.' });
            }
        });
    });

</script>

@include('layouts.a_footer')
