<!doctype html>
<html lang="en">

@include('layouts.partials.head')

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        @include('layouts.partials.sidebar')
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper" dir="rtl">
            @include('layouts.partials.admin-nav')
            <!--  Header Start -->
            <!--  Header End -->
            @yield('content')
            {{-- <audio id="backgroundMusic" autoplay loop>
                <source src="{{ asset('panel/src/assets/musics/0'.rand(1,4).'.mp3') }}" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio> --}}
        </div>
    </div>
@include('layouts.partials.script')
</body>

</html>
