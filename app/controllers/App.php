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

    public static function sbPrintProjectRef($id)
    {
        $ref = get_post_meta($id, 'sb-project-ref');
        if ($ref) {
            $text = '<p class="text-muted project-ref">';
            $text .= '<a data-toggle="tooltip" title="Read more about this project on APN E-Lib"
                       href="'.get_post_meta($id, 'sb-project-elib-url')[0].'">'
                  .'<i class="fa fa-external-link-square"></i> '.$ref[0].'</a></p>';

            return print $text;
        } else {
            return print '<p class="text-muted project-ref" style="color:red !important;">Missing field: sb-project-ref</p>';
        }
    }

    public static function sbGetCoauthorDescription()
    {
        $author = get_queried_object();

        return $author->description;
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
                              esc_attr(sprintf(__('View all articles wiht keyword %s',
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

    public static function sbProgramme()
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
            'post_type' => 'article',
            'tax_query' => [
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
        $terms = get_terms( array(
            'taxonomy' => 'keyword',
            'hide_empty' => true,
            'order_by' => 'count',
        ));

        if (!empty($terms) && !is_wp_error($terms)) {
            $count = count($terms);
            $i = 0;
            $term_list = '<p class="keywords_list">';
            foreach ($terms as $term) {
                $i++;
                $term_list .= '<a href="'.esc_url(get_term_link($term)).
                              '" alt="'.
                              esc_attr(sprintf(__('View all articles wiht keyword %s',
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
}
