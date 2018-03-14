<?php

add_action('init', function () {

    /**
     * Taxonomy: Issues.
     */
    $labels = [
               'name'   => __('Issues', 'sage'),
        'singular_name' => __('Issue', 'sage'),
        'add_new_item'  => __('Add New Issue', 'sage'),
       ];

    $args = [
        'label'              => __('Issue', 'sage'),
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'hierarchical'       => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => true,
        'query_var'          => true,
        'rewrite'            => ['slug' => 'issue', 'with_front' => true],
        'show_admin_column'  => false,
        'show_in_rest'       => false,
        'rest_base'          => '',
        'show_in_quick_edit' => true,
       ];
    register_taxonomy('issue', ['article'], $args);
});
