<div class="container-fluid">
    <livewire:admin.components.live-breadcrumb :items="[['title' => 'سفارش ها']]" />
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
                <h5 class="card-title fw-semibold mb-4">سفارش ها</h5>
                <button class="btn btn-sm btn-ac-info" wire:click="create">ایجاد سفارش</button>
            </div>
            <div class="table-responsive">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" class="form-control border-info" wire:model.live.debounce.600="search" placeholder="جستجو ...">
                    </div>
                    <div class="col-md-2">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFilter" wire:ignore>
                                    <button class="accordion-button collapsed p-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFilter" aria-expanded="false" aria-controls="collapseFilter">
                                        فیلتر:
                                    </button>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col-md-12">
                        <div id="collapseFilter" class="accordion-collapse collapse" aria-labelledby="headingFilter" data-bs-parent="#accordionExample" wire:ignore.self>
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <button class="btn btn-info" wire:click="resetFilter()" type="button">ریست فیلتر</button>
                                    </div>
                                </div>
                                <div class="row p-3">
                                    <div class="border col-md-6 px-0 py-2 text-center">
                                        <span>نوع سفارش:</span>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" wire:model.live="filter.order_type" name="orderType" id="inlineRadio1" value="tuition">
                                            <label class="form-check-label" for="inlineRadio1">نمایش شهریه ها</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" wire:model.live="filter.order_type" name="orderType" id="inlineRadio2" value="book">
                                            <label class="form-check-label" for="inlineRadio2">نمایش کتاب ها</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" wire:model.live="filter.order_type" name="orderType" id="inlineRadio3" value="">
                                            <label class="form-check-label" for="inlineRadio3">نمایش همه</label>
                                        </div>
                                    </div>
                                    <div class="border col-md-6 p-2 text-center">
                                        <span>نوع پرداخت:</span>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" wire:model.live="filter.payment_type" name="paymentType" id="paymentType1" value="installment">
                                            <label class="form-check-label" for="paymentType1">نمایش اقساطی</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" wire:model.live="filter.payment_type" name="paymentType" id="paymentType2" value="full">
                                            <label class="form-check-label" for="paymentType2">نمایش یکجا</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" wire:model.live="filter.payment_type" name="paymentType" id="paymentType3" value="">
                                            <label class="form-check-label" for="paymentType3">نمایش همه</label>
                                        </div>
                                    </div>
                                    <div class="border col-md-6 px-0 py-2 text-center">
                                        <span>وضعیت پرداخت:</span>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" wire:model.live="filter.payment_status" name="paymentStatus" id="paymentStatus1" value="debt">
                                            <label class="form-check-label" for="paymentStatus1">نمایش بدهکار</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" wire:model.live="filter.payment_status" name="paymentStatus" id="paymentStatus2" value="clear">
                                            <label class="form-check-label" for="paymentStatus2">نمایش تسویه</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" wire:model.live="filter.payment_status" name="paymentStatus" id="paymentStatus3" value="">
                                            <label class="form-check-label" for="paymentStatus3">نمایش همه</label>
                                        </div>
                                    </div>
                                    <div class="border col-md-6 text-center">
                                        <select wire:model.live="filter.payment_method" class="form-control border-0">
                                            <option value="">روش پرداخت</option>
                                            @foreach ($paymentMethods as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">شماره قرارداد</th>
                            <th scope="col">دانش آموز</th>
                            <th scope="col">نوع سفارش</th>
                            <th scope="col">کتاب یا دوره</th>
                            <th scope="col">نوع پرداخت</th>
                            <th scope="col">روش پرداخت</th>
                            <th scope="col">مبلغ اصلی (تومان)</th>
                            <th scope="col">مبلغ پرداخت شده (تومان)</th>
                            <th scope="col">وضعیت پرداخت</th>
                            <th scope="col">تاریخ ثبت</th>
                            <th scope="col">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $key => $order)
                        
                            <tr>
                                <th scope="row">{{  ($orders->currentpage()-1) * $orders->perpage() + $key + 1 }}</th>
                                <td wire:click="show({{ $order->id }})" class="cursor-pointer text-nowrap">{{ $order->contract_number ?: "_" }}</td>
                                <td wire:click="show({{ $order->id }})" class="cursor-pointer text-nowrap">{{ $order->user?->full_name }}</td>
                                <td wire:click="show({{ $order->id }})" class="cursor-pointer">{{ __('admin/enums/EnumOrderType.' . $order->type) }}</td>
                                <td wire:click="show({{ $order->id }})" class="cursor-pointer">{{ $order->type === 'tuition' ? $order->orderable?->course?->title_with_part : $order->orderable?->title }}</td>
                                <td>{{ $order->payment_type ? __('admin/enums/EnumPaymentTypes.' . $order->payment_type) : "-" }}</td>
                                <td class="text-nowrap">{{ $order->payment_method ? __('admin/enums/EnumPaymentMethods.' . $order->payment_method) : "-" }}</td>
                                <td>{{ number_format($order->order_amount) }}</td>
                                <td>{{ number_format($order->paid_amount) }}</td>
                                <td class="text-nowrap">{{ __('admin/enums/EnumOrderPaymentStatus.' . $order->payment_status) }} <i class="ti {{ $order->payment_status === 'clear' ? "ti-checkbox text-success" : "ti-x text-danger" }}"></i></td>
                                <td class="text-nowrap">{{ \Morilog\Jalali\Jalalian::fromDateTime($order->register_date)->format('Y-m-d') }}</td>
                                <td class="text-nowrap">
                                    <i class="cursor-pointer ti ti-trash text-danger ms-2" data-bs-toggle="tooltip" data-bs-placement="top" onclick="Custom.deleteItemList({{$order->id}})" title="حذف"></i>
                                    <i class="cursor-pointer ti ti-pencil text-warning ms-2" data-bs-toggle="tooltip" data-bs-placement="top" wire:click="edit({{ $order->id }})" title="ویرایش"></i>
                                    {{-- <i class="cursor-pointer ti ti-eye" data-bs-toggle="tooltip" data-bs-placement="top" wire:click="show({{ $order->id }})" title="نمایش"></i> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
