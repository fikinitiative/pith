<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>

  <!--[if lt IE 8]>
    <div class="alert alert-warning">
      <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'roots'); ?>
    </div>
  <![endif]-->

  <?php
    do_action('get_header');
    get_template_part('templates/header');
  ?>

  <?php if ( is_front_page() && is_active_sidebar( 'sidebar-home-top-1' ) ) : ?>
      <section class="jumbotron sidebar-full sidebar-top sidebar-home sidebar-home-first">
        <?php dynamic_sidebar('sidebar-home-top-1'); ?>
      </section>
  <?php endif; ?>

  <?php if ( is_front_page() && is_active_sidebar( 'sidebar-home-top-2' ) ) : ?>
      <section class="jumbotron sidebar-full sidebar-top sidebar-home">
        <div class="container">
            <?php dynamic_sidebar('sidebar-home-top-2'); ?>
        </div>
      </section>
  <?php endif; ?>

  <div class="wrap container" role="document">
    <div class="content row">
      <main class="main <?php echo roots_main_class(); ?>" role="main">
        <?php include roots_template_path(); ?>
      </main><!-- /.main -->
      <?php if (roots_display_sidebar()) : ?>
        <aside class="sidebar <?php echo roots_sidebar_class(); ?>" role="complementary">
          <?php include roots_sidebar_path(); ?>
        </aside><!-- /.sidebar -->
      <?php endif; ?>
    </div><!-- /.content -->
  </div><!-- /.wrap -->

  <?php if ( is_front_page() && is_active_sidebar( 'sidebar-home-bottom' ) ) : ?>
      <section class="jumbotron sidebar-full sidebar-bottom sidebar-home">
        <div class="container">
            <?php dynamic_sidebar('sidebar-home-bottom'); ?>
        </div>
      </section>
  <?php endif; ?>

  <?php get_template_part('templates/footer'); ?>

</body>
</html>
