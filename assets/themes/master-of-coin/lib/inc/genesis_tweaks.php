<?php
global $wp_filter;
//ts_var( $wp_filter['genesis_before_footer'] );
require_once('genesis_tweak_functions.php');
/*** GENERAL ***/
add_theme_support( 'html5' );//* Add HTML5 markup structure
add_theme_support( 'genesis-responsive-viewport' );//* Add viewport meta tag for mobile browsers MOVED
add_theme_support( 'custom-background' );//* Add support for custom background
add_filter( 'edit_post_link', '__return_false' );
//* Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
'header',
'nav',
'subnav',
'footer',
'site-inner',
'footer-widgets',
) );
/*** HEADER ***/
add_action('genesis_before_header','msdlab_pre_header');
//add_action( 'msdlab_pre_header', 'genesis_do_subnav' );
add_action('msdlab_pre_header','msdlab_pre_header_sidebar');
add_action('wp_head','msdlab_add_open_graph_meta',1);
add_action('wp_head','msdlab_add_apple_touch_icons',1);
add_filter( 'genesis_search_text', 'msdlab_search_text' ); //customizes the serach bar placeholder
add_filter('genesis_search_button_text', 'msdlab_search_button'); //customize the search form to add fontawesome search button.
add_filter('genesis_do_subnav','msdlab_subnav_right',10,2);
add_action('genesis_before_header','msdlab_logo_for_print');
/*** NAV ***//**
 * Move nav into header
 */
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav' );

//*** SIDEBARS ***/
//add_action('genesis_before', 'msdlab_ro_layout_logic'); //This ensures that the primary sidebar is always to the left.
add_action('after_setup_theme','msdlab_add_extra_theme_sidebars', 4); //creates widget areas for a hero and flexible widget area
add_filter('widget_text', 'do_shortcode');//shortcodes in widgets
global $wp_embed;
add_filter( 'widget_text', array( $wp_embed, 'run_shortcode' ), 8 );
add_filter( 'widget_text', array( $wp_embed, 'autoembed'), 8 );


/*** CONTENT ***/

add_filter('genesis_breadcrumb_link','msdlab_modify_breadcrumb_clickage');
add_filter('genesis_category_crumb','msdlab_jank_the_cpt_breadcrumb');
add_filter('genesis_single_crumb','msdlab_jank_the_cpt_breadcrumb');
add_filter('genesis_post_type_crumb','msdlab_jank_the_cpt_breadcrumb');
add_filter('genesis_page_crumb','msdlab_jank_the_cpt_breadcrumb');
add_filter('genesis_blog_crumb','msdlab_jank_the_cpt_breadcrumb');
add_filter('genesis_breadcrumb_args', 'msdlab_breadcrumb_args', 10); //customize the breadcrumb output
remove_action('genesis_before_loop', 'genesis_do_breadcrumbs'); //move the breadcrumbs 
add_filter( 'genesis_post_info', 'sp_post_info_filter' );
add_action('genesis_before_content_sidebar_wrap', 'genesis_do_breadcrumbs', 10); //to outside of the loop area
add_action('template_redirect','msdlab_maybe_move_title');
add_shortcode('post_author_bio','msdlab_post_author_bio');
//add_action('genesis_before_entry','msd_post_image');//add the image above the entry
add_action('genesis_entry_header','msdlab_author_image', 1);

//add_action( 'genesis_entry_header', 'msdlab_do_post_subtitle' );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
add_action( 'genesis_entry_header', 'msdlab_post_info', 12 );
add_action('genesis_entry_content',array('MSDNewsCPT','do_news_url_display'), 4);
add_filter('post_type_link',array('MSDNewsCPT','do_news_url'));
add_action( 'genesis_before_post', 'msdlab_post_image', 8 ); //add feature image across top of content on *pages*.
//add_action('template_redirect','msdlab_blog_grid');
add_action('template_redirect','msdlab_blog_index');

remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

add_filter( 'genesis_next_link_text', 'msdlab_older_link_text', 20);
add_filter( 'genesis_prev_link_text', 'msdlab_newer_link_text', 20);

 
/*** FOOTER ***/
add_theme_support( 'genesis-footer-widgets', 1 ); //adds automatic footer widgets

remove_action('genesis_footer','genesis_do_footer'); //replace the footer
add_action('genesis_footer','msdlab_do_social_footer');//with a msdsocial support one

add_action('genesis_footer','msdlab_print_footer');//a friendly print footer

/*** HOMEPAGE (BACKEND SUPPORT) ***/
add_action('after_setup_theme','msdlab_add_homepage_hero_flex_sidebars'); //creates widget areas for a hero and flexible widget area
add_action('after_setup_theme','msdlab_add_homepage_callout_sidebars'); //creates a widget area for a callout bar, usually between the hero and the widget area

/*** SITEMAP ***/
add_action('after_404','msdlab_sitemap');

/*** Blog Header ***/
//add_action('genesis_before_loop','msd_add_blog_header');
add_action('wp_head', 'msdlab_custom_hooks_management');