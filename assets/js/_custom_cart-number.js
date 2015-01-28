addNumberOfProductsInCartMenu = function (){
    if ((jQuery('.cart-menu li a').length>0) && (typeof fik_cart_name !== 'undefined') && (fik_cart_name.length>0)) {
        if (typeof jQuery.cookie(fik_cart_name) !== 'undefined') {
            var cart = unserialize(decodeURIComponent(jQuery.cookie(fik_cart_name)));
            var itemsQuantity = 0;
            jQuery.each( cart.items, function( key, value ) {
                itemsQuantity = itemsQuantity + cart.items[key].quantity * 1 ;
            });
            jQuery('.cart-menu li a').append(' <span class="badge">' + itemsQuantity + '</span>');
        }
    }
};
