<?php
/**
 * Theme wrapper inspired by Silviu-Cristian Burcă
 * and Roots theme by Ben Word.
 *
 * @link http://scribu.net/wordpress/theme-wrappers.html
 * @link https://github.com/roots/roots
 */

function bare_roots_template_path() {
  return BareRoots_Wrapper::$main;
}

class BareRoots_Wrapper {

  public static $main;

  private $templates;
  private static $base = null;

  public function __construct($template) {
    $this->templates = array($template);

    if (self::$base) {
      $slug = basename($template, '.php');
      array_unshift($this->templates, sprintf('%s-%s.php', $slug, self::$base));
    }
  }

  public function __toString() {
    return locate_template($this->templates);
  }

  public static function wrap($main) {
    if (!is_string($main)) {
      return $main;
    }

    self::$main = $main;
    self::$base = basename($main, '.php');

    if ('index' === self::$base) {
      self::$base = null;
    }

    return new BareRoots_Wrapper('base.php');
  }

}

add_filter('template_include', array('BareRoots_Wrapper', 'wrap'), 99);
