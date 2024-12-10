<!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="profile" href="https://gmpg.org/xfn/11">

        <?php wp_head(); ?>
    </head>

    <?php
    $body_classes = [];

    if (berliano_show_sidebar() && is_active_sidebar('sidebar-right')) {
        $body_classes[] = 'layout--has-rsidebar';
    }

    if (berliano_show_sidebar() && is_active_sidebar('sidebar')) {
        $body_classes[] = 'layout--has-lsidebar';
    }
    ?>

    <body <?php body_class($body_classes); ?>>
        <?php wp_body_open(); ?>

        <a class="skip-link screen-reader-text h-shadow-focus" href="#site-content">
            <?php _e('Skip to the content', 'berliano') ?>
        </a>

        <div id="site-container">
            <header id="site-header">
                <?php berliano_cmp_logo(); ?>

                <div class="site-header__search-nav">
                    <?php get_search_form(); ?>

                    <?php if (berliano_show_primary_nav()) { ?>
                        <nav id="site-nav" role="navigation">
                            <ul class="primary-menu has-dark-link">
                                <?php berliano_primary_nav(); ?>
                            </ul>
                        </nav>
                    <?php } ?>

                    <button class="mobile-nav-toggle js-mobile-nav-show" aria-label="<?php esc_attr_e('Open navigation menu', 'berliano') ?>" aria-expanded="false">
                        <?php berliano_the_theme_svg('nav'); ?>
                    </button>
                </div>
            </header>

            <div id="site-wrapper">
                <main id="site-content" role="main">