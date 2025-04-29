@include('layouts.s_header')
@include('layouts.s_sidebar')

<main class="app-main">
    <!-- App Content Header -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Courses</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Student</a></li>
                        <li class="breadcrumb-item active">Courses</li>
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
                        <table class="table table-bordered" id="courses-table" width="100%">
                            <thead>
                                <tr>
                                    <th width="50">ID</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Duration</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($courses as $course)
                                    <tr>
                                        <td>{{ $course->id }}</td>
                                        <td>
                                            <img src="{{ $course->image ? asset('storage/' . $course->image) : asset('images/no-image.png') }}" height="100" alt="Course Image">
                                        </td>
                                        <td>{{ $course->name }}</td>
                                        <td>{{ $course->category }}</td>
                                        <td>{{ $course->duration }}</td>
                                        <td>{{ $course->date }}</td>
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
