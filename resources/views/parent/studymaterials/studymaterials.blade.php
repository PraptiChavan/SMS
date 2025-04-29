@include('layouts.p_header')
@include('layouts.p_sidebar')


<main class="app-main">
    <!-- App Content Header -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Study Materials</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Parent</a></li>
                        <li class="breadcrumb-item active">Study Materials</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- App Content -->
    <div class="app-content">
        <div class="container-fluid">
            <!-- Courses List -->
            <div class="card">
                <div class="card-header py-2">
                    <h3 class="card-title">Study Materials</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                    <h6 style="margin-top: 10px; margin-bottom: 10px;"><b>Find Student's Study Materials</b></h6>
                        <div class="col-lg-12" style="margin-bottom:20px;">
                            <div class="form-group">
                                <select name="students" id="students" class="form-control">
                                    <option value="">Select Student</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}" data-class="{{ $student->classes }}">{{ $student->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Courses Table -->
                    <div class="col-12">
                        <table class="table table-bordered" id="courses-table" width="100%">
                            <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Title</th>
                                    <th>Attachment</th>
                                    <th>Class</th>
                                    <th>Subject</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody id="study-materials-body">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#students').change(function() {
        let studentId = $(this).val();

        if (studentId) {
            $.ajax({
                url: "{{ url('/parent/fetch-studymaterials') }}",
                type: "POST",
                data: {
                    student_id: studentId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status === 'success') {
                        let materials = response.data;
                        let tableBody = $('#study-materials-body');
                        tableBody.empty();

                        if (materials.length > 0) {
                            $.each(materials, function(index, material) {
                                let row = `<tr>
                                    <td>${index + 1}</td>
                                    <td>${material.title}</td>
                                    <td>${getAttachmentHTML(material.attachment)}</td>
                                    <td>${material.classes}</td>
                                    <td>${material.subjects}</td>
                                    <td>${material.date}</td>
                                    <td>${material.description}</td>
                                </tr>`;
                                tableBody.append(row);
                            });
                        } else {
                            tableBody.append('<tr><td colspan="7" class="text-center">No study materials found for this class.</td></tr>');
                        }
                    } else {
                        alert(response.message);
                    }
                }
            });
        } else {
            $('#study-materials-body').html('<tr><td colspan="7" class="text-center">Select a student to load study materials.</td></tr>');
        }
    });

    function getAttachmentHTML(attachment) {
        if (!attachment) return 'No Attachment';

        let fileExtension = attachment.split('.').pop().toLowerCase();
        let filePath = "{{ asset('storage/') }}" + '/' + attachment;

        if (['jpg', 'jpeg', 'png'].includes(fileExtension)) {
            return `<img src="${filePath}" height="80" alt="Attachment">`;
        } else if (fileExtension === 'pdf') {
            return `<a href="${filePath}" target="_blank"><i class="fa fa-file-pdf text-danger"></i> View PDF</a>`;
        } else if (['doc', 'docx'].includes(fileExtension)) {
            return `<a href="${filePath}" target="_blank"><i class="fa fa-file-word text-primary"></i> View Document</a>`;
        } else if (['ppt', 'pptx'].includes(fileExtension)) {
            return `<a href="${filePath}" target="_blank"><i class="fa fa-file-powerpoint text-warning"></i> View Presentation</a>`;
        } else {
            return `<a href="${filePath}" target="_blank"><i class="fa fa-file"></i> Download</a>`;
        }
    }
});
</script>

@include('layouts.a_footer')
