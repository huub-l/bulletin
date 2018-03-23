<?php

namespace App;

use Sober\Controller\Controller;
use WP_Query;

class App extends Controller
{
    public function siteName()
    {
        return get_bloginfo('name');
    }

    public static function title()
    {
        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }

            return __('Latest Posts', 'sage');
        }
        if (is_archive()) {
            if (is_author()) {
                if (function_exists('coauthors_posts_links')) {
                    $author = get_queried_object();

                    return $author->display_name;
                } else {
                    return sprintf(__('Author: %s'), '<span class="vcard">'.get_the_author().'</span>');
                }
            } else {
                return get_the_archive_title();
            }
        }
        if (is_search()) {
            return sprintf(__('Search Results for %s', 'sage'), get_search_query());
        }
        if (is_404()) {
            return __('Not Found', 'sage');
        }

        return get_the_title();
    }

    public static function sbGetProjectRef($id)
    {
        $ref = get_post_meta($id, 'sb-project-ref', true);
        if (!empty($ref)) {
            $text = '<p class="text-muted project-ref">';
            $text .= '<a data-toggle="tooltip" title="Read more about this project on APN E-Lib"
                       href="'.get_post_meta($id, 'sb-project-elib-url', true).'">'
                  .'<i class="fa fa-external-link-square"></i> '.$ref.'</a></p>';

            return $text;
        } else {
            return '<p class="text-muted project-ref" style="color:red !important;">Missing field: sb-project-ref</p>';
        }
    }

    public static function sbGetCoauthorDescription()
    {
        $author = get_queried_object();

        return $author->description;
    }

    public static function sbGetCoauthorsByPostId($post_id)
    {
        if (function_exists('coauthors_posts_links')) {
            return get_coauthors($post_id);
        } else {
            return get_the_author();
        }
    }

    public static function sbGetIssueTermByPostId($post_id)
    {
        $terms = wp_get_post_terms($post_id, 'issue');

        if (!empty($terms) && !is_wp_error($terms)) {
            return $terms[0];
        } else {
            return false;
        }
    }

    public static function sbGetContributorFirst($display_name)
    {
        $name_array = explode(' ', $display_name);
        array_pop($name_array);

        return ucfirst(strtolower(implode(' ', $name_array)));
    }

    public static function sbGetContributorLast($display_name)
    {
        $name_array = explode(' ', $display_name);

        return ucfirst(strtolower(end($name_array)));
    }

    public static function sbGetCitation($id)
    {
        $citation = get_post_meta($id, 'sb-citation-auto');
        if ($citation) {
            if ('' != $citation[0]) {
                return $citation[0];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function sbKeywords()
    {
        $terms = wp_get_post_terms(get_the_id(), 'keyword');

        if (!empty($terms) && !is_wp_error($terms)) {
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

    public static function sbGetProgrammeString()
    {
        $terms = wp_get_post_terms(get_the_id(), 'programme');

        if (!empty($terms) && !is_wp_error($terms)) {
            return implode(', ', wp_list_pluck($terms, 'name'));
        }
    }

    public static function sbGetArticleQuery()
    {
        $args = [
            'post_type'      => 'article',
            'posts_per_page' => '8',
        ];

        return new WP_Query($args);
    }

    public static function sbGetFeaturedQuery()
    {
        $args = [
            'post_type'      => 'article',
            'posts_per_page' => 1,
            'tax_query'      => [
                [
                    'taxonomy' => 'category',
                    'field'    => 'slug',
                    'terms'    => ['featured'],
                ],
            ],
        ];

        return new WP_Query($args);
    }

    public static function sbGetAllKeywords()
    {
        $terms = get_terms([
            'taxonomy'   => 'keyword',
            'hide_empty' => true,
            'order_by'   => 'count',
        ]);

        if (!empty($terms) && !is_wp_error($terms)) {
            $count = count($terms);
            $i = 0;
            $term_list = '';
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
                    $term_list .= '';
                }
            }

            return $term_list;
        } else {
            return '<p class="keywords_list" style="color:red">To be added</p>';
        }
    }

    public static function sbGetAllIssues()
    {
        return get_terms('issue', [
                'hide_empty' => false,
                'orderby'    => 'name',
                'order'      => 'DESC',
                ]);
    }

    public static function sbGetIssue()
    {
        $terms = wp_get_post_terms(get_the_id(), 'issue');

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

    public static function sbGetDoiLink($id)
    {
        $doi = get_post_meta($id, 'sb-doi', true);
        if (!empty($doi)) {
            $text = '<a href="https://doi.org/'.$doi.'"><i class="fa fa-external-link-square"></i> https://doi.org/'.$doi.'</a>';

            return $text;
        } else {
            return false;
        }
    }

    public static function sbGetPartners()
    {
        $terms = wp_get_post_terms(get_the_id(), 'partner');

        if (!empty($terms) && !is_wp_error($terms)) {
            $count = count($terms);
            $i = 0;
            $term_list = '<p class="keywords_list">';
            foreach ($terms as $term) {
                $i++;
                $term_list .= '<a href="'.esc_url(get_term_link($term)).
                              '" alt="'.
                              esc_attr(sprintf(__('View all articles with the involvement of %s',
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
            return false;
        }
    }

    public static function sbGetProgramme()
    {
        $terms = wp_get_post_terms(get_the_id(), 'programme');

        if (!empty($terms) && !is_wp_error($terms)) {
            $count = count($terms);
            $i = 0;
            $term_list = '<p class="keywords_list">';
            foreach ($terms as $term) {
                $i++;
                $term_list .= '<a href="'.esc_url(get_term_link($term)).
                              '" alt="'.
                              esc_attr(sprintf(__('View all articles funded under programme %s',
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
            return false;
        }
    }
}
