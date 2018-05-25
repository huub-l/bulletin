<?php

add_action('init', function () {

    /**
     * Taxonomy: Corresponding author.
     */
    $labels = [
               'name'   => __('Corresponding Author ID', 'sage'),
        'singular_name' => __('Corresponding Author ID', 'sage'),
        'add_new_item'  => __('Add Corresponding Author ID', 'sage'),
        'popular_items'              => __( 'Popular Author IDs', 'sage' ),
        'all_items'                  => __( 'All Registered Corresponding Author IDs', 'sage' ),
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => __( 'Edit Author ID', 'sage' ),
        'update_item'                => __( 'Update Author ID', 'sage' ),
        'add_new_item'               => __( 'Add New Author ID', 'sage' ),
        'new_item_name'              => __( 'New Author ID name', 'sage' ),
        'separate_items_with_commas' => __( 'Separate IDs with commas', 'sage' ),
        'add_or_remove_items'        => __( 'Add or remove Author IDs', 'sage' ),
        'choose_from_most_used'      => __( 'Choose from the most used IDs', 'sage' ),
        'not_found'                  => __( 'No Ids found.', 'sage' ),
        'menu_name'                  => __( 'Corresponding Authors ID', 'sage' ),
       ];

    $args = [
        'label'              => __('Corresponding Author ID', 'sage'),
        'labels'             => $labels,
        'public'             => false,
        'publicly_queryable' => false,
        'hierarchical'       => false,
        'show_ui'            => true,
        'show_in_menu'       => false,
        'show_in_nav_menus'  => false,
        'show_in_rest'       => false,
        'query_var'          => true,
        'rewrite'            => false,
        'show_admin_column'  => false,
        'show_in_quick_edit' => true,
       ];
    register_taxonomy('corresponding-author-id', ['article'], $args);
});
