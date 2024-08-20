<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <h5 class="card-title fw-semibold mb-4">کاربران</h5>
            <button class="btn btn-sm btn-ac-info" wire:click="create('{{ $type }}')">ایجاد {{ $type == "student" ? "دانش آموز" : "کادر اداری" }}</button>
        </div>
        <div class="table-responsive">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" class="form-control border-info" wire:model.live.debounce.600="search" placeholder="جستجو ...">
                </div>
                <div class="col-md-2">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFilter" wire:ignore>
                                <button class="accordion-button collapsed p-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFilter" aria-expanded="false" aria-controls="collapseFilter">
                                    فیلتر:
                                </button>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row my-3">
                <div class="col-md-12">
                    <div id="collapseFilter" class="accordion-collapse collapse" aria-labelledby="headingFilter" data-bs-parent="#accordionExample" wire:ignore.self>
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <button class="btn btn-info" wire:click="resetFilter()" type="button">ریست فیلتر</button>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" wire:model.live="filters.is_foreigner" type="checkbox" role="switch" id="is_foreigner">
                                        <label class="form-check-label" for="is_foreigner">اتباع خارجی</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" wire:model.live="filters.dropout" type="checkbox" role="switch" id="dropout">
                                        <label class="form-check-label" for="dropout">ریزشی</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" wire:model.live="filters.has_personal_image" type="checkbox" role="switch" id="has_personal_image">
                                        <label class="form-check-label" for="has_personal_image">بدون عکس</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" wire:model.live="filters.has_national_card_image" type="checkbox" role="switch" id="has_personal_image">
                                        <label class="form-check-label" for="has_personal_image">بدون کپی شناسنامه</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="exampleInputtext1" class="form-label"></label>
                                        <select id="" class="form-control @error('filters.preferd_course') invalid-input @enderror"
                                            wire:model.live="filters.preferd_course">
                                            <option value="">دوره ها</option>
                                            @foreach ($courses as $value)
                                                <option value="{{ $value->id }}">
                                                    {{ $value->title_with_part }} ({{ \App\Enums\EnumCourseTypes::trans($value->type) }} / {{ \App\Enums\EnumCourseAges::trans($value->age) }})</option>
                                            @endforeach
                                        </select>
                                        <div>
                                            @error('filters.preferd_course')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">نام و نام خانوادگی</th>
                        <th scope="col">کد ملی</th>
                        <th scope="col">تلفن ثابت</th>
                        <th scope="col">شماره همراه 1</th>
                        <th scope="col">شماره همراه 2</th>
                        <th scope="col">ایمیل</th>
                        <th scope="col">آدرس</th>
                        <th scope="col">نقش کاربر</th>
                        <th scope="col">تاریخ ثبت نام</th>
                        <th scope="col">ریزشی</th>
                        <th scope="col">عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $user)
                        <tr>
                            <th scope="row">{{  ($users->currentpage()-1) * $users->perpage() + $key + 1 }}</th>
                            <td class="text-nowrap cursor-pointer link-primary" wire:click="show({{ $user->id }}, {{ $user->type }})">{{ $user->full_name }}</td>
                            <td class="text-nowrap cursor-pointer link-primary" wire:click="edit({{ $user->id }}, {{ $user->type }})">{{ $user->national_code }}</td>
                            @can('user_view_phone')
                                <td>{{ $user->userInfo?->landline_phone ?: "-" }}</td>
                            @else
                                <td><i class="ti ti-alert-octagon text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="مجاز به دیدن این بخش نمی باشید."></i></td>
                            @endcan
                            @can('user_view_mobile')
                                <td>{{ $user->userInfo?->mobile_1 ?: "-" }}</td>
                                <td>{{ $user->userInfo?->mobile_2 ?: "-" }}</td>
                            @else
                                <td><i class="ti ti-alert-octagon text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="مجاز به دیدن این بخش نمی باشید."></i></td>
                                <td><i class="ti ti-alert-octagon text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="مجاز به دیدن این بخش نمی باشید."></i></td>
                            @endcan
                            @can('user_view_email')
                                <td>{{ $user->userInfo?->email ?: "-" }}</td>
                            @else
                                <td><i class="ti ti-alert-octagon text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="مجاز به دیدن این بخش نمی باشید."></i></td>
                            @endcan
                            @can('user_view_address')
                                <td><span class="d-inline-block text-truncate" style="max-width: 100px;" title="{{ $user->userInfo?->address ?: "-" }}">{{ $user->userInfo?->address ?: "-" }}</span></td>
                            @else
                                <td><i class="ti ti-alert-octagon text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="مجاز به دیدن این بخش نمی باشید."></i></td>
                            @endcan
                            <td class="text-nowrap">{{ $user->getRoleNames()?->first() ? \App\Enums\EnumUserRoles::trans($user->getRoleNames()?->first()) : "-" }}</td>
                            <td class="text-nowrap">{{ \Morilog\Jalali\Jalalian::fromDateTime($user->userInfo->register_date)->format('Y-m-d') }}</td>
                            <td class="text-nowrap">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" {{ $user->dropout ? "checked" : "" }} id="dropoutCheckbox">
                                    <label class="form-check-label" for="dropoutCheckbox">
                                    </label>
                                  </div>
                                
                            </td>
                            <td>
                                <div class="text-nowrap">
                                    <i class="cursor-pointer ti ti-trash text-danger ms-2" data-bs-toggle="tooltip" data-bs-placement="top" onclick="Custom.deleteItemList({{$user->id}})" title="حذف"></i>
                                    <i class="cursor-pointer ti ti-pencil text-warning ms-2" data-bs-toggle="tooltip" data-bs-placement="top" wire:click="edit({{ $user->id }}, {{ $user->type }})" title="ویرایش"></i>
                                    <i class="cursor-pointer ti ti-eye" data-bs-toggle="tooltip" data-bs-placement="top" wire:click="show({{ $user->id }}, {{ $user->type }})" title="نمایش"></i>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    </div>
</div>
