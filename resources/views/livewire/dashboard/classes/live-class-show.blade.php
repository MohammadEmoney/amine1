<div dir="rtl">
    <div class="row justify-content-center">
        <div class="col-md-10 col-12">
            <div class="card">
                <div class="card-body">
                    <form >
                        <div class="row justify-content-center mb-3">
                            <div class="col-12 border bg-ac-secondary text-white" wire:click="sub">
                                <p class="p-2 text-center fs-5">جزئیات دوره {{ $semester->course?->title_with_part }}</p>
                            </div>
                            <div class="col-6 border text-center bg-body-tertiary">
                                <p class="my-2 text-center text-info">نام دوره و یا کلاس مورد نظر</p>
                            </div>
                            <div class="col-6 border bg-body-tertiary">
                                <p class="my-2 text-center text-black">{{ $semester->course?->title_with_part }}</p>
                            </div>
                            <div class="col-6 border text-center">
                                <p class="my-2 text-center text-info">نام مدرس</p>
                            </div>
                            <div class="col-6 border text-center text-black d-grid gap-2 px-0">
                                {{ $semester->teacher?->full_name ?: "-" }}
                            </div>
                            <div class="col-6 border text-center bg-body-tertiary">
                                <p class="my-2 text-center text-info">نوع دوره</p>
                            </div>
                            <div class="col-6 border text-center text-black d-grid gap-2 px-0 bg-body-tertiary">
                                {{ \App\Enums\EnumCourseTypes::trans($semester->course?->type) }}
                            </div>
                            <div class="col-6 border text-center">
                                <p class="my-2 text-center text-info">رده سنی</p>
                            </div>
                            <div class="col-6 border text-center text-black d-grid gap-2 px-0">
                                {{ \App\Enums\EnumCourseAges::trans($semester->course?->age) }}
                            </div>
                            <div class="col-6 border text-center bg-body-tertiary">
                                <p class="my-2 text-center text-info">شروع ثبت نام</p>
                            </div>
                            <div class="col-6 border text-center text-black d-grid gap-2 px-0 bg-body-tertiary">
                                {{ $semester->register_date ? \Morilog\Jalali\Jalalian::fromDateTime($semester->register_date)->format('%d %B، %Y') : "-" }}
                            </div>
                            <div class="col-6 border text-center">
                                <p class="my-2 text-center text-info">شروع ترم</p>
                            </div>
                            <div class="col-6 border text-center text-black d-grid gap-2 px-0">
                                {{ \Morilog\Jalali\Jalalian::fromDateTime($semester->date_start)->format('%d %B، %Y') }}
                            </div>
                            <div class="col-6 border text-center bg-body-tertiary">
                                <p class="my-2 text-center text-info">پایان ترم</p>
                            </div>
                            <div class="col-6 border text-center text-black d-grid gap-2 px-0 bg-body-tertiary">
                                {{ \Morilog\Jalali\Jalalian::fromDateTime($semester->date_end)->format('%d %B، %Y') }}
                            </div>
                            <div class="col-6 border text-center">
                                <p class="my-2 text-center text-info">ساعت کلاس</p>
                            </div>
                            <div class="col-6 border text-center text-black d-grid gap-2 px-0">
                                {{ $semester->time_start->format("H:i") }} الی {{ $semester->time_end->format("H:i") }}
                            </div>
                            <div class="col-6 border text-center bg-body-tertiary">
                                <p class="my-2 text-center text-info">شماره کلاس</p>
                            </div>
                            <div class="col-6 border text-center text-black d-grid gap-2 px-0 bg-body-tertiary">
                                {{ $semester->class_number }}
                            </div>
                            <div class="col-6 border text-center">
                                <p class="my-2 text-center text-info">روزهای برگزاری کلاس</p>
                            </div>
                            <div class="col-6 border text-center text-black d-grid gap-2 px-0 cursor-pointer link-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                {{ $semester->days }} {{ $semester->day_type ? "($semester->day_type)" : ""}}
                            </div>
                            <div class="col-6 border text-center bg-body-tertiary">
                                <p class="my-2 text-center text-info">جنسیت</p>
                            </div>
                            <div class="col-6 border text-center text-black d-grid gap-2 px-0 bg-body-tertiary">
                                {{ \App\Enums\EnumSemesterGender::trans($semester->gender) }}
                            </div>
                            <div class="col-6 border text-center">
                                <p class="my-2 text-center text-info">شهریه</p>
                            </div>
                            <div class="col-6 border text-center text-black d-grid gap-2 px-0">
                                {{ number_format($semester->tuition_fee ?: "-") }} تومان
                            </div>
                        </div>

                        @if (Auth::user()->userInfo?->type === 'student')
                            <div class="row justify-content-center">
                                <div class="col-md-6 d-grid">
                                    <button class="btn btn-ac-primary" type="button" wire:click="addToCart()">افزودن به سبد و پرداخت <i class="ti ti-shopping-cart-plus"></i></button>
                                </div>
                            </div>
                        @else
                            <div class="row justify-content-center">
                                <div class="col-md-6 d-grid">
                                    <button class="btn btn-ac-primary" type="button" wire:click="manageStudents()">مدیریت دانش آموزان <i class="ti ti-shopping-cart-plus"></i></button>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">برنامه هفتگی</h5>
            {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ \Morilog\Jalali\Jalalian::fromDateTime(now())->format('%d %B') }}</th>
                                    @foreach (range(1, 6) as $i)
                                        <th scope="col">{{ \Morilog\Jalali\Jalalian::fromDateTime(now())->addDays($i)->format('%d %B') }}</th>
                                    @endforeach
                                    {{-- <th scope="col">یکشنبه</th>
                                    <th scope="col">دوشنبه</th>
                                    <th scope="col">سه شنبه</th>
                                    <th scope="col">چهارشنبه</th>
                                    <th scope="col">پنج شنبه</th>
                                    <th scope="col">جمعه</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th class="{{ $semester->hasClassToday('saturday') ? "bg-ac-info text-white" : "" }}">شنبه</th>
                                    @foreach (range(1, 7) as $i)
                                        @if ($semester->hasClassToday('saturday'))
                                            <td class="text-nowrap bg-ac-info text-white"> 
                                                    {{ $semester->time_start->format("H:i") }} - {{ $semester->time_end->format("H:i") }}
                                            </td>
                                        @else
                                            <td>-</td>
                                        @endif
                                    @endforeach
                                </tr>
                                <tr>
                                    <th class="{{ $semester->hasClassToday('sunday') ? "bg-ac-info text-white" : "" }}">یکشنبه</th>
                                    @foreach (range(1, 7) as $i)
                                        @if ($semester->hasClassToday('sunday'))
                                            <td class="text-nowrap bg-ac-info text-white"> 
                                                    {{ $semester->time_start->format("H:i") }} - {{ $semester->time_end->format("H:i") }}
                                            </td>
                                        @else
                                            <td>-</td>
                                        @endif
                                    @endforeach
                                </tr>
                                <tr>
                                    <th class="{{ $semester->hasClassToday('monday') ? "bg-ac-info text-white" : "" }}">دوشنبه</th>
                                    @foreach (range(1, 7) as $i)
                                        @if ($semester->hasClassToday('monday'))
                                            <td class="text-nowrap bg-ac-info text-white"> 
                                                    {{ $semester->time_start->format("H:i") }} - {{ $semester->time_end->format("H:i") }}
                                            </td>
                                        @else
                                            <td>-</td>
                                        @endif
                                    @endforeach
                                </tr>
                                <tr>
                                    <th class="{{ $semester->hasClassToday('tuesday') ? "bg-ac-info text-white" : "" }}">سه شنبه</th>
                                    @foreach (range(1, 7) as $i)
                                        @if ($semester->hasClassToday('tuesday'))
                                            <td class="text-nowrap bg-ac-info text-white"> 
                                                    {{ $semester->time_start->format("H:i") }} - {{ $semester->time_end->format("H:i") }}
                                            </td>
                                        @else
                                            <td>-</td>
                                        @endif
                                    @endforeach
                                </tr>
                                <tr>
                                    <th class="{{ $semester->hasClassToday('wednesday') ? "bg-ac-info text-white" : "" }}">چهارشنبه</th>
                                    @foreach (range(1, 7) as $i)
                                        @if ($semester->hasClassToday('wednesday'))
                                            <td class="text-nowrap bg-ac-info text-white"> 
                                                    {{ $semester->time_start->format("H:i") }} - {{ $semester->time_end->format("H:i") }}
                                            </td>
                                        @else
                                            <td>-</td>
                                        @endif
                                    @endforeach
                                </tr>
                                <tr>
                                    <th class="{{ $semester->hasClassToday('thursday') ? "bg-ac-info text-white" : "" }}">پنج شنبه</th>
                                    @foreach (range(1, 7) as $i)
                                        @if ($semester->hasClassToday('thursday'))
                                            <td class="text-nowrap bg-ac-info text-white"> 
                                                    {{ $semester->time_start->format("H:i") }} - {{ $semester->time_end->format("H:i") }}
                                            </td>
                                        @else
                                            <td>-</td>
                                        @endif
                                    @endforeach
                                </tr>
                                <tr>
                                    <th class="{{ $semester->hasClassToday('friday') ? "bg-ac-info text-white" : "" }}">جمعه</th>
                                    @foreach (range(1, 7) as $i)
                                        @if ($semester->hasClassToday('friday'))
                                            <td class="text-nowrap bg-ac-info text-white"> 
                                                    {{ $semester->time_start->format("H:i") }} - {{ $semester->time_end->format("H:i") }}
                                            </td>
                                        @else
                                            <td>-</td>
                                        @endif
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
            </div>
        </div>
        </div>
    </div>
</div>
