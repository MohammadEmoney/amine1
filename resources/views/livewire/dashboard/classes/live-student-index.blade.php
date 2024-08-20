<div dir="rtl">
    <div class="row justify-content-center">
        <div class="col-md-10 col-12">
            <div class="card">
                <div class="card-body">
                    <form>
                        <div class="row justify-content-center mb-3">
                            <div class="col-12 border bg-ac-secondary text-white" wire:click="sub">
                                <p class="p-2 text-center fs-5">اسامی دانش آموزان کلاس
                                    {{ $semester->course->title_with_part }}</p>
                            </div>
                            <div class="container mt-3 mb-4">
                                <div class="col-lg-12 mt-4 mt-lg-0">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="user-dashboard-info-box table-responsive mb-0 p-4 shadow-sm">
                                                <table class="table table-hover manage-candidates-top mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>نام دانش آموز</th>
                                                            <th class="action text-left"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($students ?: [] as $student)
                                                        <tr class="candidates-list">
                                                            <td class="title p-3">
                                                                <div class="thumb">
                                                                    <img class="img-fluid"
                                                                        src="{{ $student->getFirstMediaUrl('personal_image') ?: asset('panel/src/assets/images/profile/avatar_placeholder.png') }}"
                                                                        alt="{{ $student->full_name }}">
                                                                </div>
                                                                <div class="candidate-list-details">
                                                                    <div class="candidate-list-info">
                                                                        <div class="candidate-list-title">
                                                                            <h5 class="mb-0"><a href="#">{{
                                                                                    $student->full_name }}</a>
                                                                            </h5>
                                                                        </div>
                                                                        <div class="candidate-list-option">
                                                                            <ul class="list-unstyled">
                                                                                <li class="border-start">نام پدر:
                                                                                    <span class="fw-bolder">{{
                                                                                        $student->userInfo?->father_name
                                                                                        }}</span>
                                                                                </li>
                                                                                <li>کد ملی: <span class="fw-bolder">{{
                                                                                        $student->national_code
                                                                                        }}</span>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <ul
                                                                    class="list-unstyled mb-0 d-flex justify-content-end">
                                                                    <li>
                                                                        <i class="cursor-pointer far fa-trash-alt text-danger ms-2"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-placement="top"
                                                                            onclick="Custom.deleteItemList({{ $student->id }})"
                                                                            title="حذف"></i>
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            @if($add)
                            <div class="col-md-8">
                                <div class="mb-3" wire:ignore>
                                    <label for="exampleInputtext1" class="form-label">انتخاب دانش آموزان</label>
                                    <select id="students" class="form-control select2" multiple
                                        onchange="livewireSelect2Multi('data.selected_students', this)">
                                        <option value="">انتخاب نمایید</option>
                                        @foreach ($allStudents as $key => $value)
                                        <option value="{{ $value->id }}">
                                            {{ $value->full_name }} (کدملی: {{ $value->national_code }} | نام پدر: {{ $value->userInfo?->father_name ?: "-" }})</option>
                                        @endforeach
                                    </select>
                                    <div>
                                        @error('data.selected_students')
                                        {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 d-grid">
                                <button class="btn btn-ac-primary" type="button" wire:click="submit()">ثبت
                                    <i class="ti ti-plus"></i></button>
                            </div>
                            @else
                            <div class="col-md-6 d-grid">
                                <button class="btn btn-ac-primary" type="button" wire:click="enableAdd()">افزودن دانش
                                    آموز
                                    <i class="ti ti-plus"></i></button>
                            </div>
                            @endif
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
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

@script
    <script>
        $wire.on('select2Initiation', () => {
            $(document).ready(function () {
                $('.select2').select2({
                    placeholder: 'انتخاب کنید',
                    dir: 'rtl',
                    containerCssClass: 'select-sm',
                    allowClear: !0
                });
            });
        })
    </script>
@endscript