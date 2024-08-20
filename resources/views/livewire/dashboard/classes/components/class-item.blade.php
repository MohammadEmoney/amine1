<div class="col-lg-4 employee-1">
    <div class="employee cursor-pointer">
        <div class="employee-image">
            <img src="{{ $semester->teacher?->userInfo?->gender === "male" ? asset('front/img/male.jpg') : asset('front/img/female.jpg') }}" class="img-fluid d-block m-auto" alt="employee-image">
            {{-- <img src="{{ $semester->teacher?->getFirstMediaUrl('personal_image') ?: asset('panel/src/assets/images/profile/man.jpg') }}" class="img-fluid d-block m-auto" alt="employee-image"> --}}
        </div>
        <div class="employee-details">
        <div class="employee-name" wire:click=showDetails({{ $semester->id }})>
            <h1 class="fs-6 mt-3 text-center text-white">{{ $semester->teacher?->full_name ?: "-" }}<br>
                <span class="employee-role fs-3">{{ $semester->course?->title_with_part ?: "-" }}</span>
            </h1>
        </div>
        <div class="employee-social-link">
            <ul>
                <li class="fw-bolder btn btn-ac-primary">{{ \App\Enums\EnumCourseTypes::trans($semester->course?->type) }}</li>
                <li class="fw-bolder btn btn-primary">{{ \App\Enums\EnumCourseAges::trans($semester->course?->age) }}</li>
                <li class="fw-bolder btn btn-secondary">{{ \App\Enums\EnumSemesterGender::trans($semester->gender) }}</li>
            </ul>
            <ul>
                <li class="btn btn-ac-info"><span class="fw-bolder">تاریخ ثبت نام: </span><span dir="ltr">{{ \Morilog\Jalali\Jalalian::fromDateTime($semester->register_date)->format('Y-m-d') }}</span></li>
                <li class="btn btn-ac-info"><span class="fw-bolder">تاریخ شروع ترم: </span><span dir="ltr">{{ \Morilog\Jalali\Jalalian::fromDateTime($semester->date_start)->format('Y-m-d') }}</span></li>
            </ul>
        </div>
        </div>
    </div>
</div>