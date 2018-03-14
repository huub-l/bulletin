<?php

add_action('init', function () {

    /**
     * Taxonomy: Keywords.
     */
    $labels = [
        'name'          => __('Keywords', 'sage'),
        'singular_name' => __('Keyword', 'sage'),
    ];

    $args = [
        'label'              => __('Keywords', 'sage'),
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'hierarchical'       => false,
        'label'              => 'Keywords',
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => true,
        'query_var'          => true,
        'rewrite'            => ['slug' => 'keyword', 'with_front' => true],
        'show_admin_column'  => false,
        'show_in_rest'       => false,
        'rest_base'          => '',
        'show_in_quick_edit' => true,
    ];
    register_taxonomy('keyword', ['article'], $args);
});