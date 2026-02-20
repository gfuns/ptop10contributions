@extends('admin.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Loan Repayment')

<!-- Container fluid -->
<section class="container-fluid p-4">

    <div class="row">
        <!-- Page Header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-3 mb-3 d-lg-flex align-items-center justify-content-between">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-1 h3 fw-bold text-dark">
                        Loan Repayment
                    </h1>
                    <!-- Breadcrumb  -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#">Loan Repayment</a>
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
                        <!-- table -->
                        <div class="ps-3 pt-4">
                            <h4>Loan Records For {{ $member->last_name . ', ' . $member->other_names }}</h4>
                        </div>
                        <div class="table-responsive overflow-y-hidden mb-5" style="min-height: 200px">
                            <table id="" class="table mb-0 text-nowrap table-hover table-centered "
                                style="font-size:14px">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="text-dark">S/No</th>
                                        <th scope="col" class="text-dark">Card No.</th>
                                        <th scope="col" class="text-dark">Loan Taken</th>
                                        <th scope="col" class="text-dark">Disbursement Date</th>
                                        <th scope="col" class="text-dark">Amount Paid</th>
                                        <th scope="col" class="text-dark">Balance</th>
                                        <th scope="col" class="text-dark">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($loans as $loan)
                                        <tr>
                                            <td class="align-middle text-dark"> {{ $loop->index + 1 }}.</td>
                                            <td class="align-middle text-dark">{{ $loan->card_number }}</td>
                                            <td class="align-middle text-dark">
                                                &#8358;{{ number_format($loan->amount, 2) }}</td>
                                            <td class="align-middle text-dark">
                                                {{ date_format(new DateTime($loan->disbursement_date), 'jS M, Y g:ia') }}
                                            </td>
                                            <td class="align-middle text-dark">&#8358;{{ number_format($loan->totalPaid(), 2)}}</td>
                                            <td class="align-middle text-dark">&#8358;{{ number_format($loan->balance(), 2) }}</td>
                                            <td class="align-middle">
                                                <div class="hstack gap-4">

                                                    <span class="dropdown dropstart">
                                                        <a class="btn btn-primary bg-light-primary text-primary btn-sm"
                                                            href="#" role="button" data-bs-toggle="dropdown"
                                                            data-bs-offset="-20,20" aria-expanded="false">
                                                            Action</a>

                                                        <span class="dropdown-menu"><span
                                                                class="dropdown-header">Action</span>

                                                            <a style="cursor:pointer"
                                                                class="dropdown-item view-schedule"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#viewRepaymentDetails"
                                                                data-loan-id="{{ $loan->id }}"><i
                                                                    class="fe fe-eye dropdown-item-icon"></i>View
                                                                Repayment Schedule</a>

                                                            <a style="cursor:pointer" class="dropdown-item"
                                                                data-bs-toggle="modal" data-bs-target="#weeklyPayment"
                                                                data-myid="{{ $loan->id }}"
                                                                data-cardno="{{ $member->card_number }}"
                                                                data-name="{{ $member->last_name.", ".$member->other_names }}"
                                                                data-schedule="{{ $loan->schedule()}}"
                                                                data-week="{{ $loan->weekInfo()}}"
                                                                data-date="{{ date_format(new DateTime($loan->dateInfo()), "jS M, Y")}}"
                                                                data-amount="{{ $loan->weekly_repayment}}"><i
                                                                    class="fe fe-edit dropdown-item-icon"></i>Record
                                                                Weekly Payment</a>

                                                            <a style="cursor:pointer" class="dropdown-item"
                                                                data-bs-toggle="modal" data-bs-target="#viewLoanDetails"
                                                                data-myid="{{ $loan->id }}"><i
                                                                    class="fe fe-edit dropdown-item-icon"></i>Record
                                                                Sub-Weekly Payment</a>

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


@if (\App\Http\Controllers\MenuController::canEdit(Auth::user()->role_id, 4) == true)
    <div class="modal fade" id="weeklyPayment" tabindex="-1" role="dialog" aria-labelledby="newCatgoryLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form class="needs-validation" novalidate method="post" action="{{ route('admin.recordWeeklyPayment') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title mb-0" id="newCatgoryLabel">
                            Record Weekly Payment
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 col-12">
                            <label class="form-label">Card Number <span class="text-danger">*</span></label>
                            <input id="cardnum" type="text" name="card_number" class="form-control"
                                placeholder="Enter Card Number" readonly required>
                            <div class="invalid-feedback">Please provide card number.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Member Name <span class="text-danger">*</span></label>
                            <input id="name" type="text" name="member_name" class="form-control"
                                placeholder="Enter Member Name" required readonly>
                            <div class="invalid-feedback">Please provide member name.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Week <span class="text-danger">*</span></label>
                            <input id="week" type="text" name="week" class="form-control"
                                placeholder="Enter Week Details" required readonly>
                            <div class="invalid-feedback">Please provide week details.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Weekly Payment Amount <span class="text-danger">*</span></label>
                            <input id="amount" type="text" name="amount" class="form-control"
                                placeholder="Enter Weekly Payment Amount" oninput="validateInput(event)" required readonly>
                            <div class="invalid-feedback">Please provide amount.</div>
                        </div>

                        <input id="schedule" type="hidden" name="schedule" class="form-control" required>
                        <input id="myid" type="hidden" name="loan_id" class="form-control" required>


                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Record Payment</button>
                        <button type="button" class="btn btn-outline-success ms-2"
                            data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

<div class="modal fade" id="viewRepaymentDetails" tabindex="-1" role="dialog" aria-labelledby="newCatgoryLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title mb-0" id="newCatgoryLabel">
                    View Loan Repayment Schedule
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div id="modal-loader" class="text-center py-4">
                    <div class="spinner-border text-primary"></div>
                    <p class="mt-2">Loading items...</p>
                </div>

                <div id="itemsTableWrapper" class="d-none table-responsive overflow-y-hidden">
                    <table id="" class="table table-bordered text-nowrap table-striped"
                        style="font-size: 13px">
                        <thead>
                            <tr>
                                <th class="">Week</th>
                                <th class="">Due Date</th>
                                <th class="">Expected Repayment</th>
                                <th class="">Payment Status</th>
                            </tr>
                        </thead>
                        <tbody id="itemsTableBody"></tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-success ms-2" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
    document.getElementById("navLoans").classList.add('show');
    document.getElementById("repayment").classList.add('active');
</script>

@endsection


@section('customjs')

<script>
    $(document).on('click', '.view-schedule', function() {
        const loanId = $(this).data('loan-id');

        $('#modal-loader').removeClass('d-none');
        $('#itemsTableWrapper').addClass('d-none');
        $('#itemsTableBody').html('');

        $.ajax({
            url: `/portal/admin/loan/repayment-schedule/${loanId}`,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                let rows = '';

                response.items.forEach(item => {
                    rows += `
                    <tr>
                        <td>${item.week}</td>
                        <td>${item.due_date}</td>
                        <td>N${item.amount}</td>
                        <td>${item.status}</td>
                    </tr>
                `;
                });

                $('#itemsTableBody').html(rows);
                $('#modal-loader').addClass('d-none');
                $('#itemsTableWrapper').removeClass('d-none');
            },
            error: function() {
                $('#modal-loader').html('<p class="text-danger">Failed to load items.</p>');
            }
        });
    });
</script>

@endsection
