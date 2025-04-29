@include('layouts.p_header')
@include('layouts.p_sidebar')

<main class="app-main">
    <!-- App Content Header -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Periods</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Parent</a></li>
                        <li class="breadcrumb-item active">Periods</li>
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
                        <table class="table table-bordered" id="sections-table" width="100%">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Title</th>
                                    <th>From</th>
                                    <th>To</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($periods as $period)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $period->title }}</td>
                                        <td>{{ $period->from }}</td>
                                        <td>{{ $period->to }}</td>
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
