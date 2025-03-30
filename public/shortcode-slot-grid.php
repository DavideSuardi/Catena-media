<?php
add_shortcode('slot_grid', function ($atts) {
    $atts = shortcode_atts([
        'limit' => 6,
        'order' => 'recent'
    ], $atts);

    $query_args = [
        'post_type' => 'slot',
        'posts_per_page' => intval($atts['limit']),
        'orderby' => $atts['order'] === 'random' ? 'rand' : 'modified',
        'order' => 'DESC'
    ];

    $slots = new WP_Query($query_args);

    if (!$slots->have_posts()) {
        return '<p>No slots available.</p>';
    }

    ob_start();
    echo '<div class="wr-slot-grid">';

    while ($slots->have_posts()) {
        $slots->the_post();
        $rating = get_post_meta(get_the_ID(), 'star_rating', true);

        echo apply_filters('wr_slot_grid_item_open', '<div class="wr-slot">');
        if (has_post_thumbnail()) {
            echo '<div class="wr-slot-img">';
            the_post_thumbnail('medium');
            echo '</div>';
        }
        echo '<h3 class="wr-slot-title">' . esc_html(get_the_title()) . '</h3>';
        echo '<p class="wr-slot-rating">⭐ ' . intval($rating) . '/5</p>';
        echo '<a class="wr-slot-link" href="' . esc_url(get_permalink()) . '">More Info</a>';
        echo apply_filters('wr_slot_grid_item_close', '</div>');
    }

    echo '</div>';
    wp_reset_postdata();
    return ob_get_clean();
});
