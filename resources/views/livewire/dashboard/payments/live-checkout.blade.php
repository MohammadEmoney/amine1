<div dir="rtl">
    <div class="row justify-content-center">
        <div class="col-md-10 col-12">
            <div class="card">
                <div class="card-body">
                    <h4>{{ $title }}</h4>
                    <div class="container">
                        <div class="row">
                        
                            <div class="col-md-4 order-2">
                                <h4 class="d-flex justify-content-between align-items-center mb-3">
                                    <span class=text-muted>مجموع کل</span>
                                </h4>
                                
                                <li class="list-group-item d-flex justify-content-between lh-condensed mb-3">
                                    <div>
                                        <h6 class="my-0">مجموع سبد خرید</h6>
                                        {{-- <small class="text-muted">Brief description</small> --}}
                                    </div>
                                    <span class="text-muted">{{ number_format($totalPrice) }} تومان</span>
                                </li>
                                @if ($tax)
                                <li class="list-group-item d-flex justify-content-between lh-condensed mb-3">
                                    <div>
                                        <h6 class="my-0">مالیات</h6>
                                        {{-- <small class="text-muted">Brief description</small> --}}
                                    </div>
                                    <span class="text-muted">{{ $tax }}%</span>
                                </li>
                                @endif
                                
                                @if ($discountPrice)
                                    <li class="list-group-item d-flex justify-content-between bg-light mb-3">
                                        <div class="text-success">
                                            <h6 class="my-0">تخفیف</h6>
                                            {{-- <small>EXAMPLECODE</small> --}}
                                        </div>
                                        <span class="text-success">-{{ number_format($discountPrice) }} تومان</span>
                                    </li>
                                @endif
                                
                                
                                <div class="card-footer d-flex justify-content-between px-0">
                                    <span>مبلغ قابل پرداخت</span>
                                    <strong>{{ number_format($payablePrice) }} تومان</strong>
                                </div>
                            </div>
                        
                            <div class="col-md-8 order-1">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">تصویر</th>
                                                <th scope="col">عنوان</th>
                                                <th scope="col">تعداد</th>
                                                <th scope="col">مبلغ (تومان)</th>
                                                <th scope="col">عملیات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($carts as $key => $cart)
                                                <tr>
                                                    <th scope="row">{{  $loop->iteration }}</th>
                                                    <td style="width: 7rem"><img src="{{ $cart['image'] ?? asset('front/img/amine2.png') }}" alt="" class="w-100"></td>
                                                    <td class="text-nowrap"><a href="{{ $cart['link'] ?? "#" }}"></a>{{ $cart['title'] ?? "-" }}</td>
                                                    <td>{{ $cart['quantity'] ?? 1 }}</td>
                                                    <td>{{ number_format($cart['price'] ?? 0) }}</td>
                                                    <td class="text-nowrap">
                                                        <i class="cursor-pointer ti ti-trash text-danger ms-2" data-bs-toggle="tooltip" data-bs-placement="top" onclick="Custom.deleteItemList({{$cart['id']}})" title="حذف"></i>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center"><p> سبد خرید شما خالی می باشد. <i class="ti ti-alert-triangle"></i></p></td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <form wire:submit.prevent="submitUserInfo" class="mb-3">
                                    <div class="row">
                                        <div class="col mb-4">
                                            <label for="First name"> نام </label>
                                            <input type="text" class="form-control" placeholder="نام" aria-label="First name" wire:model.live="data.first_name">
                                            <div>@error('data.first_name') {{ $message }} @enderror</div>
                                        </div>
                                        <div class="col mb-4">
                                            <label for="La\st name"> نام خانوادگی </label>
                                            <input type="text" class="form-control" placeholder="نام خانوادگی" aria-label="Last name" wire:model.live="data.last_name">
                                            <div>@error('data.last_name') {{ $message }} @enderror</div>
                                        </div>
                                    </div>
    
                                    <div class="row">
                                        <div class="mb-4">
                                            <label for="email">ایمیل (اختیاری)</label>
                                            <input type="text" class="form-control" placeholder="your@example.com" aria-label="ایمیل" wire:model.live="data.email" dir="ltr">
                                            <div>@error('data.email') {{ $message }} @enderror</div>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="Address">آدرس</label>
                                            <input type="text" class="form-control" placeholder="مهرشهر ، بلوار ارم ، خیابان ولیعصر ..." aria-label="Address" wire:model.live="data.address">
                                            <div>@error('data.address') {{ $message }} @enderror</div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <button class="btn btn-ac-info" type="submit">
                                                ثبت اطلاعات
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                
                                <div class="row">
                                    
                                    <hr class="mb-4">
                                    <h5 class="mb-3">نحوه پرداخت</h5>
                                
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" wire:model.live="paymentMethod" id="flexRadioDefault1" value="credit_card">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                        پرداخت آنلاین
                                        </label>
                                    </div>
                                    {{-- <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                                        <label class="form-check-label" for="flexRadioDefault2">
                                        Debit card
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3">
                                        <label class="form-check-label" for="flexRadioDefault3">
                                        Paypal
                                        </label>
                                    </div>
                                
                                    <div class="row">
                                        <div class="col mb-4">
                                        <label for="Card1">
                                            Name on card
                                        </label>
                                        <input type="text" class="form-control"aria-label="card1">
                                        <small class="text-muted">
                                            Full name, as displayed on the card
                                        </small>
                                        </div>
                                        
                                        <div class="col mb-4">
                                        <label for="Card2">
                                            Credit card Nummber
                                        </label>
                                        <input type="text" class="form-control" placeholder"1234-5678-9012" aria-label="Card2">
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col mb-3">
                                        <label for="Card3">
                                            Expiry Date
                                        </label>
                                        <input type="text" class="form-control"aria-label="card3">
                                        </div>
                                        
                                        <div class="col mb-3">
                                        <label for="Card4">
                                            CVV
                                        </label>
                                        <input type="text" class="form-control"  aria-label="Card4">
                                        </div>
                                    </div> --}}
                                
                                </div>

                                @if ($paymentMethod === 'credit_card')
                                    <div class="row">
                                        <hr class="mb-4">
                                        <h5 class="mb-3">درگاه پرداخت</h5>
                                        @foreach ($gateways as $gateway)
                                            <div class="col-md-2">
                                                <label>
                                                    <input type="radio" class="gateway-input" wire:model="gateway" name="gateway" value="{{ $gateway }}">
                                                    <img src="{{ \App\Enums\EnumGateway::icon($gateway) }}" class="img-fluid" alt="Option 1">
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            
                                <hr class="mb-4">
                                
                                <div class="d-grid gap-2">
                                    <button class="btn btn-ac-primary btn-lg" type="button" wire:click="pay">
                                        <span class="spinner-border spinner-border-sm" wire:loading></span>
                                    پرداخت
                                    </button>
                                </div>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
