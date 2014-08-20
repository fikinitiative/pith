<?php

/*
*   Customize cart table
*/

add_filter('cart_format', 'customize_cart');

function customize_cart($format){

    $format['quantity_form'] = '<td><form action="" method="post"><input type="hidden" name="cart_item_%s" value="%s" class="nueva_clase"><input type="number" name="cart_item_%s_quantity" min="0" max="10" step="1" value="%s" placeholder="%s" class="input-mini" required=""> <button type="submit" class="cart_item_update btn btn-small btn-primary" name="update_quantity">%s</button></form></td>';

    return $format;
}
