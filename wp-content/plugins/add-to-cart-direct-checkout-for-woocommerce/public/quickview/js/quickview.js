
jQuery(document).ready(function ($) {

    //shop page button click 
    $(document).on('click', ".quick_view", function () {

        var product_id = $(this).data('product-id');

        $.magnificPopup.open({
            items: {
                src: pisol_frontend_obj.ajaxurl + "?action=pisol_get_product&product_id=" + product_id,
                type: "ajax",
                showCloseBtn: true,
                closeOnContentClick: false,
                closeOnBgClick: false,
                mainClass: 'mfp-fade',
                removalDelay: 300,
            },
        });

    });

});