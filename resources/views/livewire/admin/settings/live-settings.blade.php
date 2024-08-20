<div class="container-fluid">
    <livewire:admin.components.live-breadcrumb :items="[['title' => $title]]" />
    <div class="card">
        <div class="card-body">
            <h3 class="">{{ $title }}</h3>
            <div class="row justify-content-center w-100">
                <div class="col-md-12">
                    <!-- Ends -->
                    <!-- Section -->
                    <section class="bg-light py-5">
                        <div class="container">
                            <!-- Row -->
                            <div class="row">
                                <!-- Column -->
                                <div class="col">
                                    <!-- Tabs Links -->
                                    <ul class="nav nav-pills" role="tablist" wire:ignore>
                                        <!-- Tabs Links --> <!-- querySelector class // *** mouse-enter1 *** --> 
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active mouse-enter1" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">{{ __('global.general') }}</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link mouse-enter1" id="pills-customize-tab" data-bs-toggle="pill" data-bs-target="#pills-customize" type="button" role="tab" aria-controls="pills-customize" aria-selected="false">{{ __('global.customize') }}</button>
                                        </li>
                                        {{-- <li class="nav-item" role="presentation">
                                            <button class="nav-link mouse-enter1" id="pills-contact-us-tab" data-bs-toggle="pill" data-bs-target="#pills-contact-us" type="button" role="tab" aria-controls="pills-contact-us" aria-selected="false">{{ __('global.contact_us') }}</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link mouse-enter1" id="pills-cooperation-tab" data-bs-toggle="pill" data-bs-target="#pills-cooperation" type="button" role="tab" aria-controls="pills-cooperation" aria-selected="false">{{ __('global.cooperation') }}</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link mouse-enter1" id="pills-agency-tab" data-bs-toggle="pill" data-bs-target="#pills-agency" type="button" role="tab" aria-controls="pills-agency" aria-selected="false">{{ __('global.agency') }}</button>
                                        </li> --}}
                                    </ul>
                                    <!-- Tabs Content -->
                                    <div class="tab-content bg-white p-4">
                                        <div class="tab-pane fade show active" wire:ignore.self id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                            <div class="row justify-content-center w-100">
                                                <div class="col-md-12">
                                                    <div class="card mb-3 mt-3">
                                                        <div class="card-body">
                                                            <form wire:submit.prevent="submit" autocomplete="off">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label for="exampleInputtext1" class="form-label">{{ __('global.title') }}
                                                                                *</label>
                                                                            <input type="text" class="form-control"
                                                                                wire:model.blur="data.title" id="exampleInputtext1"
                                                                                aria-describedby="textHelp" placeholder="{{ __('global.title') }}">
                                                                            <div>
                                                                                @error('data.title')
                                                                                    {{ $message }}
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label for="email" class="form-label">{{ __('global.email') }}
                                                                                *</label>
                                                                            <input type="email" class="form-control"
                                                                                wire:model.live.debounce.800ms="data.email" id="email"
                                                                                aria-describedby="textHelp" placeholder="{{ __('global.email') }}">
                                                                            <div>
                                                                                @error('data.email')
                                                                                    {{ $message }}
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label for="phone" class="form-label">{{ __('global.phone_number') }}
                                                                                *</label>
                                                                            <input type="text" class="form-control" dir="ltr"
                                                                                wire:model.live.debounce.800ms="data.phone" id="phone"
                                                                                aria-describedby="textHelp" placeholder="{{ __('global.phone_number') }}">
                                                                            <div>
                                                                                @error('data.phone')
                                                                                    {{ $message }}
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label for="second_phone" class="form-label">{{ __('global.second_phone_number') }}
                                                                                *</label>
                                                                            <input type="text" class="form-control" dir="ltr"
                                                                                wire:model.live.debounce.800ms="data.second_phone" id="second_phone"
                                                                                aria-describedby="textHelp" placeholder="{{ __('global.second_phone_number') }}">
                                                                            <div>
                                                                                @error('data.second_phone')
                                                                                    {{ $message }}
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label for="landline" class="form-label">{{ __('global.landline') }}
                                                                                *</label>
                                                                            <input type="text" class="form-control" dir="ltr"
                                                                                wire:model.live.debounce.800ms="data.landline" id="landline"
                                                                                aria-describedby="textHelp" placeholder="{{ __('global.landline') }}">
                                                                            <div>
                                                                                @error('data.landline')
                                                                                    {{ $message }}
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label for="second_landline" class="form-label">{{ __('global.second_landline') }}
                                                                                *</label>
                                                                            <input type="text" class="form-control" dir="ltr"
                                                                                wire:model.live.debounce.800ms="data.second_landline" id="second_landline"
                                                                                aria-describedby="textHelp" placeholder="{{ __('global.second_landline') }}">
                                                                            <div>
                                                                                @error('data.second_landline')
                                                                                    {{ $message }}
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                
                                                                {{-- <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="exampleInputtext1" class="form-label">{{ __('global.open_days') }}</label>
                                                                        <select id="open_days" class="form-control"
                                                                            wire:model.live="data.open_days">
                                                                            <option value="">{{ __('global.select_item') }}</option>
                                                                            @foreach ($weekDays as $key => $value)
                                                                                <option value="{{ $key }}">{{ $value }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-3 mb-3">
                                                                        <label for="exampleInputtext1" class="form-label">{{ __('global.open_hours_start') }}</label>
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <select id="open_hours_start_minute" class="form-control"
                                                                                    wire:model.live="data.open_hours_start_minute">
                                                                                    @foreach (range(0, 59) as $value)
                                                                                        @php
                                                                                            $value = str_pad($value, 2, '0', STR_PAD_LEFT);
                                                                                        @endphp
                                                                                        <option value="{{ $value }}">{{ $value }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <select id="open_hours_start_hour" class="form-control"
                                                                                    wire:model.live="data.open_hours_end_hour">
                                                                                    @foreach (range(1, 24) as $key => $value)
                                                                                        @php
                                                                                            $value = str_pad($value, 2, '0', STR_PAD_LEFT);
                                                                                        @endphp
                                                                                        <option value="{{ $value }}">{{ $value }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> --}}
                
                                                                {{-- <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="exampleInputtext1" class="form-label">{{ __('global.lang') }}</label>
                                                                            <select id="langs" class="form-control"
                                                                                wire:model.live="data.lang">
                                                                                <option value="">{{ __('global.select_item') }}</option>
                                                                                @foreach ($langs as $key => $value)
                                                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                    </div>
                                                                    <div class="col-md-6 mb-3">
                                                                        <div class="">
                                                                            <label for="exampleInputtext1" class="form-label">{{ __('global.timezone') }}</label>
                                                                            <select id="categories" class="form-control">
                                                                                <option value="">{{ __('global.select_item') }}</option>
                                                                                @foreach (\App\Enums\EnumTimeZone::getTranslatedAll() as  $value)
                                                                                    <option value="{{ $value }}"
                                                                                        @selected($value==($data['timezone']??''))>
                                                                                        {{ $value }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div>
                                                                            @error('data.timezone')
                                                                                {{ $message }}
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div> --}}
                    
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label for="formFile" class="form-label">{{ __('global.logo') }}</label>
                                                                            <input class="form-control" wire:model.live="data.logo" type="file" id="formFile">
                                                                            <div>
                                                                                @error('data.logo')
                                                                                    {{ $message }}
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        @if (isset($data['logo']) && !empty($data['logo']))
                                                                            @if(method_exists($data['logo'], 'temporaryUrl'))
                                                                                <div class="col-md-12 px-5 mb-3">
                                                                                    <img src="{{ $data['logo']->temporaryUrl() }}" class="w-100">
                                                                                </div>
                                                                            @else
                                                                                <div class="col-md-12 px-5 mb-3">
                                                                                    <img src="{{ $data['logo']->getUrl() }}" class="w-100">
                                                                                    <span class="fs-4 position-absolute text-danger cursor-pointer" wire:click="deleteMedia({{ $data['logo']->id }}, 'logo')"><i class="ti ti-trash"></i></span>
                                                                                </div>
                                                                            @endif
                                                                        @endif
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label for="formFile" class="form-label">{{ __('global.favicon') }}</label>
                                                                            <input class="form-control" wire:model.live="data.favicon" type="file" id="formFile">
                                                                            <div>
                                                                                @error('data.favicon')
                                                                                    {{ $message }}
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        @if (isset($data['favicon']) && !empty($data['favicon']))
                                                                            @if(method_exists($data['favicon'], 'temporaryUrl'))
                                                                                <div class="col-md-12 px-5 mb-3">
                                                                                    <img src="{{ $data['favicon']->temporaryUrl() }}" style="max-width: 100px">
                                                                                </div>
                                                                            @else
                                                                                <div class="col-md-12 px-5 mb-3">
                                                                                    <img src="{{ $data['favicon']->getUrl() }}" style="max-width: 100px">
                                                                                    <span class="fs-4 position-absolute text-danger cursor-pointer" wire:click="deleteMedia({{ $data['favicon']->id }}, 'favicon')"><i class="ti ti-trash"></i></span>
                                                                                </div>
                                                                            @endif
                                                                        @endif
                                                                    </div>
                                                                </div>
                    
                                                                <div class="row">     
                                                                    <div class="col-md-12 mb-3" wire:ignore>
                                                                        <label for="address" class="form-label">{{ __('global.address') }}</label>
                                                                        <textarea id="address" class="form-control" cols="30" rows="10" wire:model.live="data.address"></textarea>
                                                                    </div>
                                                                    <div>
                                                                        @error('data.address')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row">     
                                                                    <div class="col-md-12 mb-3" wire:ignore>
                                                                        <label for="about_us" class="form-label">{{ __('global.about_us') }}</label>
                                                                        <textarea id="about_us" class="form-control" cols="30" rows="10" wire:model.live="data.about_us">{!! $data['about_us'] ?? "" !!}</textarea>
                                                                    </div>
                                                                    <div>
                                                                        @error('data.about_us')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <button type="submit"
                                                                            class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-0">
                                                                            <span class="spinner-border spinner-border-sm"
                                                                                wire:loading></span> {{ __('global.submit') }}
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" wire:ignore.self id="pills-customize" role="tabpanel" aria-labelledby="pills-customize-tab">
                                            <div class="row justify-content-center w-100">
                                                <div class="col-md-12">
                                                    <form wire:submit.prevent="submit">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">آهنگ پس زمینه داشبورد</label>
                                                                    <div class="form-check form-switch d-flex ps-0 flex-row-reverse justify-content-end">
                                                                        <label class="form-check-label" for="flexSwitchCheckDefault">{{ __('global.inactive') }}</label>
                                                                        <input class="form-check-input mx-2" type="checkbox" role="switch" id="flexSwitchCheckDefault" wire:model.defer="personalSetting.is_active_music">
                                                                        <label class="form-check-label" for="flexSwitchCheckDefault">{{ __('global.active') }}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <button type="submit"
                                                                    class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-0">
                                                                    <span class="spinner-border spinner-border-sm"
                                                                        wire:loading></span> {{ __('global.submit') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="tab-pane fade" wire:ignore.self id="pills-contact-us" role="tabpanel" aria-labelledby="pills-contact-us-tab">
                                            <div class="row justify-content-center w-100">
                                                <div class="col-md-12">
                                                    <form wire:submit.prevent="submit">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputtext1" class="form-label">{{ __('global.title') }}
                                                                        *</label>
                                                                    <input type="text" class="form-control"
                                                                        wire:model.blur="data.contact_us.title" id="exampleInputtext1"
                                                                        aria-describedby="textHelp" placeholder="{{ __('global.title') }}">
                                                                    <div>
                                                                        @error('data.contact_us.title')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="formFile" class="form-label">{{ __('global.background') }}</label>
                                                                    <input class="form-control" wire:model.live="data.contact_us_bg" type="file" id="formFile">
                                                                    <div>
                                                                        @error('data.contact_us_bg')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                @if (isset($data['contact_us_bg']) && !empty($data['contact_us_bg']))
                                                                    @if(method_exists($data['contact_us_bg'], 'temporaryUrl'))
                                                                        <div class="col-md-12 px-5 mb-3">
                                                                            <img src="{{ $data['contact_us_bg']->temporaryUrl() }}" class="w-100">
                                                                        </div>
                                                                    @else
                                                                        <div class="col-md-12 px-5 mb-3">
                                                                            <img src="{{ $data['contact_us_bg']->getUrl() }}" class="w-100">
                                                                            <span class="fs-4 position-absolute text-danger cursor-pointer" wire:click="deleteMedia({{ $data['contact_us_bg']->id }}, 'contact_us_bg')"><i class="ti ti-trash"></i></span>
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="row">     
                                                            <div class="col-md-12 mb-3" wire:ignore>
                                                                <label for="contact_us_description" class="form-label">{{ __('global.description') }}</label>
                                                                <textarea id="contact_us_description" class="form-control" cols="30" rows="10" wire:model.live="data.contact_us.description">{!! $data['contact_us']['description'] ?? null !!}</textarea>
                                                            </div>
                                                            <div>
                                                                @error('data.contact_us.description')
                                                                    {{ $message }}
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <button type="submit"
                                                                    class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-0">
                                                                    <span class="spinner-border spinner-border-sm"
                                                                        wire:loading></span> {{ __('global.submit') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" wire:ignore.self id="pills-cooperation" role="tabpanel" aria-labelledby="pills-cooperation-tab">
                                            <div class="row justify-content-center w-100">
                                                <div class="col-md-12">
                                                    <form wire:submit.prevent="submit">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputtext1" class="form-label">{{ __('global.title') }}
                                                                        *</label>
                                                                    <input type="text" class="form-control"
                                                                        wire:model.blur="data.cooperation.title" id="exampleInputtext1"
                                                                        aria-describedby="textHelp" placeholder="{{ __('global.title') }}">
                                                                    <div>
                                                                        @error('data.cooperation.title')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="formFile" class="form-label">{{ __('global.background') }}</label>
                                                                    <input class="form-control" wire:model.live="data.cooperation_bg" type="file" id="formFile">
                                                                    <div>
                                                                        @error('data.cooperation_bg')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                @if (isset($data['cooperation_bg']) && !empty($data['cooperation_bg']))
                                                                    @if(method_exists($data['cooperation_bg'], 'temporaryUrl'))
                                                                        <div class="col-md-12 px-5 mb-3">
                                                                            <img src="{{ $data['cooperation_bg']->temporaryUrl() }}" class="w-100">
                                                                        </div>
                                                                    @else
                                                                        <div class="col-md-12 px-5 mb-3">
                                                                            <img src="{{ $data['cooperation_bg']->getUrl() }}" class="w-100">
                                                                            <span class="fs-4 position-absolute text-danger cursor-pointer" wire:click="deleteMedia({{ $data['cooperation_bg']->id }}, 'cooperation_bg')"><i class="ti ti-trash"></i></span>
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="row">     
                                                            <div class="col-md-12 mb-3" wire:ignore>
                                                                <label for="cooperation_description" class="form-label">{{ __('global.description') }}</label>
                                                                <textarea id="cooperation_description" class="form-control" cols="30" rows="10" wire:model.live="data.cooperation.description">{!! $data['cooperation']['description'] ?? "" !!}</textarea>
                                                            </div>
                                                            <div>
                                                                @error('data.cooperation.description')
                                                                    {{ $message }}
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <button type="submit"
                                                                    class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-0">
                                                                    <span class="spinner-border spinner-border-sm"
                                                                        wire:loading></span> {{ __('global.submit') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" wire:ignore.self id="pills-agency" role="tabpanel" aria-labelledby="pills-agency-tab">
                                            <div class="row justify-content-center w-100">
                                                <div class="col-md-12">
                                                    <form wire:submit.prevent="submit">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputtext1" class="form-label">{{ __('global.title') }}
                                                                        *</label>
                                                                    <input type="text" class="form-control"
                                                                        wire:model.blur="data.agency.title" id="exampleInputtext1"
                                                                        aria-describedby="textHelp" placeholder="{{ __('global.title') }}">
                                                                    <div>
                                                                        @error('data.agency.title')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="formFile" class="form-label">{{ __('global.background') }}</label>
                                                                    <input class="form-control" wire:model.live="data.agency_bg" type="file" id="formFile">
                                                                    <div>
                                                                        @error('data.agency_bg')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                @if (isset($data['agency_bg']) && !empty($data['agency_bg']))
                                                                    @if(method_exists($data['agency_bg'], 'temporaryUrl'))
                                                                        <div class="col-md-12 px-5 mb-3">
                                                                            <img src="{{ $data['agency_bg']->temporaryUrl() }}" class="w-100">
                                                                        </div>
                                                                    @else
                                                                        <div class="col-md-12 px-5 mb-3">
                                                                            <img src="{{ $data['agency_bg']->getUrl() }}" class="w-100">
                                                                            <span class="fs-4 position-absolute text-danger cursor-pointer" wire:click="deleteMedia({{ $data['agency_bg']->id }}, 'agency_bg')"><i class="ti ti-trash"></i></span>
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="row">     
                                                            <div class="col-md-12 mb-3" wire:ignore>
                                                                <label for="agency_description" class="form-label">{{ __('global.description') }}</label>
                                                                <textarea id="agency_description" class="form-control" cols="30" rows="10" wire:model.live="data.agency.description">{!! $data['agency']['description'] ?? "" !!}</textarea>
                                                            </div>
                                                            <div>
                                                                @error('data.agency.description')
                                                                    {{ $message }}
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <button type="submit"
                                                                    class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-0">
                                                                    <span class="spinner-border spinner-border-sm"
                                                                        wire:loading></span> {{ __('global.submit') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Ends -->
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    @include('admin.components.ckeditor', ['selectorIds' => [
            'lang' => 'fa',
            'about_us' => 'about_us',
            'contact_us.description' => 'contact_us_description',
            'cooperation.description' => 'cooperation_description',
            'agency.description' => 'agency_description',
        ]])
@endpush