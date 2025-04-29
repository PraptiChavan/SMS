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
                    <h3 class="mb-0">Add New Class</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.classes') }}" id="backToClasses">Classes</a></li>
                        <li class="breadcrumb-item active">Add New Class</li>
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
                    <h3 class="card-title">Add New Class</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.classes.store') }}" method="POST" id="classForm" onsubmit="showLoadingSpinner(event)">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" id="title" maxlength="50" style="margin-top: 20px;" placeholder="Title" required oninput="updateCounter('title', 'titleCounter')">
                            <span id="titleCounter" class="char-counter">0/50</span>
                        </div>
                        <div class="form-group" style="margin-top: 20px;">
                            <label for="sections">Sections</label>
                            @foreach($sections as $section)
                                <div>
                                    <label for="section_{{ $section->id }}" style="margin-top: 20px;">
                                        <input type="checkbox" name="sections[]" id="section_{{ $section->id }}" value="{{ $section->id }}">
                                        {{ $section->title }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <!-- Submit Button -->
                        <button type="submit" id="submitBtn" class="btn btn-success" style="margin-top: 20px;">
                            Submit
                        </button>

                        <!-- Loading Spinner -->
                        <!-- Full-Screen Loading Overlay -->
                        <div id="loadingOverlay" style="display: none !important;">
                            <div class="spinner-box">
                                <img src="{{ asset('assets/img/admin/users/loading.gif') }}" alt="Loading..." width="80">
                                <p><b>Processing, please wait...</b></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    function updateCounter(inputId, counterId) {
        let inputElement = document.getElementById(inputId);
        let counterElement = document.getElementById(counterId);
        counterElement.textContent = `${inputElement.value.length}/${inputElement.maxLength}`;
    }

    // Function to handle breadcrumb click and show the spinner
    function showSpinnerBeforeNavigate(event) {
        // Prevent default navigation action to show the spinner first
        event.preventDefault();

        // Show the loading spinner
        document.getElementById('loadingOverlay').style.display = 'flex';

        // Navigate to the "Classes" page after a small delay
        setTimeout(() => {
            window.location.href = event.target.href; // Redirect to the original link
        }, 100); // Adjust the delay if needed
    }

    // Add the event listener to the breadcrumb link for "Classes"
    document.querySelector('.breadcrumb-item a[href="{{ route('admin.classes') }}"]').addEventListener('click', showSpinnerBeforeNavigate);

</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        // Form submission with AJAX
        $('#classForm').submit(function (event) {
            event.preventDefault(); // Prevent default form submission

            let title = $('#title').val(); // Class title
            let sections = []; // Array to hold selected section IDs

            // Loop through the checkboxes to collect the selected sections
            $('input[name="sections[]"]:checked').each(function () {
                sections.push($(this).val());
            });

            // Show loading spinner
            $('#loadingOverlay').show();

            $.ajax({
                url: "{{ route('admin.classes.store') }}", // Route to store class
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    title: title,
                    sections: sections // Send the selected sections as an array
                },
                success: function (response) {
                    $('#loadingOverlay').hide(); // Hide spinner

                    if (response.success) {
                        // Show success popup
                        Swal.fire({
                            icon: "success",
                            title: "Success!",
                            text: response.success
                        }).then(() => {
                            // Show loading spinner before redirecting
                            $('#loadingOverlay').show(); 

                            // Redirect to classes view after success
                            window.location.href = "{{ route('admin.classes') }}"; 
                        });
                    }
                },
                error: function (xhr) {
                    $('#loadingOverlay').hide(); // Hide spinner

                    if (xhr.status === 400) {
                        // Show error popup
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: xhr.responseJSON.error
                        });
                    }
                }
            });
        });
    });
</script>

@include('layouts.a_footer')