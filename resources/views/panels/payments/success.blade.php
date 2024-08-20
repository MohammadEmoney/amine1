@extends('layouts.panel')

@section('content')
    <div class="container">
        <div dir="rtl">
            <div class="row justify-content-center">
                <div class="col-md-10 col-12">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="text-center"><i class="ti ti-circle-check text-success"></i></h1>
                            <p class="text-center">
                                سفارش <span class="alert text-info">{{ $order?->contract_number }}</span> با موفقیت پرداخت و در سیستم ثبت شد.
                            </p>
                            <p class="text-center">پرداخت با موفقیت انجام شد. سفارش شما با موفقیت ثبت شد.
                                از اینکه آموزشگاه امین 1 را انتخاب کردید از شما سپاسگزاریم.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-10 col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4>کد سفارش: {{ $order?->contract_number }}</h4>
                            <div class="row">
                                <div class="col-md-9">
                                    سفارش شما با موفقیت در سیستم ثبت شد و هم اکنون در انتظار پرداخت است.جزئیات این سفارش را می توانید با کلیک بر روی دکمه پیگیری سفارش مشاهده نمایید.
                                </div>
                                <div class="col-md-3">
                                    <a href="#" class="btn btn-ac-info">پیگیری سفارش</a>
                                </div>
                            </div>

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">نام تحویل گیرنده: {{ Auth::user()->full_name }}</th>
                                        <th scope="col">شماره تماس : {{ Auth::user()->phone }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>نوع سفارش : {{ __('admin/enums/EnumOrderType.' . $order?->type) }}</td>
                                        <td>مبلغ کل : {{ number_format($order?->order_amount) }} تومان</td>
                                    </tr>
                                    <tr>
                                        <td>وضعیت پرداخت : ناموفق</td>
                                        <td>وضعیت سفارش : {{ __('admin/enums/EnumOrderStatus.' . $order?->status) }}</td>
                                    </tr>
                                    <tr>
                                        <td>آدرس : {{ Auth::user()->userInfo?->address }}</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
