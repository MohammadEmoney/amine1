<div class="container-fluid">
    <livewire:admin.components.live-breadcrumb :items="[['title' => 'لیست سوال ها', 'route' => route('admin.evaluations.index')], ['title' => 'ویرایش سوال']]" />
    <div class="card">
        <div class="card-body">
            <h3 class="">ویرایش سوال</h3>
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
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="exampleInputtext1" class="form-label">عنوان سوال
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
                                                <div class="col-md-6">
                                                    <label for="exampleInputtext1" class="form-label">انتخاب کلاس*</label>
                                                    <div class="mb-3" wire:ignore>
                                                        <select id="semeterId" class="form-control select2"
                                                            onchange="livewireSelect2('data.semester_id', this)">
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
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="exampleInputtext1" class="form-label">نمره کل
                                                            *</label>
                                                        <input type="number" class="form-control"
                                                            wire:model.live.debounce.800ms="data.total_value" id="exampleInputtext1" min="0"
                                                            aria-describedby="textHelp" placeholder="">
                                                        <div>
                                                            @error('data.total_value')
                                                                {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="row justify-content-center">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label for="formFile" class="form-label">تصویر سوال
                                                                </label>
                                                            <input class="form-control"
                                                                wire:model.live="data.mainImage"
                                                                type="file" id="formFile">
                                                        </div>
                                                    </div>
                                                    @if (isset($data['mainImage']))
                                                        @if(method_exists($data['mainImage'], 'temporaryUrl'))
                                                            <div class="col-md-6 px-5 mb-3">
                                                                <img src="{{ $data['mainImage']->temporaryUrl() }}" class="w-100">
                                                            </div>
                                                        @else
                                                            <div class="col-md-6 px-5 mb-3">
                                                                <img src="{{ $data['mainImage']->getUrl() }}" class="w-100">
                                                                <span class="fs-4 position-absolute text-danger cursor-pointer" wire:click="deleteMedia({{ $data['mainImage']->id }}, 'mainImage')"><i class="ti ti-trash"></i></span>
                                                            </div>
                                                        @endif
                                                    @endif
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
                                                    <button type="submit"
                                                        class="btn btn-dark w-100 py-8 fs-4 mb-4 rounded-0">
                                                        <span class="spinner-border spinner-border-sm"
                                                            wire:loading></span> ویرایش اطلاعات
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
@include('admin.components.ckeditor', ['selectorIds' => ['description' => 'description']])
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                placeholder: 'انتخاب کنید',
                dir: 'rtl',
                containerCssClass: 'select-sm',
                allowClear: !0
            });
            $('#semeterId').val({{ $data['semester_id'] }}).trigger('change');
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