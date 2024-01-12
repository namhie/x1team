jQuery(function ($) {


$(document).ready(function() {

    $('#createVendorProduct').on('submit', function(e) {
        console.log(e);
        e.preventDefault();
        var fd = new FormData( $(this)[0] );
            fd.append( 'action', 'create_vendor_product' );
        $.ajax({
            url: '/wp-admin/admin-ajax.php',
            method: 'POST',
            processData: false,
			contentType: false,
            data: fd,
            // data: {
            //     'action': 'create_vendor_product',
            //     'form_data': fd
            // }
        }).done(data => {
            $(this)[0].reset();
            console.log(data);
        }).fail(data => {
            console.log(data);
        });


    })

    $('#updateVendorProduct').on('click', function (e) {
        let productCategory = [];


        $('.cat_product:checked').each( ( k, inp ) => {
            productCategory.push( $(inp).val() )
        })


        $.ajax({
            url: '/wp-admin/admin-ajax.php',
            method: 'POST',
            data: {
                'action': 'update_vendor_product',
                'productID': $(this).data('post_id'),
                'productTitle': $('[name="product-title"]').val(),
                'productDescription': $('[name="product-description"]').val(),
                'productPrice': $('[name="product-price"]').val(),
                'productRegularPrice': $('[name="product-regular-price"]').val(),
                'productCategory': productCategory,
            }
        }).done(data => {
            window.location = data;
        }).fail(data => {
            console.log(data);
        });



    })


});


}); // jQuery End