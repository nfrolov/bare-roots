<?php
add_filter('wp_title', function ($title, $sep) {
  if (is_feed()) {
    return $title;
  }

  $title .= get_bloginfo('name');

  $description = get_bloginfo('description', 'display');
  if ($description && (is_home() || is_front_page())) {
    $title = "$title $sep $description";
  }

  return $title;
}, 10, 2);
