@extends('admin.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Loan Applications')

<!-- Container fluid -->
<section class="container-fluid p-4">

    <div class="row">
        <!-- Page Header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-3 mb-3 d-lg-flex align-items-center justify-content-between">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-1 h3 fw-bold text-dark">
                        Loan Applications
                    </h1>
                    <!-- Breadcrumb  -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#">Loan Management</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#">Loan Applications</a>
                            </li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">

            <!-- Tab -->
            <div class="tab-content">
                <!-- Tab pane -->

                <!-- tab pane -->
                <div class="tab-pane fade show active" id="tabPaneList" role="tabpanel" aria-labelledby="tabPaneList">
                    <!-- card -->
                    <div class="card mb-4">
                        <!-- Card header -->
                        <form id="form" name="form" method="GET">
                            <div class="p-4 row gx-3">
                                <!-- Form -->
                                <div class="col-12 col-lg-8 mb-3 mb-lg-0">
                                    <!-- search -->

                                    <div class="d-flex align-items-center">
                                        <span class="position-absolute ps-3 search-icon">
                                            <i class="fe fe-search"></i>
                                        </span>
                                        <!-- input -->
                                        <input name="search" type="search" class="form-control ps-6"
                                            placeholder="Search Members Loan Applications Using Card Number or Names......"
                                            value="{{ $search }}">
                                    </div>

                                </div>

                                <div class="col-12 col-lg-3 mb-3 mb-lg-0">
                                    <!-- search -->

                                    <div class="d-flex align-items-center">
                                        <span class="position-absolute ps-3 search-icon">
                                            <i class="fe fe-calendar"></i>
                                        </span>
                                        <!-- input -->
                                        <input name="date" type="date" class="form-control ps-6"
                                            value="{{ $date }}">
                                    </div>

                                </div>
                                <div class="col-12 col-lg-1 mb-3 mb-lg-0">
                                    <!-- search -->

                                    <button type="submit" class="btn btn-primary w-100"><i
                                            class="fe fe-search"></i></button>

                                </div>
                            </div>
                        </form>
                        <!-- table -->
                        <div class="table-responsive overflow-y-hidden mb-5" style="min-height: 200px">
                            <table id="" class="table mb-0 text-nowrap table-hover table-centered "
                                style="font-size:14px">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="text-dark">S/No</th>
                                        <th scope="col" class="text-dark">Card No.</th>
                                        <th scope="col" class="text-dark">Member Name</th>
                                        <th scope="col" class="text-dark">Loan Amount</th>
                                        <th scope="col" class="text-dark">Application Date</th>
                                        <th scope="col" class="text-dark">Status</th>
                                        <th scope="col" class="text-dark">Agent</th>
                                        <th scope="col" class="text-dark">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($loans as $loan)
                                        <tr>
                                            <td class="align-middle text-dark"> {{ $loop->index + 1 }}</td>
                                            <td class="align-middle text-dark">{{ $loan->card_number }}</td>
                                            <td class="align-middle text-dark">
                                                {{ $loan->member->last_name . ', ' . $loan->member->other_names }}</td>
                                            <td class="align-middle text-dark">
                                                &#8358;{{ number_format($loan->amount, 2) }}</td>
                                            <td class="align-middle text-dark">
                                                {{ date_format($loan->created_at, 'jS M, Y g:ia') }}</td>
                                            <td class="align-middle text-dark">
                                                @if ($loan->approval_status == 'approved')
                                                    <span
                                                        class="badge text-success bg-light-success">{{ ucwords($loan->approval_status) }}</span>
                                                @elseif ($loan->approval_status == 'denied')
                                                    <span
                                                        class="badge text-danger bg-light-danger">{{ ucwords($loan->approval_status) }}</span>
                                                @else
                                                    <span
                                                        class="badge text-warning bg-light-warning">{{ ucwords($loan->approval_status) }}</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-dark">
                                                {{ $loan->agent->last_name . ', ' . $loan->agent->other_names }}</td>
                                            <td class="align-middle">
                                                <div class="hstack gap-4">

                                                    <span class="dropdown dropstart">
                                                        <a class="btn btn-primary bg-light-primary text-primary btn-sm"
                                                            href="#" role="button" data-bs-toggle="dropdown"
                                                            data-bs-offset="-20,20" aria-expanded="false">
                                                            Action</a>

                                                        <span class="dropdown-menu"><span
                                                                class="dropdown-header">Action</span>

                                                            <a style="cursor:pointer" class="dropdown-item"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#viewLoanAppDetails"
                                                                data-myid="{{ $loan->id }}"
                                                                data-cardno="{{ $loan->card_number }}"
                                                                data-applicant="{{ $loan->member->last_name . ', ' . $loan->member->other_names }}"
                                                                data-photograph="{{ $loan->member->photograph }}"
                                                                data-guarantorcard="{{ $loan->guarantor->card_number }}"
                                                                data-guarantor="{{ $loan->guarantor->last_name . ', ' . $loan->guarantor->other_names }}"
                                                                data-guarantorphoto="{{ $loan->guarantor->photograph }}"
                                                                data-appdate="{{ date_format($loan->created_at, 'jS M, Y g:ia') }}"
                                                                data-amount="{{ number_format($loan->amount, 2) }}"
                                                                data-weeklypay="{{ number_format($loan->weekly_repayment, 2) }}"
                                                                data-status="{{ ucwords($loan->approval_status) }}"><i
                                                                    class="fe fe-eye dropdown-item-icon"></i>View
                                                                Details</a>

                                                            @if (\App\Http\Controllers\MenuController::canEdit(Auth::user()->role_id, 4) == true && $loan->status == "pending")
                                                                <a style="cursor:pointer" class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#editAmount"
                                                                    data-myid="{{ $loan->id }}"
                                                                    data-amount="{{ $loan->amount }}"><i
                                                                        class="fe fe-edit dropdown-item-icon"></i>Edit
                                                                    Loan Amount</a>
                                                            @endif
                                                        </span>

                                                    </span>

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>

                            @if (count($loans) < 1)
                                <div class="col-xl-12 col-12 job-items job-empty">
                                    <div class="text-center mt-4"><i class="bi bi-emoji-frown"
                                            style="font-size: 48px"></i>
                                        <h3 class="mt-2 text-dark">No Record Found</h3>
                                        <div class="mt-2 text-muted text-dark"> There are no loan records found.
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="viewLoanAppDetails" tabindex="-1" role="dialog" aria-labelledby="newCatgoryLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title mb-0" id="newCatgoryLabel">
                    View Loan Application Details
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>
            <div class="modal-body table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td class="">Applicant's Card Number</td>
                            <td class=""><span id="vcardno"></span></td>
                            <td class="" rowspan="5" align="right" style="text-align: center"><img
                                    src="" id="vphoto" class="img-responsive" style="max-width: 100px" />
                                <div>Applicant's Photo</div>
                            </td>
                        </tr>

                        <tr>
                            <td class="">Applicant's Name</td>
                            <td class=""><span id="vapplicant"></span></td>
                        </tr>

                        <tr>
                            <td class="">Loan Amount</td>
                            <td class="">&#8358;<span id="vamount"></span></td>
                        </tr>

                        <tr>
                            <td class="">Tenure</td>
                            <td class=""><span id="vtenure">60 Days</span></td>
                        </tr>

                        <tr>
                            <td class="">Weekly Repayment</td>
                            <td class="">&#8358;<span id="vweeklypay"></span></td>
                        </tr>

                        <tr>
                            <td class="">Gurantor's Card Number</td>
                            <td class=""><span id="vguarantorcard"></span></td>
                            <td class="" rowspan="4" align="right" style="text-align: center"><img
                                    src="" id="vguarantorphoto" class="img-responsive"
                                    style="max-width: 100px" />
                                <div>Guarantor's Photo</div>
                            </td>
                        </tr>

                        <tr>
                            <td class="">Gurantor's Name</td>
                            <td class=""><span id="vguarantor"></span></td>
                        </tr>

                        <tr>
                            <td class="">Application Date</td>
                            <td class=""><span id="vappdate"></span></td>
                        </tr>

                        <tr>
                            <td class="">Status</td>
                            <td class=""><span id="vstatus"></span></td>
                        </tr>
                    </tbody>

                </table>
                @if (\App\Http\Controllers\MenuController::canEdit(Auth::user()->role_id, 4) == true)
                    <div id="controlBtns" class="row col-12">
                        <div class="col-12 col-md-6 mb-3">
                            <a id="approveLoan" href="#"
                                onclick="return confirm('Are you sure you want to approve this loan application?');">
                                <button class="btn btn-success btn-md w-100">Approve Application</button></a>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <a id="rejectLoan" href="#"
                                onclick="return confirm('Are you sure you want to reject this loan application?');">
                                <button class="btn btn-danger btn-md w-100">Reject Application</button> </a>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>



@if (\App\Http\Controllers\MenuController::canEdit(Auth::user()->role_id, 4) == true)
    <div class="modal fade" id="editAmount" tabindex="-1" role="dialog" aria-labelledby="newCatgoryLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form class="needs-validation" novalidate method="post"
                    action="{{ route('admin.updateLoanAmount') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title mb-0" id="newCatgoryLabel">
                            Edit Loan Amount
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 col-12">
                            <label class="form-label">Loan Amount <span class="text-danger">*</span></label>
                            <input id="amount" type="text" name="loan_amount" class="form-control"
                                placeholder="Enter Loan Amount" oninput="validateInput(event)" required>
                            <div class="invalid-feedback">Please provide loan amount.</div>
                        </div>

                        <input id="myid" type="hidden" name="loan_id" class="form-control" required>


                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Save Changes</button>
                        <button type="button" class="btn btn-outline-success ms-2"
                            data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

<script type="text/javascript">
    document.getElementById("navLoans").classList.add('show');
    document.getElementById("applications").classList.add('active');
</script>

@endsection
