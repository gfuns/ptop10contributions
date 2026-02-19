@extends('admin.layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Member Savings')

<!-- Container fluid -->
<section class="container-fluid p-4">

    <div class="row">
        <!-- Page Header -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="border-bottom pb-3 mb-3 d-lg-flex align-items-center justify-content-between">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-1 h3 fw-bold text-dark">
                        Member Savings
                    </h1>
                    <!-- Breadcrumb  -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#">Member Savings</a>
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

                                <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                                    <!-- search -->

                                    <div class="d-flex align-items-center">
                                        <span class="position-absolute ps-3 search-icon">
                                            <i class="fe fe-calendar"></i>
                                        </span>
                                        <!-- input -->
                                        <input name="date" type="date" class="form-control ps-6"
                                            value="{{ $date }}" onChange="this.form.submit()">
                                    </div>

                                </div>
                            </div>
                        </form>
                        <!-- table -->
                        <div class="ps-3"><h4>Savings Records For {{ $member->last_name.", ".$member->other_names }}</h4></div>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($savings as $sav)
                                        <tr>
                                            <td class="align-middle text-dark"> {{ $loop->index + 1 }}</td>
                                            <td class="align-middle text-dark">{{ $sav->card_number }}</td>
                                            <td class="align-middle text-dark">
                                                {{ $sav->member->last_name . ', ' . $sav->member->other_names }}</td>
                                            <td class="align-middle text-dark">&#8358;{{ number_format($sav->amount, 2) }}</td>
                                            <td class="align-middle text-dark">
                                                {{ date_format($sav->created_at, 'jS M, Y g:ia') }}</td>
                                            <td class="align-middle text-dark">
                                                {{ $sav->agent->last_name . ', ' . $sav->agent->other_names }}</td>
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





<script type="text/javascript">
    document.getElementById("members").classList.add('active');
</script>

@endsection
