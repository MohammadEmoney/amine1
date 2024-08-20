<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="{{ route('home') }}" class="text-nowrap logo-img fs-6">
                {{-- <img src="/panel/src/assets/images/logos/dark-logo.svg" width="180" alt="" /> --}}
                {{ $settings['title'] ?? env('APP_NAME') }}
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">خانه</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('admin.dashboard') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-layout-dashboard"></i>
                        </span>
                        <span class="hide-menu">داشبورد</span>
                    </a>
                </li>
                @canany(['user_student_access', 'user_waiting_access', 'user_access', 'user_deleted_access', 'attendance_access'])
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">کاربران</span>
                    </li>
                @endcanany
                @can('user_student_access')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.users.student.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-users"></i>
                            </span>
                            <span class="hide-menu">لیست دانش آموزان</span>
                        </a>
                    </li>
                @endcan
                @can('user_access')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.users.staff.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-users"></i>
                            </span>
                            <span class="hide-menu">لیست کادر اداری و آموزش</span>
                        </a>
                    </li>
                @endcan
                @can('user_waiting_access')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.users.waiting.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-user-exclamation"></i>
                            </span>
                            <span class="hide-menu">لیست انتظار</span>
                        </a>
                    </li>
                @endcan
                @can('attendance_access')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.attendances.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-user-check"></i>
                            </span>
                            <span class="hide-menu">لیست حضور غیاب</span>
                        </a>
                    </li>
                @endcan
                @can('dropout_access')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.users.dropouts.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-user-minus"></i>
                            </span>
                            <span class="hide-menu">لیست ریزشی ها</span>
                        </a>
                    </li>
                @endcan
                @can('user_deleted_access')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.users.trash') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-user-off"></i>
                            </span>
                            <span class="hide-menu">لیست کاربران حذف شده</span>
                        </a>
                    </li>
                @endcan
                @canany(['course_access', 'semester_access', 'book_access', 'evaluation_access'])
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">دوره ها</span>
                    </li>
                @endcanany
                @can('course_access')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.courses.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-books"></i>
                            </span>
                            <span class="hide-menu">دوره ها</span>
                        </a>
                    </li>
                @endcan
                @can('semester_access')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.semesters.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-calendar"></i>
                            </span>
                            <span class="hide-menu">کلاس ها</span>
                        </a>
                    </li>
                @endcan
                @can('book_access')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.books.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-book"></i>
                            </span>
                            <span class="hide-menu">کتاب ها</span>
                        </a>
                    </li>
                @endcan
                @can('evaluation_access')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.evaluations.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-help"></i>
                            </span>
                            <span class="hide-menu">سوال ها</span>
                        </a>
                    </li>
                @endcan
                @canany(['financial_access'])
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">مالی</span>
                    </li>
                @endcanany
                @can('financial_access')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.orders.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-coin"></i>
                            </span>
                            <span class="hide-menu">سفارش ها</span>
                        </a>
                    </li>
                @endcan
                @can('message_access')
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">پیام ها</span>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.messages.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-message"></i>
                            </span>
                            <span class="hide-menu">پیام ها</span>
                        </a>
                    </li>
                @endcan
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">تنظیمات</span>
                </li>
                @can('general_settings')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.settings.general') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-settings"></i>
                            </span>
                            <span class="hide-menu">{{ __('global.site_settings') }}</span>
                        </a>
                    </li>
                @endcan
                @can('permission_access')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.roles.permissions') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-alert-octagon"></i>
                            </span>
                            <span class="hide-menu">دسترسی ها</span>
                        </a>
                    </li>
                @endcan
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('admin.users.password') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-key"></i>
                        </span>
                        <span class="hide-menu">تغییر رمز عبور</span>
                    </a>
                </li>


                {{-- <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('profile.edit') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-layout-dashboard"></i>
                        </span>
                        <span class="hide-menu">ویرایش اطلاعات</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="/ui-buttons.html" aria-expanded="false">
                        <span>
                            <i class="ti ti-article"></i>
                        </span>
                        <span class="hide-menu">مشاهده برنامه کلاسی</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="./ui-alerts.html" aria-expanded="false">
                        <span>
                            <i class="ti ti-alert-circle"></i>
                        </span>
                        <span class="hide-menu">مشاهده وضعیت شهریه</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="./ui-card.html" aria-expanded="false">
                        <span>
                            <i class="ti ti-cards"></i>
                        </span>
                        <span class="hide-menu">مشاهده کارنامه</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="./ui-forms.html" aria-expanded="false">
                        <span>
                            <i class="ti ti-file-description"></i>
                        </span>
                        <span class="hide-menu"> درخواست های من</span>
                    </a>
                </li> --}}
                
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
