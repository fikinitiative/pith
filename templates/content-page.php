<?php if ( has_post_thumbnail() ) { ?>
      <figure class="featured-image">
        <?php the_post_thumbnail( 'post-custom-thumbnail', array('class' => 'img-responsive') ); ?>
      </figure>
    <?php } ?>
<?php the_content(); ?>
<?php wp_link_pages(array('before' => '<nav class="pagination">', 'after' => '</nav>')); ?>
