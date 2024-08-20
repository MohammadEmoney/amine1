<div>
    <div class="row g-6 mb-6">
        @can('student_status')
            <div class="col-xl-3 col-sm-6 col-12 cursor-pointer" wire:click="redirectTo('admin.users.student.index')">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <span class="h6 font-semibold text-muted text-sm d-block mb-2">دانش آموزان ثبتنام شده</span>
                                <span class="h3 font-bold mb-0">{{ $students }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="fs-5">
                                    <i class="ti ti-users"></i>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="mt-2 mb-0 text-sm">
                            <span class="badge badge-pill bg-soft-success text-success me-2">
                                <i class="bi bi-arrow-up me-1"></i>13%
                            </span>
                            <span class="text-nowrap text-xs text-muted">Since last month</span>
                        </div> --}}
                    </div>
                </div>
            </div>
        @endcan

        @can('staff_status')
            <div class="col-xl-3 col-sm-6 col-12 cursor-pointer" wire:click="redirectTo('admin.users.staff.index')">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <span class="h6 font-semibold text-muted text-sm d-block mb-2">کارمندان ثبتنام شده</span>
                                <span class="h3 font-bold mb-0">{{ $staff }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="fs-5">
                                    <i class="ti ti-users"></i>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="mt-2 mb-0 text-sm">
                            <span class="badge badge-pill bg-soft-success text-success me-2">
                                <i class="bi bi-arrow-up me-1"></i>30%
                            </span>
                            <span class="text-nowrap text-xs text-muted">Since last month</span>
                        </div> --}}
                    </div>
                </div>
            </div>
        @endcan
        @can('course_status')
            <div class="col-xl-3 col-sm-6 col-12 cursor-pointer" wire:click="redirectTo('admin.courses.index')">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <span class="h6 font-semibold text-muted text-sm d-block mb-2">دوره ها</span>
                                <span class="h3 font-bold mb-0">{{ $courses }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="fs-5">
                                    <i class="ti ti-book"></i>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="mt-2 mb-0 text-sm">
                            <span class="badge badge-pill bg-soft-danger text-danger me-2">
                                <i class="bi bi-arrow-down me-1"></i>-5%
                            </span>
                            <span class="text-nowrap text-xs text-muted">Since last month</span>
                        </div> --}}
                    </div>
                </div>
            </div>
        @endcan

        @can('orders_status')
            <div class="col-xl-3 col-sm-6 col-12 cursor-pointer" wire:click="redirectTo('admin.dashboard')">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <span class="h6 font-semibold text-muted text-sm d-block mb-2">سفارش ها</span>
                                <span class="h3 font-bold mb-0">{{ $orders }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="fs-5">
                                    <i class="ti ti-credit-card"></i>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="mt-2 mb-0 text-sm">
                            <span class="badge badge-pill bg-soft-success text-success me-2">
                                <i class="bi bi-arrow-up me-1"></i>10%
                            </span>
                            <span class="text-nowrap text-xs text-muted">Since last month</span>
                        </div> --}}
                    </div>
                </div>
            </div>
        @endcan
    </div>
    <div class="row g-6 mb-6">
        @can('dropout_student_status')
            <div class="col-xl-3 col-sm-6 col-12 cursor-pointer" wire:click="redirectTo('admin.users.student.index')">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <span class="h6 font-semibold text-muted text-sm d-block mb-2">دانش آموزان ریزشی</span>
                                <span class="h3 font-bold mb-0">{{ $dropoutStudents }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="fs-5">
                                    <i class="ti ti-users"></i>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="mt-2 mb-0 text-sm">
                            <span class="badge badge-pill bg-soft-success text-success me-2">
                                <i class="bi bi-arrow-up me-1"></i>13%
                            </span>
                            <span class="text-nowrap text-xs text-muted">Since last month</span>
                        </div> --}}
                    </div>
                </div>
            </div>
        @endcan
        @can('dropout_staff_status')
            <div class="col-xl-3 col-sm-6 col-12 cursor-pointer" wire:click="redirectTo('admin.users.staff.index')">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <span class="h6 font-semibold text-muted text-sm d-block mb-2">کارمندان ریزشی</span>
                                <span class="h3 font-bold mb-0">{{ $dropoutStaff }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="fs-5">
                                    <i class="ti ti-users"></i>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="mt-2 mb-0 text-sm">
                            <span class="badge badge-pill bg-soft-success text-success me-2">
                                <i class="bi bi-arrow-up me-1"></i>30%
                            </span>
                            <span class="text-nowrap text-xs text-muted">Since last month</span>
                        </div> --}}
                    </div>
                </div>
            </div>
        @endcan
        @can('not_active_course_status')
            <div class="col-xl-3 col-sm-6 col-12 cursor-pointer" wire:click="redirectTo('admin.courses.index')">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <span class="h6 font-semibold text-muted text-sm d-block mb-2">دوره های در حال تشکیل</span>
                                <span class="h3 font-bold mb-0">{{ $notActiveCourses }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="fs-5">
                                    <i class="ti ti-book"></i>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="mt-2 mb-0 text-sm">
                            <span class="badge badge-pill bg-soft-danger text-danger me-2">
                                <i class="bi bi-arrow-down me-1"></i>-5%
                            </span>
                            <span class="text-nowrap text-xs text-muted">Since last month</span>
                        </div> --}}
                    </div>
                </div>
            </div>
        @endcan
        @can('waiting_student_status')
            <div class="col-xl-3 col-sm-6 col-12 cursor-pointer" wire:click="redirectTo('admin.users.waiting.index')">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <span class="h6 font-semibold text-muted text-sm d-block mb-2">لیست انتظار</span>
                                <span class="h3 font-bold mb-0">{{ $waitingStudents }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="fs-5">
                                    <i class="ti ti-user-exclamation"></i>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="mt-2 mb-0 text-sm">
                            <span class="badge badge-pill bg-soft-success text-success me-2">
                                <i class="bi bi-arrow-up me-1"></i>10%
                            </span>
                            <span class="text-nowrap text-xs text-muted">Since last month</span>
                        </div> --}}
                    </div>
                </div>
            </div>
        @endcan
    </div>
</div>
