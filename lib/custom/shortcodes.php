<?php


// Grid products shortcode

function pith_products_grid($atts) {
    global $wp_query;

    if (isset($atts['quantity'])) {
        $quantity = $atts['quantity'];
    } else {
        $quantity = '12';
    }

    if (isset($atts['columns'])) {
        $columns = $atts['columns'];
    } else {
        $columns = '3';
    }

    $args = array(
        'post_type' => 'fik_product',
        'post_per_page' => $quantity,
    );

    if (isset($atts['slug'])) {

        $args['tax_query'] = array(
            'relation' => 'OR',
            array(
                'taxonomy' => 'store-section',
                'field' => 'slug',
                'terms' => $atts['slug']
            )
        );
    }

    $temp_query = $wp_query;
    query_posts($args);
    if ($wp_query->have_posts()) {
        ?>
        <section class="row">
            <?php
                /* Start the Loop */
                $i = 0;
                while (have_posts() && $i < $quantity) : the_post();

                    /* Include the post format-specific template for the content. If you want to
                     * this in a child theme then include a file called called content-___.php
                     * (where ___ is the post format) and that will be used instead.
                     */
                    if ($columns == 4){
                        get_template_part('templates/content-fik_product-cols-4');
                    }else{
                        get_template_part('templates/content-fik_product-cols-3');
                    }

                $i++;
                endwhile;
            ?>
        </section>
        <?php
    }
    $wp_query = $temp_query;

}

if ( shortcode_exists('fikproducts')){
    remove_shortcode('fikproducts');
}

add_shortcode('fikproducts', 'pith_products_grid');
