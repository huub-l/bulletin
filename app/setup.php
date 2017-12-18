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
        'name' => __('Footer (left)', 'sage'),
        'id'   => 'sidebar-footer-1',
    ] + $config);
    register_sidebar([
        'name' => __('Footer (right)', 'sage'),
        'id'   => 'sidebar-footer-2',
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
        'has_archive'         => true,
        'show_in_menu'        => true,
        'exclude_from_search' => false,
        'capability_type'     => 'post',
        'map_meta_cap'        => true,
        'hierarchical'        => false,
        'rewrite'             => ['slug' => 'article', 'with_front' => true],
        'query_var'           => true,
        'supports'            => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'comments', 'author'],
        'taxonomies'          => ['keyword', 'programme', 'issue', 'partners', 'category'],
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
        'publicly_queryable' => true,
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
        'show_in_quick_edit' => true,
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
        'publicly_queryable' => true,
        'hierarchical'       => true,
        'show_ui'            => true,
        'show_in_menu'       => false,
        'show_in_nav_menus'  => false,
        'query_var'          => true,
        'rewrite'            => ['slug' => 'programme', 'with_front' => true],
        'show_admin_column'  => false,
        'show_in_rest'       => false,
        'rest_base'          => '',
        'show_in_quick_edit' => true,
       ];
    register_taxonomy('programme', ['article'], $args);
});

add_action('init', function () {

    /**
     * Taxonomy: Issues.
     */
    $labels = [
               'name'   => __('Issues', 'sage'),
        'singular_name' => __('Issue', 'sage'),
        'add_new_item'  => __('Add New Issue', 'sage'),
       ];

    $args = [
        'label'              => __('Issue', 'sage'),
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'hierarchical'       => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => true,
        'query_var'          => true,
        'rewrite'            => ['slug' => 'issue', 'with_front' => true],
        'show_admin_column'  => false,
        'show_in_rest'       => false,
        'rest_base'          => '',
        'show_in_quick_edit' => true,
       ];
    register_taxonomy('issue', ['article'], $args);
});

