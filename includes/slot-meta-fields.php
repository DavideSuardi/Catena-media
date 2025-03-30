<?php

// register data
add_action('init', function () {
    $fields = [
        'provider_name' => 'string',
        'rtp' => 'string',
        'min_wager' => 'number',
        'max_wager' => 'number',
        'star_rating' => 'number'
    ];

    foreach ($fields as $key => $type) {
        register_post_meta('slot', $key, [
            'type' => $type,
            'single' => true,
            'show_in_rest' => true
        ]);
    }
});

// metabox panel
add_action('add_meta_boxes', function () {
    add_meta_box(
        'slot_custom_fields',
        'Slot Info',
        'wr_render_slot_fields',
        'slot',
        'normal',
        'default'
    );
});

// render metabox
function wr_render_slot_fields($post) {
    $provider = get_post_meta($post->ID, 'provider_name', true);
    $rtp = get_post_meta($post->ID, 'rtp', true);
    $min = get_post_meta($post->ID, 'min_wager', true);
    $max = get_post_meta($post->ID, 'max_wager', true);
    $rating = get_post_meta($post->ID, 'star_rating', true);
    ?>
    <label>Provider Name:</label>
    <input type="text" name="provider_name" value="<?php echo esc_attr($provider); ?>" class="widefat" />

    <label>RTP (%):</label>
    <input type="text" name="rtp" value="<?php echo esc_attr($rtp); ?>" class="widefat" />

    <label>Minimum Wager (€):</label>
    <input type="number" step="0.01" name="min_wager" value="<?php echo esc_attr($min); ?>" class="widefat" />

    <label>Maximum Wager (€):</label>
    <input type="number" step="0.01" name="max_wager" value="<?php echo esc_attr($max); ?>" class="widefat" />

    <label>Star Rating (1–5):</label>
    <input type="number" step="1" min="1" max="5" name="star_rating" value="<?php echo esc_attr($rating); ?>" class="widefat" />
    <?php
}

// save fields
add_action('save_post_slot', function ($post_id) {
    if (isset($_POST['provider_name'])) {
        update_post_meta($post_id, 'provider_name', sanitize_text_field($_POST['provider_name']));
    }
    if (isset($_POST['rtp'])) {
        update_post_meta($post_id, 'rtp', sanitize_text_field($_POST['rtp']));
    }
    if (isset($_POST['min_wager'])) {
        update_post_meta($post_id, 'min_wager', floatval($_POST['min_wager']));
    }
    if (isset($_POST['max_wager'])) {
        update_post_meta($post_id, 'max_wager', floatval($_POST['max_wager']));
    }
    if (isset($_POST['star_rating'])) {
        update_post_meta($post_id, 'star_rating', intval($_POST['star_rating']));
    }
});
