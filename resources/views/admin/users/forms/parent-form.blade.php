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
        top: 81%; /* Vertically align the counter */
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

<form action="{{ route('user.account.store') }}" method="POST" id="registerForm">
    @csrf
    <input type="hidden" name="type" value="{{ $user }}">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" id="name" maxlength="50" style="margin-top: 20px;" placeholder="Full Name" required oninput="updateCounter('name', 'nameCounter')">
                        <span id="nameCounter" class="char-counter">0/50</span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email" maxlength="100" style="margin-top: 20px;" placeholder="Email" required oninput="updateCounter('email', 'emailCounter')">
                        <span id="emailCounter" class="char-counter">0/100</span>
                    </div>
                </div>
            </div>
            <!-- Submit Button -->
            <button type="submit" id="submitBtn" class="btn btn-success" style="margin-top: 20px;">
                Register
            </button>
        </div>
        <!-- Loading Spinner -->
        <!-- Full-Screen Loading Overlay -->
        <div id="loadingOverlay" style="display: none !important;">
            <div class="spinner-box">
                <img src="{{ asset('assets/img/admin/users/loading.gif') }}" alt="Loading..." width="80">
                <p><b>Processing, please wait...</b></p>
            </div>
        </div>
    </div>
</form>

<script>
    function updateCounter(inputId, counterId) {
        let inputElement = document.getElementById(inputId);
        let counterElement = document.getElementById(counterId);
        counterElement.textContent = `${inputElement.value.length}/${inputElement.maxLength}`;
    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $('#registerForm').on('submit', function(event) {
            event.preventDefault();
            let formData = $(this).serialize();

            // Show the loading spinner when the form is being submitted
            $('#loadingOverlay').show();

            $.ajax({
                url: "{{ route('user.account.store') }}",
                type: "POST",
                data: formData,
                dataType: "json",
                beforeSend: function() {
                    $('#loadingOverlay').show();  // Show spinner
                },
                success: function(response) {
                    $('#loadingOverlay').hide(); // Hide spinner

                    if (!response.success) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.message,
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Account Created',
                            text: response.message,
                            confirmButtonText: 'OK',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Show spinner again before redirecting
                                $('#loadingOverlay').show();

                                // Redirect to users page after a short delay
                                setTimeout(function() {
                                    window.location.href = "{{ route('user.account', ['user' => 'parent']) }}";
                                }, 1500); // 1.5 second delay to show spinner
                            }
                        });
                    }
                },
                error: function(xhr) {
                    $('#loadingOverlay').hide(); // Hide spinner on error
                    let errorMsg = xhr.responseJSON?.message || 'An error occurred. Please try again.';
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMsg,
                    });
                }
            });
        });
    });
</script>