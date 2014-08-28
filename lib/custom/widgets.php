<?php

/**
 * Register widgets
 */

function pith_widgets_init() {

// Sidebar

  register_sidebar(array(
    'name'          => __('Sidebar', 'roots'),
    'id'            => 'sidebar-primary',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>',
  ));

// Footer

  register_sidebar(array(
    'name'          => __('Footer column one', 'roots'),
    'id'            => 'widget-area-footer-one',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>',
  ));

  register_sidebar(array(
    'name'          => __('Footer column two', 'roots'),
    'id'            => 'widget-area-footer-two',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>',
  ));

  register_sidebar(array(
    'name'          => __('Footer column three', 'roots'),
    'id'            => 'widget-area-footer-three',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>',
  ));

  register_sidebar(array(
    'name'          => __('Footer column four', 'roots'),
    'id'            => 'widget-area-footer-four',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>',
  ));

// Widget zones

  register_sidebar(array(
    'name'          => __('Home Top 1 (Full width)', 'roots'),
    'id'            => 'widget-area-home-top-1',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>',
  ));

  register_sidebar(array(
    'name'          => __('Home Top 2 (Normal width)', 'roots'),
    'id'            => 'widget-area-home-top-2',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>',
  ));

  register_sidebar(array(
    'name'          => __('Home Bottom', 'roots'),
    'id'            => 'widget-area-home-bottom',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>',
  ));

}
add_action('widgets_init', 'pith_widgets_init');
