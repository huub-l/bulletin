<?php

namespace App;

/*
 * Add metadata to the article
 * https://github.com/APN-ComDev/bulletin/issues/66
 */

add_action('wp_head', function () {
    if ('article' == get_post_type()) {

        $articleId = get_the_ID();
        $authors   = App::sbGetCoauthorsByPostId($articleId);
        $pdfUrl    = App::sbGetPdfUrl($articleId);

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

        // PDF URL
        if($pdfUrl) {
          echo '<meta name="citation_pdf_url" content="'. $pdfUrl .'">'."\n";
        }

    }
});
