@extends('layouts.front')

@section('content')
{{-- <!-- Spinner Start -->
<div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-grow text-primary" role="status"></div>
</div>
<!-- Spinner End --> --}}

<!-- Carousel Start -->
<div class="container-fluid p-0 wow fadeIn" data-wow-delay="0.1s">
    <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="w-100" src="/front/img/carousel-1.jpg" alt="Image">
                <div class="carousel-caption">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <h1 class="display-2 text-light mb-5 animated slideInDown">آموزشگاه زبان امین 1</h1>
                                {{-- <a href="{{ route('login') }}" class="btn btn-primary py-sm-3 px-sm-5">ورود به صفحه شخصی</a>
                                <a href="{{ route('register') }}" class="btn btn-light py-sm-3 px-sm-5 ms-3">ثبت نام اولیه</a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="carousel-item">
                <img class="w-100" src="/front/img/carousel-2.jpg" alt="Image">
                <div class="carousel-caption">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <h1 class="display-2 text-light mb-5 animated slideInDown">Safe Driving Is Our Top Priority</h1>
                                <a href="{{ route('login') }}" class="btn btn-primary py-sm-3 px-sm-5">ورود به صفحه شخصی</a>
                                <a href="{{ route('register') }}" class="btn btn-light py-sm-3 px-sm-5 ms-3">ثبت نام اولیه</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
        {{-- <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#header-carousel"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button> --}}
    </div>
</div>
<!-- Carousel End -->


<!-- Facts Start -->
<div class="container-fluid facts py-5 pt-lg-0">
    <div class="container py-5 pt-lg-0">
        <div class="row gx-0">
            <div class="col-lg-4 wow fadeIn" data-wow-delay="0.1s">
                <div class="bg-white shadow d-flex align-items-center h-100 p-4" style="min-height: 150px;">
                    <div class="d-flex">
                        <div class="flex-shrink-0 btn-lg-square bg-primary ms-2">
                            <i class="fa fa-graduation-cap text-white"></i>
                        </div>
                        <div>
                            <h5>دوره‌های آموزشی متنوع </h5>
                            <span>ارائه دوره‌های مکالمه، آمادگی برای آزمون‌های بین‌المللی و تدریس مهارت‌های زبانی با روش‌های جذاب و موثر.</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 wow fadeIn" data-wow-delay="0.3s">
                <div class="bg-white shadow d-flex align-items-center h-100 p-4" style="min-height: 150px;">
                    <div class="d-flex">
                        <div class="flex-shrink-0 btn-lg-square bg-primary ms-2">
                            <i class="fa fa-users text-white"></i>
                        </div>
                        <div>
                            <h5>اساتید مجرب و متخصص</h5>
                            <span>اساتید با تجربه و تخصص در زمینه آموزش زبان انگلیسی که به دانش‌آموزان کمک می‌کنند تا مهارت‌های زبانی خود را بهبود بخشند.</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 wow fadeIn" data-wow-delay="0.5s">
                <div class="bg-white shadow d-flex align-items-center h-100 p-4" style="min-height: 150px;">
                    <div class="d-flex">
                        <div class="flex-shrink-0 btn-lg-square bg-primary ms-2">
                            <i class="fa fa-phone text-white"></i>
                        </div>
                        <div>
                            <h5>پشتیبانی فنی 24/7</h5>
                            <span>امکان پاسخگویی به سوالات و رفع مشکلات دانش‌آموزان در طول فرآیند یادگیری به صورت 24 ساعته و در تمام روزهای هفته.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Facts End -->


<!-- About Start -->
<div class="container-xxl py-6">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="position-relative overflow-hidden ps-5 pt-5 h-100" style="min-height: 400px;">
                    <img class="position-absolute w-100 h-100" src="/front/img/4.jpg" alt="" style="object-fit: cover;">
                    <img class="position-absolute top-0 start-0 bg-white pe-3 pb-3" src="/front/img/3.jpg" alt="" style="width: 200px; height: 200px;">
                </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="h-100">
                    <h6 class="text-primary text-uppercase mb-2"درباره ما</h6>
                    <h1 class="display-6 mb-4">آموزشگاه زبان امین 1</h1>
                    <p>آموزشگاه زبان انگلیسی ما با بیش از 10 سال تجربه در زمینه آموزش زبان انگلیسی، به عنوان یکی از معتبرترین موسسات آموزشی در این حوزه شناخته می‌شود. ما با افتخار به دانش‌آموزان خود خدمات آموزشی با کیفیت و متنوع ارائه می‌دهیم. اساتید ما دارای تجربه و تخصص فراوان در زمینه آموزش زبان امین 1 هستند و به عنوان مربیان حرفه‌ای، به دانش‌آموزان کمک می‌کنند تا مهارت‌های زبانی خود را بهبود بخشند.</p>
                    <p class="mb-4">در آموزشگاه ما، دوره‌های آموزشی متنوع و جذاب به دانش‌آموزان ارائه می‌شود. از دوره‌های مکالمه تا آمادگی برای آزمون‌های بین‌المللی، تلاش ما بر این است که به نیازهای گوناگون دانش‌آموزان پاسخ دهیم. همچنین، کتاب‌های آموزشی با کیفیت بالا و منابع تدریس متنوع، به دانش‌آموزان کمک می‌کند تا بهترین نتایج را در یادگیری زبان انگلیسی به دست آورند.</p>
                    {{-- <div class="row g-2 mb-4 pb-2">
                        <div class="col-sm-6">
                            <i class="fa fa-check text-primary me-2"></i>Fully Licensed
                        </div>
                        <div class="col-sm-6">
                            <i class="fa fa-check text-primary me-2"></i>Online Tracking
                        </div>
                        <div class="col-sm-6">
                            <i class="fa fa-check text-primary me-2"></i>Afordable Fee
                        </div>
                        <div class="col-sm-6">
                            <i class="fa fa-check text-primary me-2"></i>Best Trainers
                        </div>
                    </div> --}}
                    <div class="row g-4">
                        <div class="col-sm-6">
                            <a class="btn btn-primary py-3 px-5" href="/about-us">بیشتر بخوانید</a>
                        </div>
                        <div class="col-sm-6">
                            <a class="d-inline-flex align-items-center btn btn-outline-primary border-2 p-2" href="tel:+982633368691">
                                <span class="flex-shrink-0 btn-square bg-primary">
                                    <i class="fa fa-phone-alt text-white"></i>
                                </span>
                                <span class="px-3" dir="ltr">02633368691</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- About End -->


<livewire:front.components.live-classes />


<!-- Features Start -->
<div class="container-xxl py-6" dir="rtl">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="text-primary text-uppercase mb-2">چرا ما را انتخاب کنید!</h6>
                <h1 class="display-6 mb-4">انتخاب ما را برای آموزش زبان انگلیسی دلیل دارد!</h1>
                <p class="mb-5">با تلاش برای ارائه بهترین خدمات آموزشی، ما انتخاب مناسبی برای یادگیری زبان انگلیسی هستیم.</p>
                <div class="row gy-5 gx-4">
                    <div class="col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0 btn-square bg-primary me-3">
                                <i class="fa fa-check text-white"></i>
                            </div>
                            <h5 class="mb-0">تجربه حرفه‌ای</h5>
                        </div>
                        <span>اساتید ما دارای تجربه و تخصص فراوان در زمینه آموزش زبان انگلیسی هستند.</span>
                    </div>
                    <div class="col-sm-6 wow fadeIn" data-wow-delay="0.2s">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0 btn-square bg-primary me-3">
                                <i class="fa fa-check text-white"></i>
                            </div>
                            <h5 class="mb-0">منابع آموزشی متنوع</h5>
                        </div>
                        <span>دوره‌های متنوع و کتاب‌های آموزشی با کیفیت بالا، به دانش‌آموزان ارائه می‌شود.</span>
                    </div>
                    <div class="col-sm-6 wow fadeIn" data-wow-delay="0.3s">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0 btn-square bg-primary me-3">
                                <i class="fa fa-check text-white"></i>
                            </div>
                            <h5 class="mb-0">پشتیبانی فنی</h5>
                        </div>
                        <span>پشتیبانی فنی 24/7 برای حل مشکلات و پاسخ به سوالات دانش‌آموزان در دسترس است.</span>
                    </div>
                    <div class="col-sm-6 wow fadeIn" data-wow-delay="0.4s">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0 btn-square bg-primary me-3">
                                <i class="fa fa-check text-white"></i>
                            </div>
                            <h5 class="mb-0">انعطاف پذیری در زمان بندی</h5>
                        </div>
                        <span>برنامه‌های آموزشی انعطاف پذیر و قابل تنظیم برای مطابقت با نیازهای شخصی دانش‌آموزان ارائه می‌شود.</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="position-relative overflow-hidden pe-5 pt-5 h-100" style="min-height: 400px;">
                    <img class="position-absolute w-100 h-100" src="/front/img/1.jpg" alt="" style="object-fit: cover;">
                    <img class="position-absolute top-0 end-0 bg-white ps-3 pb-3" src="/front/img/2.jpg" alt="" style="width: 200px; height: 200px">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Features End -->


<livewire:front.components.live-teachers />


<!-- Testimonial Start -->
{{-- <div class="container-xxl py-6">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
            <h6 class="text-primary text-uppercase mb-2">Testimonial</h6>
            <h1 class="display-6 mb-4">What Our Clients Say!</h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8 wow fadeInUp" data-wow-delay="0.1s">
                <div class="owl-carousel testimonial-carousel">
                    <div class="testimonial-item text-center">
                        <div class="position-relative mb-5">
                            <img class="img-fluid rounded-circle mx-auto" src="/front/img/testimonial-1.jpg" alt="">
                            <div class="position-absolute top-100 start-50 translate-middle d-flex align-items-center justify-content-center bg-white rounded-circle" style="width: 60px; height: 60px;">
                                <i class="fa fa-quote-left fa-2x text-primary"></i>
                            </div>
                        </div>
                        <p class="fs-4">Dolores sed duo clita tempor justo dolor et stet lorem kasd labore dolore lorem ipsum. At lorem lorem magna ut et, nonumy et labore et tempor diam tempor erat.</p>
                        <hr class="w-25 mx-auto">
                        <h5>Client Name</h5>
                        <span>Profession</span>
                    </div>
                    <div class="testimonial-item text-center">
                        <div class="position-relative mb-5">
                            <img class="img-fluid rounded-circle mx-auto" src="/front/img/testimonial-2.jpg" alt="">
                            <div class="position-absolute top-100 start-50 translate-middle d-flex align-items-center justify-content-center bg-white rounded-circle" style="width: 60px; height: 60px;">
                                <i class="fa fa-quote-left fa-2x text-primary"></i>
                            </div>
                        </div>
                        <p class="fs-4">Dolores sed duo clita tempor justo dolor et stet lorem kasd labore dolore lorem ipsum. At lorem lorem magna ut et, nonumy et labore et tempor diam tempor erat.</p>
                        <hr class="w-25 mx-auto">
                        <h5>Client Name</h5>
                        <span>Profession</span>
                    </div>
                    <div class="testimonial-item text-center">
                        <div class="position-relative mb-5">
                            <img class="img-fluid rounded-circle mx-auto" src="/front/img/testimonial-3.jpg" alt="">
                            <div class="position-absolute top-100 start-50 translate-middle d-flex align-items-center justify-content-center bg-white rounded-circle" style="width: 60px; height: 60px;">
                                <i class="fa fa-quote-left fa-2x text-primary"></i>
                            </div>
                        </div>
                        <p class="fs-4">Dolores sed duo clita tempor justo dolor et stet lorem kasd labore dolore lorem ipsum. At lorem lorem magna ut et, nonumy et labore et tempor diam tempor erat.</p>
                        <hr class="w-25 mx-auto">
                        <h5>Client Name</h5>
                        <span>Profession</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<!-- Testimonial End -->


@endsection
