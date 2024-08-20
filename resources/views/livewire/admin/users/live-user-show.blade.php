<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-4">
            <h5 class="card-title fw-semibold">اطلاعات کاربر {{ $user->full_name }}</h5>
            <button class="btn btn-sm btn-ac-info" wire:click="edit()">ویرایش</button>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row mb-5">
                    <div class="col-md-3 col-6 mb-3 text-center">
                        نام: {{ $user->first_name }}
                    </div>
                    <div class="col-md-3 col-6 mb-3 text-center">
                        نام خانوادگی: {{ $user->last_name }}
                    </div>
                    <div class="col-md-3 col-6 mb-3 text-center">
                        نام پدر: {{ $user->userInfo->father_name }}
                    </div>
                    <div class="col-md-3 col-6 mb-3 text-center">
                        شماره همراه: <span @cannot('user_view_mobile') class="phone-number" @endcannot dir="ltr">{{ $user->userInfo->mobile_1 }}</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-10 col-12 mb-3 table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center" scope="col">ویرایش اطلاعات</th>
                                    <th class="text-center" scope="col">مشاهده کارنامه</th>
                                    <th class="text-center" scope="col">مشاهده سایر دوره ها</th>
                                    <th class="text-center" scope="col">مشاهده امور مالی</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center"><i class="cursor-pointer ti ti-click ms-2" data-bs-toggle="tooltip" data-bs-placement="top" wire:click="edit({{ $user->id }}, {{ $user->type }})" title="ویرایش"></i></td>
                                    <td class="text-center"><i class="cursor-pointer ti ti-click ms-2" data-bs-toggle="tooltip" data-bs-placement="top" wire:click="reportCard({{ $user->id }}, {{ $user->type }})" title="کارنامه"></i></td>
                                    <td class="text-center"><i class="cursor-pointer ti ti-click ms-2" data-bs-toggle="tooltip" data-bs-placement="top" wire:click="courses({{ $user->id }}, {{ $user->type }})" title="سایر دوره ها"></i></td>
                                    <td class="text-center"><i class="cursor-pointer ti ti-click ms-2" data-bs-toggle="tooltip" data-bs-placement="top" wire:click="finances({{ $user->id }}, {{ $user->type }})" title="امور مالی"></i></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col text-center">
                        <img src="{{ $user->getFirstMediaUrl('personal_image') }}" alt="" class="img-fluid" style="max-height: 110px">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3 table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center" scope="col">نام ترم جاری</th>
                                    <th class="text-center" scope="col">نام استاد</th>
                                    <th class="text-center" scope="col">ارسال اطلاعات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">{{ $user->current_semester_title }}</td>
                                    <td class="text-center">{{ $user->current_semester_teacher }}</td>
                                    <td class="text-center"><i class="cursor-pointer ti ti-click ms-2" data-bs-toggle="modal" data-bs-target="#sendInfo" title="ارسال"></i></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row g-0">
                    <div class="col-md-3 text-center align-content-center border">
                        وضعیت شهریه
                    </div>
                    <div class="border col-md-9 table-responsive p-4">
                        <table class="mb-0 table table-bordered">
                            <tbody>
                                @forelse ($tuitions as $tuition)
                                    <tr>
                                        <td class="text-center p-1">{{ __('admin/enums/EnumOrderPaymentStatus.' . $tuition->payment_status) }}</td>
                                        <td class="text-center p-1"><i class="ti {{ $tuition->payment_status === 'clear' ? "ti-checkbox text-success" : "ti-x text-danger" }}"></i></td>
                                        <td class="text-center p-1">جهت مشاهده جزئیات کلیک نمایید</td>
                                    </tr>
                                @empty
                                    <tr><td class="text-center p-1">در حال حاضر اطلاعاتی ثبت نشده است.</td></tr>
                                @endforelse
                                {{-- <tr>
                                    <td class="text-center p-1">تسویه</td>
                                    <td class="text-center p-1"><i class="cursor-pointer ti ti-check" data-bs-toggle="tooltip" data-bs-placement="top" wire:click="edit({{ $user->id }}, {{ $user->type }})" title="ویرایش"></i></td>
                                    <td class="text-center p-1">بدهکار می باشد</td>
                                </tr>
                                <tr>
                                    <td class="text-center p-1">بدهکار</td>
                                    <td class="text-center p-1"><i class="cursor-pointer ti ti-x" data-bs-toggle="tooltip" data-bs-placement="top" wire:click="edit({{ $user->id }}, {{ $user->type }})" title="ویرایش"></i></td>
                                    <td class="text-center p-1">جهت مشاهده بدهی کلیک نمایید</td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row g-0">
                    <div class="col-md-3 text-center align-content-center border">
                        وضعیت کتاب
                    </div>
                    <div class="border col-md-9 table-responsive p-4">
                        <table class="mb-0 table table-bordered">
                            <tbody>
                                @forelse ($books as $book)
                                    <tr>
                                        <td class="text-center p-1">{{ __('admin/enums/EnumOrderPaymentStatus.' . $book->payment_status) }}</td>
                                        <td class="text-center p-1"><i class="ti {{ $book->payment_status === 'clear' ? "ti-checkbox text-success" : "ti-x text-danger" }}"></i></td>
                                        <td class="text-center p-1 cursor-pointer">جهت مشاهده جزئیات کلیک نمایید</td>
                                    </tr>
                                @empty
                                    <tr><td class="text-center p-1">در حال حاضر اطلاعاتی ثبت نشده است.</td></tr>
                                @endforelse
                                {{-- <tr>
                                    <td class="text-center p-1">بدهکار</td>
                                    <td class="text-center p-1"><i class="cursor-pointer ti ti-x" data-bs-toggle="tooltip" data-bs-placement="top" wire:click="edit({{ $user->id }}, {{ $user->type }})" title="ویرایش"></i></td>
                                    <td class="text-center p-1">جهت مشاهده بدهی کلیک نمایید</td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row g-0">
                    <div class="col-md-3 text-center align-content-center border">
                        برنامه هفتگی
                    </div>
                    <div class="border col-md-9 table-responsive p-4">
                        <table class="mb-0 table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center" scope="col">روز</th>
                                    <th class="text-center" scope="col">نام دوره</th>
                                    <th class="text-center" scope="col">شماره کلاس</th>
                                    <th class="text-center" scope="col">ساعت</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center p-1">شنبه</td>
                                    <td class="text-center p-1">Fil 1/a</td>
                                    <td class="text-center p-1">A</td>
                                    <td class="text-center p-1">18 – 19:30</td>
                                </tr>
                                <tr>
                                    <td class="text-center p-1">یکشنبه</td>
                                    <td class="text-center p-1">Fil 1/a</td>
                                    <td class="text-center p-1">A</td>
                                    <td class="text-center p-1">18 – 19:30</td>
                                </tr>
                                <tr>
                                    <td class="text-center p-1">دوشنبه</td>
                                    <td class="text-center p-1">Fil 1/a</td>
                                    <td class="text-center p-1">A</td>
                                    <td class="text-center p-1">18 – 19:30</td>
                                </tr>
                                <tr>
                                    <td class="text-center p-1">سه شنبه</td>
                                    <td class="text-center p-1">Fil 1/a</td>
                                    <td class="text-center p-1">A</td>
                                    <td class="text-center p-1">18 – 19:30</td>
                                </tr>
                                <tr>
                                    <td class="text-center p-1">چهار شنبه</td>
                                    <td class="text-center p-1">Fil 1/a</td>
                                    <td class="text-center p-1">A</td>
                                    <td class="text-center p-1">18 – 19:30</td>
                                </tr>
                                <tr>
                                    <td class="text-center p-1">پنج شنبه</td>
                                    <td class="text-center p-1">Fil 1/a</td>
                                    <td class="text-center p-1">A</td>
                                    <td class="text-center p-1">18 – 19:30</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="sendInfo" tabindex="-1" aria-labelledby="sendInfoLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">ارسال اطلاعات</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group text-center">
                    <li class="list-group-item" wire:click="send('tuition')">ارسال بدهی شهریه بهمراه لینک پرداخت</li>
                    <li class="list-group-item" wire:click="send('book')">ارسال بدهی کتاب بهمراه لینک پرداخت</li>
                    <li class="list-group-item" wire:click="send('lessonPlan')">ارسال برنامه هفتگی</li>
                    <li class="list-group-item" wire:click="send('reportCard')">ارسال کارنامه</li>
                </ul>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">لغو</button>
            </div>
        </div>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        $(document).ready(function() {
            $('.phone-number').each(function() {
                var phoneNumber = $(this).text();
                var hiddenNumber = phoneNumber.substring(0, 4) + '*****' + phoneNumber.substring(9);
                $(this).text(hiddenNumber);

                $(this).on('click', function() {
                    window.location.href = 'tel:' + phoneNumber;
                });
            });
            $('.national-code').each(function() {
                var nationalCode = $(this).text();
                var hiddenNumber = nationalCode.substring(0, 4) + '*****' + nationalCode.substring(8);
                $(this).text(hiddenNumber);
            });
        });
    </script>
@endpush
