<?php
function msdlab_excerpt($content){
    global $post;
    print msdlab_get_excerpt($post->ID);
}

function msdlab_get_excerpt( $post_id, $excerpt_length = 50, $trailing_character = '' ) {
    $the_post = get_post( $post_id );
    $the_excerpt = strip_tags( strip_shortcodes( $the_post->post_excerpt ) );
     
    if ( empty( $the_excerpt ) )
        $the_excerpt = strip_tags( strip_shortcodes( $the_post->post_content ) );
     
    $words = explode( ' ', $the_excerpt, $excerpt_length + 1 );
     
    if( count( $words ) > $excerpt_length )
        $words = array_slice( $words, 0, $excerpt_length );
     
    $the_excerpt = implode( ' ', $words ) . '<a class="excerpt-more" href="'.get_permalink($post_id).'">'.$trailing_character.'</a>';
    return $the_excerpt;
}


// cleanup tinymce for SEO
function fb_change_mce_buttons( $initArray ) {
	//@see http://wiki.moxiecode.com/index.php/TinyMCE:Control_reference
	$initArray['theme_advanced_blockformats'] = 'p,address,pre,code,h3,h4,h5,h6';
	$initArray['theme_advanced_disable'] = 'forecolor';

	return $initArray;
}
add_filter('tiny_mce_before_init', 'fb_change_mce_buttons');
	
// add classes for various browsers
add_filter('body_class','browser_body_class');
function browser_body_class($classes) {
    global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
 
    if($is_lynx) $classes[] = 'lynx';
    elseif($is_gecko) $classes[] = 'gecko';
    elseif($is_opera) $classes[] = 'opera';
    elseif($is_NS4) $classes[] = 'ns4';
    elseif($is_safari) $classes[] = 'safari';
    elseif($is_chrome) $classes[] = 'chrome';
    elseif($is_IE) $classes[] = 'ie';
    else $classes[] = 'unknown';
 
    if($is_iphone) $classes[] = 'iphone';
    if(wp_is_mobile()) $classes[] = 'ismobile';
    return $classes;
}

add_filter('body_class','pagename_body_class');
function pagename_body_class($classes) {
	global $post;
	if(is_page()){
		$classes[] = $post->post_name;
	}
	return $classes;
}

add_filter('body_class','chapter_body_class');
function chapter_body_class($classes) {
    global $post;
    $post_data = get_post(get_topmost_parent($post->ID));
    $classes[] = 'chapter-'.$post_data->post_name;
    return $classes;
}
add_filter('body_class','category_body_class');
function category_body_class($classes) {
    global $post;
	$post_categories = wp_get_post_categories( $post->ID );
	foreach($post_categories as $c){
		$cat = get_category( $c );
		$classes[] = 'category-'.$cat->slug;
	}
    return $classes;
}

// add classes for subdomain
if(is_multisite()){
	add_filter('body_class','subdomain_body_class');
	function subdomain_body_class($classes) {
		global $subdomain;
		$site = get_current_site()->domain;
		$url = get_bloginfo('url');
		$sub = preg_replace('@http://@i','',$url);
		$sub = preg_replace('@'.$site.'@i','',$sub);
		$sub = preg_replace('@\.@i','',$sub);
		$classes[] = 'site-'.$sub;
		$subdomain = $sub;
		return $classes;
	}
}

add_action('template_redirect','set_chapter');
function set_chapter(){
	global $post, $chapter;
	$chapter = get_chapter();
}

function get_chapter(){
    global $post;
    $post_data = get_post(get_topmost_parent($post->ID));
    $chapter = $post_data->post_name;
    return $chapter;
}

function get_topmost_parent($post_id){
	$parent_id = get_post($post_id)->post_parent;
	if($parent_id == 0){
		$parent_id = $post_id;
	}else{
		$parent_id = get_topmost_parent($parent_id);
	}
	return $parent_id;
}
add_filter( 'the_content', 'msd_remove_msword_formatting' );
function msd_remove_msword_formatting($content){
	global $allowedposttags;
	$allowedposttags['span']['style'] = false;
	$content = wp_kses($content,$allowedposttags);
	return $content;
}

