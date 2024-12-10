<?php

// Classes
require get_template_directory() . '/inc/utils.php';
require get_template_directory() . '/inc/svg-icons.php';
require get_template_directory() . '/inc/class-berliano-customize.php';
require get_template_directory() . '/inc/class-berliano-walker-comment.php';
require get_template_directory() . '/inc/class-berliano-walker-category.php';

// Widgets
require get_template_directory() . '/widgets/class-berliano-widget-categories.php';
require get_template_directory() . '/widgets/class-berliano-widget-recent-comments.php';
require get_template_directory() . '/widgets/class-berliano-widget-recent-posts.php';

// Components
require get_template_directory() . '/components/archive-header.php';
require get_template_directory() . '/components/alert.php';
require get_template_directory() . '/components/post.php';
require get_template_directory() . '/components/post-card.php';
require get_template_directory() . '/components/post-list.php';
require get_template_directory() . '/components/post-nav.php';
require get_template_directory() . '/components/related-posts.php';
require get_template_directory() . '/components/password-form.php';
require get_template_directory() . '/components/logo.php';
require get_template_directory() . '/components/sidebar.php';
require get_template_directory() . '/components/sidebar-right.php';

/**
 * Theme support
 */
function berliano_theme_support() {
    global $content_width;

	if (!isset($content_width)) {
		$content_width = 800;
    }

    add_theme_support('custom-logo', [
        'width'       => 150,
        'height'      => 40,
        'flex-height' => false,
        'flex-width'  => true,
    ]);
    add_theme_support('automatic-feed-links');
    add_theme_support('custom-background', [
        'default-color' => 'ffffff'
    ]);
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style' ]);

    set_post_thumbnail_size(620, 9999);
    add_image_size('berliano-thumbnail-post', $content_width, 9999);
    add_image_size('berliano-thumbnail-post-small', 50, 9999);

    load_theme_textdomain('berliano');
}

add_action('after_setup_theme', 'berliano_theme_support');

/**
 * Register and Enqueue Assets.
 */
function berliano_register_assets() {
    $theme_version = wp_get_theme()->get('Version');
    $font = has_custom_logo()
        ? 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap'
        : 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&family=Roboto+Condensed&display=swap';

    wp_enqueue_style('berliano-google-fonts', $font, null, null);
    wp_enqueue_style('berliano-css-bundle', get_template_directory_uri() . '/dist/bundle.min.css', null, $theme_version);
    wp_enqueue_script('berliano-js-bundle', get_template_directory_uri() . '/dist/bundle.min.js', null, $theme_version);

    if ((! is_admin()) && is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_enqueue_scripts', 'berliano_register_assets');

/**
 * Enqueue supplemental block editor styles.
 */
function berliano_block_editor_styles() {
    $theme_version = wp_get_theme()->get('Version');

    wp_enqueue_style('berliano-block-editor-styles', get_theme_file_uri('/dist/bundle-editor-block.min.css'), [], $theme_version, 'all');
}

add_action('enqueue_block_editor_assets', 'berliano_block_editor_styles', 1, 1);

/**
 * Register navigation menus.
 */
function berliano_menus() {
    register_nav_menus([
        'primary' => __('Primary Menu', 'berliano'),
    ]);
}

add_action('init', 'berliano_menus');

/**
 * Register widget areas.
 */
function zentile_sidebar_registration() {
    register_widget('Berliano_Widget_Categories');
    register_widget('Berliano_Widget_Recent_Comments');
    register_widget('Berliano_Widget_Recent_Posts');

    $common_options = [
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
        'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
        'after_widget'  => '</div></div>',
    ];

    register_sidebar($common_options + [
        'id'            => 'sidebar',
        'name'          => __('Left Sidebar (Primary)', 'berliano'),
        'description'   => __('Widgets in this area will be displayed in the left sidebar.', 'berliano'),
    ]);

    register_sidebar($common_options + [
        'id'            => 'sidebar-right',
        'name'          => __('Right Sidebar', 'berliano'),
        'description'   => __('Widgets in this area will be displayed in the right sidebar.', 'berliano'),
    ]);

    register_sidebar($common_options + [
        'id'            => 'footer',
        'name'          => __('Footer', 'berliano'),
        'description'   => __('Widgets in this area will be displayed in the footer.', 'berliano'),
    ]);
}

add_action('widgets_init', 'berliano_sidebar_registration');