<?php

function bootstrap_clearfix() {
    global $wp_query;

    if(($wp_query->current_post + 1) % 2 == 0) {
        echo '<div class="clearfix visible-sm-block"></div>';
    }

    if(($wp_query->current_post + 1) % 3 == 0) {
        echo '<div class="clearfix visible-md-block visible-lg-block"></div>';
    }
}
add_action('clearfix_hook', 'bootstrap_clearfix');
