<?php

/*
*   Add support for upload SVG
*/

function cc_mime_types( $mimes ){
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );

/*
*   Add shortcode support on text widgets
*/

add_filter('widget_text', 'do_shortcode');
