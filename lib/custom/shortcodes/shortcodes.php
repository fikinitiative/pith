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

// ********************************************** Fik shortcodes


// -------------
// ------------- Row shortcode
// -------------

function pith_bootstrap_row($atts, $content = null) {

    return "<section class='row'>" . do_shortcode($content) . "</section>";

}

if ( shortcode_exists('fik_row')){
    remove_shortcode('fik_row');
}

add_shortcode('fik_row', 'pith_bootstrap_row');


// -------------
// ------------- Column shortcode 1/2
// -------------

function pith_bootstrap_col_1_2($atts, $content = null) {

    return "<div class='col-sm-6'>" . $content . "</div>";

}

if ( shortcode_exists('fik_col_1-2')){
    remove_shortcode('fik_col_1-2');
}

add_shortcode('fik_col_1-2', 'pith_bootstrap_col_1_2');


// -------------
// ------------- Column shortcode 1/3
// -------------

function pith_bootstrap_col_1_3($atts, $content = null) {

    return "<div class='col-sm-4'>" . $content . "</div>";

}

if ( shortcode_exists('fik_col_1-3')){
    remove_shortcode('fik_col_1-3');
}

add_shortcode('fik_col_1-3', 'pith_bootstrap_col_1_3');


// -------------
// ------------- Column shortcode 1/4
// -------------

function pith_bootstrap_col_1_4($atts, $content = null) {

    return "<div class='col-sm-3'>" . $content . "</div>";

}

if ( shortcode_exists('fik_col_1-4')){
    remove_shortcode('fik_col_1-4');
}

add_shortcode('fik_col_1-4', 'pith_bootstrap_col_1_4');


// -------------
// ------------- Column shortcode 2/3
// -------------

function pith_bootstrap_col_2_3($atts, $content = null) {

    return "<div class='col-sm-8'>" . $content . "</div>";

}

if ( shortcode_exists('fik_col_2-3')){
    remove_shortcode('fik_col_2-3');
}

add_shortcode('fik_col_2-3', 'pith_bootstrap_col_2_3');


// -------------
// ------------- Column shortcode 3/4
// -------------

function pith_bootstrap_col_3_4($atts, $content = null) {

    return "<div class='col-sm-9'>" . $content . "</div>";

}

if ( shortcode_exists('fik_col_3-4')){
    remove_shortcode('fik_col_3-4');
}

add_shortcode('fik_col_3-4', 'pith_bootstrap_col_3_4');


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
        $product_grid = '<section class="row">';
        /* Start the Loop */
        $i = 0;
        while (have_posts() && $i < $quantity) : the_post();
            /* Include the post format-specific template for the content. If you want to
             * this in a child theme then include a file called called content-___.php
             * (where ___ is the post format) and that will be used instead.
             */
            if ($columns == 4){
                $product_grid .= load_template_part('templates/content-fik_product-cols-4');
            }else{
                $product_grid .= load_template_part('templates/content-fik_product-cols-3');
            }
            $i++;

        endwhile;

        $product_grid .= '</section>';
    }
    $wp_query = $temp_query;
    return $product_grid;
}

if ( shortcode_exists('fik_products')){
    remove_shortcode('fik_products');
}

add_shortcode('fik_products', 'pith_products_grid');


// -------------
// ------------- Latest posts shortcode
// -------------

function pith_latest_posts($atts) {

    $args = array(
        "quantity"       => "2",
        "category_name"       => ""
    );

    extract(shortcode_atts($args, $atts));

    $q = new WP_Query(
        array('posts_per_page' => $quantity, 'category_name' => $category_name)
    );

    $html = "";
    $html .= "<section class='row latests-posts'>";

    while ($q->have_posts()) : $q->the_post();

        $html .= '<article class="col-sm-6">';
        $html .= '<figure class="featured-image">';
        $html .= '<a href="'.get_permalink().'">';
        $html .= get_the_post_thumbnail(get_the_ID(), 'latest-post-custom-thumbnail');
        $html .= '</a></figure>';
        $html .= '<header>';
        $html .= '<h5 class="entry-title"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h5>';
        $html .= '</header>';
        $html .= '<footer>';
        $html .= '<time class="published" datetime="'.get_the_time('c').'">'.get_the_date().'</time>';
        $html .= '<p class="byline author vcard">By <a href="'.get_author_posts_url(get_the_author_meta(ID)).'" rel="author" class="fn">'.get_the_author().'</a></p>';
        $html .= '</footer>';
        $html .= '</article>';

    endwhile;
    wp_reset_query();

    $html .= "</section>";
    return $html;
}

if ( shortcode_exists('fik_latest_posts')){
    remove_shortcode('fik_latest_posts');
}

add_shortcode('fik_latest_posts', 'pith_latest_posts');


// -------------
// ------------- Special titles shortcode
// -------------

function pith_special_title($atts, $content = null) {

    return "<h5><span class='fik-special-title'>" . $content . "</span></h5>";

}

if ( shortcode_exists('fik_special_title')){
    remove_shortcode('fik_special_title');
}

add_shortcode('fik_special_title', 'pith_special_title');


// -------------
// ------------- Buttons shortcode
// -------------

