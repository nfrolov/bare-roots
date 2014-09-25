    <main class="page__main" role="main">
      <div class="page__hero hero hero_size_small hero_bg_basic"></div>
      <section class="page__section section">
        <div class="section__container">
<?php while (have_posts()): the_post(); ?>

          <h1 class="heading heading_lvl_1"><?php the_title() ?></h1>

<?php the_content() ?>

<?php endwhile ?>
        </div>
      </section>
    </main>
