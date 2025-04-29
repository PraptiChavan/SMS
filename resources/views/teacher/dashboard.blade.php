@include('layouts.t_header')
@include('layouts.t_sidebar')

<style>

    .card {
        padding: 20px; /* Adds space inside the card */
        border-radius: 8px; /* Optional: gives rounded corners for a cleaner look */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Optional: subtle shadow for better visibility */
    }
    
    .class-title {
        font-family: 'Roboto', Arial, sans-serif;
        font-weight: 600;
        color: #333;
        font-size: 1.2rem;
        line-height: 1.4;
    }

    .card-header.match-class-width {
        border-bottom: none !important;
        padding-top: 0px;
        padding-bottom: 0px;
    }

    .card-body {
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .info-box-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
    }

    .spinner {
        display: none;
        text-align: center;
        font-size: 1.2rem;
        font-weight: 500;
    }

    .status-select.text-success {
        background-color: #d4edda;
        color: #155724;
    }

    .status-select.text-danger {
        background-color: #f8d7da;
        color: #721c24;
    }

    .status-select.text-warning {
        background-color: #fff3cd;
        color: #856404;
    }

    .status-select.text-primary {
        background-color: #d1ecf1;
        color: #0c5460;
    }
    /********** Notice Board, Recent Event CSS Starts **********/

    /* ✅ Event Card Styling */
    html, body {
        max-width: 100%;
        overflow-x: hidden;
    }

    .app-main {
        padding-bottom: 0 !important; /* Remove any extra padding */
    }

    .main-section {
        margin-bottom: 0 !important; /* Ensure no margin at the bottom */
    }

    footer {
        margin-top: 0 !important; /* Ensure the footer sticks right after content */
    }

    .event-list {
        padding: 10px;
        border-bottom: 1px solid #e1e1e1;
    }

    .event-date {
        min-width: 120px;
        text-align: center;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .event-date p {
        font-weight: 500;
        font-size: 14px;
        margin-bottom: 0;
    }

    .event-date h4 {
        font-weight: 600;
        font-size: 22px;
        margin-bottom: 0;
        color: white;
    }

    .event-content p {
        font-size: 14px;
        color: white;
    }

    .event-content h5 {
        font-size: 16px;
        color: white;
        font-weight: 600;
    }

    .event-content h6 {
        font-size: 16px;
        color: white;
    }

    /* ✅ Reduced height for Recent Event marquee */
    .recent-event {
        max-height: 275px; /* ✅ Reduced height */
    }

    .campus-bg {
        background-image: url('/assets/img/unnamed.png'); /* Replace with your image path */
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        border-radius: 8px;
        height: 100%;
        position: relative; /* Ensures overlay stays within this div */
        overflow: hidden; /* Prevents overlay overflow */
    }

    /* Add an overlay with opacity */
    .campus-bg::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6); /* Black overlay with 60% opacity */
        border-radius: 8px; /* Ensures the overlay follows the image’s shape */
        z-index: 0; /* Ensure it’s behind content */
    }

    /* Ensure the content stays visible on top */
    .campus-bg .container {
        position: relative;
        z-index: 1;
    }

    /* Ensure all sections fit within the screen */
    .container-fluid, .row {
        margin: 0;
        padding: 0;
        width: 100%;
    }

    /* Prevent elements from exceeding screen width */
    .app-main {
        overflow-x: hidden;
    }

    /* Adjust the marquee height properly */
    .recent-event {
        overflow: hidden;
    }

    /* Ensure images and other elements do not exceed screen width */
    img {
        max-width: 100%;
        height: auto;
    }

    /********** Notice Board, Recent Event CSS Ends **********/

</style>

