// Load Bootstrap carousel

jQuery('.carousel').carousel();

// Product thumbnails function

jQuery(document).ready(function() {
    jQuery(".product-image-thumbnails a").click(function(event) {
        jQuery("#prod-img").attr("src", jQuery(this).attr("href"));
//        prevent href
        return false;
    });
});
