<nav class="navbar-vertical navbar">
    <div class="vh-100" data-simplebar>
        <!-- Brand logo -->
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
            <h3 class="fw-bold">
                <div class="row">
                    {{-- <div class="col-3"> --}}
                    {{-- <img src="{{ asset('images/logo.png') }}" alt="" style="height: 50px"> --}}
                    {{-- </div> --}}
                    <div class="col-12" style="color: white;  font-size: 16px;">
                        <span>P - Top 10 Contributions</span>
                    </div>
                </div>
            </h3>
        </a>
        <!-- Navbar nav -->
        <ul class="navbar-nav flex-column" id="sideNavbar">

            <li class="nav-item">
                <a class="nav-link " id="dashboard" href="{{ route('admin.dashboard') }}">
                    <i class="nav-icon fe fe-home me-2"></i>
                    Dashboard
                </a>
            </li>

            @if (\App\Http\Controllers\MenuController::allowAccess(Auth::user()->role_id, 1) == true)
                <li class="nav-item">
                    <div class="nav-divider"></div>
                </li>

                <li class="nav-item">
                    <a class="nav-link  collapsed " href="#" data-bs-toggle="collapse"
                        data-bs-target="#platSettings" aria-expanded="false" aria-controls="platSettings">
                        <i class="nav-icon  bi bi-tools me-2"></i> Platform Configuration
                    </a>
                    <div id="platSettings" class="collapse " data-bs-parent="#sideNavbar">
                        <ul class="nav flex-column">

                            <li class="nav-item">
                                <a class="nav-link " id="features" href="{{ route('admin.platformFeatures') }}">
                                    <span class="nav-size">Platform Features</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link " id="roles" href="{{ route('admin.userRoles') }}">
                                    <span class="nav-size">Roles and Permissions</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link " id="users" href="{{ route('admin.agentManagement') }}">
                                    <span class="nav-size">Agent Management</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif

            @if (\App\Http\Controllers\MenuController::allowAccess(Auth::user()->role_id, 2) == true)
                <li class="nav-item">
                    <div class="nav-divider"></div>
                </li>

                <li class="nav-item">
                    <a class="nav-link " id="members" href="{{ route('admin.memberManagement') }}">
                        <i class="nav-icon bi bi-people me-2"></i>
                        Registered Members
                    </a>
                </li>
            @endif


            @if (\App\Http\Controllers\MenuController::allowAccess(Auth::user()->role_id, 3) == true)
                <li class="nav-item">
                    <div class="nav-divider"></div>
                </li>

                <li class="nav-item">
                    <a class="nav-link " id="savings" href="{{ route('admin.savingsRecords') }}">
                        <i class="nav-icon bi bi-card-list me-2"></i>
                        Savings Records
                    </a>
                </li>
            @endif


            @if (\App\Http\Controllers\MenuController::allowAccess(Auth::user()->role_id, 4) == true)
                <li class="nav-item">
                    <div class="nav-divider"></div>
                </li>

                <li class="nav-item">
                    <a class="nav-link  collapsed " href="#" data-bs-toggle="collapse" data-bs-target="#navLoans"
                        aria-expanded="false" aria-controls="navLoans">
                        <i class="nav-icon bi bi-cash-coin me-2"></i> Loan Management
                    </a>
                    <div id="navLoans" class="collapse " data-bs-parent="#sideNavbar">
                        <ul class="nav flex-column">

                            @if (\App\Http\Controllers\MenuController::canCreate(Auth::user()->role_id, 4) == true)
                                <li class="nav-item">
                                    <a class="nav-link" id="new" href="{{ route('admin.newLoan') }}">
                                        <span class="nav-size"> New Loan Application</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="new" href="">
                                        <span class="nav-size"> Loan Repayment</span>
                                    </a>
                                </li>
                            @endif

                            <li class="nav-item">
                                <a class="nav-link " id="applications" href="{{ route('admin.loanApplications') }}">
                                    <span class="nav-size">Loan Applications</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link " id="disbursed" href="{{ route('admin.loanRecords') }}">
                                    <span class="nav-size">Disbursed Loans</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
            @endif

            @if (\App\Http\Controllers\MenuController::allowAccess(Auth::user()->role_id, 5) == true)
                <li class="nav-item">
                    <div class="nav-divider"></div>
                </li>

                <li class="nav-item">
                    <a class="nav-link " id="reports" href="{{ route('admin.reports') }}">
                        <i class="nav-icon bi bi-clipboard2-data me-2"></i>
                        Administrative Reports
                    </a>
                </li>
            @endif

            <li class="nav-item">
                <div class="nav-divider"></div>
            </li>

            <li class="nav-item">
                <a class="nav-link  collapsed " href="#" data-bs-toggle="collapse"
                    data-bs-target="#navSettings" aria-expanded="false" aria-controls="navSettings">
                    <i class="nav-icon bi bi-person-bounding-box me-2"></i> Account Settings
                </a>
                <div id="navSettings" class="collapse " data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">

                        <li class="nav-item">
                            <a class="nav-link" id="profile" href="{{ route('admin.viewProfile') }}">
                                <span class="nav-size"> Profile Information</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link " id="security" href="{{ route('admin.security') }}">
                                <span class="nav-size">Account Security</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <div class="nav-divider"></div>
            </li>

            <li class="nav-item">
                <a class="nav-link " href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                    <i class="nav-icon fe fe-log-out me-2"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>


        </ul>
        <!-- Card -->

    </div>
</nav>
