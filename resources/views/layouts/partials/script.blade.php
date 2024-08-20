<script src="/panel/src/assets/libs/jquery/dist/jquery.min.js"></script>
<script src="/panel/src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="/panel/src/assets/js/sidebarmenu.js"></script>
<script src="/panel/src/assets/js/app.min.js"></script>
{{-- <script src="/panel/src/assets/libs/apexcharts/dist/apexcharts.min.js"></script> --}}
<script src="/panel/src/assets/libs/simplebar/dist/simplebar.js"></script>
<script src="/panel/src/assets/libs/persiandate/persian-date.min.js"></script>
{{-- <script src="/panel/src/assets/js/dashboard.js"></script> --}}
<script src="/panel/src/assets/libs/sweetalert/sweetalert2.all.js"></script>
<script src="/panel/src/assets/libs/select2/select2.full.min.js"></script>
<script src="/panel/src/assets/js/alert.js"></script>
<script src="https://unpkg.com/persian-datepicker@latest/dist/js/persian-datepicker.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.28.0/tableExport.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.3/dist/bootstrap-table.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.3/dist/bootstrap-table-locale-all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.3/dist/extensions/export/bootstrap-table-export.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script src="/panel/src/assets/js/custom.js"></script>

<script>
    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });
</script>

<script>
    $('document').ready(function(){
        const backgroundMusic = document.getElementById('backgroundMusic');

        // Handle route changes to restart music if paused
        window.addEventListener('hashchange', () => {
            backgroundMusic.play();
        });

        // Pause music when the dashboard is left
        window.addEventListener('beforeunload', () => {
            backgroundMusic.pause();
        });
    });
</script>

@livewireScripts

@stack('scripts')
