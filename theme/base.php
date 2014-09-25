<!doctype html>
<html class="page" <?php language_attributes() ?>>
  <head>
    <meta charset="<?php bloginfo('charset') ?>">
    <meta name="viewport" content="width=device-width">
    <title><?php wp_title('-', true, 'right') ?></title>
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,200italic,300italic,400italic,600italic">
    <?php wp_head() ?>
  </head>
  <body class="page__body">

    <header class="page__header header" role="banner">
      <div class="header__container">
        <h1 class="header__logo logo">
          <a class="logo__link" href="<?php echo esc_url(home_url('/')) ?>"><?php bloginfo('name') ?></a>
        </h1>
        <nav class="header__menu menu" role="navigation">
          <?php wp_nav_menu(array('theme_location' => 'primary')) ?>
        </nav>
      </div>
    </header>

<?php require bare_roots_template_path() ?>

    <footer class="page__footer footer">
      <div class="footer__container">
        <p class="footer__text footer__copyright">© 2014 <?php bloginfo('name') ?></p>
      </div>
    </footer>

    <?php wp_footer() ?>
  </body>
</html>
