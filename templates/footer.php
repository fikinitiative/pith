<footer class="jumbotron content-info" role="contentinfo">
  <div class="container">
    <div class="row">
      <section class="col-sm-6 col-md-3">
        <?php dynamic_sidebar('widget-area-footer-one'); ?>
      </section>
      <section class="col-sm-6 col-md-3">
        <?php dynamic_sidebar('widget-area-footer-two'); ?>
      </section>
      <div class="clearfix visible-sm-block"></div>
      <section class="col-sm-6 col-md-3">
        <?php dynamic_sidebar('widget-area-footer-three'); ?>
      </section>
      <section class="col-sm-6 col-md-3">
        <?php dynamic_sidebar('widget-area-footer-four'); ?>
      </section>
    </div>
  </div>
</footer>
<footer class="jumbotron closing">
    <div class="container">
    <p class="copy">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
    <p class="fik-stores-badge">Powered by<a href="http://fikstores.com/" target="_blank"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/fik-logo-badge-white.svg'?>" /></a></p>
    </div>
</footer>

<?php wp_footer(); ?>
