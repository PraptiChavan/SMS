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
                    <h3 class="mb-0">Manage Sections</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">Sections</li>
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
                            <h3 class="card-title">Sections</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-bordered" id="sections-table" width="100%">
                                        <thead>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>Sections</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sections as $section)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $section->title }}</td>
                                                    <td>
                                                        <!-- Example Action (could be a view/edit/delete button) -->
                                                        <a href="{{ route('admin.sections.edit', $section->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>
                                                        <a href="{{ route('admin.sections.destroy', $section->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this section?');"><i class="fa fa-trash fa-fw"></i></a>
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
                            <h3 class="card-title">Add New Section</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.sections.store') }}" method="POST" id="sectionForm">
                                @csrf
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" id="title" maxlength="50" style="margin-top: 20px;" placeholder="Title" required oninput="updateCounter('title', 'titleCounter')">
                                    <span id="titleCounter" class="char-counter">0/50</span>
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
</script> 

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        $('#sectionForm').submit(function (event) {
            event.preventDefault(); // Prevent default form submission
            
            let title = $('#title').val(); // Get input value
            $('#loadingOverlay').show(); // Show spinner
            
            $.ajax({
                url: "{{ route('admin.sections.store') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    title: title
                },
                success: function (response) {
                    $('#loadingOverlay').hide(); // Hide spinner
                    
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: response.success
                    }).then(() => {
                        updateTable(response.newSection); // Update table dynamically
                        $('#title').val(''); // Clear input field
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
        function updateTable(section) {
            let newRow = `<tr>
                <td>${$('#sections-table tbody tr').length + 1}</td>
                <td>${section.title}</td>
            </tr>`;
            $('#sections-table tbody').append(newRow);
        }
    });
</script>

@include('layouts.a_footer')