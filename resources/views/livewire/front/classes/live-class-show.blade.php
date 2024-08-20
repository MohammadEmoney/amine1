<div>
    @include('front.components.header', [
        'background' => asset('front/img/carousel-1.jpg'),
        'title' => $title,
        'subTitle' => '',
        'items' => [['title' => $title]]
    ])

    <!-- Class Show Start -->
    <div class="container-xxl py-6">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="position-relative overflow-hidden ps-5 pt-5 h-100" style="min-height: 400px;">
                        <img class="position-absolute w-100 h-100" src="{{ $semester->teacher?->getFirstMediaUrl('personal_image') ?: asset('panel/src/assets/images/profile/man.jpg') }}" alt="" style="object-fit: cover;">
                        {{-- <img class="position-absolute top-0 start-0 bg-white pe-3 pb-3" src="img/about-2.jpg" alt="" style="width: 200px; height: 200px;"> --}}
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="h-100">
                        <h6 class="text-primary text-uppercase mb-2">جزئیات دوره {{ $semester->course?->title_with_part }}</h6>
                        <form >
                            <div class="row justify-content-center mb-3">
                                <div class="col-6 text-center bg-body-tertiary">
                                    <p class="my-2 text-center text-info">نام دوره و یا کلاس مورد نظر</p>
                                </div>
                                <div class="col-6 bg-body-tertiary">
                                    <p class="my-2 text-center text-black">{{ $semester->course?->title_with_part }}</p>
                                </div>
                                <div class="col-6 text-center">
                                    <p class="my-2 text-center text-info">نام مدرس</p>
                                </div>
                                <div class="col-6 text-center text-black d-grid gap-2 px-0">
                                    {{ $semester->teacher?->full_name ?: "-" }}
                                </div>
                                <div class="col-6 text-center bg-body-tertiary">
                                    <p class="my-2 text-center text-info">نوع دوره</p>
                                </div>
                                <div class="col-6 text-center text-black d-grid gap-2 px-0 bg-body-tertiary">
                                    {{ \App\Enums\EnumCourseTypes::trans($semester->course?->type) }}
                                </div>
                                <div class="col-6 text-center">
                                    <p class="my-2 text-center text-info">رده سنی</p>
                                </div>
                                <div class="col-6 text-center text-black d-grid gap-2 px-0">
                                    {{ \App\Enums\EnumCourseAges::trans($semester->course?->age) }}
                                </div>
                                <div class="col-6 text-center bg-body-tertiary">
                                    <p class="my-2 text-center text-info">شروع ثبت نام</p>
                                </div>
                                <div class="col-6 text-center text-black d-grid gap-2 px-0 bg-body-tertiary">
                                    {{ $semester->register_date ? \Morilog\Jalali\Jalalian::fromDateTime($semester->register_date)->format('%d %B، %Y') : "-" }}
                                </div>
                                <div class="col-6 text-center">
                                    <p class="my-2 text-center text-info">شروع ترم</p>
                                </div>
                                <div class="col-6 text-center text-black d-grid gap-2 px-0">
                                    {{ \Morilog\Jalali\Jalalian::fromDateTime($semester->date_start)->format('%d %B، %Y') }}
                                </div>
                                <div class="col-6 text-center bg-body-tertiary">
                                    <p class="my-2 text-center text-info">پایان ترم</p>
                                </div>
                                <div class="col-6 text-center text-black d-grid gap-2 px-0 bg-body-tertiary">
                                    {{ \Morilog\Jalali\Jalalian::fromDateTime($semester->date_end)->format('%d %B، %Y') }}
                                </div>
                                <div class="col-6 text-center">
                                    <p class="my-2 text-center text-info">ساعت کلاس</p>
                                </div>
                                <div class="col-6 text-center text-black d-grid gap-2 px-0">
                                    {{ $semester->time_start->format("H:i") }} الی {{ $semester->time_end->format("H:i") }}
                                </div>
                                <div class="col-6 text-center bg-body-tertiary">
                                    <p class="my-2 text-center text-info">شماره کلاس</p>
                                </div>
                                <div class="col-6 text-center text-black d-grid gap-2 px-0 bg-body-tertiary">
                                    {{ $semester->class_number }}
                                </div>
                                <div class="col-6 text-center">
                                    <p class="my-2 text-center text-info">روزهای برگزاری کلاس</p>
                                </div>
                                <div class="col-6 text-center text-black d-grid gap-2 px-0 cursor-pointer link-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    {{ $semester->days }} {{ $semester->day_type ? "($semester->day_type)" : ""}}
                                </div>
                                <div class="col-6 text-center bg-body-tertiary">
                                    <p class="my-2 text-center text-info">جنسیت</p>
                                </div>
                                <div class="col-6 text-center text-black d-grid gap-2 px-0 bg-body-tertiary">
                                    {{ \App\Enums\EnumSemesterGender::trans($semester->gender) }}
                                </div>
                                <div class="col-6 text-center">
                                    <p class="my-2 text-center text-info">شهریه</p>
                                </div>
                                <div class="col-6 text-center text-black d-grid gap-2 px-0">
                                    {{ number_format($semester->tuition_fee ?: "-") }} تومان
                                </div>
                            </div>
    
                            <div class="row justify-content-center">
                                <div class="col-md-6 d-grid">
                                    <button class="btn btn-primary" type="button" wire:click="addToCart()">افزودن به سبد و پرداخت <i class="ti ti-shopping-cart-plus"></i></button>
                                </div>
                            </div>
                        </form>
                        
                        {{-- <h1 class="display-6 mb-4">We Help Students To Pass Test & Get A License On The First Try</h1> --}}
                        {{-- <p>Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit. Aliqu diam amet diam et eos. Clita erat ipsum et lorem et sit, sed stet lorem sit clita duo justo magna dolore erat amet</p>
                        <p class="mb-4">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit. Aliqu diam amet diam et eos. Clita erat ipsum et lorem et sit, sed stet lorem sit clita duo justo magna dolore erat amet</p>
                        <div class="row g-2 mb-4 pb-2">
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
                        </div>
                        <div class="row g-4">
                            <div class="col-sm-6">
                                <a class="btn btn-primary py-3 px-5" href="">Read More</a>
                            </div>
                            <div class="col-sm-6">
                                <a class="d-inline-flex align-items-center btn btn-outline-primary border-2 p-2" href="tel:+0123456789">
                                    <span class="flex-shrink-0 btn-square bg-primary">
                                        <i class="fa fa-phone-alt text-white"></i>
                                    </span>
                                    <span class="px-3">+012 345 6789</span>
                                </a>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Class Show End -->
</div>
