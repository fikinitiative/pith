<?php setup_postdata($post); ?>

        <figure class="product-wrap thumbnail">
<!--            <span class="label label-info product-state">Rebajado</span>-->
            <a href="<?php the_permalink(); ?>">
                <?php if ( has_post_thumbnail() ) { ?>
                    <?php the_post_thumbnail( 'store-product-custom-thumbnail', array('class' => 'img-responsive') ); ?>
                <?php } ?>
            </a>
            <figcaption class="caption">
                <h3 class="title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    <span class="product-price"><?php the_fik_price(); ?><?php the_fik_previous_price(); ?></span>
                </h3>
                <?php echo get_the_tag_list( '<p class="tags"><span>', '</span>, <span>', '</span></p>') ?>
            </figcaption>
        </figure>
