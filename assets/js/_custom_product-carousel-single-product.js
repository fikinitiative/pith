singleProductCarousel = function () {
    jQuery(".product-image-thumbnails a").click(function(event) {
        jQuery("#prod-img").attr("src", jQuery(this).attr("href"));
// prevent href
        return false;
    });
};
