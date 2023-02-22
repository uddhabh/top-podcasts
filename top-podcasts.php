<?php
/*
Plugin Name: Top Podcasts
Description: A plugin to display top podcasts from Apple Podcasts and Spotify.
Version: 1.0
Author: Beenacle Technologies
Author URI: https://beenacle.com/
License: GPL2
*/

require_once(plugin_dir_path(__FILE__) . 'includes/functions.php');

// Enqueue plugin CSS
function top_podcasts_enqueue_styles() {
    wp_enqueue_style( 'top-podcasts-style', plugins_url( 'assets/css/style.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'top_podcasts_enqueue_styles' );
