<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class Article extends Controller
{
    public $id;

    public function __construct($id = 0)
    {
        $this->id = $id;
    }

    /**
     * Returns the sb-citedby-count-auto field of the article
     * or 0 if not found.
     *
     * @return bool
     */
    public function getCitedByCount()
    {
        $citedByCount = get_post_meta($this->id, '_sb-citedby-count', true);

        if (!empty($citedByCount)) {
            return $citedByCount;
        }

        return 0;
    }

    /**
     * Returns the doi field of the article or false if not found.
     */
    public function getDoi()
    {
        $doi = get_post_meta($this->id, 'sb-doi', true);
        if (!empty($doi)) {
            return $doi;
        }

        return false;
    }

    /**
     * Returns the pdf-url field of the article or false if not found.
     */
    public function getPdfUrl()
    {
        $url = get_post_meta($this->id, 'sb-pdf-url', true);

        if (!empty($url)) {
            return $url;
        }

        return false;
    }

    /**
     * Return the coauthors or author, if CoAuthorPlus plugin does not exist.
     */
    public function getCoauthors()
    {
        if (function_exists('coauthors_posts_links')) {
            return get_coauthors($this->id);
        } else {
            return get_the_author();
        }
    }

    /**
     * Return formatted links of authors of an article.
     */
    public function getCoauthorsLinks()
    {
        if (function_exists('coauthors_posts_links')) {
            $authors = $this->getCoauthors();
            $links = '';

            switch (count($authors)) {
                case 0:
                    break;
                case 1:
                    $links .= $this->getIndividualCoauthorLink($author[0]);
                    break;
                default:
                    $maxKey = count($authors) - 1;

                    foreach ($authors as $k => $author) {
                        if ($k == $maxKey) {
                            $links .= 'and ';
                        }

                        $links .= $this->getIndividualCoauthorLink($author);

                        if ($k != $maxKey) {
                            $links .= ', ';
                        }
                    }
            }

            return $links;
        } else {
            return get_the_author();
        }
    }

    /**
     * Return formatted link of an author.
     *
     * @param object $author
     *
     * @return string $link
     */
    private function getIndividualCoauthorLink($author)
    {
        $url = get_author_posts_url($author->ID, $author->user_nicename);

        // Add hyperlink
        $link = '<a href="'.$url.'"'
                .' title="Articles by '
                .$author->display_name
                .'" class="author url fn" rel="author">';

        $link .= $author->display_name;

        // Add envelop to corresponding authors
        $correspondingAuthorIds = $this->getCorrespondingAuthorIds();

        foreach ($correspondingAuthorIds as $id) {
            if ($author->ID == $id) {
                $link .= ' <sup aria-hidden="true"><i class="fa fa-envelope-o"></i></sup>';
                break;
            }
        }

        $link .= '</a>';

        return $link;
    }

    /**
     * Return formatted link of an author.
     *
     * @param object $author
     *
     * @return array
     */
    private function getCorrespondingAuthorIds()
    {
        return wp_get_post_terms(
            $this->id,
            'corresponding-author-id',
            ['fields' => 'names']
        );
    }

    /**
     * Return keywords of an article or false if not found.
     */
    public function getKeywords()
    {
        $terms = wp_get_post_terms($this->id, 'keyword');

        if (!empty($terms) && !is_wp_error($terms)) {
            return $terms;
        }

        return false;
    }

    /**
     * Return a formatted html string of keywords.
     *
     * @return string
     */
    public function getKeywordsList()
    {
        $terms = $this->getKeywords();

        if (!empty($terms)) {
            $count = count($terms);
            $i = 0;
            $term_list = '<p class="keywords_list">';
            foreach ($terms as $term) {
                $i++;
                $term_list .= '<a href="'.esc_url(get_term_link($term)).
                              '" alt="'.
                              esc_attr(sprintf(__('View all articles with keyword %s',
                              'sage'), ucfirst($term->name))).
                              '">'.ucfirst($term->name).'</a>';
                if ($count != $i) {
                    $term_list .= ' &middot; ';
                } else {
                    $term_list .= '</p>';
                }
            }

            return $term_list;
        } else {
            return '<p class="keywords_list" style="color:red">To be added</p>';
        }
    }

    /**
     * Return the formatted citation of an article.
     *
     * @return void
     */
    public function getCitation()
    {
        $citation = get_post_meta($this->id, 'sb-citation-auto', true);

        if (!empty($citation)) {
            return $citation;
        }

        return false;
    }

    /**
     * Return issue term of an article or false if not found.
     */
    public function getIssueTerm()
    {
        $terms = wp_get_post_terms($this->id, 'issue');

        if (!empty($terms) && !is_wp_error($terms)) {
            return $terms[0];
        } else {
            return false;
        }
    }

    /**
     * Returns a string of an article or false if not found.
     */
    public function getProgrammeString()
    {
        $terms = wp_get_post_terms($this->id, 'programme');

        if (!empty($terms) && !is_wp_error($terms)) {
            return implode(', ', wp_list_pluck($terms, 'name'));
        } else {
            return false;
        }
    }

    /**
     * Return the html for the link to issue.
     *
     * @return void
     */
    public function getIssueLink()
    {
        $terms = wp_get_post_terms($this->id, 'issue');

        if (!empty($terms) && !is_wp_error($terms)) {
            $count = count($terms);
            $i = 0;
            $term_list = '<p class="keywords_list">';
            foreach ($terms as $term) {
                $i++;
                $term_list .= '<a href="'.esc_url(get_term_link($term)).
                              '" alt="'.
                              esc_attr(sprintf(__('View all articles under %s',
                              'sage'), ucfirst($term->name))).
                              '">'.ucfirst($term->name).'</a>';
                if ($count != $i) {
                    $term_list .= ' &middot; ';
                } else {
                    $term_list .= '</p>';
                }
            }

            return $term_list;
        } else {
            return '<p class="keywords_list" style="color:red">To be added</p>';
        }
    }

    /**
     * Returns the project reference of an article.
     */
    public function getProjectRef()
    {
        $ref = get_post_meta($this->id, 'sb-project-ref', true);

        if (!empty($ref)) {
            return $ref;
        } else {
            return false;
        }
    }

    /**
     * Returns the e-lib URL of reference of an article.
     */
    public function getElibUrl()
    {
        $url = get_post_meta($this->id, 'sb-project-elib-url', true);

        if (!empty($url)) {
            return $url;
        } else {
            return false;
        }
    }

    /**
     * Returns the Unix timestamp of the next_check.
     *
     * @return int
     */
    public function getNextCitedByCheckTime()
    {
        $next = get_post_meta($this->id, '_sb-citedby-next-check-time', true);

        if (!$next) {
            return 0;
        } else {
            return (int) $next;
        }
    }

    /**
     * Update the the Unix timestamp of the next_check.
     *
     * @return int
     */
    public function setNextCitedByCheckTime()
    {
        $next = time() + 60 * 60 * 24 * 7;
        update_post_meta($this->id, '_sb-citedby-next-check-time', $next);
    }

    /**
     * Updates the sb-citedby-count-auto field if the count
     * is different from its last value.
     *
     * @return bool True if changed, false if unchanged.
     */
    public function updateCitedByCount()
    {
        $doi = $this->getDoi();

        if ($doi) {
            $citation = new Citation(get_the_title($this->id), $doi);
            $oldCount = $this->getCitedByCount();
            $newCount = $citation->retrieveCitedByCount();

            if ($oldCount != $newCount) {
                update_post_meta($this->id, '_sb-citedby-count', $newCount);

                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Update forward-link fields for the article.
     *
     * @return void
     */
    public function updateForwardLinks()
    {
        $doi = $this->getDoi();

        if ($doi) {
            $citation = new Citation(get_the_title($this->id), $doi);
            $xmlElement = $citation->getCitedByXml();

            if ($xmlElement) {
                $citations = $this->getForwardLinkCitations($xmlElement);

                if (!empty($citations)) {
                    delete_post_meta($this->id, '_sb-citedby-auto');
                    $count = count($citations);

                    if ($this->getCitedByCount() != $count) {
                        foreach ($citations as $citation) {
                            add_post_meta($this->id, '_sb-citedby-auto', $citation);
                        }
                        update_post_meta($this->id, '_sb-citedby-count', $count);
                    }
                } else {
                    return;
                }
            }
        }
    }

    /**
     * Return an array of citations given a
     * CrossRef result XML.
     *
     * @return array Array of citations, or empty array
     */
    private function getForwardLinkCitations($resultXml)
    {
        $citations = [];
        $dois = [];

        // Use 'x' as namespace in order to get matches.
        if ($resultXml) {
            $dois = $resultXml->xpath('//x:doi');
        }

        if (!empty($dois)) {
            foreach ($dois as $doi) {
                $citation = new Citation('', $doi[0]);
                $citations[] = $citation->getFormattedCitation();
            }
        }

        return $citations;
    }

    /**
     * Returns an array of forward links.
     *
     * @return void
     */
    public function getForwardLinks()
    {
        $citations = get_post_meta($this->id, '_sb-citedby-auto', false);

        return $citations;
    }
}
