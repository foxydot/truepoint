<?php
/* Subtitle Support */
if(!class_exists('WPAlchemy_MetaBox')){
    include_once WP_CONTENT_DIR.'/wpalchemy/MetaBox.php';
}
global $wpalchemy_media_access;
if(!class_exists('WPAlchemy_MediaAccess')){
    include_once WP_CONTENT_DIR.'/wpalchemy/MediaAccess.php';
}
$wpalchemy_media_access = new WPAlchemy_MediaAccess();
add_action('init','add_aboutyou_metaboxes');
function add_aboutyou_metaboxes(){
        global $aboutyou_metabox;
        $aboutyou_metabox = new WPAlchemy_MetaBox(array
        (
            'id' => '_aboutyou',
            'title' => 'Tab Sections',
            'types' => array('page'),
            'context' => 'normal', // same as above, defaults to "normal"
            'priority' => 'high', // same as above, defaults to "high"
            'template' => get_stylesheet_directory() . '/lib/template/aboutyou-meta.php',
            'autosave' => TRUE,
            'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
            'prefix' => '_msdlab_' // defaults to NULL
        ));
        add_action('admin_footer','aboutyou_footer_hook',10);
}
function aboutyou_footer_hook()
{
    $post = get_post($_GET[post]);
    $aboutyou = $post->post_parent==9?true:false;
    if($aboutyou){
    ?><script type="text/javascript">
        jQuery('#postdivrich').after(jQuery('#_aboutyou_metabox'));
    </script><?php
    } else { //hide it on pages that don't match the parent section.
    ?><script type="text/javascript">
        jQuery('#_aboutyou_metabox').remove(); 
    </script><?php    
    }
}

/*function msdlab_do_post_subtitle() {
    global $subtitle_metabox;
    $subtitle_metabox->the_meta();
    $subtitle = $subtitle_metabox->get_the_value('subtitle');

    if ( strlen( $subtitle ) == 0 )
        return;

    $subtitle = sprintf( '<h2 class="entry-subtitle">%s</h2>', apply_filters( 'genesis_post_title_text', $subtitle ) );
    echo apply_filters( 'genesis_post_title_output', $subtitle ) . "\n";

}*/