<main class="app-main">

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Dashboard</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Teacher</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Campus Events Section -->
        <div class="col-lg-6">
            <div class="main-section py-4 campus-bg">
                <div class="container">
                    <div class="row justify-content-center">
                        <!-- ✅ Recent Event Section -->
                        <div class="col-lg-8 col-12 note-event mb-3">
                            <h2 class="heading-text mt-2 text-center" style="color: white; text-decoration: none; border-bottom: 5px solid var(--bs-primary);">
                                Campus Functions
                            </h2>
                            <span class="heading-border d-block mx-auto mb-3"></span>
                            <marquee direction="up" behavior="scroll" scrollamount="5" class="recent-event" style="height: 350px;">
                                @forelse($events as $event)
                                    <div class="event-list d-flex align-items-center mb-2">
                                        <div class="event-date text-center bg-primary text-white p-2 rounded me-3">
                                            <p class="mb-1">{{ $event->month }}, {{ date('Y', strtotime($event->date)) }}</p>
                                            <h4 class="mb-0">{{ date('d', strtotime($event->date)) }}</h4>
                                        </div>
                                        <div class="event-content">
                                            <h6 class="mb-1">{{ $event->title }}</h6>
                                            <h5 class="mb-0">{{ $event->description }}</h5>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center">No upcoming events</div>
                                @endforelse
                            </marquee>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Meeting Details Section -->
        <div class="col-lg-6">
            <div class="app-content">
                <div class="container-fluid">
                    <!-- Info boxes -->
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="info-box">
                                <span class="info-box-icon text-bg-primary shadow-sm">
                                    <i class="fa fa-calendar-check"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Upcoming Meetings</span>
                                    <span class="info-box-number" id="meeting-count">0</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Meeting Table -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header match-class-width">
                                    <h3 class="card-title class-title">Upcoming Parent Meetings</h3>
                                </div>
                                <div class="card-body">
                                    <ul id="meetingSchedule" class="list-group">
                                        <li class="list-group-item text-center">Fetching meeting schedule...</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function applyStatusColors() {
        $('.status-select').each(function () {
            const status = $(this).val();
            $(this).removeClass('text-success text-danger text-warning text-primary'); // Reset previous colors

            if (status === 'Accepted') {
                $(this).addClass('text-success');
            } else if (status === 'Declined') {
                $(this).addClass('text-danger');
            } else if (status === 'Pending') {
                $(this).addClass('text-warning');
            } else if (status === 'Rescheduled') {
                $(this).addClass('text-primary');
            }
        });
    }

    // Call it after meetings load
    $(document).ready(function () {
        fetchMeetings();

        function fetchMeetings() {
            $(".spinner").show();

            $.ajax({
                url: '/teacher/dashboard/meetings',
                method: 'GET',
                success: function (response) {
                    $(".spinner").hide();

                    let meetingHtml = '';

                    if (Array.isArray(response) && response.length > 0) {
                        response.forEach(meeting => {
                            meetingHtml += 
                                `<li class="list-group-item">
                                    <strong>${meeting.teacher_name}</strong><br>
                                    <strong>${meeting.class_title}</strong><br>
                                    Date: ${meeting.date}, Time: ${meeting.formatted_time}<br>
                                    Mode: ${meeting.mode}
                                    <br>Status:
                                    <select class="form-select status-select" data-id="${meeting.id}">
                                        <option value="Pending" ${meeting.status === 'Pending' ? 'selected' : ''}>Pending</option>
                                        <option value="Accepted" ${meeting.status === 'Accepted' ? 'selected' : ''}>Accepted</option>
                                        <option value="Declined" ${meeting.status === 'Declined' ? 'selected' : ''}>Declined</option>
                                        <option value="Rescheduled" ${meeting.status === 'Rescheduled' ? 'selected' : ''}>Rescheduled</option>
                                    </select>
                                    <br><small class="text-muted">Last updated by: ${meeting.updated_by_name ?? 'Not updated yet'}</small>
                                </li>`;
                        });
                        $('#meeting-count').text(response.length);
                    } else {
                        meetingHtml = '<li class="list-group-item text-center">No upcoming meetings</li>';
                    }

                    $('#meetingSchedule').html(meetingHtml);

                    // Apply colors to dropdowns after content loads
                    applyStatusColors();
                },
                error: () => {
                    $(".spinner").hide();
                    $('#meetingSchedule').html('<li class="list-group-item text-center text-danger">Error fetching meetings</li>');
                }
            });
        }

        // When status changes, apply color again
        $(document).on('change', '.status-select', function () {
            const meetingId = $(this).data('id');
            const newStatus = $(this).val();

            $.ajax({
                url: `/parent/meetings/update-status/${meetingId}`,
                method: 'POST',
                data: {
                    status: newStatus,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.status === 'success') {
                        alert(response.message);
                        fetchMeetings();
                    } else {
                        alert(response.message);
                    }
                },
                error: function () {
                    alert('Error updating meeting status');
                }
            });

            // Apply colors instantly after the change (no need to wait for reload)
            applyStatusColors();
        });
    });

</script>

@include('layouts.a_footer')
