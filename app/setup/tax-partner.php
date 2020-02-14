<?php

add_action('init', function () {

    /**
     * Taxonomy: Partners.
     */
    $labels = [
        'name'          => __('Partners', 'sage'),
        'singular_name' => __('Partner', 'sage'),
        'add_new_item'  => __('Add New Partner', 'sage'),
    ];

    $args = [
        'label'              => __('Partner', 'sage'),
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'hierarchical'       => false,
        'show_ui'            => true,
        'show_in_menu'       => false,
        'show_in_nav_menus'  => true,
        'query_var'          => true,
        'rewrite'            => ['slug' => 'partner', 'with_front' => true],
        'show_admin_column'  => false,
        'show_in_rest'       => false,
        'rest_base'          => '',
        'show_in_quick_edit' => false,
    ];
    register_taxonomy('partner', ['article'], $args);
});
