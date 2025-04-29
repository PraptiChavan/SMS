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
                    <h3 class="mb-0">Manage Periods</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">Periods</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Loading Spinner -->
    <!-- Full-Screen Loading Overlay -->
    <div id="loadingOverlay" style="display: none !important;">
        <div class="spinner-box">
            <img src="{{ asset('assets/img/admin/users/loading.gif') }}" alt="Loading..." width="80">
            <p><b>Processing, please wait...</b></p>
        </div>
    </div>

    <!-- App Content -->
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Classes List -->
                    <div class="card">
                        <div class="card-header py-2">
                            <h3 class="card-title">Periods</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-bordered" id="sections-table" width="100%">
                                        <thead>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>Title</th>
                                                <th>From</th>
                                                <th>To</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($periods as $period)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $period->title }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($period->from)->format('H:i') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($period->to)->format('H:i') }}</td>
                                                    <td>
                                                        <!-- Example Action (could be a view/edit/delete button) -->
                                                        <a href="{{ route('admin.periods.edit', $period->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>
                                                        <a href="{{ route('admin.periods.destroy', $period->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');"><i class="fa fa-trash fa-fw"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header py-2">
                            <h3 class="card-title">Add New Period</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.periods.store') }}" method="POST" id="periodForm">
                                @csrf
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" id="title" name="title" class="form-control" maxlength="50" style="margin-top: 20px; margin-bottom: 20px;" placeholder="Title" required oninput="updateCounter('title', 'titleCounter')">
                                    <span id="titleCounter" class="char-counter">0/50</span>
                                </div>
                                <div class="form-group">
                                    <label for="from">From</label>
                                    <input type="time" id="from" name="from" style="margin-top: 20px; margin-bottom: 20px; padding-right: 10px;" placeholder="From" required class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="to">To</label>
                                    <input type="time" id="to" name="to" style="margin-top: 20px; padding-right: 10px;" placeholder="To" required class="form-control">
                                </div>
                                <!-- Submit Button -->
                                <button type="submit" id="submitBtn" class="btn btn-success float-right" style="margin-top: 20px;">
                                    Submit
                                </button>
                            </form>
                        </div>
                    </div> 
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
    function showLoadingSpinner(event) {
        event.preventDefault(); // Prevent immediate form submission
        document.getElementById('loadingOverlay').style.display = 'flex'; // Show overlay
        setTimeout(() => {
            event.target.submit(); // Submit the form after showing spinner
        }, 100); // Small delay to ensure UI updates
    }
</script> 

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        $('#periodForm').submit(function (event) {
            event.preventDefault(); // Prevent default form submission
            
            let title = $('#title').val(); // Get title input value
            let from = $('#from').val(); // Get start time
            let to = $('#to').val(); // Get end time
            $('#loadingOverlay').show(); // Show spinner
            
            $.ajax({
                url: "{{ route('admin.periods.store') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    title: title,
                    from: from,
                    to: to
                },
                success: function (response) {
                    $('#loadingOverlay').hide(); // Hide spinner
                    
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: response.success
                    }).then(() => {
                        updateTable(response.newPeriod); // Update table dynamically
                        $('#title').val(''); // Clear input fields
                        $('#from').val('');
                        $('#to').val('');
                        updateCounter('title', 'titleCounter'); // Reset the counter to 0
                    });
                },
                error: function (xhr) {
                    $('#loadingOverlay').hide(); // Hide spinner
                    if (xhr.status === 400) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: xhr.responseJSON.error
                        });
                    }
                }
            });
        });

        // Function to update the table dynamically
        function updateTable(period) {
            let newRow = `<tr>
                <td>${$('#sections-table tbody tr').length + 1}</td> <!-- Updated table ID -->
                <td>${period.title}</td>
                <td>${period.from}</td>
                <td>${period.to}</td>
            </tr>`;
            $('#sections-table tbody').append(newRow); // Update this with the correct table ID
        }
    });
</script>

@include('layouts.a_footer')