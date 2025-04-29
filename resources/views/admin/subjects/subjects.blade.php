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
                    <h3 class="mb-0">Manage Subjects</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">Subjects</li>
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
                    <!-- Subjects List -->
                    <div class="card">
                        <div class="card-header py-2">
                            <h3 class="card-title">Subjects</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-bordered" id="subjects-table" width="100%">
                                        <thead>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>Subject Name</th>
                                                <th>Class</th>
                                                <th>Section</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($subjects as $subject)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $subject->name }}</td>
                                                    <td>{{ $subject->classTitle }}</td>
                                                    <td>{{ implode(', ', $subject->sectionTitles) }}</td>
                                                    <td>
                                                        <!-- Example Action (could be a view/edit/delete button) -->
                                                        <a href="{{ route('admin.subjects.edit', $subject->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>
                                                        <a href="{{ route('admin.subjects.destroy', $subject->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this class?');"><i class="fa fa-trash fa-fw"></i></a>
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
                <!-- Add New Subject -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header py-2">
                            <h3 class="card-title">Add New Subject</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.subjects.store') }}" method="POST" id="subjectForm">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Subject Name</label>
                                    <input type="text" name="name" class="form-control" id="name" maxlength="50" style="margin-top: 20px;" placeholder="Subject Name" required oninput="updateCounter('name', 'nameCounter')">
                                    <span id="nameCounter" class="char-counter">0/50</span>
                                </div>
                                <div class="form-group">
                                    <label for="classes" style="margin-top: 20px;">Class</label>
                                    <select name="classes" id="classes" class="form-control" style="margin-top: 20px;" required>
                                        <option value="">Select Category</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}">{{ $class->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="sections" style="margin-top: 20px;">Section</label>
                                    <select name="sections" id="sections" class="form-control" style="margin-top: 20px;">
                                        <option value="">Select Category</option>
                                    </select>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#classes').on('change', function() {
            var classId = $(this).val();
            if (classId) {
                $.ajax({
                    url: '{{ url("get-sections") }}/' + classId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#sections').empty().append('<option value="">Select Section</option>');
                        $.each(data, function(id, title) {
                            $('#sections').append('<option value="' + id + '">' + title + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', xhr.responseText);
                        alert('Unable to fetch sections.');
                    }
                });
            } else {
                $('#sections').empty().append('<option value="">Select Section</option>');
            }
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        $('#subjectForm').submit(function (event) {
            event.preventDefault(); // Prevent default form submission

            let subjectName = $('#name').val();
            let classId = $('#classes').val();
            let sectionId = $('#sections').val();

            $('#loadingOverlay').show(); // Show spinner

            $.ajax({
                url: "{{ route('admin.subjects.store') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    name: subjectName,
                    classes: classId,
                    sections: sectionId
                },
                success: function (response) {
                    $('#loadingOverlay').hide(); // Hide spinner
                    
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: response.success
                    }).then(() => {
                        if (response.updatedSubject) {
                            updateTable(response.updatedSubject, true); // Update existing row
                        } else {
                            updateTable(response.newSubject, false); // Add new row
                        }
                        $('#name').val('');
                        $('#classes').val('');
                        $('#sections').empty().append('<option value="">Select Section</option>');
                        updateCounter('name', 'nameCounter');
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

        function updateTable(subject, isUpdate) {
            if (isUpdate) {
                let row = $(`#subjects-table tbody tr:contains('${subject.name}')`).filter(function () {
                    return $(this).find("td:eq(2)").text() === subject.classTitle;
                });

                if (row.length) {
                    row.find("td:eq(3)").text(subject.sectionTitles.join(', '));
                    return;
                }
            }

            let newRow = `<tr>
                <td>${$('#subjects-table tbody tr').length + 1}</td>
                <td>${subject.name}</td>
                <td>${subject.classTitle}</td>
                <td>${subject.sectionTitles.join(', ')}</td>
            </tr>`;
            $('#subjects-table tbody').append(newRow);
        }
    });
</script>

@include('layouts.a_footer')