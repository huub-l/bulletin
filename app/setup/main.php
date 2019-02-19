<?php

@include 'sidebars.php';
@include 'post-type-article.php';
@include 'tax-keyword.php';
@include 'tax-programme.php';
@include 'tax-issue.php';
@include 'issue/meta-publication-form.php';
@include 'issue/meta-volume-number.php';
@include 'issue/meta-issue-number.php';
@include 'issue/meta-imprint-page-url.php';
@include 'issue/meta-elib-url.php';
@include 'issue/meta-cover-image-md5.php';
@include 'issue/issue-index.php';
@include 'article/citation.php';
@include 'article/meta.php';
@include 'article/meta-box-authors.php';
@include 'article/tax-corresponding-author.php';
@include 'cron.php';


// Hide the "post" menu in wp-admin
add_action('admin_menu', function () {
    remove_menu_page('edit.php');
});

// Show posts of 'article' post types on home page
add_action('pre_get_posts', function ($query) {
    if ($query->is_archive()) {
        $query->set('post_type', 'article');
    }

    return $query;
});

// Add image sizes
add_image_size('home-small', 510, 200, true);
add_image_size('home-featured', 1110, 400, true);

// Add thickbox script
add_action('wp_enqueue_scripts', 'add_thickbox');

// Add menu to the Admin Guide
add_action('admin_menu', function () {
    global $menu;
    add_menu_page('SB Admin Guide', 'SB Admin Guide', 'read', 'sb-admin-guide', '', 'dashicons-editor-help', 1);
    $menu[1][2] = 'https://apn.gitbook.io/sop-comdev/science-bulletin';
});

// Add editor style
add_editor_style();

// Add style to paginator navigation

add_filter('next_posts_link_attributes', function () {
    return 'class="btn btn-primary btn-square prev-post"';
});

add_filter('previous_posts_link_attributes', function () {
    return 'class="btn btn-primary btn-square next-post"';
});
