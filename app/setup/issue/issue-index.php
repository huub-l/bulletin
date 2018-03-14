<?php

// Show "cover image" column in the term list--------------------------------//
add_filter('manage_edit-issue_columns', function ($columns) {
    $columns['cover_image_md5'] = __('Cover image', 'sage');

    return $columns;
});

// Add "cover image" text to column in term list
add_filter('manage_issue_custom_column', function ($content, $column_name, $term_id) {
    $term_id = absint($term_id);
    $cover_image_md5 = get_term_meta($term_id, 'cover_image_md5', true);

    if ($column_name !== 'cover_image_md5') {
        return $content;
    }

    if (!empty($cover_image_md5)) {
        $content .= '<img width="60%" alt="Cover image this issue" 
                      src="//www.apn-gcr.org/resources/files/thumbnails/'
                      .$cover_image_md5.
                      '.jpg"/>';
    }

    return $content;
}, 100, 3);
