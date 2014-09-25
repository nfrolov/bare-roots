<?php
class BareRoots_Nav_Walker extends Walker_Nav_Menu {

  // no submenu tweaks

  public function end_el(&$output, $item, $depth = 0, $args = array()) {
    $output .= '</li>';
  }

}

add_filter('nav_menu_css_class', function ($classes, $item) {
  $classes = array_reduce($classes, function ($carry, $class) {
    if (preg_match('~(current(-menu-|[-_]page[-_])(item|parent|ancestor))~', $class)) {
      $carry[] = 'menu__item_active';
    } else if (!preg_match('~^((menu|page)[-_\w+]+)+~', $class)) {
      $carry[] = $class;
    }
    return $carry;
  }, array('menu__item'));

  $classes = array_unique($classes);

  return $classes;
}, 10, 2);

add_filter('nav_menu_item_id', '__return_null');

add_filter('nav_menu_link_attributes', function ($atts) {
  return array_merge($atts, array('class' => 'menu__link'));
});

add_filter('wp_nav_menu_args', function ($args) {
  $args['container'] = false;
  $args['items_wrap'] = '<ul class="%2$s">%3$s</ul>'."\n";
  $args['menu_class'] = 'menu__list';

  if (!$args['depth']) {
    $args['depth'] = 1;
  }

  if (!$args['walker']) {
    $args['walker'] = new BareRoots_Nav_Walker();
  }

  return $args;
});

add_filter('nav_menu_link_attributes', function ($atts) {
  if ($atts['href'] && function_exists('soil_root_relative_url')) {
    $atts['href'] = soil_root_relative_url($atts['href']);
  }
  return $atts;
});
