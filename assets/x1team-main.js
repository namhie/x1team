jQuery(function ($) {
    $(document).ready(function () {

        // Copy Link Product
        $('#copyLinkProduct').on('click', function() {
            navigator.clipboard.writeText( window.location.href );
        });

    });
});