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

</style>

<main class="app-main">
    <!-- Content Header -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Parent Meetings</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Teacher</a></li>
                        <li class="breadcrumb-item active">Meetings</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Body -->
    <div class="app-content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
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
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function applyStatusColors() {
        $('.status-select').each(function () {
            const status = $(this).val();
            $(this).removeClass('text-success text-danger text-warning text-primary');

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
                    applyStatusColors();
                },
                error: () => {
                    $(".spinner").hide();
                    $('#meetingSchedule').html('<li class="list-group-item text-center text-danger">Error fetching meetings</li>');
                }
            });
        }

        $(document).on('change', '.status-select', function () {
            const meetingId = $(this).data('id');
            const newStatus = $(this).val();

            $.ajax({
                url: `/teacher/meetings/update-status/${meetingId}`,
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

            applyStatusColors();
        });
    });
</script>

@include('layouts.a_footer')
