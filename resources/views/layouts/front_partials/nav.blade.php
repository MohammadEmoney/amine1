<!-- Topbar Start -->
<div class="container-fluid bg-dark text-light p-0" dir="ltr">
    <div class="row gx-0 d-none d-lg-flex">
        <div class="col-lg-7 px-5 text-start">
            <div class="h-100 d-inline-flex align-items-center me-4">
                <small class="fa fa-map-marker-alt text-primary me-2"></small>
                <small>بلوار ولی عصر مهرشهر، نبش تقاطع چهارم</small>
            </div>
            <div class="h-100 d-inline-flex align-items-center">
                <small class="far fa-clock text-primary me-2"></small>
                <small>شنبه - پنجشنبه : 21.00 - 09.00</small>
            </div>
        </div>
        <div class="col-lg-5 px-5 text-end">
            <div class="h-100 d-inline-flex align-items-center me-4">
                <small class="fa fa-phone-alt text-primary me-2"></small>
                <small><a href="tel:+982633368691">02633368691</a></small>
            </div>
            {{-- <div class="h-100 d-inline-flex align-items-center mx-n2">
                <a class="btn btn-square btn-link rounded-0 border-0 border-end border-secondary" href=""><i class="fab fa-facebook-f"></i></a>
                <a class="btn btn-square btn-link rounded-0 border-0 border-end border-secondary" href=""><i class="fab fa-twitter"></i></a>
                <a class="btn btn-square btn-link rounded-0 border-0 border-end border-secondary" href=""><i class="fab fa-linkedin-in"></i></a>
                <a class="btn btn-square btn-link rounded-0" href=""><i class="fab fa-instagram"></i></a>
            </div> --}}
        </div>
    </div>
</div>
<!-- Topbar End -->


<!-- Navbar Start -->
<nav dir="ltr" class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0 justify-content-between">
    <a href="{{ route('home') }}" class="navbar-brand d-flex align-items-center border-end px-4 px-lg-5">
        <h2 class="m-0"><i class="fa fa-graduation-cap text-primary me-2"></i>آموزشگاه امین 1</h2>
    </a>

    @guest
        <div class="d-flex justify-content-center">
            <a href="{{ route('register') }}" class="bg-white border-dark btn btn-light px-sm-5 py-sm-3 text-primary" style="padding-left: 4rem !important;
            padding-right: 4rem !important;">ثبت نام اولیه</a>
            <a href="{{ route('login') }}" class="border-dark btn btn-primary px-sm-5 py-sm-3">ورود به صفحه شخصی</a>
        </div>
    @endguest

    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse flex-grow-0" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0" dir="rtl">
            <a href="{{ route('home') }}" class="nav-item nav-link active">خانه</a>
            <a href="#" class="nav-item nav-link">کلاس ها</a>
            <a href="#" class="nav-item nav-link">درباره</a>
            {{-- <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                <div class="dropdown-menu bg-light m-0">
                    <a href="feature.html" class="dropdown-item">Features</a>
                    <a href="appointment.html" class="dropdown-item">Appointment</a>
                    <a href="team.html" class="dropdown-item">Our Team</a>
                    <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                    <a href="404.html" class="dropdown-item">404 Page</a>
                </div>
            </div> --}}
            <a href="#" class="nav-item nav-link">تماس با ما</a>
            @auth
                @if(Auth::user()->hasAnyRole(['student', 'teacher']))
                    <a href="{{ route('profile.edit') }}" class="btn btn-info nav-item nav-link px-3 text-white">داشبورد</a>
                @endif
                @if(Auth::user()->hasAnyRole(['admin', 'super-admin']))
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-info nav-item nav-link px-3 text-white">داشبورد</a>
                @endif

            @endauth
        </div>
        {{-- <a href="" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Get Started<i class="fa fa-arrow-right ms-3"></i></a> --}}
    </div>
</nav>
<!-- Navbar End -->