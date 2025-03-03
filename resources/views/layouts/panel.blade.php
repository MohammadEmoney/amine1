<!doctype html>
<html lang="en">

@include('layouts.partials.head')

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        {{-- @include('layouts.partials.sidebar') --}}
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="container">
            @include('layouts.partials.navbar')
            <!--  Header Start -->
            <!--  Header End -->
            @yield('content')
            @include('layouts.partials.footer')
        </div>
    </div>
@include('layouts.partials.script')
</body>

</html>
