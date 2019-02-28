<?php

namespace App;

use APp\Controllers\Article;

/*
 * Create a meta box that shows author IDs
 */

add_action('add_meta_boxes', function () {
    add_meta_box(
        'article-side-help',
        'IDs for metadata',
        function () {
            $article = new Article(get_the_ID());
            $authors = $article->getCoauthors();
            echo '<p><strong>Article ID:</strong> '.get_the_ID().'</p>';
            echo '<p><strong>Authors:</strong></p>';
            foreach ($authors as $author) {
                echo '<p><span style="color:red">'.$author->ID.'</span>';
                echo ': '.$author->display_name;
                echo '</span></p>';
            }
        },
        'article',
        'side',
        'default'
    );
});
