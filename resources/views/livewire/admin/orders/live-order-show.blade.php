<div class="container-fluid">
    <livewire:admin.components.live-breadcrumb :items="[['title' => 'لیست سفارش ها', 'route' => route('admin.orders.index')], ['title' => 'ویرایش سفارش']]" />
    <div class="card">
        <div class="img-placeholder"></div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="card-title fw-semibold">اطلاعات {{ $orderTitle }}</h5>
                <button class="btn btn-sm btn-ac-info" wire:click="edit()">ویرایش</button>
            </div>
            <div>
                <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
                            data-sidebar-position="fixed" data-header-position="fixed">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-3 col-6 mb-3 text-center">
                                    نام: <a href="{{ route('admin.users.student.show', $user->id) }}">{{ $user->first_name }}</a>
                                </div>
                                <div class="col-md-3 col-6 mb-3 text-center">
                                    نام خانوادگی: <a href="{{ route('admin.users.student.show', $user->id) }}">{{ $user->last_name }}</a>
                                </div>
                                <div class="col-md-3 col-6 mb-3 text-center">
                                    نام پدر: {{ $user->userInfo->father_name }}
                                </div>
                                <div class="col-md-3 col-6 mb-3 text-center">
                                    شماره همراه: <span @cannot('user_view_mobile') class="phone-number" @endcannot dir="ltr">{{ $user->userInfo->mobile_1 }}</span>
                                </div>
                            </div>
                            <div class="row mb-5">
                                @if($order->type === "tuition")
                                    <div class="col-md-3 col-6 mb-3 text-center">
                                        شهریه کلاس: <a href="{{ route('admin.semesters.edit', $order->orderable->id) }}">{{ $order->orderable?->course?->title_with_part }}</a>
                                    </div>
                                    <div class="col-md-3 col-6 mb-3 text-center">
                                        مبلغ شهریه: {{ number_format($order->order_amount ?: 0) }} تومان
                                    </div>
                                @else
                                    <div class="col-md-3 col-6 mb-3 text-center">
                                        کتاب <a href="{{ route('admin.books.edit', $order->orderable->id) }}">{{ $order->orderable->title }}</a>
                                    </div>
                                @endif
                            </div>
    
                            {{-- <div class="row">
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
                                                <td class="text-center"><i class="cursor-pointer ti ti-click ms-2" data-bs-toggle="tooltip" data-bs-placement="top" wire:click="sendMessagesModal({{ $user->id }}, {{ $user->type }})" title="ویرایش"></i></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div> --}}
                            <div class="row g-0">
                                <div class="col-md-3 text-center align-content-center border">
                                    وضعیت پرداخت
                                </div>
                                <div class="border col-md-9 table-responsive p-4">
                                    <table class="mb-0 table table-bordered">
                                        <tbody>
                                            <tr class="{{ $order->payment_status === 'clear' ? "bg-success" : "bg-danger"}}">
                                                <td class="text-center p-1 text-white">{{ __('admin/enums/EnumOrderPaymentStatus.' . $order->payment_status) }}</td>
                                                <td class="text-center p-1"><i class="ti {{ $order->payment_status === 'clear' ? "ti-checkbox" : "ti-x" }}"></i></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row g-0">
                                <div class="col-md-3 text-center align-content-center border">
                                    مبلغ {{ $orderTitle }}
                                </div>
                                <div class="col-md-9 table-responsive">
                                    <table class="mb-0 table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    {{ number_format($order->order_amount ?: 0) }} تومان
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row g-0">
                                <div class="col-md-3 text-center align-content-center border">
                                    مبلغ پرداخت شده
                                </div>
                                <div class="col-md-9 table-responsive">
                                    <table class="mb-0 table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    {{ number_format($order->paid_amount ?: 0) }} تومان
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row g-0">
                                <div class="col-md-3 text-center align-content-center border">
                                    شماره قرارداد
                                </div>
                                <div class="col-md-9 table-responsive">
                                    <table class="mb-0 table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    {{ $order->contract_number ?: "-" }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row g-0">
                                <div class="col-md-3 text-center align-content-center border">
                                    نوع پرداخت
                                </div>
                                <div class="col-md-9 table-responsive">
                                    <table class="mb-0 table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    {{ $order->payment_type ? __('admin/enums/EnumPaymentTypes.' . $order->payment_type) : "-" }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row g-0">
                                <div class="col-md-3 text-center align-content-center border">
                                    نحوه پرداخت
                                </div>
                                <div class="col-md-9 table-responsive">
                                    <table class="mb-0 table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    {{ $order->payment_method ? __("admin/enums/EnumPaymentMethods." . $order->payment_method) : "-" }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row g-0">
                                <div class="col-md-3 text-center align-content-center border">
                                    مدارک
                                </div>
                                <div class="col-md-9 table-responsive">
                                    <table class="mb-0 table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <img src="{{ $order->getFirstMediaUrl('documents') }}" class="w-25 img-full-screen">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row g-0">
                                @if ($order->installments)
                                    <h3 class="m-3">لیست اقساط</h3>
                                @endif
                                @includeWhen($order->installments, 'livewire.admin.orders.partials.installments-list')
                            </div>
                        </div>
                    </div>
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
