<div class="container-fluid">
    <livewire:admin.components.live-breadcrumb :items="[['title' => 'لیست کتاب ها', 'route' => route('admin.books.index')], ['title' => 'ایجاد کتاب جدید']]" />
    <div class="card">
        <div class="card-body">
            <h3 class="">ایجاد کتاب</h3>
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
                                                        <label for="exampleInputtext1" class="form-label">عنوان کتاب
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
                                                    <div class="mb-3">
                                                        <label for="exampleInputtext1" class="form-label">رده سنی*</label>
                                                        <select id="" class="form-control"
                                                            wire:model.live="data.age">
                                                            <option value="">انتخاب نمایید</option>
                                                            @foreach ($ages as $key => $value)
                                                                <option value="{{ $key }}">
                                                                    {{ $value }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div>
                                                            @error('data.age')
                                                                {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="exampleInputtext1" class="form-label">موجودی
                                                            *</label>
                                                        <input type="number" class="form-control"
                                                            wire:model.live.debounce.800ms="data.inventory" id="exampleInputtext1" min="0"
                                                            aria-describedby="textHelp" placeholder="">
                                                        <div>
                                                            @error('data.inventory')
                                                                {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="exampleInputtext1" class="form-label">مبلغ ( به تومان )
                                                            *</label>
                                                        <input type="number" class="form-control"
                                                            wire:model.live.debounce.800ms="data.price" id="exampleInputtext1"
                                                            aria-describedby="textHelp" placeholder="">
                                                        <div>
                                                            @error('data.price')
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
                                                            <label for="formFile" class="form-label">تصویر کتاب
                                                                *</label>
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
                                                    <div class="mb-3">
                                                        <label for="exampleInputtext1"
                                                            class="form-label">توضیحات</label>
                                                        <textarea class="form-control" wire:model.live="data.description" id="" cols="10" rows="10"
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

