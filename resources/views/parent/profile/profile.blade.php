@include('layouts.p_header')
@include('layouts.p_sidebar')

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
                    <h3 class="mb-0">Parent Profile</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Parent</a></li>
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
                    <div class="card border-primary" style="height: 314.11px;">
                        <div class="card-body box-profile text-center">
                            <img class="profile-user-img img-fluid img-circle custom-img" src="{{ asset('assets\img\admin\AdminLTELogo.png') }}" alt="User profile picture">
                            <h3 class="profile-username text-center">{{ $parentName  ?? 'Parent Name' }}</h3>
                            <p class="text-muted text-center">{{ $parentAddress ?? 'N/A' }},
                                {{ $parentState ?? 'N/A' }},
                                {{ $parentCountry ?? 'N/A' }}
                                ({{ $parentZip ?? 'N/A' }})
                            </p>
                            <hr>
                            <p>
                                <strong><i class="fa-fw fas fa-phone-square mr-1"></i> Mobile : </strong>
                                <span class="text-muted float-right">{{ $parentMobile ?? 'N/A' }}</span>
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
                            <p class="text-muted">{{ $parent->parent_education ?? 'B.S. in Computer Science from the University of Tennessee at Knoxville' }}</p>
                            <hr>

                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
                            <p class="text-muted">{{ $parentState ?? 'Malibu' }}, {{ $parentCountry ?? 'California' }}</p>
                            <hr>

                            <strong><i class="fa fa-user mr-2"></i> Children</strong>
                            <p class="text-muted">{{ $children ?? 'No Children'}}</p>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
    </div>
</main>

@include('layouts.a_footer')