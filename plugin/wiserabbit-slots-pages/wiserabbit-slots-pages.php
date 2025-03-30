<?php
/*
Plugin Name: WiseRabbit - Slot Manager
Description: Custom management for slots pages
Version: 1.0
Author: Davide Suardi
*/

if (!defined('ABSPATH')) exit;

define('WR_SLOTS_PATH', plugin_dir_path(__FILE__));
define('WR_SLOTS_URL', plugin_dir_url(__FILE__));

// Load core components
require_once WR_SLOTS_PATH . 'includes/slot-post-type.php';
require_once WR_SLOTS_PATH . 'includes/slot-meta-fields.php';
require_once WR_SLOTS_PATH . 'public/shortcode-slot-grid.php';



// Enqueue styles (with override support)
add_action('wp_enqueue_scripts', function () {
    if (apply_filters('wr_slots_disable_styles', false)) return;

    $theme_override = get_stylesheet_directory() . '/wiserabbit-slots-override.css';
    if (file_exists($theme_override)) {
        wp_enqueue_style('wr-slots-override', get_stylesheet_directory_uri() . '/wiserabbit-slots-override.css');
    } else {
        wp_enqueue_style('wr-slots-style', WR_SLOTS_URL . 'public/css/default-style.css');
    }
});

// Replace content on single slot page
add_filter('the_content', function ($content) {
    if (!is_singular('slot') || !in_the_loop() || !is_main_query()) {
        return $content;
    }

    $post_id = get_the_ID();
    $provider = get_post_meta($post_id, 'provider_name', true);
    $rtp = get_post_meta($post_id, 'rtp', true);
    $min = get_post_meta($post_id, 'min_wager', true);
    $max = get_post_meta($post_id, 'max_wager', true);
    $rating = get_post_meta($post_id, 'star_rating', true);

    ob_start();
    ?>
    <div class="slot-single">
        <div class="slot-description">
            <?php echo $content; ?>
        </div>
        <ul class="slot-meta">
            <li><strong>Provider:</strong> <?php echo esc_html($provider); ?></li>
            <li><strong>RTP:</strong> <?php echo esc_html($rtp); ?>%</li>
            <li><strong>Wager:</strong> <?php echo esc_html($min); ?>€ – <?php echo esc_html($max); ?>€</li>
            <li><strong>Rating:</strong> <?php echo esc_html($rating); ?>/5</li>
        </ul>
    </div>
    <?php

    return ob_get_clean();
}, 20);



// Flush permalinks on activation
register_activation_hook(__FILE__, function () {
    flush_rewrite_rules();
});