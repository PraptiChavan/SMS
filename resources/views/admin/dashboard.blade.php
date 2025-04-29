@include('layouts.a_header')
@include('layouts.a_sidebar')

<style>
    .class-title {
        font-family: 'Roboto', Arial, sans-serif; /* Choose a clean, readable font */
        font-weight: 600; /* Make both bold but not too heavy */
        color: #333; /* Dark gray for a modern touch */
        font-size: 1.2rem; /* Balance size for both elements */
        line-height: 1.4;
    }

    /* Ensure consistent spacing and alignment for both sections */
    .form-group {
        margin-bottom: 20px; /* Consistent space under Class dropdown */
    }

    .card-header.match-class-width {
        border-bottom: none !important; /* Remove the line */
        padding-top: 0px; /* Aligns vertically with the Class title */
        padding-bottom: 0px;
    }   

    .card-header {
        position: relative;
        /* padding: 1rem 1rem; */
        background-color: transparent;
        border-bottom: 1px solid var(--bs-border-color-translucent);
        border-top-left-radius: 0.375rem;
        border-top-right-radius: 0.375rem;
    }

    /* Align content inside cards consistently */
    .card-body {
        padding-top: 10px;
        padding-bottom: 10px;
    }

</style>

<main class="app-main">
    <!-- App Content Header -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Dashboard</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- App Content -->
    <div class="app-content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <!-- Total Students -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon text-bg-primary shadow-sm">
                            <i class="fa fa-graduation-cap"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Students</span>
                            <span class="info-box-number">6,000</span>
                        </div>
                    </div>
                </div>
                <!-- Total Teachers -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon text-bg-danger shadow-sm">
                            <i class="fa fa-users"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Teachers</span>
                            <span class="info-box-number">50</span>
                        </div>
                    </div>
                </div>
                <!-- Total Courses -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon text-bg-success shadow-sm">
                            <i class="fa fa-book-open"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Courses</span>
                            <span class="info-box-number">760</span>
                        </div>
                    </div>
                </div>
                <!-- New Inquiries -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon text-bg-warning shadow-sm">
                            <i class="fa fa-question"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">New Inquiries</span>
                            <span class="info-box-number">2,000</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group" style="width: 100%;">
                                <label for="class_id" class="mb-2 class-title">Class</label>
                                <select id="classSelect" name="class_id" class="form-control" style="width: 100%;">
                                    <option value="">Select Class</option>
                                    @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="card-header match-class-width">
                            <h3 class="card-title class-title" style="margin-top: 0;">Upcoming Parent Meetings</h3>
                        </div>
                        <div class="card-body">
                            <ul id="meetingSchedule" class="list-group">
                                <li class="list-group-item text-center">Select a class to get the meeting schedule</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div> 
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $.ajax({
            url: '/admin/dashboard/meetings',
            method: 'GET',
            success: function(response) {
                let meetingsHtml = '';
                if (response.length === 0) {
                    meetingsHtml = '<li class="list-group-item text-center">No upcoming meetings</li>';
                } else {
                    response.forEach(meeting => {
                        meetingsHtml += `
                            <li class="list-group-item">
                                <strong>${meeting.teacher_name}</strong><br>
                                <strong>${meeting.class_title}</strong><br>
                                Date: ${meeting.date}, Time: ${meeting.time}<br>
                                Mode: ${meeting.mode} 
                                ${meeting.meeting_link ? `<br>Link: <a href="${meeting.meeting_link}" target="_blank">Join Meeting</a>` : ''}
                                <br>Status: <span class="badge bg-${meeting.status === 'Pending' ? 'warning' : (meeting.status === 'Accepted' ? 'success' : 'danger')}">${meeting.status}</span>
                            </li>`;
                    });
                }
                $('#meetingList').html(meetingsHtml);
            }
        });
    });
</script>

<script>
    document.getElementById('classSelect').addEventListener('change', function () {
        const classId = this.value;
        const scheduleDiv = document.getElementById('meetingSchedule');

        if (classId) {
            scheduleDiv.innerHTML = `<li class="list-group-item text-center text-primary">Loading meeting schedule...</li>`;
            scheduleDiv.style.display = "block";

            fetch(`/get-meetings/${classId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        let scheduleHTML = '<ul class="list-group">';
                        data.forEach(meeting => {
                            scheduleHTML += `
                                <li class="list-group-item">
                                    <strong>${meeting.teacher_name}</strong><br>
                                    <strong>${meeting.class_title}</strong><br>
                                    Date: ${meeting.date}, Time: ${meeting.formatted_time}<br> <!-- Use formatted_time -->
                                    Mode: ${meeting.mode} 
                                    ${meeting.meeting_link ? `<br>Link: <a href="${meeting.meeting_link}" target="_blank">Join Meeting</a>` : ''}
                                    <br>Status: <span class="badge bg-${meeting.status === 'Pending' ? 'warning' : (meeting.status === 'Accepted' ? 'success' : 'danger')}">${meeting.status}</span>
                                    <br><small class="text-muted">Last updated by: ${meeting.updated_by_name ?? 'Not updated yet'}</small>
                                </li>`;
                        });
                        scheduleHTML += '</ul>';
                        scheduleDiv.innerHTML = scheduleHTML;
                    } else {
                        scheduleDiv.innerHTML = '<li class="list-group-item text-center text-primary">No meetings scheduled for this class.</li>';
                    }
                })
                .catch(() => {
                    scheduleDiv.innerHTML = '<li class="list-group-item text-center text-danger">Error fetching meeting schedule.</li>';
                });
        } else {
            scheduleDiv.innerHTML = `<li class="list-group-item text-center text-muted">Select a class to get the meeting schedule</li>`;
        }
    });
</script>

@include('layouts.a_footer')