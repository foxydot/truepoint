<?php
//support for landing page template
if(!class_exists('WPAlchemy_MetaBox')){
    include_once WP_CONTENT_DIR.'/wpalchemy/MetaBox.php';
}
global $wpalchemy_media_access;
if(!class_exists('WPAlchemy_MediaAccess')){
    include_once (WP_CONTENT_DIR.'/wpalchemy/MediaAccess.php');
}
class MSDResourcePage{
    /**
         * A reference to an instance of this class.
         */
        private static $instance;


        /**
         * Returns an instance of this class. 
         */
        public static function get_instance() {

                if( null == self::$instance ) {
                        self::$instance = new MSDResourcePage();
                } 

                return self::$instance;

        } 
        
        private $templates;
        
        /**
         * Initializes the plugin by setting filters and administration functions.
         */
   function __construct() {
            $this->templates = array('resources-template.php');
            add_action('admin_footer',array($this,'info_footer_hook'));
        }
        
    function add_metaboxes(){
        global $resource_page_sidebar_metabox,$wpalchemy_media_access;
        $resource_page_sidebar_metabox = new WPAlchemy_MetaBox(array
        (
            'id' => '_resource_page_sidebar',
            'title' => 'Resource Page Blocks',
            'types' => array('page'),
            'context' => 'normal', // same as above, defaults to "normal"
            'priority' => 'high', // same as above, defaults to "high"
            'template' => get_stylesheet_directory() . '/lib/template/metabox-resource-page.php',
            'autosave' => TRUE,
            'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
            'prefix' => '_msdlab_', // defaults to NULL
            'include_template' => array('resources-template.php'),
        ));
    }
    
    function resource_page_sidebar_output(){
        global $resource_page_sidebar_metabox;
        if(is_object($resource_page_sidebar_metabox)){
            $ret = $resource_page_sidebar_metabox->get_the_value('resource_sidebar');
            $ret = '<div class="sidebar col-sm-4 col-xs-12">'.$ret.'</div>';
            print $ret;
            return true;
        }//clsoe if
        return false;
    }

        function info_footer_hook(){
            $postid = is_admin()?$_GET['post']:$post->ID;
            $template_file = get_post_meta($postid,'_wp_page_template',TRUE);
            if(in_array($template_file,$this->templates)){
            ?><script type="text/javascript">
                
        jQuery('#_resource_page_metabox').before(jQuery('#_landing_page_metabox'));
                </script><?php
            }
        }
        
}
add_action( 'init', array( 'MSDResourcePage', 'add_metaboxes' ) );