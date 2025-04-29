@include('layouts.p_header')
@include('layouts.p_sidebar')

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Admit Card</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Parent</a></li>
                        <li class="breadcrumb-item active">Admit Card</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <h6 style="margin-top: 10px; margin-bottom: 10px;"><b>Download Student's Admit Card</b></h6>
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

                    <!-- Admit Card Table -->
                    <div class="col-12">
                        <table class="table table-bordered" id="admitcard-table" width="100%">
                            <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <th>Fees Paid</th>
                                    <th>Admit Card</th>
                                </tr>
                            </thead>
                            <tbody id="admitcard-body">
                                <tr>
                                    <td colspan="5" class="text-center">Select a student to view admit cards</td>
                                </tr>
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
    $(document).ready(function () {
        $('#students').change(function () {
            let studentId = $(this).val();

            if (studentId) {
                $.ajax({
                    url: "{{ url('/parent/fetch-admitcards') }}",
                    type: "POST",
                    data: {
                        student_id: studentId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        let tableBody = $('#admitcard-body');
                        tableBody.empty();

                        if (response.status === 'success') {
                            let admitCards = response.data;

                            if (admitCards.length > 0) {
                                $.each(admitCards, function (index, card) {
                                    let row = `<tr>
                                        <td>${card.student_name}</td>
                                        <td>${card.fees_paid}</td>
                                        <td><a href="${card.admit_card_url}" target="_blank">Download</a></td>
                                    </tr>`;
                                    tableBody.append(row);
                                });
                            } else {
                                tableBody.append('<tr><td colspan="5" class="text-center">No admit cards available for this class.</td></tr>');
                            }
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function () {
                        alert('Failed to fetch admit cards');
                    }
                });
            } else {
                $('#admitcard-body').html('<tr><td colspan="5" class="text-center">Select a student to load admit cards.</td></tr>');
            }
        });
    });
</script>

@include('layouts.a_footer')
