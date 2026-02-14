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
                    <h1 class="mb-0 h3 fw-bold text-dark">Welcome Back {{ Auth::user()->last_name.", ".Auth::user()->other_names }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col-lg-3 col-md-12 col-12">
                <!-- Card -->
                <div class="card mb-4 bg-light-success">
                    <!-- Card body -->
                    <a href="#">
                        <div class="card-body text-center">
                            <h4 class="fw-bold mb-1 text-dark">{{ number_format(0, 0) }}</h4>
                            <div class="mb-2 lh-1">
                                <h4 class="fs-6 text-uppercase fw-bold ls-md text-dark">Customers</h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-12 col-12">
                <!-- Card -->
                <div class="card mb-4 bg-light-danger">
                    <!-- Card body -->
                    <a href="#">
                        <div class="card-body text-center">
                            <h4 class="fw-bold mb-1 text-dark">{{ number_format(0, 0) }}</h4>
                            <div class="mb-2 lh-1">
                                <h4 class="fs-6 text-uppercase fw-bold ls-md text-dark">Manufacturers</h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-12 col-12">
                <!-- Card -->
                <div class="card mb-4">
                    <!-- Card body -->
                    <a href="#">
                        <div class="card-body text-center">
                            <h4 class="fw-bold mb-1 text-dark">{{ number_format(0, 0) }}</h4>
                            <div class="mb-2 lh-1">
                                <h4 class="fs-6 text-uppercase fw-bold ls-md text-dark">Suppliers</h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>


            <div class="col-lg-3 col-md-12 col-12">
                <!-- Card -->
                <div class="card mb-4">
                    <!-- Card body -->
                    <a href="#">
                        <div class="card-body text-center">
                            <h4 class="fw-bold mb-1 text-dark">{{ number_format(0, 0) }}</h4>
                            <div class="mb-2 lh-1">
                                <h4 class="fs-6 text-uppercase fw-bold ls-md text-dark">Below Threshold</h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-12 col-12">
                <!-- Card -->
                <div class="card mb-4">
                    <!-- Card body -->
                    <a href="#" class="">
                        <div class="card-body text-center">
                            <h4 class="fw-bold mb-1 text-dark">{{ number_format(0, 0) }}</h4>
                            <div class="mb-2 lh-1">
                                <h4 class="fs-6 text-uppercase fw-bold ls-md text-dark">Out Of Stock</h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

               <div class="col-lg-3 col-md-12 col-12">
                <!-- Card -->
                <div class="card mb-4">
                    <!-- Card body -->
                    <a href="#">
                        <div class="card-body text-center">
                            <h4 class="fw-bold mb-1 text-dark">{{ number_format(0, 0) }}</h4>
                            <div class="mb-2 lh-1">
                                <h4 class="fs-6 text-uppercase fw-bold ls-md text-dark">Expired Products</h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-12 col-12">
                <!-- Card -->
                <div class="card mb-4">
                    <!-- Card body -->
                    <a href="#">
                        <div class="card-body text-center">
                            <h4 class="fw-bold mb-1 text-dark">{{ number_format(0, 0) }}</h4>
                            <div class="mb-2 lh-1">
                                <h4 class="fs-6 text-uppercase fw-bold ls-md text-dark">Pending Inbound Transfers</h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-12 col-12">
                <!-- Card -->
                <div class="card mb-4">
                    <!-- Card body -->
                    <a href="#">
                        <div class="card-body text-center">
                            <h4 class="fw-bold mb-1 text-dark">&#8358;{{ number_format(0, 2) }}</h4>
                            <div class="mb-2 lh-1">
                                <h4 class="fs-6 text-uppercase fw-bold ls-md text-dark">Value Of Available Stock</h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 col-md-12 col-12">
                <!-- Card -->
                <div class="card mb-4">
                    <!-- Card body -->
                    <div class="card-header p-0">
                        <div class="text-dark fw-bold p-2 ps-4">
                            MONTHLY PROGRESS REPORT
                        </div>
                    </div>
                    <div id="" class="card-body">
                        <!-- Earning chart -->
                        <div id="chart" class="apex-charts d-flex justify-content-center"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-12">
                <!-- Card -->
                <div class="card mb-4">
                    <!-- Card body -->
                    <div class="card-header p-0">
                        <div class="text-dark fw-bold p-2">
                            TODAY'S REPORT
                        </div>
                    </div>
                    <div class="p-2">
                        <table class="table table-bordered text-dark">
                            <tr>
                                <td class="fw-bold">STATISTIC</td>
                                <td class="fw-bold text-end">AMOUNT</td>
                            </tr>

                        </table>
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
