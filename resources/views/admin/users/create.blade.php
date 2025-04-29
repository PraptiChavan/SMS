@include('layouts.a_header')
@include('layouts.a_sidebar')

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Add New {{ ucfirst($user) }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('user.account', ['user' => $user]) }}">Accounts</a></li>
                        <li class="breadcrumb-item active"><a href="#" id="backToUser">{{ ucfirst($user) }}</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            @if($user === 'student')
                @include('admin.users.forms.student-form', ['classes' => $classes])
            @elseif($user === 'teacher')
                @include('admin.users.forms.teacher-form')
            @elseif($user === 'parent')
                @include('admin.users.forms.parent-form')
            @elseif($user === 'counseller')
                @include('admin.users.forms.counseller-form')
            @elseif($user === 'librarian')
                @include('admin.users.forms.librarian-form')
            @endif
        </div>
    </div>
</main>

<script>
    // Add the event listener to the breadcrumb link for "Classes"
    document.querySelector('.breadcrumb-item a[href="{{ route('user.account', ['user' => 'type']) }}"]');
</script>

@include('layouts.a_footer')
