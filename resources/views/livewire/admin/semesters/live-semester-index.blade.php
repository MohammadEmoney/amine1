<div class="container-fluid">
    <livewire:admin.components.live-breadcrumb :items="[['title' => 'کلاس ها']]" />
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
                <h5 class="card-title fw-semibold mb-4">کلاس ها</h5>
                <button class="btn btn-sm btn-ac-info" wire:click="create">ایجاد کلاس</button>
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
                            <th scope="col">نام مدرس</th>
                            <th scope="col">نوع دوره</th>
                            <th scope="col">رده سنی</th>
                            {{-- <th scope="col">شروع ثبت نام</th> --}}
                            <th scope="col">شروع ترم</th>
                            <th scope="col">پایان ترم</th>
                            <th scope="col">ساعت و شماره کلاس</th>
                            <th scope="col">شهریه (تومان)</th>
                            <th scope="col">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($semesters as $key => $semester)
                            <tr>
                                <th scope="row">{{  ($semesters->currentpage()-1) * $semesters->perpage() + $key + 1 }}</th>
                                <td wire:click="edit({{ $semester->id }})" class="cursor-pointer text-nowrap">{{ $semester->course?->title_with_part }}</td>
                                <td class="text-nowrap">{{ $semester->teacher->full_name }}</td>
                                <td>{{ \App\Enums\EnumCourseTypes::trans($semester->course?->type) }}</td>
                                <td>{{ \App\Enums\EnumCourseAges::trans($semester->course?->age) }}</td>
                                {{-- <td class="text-nowrap">{{ $semester->register_date ? \Morilog\Jalali\Jalalian::fromDateTime($semester->register_date)->format('Y-m-d') : "-" }}</td> --}}
                                <td class="text-nowrap">{{ \Morilog\Jalali\Jalalian::fromDateTime($semester->date_start)->format('Y-m-d') }}</td>
                                <td class="text-nowrap">{{ \Morilog\Jalali\Jalalian::fromDateTime($semester->date_end)->format('Y-m-d') }}</td>
                                <td class="text-nowrap">{{ $semester->time_start->format("H:i") }} الی {{ $semester->time_end->format("H:i") }} (کلاس: {{ $semester->class_number }})</td>
                                <td>{{ number_format($semester->tuition_fee ?: "-") }}</td>
                                <td class="text-nowrap">
                                    <i class="cursor-pointer ti ti-trash text-danger ms-2" data-bs-toggle="tooltip" data-bs-placement="top" onclick="Custom.deleteItemList({{$semester->id}})" title="حذف"></i>
                                    <i class="cursor-pointer ti ti-pencil text-warning ms-2" data-bs-toggle="tooltip" data-bs-placement="top" wire:click="edit({{ $semester->id }})" title="ویرایش"></i>
                                    {{-- <i class="cursor-pointer ti ti-eye" data-bs-toggle="tooltip" data-bs-placement="top" wire:click="show({{ $semester->id }})" title="نمایش"></i> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $semesters->links() }}
            </div>
        </div>
    </div>
</div>
