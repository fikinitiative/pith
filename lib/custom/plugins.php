<?php

// Run this code on 'after_theme_setup', when plugins have already been loaded.
add_action('after_setup_theme', 'my_load_plugins');

// This function loads the plugins.
function my_load_plugins() {

    // Check to see if your plugin has already been loaded.
	if (!function_exists('my_plugin_function_name')) {
		// load plugin if not already loaded
		include_once(TEMPLATEPATH.'/assets/plugins/wp-flexible-map/flexible-map.php');
	}
}
