<div class="container-fluid">
    <livewire:admin.components.live-breadcrumb :items="[['title' => 'سوال ها']]" />
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
                <h5 class="card-title fw-semibold mb-4">سوال ها</h5>
                <button class="btn btn-sm btn-ac-info" wire:click="create">ایجاد سوال</button>
            </div>
            <div class="table-responsive">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" class="form-control border-info" wire:model.live.debounce.600="search" placeholder="جستجو ...">
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">عنوان</th>
                            <th scope="col">نوع</th>
                            <th scope="col">نمره کل</th>
                            <th scope="col">ایجاد توسط</th>
                            <th scope="col">کلاس</th>
                            <th scope="col">تعداد سوال</th>
                            <th scope="col">فعال</th>
                            <th scope="col">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($evaluations as $key => $evaluation)
                            <tr>
                                <th scope="row">{{  ($evaluations->currentpage()-1) * $evaluations->perpage() + $key + 1 }}</th>
                                <td wire:click="edit({{ $evaluation->id }})" class="cursor-pointer">{{ $evaluation->title }}</td>
                                <td>{{ __('admin/enums/EnumEvaluationType.' . $evaluation->type) }}</td>
                                <td>{{ $evaluation->total_value }}</td>
                                <td>{{ $evaluation->user?->full_name ?: "-" }}</td>
                                <td>{{ $evaluation->semester?->title ?: "-" }}</td>
                                <td>{{ $evaluation->questions_count ?: 0 }}</td>
                                <td class="text-nowrap">
                                    <div class="form-switch">
                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" @checked($evaluation->is_active) wire:click="changeActiveStatus({{ $evaluation->id }})">
                                    </div>
                                </td>
                                <td class="text-nowrap">
                                    <i class="cursor-pointer ti ti-trash text-danger ms-2" data-bs-toggle="tooltip" data-bs-placement="top" onclick="Custom.deleteItemList({{$evaluation->id}})" title="حذف"></i>
                                    <i class="cursor-pointer ti ti-pencil text-warning ms-2" data-bs-toggle="tooltip" data-bs-placement="top" wire:click="edit({{ $evaluation->id }})" title="ویرایش"></i>
                                    {{-- <i class="cursor-pointer ti ti-eye" data-bs-toggle="tooltip" data-bs-placement="top" wire:click="show({{ $evaluation->id }})" title="نمایش"></i> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $evaluations->links() }}
            </div>
        </div>
    </div>
</div>
