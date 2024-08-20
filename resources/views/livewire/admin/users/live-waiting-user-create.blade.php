<div class="card">
    <div class="card-body">
        <h3 class="">ثبت نام {{ $type == "student" ? "دانش آموز" : "کادر اداری"}}</h3>
        <div>
            <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
                data-sidebar-position="fixed" data-header-position="fixed">
                <div class="d-flex align-items-center justify-content-center w-100">
                    <div class="row justify-content-center w-100">
                        <div class="col-md-12">
                            <div class="card mb-3 mt-3">
                                <div class="card-body">
                                    @include('livewire.admin.users.components.student-form')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#student_birth_date").pDatepicker({
                format: 'YYYY-MM-DD',
                autoClose: true,
                onSelect: function(unix) {
                    var propertyName = $(this).data('property');
                    @this.set('data.birth_date', new persianDate(unix).format('YYYY-MM-DD'), true);
                }
            });
        });

        $("#register_date").pDatepicker({
            format: 'YYYY-MM-DD',
            autoClose: true,
            onSelect: function(unix) {
                var propertyName = $(this).data('property');
                @this.set('data.register_date', new persianDate(unix).format('YYYY-MM-DD'), true);
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
    </script>
@endpush
@if($errors->any())
    @push('scripts')
        <script wire:key="{{ rand() }}">
            console.log('kljsadhflaiksujhdef');
            let firstInvalidInput = document.querySelctor('.invalid-input');
            if(firstInvalidInput)
                firdstInvalidInput.focus();
        </script>
    @endpush
@endif
@script
    <script>
        $wire.on('autoFocus', () => {
            $(document).ready(function () {
                console.log('invalid-input Focus');
                $('.invalid-input').focus()
            });
        })
        $wire.on('moveToNextField', (event) => {
            const nextFieldId = event[0];
            const nextField = document.getElementById(nextFieldId);
            if (nextField) {
                nextField.focus(); // Move focus to the next input field
            }
        });
        $wire.on('loadDatePicker', () => {
            $(document).ready(function () {
                $('.select2').select2({
                    placeholder: 'انتخاب کنید',
                    dir: 'rtl',
                    containerCssClass: 'select-sm',
                    allowClear: !0
                });
                
                $(`#date_left`).pDatepicker({
                    format: 'YYYY-MM-DD',
                    autoClose: true,
                    onSelect: function(unix) {
                        @this.set(`dropouts.date_left`, new persianDate(unix).format('YYYY-MM-DD'), true);
                    }
                });
                $(`#date_return`).pDatepicker({
                    format: 'YYYY-MM-DD',
                    autoClose: true,
                    onSelect: function(unix) {
                        @this.set(`dropouts.date_return`, new persianDate(unix).format('YYYY-MM-DD'), true);
                    }
                });
            });
        })
    </script>
@endscript