function remove_plaintext_email($emailAddress) {
    $emailRegEx = '/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4})/i';
    return preg_replace_callback($emailRegEx, "encodeEmail", $emailAddress);
}

function encodeEmail($result) {
     return antispambot($result[1]);
}
add_filter( 'the_content', 'remove_plaintext_email', 20 );
add_filter( 'widget_text', 'remove_plaintext_email', 20 );

add_action('init','msd_allow_all_embeds');
function msd_allow_all_embeds(){
	global $allowedposttags;
	$allowedposttags["iframe"] = array(
			"src" => array(),
			"height" => array(),
			"width" => array()
	);
	$allowedposttags["object"] = array(
			"height" => array(),
			"width" => array()
	);

	$allowedposttags["param"] = array(
			"name" => array(),
			"value" => array()
	);

	$allowedposttags["embed"] = array(
			"src" => array(),
			"type" => array(),
			"allowfullscreen" => array(),
			"allowscriptaccess" => array(),
			"height" => array(),
			"width" => array()
	);
    
    $allowedposttags["a"]['data-toggle'] = array();
    $allowedposttags["a"]['data-target'] = array();
}

/* ---------------------------------------------------------------------- */
/* Check the current post for the existence of a short code
/* ---------------------------------------------------------------------- */

if ( !function_exists('msdlab_has_shortcode') ) {

    function msdlab_has_shortcode($shortcode = '') {
    
        global $post;
        $post_obj = get_post( $post->ID );
        $found = false;
        
        if ( !$shortcode )
            return $found;
        if ( stripos( $post_obj->post_content, '[' . $shortcode ) !== false )
            $found = true;
        
        // return our results
        return $found;
    
    }
}

/**
 * Check if a post is a particular post type.
 */
if(!function_exists('is_cpt')){
	function is_cpt($cpt){
		global $post;
		$ret = get_post_type( $post ) == $cpt?TRUE:FALSE;
		return $ret;
	}
}

function remove_wpautop( $content ) { 
    $content = do_shortcode( shortcode_unautop( $content ) ); 
    $content = preg_replace( '#^<\/p>|<br \/?>|<p>$#', '', $content );
    return $content;
}
if(!function_exists('get_attachment_id_from_src')){
function get_attachment_id_from_src ($image_src) {
        global $wpdb;
        $query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
        $id = $wpdb->get_var($query);
        return $id;
    }
}

if(!function_exists('msdlab_get_attachment')){
function msdlab_get_attachment( $attachment_id ) {

    $attachment = get_post( $attachment_id );
    return array(
        'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
        'caption' => $attachment->post_excerpt,
        'description' => $attachment->post_content,
        'href' => get_permalink( $attachment->ID ),
        'src' => $attachment->guid,
        'title' => $attachment->post_title
    );
}
}

add_filter( 'the_content', 'add_bootstrap_allowed_attributes');

function add_bootstrap_allowed_attributes($content){
    global $allowedposttags;
    $atts = array(
        'data-target',
        'data-toggle',
        'data-dismiss',
        'aria-expanded',
        'aria-controls',
        'aria-label',
        'aria-labeledby',
        'aria-describedby',
        'aria-haspopup',
        'role',
        'style',
        'frameBorder',
        'scrolling',
        'height',
        'width',
        );
    foreach($allowedposttags AS $k => $v){
        foreach($atts AS $a){
            $allowedposttags[$k][$a]=true;
        }
    }
    $content = wp_kses($content,$allowedposttags);
    return $content;
}

function msd_has_body_class($class_needle){
    $class_haystack = explode(' ',implode(' ',get_body_class()));
    if(in_array($class_needle,$class_haystack)){
        return true;
    } else {
        return false;
    }
}