@extends('admin.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Member Management')

<!-- Container fluid -->
<section class="container-fluid p-4">

    <div class="row">
        <!-- Page Header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-3 mb-3 d-lg-flex align-items-center justify-content-between">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-1 h3 fw-bold text-dark">
                        Member Management
                    </h1>
                    <!-- Breadcrumb  -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#">Member Management</a>
                            </li>
                        </ol>
                    </nav>
                </div>


                @if (\App\Http\Controllers\MenuController::canCreate(Auth::user()->role_id, 2) == true)
                    <!-- button -->
                    <div>
                        <a href="#" class="btn btn-primary btn-sm me-2" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasRight">Create New Member Account</a>
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
                                <div class="col-12 mb-3 mb-lg-0">
                                    <!-- search -->

                                    <div class="d-flex align-items-center">
                                        <span class="position-absolute ps-3 search-icon">
                                            <i class="fe fe-search"></i>
                                        </span>
                                        <!-- input -->
                                        <input name="search" type="search" class="form-control ps-6"
                                            placeholder="Search Members Using Names, Email or Phone Number......"
                                            value="{{ $search }}">
                                    </div>

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
                                        <th scope="col" class="text-dark">Last Name</th>
                                        <th scope="col" class="text-dark">Other Names</th>
                                        <th scope="col" class="text-dark">Email</th>
                                        <th scope="col" class="text-dark">Phone Number</th>
                                        @if (\App\Http\Controllers\MenuController::canEdit(Auth::user()->role_id, 2) == true)
                                            <th scope="col" class="text-dark">Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $usr)
                                        <tr>
                                            <td class="align-middle text-dark"> {{ $loop->index + 1 }}</td>
                                            <td class="align-middle text-dark">{{ $usr->card_number }}</td>
                                            <td class="align-middle text-dark">{{ $usr->last_name }}</td>
                                            <td class="align-middle text-dark">{{ $usr->other_names }}</td>
                                            <td class="align-middle text-dark"> {{ $usr->email }} </td>
                                            <td class="align-middle text-dark"> {{ $usr->phone_number }} </td>
                                            @if (\App\Http\Controllers\MenuController::canEdit(Auth::user()->role_id, 2) == true)
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
                                                                    data-bs-toggle="modal" data-bs-target="#viewMember"
                                                                    data-myid="{{ $usr->id }}"
                                                                    data-cardno="{{ $usr->card_number }}"
                                                                    data-othernames="{{ $usr->other_names }}"
                                                                    data-lastname="{{ $usr->last_name }}"
                                                                    data-email="{{ $usr->email }}"
                                                                    data-phone="{{ $usr->phone_number }}"
                                                                    data-address="{{ $usr->contact_address }}"
                                                                    data-regdate="{{ date_format($usr->created_at, 'jS F, Y g:ia') }}"
                                                                    data-photograph="{{ $usr->photograph }}"><i
                                                                        class="fe fe-eye dropdown-item-icon"></i>View
                                                                    Member Information</a>

                                                                <a href="{{ route('admin.memberSavings', [$usr->id]) }}"
                                                                    class="dropdown-item"><i
                                                                        class="fe fe-eye dropdown-item-icon"></i>View
                                                                    Member Savings</a>

                                                                <a href="{{ route('admin.memberLoans', [$usr->id]) }}"
                                                                    class="dropdown-item"><i
                                                                        class="fe fe-eye dropdown-item-icon"></i>View
                                                                    Member Loans</a>

                                                                @if (\App\Http\Controllers\MenuController::canEdit(Auth::user()->role_id, 2) == true)
                                                                    <a style="cursor:pointer" class="dropdown-item"
                                                                        data-bs-toggle="offcanvas"
                                                                        data-bs-target="#editMember"
                                                                        data-myid="{{ $usr->id }}"
                                                                        data-othernames="{{ $usr->other_names }}"
                                                                        data-lastname="{{ $usr->last_name }}"
                                                                        data-email="{{ $usr->email }}"
                                                                        data-phone="{{ $usr->phone_number }}"
                                                                        data-address="{{ $usr->contact_address }}"><i
                                                                            class="fe fe-edit dropdown-item-icon"></i>Edit
                                                                        Member Information</a>
                                                                @endif
                                                            </span>

                                                        </span>

                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>

                            @if (count($users) < 1)
                                <div class="col-xl-12 col-12 job-items job-empty">
                                    <div class="text-center mt-4"><i class="bi bi-emoji-frown"
                                            style="font-size: 48px"></i>
                                        <h3 class="mt-2 text-dark">No Record Found</h3>
                                        <div class="mt-2 text-muted text-dark"> There are no member records found.
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

