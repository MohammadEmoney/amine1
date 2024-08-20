<div class="container-fluid">
    <livewire:admin.components.live-breadcrumb :items="[['title' => 'پیام ها']]" />
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
                <h5 class="card-title fw-semibold mb-4">پیام ها</h5>
                <div>
                    <button class="btn btn-sm btn-ac-primary" wire:click="create('students')">ارسال پیام به دانش آموز</button>
                    <button class="btn btn-sm btn-ac-info" wire:click="create('class')">ارسال پیام یه کلاس</button>
                </div>
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
                            <th scope="col">کلاس / دانش آموز</th>
                            <th scope="col">وضعیت</th>
                            <th scope="col">پیام</th>
                            <th scope="col">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($messages as $key => $message)
                            <tr>
                                <th scope="row">{{  ($messages->currentpage()-1) * $messages->perpage() + $key + 1 }}</th>
                                <td wire:click="edit({{ $message->id }})" class="cursor-pointer">{{ $message->title }}</td>
                                <td>{{ $message->semester?->title ?: $message->users->first()?->full_name }}</td>
                                <td>{{ $message->status }}</td>
                                <td>{{ $message->message }}</td>
                                <td class="text-nowrap">
                                    <i class="cursor-pointer ti ti-trash text-danger ms-2" data-bs-toggle="tooltip" data-bs-placement="top" onclick="Custom.deleteItemList({{$message->id}})" title="حذف"></i>
                                    <i class="cursor-pointer ti ti-pencil text-warning ms-2" data-bs-toggle="tooltip" data-bs-placement="top" wire:click="edit({{ $message->id }})" title="ویرایش"></i>
                                    {{-- <i class="cursor-pointer ti ti-eye" data-bs-toggle="tooltip" data-bs-placement="top" wire:click="show({{ $message->id }})" title="نمایش"></i> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $messages->links() }}
            </div>
        </div>
    </div>
</div>
