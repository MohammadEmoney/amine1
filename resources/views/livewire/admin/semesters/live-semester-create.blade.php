<div class="container-fluid">
    <livewire:admin.components.live-breadcrumb :items="[['title' => 'لیست کلاس ها', 'route' => route('admin.semesters.index')], ['title' => 'ایجاد کلاس جدید']]" />
    <div class="card">
        <div class="card-body">
            <h3 class="">ایجاد کلاس</h3>
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
                                            <div class="row">
                                                {{-- <div class="col-md-6">
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
                                                </div> --}}
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="exampleInputtext1" class="form-label">انتخاب دوره</label>
                                                        <select id="" class="form-control"
                                                            wire:model.live="data.course_id">
                                                            <option value="">انتخاب نمایید</option>
                                                            @foreach ($courses as $course)
                                                                <option value="{{ $course->id }}">
                                                                    {{ $course->title_with_part }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div>
                                                            @error('data.course_id')
                                                                {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="exampleInputtext1" class="form-label">انتخاب مدرس</label>
                                                        <select id="" class="form-control"
                                                            wire:model.live="data.teacher_id">
                                                            <option value="">انتخاب نمایید</option>
                                                            @foreach ($staff as $value)
                                                                <option value="{{ $value->id }}">
                                                                    {{ $value->full_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div>
                                                            @error('data.teacher_id')
                                                                {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                {{-- <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="register_date"
                                                            class="form-label">شروع ثبت نام
                                                            *</label>
                                                        <input type="text"
                                                            class="form-control"
                                                            wire:model.live="data.register_date"
                                                            id="register_date"
                                                            autocomplete="new-password"
                                                            aria-describedby="textHelp"
                                                            data-date="{{ $data['register_date'] ?? "" }}" value="{{ $data['register_date'] ?? "" }}">
                                                        <div>
                                                            @error('data.register_date')
                                                                {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div> --}}
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="date_start"
                                                            class="form-label">شروع ترم
                                                            *</label>
                                                        <input type="text"
                                                            class="form-control"
                                                            wire:model.live="data.date_start"
                                                            id="date_start"
                                                            autocomplete="new-password"
                                                            aria-describedby="textHelp"
                                                            data-date="{{ $data['date_start'] ?? "" }}" value="{{ $data['date_start'] ?? "" }}">
                                                        <div>
                                                            @error('data.date_start')
                                                                {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="date_end"
                                                            class="form-label">پایان ترم
                                                            *</label>
                                                        <input type="text"
                                                            class="form-control"
                                                            wire:model.live="data.date_end"
                                                            id="date_end"
                                                            autocomplete="new-password"
                                                            aria-describedby="textHelp"
                                                            data-date="{{ $data['date_end'] ?? "" }}" value="{{ $data['date_end'] ?? "" }}">
                                                        <div>
                                                            @error('data.date_end')
                                                                {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="time_start"
                                                            class="form-label">شروع کلاس
                                                            *</label>
                                                        <input type="text"
                                                            class="form-control"
                                                            wire:model.live="data.time_start"
                                                            id="time_start"
                                                            aria-describedby="textHelp"
                                                            data-date="{{ $data['time_start'] ?? "" }}" value="{{ $data['time_start'] ?? "" }}">
                                                        <div>
                                                            @error('time_start')
                                                                {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="time_end"
                                                            class="form-label">پایان کلاس
                                                            *</label>
                                                        <input type="text"
                                                            class="form-control"
                                                            wire:model.live="data.time_end"
                                                            id="time_end"
                                                            aria-describedby="textHelp"
                                                            data-date="{{ $data['time_end'] ?? "" }}" value="{{ $data['time_end'] ?? "" }}">
                                                        <div>
                                                            @error('time_end')
                                                                {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label for="exampleInputtext1" class="form-label">روز ها برگزاری کلاس</label>
                                                                <select id="" class="form-control"
                                                                    wire:model.live="dayType">
                                                                    <option value="">انتخاب نمایید</option>
                                                                    <option value="even">زوج</option>
                                                                    <option value="odd">فرد</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        @foreach ($weekDays as $day)
                                                            <div class="col-md-3 border">
                                                                <div class="my-2">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" wire:model="selectedDays.{{ $day }}"
                                                                            value="{{ $day }}" id="flexCheckDefault_{{ $day }}">
                                                                        <label class="form-check-label" for="flexCheckDefault_{{ $day }}">
                                                                            {{ __('admin/globals.week_days.' . $day) }}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="exampleInputtext1" class="form-label">شهریه( به تومان )
                                                            *</label>
                                                        <input type="number" class="form-control"
                                                            wire:model.live.debounce.800ms="data.tuition_fee" id="exampleInputtext1"
                                                            aria-describedby="textHelp" placeholder="">
                                                        <div>
                                                            @error('data.tuition_fee')
                                                                {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label for="exampleInputtext1" class="form-label">جنسیت *</label>
                                                            <select id="" class="form-control"
                                                                wire:model.live="data.gender">
                                                                <option value="">انتخاب نمایید</option>
                                                                @foreach ($genders as $key => $value)
                                                                    <option value="{{ $key }}">{{ $value  }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div>
                                                                @error('data.gender')
                                                                    {{ $message }}
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="exampleInputtext1" class="form-label">ترم
                                                            *</label>
                                                        <input type="number" class="form-control"
                                                            wire:model.live.debounce.800ms="data.term_number" id="exampleInputtext1" min="1"
                                                            aria-describedby="textHelp" placeholder="">
                                                        <div>
                                                            @error('data.term_number')
                                                                {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-6">
                                                    <div class="mb-3" wire:ignore>
                                                        <label for="exampleInputtext1" class="form-label">انتخاب دانش آموزان</label>
                                                        <select id="" class="form-control select2" multiple
                                                            onchange="livewireSelect2Multi('data.students', this)">
                                                            <option value="">انتخاب نمایید</option>
                                                            @foreach ($students as $key => $value)
                                                                <option value="{{ $value->id }}">
                                                                    {{ $value->full_name }} ({{  $value->national_code  }})</option>
                                                            @endforeach
                                                        </select>
                                                        <div>
                                                            @error('data.students')
                                                                {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label for="exampleInputtext1" class="form-label">شماره کلاس( حرف کلاس)</label>
                                                            <select id="" class="form-control"
                                                                wire:model.live="data.class_number">
                                                                <option value="">انتخاب نمایید</option>
                                                                <option value="kids">Kids</option>
                                                                <option value="بوفه">بوفه</option>
                                                                @foreach (range('A', 'N') as $key => $value)
                                                                    <option value="{{ $value }}">{{ $value  }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div>
                                                                @error('data.class_number')
                                                                    {{ $message }}
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
</div>


@push('scripts')
    <script>
        $(document).ready(function () {

            $(`#register_date`).pDatepicker({
                    format: 'YYYY-MM-DD',
                    autoClose: true,
                    onSelect: function(unix) {
                        var propertyName = $(this).data('property');
                        console.log(propertyName);
                        @this.set(`data.register_date`, new persianDate(unix).format('YYYY-MM-DD'), true);
                    }
                });
            $(`#date_start`).pDatepicker({
                    format: 'YYYY-MM-DD',
                    autoClose: true,
                    onSelect: function(unix) {
                        var propertyName = $(this).data('property');
                        console.log(propertyName);
                        @this.set(`data.date_start`, new persianDate(unix).format('YYYY-MM-DD'), true);
                    }
                });
            $(`#date_end`).pDatepicker({
                format: 'YYYY-MM-DD',
                autoClose: true,
                onSelect: function(unix) {
                    var propertyName = $(this).data('property');
                    console.log(propertyName);
                    @this.set(`data.date_end`, new persianDate(unix).format('YYYY-MM-DD'), true);
                }
            });
            $(`#time_start`).pDatepicker({
                    format: 'HH:mm',
                    autoClose: true,
                    onlyTimePicker : true,
                    initialValue : true,
                    timePicker : {
                        enabled: true,
                        second: {
                            enabled: false
                        }
                    },
                    onSelect: function(unix) {
                        var propertyName = $(this).data('property');
                        console.log(propertyName);
                        @this.set(`data.time_start`, new persianDate(unix).format('HH:mm'), true);
                    }
                });
            $(`#time_end`).pDatepicker({
                format: 'HH:mm',
                autoClose: true,
                onlyTimePicker : true,
                timePicker : {
                    enabled: true,
                    second: {
                        enabled: false
                    }
                },
                onSelect: function(unix) {
                    var propertyName = $(this).data('property');
                    console.log(propertyName);
                    @this.set(`data.time_end`, new persianDate(unix).format('HH:mm'), true);
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