@if (\App\Http\Controllers\MenuController::canCreate(Auth::user()->role_id, 2) == true)
    <!-- offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" style="width: 600px;">
        <div class="offcanvas-body" data-simplebar>
            <div class="offcanvas-header px-2 pt-0">
                <h3 class="offcanvas-title" id="offcanvasExampleLabel">Create New Member Account</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                <!-- form -->
                <form class="needs-validation" novalidate method="post" action="{{ route('admin.storeMember') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- form group -->

                        <div class="mb-3 col-12">
                            <label class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="last_name" class="form-control"
                                placeholder="Enter Last Name" required>
                            <div class="invalid-feedback">Please provide last name.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Other Names <span class="text-danger">*</span></label>
                            <input type="text" name="other_names" class="form-control"
                                placeholder="Enter Other Names" required>
                            <div class="invalid-feedback">Please provide other names.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control"
                                placeholder="Enter Email Address" required>
                            <div class="invalid-feedback">Please provide a valid email.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" name="phone_number" class="form-control"
                                placeholder="Enter Phone Number" required oninput="validateInput(event)" maxlength="11">
                            <div class="invalid-feedback">Please provide a valid phone number.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Contact Address <span class="text-danger">*</span></label>
                            <textarea name="contact_address" class="form-control" placeholder="Enter Contact Address" required rows="3"
                                style="resize: none"></textarea>
                            <div class="invalid-feedback">Please provide a valid contact address.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Photograph <span class="text-danger">*</span></label>
                            <input type="file" name="photograph" class="form-control"
                                placeholder="Enter Photograph" required>
                            <div class="invalid-feedback">Please upload a valid photograph.</div>
                        </div>

                        <div class="col-md-12 border-bottom"></div>
                        <!-- button -->
                        <div class="col-12 mt-4">
                            <button class="btn btn-primary" type="submit">Create Member Account</button>
                            <button type="button" class="btn btn-outline-primary ms-2" data-bs-dismiss="offcanvas"
                                aria-label="Close">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif


@if (\App\Http\Controllers\MenuController::canEdit(Auth::user()->role_id, 2) == true)
    <div class="offcanvas offcanvas-end" tabindex="-1" id="editMember" style="width: 600px;">
        <div class="offcanvas-body" data-simplebar>
            <div class="offcanvas-header px-2 pt-0">
                <h3 class="offcanvas-title" id="offcanvasExampleLabel"> Edit Member Information</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <!-- card body -->
            <div class="container">
                <!-- form -->
                <form class="needs-validation" novalidate method="post" action="{{ route('admin.updateMember') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- form group -->
                        <div class="mb-3 col-12">
                            <label class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input id="lastname" type="text" name="last_name" class="form-control"
                                placeholder="Enter Last Name" required>
                            <div class="invalid-feedback">Please provide last name.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Other Names <span class="text-danger">*</span></label>
                            <input id="othernames" type="text" name="other_names" class="form-control"
                                placeholder="Enter Other Names" required>
                            <div class="invalid-feedback">Please provide other names.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input id="email" type="email" name="email" class="form-control"
                                placeholder="Enter Email" required>
                            <div class="invalid-feedback">Please provide a valid email.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input id="phone" type="text" name="phone_number" class="form-control"
                                placeholder="Enter Phone Number" required oninput="validateInput(event)" maxlength="11">
                            <div class="invalid-feedback">Please provide a valid phone number.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Contact Address <span class="text-danger">*</span></label>
                            <textarea id="address" name="contact_address" class="form-control" placeholder="Enter Contact Address" required
                                rows="3" style="resize: none"></textarea>
                            <div class="invalid-feedback">Please provide a valid contact address.</div>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Photograph</label>
                            <input type="file" name="photograph" class="form-control"
                                placeholder="Enter Photograph">
                            <div class="invalid-feedback">Please upload a valid photograph.</div>
                        </div>

                        <input id="myid" type="hidden" name="member_id" class="form-control" required>

                        <div class="col-md-12 border-bottom"></div>
                        <!-- button -->
                        <div class="col-12 mt-4">
                            <button class="btn btn-primary" type="submit">Save Changes</button>
                            <button type="button" class="btn btn-outline-primary ms-2" data-bs-dismiss="offcanvas"
                                aria-label="Close">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif


<div class="modal fade" id="viewMember" tabindex="-1" role="dialog" aria-labelledby="newCatgoryLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title mb-0" id="newCatgoryLabel">
                    View Member Information
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td class="">Card Number</td>
                            <td class=""><span id="vcardno"></span></td>
                            <td class="" rowspan="11" align="right" style="text-align: center"><img
                                    src="" id="vphoto" class="img-responsive" style="max-width: 100px" />
                            </td>
                        </tr>

                        <tr>
                            <td class="">Last Names</td>
                            <td class=""><span id="vlastname"></span></td>
                        </tr>

                        <tr>
                            <td class="">Other Names</td>
                            <td class=""><span id="vothernames"></span></td>
                        </tr>

                        <tr>
                            <td class="">Email</td>
                            <td class=""><span id="vemail"></span></td>
                        </tr>

                        <tr>
                            <td class="">Phone Number</td>
                            <td class=""><span id="vphone"></span></td>
                        </tr>

                        <tr>
                            <td class="">Contact Address</td>
                            <td class=""><span id="vaddress"></span></td>
                        </tr>

                        <tr>
                            <td class="">Registration Date</td>
                            <td class=""><span id="vregdate"></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    document.getElementById("members").classList.add('active');
</script>

@endsection
