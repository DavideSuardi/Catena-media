<?php
add_action('init', function () {
    register_post_type('slot', [
        'label' => 'Slots',
        'public' => true,
        'menu_icon' => 'dashicons-controls-play',
        'supports' => ['title', 'editor', 'thumbnail'],
        'has_archive' => true,
        'rewrite' => ['slug' => 'slots'],
        'show_in_rest' => true
    ]);
});
