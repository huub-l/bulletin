<?php

namespace App;

use Sober\Controller\Controller;

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
            if (is_author()){
                if ( function_exists( 'coauthors_posts_links' ) ){
                    $author = get_queried_object();
                    return $author->display_name;
                }else{
                    return sprintf( __( 'Author: %s' ), '<span class="vcard">' . get_the_author() . '</span>' );
                }
            }else{
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

    public static function sbPrintProjectRef($id){
        $ref = get_post_meta($id, "sb-project-ref");
        if($ref) {
            $text = '<p class="text-muted project-ref">';
            $text .= '<a data-toggle="tooltip" title="Read more about this project on APN E-Lib"
                       href="'.get_post_meta($id, "sb-project-elib-url")[0].'">'
                  .$ref[0]
                  .'</a></p>';
            return print($text);
        } else {
            return print('<p class="text-muted project-ref">"sb-project-ref"</p>');
        }
    }

    public static function sbGetCoauthorDescription(){
        $author = get_queried_object();
        return $author->description;
    }
}
