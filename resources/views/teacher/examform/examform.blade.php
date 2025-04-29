@include('layouts.t_header')
@include('layouts.t_sidebar')


<main class="app-main">
    <!-- App Content Header -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Exam Form</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Teacher</a></li>
                        <li class="breadcrumb-item active">Exam Form</li>
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
                <div class="card-header py-2">
                    <h3 class="card-title">Exam Form</h3>
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
                                        <th>Exam Name</th>
                                        <th>Class</th>
                                        <th>Subject</th>
                                        <th>Date</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Total Marks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($examform as $examforms)
                                        <tr>
                                            <td>{{ $examforms->name }}</td>
                                            <td>
                                            @php
                                                $class = \App\Models\admin\ClassModel::find($examforms->classes);
                                                echo $class ? $class->title : 'No Class';
                                            @endphp
                                            </td>
                                            <td>
                                            @php
                                                $subjectNames = [];
                                                foreach (explode(',', $examforms->subjects) as $subjectId) {
                                                    $subject = \App\Models\admin\SubjectModel::find($subjectId);
                                                    if ($subject) {
                                                        $subjectNames[] = $subject->name;
                                                    }
                                                }
                                                echo implode(', ', $subjectNames);
                                            @endphp
                                            </td>
                                            <td>{{ $examforms->date }}</td>
                                            <td>{{ \Carbon\Carbon::parse($examforms->start_time)->format('H:i') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($examforms->end_time)->format('H:i') }}</td>
                                            <td>{{ $examforms->total_marks }}</td>
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



@include('layouts.a_footer')
