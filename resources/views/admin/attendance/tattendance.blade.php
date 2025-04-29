@include('layouts.a_header')
@include('layouts.a_sidebar')

<style>
    .card {
        width: 100%;
        overflow-x: auto;
        white-space: nowrap;
    }
    .equal-height {
        height: 38px;
    }
    .grey-text {
        color: #aaa;
    }
    .present-day {
        background-color: #28a745 !important;
        color: white;
    }
    .absent-day {
        background-color: #dc3545 !important;
        color: white;
    }
    #attendance-table {
        table-layout: fixed;
        width: 100%;
    }
    #attendance-table th,
    #attendance-table td {
        width: 50px;
        height: 50px;
        text-align: center;
        vertical-align: middle;
    }
    #attendance-table th:first-child,
    #attendance-table td:first-child {
        width: 200px;
        text-align: left;
        padding-left: 10px;
    }
    #loadingOverlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(255, 255, 255, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        display: none;
    }
    .spinner-box {
        background: transparent;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        color:#0000cd;
    }
</style>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Manage Teacher Attendance</h3>
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

    <div id="loadingOverlay">
        <div class="spinner-box">
            <img src="{{ asset('assets/img/admin/users/loading.gif') }}" alt="Loading..." width="80">
            <p><b>Processing, please wait...</b></p>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card" style="margin-bottom: 20px;">
                <div class="card-header">
                    <h3 class="card-title">Teacher Details</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="teachers" style="margin-bottom:10px;"><b>Select Teacher</b></label>
                            <div class="form-group">
                                <select name="teachers" id="teachers" class="form-control" required>
                                    <option value="">Select Teacher</option>
                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                @php
                    use Carbon\Carbon;
                    $today = Carbon::now();
                @endphp
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Attendance Summary</h3>
                    <div class="d-flex align-items-center ms-auto">
                        <button class="btn btn-sm btn-outline-primary equal-height" onclick="changeMonth(-1)">&#60;</button>
                        <input type="text" id="monthDisplay" class="form-control text-center mx-2 equal-height" style="width: 150px;" value="{{ now()->format('F Y') }}" readonly>
                        <button class="btn btn-sm btn-outline-primary equal-height" onclick="changeMonth(1)">&#62;</button>
                    </div>
                </div>

                <div class="card-body">
                    <div style="overflow-x: auto; width: 100%;">
                        <table class="table table-bordered" id="attendance-table" style="font-size: 13px; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Periods</th>
                                    @for ($day = 1; $day <= $daysInMonth; $day++)
                                        <th>{{ $day }}</th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($periods as $period)
                                    <tr data-period="{{ $period->id }}">
                                        <td>{{ $period->title }}</td>
                                        @for ($day = 1; $day <= $daysInMonth; $day++)
                                            <td data-day="{{ $day }}" class="attendance-cell">-</td>
                                        @endfor
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <form action="{{ route('save.teacher.attendance') }}" method="POST" style="margin-top:20px;">
                        @csrf
                        <input type="hidden" name="year" value="{{ now()->year }}">
                        <input type="hidden" name="month" value="{{ now()->month }}">
                        <input type="hidden" name="teacher_id" id="selectedTeacher">
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
    let currentMonth = new Date().getMonth() + 1;
    let currentYear = new Date().getFullYear();

    function changeMonth(direction) {
        currentMonth += direction;
        if (currentMonth < 1) {
            currentMonth = 12;
            currentYear--;
        } else if (currentMonth > 12) {
            currentMonth = 1;
            currentYear++;
        }

        let newDate = new Date(currentYear, currentMonth - 1);
        let monthName = newDate.toLocaleString('default', { month: 'long' });
        $('#monthDisplay').val(`${monthName} ${currentYear}`);
        $('input[name="year"]').val(currentYear);
        $('input[name="month"]').val(currentMonth);

        updateTableHeaders();
        loadAttendanceData();
    }

    function updateTableHeaders() {
        let daysInMonth = new Date(currentYear, currentMonth, 0).getDate();
        let tableHead = $("#attendance-table thead tr");
        tableHead.empty().append('<th>Periods</th>');

        for (let day = 1; day <= daysInMonth; day++) {
            tableHead.append(`<th>${day}</th>`);
        }

        updateAttendanceRows(daysInMonth);
    }

    function updateAttendanceRows(daysInMonth) {
        let tableBody = $("#attendance-table tbody");
        tableBody.find("tr").each(function () {
            let periodId = $(this).data("period");
            let newRow = `<td>${$(this).find("td:first").text()}</td>`;
            
            for (let day = 1; day <= daysInMonth; day++) {
                newRow += `<td data-day="${day}" class="attendance-cell">-</td>`;
            }

            $(this).html(newRow);
        });
    }

    function loadAttendanceData() {
        let teacherId = $('#selectedTeacher').val();
        if (!teacherId) return;

        $.ajax({
            url: '{{ route('attendance.fetch') }}',
            method: 'GET',
            data: {
                _token: '{{ csrf_token() }}',
                teacher_id: teacherId,
                year: currentYear,
                month: currentMonth,
            },
            success: function (response) {
                let tableBody = $("#attendance-table tbody");
                tableBody.find("td.attendance-cell").text('-').removeClass('present-day absent-day');
                
                response.forEach(record => {
                    let cell = $(`tr[data-period="${record.period_id}"] td[data-day="${record.day}"]`);
                    cell.text(record.status === 'P' ? '✅' : '❌').addClass(record.status === 'P' ? 'present-day' : 'absent-day');
                });
            }
        });
    }
</script>

<script>
    $('#teachers').on('change', function() {
        $('#selectedTeacher').val($(this).val());
        let tableBody = $("#attendance-table tbody");
        tableBody.find("td.attendance-cell").text('-').removeClass('present-day absent-day');
        loadAttendanceData();
    });
</script>

<script>
    let attendanceData = [];

    $(document).on('click', '.attendance-cell', function () {
        let cell = $(this);
        let periodId = cell.closest('tr').data('period');
        let day = cell.data('day');
        let newStatus = cell.text() === '✅' ? 'A' : 'P';

        cell.text(newStatus === 'P' ? '✅' : '❌').removeClass('present-day absent-day').addClass(newStatus === 'P' ? 'present-day' : 'absent-day');

        attendanceData = attendanceData.filter(entry => !(entry.period_id === periodId && entry.day === day));
        attendanceData.push({ period_id: periodId, day: day, status: newStatus });
    });
</script>

<script>
    $('form').on('submit', function (event) {
        event.preventDefault();

        if (attendanceData.length === 0) {
            Swal.fire({ icon: 'warning', title: 'No Changes', text: 'No attendance changes to save.' });
            return;
        }

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: {
                _token: $('input[name="_token"]').val(),
                attendance: attendanceData,
                year: currentYear,
                month: currentMonth,
                teacher_id: $('#selectedTeacher').val(),
            },
            success: function () {
                Swal.fire({ icon: 'success', title: 'Success!', text: 'Attendance saved successfully!', timer: 2000, showConfirmButton: false });
                attendanceData = [];
            },
            error: function () {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to save attendance. Try again.' });
            }
        });
    });
</script>

@include('layouts.a_footer')