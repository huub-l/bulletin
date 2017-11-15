<?php

namespace App;

use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Container;
use Roots\Sage\Template\Blade;
use Roots\Sage\Template\BladeProvider;

/*
 * Theme assets
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('sage/main.css', asset_path('styles/main.css'), false, null);
    wp_enqueue_script('sage/main.js', asset_path('scripts/main.js'), ['jquery'], null, true);
}, 100);

/*
 * Theme setup
 */
add_action('after_setup_theme', function () {
    /*
     * Enable features from Soil when plugin is activated
     * @link https://roots.io/plugins/soil/
     */
    add_theme_support('soil-clean-up');
    add_theme_support('soil-jquery-cdn');
    add_theme_support('soil-nav-walker');
    add_theme_support('soil-nice-search');
    add_theme_support('soil-relative-urls');

    /*
     * Enable plugins to manage the document title
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /*
     * Register navigation menus
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage'),
    ]);

    /*
     * Enable post thumbnails
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /*
     * Enable HTML5 markup support
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

    /*
     * Enable selective refresh for widgets in customizer
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
     */
    add_theme_support('customize-selective-refresh-widgets');

    /*
     * Use main stylesheet for visual editor
     * @see resources/assets/styles/layouts/_tinymce.scss
     */
    add_editor_style(asset_path('styles/main.css'));
}, 20);

/*
 * Register sidebars
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ];
    register_sidebar([
        'name' => __('Primary', 'sage'),
        'id'   => 'sidebar-primary',
    ] + $config);
    register_sidebar([
        'name' => __('Footer', 'sage'),
        'id'   => 'sidebar-footer',
    ] + $config);
});

/*
 * Updates the `$post` variable on each iteration of the loop.
 * Note: updated value is only available for subsequently loaded views, such as partials
 */
add_action('the_post', function ($post) {
    sage('blade')->share('post', $post);
});

/*
 * Setup Sage options
 */
add_action('after_setup_theme', function () {
    /*
     * Add JsonManifest to Sage container
     */
    sage()->singleton('sage.assets', function () {
        return new JsonManifest(config('assets.manifest'), config('assets.uri'));
    });

    /*
     * Add Blade to Sage container
     */
    sage()->singleton('sage.blade', function (Container $app) {
        $cachePath = config('view.compiled');
        if (!file_exists($cachePath)) {
            wp_mkdir_p($cachePath);
        }
        (new BladeProvider($app))->register();

        return new Blade($app['view']);
    });

    /*
     * Create @asset() Blade directive
     */
    sage('blade')->compiler()->directive('asset', function ($asset) {
        return '<?= '.__NAMESPACE__."\\asset_path({$asset}); ?>";
    });
});

add_action('init', function () {

    /**
     * Post Type: SB Articles.
     */
    $labels = [
        'name'          => __('SB Articles', 'sage'),
        'singular_name' => __('SB Article', 'sage'),
    ];

    $args = [
        'label'               => __('SB Articles', 'sage'),
        'labels'              => $labels,
        'description'         => 'Articles in a science bulletin',
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_rest'        => false,
        'rest_base'           => '',
        'has_archive'         => false,
        'show_in_menu'        => true,
        'exclude_from_search' => false,
        'capability_type'     => 'post',
        'map_meta_cap'        => true,
        'hierarchical'        => false,
        'rewrite'             => ['slug' => 'article', 'with_front' => true],
        'query_var'           => true,
        'supports'            => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'comments', 'author'],
        'taxonomies'          => ['keyword', 'programme', 'category'],
    ];

    register_post_type('article', $args);
});

add_action('init', function () {

    /**
     * Taxonomy: Keywords.
     */
    $labels = [
        'name'          => __('Keywords', 'sage'),
        'singular_name' => __('Keyword', 'sage'),
    ];

    $args = [
        'label'              => __('Keywords', 'sage'),
        'labels'             => $labels,
        'public'             => true,
        'hierarchical'       => false,
        'label'              => 'Keywords',
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => true,
        'query_var'          => true,
        'rewrite'            => ['slug' => 'keyword', 'with_front' => true],
        'show_admin_column'  => false,
        'show_in_rest'       => false,
        'rest_base'          => '',
        'show_in_quick_edit' => false,
    ];
    register_taxonomy('keyword', ['article'], $args);
});

add_action('init', function () {

       /**
        * Taxonomy: Programmes.
        */
    $labels = [
               'name'   => __('Programmes', 'sage'),
        'singular_name' => __('Programme', 'sage'),
        'add_new_item'  => __('Add New Programme', 'sage'),
       ];

    $args = [
               'label'              => __('Programmes', 'sage'),
               'labels'             => $labels,
               'public'             => true,
               'hierarchical'       => true,
        'show_ui'                   => true,
               'show_in_menu'       => false,
               'show_in_nav_menus'  => false,
               'query_var'          => true,
               'rewrite'            => ['slug' => 'programme', 'with_front' => true],
               'show_admin_column'  => false,
               'show_in_rest'       => false,
               'rest_base'          => '',
               'show_in_quick_edit' => false,
       ];
    register_taxonomy('programme', ['article'], $args);
});

// Hide post menue
add_action('admin_menu', function () {
    remove_menu_page('edit.php');
});

// Show posts of 'article' post types on home page
add_action('pre_get_posts', function ($query) {
    if ($query->is_archive()) {
        $query->set('post_type', 'article');
    }

    return $query;
});

// Add image sizes
add_image_size('home-small', 255, 100, true);
add_image_size('home-featured', 570, 400, true);
