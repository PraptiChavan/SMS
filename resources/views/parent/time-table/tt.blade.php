@include('layouts.p_header')
@include('layouts.p_sidebar')

<style>
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
                    <h3 class="mb-0">Time Table</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Parent</a></li>
                        <li class="breadcrumb-item active">Time Table</li>
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
                    <h6 style="margin-top: 10px; margin-bottom: 10px;"><b>Find Student's Time-Table</b></h6>
                        <div class="col-lg-12" style="margin-bottom:20px;">
                            <div class="form-group">
                                <select name="students" id="students" class="form-control">
                                    <option value="">Select Student</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}" data-class="{{ $student->classes }}" data-section="{{ $student->sections }}">{{ $student->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Courses Table -->
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
                                            <td></td> {{-- Initially empty cells --}}
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
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#students').change(function () {
            var studentId = $(this).val();
            var studentClass = $('#students option:selected').data('class');
            var studentSection = $('#students option:selected').data('section');

            if (studentId) {
                $.ajax({
                    url: '{{ url("filter-time-table") }}',
                    type: 'GET',
                    data: { student_id: studentId, class_id: studentClass, section_id: studentSection },
                    dataType: 'json',
                    success: function (data) {
                        updateTimeTable(data);
                    },
                    error: function () {
                        alert('Error fetching timetable data.');
                    }
                });
            } else {
                $('#timetable-body').empty();
            }
        });

        function updateTimeTable(data) {
            $('#timetable-body').empty();
            
            @foreach ($periods as $period)
            var row = `<tr>
                <td>{{ \Carbon\Carbon::parse($period->from)->format('h:i A') }} - {{ \Carbon\Carbon::parse($period->to)->format('h:i A') }}</td>`;
            
            @foreach ($weekdays as $weekday)
            var cellData = "";
            data.forEach(entry => {
                if (entry.weekdays.includes("{{ $weekday->id }}") && entry.periods.includes("{{ $period->id }}")) {
                    cellData += `<p><b>Teachers:</b> ${Array.isArray(entry.teachers) ? entry.teachers.join(', ') : entry.teachers} <br>
                                 <b>Subjects:</b> ${Array.isArray(entry.subjects) ? entry.subjects.join(', ') : entry.subjects} <br>
                                 </p>`;
                }
            });

            row += `<td>${cellData}</td>`;
            @endforeach
            
            row += `</tr>`;
            $('#timetable-body').append(row);
            @endforeach
        }
    });
</script>

@include('layouts.a_footer')
