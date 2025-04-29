@include('layouts.s_header')
@include('layouts.s_sidebar')

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

                        <h4>Student Details</h4>
                        <div class="d-flex">
                            <b>Name:</b> <span class="ms-2">{{ $student->name ?? 'N/A' }} </span>
                        </div>
                        <div class="d-flex">
                            <b>Class:</b> <span class="ms-2">{{ $studentClass ?? 'N/A' }} </span>
                        </div>
                        <h4 style="margin-bottom: 15px; margin-top: 20px;">Tuition Fees</h4>

                        <!-- Fees Table -->
                        <div class="col-12">
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
                                @php
                                    $months = [
                                        "January", "February", "March", "April", "May", "June",
                                        "July", "August", "September", "October", "November", "December"
                                    ];
                                    $currentMonthIndex = date('n') - 1; // Get current month index (0-based)
                                @endphp

                                @foreach ($months as $index => $month)
                                    <tr class="{{ $index === $currentMonthIndex ? 'table-success text-white' : '' }}">
                                        <td>{{ $index + 1 }}</td>  <!-- Serial number (1 to 12) -->
                                        <td>{{ $month }}</td>     <!-- Month name -->
                                        <td></td>
                                        <td>
                                            <a href="#" class="btn btn-primary btn-sm" style="margin-right: 3px;">
                                                <i class="fa fa-money-bill"></i> View
                                            </a>
                                            <a href="#" class="btn btn-dark btn-sm pay-now-btn" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#paymentModal" 
                                                data-name="{{ $student->name ?? 'N/A' }}" 
                                                data-email="{{ $student->email ?? 'N/A' }}" 
                                                data-phone="{{ $studentMobile ?? 'N/A' }}" 
                                                data-month="{{ $month }}"
                                                style="margin-right: 3px;">
                                                <i class="fa fa-money-bill"></i> Pay Now
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

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Confirm Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" method="post" name="payuForm">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" style="margin-bottom: 5px;">Full Name</label>
                                <input type="text" name="firstname" style="margin-bottom: 5px;" readonly class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" style="margin-bottom: 5px;" >Email Address</label>
                                <input type="email" name="email" style="margin-bottom: 5px;" readonly class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" style="margin-bottom: 5px;">Phone</label>
                                <input type="text" name="phone" style="margin-bottom: 5px;" readonly class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" style="margin-bottom: 5px;">Months</label>
                                <input type="text" name="month" style="margin-bottom: 5px;" readonly class="form-control" id="month">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <h3><i class="fa fa-rupee-sign" style="margin-top: 15px;"></i> 500.00</h3>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success" style="margin-top: 15px;">Confirm & Pay</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Proceed to Pay</button>
            </div> -->
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".pay-now-btn").forEach(button => {
            button.addEventListener("click", function () {
                // Get values from button
                let name = this.getAttribute("data-name");
                let email = this.getAttribute("data-email");
                let phone = this.getAttribute("data-phone");
                let month = this.getAttribute("data-month");

                // Populate modal fields
                document.querySelector("input[name='firstname']").value = name;
                document.querySelector("input[name='email']").value = email;
                document.querySelector("input[name='phone']").value = phone;
                document.querySelector("input[name='month']").value = month;
            });
        });
    });
</script>

@include('layouts.a_footer')