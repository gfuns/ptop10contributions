<nav class="navbar-vertical navbar">
    <div class="vh-100" data-simplebar>
        <!-- Brand logo -->
        <a class="navbar-brand" href="{{ route('member.dashboard') }}">
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
                <a class="nav-link " id="dashboard" href="{{ route('member.dashboard') }}">
                    <i class="nav-icon fe fe-home me-2"></i>
                    Dashboard
                </a>
            </li>


            <li class="nav-item">
                <div class="nav-divider"></div>
            </li>

            <li class="nav-item">
                <a class="nav-link " id="savings" href="{{ route('member.savings') }}">
                    <i class="nav-icon bi bi-card-list me-2"></i>
                    Savings Records
                </a>
            </li>

            <li class="nav-item">
                <div class="nav-divider"></div>
            </li>

            <li class="nav-item">
                <a class="nav-link " id="loans" href="{{ route('member.loans') }}">
                    <i class="nav-icon bi bi-card-list me-2"></i>
                    Loan Records
                </a>
            </li>


            <li class="nav-item">
                <div class="nav-divider"></div>
            </li>

            <li class="nav-item">
                <a class="nav-link  collapsed " href="#" data-bs-toggle="collapse" data-bs-target="#navSettings"
                    aria-expanded="false" aria-controls="navSettings">
                    <i class="nav-icon bi bi-person-bounding-box me-2"></i> Account Settings
                </a>
                <div id="navSettings" class="collapse " data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">

                        <li class="nav-item">
                            <a class="nav-link" id="profile" href="{{ route('member.viewProfile') }}">
                                <span class="nav-size"> Profile Information</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link " id="security" href="{{ route('member.security') }}">
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
