<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <h5 class="card-title fw-semibold mb-4">دوره ها</h5>
            <button class="btn btn-sm btn-ac-info" wire:click="create">ایجاد دوره</button>
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
                        <th scope="col">نام دوره</th>
                        <th scope="col">دسته بندی والد</th>
                        <th scope="col">نوع دوره</th>
                        <th scope="col">رده سنی</th>
                        <th scope="col">الویت</th>
                        <th scope="col">قیمت (تومان)</th>
                        {{-- <th scope="col">قیمت فروش (تومان)</th> --}}
                        <th scope="col">عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $key => $course)
                        <tr>
                            <th scope="row">{{  ($courses->currentpage()-1) * $courses->perpage() + $key + 1 }}</th>
                            <td>{{ $course->title }}{{ $course->part_number ? " / $course->part_number" : "" }}</td>
                            <td>{{ $course->parent?->title ?: "-" }}</td>
                            <td>{{ \App\Enums\EnumCourseTypes::trans($course->type) }}</td>
                            <td>{{ \App\Enums\EnumCourseAges::trans($course->age) }}</td>
                            <td>{{ $course->priority }}</td>
                            <td>{{ number_format($course->price) }}</td>
                            {{-- <td>{{ number_format($course->sale_price) }}</td> --}}
                            <td class="text-nowrap">
                                <i class="cursor-pointer ti ti-trash text-danger ms-2" data-bs-toggle="tooltip" data-bs-placement="top" onclick="Custom.deleteItemList({{$course->id}})" title="حذف"></i>
                                <i class="cursor-pointer ti ti-pencil text-warning ms-2" data-bs-toggle="tooltip" data-bs-placement="top" wire:click="edit({{ $course->id }})" title="ویرایش"></i>
                                {{-- <i class="cursor-pointer ti ti-eye" data-bs-toggle="tooltip" data-bs-placement="top" wire:click="show({{ $course->id }})" title="نمایش"></i> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $courses->links() }}
        </div>
    </div>
</div>
