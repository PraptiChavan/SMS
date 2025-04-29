@include('layouts.a_header')
@include('layouts.a_sidebar')

<style>
    .form-group {
        position: relative; /* Make sure form-group is relatively positioned to position the counter */
    }

    .form-control {
        padding-right: 50px; /* Leaves space for the counter */
    }

    .char-counter {
        position: absolute;
        right: 10px; /* Shift the counter to the right */
        top: 78%; /* Vertically align the counter */
        transform: translateY(-50%); /* Ensure the counter is perfectly centered vertically */
        font-size: 13px;
        color: gray;
        background: transparent;
        padding: 10px;
        pointer-events: none;
    }
</style>

<main class="app-main">
    <!-- App Content Header -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Meetings</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">Meetings</li>
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
                    <h3 class="card-title">Meetings</h3>
                </div>
                <div class="card-body">
                    <form id="meetingForm">
                        @csrf
                        <div class="form-group">
                            <label for="teacher_id">Teacher Name</label>
                            <select name="teacher_id" class="form-control" style="margin-top: 20px;">
                                <option value="">Select Teacher</option>
                                @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="class_id" style="margin-top: 20px;">Class</label>
                            <select name="class_id" class="form-control" style="margin-top: 20px;">
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="date" style="margin-top: 20px;">Date</label>
                            <input type="date" id="date" name="date" style="margin-top: 20px; padding-right: 10px;" required class="form-control" min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="form-group">
                            <label for="time" style="margin-top: 20px;">Time</label>
                            <input type="time" id="time" name="time" style="margin-top: 20px; padding-right: 10px;" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="agenda" style="margin-top: 20px;">Agenda</label>
                            <textarea name="agenda" id="agenda" maxlength="150" required oninput="updateCounter('agenda', 'agendaCounter')" class="form-control" style="margin-top: 20px;"></textarea>
                            <span id="agendaCounter" class="char-counter">0/150</span>
                        </div>
                        <div class="form-group">
                            <label for="mode" style="margin-top: 20px;">Mode</label>
                            <select name="mode" class="form-control" style="margin-top: 20px;">
                                <option value="">Select Mode</option>
                                <option value="Online">Online</option>
                                <option value="Offline">Offline</option>
                            </select>
                        </div>
                        <!-- Submit Button -->
                        <button type="submit" id="submitBtn" class="btn btn-success" style="margin-top: 20px;">
                            Schedule
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function updateCounter(inputId, counterId) {
        let inputElement = document.getElementById(inputId);
        let counterElement = document.getElementById(counterId);
        counterElement.textContent = `${inputElement.value.length}/${inputElement.maxLength}`;
    }
</script>
<script>
    $('#meetingForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '/admin/meetings/store',
            data: $(this).serialize(),
            success: function(response) {
                alert(response.success);
                window.location.href = '/admin/dashboard';  // Redirect to the dashboard
                // window.location.href = "{{ route('admin.dashboard') }}"
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON?.error || 'Something went wrong.'));
            }
        });
    });
</script>
@include('layouts.a_footer')