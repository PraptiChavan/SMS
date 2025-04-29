@include('layouts.a_header')
@include('layouts.a_sidebar')

<style>
    #loadingOverlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(255, 255, 255, 0.5); /* Dark transparent background */
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999; /* Ensure it's above all other elements */
        display: none; /* Initially hidden */
    }

    .spinner-box {
        background: transparent; /* Slightly visible background */
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        color:#0000cd;
    }
</style>

<main class="app-main">
    <!-- App Content Header -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Manage Courses</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">Courses</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Full Page Loading Spinner -->
    <div id="loadingOverlay" style="display: none;">
        <div class="spinner-box">
            <img src="{{ asset('assets/img/admin/users/loading.gif') }}" alt="Loading..." width="80">
            <p><b>Loading, please wait...</b></p>
        </div>
    </div>

    <!-- App Content -->
    <div class="app-content">
        <div class="container-fluid">
            <!-- Courses List -->
            <div class="card">
                <div class="card-header py-2">
                    <h3 class="card-title">Courses</h3>
                    <div class="card-tools">
                        <!-- Add New Button with onclick event to show the spinner -->
                        <a href="javascript:void(0);" onclick="showLoadingAndRedirect()" class="btn btn-success btn-xs">
                            <i class="fa fa-plus mr-2"></i>Add New
                        </a>
                    </div>
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
                                        <th width="50">ID</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Duration</th>
                                        <th>Date</th>
                                        <th>Action</th>
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
                                            <td>
                                                <!-- Example Action (could be a view/edit/delete button) -->
                                                <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>
                                                <a href="{{ route('admin.courses.destroy', $course->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this course?');"><i class="fa fa-trash fa-fw"></i></a>
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

<script>
    function showLoadingAndRedirect() {
        // Show the spinner
        document.getElementById('loadingOverlay').style.display = 'flex';

        // Redirect to the Add New Class page after a short delay
        setTimeout(function () {
            window.location.href = "{{ route('admin.courses.create') }}"; // Redirect to the "Add New Class" page
        }, 500); // Delay in milliseconds (500ms for the spinner to show)
    }
</script>

@include('layouts.a_footer')
