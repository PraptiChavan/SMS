@include('layouts.s_header')
@include('layouts.s_sidebar')

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
                        <li class="breadcrumb-item"><a href="#">Student</a></li>
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
                            <tbody>
                                @foreach ($periods as $period)
                                    <tr>
                                        <!-- Period time formatted with Carbon -->
                                        <td>{{ \Carbon\Carbon::parse($period->from)->format('h:i A') }} - {{ \Carbon\Carbon::parse($period->to)->format('h:i A') }}</td>

                                        @foreach ($weekdays as $weekday)
                                            <td>
                                                @foreach ($time as $entry)
                                                    @if(in_array($weekday->id, explode(',', $entry->weekdays)) && in_array($period->id, explode(',', $entry->periods)))
                                                    <p>
                                                        <b>Teachers:</b> 
                                                        @php
                                                            $teacherNames = [];
                                                            foreach (explode(',', $entry->teachers) as $teacherId) {
                                                                $teacher = \App\Models\admin\Account::find($teacherId);
                                                                if ($teacher) {
                                                                    $teacherNames[] = $teacher->name;
                                                                }
                                                            }
                                                            echo implode(', ', $teacherNames);
                                                        @endphp
                                                        <br>
                                                        <b>Subjects:</b> 
                                                        @php
                                                            $subjectNames = [];
                                                            foreach (explode(',', $entry->subjects) as $subjectId) {
                                                                $subject = \App\Models\admin\SubjectModel::find($subjectId);
                                                                if ($subject) {
                                                                    $subjectNames[] = $subject->name;
                                                                }
                                                            }
                                                            echo implode(', ', $subjectNames);
                                                        @endphp
                                                    </p>
                                                    @endif
                                                @endforeach
                                            </td>
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




@include('layouts.a_footer')
