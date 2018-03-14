<?php

namespace App;

/*
 * Create a citation custom field for articles on save / update
 *
 * @param int $post_id The post ID.
 * @param post $post The post object.
 * @param bool $update Whether this is an existing post being updated or not.
 */

add_action('save_post', function ($post_id, $post, $update) {

    // If this isn't an 'article' post, don't update it.
    if ('article' != get_post_type($post_id)) {
        return;
    }

    $citation = new Citation(get_the_title($post_id));
    $journal = new PubJournal();
    $authors = App::sbGetCoauthorsByPostId($post_id);
    $issueTerm = App::sbGetIssueTermByPostId($post_id);
    $contributors = [];

    foreach ($authors as $author) {
        // Get authors

        $contributor = new Contributor('author');

        if ('' != $author->first_name) {
            $contributor->first = $author->first_name;
        } else {
            $contributor->first = App::sbGetContributorFirst($author->display_name);
        }

        if ('' != $author->last_name) {
            $contributor->last = $author->last_name;
        } else {
            $contributor->last = App::sbGetContributorLast($author->display_name);
        }

        $contributors[] = $contributor;
    }

    // Set DOI
    $citation->doi = get_post_meta($post_id, 'sb-doi', true);

    $journal->year = get_the_date('Y', $post_id);

    if ($issueTerm) {
        $journal->volume = get_term_meta($issueTerm->term_id, 'volume', true);
        $journal->issue = get_term_meta($issueTerm->term_id, 'issue', true);
    }

    // - Update the article's metadata.
    update_post_meta($post_id, 'sb-citation-auto', $citation->getBib($journal, $contributors));
}, 100, 3);
