<?php

add_action('init', function () {

    /**
     * Post Type: SB Articles.
     */
    $labels = [
        'name'          => __('SB Articles', 'sage'),
        'singular_name' => __('SB Article', 'sage'),
    ];

    $args = [
        'label'               => __('SB Articles', 'sage'),
        'labels'              => $labels,
        'description'         => 'Articles in a science bulletin',
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_rest'        => false,
        'rest_base'           => '',
        'has_archive'         => true,
        'show_in_menu'        => true,
        'exclude_from_search' => false,
        'capability_type'     => 'post',
        'map_meta_cap'        => true,
        'hierarchical'        => false,
        'rewrite'             => ['slug' => 'article', 'with_front' => true],
        'query_var'           => true,
        'supports'            => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'comments', 'author'],
        'taxonomies'          => ['keyword', 'programme', 'issue', 'partners', 'category'],
    ];

    register_post_type('article', $args);
});