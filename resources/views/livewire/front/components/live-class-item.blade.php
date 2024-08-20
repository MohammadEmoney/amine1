<div class="courses-item d-flex flex-column bg-white overflow-hidden h-100">
    <div class="text-center p-4 pt-0">
        <div class="d-inline-block bg-primary text-white fs-5 py-1 px-4 mb-4">{{ number_format($semester->tuition_fee ?: "-") }} تومان</div>
        <h5 class="mb-3">{{ $semester->course?->title_with_part ?: "-" }}</h5>
        {{-- <p>Tempor erat elitr rebum at clita dolor diam ipsum sit diam amet diam et eos</p> --}}
        <ul class="d-flex justify-content-around list-unstyled">
            <li class="small"><i class="fa fa-user-friends text-primary ms-2"></i>{{ \App\Enums\EnumCourseTypes::trans($semester->course?->type) }}</li>
            <li class="small"><i class="fa fa-users text-primary ms-2"></i>{{ \App\Enums\EnumCourseAges::trans($semester->course?->age) }}</li>
            <li class="small"><i class="fa fa-venus-mars text-primary ms-2"></i>{{ \App\Enums\EnumSemesterGender::trans($semester->gender) }}</li>
        </ul>
        <ul class="d-flex justify-content-around list-unstyled mb-0">
            <li class="small d-flex flex-column"><span class="fw-bolder">تاریخ ثبت نام: </span><span dir="ltr">{{ \Morilog\Jalali\Jalalian::fromDateTime($semester->register_date)->format('Y-m-d') }}</span></li>
            <li class="small d-flex flex-column"><span class="fw-bolder">تاریخ شروع ترم: </span><span dir="ltr">{{ \Morilog\Jalali\Jalalian::fromDateTime($semester->date_start)->format('Y-m-d') }}</span></li>
        </ul>
    </div>
    <div class="position-relative mt-auto">
        <img class="img-fluid" src="{{ $semester->teacher?->userInfo?->gender === "male" ? asset('front/img/male.jpg') : asset('front/img/female.jpg') }}" alt="{{ $semester->teacher?->full_name ?: "-" }}">
        {{-- <img class="img-fluid" src="{{ $semester->teacher?->getFirstMediaUrl('personal_image') ?: asset('panel/src/assets/images/profile/man.jpg') }}" alt="{{ $semester->teacher?->full_name ?: "-" }}"> --}}
        <div class="courses-overlay">
            <a class="btn btn-outline-primary border-2" href="{{ route('classes.show', ['semester' => $semester->id]) }}">بیشتر</a>
        </div>
    </div>
</div>