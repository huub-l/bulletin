<?php

add_action('init', function () {

    /**
     * Post Type: SB Articles.
     */
    $labels = [
        'name'          => __('Science Bulletin Articles', 'sage'),
        'singular_name' => __('Science Bulletin Article', 'sage'),
    ];

    $args = [
        'label'               => __('Science Bulletin Articless', 'sage'),
        'labels'              => $labels,
        'description'         => 'Articles in an issue of the APN Science Bulletin',
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
        'rewrite'             => ['slug' => 'article', 'with_front' => false],
        'query_var'           => true,
        'supports'            => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'comments', 'author'],
        'taxonomies'          => ['keyword', 'programme', 'issue', 'partners', 'category'],
    ];

    register_post_type('article', $args);
});
