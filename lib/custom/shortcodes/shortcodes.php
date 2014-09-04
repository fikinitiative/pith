<?php
// -------------
// ------------- Add button at text editor
// -------------

if (!function_exists('register_button')){
    function register_button( $buttons ){
        array_push( $buttons, "|", "fik_shortcodes" );
        return $buttons;
    }
}

if (!function_exists('add_plugin')){
    function add_plugin( $plugin_array ) {
        $plugin_array['fik_shortcodes'] = get_template_directory_uri() . '/lib/custom/shortcodes/fik_shortcodes.js';
        return $plugin_array;
    }
}

if (!function_exists('fik_shortcodes_button')){
    function fik_shortcodes_button(){
        if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
            return;
        }

        if ( get_user_option('rich_editing') == 'true' ) {
            add_filter( 'mce_external_plugins', 'add_plugin' );
            add_filter( 'mce_buttons', 'register_button' );
        }
    }
}
add_action('init', 'fik_shortcodes_button');


if (!function_exists('num_shortcodes')){
    function num_shortcodes($content){
        $columns = substr_count( $content, '[pricing_cell' );
        return $columns;
    }
}

// Fik shortcodes


// -------------
// ------------- Grid products shortcode
// -------------

function pith_products_grid($atts) {
    global $wp_query;

    if (isset($atts['quantity']) && $atts['quantity'] != '') {
        $quantity = $atts['quantity'];
    } else {
        $quantity = '1';
    }

    if (isset($atts['columns']) && $atts['columns'] != '') {
        $columns = $atts['columns'];
    } else {
        $columns = '3';
    }

    $args = array(
        'post_type' => 'fik_product',
        'post_per_page' => $quantity,
    );

    if (isset($atts['section']) && $atts['section'] != '') {

        $args['tax_query'] = array(
            'relation' => 'OR',
            array(
                'taxonomy' => 'store-section',
                'field' => 'slug',
                'terms' => $atts['section']
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
