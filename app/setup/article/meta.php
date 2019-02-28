<?php

namespace App;

use App\Controllers\Article;

/*
 * Add metadata to the article
 * https://github.com/APN-ComDev/bulletin/issues/66
 */

add_action('wp_head', function () {
    if ('article' == get_post_type()) {

        $article = new Article(get_the_ID());

        $authors = $article->getCoauthors();
        $pdfUrl = $article->getPdfUrl();
        $doi = $article->getDoi();
        $keywords = $article->getKeywords();

        echo "\n<!-- Article meta -->\n";

        // Article title

        echo '<meta name="citation_journal_title" content="APN Science Bulletin">'."\n";
        echo '<meta name="citation_issn" content="2522-7971">'."\n";
        echo '<meta name="citation_publisher" content="Asia-Pacific Network for Global Change Research">'."\n";

        // Article title
        echo '<meta name="citation_title" content="'.get_the_title().'">'."\n";

        // Article authors
        foreach ($authors as $author) {
            echo '<meta name="citation_author" content="'.$author->display_name.'">'."\n";
        }

        // Keywords
        if ($keywords) {
            foreach ($keywords as $keyword) {
                echo '<meta name="citation_keywords" content="'.$keyword->name.'">'."\n";
            }
        }

        // Publication date
        echo '<meta name="citation_publication_date" content="'.get_the_date('Y/m/d').'">'."\n";

        // Journal title
        echo '<meta name="citation_journal_title" content="APN Science Bulletin">'."\n";

        // DOI
        if ($doi) {
            echo '<meta name="citation_doi" content="'.$doi.'">'."\n";
        }

        // PDF URL
        if ($pdfUrl) {
            echo '<meta name="citation_pdf_url" content="'.$pdfUrl.'">'."\n";
        }

        // HTML URL
        if (wp_get_shortlink()) {
            echo '<meta name="citation_fulltext_html_url" content="'.wp_get_shortlink().'">'."\n";
        }
    }
});
