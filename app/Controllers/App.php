<?php

namespace App\Controllers;

use Dotenv\Dotenv;
use Sober\Controller\Controller;
use WP_Query;

class App extends Controller
{
    public function __construct()
    {
        $dotenv = Dotenv::create(dirname(__DIR__, 2));
        $dotenv->load();
    }

    public function siteName()
    {
        return get_bloginfo('name');
    }

    public static function getTitle()
    {
        if (is_category()) {
            $title = single_cat_title('', false);
        } elseif (is_tag()) {
            $title = single_tag_title('', false);
        } elseif (is_author()) {
            if (function_exists('coauthors_posts_links')) {
                $author = get_queried_object();
                $title = $author->display_name;
            } else {
                $title = sprintf(__('Author: %s'), '<span class="vcard">'.get_the_author().'</span>');
            }
        } elseif (is_post_type_archive()) {
            $title = post_type_archive_title('', false);
        } elseif (is_tax()) {
            $title = single_term_title('', false);
        } else {
            $title = get_the_title();
        }

        return $title;
    }

    public static function sbGetArticleQuery($args = null)
    {
        $args = $args ? $args : ['posts_per_page' => '8'];

        $args['post_type'] = 'article';

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
            'orderby'    => 'name',
            'order'      => 'ASC',
            'hide_empty' => true,
            'number'     => 100,
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
}
