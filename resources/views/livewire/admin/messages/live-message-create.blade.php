<div class="container-fluid">
    <livewire:admin.components.live-breadcrumb :items="[['title' => 'لیست پیام ها', 'route' => route('admin.messages.index')], ['title' => 'ایجاد پیام جدید']]" />
    <div class="card">
        <div class="card-body">
            <h3 class="">ایجاد پیام</h3>
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
                                        <form wire:submit.prevent="submit" autocomplete="off">
                                            {{-- <div class="d-flex justify-content-center">
                                                <div class="form-group mb-3">
                                                    <div class="form-check form-switch d-flex ps-0 flex-row-reverse justify-content-end">
                                                        <label class="form-check-label" for="flexSwitchCheckDefault">کلاس</label>
                                                        <input class="form-check-input mx-2" type="checkbox" role="switch" id="flexSwitchCheckDefault" wire:model.live="isClass">
                                                        <label class="form-check-label" for="flexSwitchCheckDefault">دانش آموز</label>
                                                    </div>
                                                </div>
                                            </div> --}}
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="exampleInputtext1" class="form-label">عنوان پیام
                                                            *</label>
                                                        <input type="text" class="form-control"
                                                            wire:model.live.debounce.800ms="data.title" id="exampleInputtext1" min="1"
                                                            aria-describedby="textHelp" placeholder="">
                                                        <div>
                                                            @error('data.title')
                                                                {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($isClass)
                                                    <div class="col-md-6">
                                                        <label for="exampleInputtext1" class="form-label">انتخاب کلاس</label>
                                                        <div class="mb-3" wire:ignore>
                                                            <select id="" class="form-control select2"
                                                                onchange="livewireSelect2('data.semesters', this)">
                                                                <option value="">انتخاب نمایید</option>
                                                                @foreach ($semesters as $key => $value)
                                                                    <option value="{{ $value->id }}">
                                                                        {{ $value->title }} ({{  $value->teacher?->full_name  }})</option>
                                                                @endforeach
                                                            </select>
                                                            <div>
                                                                @error('data.users')
                                                                    {{ $message }}
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="col-md-6">
                                                        <label for="exampleInputtext1" class="form-label">انتخاب دانش آموزان</label>
                                                        <div class="mb-3" wire:ignore>
                                                            <select id="" class="form-control select2" multiple
                                                                onchange="livewireSelect2Multi('data.students', this)">
                                                                <option value="">انتخاب نمایید</option>
                                                                @foreach ($users as $key => $value)
                                                                    <option value="{{ $value->id }}">
                                                                        {{ $value->full_name }} ({{  $value->national_code  }})</option>
                                                                @endforeach
                                                            </select>
                                                            <div>
                                                                @error('data.users')
                                                                    {{ $message }}
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="exampleInputtext1"
                                                            class="form-label">پیام *</label>
                                                        <textarea class="form-control" wire:model.live="data.message" id="" cols="10" rows="10"
                                                            style="height: 60px;"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <button type="submit"
                                                        @if ($disabledCreate) disabled @endif
                                                        class="btn btn-ac-primary w-100 py-8 fs-4 mb-4 rounded-0 {{ $disabledCreate ? '' : 'blink_me' }}">
                                                        <span class="spinner-border spinner-border-sm"
                                                            wire:loading></span> <i class="ti ti-send"></i> ارسال
                                                    </button>
                                                </div>
                                                <div class="col-md-6">
                                                    <button type="button" wire:click="draft"
                                                        @if ($disabledCreate) disabled @endif
                                                        class="btn btn-dark w-100 py-8 fs-4 mb-4 rounded-0 {{ $disabledCreate ? '' : 'blink_me' }}">
                                                        <span class="spinner-border spinner-border-sm"
                                                            wire:loading></span><i class="ti ti-device-floppy"></i> پپیش نویس
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

        function livewireSelect2(component, event) {
            @this.set(component, $(event).val())
        }

        function livewireSelect2Multi(component, event) {
            var selectedValues = [];
            $(event).find('option:selected').each(function () {
                selectedValues.push($(this).val());
            });
            @this.set(component, selectedValues)
        }
    </script>
@endpush
