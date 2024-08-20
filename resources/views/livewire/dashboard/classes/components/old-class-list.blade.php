<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">نام دوره</th>
                        <th scope="col">نوع دوره</th>
                        <th scope="col">رده سنی</th>
                        <th scope="col">نام مدرس</th>
                        <th scope="col">شروع ترم</th>
                        <th scope="col">پایان ترم</th>
                        <th scope="col">جنسیت</th>
                        <th scope="col">شهریه (تومان)</th>
                        <th scope="col">عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($semesters as $key => $semester)
                        <tr>
                            <th scope="row">{{  ($semesters->currentpage()-1) * $semesters->perpage() + $key + 1 }}</th>
                            <td class="text-nowrap cursor-pointer" wire:click=showDetails({{ $semester->id }})>{{ $semester->course?->title_with_part ?: "-" }}</td>
                            <td>{{ \App\Enums\EnumCourseTypes::trans($semester->course->type) }}</td>
                            <td>{{ \App\Enums\EnumCourseAges::trans($semester->course->age) }}</td>
                            <td class="text-nowrap">{{ $semester->teacher?->full_name ?: "-" }}</td>
                            <td class="text-nowrap">{{ \Morilog\Jalali\Jalalian::fromDateTime($semester->date_start)->format('Y-m-d') }}</td>
                            <td class="text-nowrap">{{ \Morilog\Jalali\Jalalian::fromDateTime($semester->date_end)->format('Y-m-d') }}</td>
                            <td>{{ \App\Enums\EnumSemesterGender::trans($semester->gender) }}</td>
                            <td>{{ number_format($semester->tuition_fee ?: "-") }}</td>
                            <td class="text-nowrap">
                                <span class="link-primary cursor-pointer" wire:click=showDetails({{ $semester->id }})>جزییات</span>
                                {{-- <i class="cursor-pointer ti ti-trash text-danger ms-2" data-bs-toggle="tooltip" data-bs-placement="top" onclick="Custom.deleteItemList({{$semester->id}})" title="حذف"></i>
                                <i class="cursor-pointer ti ti-pencil text-warning ms-2" data-bs-toggle="tooltip" data-bs-placement="top" wire:click="edit({{ $semester->id }})" title="ویرایش"></i> --}}
                                {{-- <i class="cursor-pointer ti ti-eye" data-bs-toggle="tooltip" data-bs-placement="top" wire:click="show({{ $semester->id }})" title="نمایش"></i> --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center"><p> هیچ دوره ای یافت نشد. <i class="ti ti-alert-triangle"></i></p></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $semesters->links() }}
        </div>
    </div>
</div>