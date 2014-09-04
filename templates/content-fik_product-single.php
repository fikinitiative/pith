<?php setup_postdata($post); ?>

    <article itemscope itemtype="http://schema.org/Product" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

        <div class="row">
            <?php if(has_post_thumbnail()) : ?>
            <div class="product-images col-sm-6">
                <div class="product-image-frame">
                    <?php
                        // We print the product thumbnail
                        the_post_thumbnail('product-main',array('class' => 'img-thumbnail'));
                    ?>
                </div>
                <?php
                    // this function outputs a <ul> with class="product-image-thumbnails" where each <li> is a thumbnil that links to a biger image (sizes specified in function).
                    // We also pass the size of the zoom image which url and size are returned as data attributes of the img. The last 2 sizes are the max width of the video thumbnail and the max width of a video embed
                    the_product_gallery_thumbnails(array(64,64) , array(620,9999), array(1240,930),64,620,FALSE);
                    ?>
            </div>
            <?php endif; ?>

            <div class="product-info col-sm-6">
                <div class="row">
                    <header class="col-xs-12">
                        <h1 itemprop="name" class="product-title"><?php the_title(); ?></h1>
                    </header>
                    <div class="product-price col-xs-12">
                        <?php the_fik_price(); ?>
                    </div>
                    <div class="product-description col-xs-12">
                        <?php the_content(); ?>
                    </div>
                    <div class="product-options col-xs-12">
                        <?php the_fik_add_to_cart_button(); ?>
                    </div>
                    <?php if ( is_active_sidebar( 'widget-area-product-description-bottom' ) ) : ?>
                      <footer class="widget-area-product-description-bottom col-xs-12">
                        <?php dynamic_sidebar('widget-area-product-description-bottom'); ?>
                      </footer>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php comments_template('/templates/comments.php'); ?>
    </article>
