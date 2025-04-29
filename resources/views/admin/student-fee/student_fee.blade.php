@include('layouts.a_header')
@include('layouts.a_sidebar')

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Manage Student Fee Details</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Student Fee Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!--begin::App Content-->  
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
        <!-- Info boxes -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Courses Table -->
                        <div class="col-12">
                            <table class="table table-bordered" id="users-table" width="100%">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)
                                        <tr>
                                            <td>{{ $student->id }}</td>
                                            <td>{{ $student->name }}</td>
                                            <td>
                                                <input type="hidden" class="student-class" value="{{ $student->classes }}"> <!-- Hidden field for class -->
                                                <!-- Example Action (could be a view/edit/delete button) -->
                                                <a href="#" class="btn btn-info btn-sm">
                                                    <i class="fa fa-eye fa-fw" style="margin-right: 5px;"></i>View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if (isset($message))
                            <p>{{ $message }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div> 
</main>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".btn-info").forEach(button => {
            button.addEventListener("click", function (event) {
                event.preventDefault();

                // Get the closest row and extract student details
                let row = this.closest("tr");
                let studentName = row.querySelector("td:nth-child(2)").innerText; // Extract name
                let studentClass = row.querySelector(".student-class").value; // Extract class from hidden input

                // Hide the existing table
                document.getElementById("users-table").style.display = "none";

                // Months array
                let months = [
                    "January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December"
                ];

                // Get the current month index (0-based, so add 1 for 1-based Sr No.)
                let currentMonthIndex = new Date().getMonth();

                // Create new table structure with the current month highlighted
                let newTable = `
                    <h4>Student Details</h4>
                    <div class="d-flex">
                        <b>Name:</b> <span class="ms-2">${studentName} </span>
                    </div>
                    <div class="d-flex">
                        <b>Class:</b> <span class="ms-2">${studentClass} </span>
                    </div>
                    <h4 style="margin-bottom: 15px; margin-top: 20px;">Tuition Fees</h4>
                    <table class="table table-bordered" id="new-table" width="100%">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Months</th>
                                <th>Fee Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${months.map((month, i) => `
                                <tr class="${i === currentMonthIndex ? 'table-success text-white' : ''}">
                                    <td>${i + 1}</td>
                                    <td>${month}</td>
                                    <td></td>
                                    <td>
                                        <a href="#" class="btn btn-primary btn-sm" style="margin-right: 3px;">
                                            <i class="fa fa-money-bill"></i> View
                                        </a>
                                        <a href="#" class="btn btn-dark btn-sm" style="margin-right: 3px;">
                                            <i class="fa fa-money-bill"></i> Pay Now
                                        </a>
                                        <a href="#" class="btn btn-success btn-sm">
                                            <i class="fa fa-envelope fa-fw"></i> Send Message
                                        </a>
                                        <a href="#" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash fa-fw"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                `;

                // Inject new table into .card-body
                document.querySelector(".card-body").innerHTML = newTable;
            });
        });
    });


</script>

@include('layouts.a_footer')