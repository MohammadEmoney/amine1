<div class="container-fluid">
    <livewire:admin.components.live-breadcrumb :items="[['title' => 'کتاب ها']]" />
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
                <h5 class="card-title fw-semibold mb-4">کتاب ها</h5>
                <button class="btn btn-sm btn-ac-info" wire:click="create">ایجاد کتاب</button>
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
                            <th scope="col">تصویر</th>
                            <th scope="col">نام کتاب</th>
                            <th scope="col">رده سنی</th>
                            <th scope="col">مبلغ (تومان)</th>
                            <th scope="col">موجودی</th>
                            <th scope="col">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($books as $key => $book)
                            <tr>
                                <th scope="row">{{  ($books->currentpage()-1) * $books->perpage() + $key + 1 }}</th>
                                <td><img src="{{ $book->getFirstMediaUrl('mainImage') }}" alt="" class="img-fluid" width="50px"></td>
                                <td wire:click="edit({{ $book->id }})" class="cursor-pointer">{{ $book->title }}</td>
                                <td>{{ __('admin/enums/EnumCourseAges.' . $book->age) }}</td>
                                <td>{{ number_format($book->price) }}</td>
                                <td>{{ $book->inventory }}</td>
                                <td class="text-nowrap">
                                    <i class="cursor-pointer ti ti-trash text-danger ms-2" data-bs-toggle="tooltip" data-bs-placement="top" onclick="Custom.deleteItemList({{$book->id}})" title="حذف"></i>
                                    <i class="cursor-pointer ti ti-pencil text-warning ms-2" data-bs-toggle="tooltip" data-bs-placement="top" wire:click="edit({{ $book->id }})" title="ویرایش"></i>
                                    {{-- <i class="cursor-pointer ti ti-eye" data-bs-toggle="tooltip" data-bs-placement="top" wire:click="show({{ $book->id }})" title="نمایش"></i> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $books->links() }}
            </div>
        </div>
    </div>
</div>
