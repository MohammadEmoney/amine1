<div class="card">
    <div class="card-body">
        <h3 class="">ویرایش {{ $type == "student" ? "دانش آموز" : "کادر اداری"}}</h3>
        <div>
            <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
                data-sidebar-position="fixed" data-header-position="fixed">
                <div class="d-flex align-items-center justify-content-center w-100">
                    <div class="row justify-content-center w-100">
                        <div class="col-md-12">
                            <div class="card mb-3 mt-3">
                                <div class="card-body">
                                    @if ($type == "student")
                                        @include('livewire.admin.users.components.student-form')
                                    @endif
                                    @if($type == "staff")
                                        @include('livewire.admin.users.components.staff-form')
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($type == "student")
    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function() {
                $("#student_birth_date").pDatepicker({
                    format: 'YYYY-MM-DD',
                    autoClose: true,
                    initialValue : true,
                    initialValueType : 'persian',
                    onSelect: function(unix) {
                        var propertyName = $(this).data('property');
                        @this.set('data.birth_date', new persianDate(unix).format('YYYY-MM-DD'), true);
                    }
                });

                $("#register_date").pDatepicker({
                    format: 'YYYY-MM-DD',
                    autoClose: true,
                    initialValue : true,
                    initialValueType : 'persian',
                    onSelect: function(unix) {
                        var propertyName = $(this).data('property');
                        @this.set('data.birth_date', new persianDate(unix).format('YYYY-MM-DD'), true);
                    }
                });

                $("#date_left").pDatepicker({
                    format: 'YYYY-MM-DD',
                    autoClose: true,
                    initialValue : true,
                    initialValueType : 'persian',
                    onSelect: function(unix) {
                        var propertyName = $(this).data('property');
                        @this.set('dropouts.date_left', new persianDate(unix).format('YYYY-MM-DD'), true);
                    }
                });

                $("#date_return").pDatepicker({
                    format: 'YYYY-MM-DD',
                    autoClose: true,
                    initialValue : true,
                    initialValueType : 'persian',
                    onSelect: function(unix) {
                        var propertyName = $(this).data('property');
                        @this.set('dropouts.date_return', new persianDate(unix).format('YYYY-MM-DD'), true);
                    }
                });

            $('.select2').select2({
                placeholder: 'انتخاب کنید',
                dir: 'rtl',
                containerCssClass: 'select-sm',
                allowClear: !0
            });

            function livewireSelect2Multi(component, event) {
                var selectedValues = [];
                $(event).find('option:selected').each(function () {
                    selectedValues.push($(this).val());
                });
                @this.set(component, selectedValues)
            }

            });
        </script>
    @endpush
@endif
@if($type == "staff")
@push('scripts')
    <script>
        $(document).ready(function () {
            $("#staff_birth_date").pDatepicker({
                format: 'YYYY-MM-DD',
                autoClose: true,
                initialValue : true,
                initialValueType : 'persian',
                onSelect: function(unix) {
                    var propertyName = $(this).data('property');
                    @this.set('data.birth_date', new persianDate(unix).format('YYYY-MM-DD'), true);
                }
            });
            $(`#date_start`).pDatepicker({
                    format: 'YYYY-MM-DD',
                    autoClose: true,
                    initialValue : true,
                    initialValueType : 'persian',
                    onSelect: function(unix) {
                        var propertyName = $(this).data('property');
                        console.log(propertyName);
                        @this.set(`jobs.date_start`, new persianDate(unix).format('YYYY-MM-DD'), true);
                    }
                });
            $(`#date_end`).pDatepicker({
                format: 'YYYY-MM-DD',
                autoClose: true,
                initialValue : true,
                initialValueType : 'persian',
                onSelect: function(unix) {
                    var propertyName = $(this).data('property');
                    console.log(propertyName);
                    @this.set(`jobs.date_end`, new persianDate(unix).format('YYYY-MM-DD'), true);
                }
            });

            $('.select2').select2({
                placeholder: 'انتخاب کنید',
                dir: 'rtl',
                containerCssClass: 'select-sm',
                allowClear: !0
            });

            function livewireSelect2Multi(component, event) {
                var selectedValues = [];
                $(event).find('option:selected').each(function () {
                    selectedValues.push($(this).val());
                });
                @this.set(component, selectedValues)
            }
        });
    </script>
@endpush

@script
<script>

    $wire.on('selectJobsReference', () => {
        $(document).ready(function () {
            $(`#date_end`).pDatepicker({
                format: 'YYYY-MM-DD',
                autoClose: true,
                onSelect: function(unix) {
                    @this.set(`jobs.date_end`, new persianDate(unix).format('YYYY-MM-DD'), true);
                }
            });
        });
    })
</script>
@endscript
@endif
