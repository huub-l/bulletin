<?php

/*
 * Register sidebars
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ];
    register_sidebar([
        'name' => __('Primary', 'sage'),
        'id'   => 'sidebar-primary',
    ] + $config);
    register_sidebar([
        'name' => __('Footer (left)', 'sage'),
        'id'   => 'sidebar-footer-1',
    ] + $config);
    register_sidebar([
        'name' => __('Footer (right)', 'sage'),
        'id'   => 'sidebar-footer-2',
    ] + $config);
});
