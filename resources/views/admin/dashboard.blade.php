@extends('admin.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Administrative Dashboard')


<!-- Page Header -->
<!-- Container fluid -->
<section class="container-fluid p-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-3 mb-3 d-lg-flex justify-content-between align-items-center">
                <div class="mb-3 mb-lg-0">
                    <h1 class="mb-0 h3 fw-bold text-dark">Welcome Back
                        {{ Auth::user()->last_name . ', ' . Auth::user()->other_names }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="col-lg-12 col-12 ">
            <!-- Card -->
            <div class="card mb-4">
                <!-- Card header -->
                <div
                    class="card-header align-items-center card-header-height d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">What Operation would you like to perform?</h4>
                    </div>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <div class="row col-lg-12 col-12">
                        <div class="col-lg-4 col-md-12 col-12">
                            <!-- Card -->
                            <a href="{{ route('admin.memberManagement') }}">
                                <div class="card mb-4" style="background: #243A6E">
                                    <!-- Card body -->
                                    <div class="p-3">
                                        <h4 class="fs-6 text-uppercase fw-bold ls-md text-white text-center">Register A
                                            New Member</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-4 col-md-12 col-12">
                            <!-- Card -->
                            <a href="{{ route('admin.savingsRecords') }}">
                                <div class="card mb-4" style="background: #243A6E">
                                    <!-- Card body -->
                                    <div class="p-3">
                                        <h4 class="fs-6 text-uppercase fw-bold ls-md text-white text-center">Record
                                            Member Savings</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-4 col-md-12 col-12">
                            <!-- Card -->
                            <a href="{{ route('admin.newLoan') }}">
                                <div class="card mb-4" style="background: #243A6E">
                                    <!-- Card body -->
                                    <div class="p-3">
                                        <h4 class="fs-6 text-uppercase fw-bold ls-md text-white text-center">New Loan
                                            Application</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-4 col-md-12 col-12">
                            <!-- Card -->
                            <a href="">
                                <div class="card mb-4" style="background: #243A6E">
                                    <!-- Card body -->
                                    <div class="p-3">
                                        <h4 class="fs-6 text-uppercase fw-bold ls-md text-white text-center">Record Loan
                                            Remmittance</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        @if (Auth::user()->userRole->role_type == 'administrator')
                            <div class="col-lg-4 col-md-12 col-12">
                                <!-- Card -->
                                <a href="{{ route('admin.loanApplications') }}">
                                    <div class="card mb-4" style="background: #243A6E">
                                        <!-- Card body -->
                                        <div class="p-3">
                                            <h4 class="fs-6 text-uppercase fw-bold ls-md text-white text-center">View
                                                Loan Applications</h4>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-4 col-md-12 col-12">
                                <!-- Card -->
                                <a href="{{ route('admin.loanRecords') }}">
                                    <div class="card mb-4" style="background: #243A6E">
                                        <!-- Card body -->
                                        <div class="p-3">
                                            <h4 class="fs-6 text-uppercase fw-bold ls-md text-white text-center">Manage
                                                Disbursed Loans</h4>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @else
                            <div class="col-lg-4 col-md-12 col-12">
                                <!-- Card -->
                                <a href="{{ route('admin.viewProfile') }}">
                                    <div class="card mb-4" style="background: #243A6E">
                                        <!-- Card body -->
                                        <div class="p-3">
                                            <h4 class="fs-6 text-uppercase fw-bold ls-md text-white text-center">Manage
                                                Profile Information</h4>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-4 col-md-12 col-12">
                                <!-- Card -->
                                <a href="{{ route('admin.security') }}">
                                    <div class="card mb-4" style="background: #243A6E">
                                        <!-- Card body -->
                                        <div class="p-3">
                                            <h4 class="fs-6 text-uppercase fw-bold ls-md text-white text-center">Manage
                                                Account Security</h4>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<script>
    document.getElementById("dashboard").classList.add('active');
</script>


@endsection
