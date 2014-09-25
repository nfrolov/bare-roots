<?php
add_action('after_setup_theme', function () {
  load_theme_textdomain('bare-roots', get_template_directory().'/lang');

  register_nav_menus(array(
    'primary' => __('Primary Navigation', 'bare-roots')
  ));

  add_theme_support('html5', array('caption', 'comment-form', 'comment-list'));
});

add_action('widgets_init', function () {
  register_sidebar(array(
    'name' => __('Primary Sidebar', 'bare-roots'),
    'id' => 'sidebar-primary',
    'before_widget' => '<section class="widget %2$s">',
    'after_widget' => '</section>',
    'before_title' => '<h3 class="widget__title">',
    'after_title' => '</h3>',
  ));
});
