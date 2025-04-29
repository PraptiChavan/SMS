@include('layouts.s_header')
@include('layouts.s_sidebar')

<style>
    .custom-img {
        height: 80px; /* Adjust as needed */
        width: 80px; /* Keep it circular */
        object-fit: cover; /* Prevent distortion */
    }
</style>

<main class="app-main">
    <!-- App Content Header -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Student Profile</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Student</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <!-- App Content -->
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <!-- Student Profile Section -->
                <div class="col-md-3">
                    <div class="card border-primary" style="height: 395.3px;">
                        <div class="card-body box-profile text-center">
                            <img class="profile-user-img img-fluid img-circle custom-img" src="{{ asset('assets\img\admin\AdminLTELogo.png') }}" alt="User profile picture">
                            <h3 class="profile-username text-center">{{ $student->name ?? 'Student Name' }}</h3>
                            <p class="text-muted text-center">{{ $studentAddress ?? 'N/A' }},
                                {{ $studentState ?? 'N/A' }},
                                {{ $studentCountry ?? 'N/A' }}
                                ({{ $studentZip ?? 'N/A' }})
                            </p>
                            <hr>
                            <p>
                                <strong><i class="fa-fw fas fa-chalkboard mr-1"></i> Class : </strong>
                                <span class="text-muted float-right">{{ $studentClass ?? 'N/A' }}</span>
                            </p>
                            <hr>
                            <p>
                                <strong><i class="fa-fw fas fa-calendar-alt mr-1"></i> DOB : </strong>
                                <span class="text-muted float-right">{{ $studentDOB ?? 'N/A' }}</span>
                            </p>
                            <hr>
                            <p>
                                <strong><i class="fa-fw fas fa-phone-square mr-1"></i> Mobile : </strong>
                                <span class="text-muted float-right">{{ $studentMobile ?? 'N/A' }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Parent's Information Section -->
                <div class="col-md-9">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Parent's Information</h3>
                        </div>

                        <div class="card-body">
                            <strong><i class="fas fa-book mr-1"></i> Education</strong>
                            <p class="text-muted">{{ $student->parent_education ?? 'B.S. in Computer Science from the University of Tennessee at Knoxville' }}</p>
                            <hr>

                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
                            <p class="text-muted">{{ $studentState ?? 'Malibu' }}, {{ $studentCountry ?? 'California' }}</p>
                            <hr>

                            <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>
                            <p class="text-muted">
                                @foreach(['UI Design', 'Coding', 'Javascript', 'PHP', 'Node.js'] as $skill)
                                    <span class="badge bg-primary">{{ $skill }}</span>
                                @endforeach
                            </p>
                            <hr>

                            <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>
                            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
    </div>
</main>

@include('layouts.a_footer')