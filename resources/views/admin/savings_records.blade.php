@extends('admin.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Saving Records')

<!-- Container fluid -->
<section class="container-fluid p-4">

    <div class="row">
        <!-- Page Header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-3 mb-3 d-lg-flex align-items-center justify-content-between">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-1 h3 fw-bold text-dark">
                        Saving Records
                    </h1>
                    <!-- Breadcrumb  -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#">Saving Records</a>
                            </li>
                        </ol>
                    </nav>
                </div>


                @if (\App\Http\Controllers\MenuController::canCreate(Auth::user()->role_id, 3) == true)
                    <!-- button -->
                    <div>
                        <a href="#" class="btn btn-primary btn-sm me-2" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasRight">Record Member Savings</a>
                    </div>
                @endif

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
                                            placeholder="Search Members Savings Using Card Number or Names......"
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
                                        <th scope="col" class="text-dark">Amount Saved</th>
                                        <th scope="col" class="text-dark">Date</th>
                                        <th scope="col" class="text-dark">Agent</th>
                                        @if (\App\Http\Controllers\MenuController::canEdit(Auth::user()->role_id, 3) == true)
                                            <th scope="col" class="text-dark">Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($savings as $sav)
                                        <tr>
                                            <td class="align-middle text-dark"> {{ $loop->index + 1 }}</td>
                                            <td class="align-middle text-dark">{{ $sav->card_number }}</td>
                                            <td class="align-middle text-dark">
                                                {{ $sav->member->last_name . ', ' . $sav->member->other_names }}</td>
                                            <td class="align-middle text-dark">
                                                &#8358;{{ number_format($sav->amount, 2) }}</td>
                                            <td class="align-middle text-dark">
                                                {{ date_format($sav->created_at, 'jS M, Y g:ia') }}</td>
                                            <td class="align-middle text-dark">
                                                {{ $sav->agent->last_name . ', ' . $sav->agent->other_names }}</td>
                                            @if (\App\Http\Controllers\MenuController::canEdit(Auth::user()->role_id, 3) == true)
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
                                                                    data-bs-toggle="modal" data-bs-target="#editAmount"
                                                                    data-myid="{{ $sav->id }}"
                                                                    data-amount="{{ $sav->amount }}"><i
                                                                        class="fe fe-edit dropdown-item-icon"></i>Edit
                                                                    Savings Amount</a>
                                                            </span>

                                                        </span>

                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>

                            @if (count($savings) < 1)
                                <div class="col-xl-12 col-12 job-items job-empty">
                                    <div class="text-center mt-4"><i class="bi bi-emoji-frown"
                                            style="font-size: 48px"></i>
                                        <h3 class="mt-2 text-dark">No Record Found</h3>
                                        <div class="mt-2 text-muted text-dark"> There are no savings records found.
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

@if (\App\Http\Controllers\MenuController::canCreate(Auth::user()->role_id, 3) == true)
    <!-- offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" style="width: 600px;">
        <div class="offcanvas-body" data-simplebar>
            <div class="offcanvas-header px-2 pt-0">
                <h3 class="offcanvas-title" id="offcanvasExampleLabel">Record Member Savings</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                <!-- form -->
                <form class="needs-validation" novalidate method="post"
                    action="{{ route('admin.storeMemberSavings') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- form group -->

                        <div class="mb-3 col-12">
                            <label class="form-label">Card Number <span class="text-danger">*</span></label>
                            <input type="text" name="card_number" class="form-control"
                                placeholder="Enter Card Number" required onblur="fetchMemberName(this.value)">
                            <div class="invalid-feedback">Please provide card number.</div>
                        </div>

                        <div id="membernamediv" class="mb-3 col-12">
                            <label class="form-label">Member Name <span class="text-danger">*</span></label>
                            <input id="membername" type="text" name="member_name" class="form-control"
                                placeholder="Enter Other Names" readonly required>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Amount Saved <span class="text-danger">*</span></label>
                            <input type="text" name="amount_saved" class="form-control"
                                placeholder="Enter Amount Saved" required oninput="validateInput(event)">
                            <div class="invalid-feedback">Please provide a valid amount.</div>
                        </div>

                        <div class="col-md-12 border-bottom"></div>
                        <!-- button -->
                        <div class="col-12 mt-4">
                            <button class="btn btn-primary" type="submit">Record Member Savings</button>
                            <button type="button" class="btn btn-outline-primary ms-2" data-bs-dismiss="offcanvas"
                                aria-label="Close">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

@if (\App\Http\Controllers\MenuController::canEdit(Auth::user()->role_id, 3) == true)
    <div class="modal fade" id="editAmount" tabindex="-1" role="dialog" aria-labelledby="newCatgoryLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form class="needs-validation" novalidate method="post" action="{{ route('admin.updateSavingsAmount') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title mb-0" id="newCatgoryLabel">
                            Edit Savings Amount
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 col-12">
                            <label class="form-label">Savings Amount <span class="text-danger">*</span></label>
                            <input id="amount" type="text" name="savings_amount" class="form-control"
                                placeholder="Enter Savings Amount" oninput="validateInput(event)" required>
                            <div class="invalid-feedback">Please provide savings amount.</div>
                        </div>

                        <input id="myid" type="hidden" name="savings_id" class="form-control" required>


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
    document.getElementById("savings").classList.add('active');
</script>

@endsection


@section('customjs')
<script type="text/javascript">
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true
    });

    function fetchMemberName(cardno) {

        $.ajax({
            url: `/ajax/getMemberName/${cardno}`,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    // $('#membernamediv').show();
                    $('#membername').val(response.name);
                } else {
                    // $('#membernamediv').hide();
                    $('#membername').val('');
                    Toast.fire({
                        icon: 'error',
                        title: 'Unable to validate provided card number.'
                    });

                }
            },
            error: function(xhr) {
                // $('#membernamediv').hide();
                $('#membername').val('');
                Toast.fire({
                    icon: 'error',
                    title: 'Unable to validate provided card number.'
                });
            }
        });
    }
</script>
@endsection
