<div class="container-fluid" dir="rtl">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
                <h5 class="card-title fw-semibold">سوال ها</h5>
                <button class="btn btn-sm btn-ac-info" wire:click="create">ایجاد سوال</button>
            </div>
            @if ($evaluations?->count())
                <div class="table-responsive mt-4">
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
                                <th scope="col">کلاس</th>
                                <th scope="col">تعداد سوال</th>
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
                                    <td>{{ $evaluation->semester?->title ?: "-" }}</td>
                                    <td>{{ $evaluation->questions_count ?: 0 }}</td>
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
            @else
                <div class="row">
                    <p class="text-center"> هیچ سوالی یافت نشد. <i class="ti ti-alert-piangle"></i></p>
                </div>
            @endif
            
        </div>
    </div>
</div>
