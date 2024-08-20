<div dir="rtl">
    <div class="row justify-content-center">
        <div class="col-md-10 col-12">
            <div class="card">
                <div class="card-body">
                    {{-- <form wire:submit.prevent="submit"> --}}
                        <div class="row justify-content-center">
                            <div class="col-12 border bg-ac-secondary text-white">
                                @if(Auth::user()->hasRole('student'))
                                    <p class="p-2 text-center">لطفا از طریق یکی از گزینه های زیر دوره مورد نظر خود را انتخاب و ثبت نام خود را تکمیل نمایید .</p>
                                @else
                                    <p class="p-2 text-center">لطفا از طریق یکی از گزینه های زیر سفارش مورد نظر خود را انتخاب نمایید .</p>
                                @endif
                            </div>
                            <div class="col-6 border bg-ac-primary text-white text-center py-2">جستجو در سفارش ها</div>
                            <div class="col-6 border">
                                <input type="text" class="form-control border-0 text-center" wire:model.live="search" placeholder="شماره قرارداد">
                            </div>
                        </div>
                    {{-- </form> --}}
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
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
    </div>
</div>