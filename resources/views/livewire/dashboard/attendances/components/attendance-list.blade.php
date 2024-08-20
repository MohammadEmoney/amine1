<div class="container">
    <div class="employee-container">
        <div class="row">
            @if ($attendances->count())
                <div class="table-responsive mt-4">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">کلاس</th>
                                <th scope="col">تاریخ</th>
                                <th scope="col">شروع کلاس</th>
                                <th scope="col">عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attendances as $key => $attendance)
                                <tr>
                                    <th scope="row">{{  ($attendances->currentpage()-1) * $attendances->perpage() + $key + 1 }}</th>
                                    <td>{{ $attendance->semester?->title }} ({{ $attendance->semester?->teacher?->full_name }})</td>
                                    <td>{{ \Morilog\Jalali\Jalalian::fromDateTime($attendance->date)->format('Y-m-d') }}</td>
                                    <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $attendance->time_start)->format('H:i') }}</td>
                                    <td>
                                        <i class="cursor-pointer ti ti-pencil" data-bs-toggle="tooltip" data-bs-placement="top" wire:click="edit({{ $attendance->id }})" title="ویرایش"></i>
                                        <i class="cursor-pointer ti ti-trash text-danger ms-2" data-bs-toggle="tooltip" data-bs-placement="top" onclick="Custom.deleteItemList({{$attendance->id}})" title="حذف"></i>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $attendances->links() }}
                </div>
            @else
                <p class="text-center"> هیچ کلاسی یافت نشد. <i class="ti ti-alert-piangle"></i></p>
            @endif
        </div>
    </div>
</div>