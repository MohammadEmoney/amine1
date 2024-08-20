<div class="container-fluid">
    <livewire:admin.components.live-breadcrumb :items="[['title' => 'لیست ریزشی ها', 'route' => route('admin.users.dropouts.index')], ['title' => $title]]" />
    <div class="card">
        <div class="card-body">
            <h3 class="">{{ $title }}</h3>
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
                                            <div class="accordion" id="accordionExample">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingOne" wire:ignore>
                                                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                        پیگیری 1 - (مسئول پیگیری : <a href="{{ route('admin.users.staff.edit', $dropout->user->id) }}">{{ $dropout->user->full_name }}</a> - تاریخ پیگیری : {{ \Morilog\Jalali\Jalalian::fromDateTime($dropout->created_at)->format('Y-m-d') }})
                                                      </button>
                                                    </h2>
                                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample" wire:ignore.self>
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="mb-3" wire:ignore>
                                                                        <label for="exampleInputtext1" class="form-label">علت ریزش دانش آموز</label>
                                                                        <select id="" class="form-control select2 @error('dropouts.reasons') invalid-input @enderror"
                                                                            wire:model.live="dropouts.reasons" onchange="livewireSelect2Multi('dropouts.reasons', this)" multiple>
                                                                            <option value="">انتخاب نمایید</option>
                                                                            @foreach ($dropoutReasons as $key => $value)
                                                                                <option value="{{ $value }}">
                                                                                    {{ $value }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <div>
                                                                            @error('dropouts.reasons')
                                                                                {{ $message }}
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputtext1" class="form-label">تاریخ
                                                                            ترک *</label>
                                                                        <input type="text" class="form-control date @error('dropouts.date_left') invalid-input @enderror"
                                                                            wire:model.live="dropouts.date_left"
                                                                            id="date_left" aria-describedby="textHelp"
                                                                            autocomplete="new-password"
                                                                            data-date="{{ $dropouts['date_left'] ?? "" }}" value="{{ $dropouts['date_left'] ?? "" }}">
                                                                        <div>
                                                                            @error('dropouts.date_left')
                                                                                {{ $message }}
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputtext1" class="form-label">تاریخ
                                                                            بازگشت</label>
                                                                        <input type="text" class="form-control date @error('dropouts.date_return') invalid-input @enderror"
                                                                            wire:model.live="dropouts.date_return"
                                                                            id="date_return" aria-describedby="textHelp"
                                                                            autocomplete="new-password"
                                                                            data-date="{{ $dropouts['date_return'] ?? "" }}" value="{{ $dropouts['date_return'] ?? "" }}">
                                                                        <div>
                                                                            @error('dropouts.date_return')
                                                                                {{ $message }}
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="mb-3" wire:ignore>
                                                                        <label for="exampleInputtext1"
                                                                            class="form-label">توضیحات</label>
                                                                        <textarea class="form-control" wire:model.live="dropouts.description" id="description" cols="10" rows="10"
                                                                            style="height: 60px;"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @foreach ($followUps as $key => $followUp)
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingOne-{{ $loop->iteration + 1 }}" wire:ignore>
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne-{{ $loop->iteration + 1 }}" aria-expanded="true" aria-controls="collapseOne-{{ $loop->iteration + 1 }}">
                                                            پیگیری {{ $loop->iteration + 1 }} - 
                                                            (مسئول پیگیری : @if(isset($followUp['user_id'])) <a href="{{ route('admin.users.staff.edit', $followUp['user_id']) }}">{{ $followUp['username'] ?? "-" }}</a> @else {{ $followUp['username'] ?? "-" }} @endif
                                                             - تاریخ پیگیری : {{ \Morilog\Jalali\Jalalian::fromDateTime(now())->format('Y-m-d') }})
                                                        </button>
                                                        </h2>
                                                        <div id="collapseOne-{{ $loop->iteration + 1 }}" class="accordion-collapse collapse show" aria-labelledby="headingOne-{{ $loop->iteration + 1 }}" data-bs-parent="#accordionExample" wire:ignore.self>
                                                            <div class="accordion-body">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="mb-3" wire:ignore>
                                                                            <label for="exampleInputtext1" class="form-label">علت ریزش دانش آموز</label>
                                                                            <select id="" class="form-control select2 @error('followUps.{{ $key }}.reasons') invalid-input @enderror"
                                                                                wire:model.live="followUps.{{ $key }}.reasons" onchange="livewireSelect2Multi('followUps.{{ $key }}.reasons', this)" multiple>
                                                                                <option value="">انتخاب نمایید</option>
                                                                                @foreach ($dropoutReasons as $key => $value)
                                                                                    <option value="{{ $value }}">
                                                                                        {{ $value }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            <div>
                                                                                @error('followUps.{{ $key }}.reasons')
                                                                                    {{ $message }}
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="mb-3" wire:ignore>
                                                                            <label for="exampleInputtext1"
                                                                                class="form-label">توضیحات</label>
                                                                            <textarea class="form-control" wire:model.live="followUps.{{ $key }}.description" id="description" cols="10" rows="10"
                                                                                style="height: 60px;"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                
                                            </div>

                                            @if (!$adding)
                                                <div class="row justify-content-center my-3">
                                                    <div class="col-md-4 d-flex">
                                                        <button type="button" class="btn btn-light w-100" wire:click="showForm()">افزودن پیگیری +</button>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="container my-4">
                                                    <div class="d-flex align-items-center">
                                                        <hr class="flex-grow-1">
                                                        <span class="mx-2">ثبت پیگیری</span>
                                                        <hr class="flex-grow-1">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3" wire:ignore>
                                                            <label for="exampleInputtext1" class="form-label">علت ریزش دانش آموز</label>
                                                            <select id="" class="form-control select2 @error('data.reasons') invalid-input @enderror"
                                                                wire:model.live="data.reasons" onchange="livewireSelect2Multi('data.reasons', this)" multiple>
                                                                <option value="">انتخاب نمایید</option>
                                                                @foreach ($dropoutReasons as $key => $value)
                                                                    <option value="{{ $value }}">
                                                                        {{ $value }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div>
                                                                @error('data.reasons')
                                                                    {{ $message }}
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3" wire:ignore>
                                                            <label for="exampleInputtext1"
                                                                class="form-label">توضیحات</label>
                                                            <textarea class="form-control" wire:model.live="data.description" id="description" cols="10" rows="10"
                                                                style="height: 60px;"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <button type="button" wire:click="submitData()"
                                                            class="btn btn-light-indigo w-100 py-8 fs-4 mb-4 rounded-0">
                                                            <span class="spinner-border spinner-border-sm"
                                                                wire:loading></span> ثبت اطلاعات
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <button type="submit"
                                                        class="btn btn-ac-primary w-100 py-8 fs-4 mb-4 rounded-0">
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
</div>

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#student_birth_date").pDatepicker({
                format: 'YYYY-MM-DD',
                autoClose: true,
                initialValue : true,
                initialValueType : 'persian',
                onSelect: function(unix) {
                    var propertyName = $(this).data('property');
                    @this.set('data.birth_date', new persianDate(unix).format('YYYY-MM-DD'), true);
                }
            });

            $("#register_date").pDatepicker({
                format: 'YYYY-MM-DD',
                autoClose: true,
                initialValue : true,
                initialValueType : 'persian',
                onSelect: function(unix) {
                    var propertyName = $(this).data('property');
                    @this.set('data.birth_date', new persianDate(unix).format('YYYY-MM-DD'), true);
                }
            });

            $("#date_left").pDatepicker({
                format: 'YYYY-MM-DD',
                autoClose: true,
                initialValue : true,
                initialValueType : 'persian',
                onSelect: function(unix) {
                    var propertyName = $(this).data('property');
                    @this.set('dropouts.date_left', new persianDate(unix).format('YYYY-MM-DD'), true);
                }
            });

            $("#date_return").pDatepicker({
                format: 'YYYY-MM-DD',
                autoClose: true,
                initialValue : true,
                initialValueType : 'persian',
                onSelect: function(unix) {
                    var propertyName = $(this).data('property');
                    @this.set('dropouts.date_return', new persianDate(unix).format('YYYY-MM-DD'), true);
                }
            });

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

@script
<script>

    $wire.on('loadJs', () => {
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
    })
</script>
@endscript
