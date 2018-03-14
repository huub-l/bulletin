<?php

add_action('init', function () {

    /**
     * Taxonomy: Programmes.
     */
    $labels = [
               'name'   => __('Programmes', 'sage'),
        'singular_name' => __('Programme', 'sage'),
        'add_new_item'  => __('Add New Programme', 'sage'),
       ];

    $args = [
        'label'              => __('Programmes', 'sage'),
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'hierarchical'       => true,
        'show_ui'            => true,
        'show_in_menu'       => false,
        'show_in_nav_menus'  => false,
        'query_var'          => true,
        'rewrite'            => ['slug' => 'programme', 'with_front' => true],
        'show_admin_column'  => false,
        'show_in_rest'       => false,
        'rest_base'          => '',
        'show_in_quick_edit' => true,
       ];
    register_taxonomy('programme', ['article'], $args);
});