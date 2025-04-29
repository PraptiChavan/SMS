@include('layouts.s_header')
@include('layouts.s_sidebar')

<main class="app-main">
    <!-- App Content Header -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Results</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Student</a></li>
                        <li class="breadcrumb-item active">Results</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- App Content -->
    <div class="app-content">
        <div class="container-fluid">
            <!-- Results List -->
            <div class="card">
                <div class="card-header py-2">
                    <h3 class="card-title">Results</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Results Table -->
                        <div class="col-12">
                            <table class="table table-bordered" id="results-table" width="100%">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Exam Name</th>
                                        <th>Result</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($results as $result)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @php
                                                    $exam = \App\Models\admin\ExamForm::find($result->exam_name);
                                                    echo $exam ? $exam->name : 'N/A';
                                                @endphp
                                            </td>
                                            <td>
                                                @if ($result->results)
                                                    <a href="{{ asset('storage/' . $result->results) }}" target="_blank">
                                                        <i class="fa fa-file"></i> View Result
                                                    </a>
                                                @else
                                                    Not Available
                                                @endif
                                            </td>
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
