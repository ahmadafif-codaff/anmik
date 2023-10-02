<script>
    $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
            $('#humberger-side').toggleClass('active');
            $('#content').toggleClass('active');
            $('body').toggleClass('overflow-x-none');
        });
    });

    tinymce.init({ 
        selector: 'textarea',
        plugins: 'autolink charmap emoticons link lists searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });

    setInterval(function(){
        $(".load-table").load(location.href + " .load-table");
        $('.reload_time').load('<?=BASEURL?>/dashboard_uptime');
    }, 1000);
</script>