<!DOCTYPE html>
<html lang="en">
@include('member.layouts.header')

<body>
    <div id="db-wrapper">
        <!-- navbar vertical -->
        <!-- Sidebar -->

            @include('member.layouts.nav')

        <!-- Page Content -->
        <main id="page-content">
            <div class="header">
                @include('member.layouts.topbar')
            </div>
            <!-- Container fluid -->

            @yield('content')
        </main>
    </div>
    <!-- Scripts -->
    @include('member.layouts.footer')

    @yield('customjs')



</body>

</html>
