<div class="container-fluid">
    <livewire:admin.components.live-breadcrumb :items="[['title' => 'حضور غیاب']]" />
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
                <h5 class="card-title fw-semibold mb-4">حضور غیاب</h5>
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
                            <th scope="col">کاربر</th>
                            <th scope="col">کلاس</th>
                            <th scope="col">تاریخ</th>
                            <th scope="col">شروع کلاس</th>
                            <th scope="col">تاریخ ثبت</th>
                            <th scope="col">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attendances as $key => $attendance)
                            <tr>
                                <th scope="row">{{  ($attendances->currentpage()-1) * $attendances->perpage() + $key + 1 }}</th>
                                <td wire:click="show({{ $attendance->semester?->id }})" class="cursor-pointer">{{ $attendance->user?->full_name ?: "-" }}</td>
                                <td wire:click="show({{ $attendance->semester?->id }})" class="cursor-pointer">{{ $attendance->semester?->title }} ({{ $attendance->semester?->teacher?->full_name }})</td>
                                <td wire:click="show({{ $attendance->semester?->id }})" class="cursor-pointer">{{ \Morilog\Jalali\Jalalian::fromDateTime($attendance->date)->format('Y-m-d') }}</td>
                                <td wire:click="show({{ $attendance->semester?->id }})" class="cursor-pointer">{{ \Carbon\Carbon::createFromFormat('H:i:s', $attendance->time_start)->format('h:i') }}</td>
                                <td wire:click="show({{ $attendance->semester?->id }})" class="cursor-pointer">{{ \Morilog\Jalali\Jalalian::fromDateTime($attendance->created_at)->format('Y-m-d ساعت: H:i') }}</td>
                                <td class="text-nowrap">
                                    {{-- <i class="cursor-pointer ti ti-trash text-danger ms-2" data-bs-toggle="tooltip" data-bs-placement="top" onclick="Custom.deleteItemList({{$attendance->id}})" title="حذف"></i> --}}
                                    {{-- <i class="cursor-pointer ti ti-pencil text-warning ms-2" data-bs-toggle="tooltip" data-bs-placement="top" wire:click="edit({{ $attendance->id }})" title="ویرایش"></i> --}}
                                    <i class="cursor-pointer ti ti-eye" data-bs-toggle="tooltip" data-bs-placement="top" wire:click="show({{ $attendance->semester?->id }})" title="نمایش"></i>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $attendances->links() }}
            </div>
        </div>
    </div>
</div>
