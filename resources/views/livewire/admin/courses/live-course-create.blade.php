<div class="card">
    <div class="card-body">
        <h3 class="">ایجاد دوره</h3>
        <div>
            <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
                data-sidebar-position="fixed" data-header-position="fixed">
                <div class="d-flex align-items-center justify-content-center w-100">
                    <div class="row justify-content-center w-100">
                        <div class="col-md-12">
                            <div class="card mb-3 mt-3">
                                <div class="card-body">

                                    {{-- @if (count($errors->messages()))
                                        <div class="alert alert-warning" role="alert">
                                            لطفا گزینه های ستاره دار را تکمیل نمایید تا اطلاعات شما ثبت
                                            گردد.
                                        </div>
                                    @endif --}}
                                    <form wire:submit.prevent="submit">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="exampleInputtext1" class="form-label">عنوان
                                                        *</label>
                                                    <input type="text" class="form-control"
                                                        wire:model.live.debounce.800ms="data.title" id="exampleInputtext1"
                                                        aria-describedby="textHelp" placeholder="مثال: First Friend">
                                                    <div>
                                                        @error('data.title')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3" wire:ignore>
                                                    <label for="exampleInputtext1" class="form-label">پارت</label>
                                                    <select id="" class="form-control select2"
                                                        {{-- wire:model.live="data.part_numbers"  --}}
                                                        onchange="livewireSelect2Multi('data.part_numbers', this)" multiple>
                                                        <option value="">انتخاب نمایید</option>
                                                        @foreach ($courseParts as $key => $value)
                                                            <option value="{{ $key }}">
                                                                {{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div>
                                                        @error('data.part_numbers')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="exampleInputtext1" class="form-label">دسته بندی والد</label>
                                                    <select id="" class="form-control"
                                                        wire:model.live="data.parent_id">
                                                        <option value="">انتخاب نمایید</option>
                                                        @foreach ($courses as $value)
                                                            <option value="{{ $value->id }}">
                                                                {{ $value->title }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div>
                                                        @error('data.parent_id')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="exampleInputtext1" class="form-label">رده سنی دوره *</label>
                                                    <select id="" class="form-control"
                                                        wire:model.live="data.course_age">
                                                        <option value="">انتخاب نمایید</option>
                                                        @foreach ($courseAges as $key => $value)
                                                            <option value="{{ $key }}">
                                                                {{ trans($value) }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div>
                                                        @error('data.course_age')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="exampleInputtext1" class="form-label">نوع دوره *</label>
                                                    <select id="" class="form-control"
                                                        wire:model.live="data.course_type">
                                                        <option value="">انتخاب نمایید</option>
                                                        @foreach ($courseTypes as $key => $value)
                                                            <option value="{{ $key }}">
                                                                {{ trans($value) }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div>
                                                        @error('data.course_type')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="exampleInputtext1" class="form-label">قیمت (تومان)
                                                        *</label>
                                                    <input type="text" class="form-control"
                                                        wire:model.live.debounce.800ms="data.price" id="exampleInputtext1"
                                                        aria-describedby="textHelp" placeholder="مثال: 20000">
                                                    <div>
                                                        @error('data.price')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="priority" class="form-label">الویت*</label>
                                                    <small>کوچکترین عدد الویت بالاتری در نمایش دارند</small>
                                                    <input type="number" class="form-control" min="0"
                                                        wire:model.live.debounce.800ms="data.priority" id="priority"
                                                        aria-describedby="textHelp" placeholder="از عدد صفر به بالا">
                                                    <div>
                                                        @error('data.priority')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="exampleInputtext1" class="form-label">قیمت فروش (تومان)
                                                    </label>
                                                    <input type="text" class="form-control"
                                                        wire:model.live.debounce.800ms="data.sale_price" id="exampleInputtext1"
                                                        aria-describedby="textHelp" placeholder="مثال: 10000">
                                                    <div>
                                                        @error('data.sale_price')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <button type="submit"
                                                    @if ($disabledCreate) disabled @endif
                                                    class="btn btn-ac-primary w-100 py-8 fs-4 mb-4 rounded-0 {{ $disabledCreate ? '' : 'blink_me' }}">
                                                    <span class="spinner-border spinner-border-sm"
                                                        wire:loading></span> ثبت نهایی اطلاعات
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
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
        $(document).ready(function () {
            $('.select2').select2({
                placeholder: 'انتخاب کنید',
                dir: 'rtl',
                containerCssClass: 'select-sm',
                allowClear: !0
            });
        });
        function livewireSelect2Multi(component, event) {
            var selectedValues = [];
            $(event).find('option:selected').each(function () {
                selectedValues.push($(this).val());
            });
            @this.set(component, selectedValues)
        }
    </script>
@endpush