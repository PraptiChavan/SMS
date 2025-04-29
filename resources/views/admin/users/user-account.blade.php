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
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6"><h3 class="mb-0">Manage Accounts</h3></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Accounts</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ ucfirst($user) }}</li>
            </ol>
            </div>
        </div>
        <!--end::Row-->
        @if($user !== 'parent')
            <div class="card-tools">
                <a href="javascript:void(0);" onclick="showLoadingAndRedirect()" class="btn btn-success btn-xs">
                    <i class="fa fa-plus mr-2"></i>Add New
                </a>
            </div>
        @endif
        </div>
        <!--end::Container-->
    </div>
    
    <!-- Full Page Loading Spinner -->
    <div id="loadingOverlay" style="display: none;">
        <div class="spinner-box">
            <img src="{{ asset('assets/img/admin/users/loading.gif') }}" alt="Loading..." width="80">
            <p><b>Loading, please wait...</b></p>
        </div>
    </div>

    <!--begin::App Content-->  
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
        <!-- Info boxes -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <!-- Courses Table -->
                        <div class="col-12">
                            <table class="table table-bordered" id="users-table" width="100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        @if ($user === 'parent')
                                            <th>Student Name</th>
                                        @endif
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($accounts as $account)
                                        <tr>
                                            <td>{{ $account->id }}</td>
                                            <td>{{ $account->name }}</td>
                                            <td>{{ $account->email }}</td>
                                            @if ($user === 'parent')
                                            <td>
                                                {{ $account->students ?? 'No Students Assigned' }}
                                            </td>
                                            @endif
                                            <td>
                                                <!-- Example Action (could be a view/edit/delete button) -->
                                                <a href="{{ route('user.account.edit', ['id' => $account->id]) }}" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>
                                                <a href="{{ route('user.account.delete', ['id' => $account->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');"><i class="fa fa-trash fa-fw"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if (isset($message))
                            <p>{{ $message }}</p>
                        @endif
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
            window.location.href = "{{ route('user.account.create', ['user' => $user]) }}"; // Redirect to the "Add New Class" page
        }, 500); // Delay in milliseconds (500ms for the spinner to show)
    }
</script>

@include('layouts.a_footer')