@include('layouts.s_header')
@include('layouts.s_sidebar')

<style>
    .equal-height {
        height: 38px; /* Ensuring equal height for both buttons and input */
    }

    #attendance-table {
        width: 100%;
        table-layout: fixed; /* Ensures equal column width */
    }

    #attendance-table .present-day {
        background-color: #28a745 !important;
        color: white;
    }

    #attendance-table .absent-day {
        background-color: #dc3545 !important;
        color: white;
    }

    #attendance-table .partial-present-day {
        background-color: #ffc107 !important;
        color: black;
    }

    #attendance-table .grey-text {
        background-color: black;
        color: white;
    }

    #attendance-table th,
    #attendance-table td {
        width: 14.28%; /* 100% divided by 7 days */
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

    <!-- App Content -->
    <div class="app-content">
        <div class="container-fluid">
            <div class="card" style="margin-bottom: 20px;">
                <div class="card-header">
                    <h3 class="card-title">Student Details</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <b>Name:</b> <span class="ms-2">{{ $student->name ?? 'N/A' }} </span>
                    </div>
                    <div class="d-flex">
                        <b>Class:</b> <span class="ms-2 me-3">{{ $studentClass ?? 'N/A' }} </span> 
                        <b>Section:</b> <span class="ms-2">{{ implode(', ', $studentSections) ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <h6 style="margin-top: 10px; margin-bottom: 10px;"><b>Find Attendance</b></h6>
                        <div class="col-lg-12" style="margin-bottom:20px;">
                            <div class="form-group">
                                <select name="periods" id="periods" class="form-control">
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

            <!-- Attendance Summary -->
            <div class="card" style="margin-top:20px;">
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
                            <tbody id="calendarBody"></tbody>
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
        let currentMonth = {{ $currentMonth }};
        let currentYear = {{ $currentYear }};
        let totalPeriods = {{ $totalPeriods }};

        $('#periods').on('change', function () {
            loadAttendanceData();
        });

        function loadAttendanceData() {
            let periodId = $('#periods').val();
            let studentId = {{ $student->id }};

            if (!periodId) return;

            $.ajax({
                url: `{{ url('get-student-attendance') }}/${studentId}?month=${currentMonth}&year=${currentYear}&period_id=${periodId}`,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    let calendarBody = $("#calendarBody");
                    calendarBody.empty();

                    let totalDays = new Date(currentYear, currentMonth, 0).getDate();
                    let firstDayOfWeek = new Date(currentYear, currentMonth - 1, 1).getDay();
                    let prevMonthTotalDays = new Date(currentYear, currentMonth - 1, 0).getDate();
                    let row = "<tr>";

                    // Fill previous month's dates
                    for (let i = firstDayOfWeek; i > 0; i--) {
                        let prevDate = prevMonthTotalDays - i + 1;
                        row += `<td class="grey-text">${prevDate}</td>`;
                    }

                    for (let day = 1; day <= totalDays; day++) {
                        let record = data[day] || { present_periods: 0 };
                        let presentPeriods = record.present_periods;
                        let attendanceStatus = `${presentPeriods}/${totalPeriods}`;
                        let dayOfWeek = (firstDayOfWeek + day - 1) % 7;

                        if (dayOfWeek === 0) {
                            row += `<td class="grey-text">${day}</td>`;
                        } else {
                            let cellClass = "absent-day"; // Default Red
                            if (presentPeriods === totalPeriods) {
                                cellClass = "present-day"; // Green
                            } else if (presentPeriods > 0 && presentPeriods < totalPeriods) {
                                cellClass = "partial-present-day"; // Yellow
                            }
                            row += `<td class="${cellClass}">${day} <br><small>(${attendanceStatus})</small></td>`;
                        }

                        if ((firstDayOfWeek + day) % 7 === 0) {
                            row += "</tr><tr>";
                        }
                    }

                    // Fill next month's dates
                    let remainingCells = (firstDayOfWeek + totalDays) % 7;
                    if (remainingCells > 0) {
                        let nextMonthDay = 1;
                        for (let i = remainingCells; i < 7; i++) {
                            row += `<td class="grey-text">${nextMonthDay}</td>`;
                            nextMonthDay++;
                        }
                    }

                    row += "</tr>";
                    calendarBody.append(row);
                },
                error: function (xhr, status, error) {
                    console.error("Error loading attendance data:", error);
                }
            });
        }

        // Change month and reload attendance
        window.changeMonth = function (step) {
            currentMonth += step;

            if (currentMonth < 1) {
                currentMonth = 12;
                currentYear--;
            } else if (currentMonth > 12) {
                currentMonth = 1;
                currentYear++;
            }

            let monthNames = [
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];
            $('#monthDisplay').val(`${monthNames[currentMonth - 1]} ${currentYear}`);

            loadAttendanceData();
        };
    });
</script>

@include('layouts.a_footer')
