<?php

namespace App;

/*
 * Create a meta box that shows author IDs
 */

add_action( 'add_meta_boxes', function(){

    add_meta_box( 
        'article-side-help', 
        'IDs for metadata', 
        function () {
            $authors = App::sbGetCoauthorsByPostId(get_the_ID());
            print '<p><strong>Article ID:</strong> '. get_the_ID() .'</p>';
            print '<p><strong>Authors:</strong></p>';
            foreach ( $authors as $author) {
                print '<p><span style="color:red">' . $author->ID . '</span>';
                print ': ' . $author->display_name;
                print '</span></p>';
            }
        }, 
        'article', 
        'side', 
        'default' 
    );

} );
