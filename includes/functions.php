<?php
function top_podcasts_shortcode($atts) {
    $atts = shortcode_atts( array(
        'provider' => 'apple',
        'num' => '20',
        'layout' => 'grid'
    ), $atts );

    // Check if cached response exists and is still fresh
    $cache_key = 'top_podcasts_cache_' . md5(json_encode($atts));
    $data = get_transient($cache_key);
    if (!$data) {
        // Make API request
        if ($atts['provider'] == 'apple') {
            $endpoint = "https://itunes.apple.com/us/rss/toppodcasts/limit={$atts['num']}/json";
            $response = wp_remote_get($endpoint);
            $data = json_decode(wp_remote_retrieve_body($response), true);
            $data = $data['feed']['entry'];
        } else if ($atts['provider'] == 'spotify') {
            $endpoint = "https://podcastcharts.byspotify.com/api/charts/top?region=us";
            $response = wp_remote_get($endpoint);
            $data = json_decode(wp_remote_retrieve_body($response), true);
        }

        // Cache API response for 1 hour
        set_transient($cache_key, $data, 60 * 60);
    }

    // Load HTML output from separate file
    ob_start();
    if ($atts['layout'] == 'carousel') {
        // Enqueue SwiperJS library and CSS
        wp_enqueue_style('swiper-css', 'https://unpkg.com/swiper/swiper-bundle.min.css');
        wp_enqueue_script('swiper', 'https://unpkg.com/swiper/swiper-bundle.min.js', array(), null, true);
        wp_enqueue_script('swiper-init', plugins_url( '/assets/js/script.js', dirname(__FILE__) ), array('swiper'), null, true);
        include 'output-carousel.php';
    } else {
        include 'output-grid.php';
    }
    $output = ob_get_contents();
    ob_end_clean();

    return $output;
}

add_shortcode( 'top_podcasts', 'top_podcasts_shortcode' );