add_action('init', function () {

    /**
     * Taxonomy: Partners.
     */
    $labels = [
               'name'   => __('Partners', 'sage'),
        'singular_name' => __('Partner', 'sage'),
        'add_new_item'  => __('Add New Partner', 'sage'),
       ];

    $args = [
        'label'              => __('Partner', 'sage'),
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'hierarchical'       => false,
        'show_ui'            => true,
        'show_in_menu'       => false,
        'show_in_nav_menus'  => true,
        'query_var'          => true,
        'rewrite'            => ['slug' => 'partner', 'with_front' => true],
        'show_admin_column'  => false,
        'show_in_rest'       => false,
        'rest_base'          => '',
        'show_in_quick_edit' => false,
       ];
    register_taxonomy('partner', ['article'], $args);
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
add_image_size('home-small', 510, 200, true);
add_image_size('home-featured', 1110, 400, true);

// Add thickbox script
add_action('wp_enqueue_scripts', 'add_thickbox');

// Add menu to Admin Guide
add_action('admin_menu', function () {
    global $menu;
    add_menu_page('SB Admin Guide', 'SB Admin Guide', 'read', 'sb-admin-guide', '', 'dashicons-editor-help', 1);
    $menu[1][2] = 'https://www.apn-gcr.org/bulletin/wp-admin/sb-admin-guide/site/';
});

// Add editor style
add_editor_style();

/* Add custom metadata to the "Issue" term. 
 * 
 * - **Form of publication (print, online, both)**
 * - E-Lib URL (legacy issues)
 * - Cover image md5 (legacy issues)
 * 
 */ 

// Add "publication form" field for "issues"
add_action( 'issue_add_form_fields', function($taxonomy){

    $issue_types = array(
        'onlineprint' => __('Online & print', 'sage'),
        'online' => __('Online', 'sage'),
        'print' => __('Print', 'sage'),
    );

    ?><div class="form-field term-group">
        <label for="issue_type"><?php _e('Publication form', 'sage'); ?></label>
        <select class="postform" id="issue_type" name="issue_type">
            <?php foreach ($issue_types as $key => $issue_type) : ?>
                <option value="<?php echo $key; ?>" class=""><?php echo $issue_type; ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div><?php

}, 10, 2 );


// Save the issue "publication form"
add_action( 'created_issue', function($term_id, $tt_id){

    if( isset( $_POST['issue_type'] ) && '' !== $_POST['issue_type'] ){
        $issue_type = sanitize_title( $_POST['issue_type'] );
        add_term_meta( $term_id, 'issue_type', $issue_type, true );
    }

}, 10, 2 );


// Edit the issue "publication form"
add_action( 'issue_edit_form_fields', function($term, $taxonomy){

    $issue_types = array(
        'onlineprint' => __('Online & print', 'sage'),
        'online' => __('Online', 'sage'),
        'print' => __('Print', 'sage'),
    );

    $selected_issue_type = get_term_meta( $term->term_id, 'issue_type', true );

    ?><tr class="form-field term-group-wrap">
        <th scope="row"><label for="issue_type"><?php _e( 'Publication form', 'sage' ); ?></label></th>
        <td><select class="postform" id="issue_type" name="issue_type">
            <?php foreach( $issue_types as $key => $issue_type ) : ?>
                <option value="<?php echo $key; ?>" <?php selected( $selected_issue_type, $key ); ?>><?php echo $issue_type; ?></option>
            <?php endforeach; ?>
        </select></td>
    </tr><?php

}, 10, 2 );


// Save the edited issue "publication form"
add_action( 'edited_issue', function($term_id, $tt_id){

    if( isset( $_POST['issue_type'] ) && '' !== $_POST['issue_type'] ){
        $issue_type = sanitize_title( $_POST['issue_type'] );
        update_term_meta( $term_id, 'issue_type', $issue_type );
    }

}, 10, 2 );


// Show "publication form" column in the term list
add_filter('manage_edit-issue_columns', function($columns){

    $columns['issue_type'] = __( 'Publication form', 'sage' );
    return $columns;

} );

// Add "publication form" text to column in term list
add_filter('manage_issue_custom_column', function($content, $column_name, $term_id){

    $issue_types = array(
        'onlineprint' => __('Online & print', 'sage'),
        'online' => __('Online', 'sage'),
        'print' => __('Print', 'sage'),
    );

    if( $column_name !== 'issue_type' ){
        return $content;
    }

    $term_id = absint( $term_id );
    $issue_type = get_term_meta( $term_id, 'issue_type', true );

    if( !empty( $issue_type ) ){
        $content .= esc_attr( $issue_types[ $issue_type ] );
    }

    return $content;

}, 10, 3 );

/* Add custom metadata to the "Issue" term. 
 * 
 * - Form of publication (print, online, both)
 * - **E-Lib URL (legacy issues)**
 * - Cover image md5 (legacy issues)
 * 
 */ 

// Add "Elib URL" field for "issues"
add_action( 'issue_add_form_fields', function($taxonomy){

    ?><div class="form-field term-group">
        <label for="elib_url"><?php _e('Full Elib URL (legacy)', 'sage'); ?></label>
        <input id="elib_url" name="elib_url" type="text">
        <p class="description">For issues 1-6, paste the full URL of the publication on E-Lib. 
        Ignore this if the issue is not housed in E-Lib.</p>
    </div><?php

}, 10, 2 );

// Save the issue "Elib URL"
add_action( 'created_issue', function($term_id, $tt_id){

    if( isset( $_POST['elib_url'] ) && '' !== $_POST['elib_url'] ){
        $elib_url = sanitize_text_field( $_POST['elib_url'] );
        add_term_meta( $term_id, 'elib_url', $elib_url, true );
    }

}, 10, 2 );

// Edit the issue "Elib URL"
add_action( 'issue_edit_form_fields', function($term, $taxonomy){

    $selected_elib_url = get_term_meta( $term->term_id, 'elib_url', true );

    ?><tr class="form-field term-group-wrap">
        <th scope="row"><label for="elib_url"><?php _e( 'Elib URL (legacy)', 'sage' ); ?></label></th>
        <td><div class="form-field term-group">
        <input id="elib_url" name="elib_url" type="text" value="<?php echo $selected_elib_url; ?>">
        <p class="description">For issues 1-6, paste the full URL of the publication on E-Lib. 
        Ignore this if the issue is not housed in E-Lib.</p>
    </div></td>
    </tr><?php

}, 10, 2 );

// Save the edited issue "Elib URL"
add_action( 'edited_issue', function($term_id, $tt_id){

    if( isset( $_POST['elib_url'] ) && '' !== $_POST['elib_url'] ){
        $elib_url = sanitize_title( $_POST['elib_url'] );
        update_term_meta( $term_id, 'elib_url', $elib_url );
    }

}, 10, 2 );

/* Add custom metadata to the "Issue" term. 
 * 
 * - Form of publication (print, online, both)
 * - E-Lib URL (legacy issues)
 * - **Cover image md5 (legacy issues)**
 * 
 */ 

// Add "Cover image md5" field for "issues"
add_action( 'issue_add_form_fields', function($taxonomy){

    ?><div class="form-field term-group">
        <label for="cover_image_md5"><?php _e('Cover image md5 (legacy)', 'sage'); ?></label>
        <input id="cover_image_md5" name="cover_image_md5" type="text">
        <p class="description">For issues 1-6, paste the "md5" part from the cover image URL. 
        This is used to construct the cover image from print issues housed in E-Lib. Ignore
        this for new issues. Example: 6dc710544598a0ad8d8b9bf13a1d7e6a for issue 6.</p>
    </div><?php

}, 10, 2 );

// Save the issue "Cover image md5"
add_action( 'created_issue', function($term_id, $tt_id){

    if( isset( $_POST['cover_image_md5'] ) && '' !== $_POST['cover_image_md5'] ){
        $cover_image_md5 = sanitize_text_field( $_POST['cover_image_md5'] );
        add_term_meta( $term_id, 'cover_image_md5', $cover_image_md5, true );
    }

}, 10, 2 );

// Edit the issue "Cover image md5"
add_action( 'issue_edit_form_fields', function($term, $taxonomy){

    $selected_md5 = get_term_meta( $term->term_id, 'cover_image_md5', true );

    ?><tr class="form-field term-group-wrap">
        <th scope="row"><label for="cover_image_md5"><?php _e( 'Cover image md5 (legacy)', 'sage' ); ?></label></th>
        <td><div class="form-field term-group">
        <input id="cover_image_md5" name="cover_image_md5" type="text" value="<?php echo $selected_md5; ?>">
        <p class="description">For issues 1-6, paste the "md5" part from the cover image URL. 
        This is used to construct the cover image from print issues housed in E-Lib. Ignore
        this for new issues. Example: 6dc710544598a0ad8d8b9bf13a1d7e6a for issue 6.</p>
    </div></td>
    </tr><?php

}, 10, 2 );

// Save the edited issue "Cover image md5"
add_action( 'edited_issue', function($term_id, $tt_id){

    if( isset( $_POST['cover_image_md5'] ) && '' !== $_POST['cover_image_md5'] ){
        $cover_image_md5 = sanitize_title( $_POST['cover_image_md5'] );
        update_term_meta( $term_id, 'cover_image_md5', $cover_image_md5 );
    }

}, 10, 2 );

// Show "cover image" column in the term list
add_filter('manage_edit-issue_columns', function($columns){

    $columns['cover_image_md5'] = __( 'Cover image', 'sage' );
    return $columns;

} );

// Add "cover image" text to column in term list
add_filter('manage_issue_custom_column', function($content, $column_name, $term_id){

    $term_id = absint( $term_id );
    $cover_image_md5 = get_term_meta( $term_id, 'cover_image_md5', true );
    
    if( $column_name !== 'cover_image_md5' ){
        return $content;
    }

    if( !empty( $cover_image_md5 ) ){
        $content .= '<img width="60%" alt="Cover image this issue" 
                      src="//www.apn-gcr.org/resources/files/thumbnails/'
                      .$cover_image_md5.
                      '.jpg"/>';
    }

    return $content;

}, 10, 3 );