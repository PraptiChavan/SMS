@include('layouts.t_header')
@include('layouts.t_sidebar')

<style>
    .equal-height {
        height: 38px; /* Ensuring equal height for both buttons and input */
    }

    #attendance-table .present-day {
        background-color: #28a745 !important;
        color: white;
    }

    #attendance-table .absent-day {
        background-color: #dc3545 !important;
        color: white;
    }

    #attendance-table .grey-text {
        background-color: black;
        color: white;
    }

    #attendance-table th,
    #attendance-table td {
        width: 50px;
        height: 50px;
        text-align: center;
        vertical-align: middle;
        font-weight: bold;
        border: 1px solid #ddd;
    }
</style>

<main class="app-main">
    <!-- App Content Header -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">My Attendance</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Teacher</a></li>
                        <li class="breadcrumb-item active">Attendance</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- App Content -->
    <div class="app-content">
        <div class="container-fluid">
            <div class="card" style="margin-bottom: 20px;">
                <div class="card-header">
                    <h3 class="card-title">Teacher Details</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <b>Name:</b> <span class="ms-2">{{ $teacher->name ?? 'N/A' }} </span>
                    </div>
                    <div class="col-lg-4">
                        <label for="periods" style="margin-top:10px;"><b>Select Period</b></label>
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
                    <div class="col-12">
                    <table class="table table-bordered" id="attendance-table" width="100%" style="font-size: 13px;">
                            <thead>
                                <tr>
                                    <th>Sunday</th>
                                    <th>Monday</th>
                                    <th>Tuesday</th>
                                    <th>Wednesday</th>
                                    <th>Thursday</th>
                                    <th>Friday</th>
                                    <th>Saturday</th>
                                </tr>
                            </thead>
                            <tbody id="calendarBody">
                                <!-- Calendar will be generated here dynamically -->
                            </tbody>
                        </table>
                    </div>
                    <form action="#">
                    <input type="hidden" name="period_id" id="selectedPeriod">
                    </form>
                    <div class="mt-3">
                        <h5>No. of Present Days: <span id="presentCount">0</span></h5>
                        <h5>No. of Absent Days: <span id="absentCount">0</span></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let currentMonth = {{ $currentMonth }};
    let currentYear = {{ $currentYear }};

    $(document).ready(function () {
        $('#periods').on('change', function () {
            let periodId = $(this).val();
            $('#selectedPeriod').val(periodId);
            
            if (periodId) {
                loadAttendanceData();
            }
        });
    });

    function changeMonth(direction) {
        currentMonth += direction;

        if (currentMonth < 1) {
            currentMonth = 12;
            currentYear -= 1;
        } else if (currentMonth > 12) {
            currentMonth = 1;
            currentYear += 1;
        }

        // Update the month display input
        let monthDisplay = new Date(currentYear, currentMonth - 1).toLocaleString('default', { month: 'long', year: 'numeric' });
        document.getElementById('monthDisplay').value = monthDisplay;

        loadAttendanceData();
    }

    function loadAttendanceData() {
        let teacherId = {{ $teacher->id }};
        let periodId = $('#periods').val();

        if (!teacherId || !periodId) return;// Prevent AJAX call if values are missing

        $.ajax({
            url: `{{ url('get-teacher-attendance') }}/${teacherId}?month=${currentMonth}&year=${currentYear}&period_id=${periodId}`,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                let calendarBody = $("#calendarBody");
                calendarBody.empty();

                let totalDays = new Date(currentYear, currentMonth, 0).getDate();
                let firstDayOfWeek = new Date(currentYear, currentMonth - 1, 1).getDay();
                let presentCount = 0;
                let absentCount = 0;
                let row = "<tr>";

                // Fill empty cells before the first day with dates from the previous month
                let prevMonthTotalDays = new Date(currentYear, currentMonth - 1, 0).getDate();
                for (let i = 0; i < firstDayOfWeek; i++) {
                    row += `<td class="grey-text">${prevMonthTotalDays - firstDayOfWeek + i + 1}</td>`;
                }

                // Add current month's days
                for (let day = 1; day <= totalDays; day++) {

                    let currentDate = new Date(currentYear, currentMonth - 1, day);
                    let weekDay = currentDate.getDay();
                    let record = data.find(attendance => attendance.day === day);
                    let attendanceStatus = record ? record.status : '-';

                    let cellClass = "";
                    if (weekDay === 0) { 
                        // Sunday: Grey out
                        cellClass = "grey-text";
                    } else if (attendanceStatus === '✅') {
                        cellClass = "present-day";
                        presentCount++;
                    } else if (attendanceStatus === '❌') {
                        cellClass = "absent-day";
                        absentCount++;
                    } else if (attendanceStatus === '-') {
                        cellClass = "";  // No change for days with no attendance
                    }
                    row += `<td class="${cellClass}">${day}</td>`;

                    if ((firstDayOfWeek + day) % 7 === 0) {
                        row += "</tr><tr>";
                    }
                }

                // Fill empty cells for the remaining week with dates from the next month
                let remainingCells = 7 - ((firstDayOfWeek + totalDays) % 7);
                if (remainingCells < 7) {
                    for (let i = 1; i <= remainingCells; i++) {
                        row += `<td class="grey-text">${i}</td>`;
                    }
                }

                row += "</tr>";
                calendarBody.append(row);

                document.getElementById('presentCount').innerText = presentCount;
                document.getElementById('absentCount').innerText = absentCount;
            },
            error: function (xhr, status, error) {
                console.error("Error loading attendance data:", error);
            }
        });
    }
</script>






@include('layouts.a_footer')