function pith_buttons($atts) {
    global $wp_query;

    if (isset($atts['text']) && $atts['text'] != '') {
        $text = $atts['text'];
    } else {
        $text = 'Button';
    }

    if (isset($atts['link']) && $atts['link'] != '') {
        $link = $atts['link'];
    } else {
        $link = '';
    }

    if (isset($atts['color']) && $atts['color'] != '') {

        if ( $atts['color'] == 'primary') {
            $color = 'primary';
        } else if ( $atts['color'] == 'secondary') {
            $color = 'info';
        } else {
            $color = 'primary';
        }
    } else {
        $color = 'default';
    }

    $temp_query = $wp_query;

    if ( $link != '' ) {
            $button = '<a type="button" class="btn btn-' . $color . '" href="' . $link . '">' . $text . '</a>';
    } else {
            $button = '<button type="button" class="btn btn-' . $color . '">' . $text. '</button>';
    }
    $wp_query = $temp_query;

    return $button;

}

if ( shortcode_exists('fik_button')){
    remove_shortcode('fik_button');
}

add_shortcode('fik_button', 'pith_buttons');


// -------------
// ------------- Slider shortcode
// -------------

function pith_slider($atts) {
    global $wp_query;
    if (isset($atts['ids'])) {
        $ids = explode(',', $atts['ids']);
        if (is_array($ids)) {
            if (!isset($atts['indicators'])) {
                $atts['indicators'] = 'true';
            }
            if (!isset($atts['indicators'])) {
                $atts['indicators'] = 'true';
            }
            if (!isset($atts['navigation'])) {
                $atts['navigation'] = 'true';
            }
            if (!isset($atts['captions'])) {
                $atts['captions'] = 'true';
            }
            if (!isset($atts['max-width'])) {
                $atts['max-width'] = '100%';
            }
            if (!isset($atts['id'])) {
                $atts['id'] = 'myCarousel';
            }
            $slides = array();
            foreach ($ids as $key => $id) {
                $image = wp_get_attachment_image($id, 'largest');
                if ($image != '') {
                    $slides[$key]['id'] = $id;
                    $slides[$key]['img'] = $image;
                    $attachment = get_post($id);
                    $slides[$key]['title'] = $attachment->post_title;
                    $slides[$key]['description'] = $attachment->post_content;
                    if (isset($atts['link' . $id])) {
                        $slides[$key]['link'] = $atts['link' . $id];
                    }
                } else {
                    unset($slides[$key]);
                }
            }
            $slides = array_values($slides);
            if ($slides != array()) {
                //We show the slider
                // Add javascript and css to output!
                if(!current_theme_supports('bootstrap-3')) {
                    wp_enqueue_script('bootstrap-carousel', '/wp-content/mu-plugins/assets/js/bootstrap-carousel.js', array('jquery'), '1.01', true);

                    wp_enqueue_style('bootstrap-carousel', '/wp-content/mu-plugins/assets/css/fik-bootstrap-carousel.css');
                }
                $maxwidth = ' style="max-width:' . $atts['max-width'] . ';"';
                echo('<div id="' . $atts['id'] . '" class="carousel slide"' . $maxwidth . '>');
                // Carousel Indicators
                if ((isset($atts['indicators'])) && ($atts['indicators'] == 'true')) {
                    echo('<ol class="carousel-indicators">');
                    foreach ($slides as $key => $slide) {
                        if ($key == 0) {
                            $class = ' class="active"';
                        } else {
                            $class = '';
                        }
                        echo('<li data-target="#' . $atts['id'] . '" data-slide-to="' . $key . '"' . $class . '></li>');
                    }
                    echo('</ol>');
                }
                // Carousel Items
                echo ('<div class="carousel-inner">');
                foreach ($slides as $key => $slide) {
                    if ($key == 0) {
                        $class = ' class="active item"';
                    } else {
                        $class = ' class="item"';
                    }
                    echo('<div' . $class . '>');
                    // Image with or without link:
                    if (isset($slide['link'])) {
                        echo('<a href="' . $slide['link'] . '" title="' . $slide['title'] . '">');
                        echo($slide['img']);
                        echo('</a>');
                    } else {
                        echo($slide['img']);
                    }
                    // Image caption if requested:
                    if ((isset($atts['captions'])) && ($atts['captions'] == 'true')) {
                        echo('<div class="carousel-caption">');
                        echo('<h4>' . $slide['title'] . '</h4>');
                        echo('<p>' . $slide['description'] . '</p>');
                        echo('</div>');
                    }
                    echo('</div>'); // Closes each of the slides
                }
                echo('</div>'); // Closes carousel-inner
                // Carousel Navigation
                if ((isset($atts['navigation'])) && ($atts['navigation'] == 'true')) {
                    echo('<a class="carousel-control left" href="#' . $atts['id'] . '" data-slide="prev"><span>&lsaquo;</span></a>');
                    echo('<a class="carousel-control right" href="#' . $atts['id'] . '" data-slide="next"><span>&rsaquo;</span></a>');
                }
                echo('</div>'); // Closes carousel
            }
        }

        if (isset($atts['width']))
            $width = $atts['width']; else
            $width = "100%";
        if (isset($atts['height']))
            $height = $atts['height']; else
            $height = "100%";
        ?>
        <?php
    }
}

if ( shortcode_exists('fik_slider')){
    remove_shortcode('fik_slider');
}

add_shortcode('fik_slider', 'pith_slider');
