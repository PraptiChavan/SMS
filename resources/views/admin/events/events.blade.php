@include('layouts.a_header')
@include('layouts.a_sidebar')

<style>
    /********** Notice Board, Recent Event CSS Starts **********/

    /* ✅ Event Card Styling */
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
        max-height: 350px; /* ✅ Reduced height */
    }

    .campus-bg {
        background-image: url('/assets/img/unnamed.png'); /* Replace with your image path */
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 100%;
    }

    /* Add an overlay with opacity */
    .campus-bg::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6); /* Black overlay, 50% opacity */
        z-index: 0; /* Ensure it’s behind content */
    }

    /* Ensure the content stays visible on top */
    .campus-bg .container {
        position: relative;
        z-index: 1;
    }

    /********** Notice Board, Recent Event CSS Ends **********/

</style>

<main class="app-main">
    <div class="main-section py-4 campus-bg">
        <div class="container">
            <div class="row justify-content-center">
                <!-- ✅ Recent Event Section -->
                <div class="col-lg-8 col-12 note-event mb-3">
                <h2 class="heading-text mt-2 text-center" style="color: white; text-decoration: none; border-bottom: 5px solid var(--bs-primary);">Campus Functions</h2>
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
</main>

@include('layouts.a_footer')
