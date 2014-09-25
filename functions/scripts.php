<?php
add_action('wp_enqueue_scripts', function () {
  $base = get_template_directory_uri();
  wp_enqueue_style('bare_roots_css', $base.'/assets/styles.css', array(), '{{ version }}');
  wp_enqueue_script('bare_roots_js', $base.'/assets/bundle.js', array(), '{{ version }}', true);
});
