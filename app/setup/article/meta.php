<?php

namespace App;

/*
 * Add metadata to the article
 * https://github.com/APN-ComDev/bulletin/issues/66
 */

add_action('wp_head', function () {
    if ('article' == get_post_type()) {
        $authors = App::sbGetCoauthorsByPostId(get_the_ID());

        // Article title
        echo '<meta name="citation_title" content="'.get_the_title().'">'."\n";

        // Article authors
        foreach ($authors as $author) {
            echo '<meta name="citation_author" content="'
               .$author->last_name.', '.$author->first_name.'">'."\n";
        }

        // Publication date
        echo '<meta name="citation_publication_date" content="'.get_the_date('Y/m/d').'">'."\n";

        // Journal title
        echo '<meta name="citation_journal_title" content="APN Science Bulletin">'."\n";
    }
});
