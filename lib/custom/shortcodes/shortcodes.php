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
        ?>
            <a type="button" class="btn btn-<?php echo($color); ?>" href="<?php echo($link); ?>"><?php echo($text); ?></a>
        <?php
    } else {
        ?>
            <button type="button" class="btn btn-<?php echo($color); ?>"><?php echo($text); ?></button>
        <?php
    }
    $wp_query = $temp_query;

}

if ( shortcode_exists('fikbutton')){
    remove_shortcode('fikbutton');
}

add_shortcode('fikbutton', 'pith_buttons');


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

add_shortcode('fikslider', 'pith_slider');
