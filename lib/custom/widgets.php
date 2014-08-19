<?php

/**
 * Register widgets
 */

function pith_widgets_init() {

// Sidebars

  register_sidebar(array(
    'name'          => __('Home Top', 'roots'),
    'id'            => 'sidebar-home-top',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>',
  ));

}
add_action('widgets_init', 'pith_widgets_init');
