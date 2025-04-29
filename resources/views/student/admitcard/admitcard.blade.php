@include('layouts.s_header')
@include('layouts.s_sidebar')

<main class="app-main">
    <!-- App Content Header -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Admit Card</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Student</a></li>
                        <li class="breadcrumb-item active">Admit Card</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- App Content -->
    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header py-2">
                    <h3 class="card-title">Admit Card</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Admit Card Table -->
                        <div class="col-12">
                            <table class="table table-bordered" id="admitcard-table" width="100%">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Student Name</th>
                                        <th>Fees Paid</th>
                                        <th>Admit Card</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($admitcards as $index => $admitcard)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $admitcard->student_name }}</td>
                                            <td>{{ $admitcard->fees_paid }}</td>
                                            <td>
                                                @if ($admitcard->admit_card)
                                                    <a href="{{ asset('storage/' . $admitcard->admit_card) }}" target="_blank">
                                                        <i class="fa fa-download"></i> Download
                                                    </a>
                                                @else
                                                    No Admit Card Available
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
