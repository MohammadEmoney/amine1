<div class="container-fluid">
    <livewire:admin.components.live-breadcrumb :items="[['title' => 'لیست حضور غیاب', 'route' => route('admin.attendances.index')], ['title' => 'ویرایش حضور غیاب']]" />
    <div class="card">
        <div class="img-placeholder"></div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-4">
                <h5 class="card-title fw-semibold">{{ $semester->title }}</h5>
            </div>
            <div>
                <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
                            data-sidebar-position="fixed" data-header-position="fixed">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-3 col-6 mb-3 text-center">
                                    نام مدرس: <a href="{{ route('admin.users.student.show', $semester->teacher?->id) }}">{{ $semester->teacher?->full_name }}</a>
                                </div>
                                <div class="col-md-3 col-6 mb-3 text-center">
                                    شماره همراه: <span @cannot('user_view_mobile') class="phone-number" @endcannot dir="ltr">{{ $semester->teacher?->userInfo?->mobile_1 }}</span>
                                </div>
                                <div class="col-md-3 col-6 mb-3 text-center">
                                    کلاس: <a href="{{ route('admin.semesters.edit', $semester->id) }}">{{ $semester->title }}</a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" class="form-control border-info" wire:model.live.debounce.600="search" placeholder="جستجو ...">
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">دانش آموزان</th>
                                            @foreach ($dates as $date)
                                                <th scope="col" class="text-center">{{ $date }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($attendances as $key => $attendance)
                                            <tr>
                                                <td>{{ $attendance['name'] }}</td>
                                                @foreach ($dates as $date)
                                                    <td class="text-center">
                                                        @if (isset($attendance['attendance'][$date]))
                                                            @if ($attendance['attendance'][$date] == 1)
                                                                <i class="fs-5 ti ti-checkbox text-success"></i> <!-- Present Icon -->
                                                            @elseif ($attendance['attendance'][$date] == 0)
                                                                <i class="fs-5 ti ti-xbox-x text-danger"></i> <!-- Absent Icon -->
                                                            @else
                                                                N/A
                                                            @endif
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        $(document).ready(function() {
            $('.phone-number').each(function() {
                var phoneNumber = $(this).text();
                var hiddenNumber = phoneNumber.substring(0, 4) + '*****' + phoneNumber.substring(9);
                $(this).text(hiddenNumber);

                $(this).on('click', function() {
                    window.location.href = 'tel:' + phoneNumber;
                });
            });
            $('.national-code').each(function() {
                var nationalCode = $(this).text();
                var hiddenNumber = nationalCode.substring(0, 4) + '*****' + nationalCode.substring(8);
                $(this).text(hiddenNumber);
            });
        });
    </script>
@endpush
