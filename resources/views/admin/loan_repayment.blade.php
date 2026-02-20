@extends('admin.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Loan Repayment')

<!-- Container fluid -->
<section class="container-fluid p-4">
    <div class="row ">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="border-bottom pb-4 d-lg-flex align-items-center justify-content-between">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-0 h2 fw-bold text-dark">Loan Repayment </h1>
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#">Loan Management</a>
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
    <div class="py-6">
        <!-- row -->
        <div class="row">

            <div class="offset-xl-2 col-xl-8 col-md-12 col-12">

                <!-- card -->
                <div class="card">
                    <!-- card body -->
                    <div class="card-body p-lg-6">
                        <!-- form -->
                        <form method="post" action="{{ route('admin.loanSearch') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- form group -->
                                <div class="mb-3 col-12">
                                    <label class="form-label text-dark">Applicant's Card Number <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="card_number" value=""
                                        class="form-control @error('card_number') is-invalid @enderror"
                                        placeholder="Enter Applicant's Card Number" required
                                        onblur="fetchMemberName(this.value)">
                                    @error('card_number')
                                        <span class="" role="alert">
                                            <strong style="color: #b02a37; font-size:12px">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>


                                <div class="col-md-8"></div>
                                <!-- button -->
                                <div class="col-12">
                                    <button class="btn btn-primary w-100" type="button"
                                        onClick="this.disabled=true; this.innerHTML='Submiting request, please wait...';this.form.submit();">Proceed</button>

                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    document.getElementById("navLoans").classList.add('show');
    document.getElementById("repayment").classList.add('active');
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

    function fetchGuarantorName(cardno) {

        $.ajax({
            url: `/ajax/getGuarantorName/${cardno}`,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    // $('#guarantornamediv').show();
                    $('#guarantorname').val(response.name);
                } else {
                    // $('#guarantornamediv').hide();
                    $('#guarantorname').val('');
                    Toast.fire({
                        icon: 'error',
                        title: 'Unable to validate provided card number.'
                    });

                }
            },
            error: function(xhr) {
                // $('#guarantornamediv').hide();
                $('#guarantorname').val('');
                Toast.fire({
                    icon: 'error',
                    title: 'Unable to validate provided card number.'
                });
            }
        });
    }
</script>

@endsection
