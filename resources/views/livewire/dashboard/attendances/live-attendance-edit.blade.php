<div class="container-fluid" dir="rtl">
    <div class="card">
        <div class="card-body p-1 p-sm-3">
            <h3 class="px-3 px-sm-1">حضور غیاب</h3>
            <div>
                <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
                    data-sidebar-position="fixed" data-header-position="fixed">
                    <div class="d-flex align-items-center justify-content-center w-100">
                        <div class="row justify-content-center w-100">
                            <div class="col-md-12">
                                <form wire:submit.prevent="submit" autocomplete="off">
                                    <div class="card mb-3 mt-3">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="exampleInputtext1" class="form-label">کلاس</label>
                                                        <input type="text" class="form-control" aria-describedby="textHelp" value="{{ $semester->title }}" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="date"
                                                            class="form-label">تاریخ
                                                            *</label>
                                                        <input type="text"
                                                            class="form-control"
                                                            wire:model.live="data.date"
                                                            id="date"
                                                            autocomplete="new-password"
                                                            aria-describedby="textHelp"
                                                            data-date="{{ $data['date'] ?? "" }}" value="{{ $data['date'] ?? "" }}">
                                                        <div>
                                                            @error('data.date')
                                                                {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
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
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control border-info" wire:model.live.debounce.600="search" placeholder="جستجو ...">
                                                </div>
                                            </div>
                                            @if ($students?->count())
                                                <div class="table-responsive mt-4">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">نام دانش آموز</th>
                                                                <th scope="col">عملیات</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($students as $key => $student)
                                                                <tr>
                                                                    <th scope="row">{{  ($students->currentpage()-1) * $students->perpage() + $key + 1 }}</th>
                                                                    <td>{{ $student->full_name }} ({{ $student->national_code }})</td>
                                                                    <td class="text-nowrap">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" wire:model="rollCall.{{ $student->id }}" id="defaultCheck{{ $key }}">
                                                                            <label class="form-check-label" for="defaultCheck{{ $key }}">
                                                                            حاضر
                                                                            </label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    {{ $students->links() }}
                                                </div>
                                            @else
                                                <div class="row">
                                                    <p class="text-center"> کلاس مورد نظر را انتخاب نمایید. <i class="ti ti-alert-piangle"></i></p>
                                                </div>
                                            @endif
                                            
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="submit"
                                                class="btn btn-dark w-100 py-8 fs-4 mb-4 rounded-0">
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

@push('scripts')
    <script>
        $(document).ready(function () {
            $(`#date`).pDatepicker({
                format: 'YYYY-MM-DD',
                autoClose: true,
                initialValue : true,
                initialValueType : 'persian',
                onSelect: function(unix) {
                    var propertyName = $(this).data('property');
                    console.log(propertyName);
                    @this.set(`data.date`, new persianDate(unix).format('YYYY-MM-DD'), true);
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