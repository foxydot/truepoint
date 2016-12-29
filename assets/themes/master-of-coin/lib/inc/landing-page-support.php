<?php
//support for landing page template
if(!class_exists('WPAlchemy_MetaBox')){
    include_once WP_CONTENT_DIR.'/wpalchemy/MetaBox.php';
}
global $wpalchemy_media_access;
if(!class_exists('WPAlchemy_MediaAccess')){
    include_once (WP_CONTENT_DIR.'/wpalchemy/MediaAccess.php');
}
class MSDLandingPage{
    /**
         * A reference to an instance of this class.
         */
        private static $instance;


        /**
         * Returns an instance of this class. 
         */
        public static function get_instance() {

                if( null == self::$instance ) {
                        self::$instance = new MSDLandingPage();
                } 

                return self::$instance;

        } 
        
        private $templates;
        
        /**
         * Initializes the plugin by setting filters and administration functions.
         */
   function __construct() {
            $this->templates = array('landing-page.php','resources-template.php');
        }
        
    function add_metaboxes(){
        global $landing_page_metabox,$wpalchemy_media_access;
        $landing_page_metabox = new WPAlchemy_MetaBox(array
        (
            'id' => '_landing_page',
            'title' => 'Landing Page Feature Blocks',
            'types' => array('page'),
            'context' => 'normal', // same as above, defaults to "normal"
            'priority' => 'high', // same as above, defaults to "high"
            'template' => get_stylesheet_directory() . '/lib/template/metabox-landing-page.php',
            'autosave' => TRUE,
            'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
            'prefix' => '_msdlab_', // defaults to NULL
            'include_template' => array('landing-page.php','resources-template.php'),
        ));
    }
    
    function default_output($feature,$i){
        if($feature['resource-title']=='' || $feature['link']==''){
            return FALSE;
        }
        global $parallax_ids;
        $eo = ($i+1)%2==0?'even':'odd';
        $title = apply_filters('the_title',$feature['resource-title']);
        $slug = sanitize_title_with_dashes(str_replace('/', '-', $title));
        
        $link = $feature['link'];
        $type = $feature['resource-type'];
        if($type != 'VIDEO'){
            $wrapped_type = '<div class="feature-type"><a href="'.$link.'">'.$type.'</a></div>';
            $wrapped_title = trim($title) != ''?apply_filters('msdlab_landing_page_output_title','<div class="feature-title">
                <h3 class="wrap"><a href="'.$link.'">
                    '.$title.'
                </a></h3>
            </div>'):'';
            $featured_image = $feature['resource-image'] !=''?'<div class="feature-img"><a href="'.$link.'"><img src="'.$feature['resource-image'].'" /></a></div>':'';
        } else {
            $wrapped_type = '<div class="feature-type">'.$type.'</div>';
            $wrapped_title = trim($title) != ''?apply_filters('msdlab_landing_page_output_title','<div class="feature-title">
                <h3 class="wrap">
                    '.$title.'
                </h3>
            </div>'):'';
            $featured_image = '<div class="feature-img">'.wp_oembed_get( $feature['link'], array('height'=>165) ).'</div>';
        }
        $classes = apply_filters('msdlab_landing_page_output_classes',array(
            'feature',
            'feature-'.strtolower($type),
            'feature-'.$slug,
            $feature['css-classes'],
            'feature-'.$eo,
            'clearfix',
            'col-sm-4',
            'col-xs-12',
        ));
        $ret = '
        <div id="'.$slug.'" class="'.implode(' ', $classes).'" >
            <div class="wrapper">
                '.$featured_image.'
                '.$wrapped_type.'
                '.$wrapped_title.'
            </div>
        </div>
        ';
        return $ret;
    }

    function landing_page_output(){
        global $meta,$landing_page_metabox;
        $i = 0;
        $meta = $landing_page_metabox->the_meta();
        if($landing_page_metabox->have_fields('features')){
            while($landing_page_metabox->have_fields('features')){
                $features[] = self::default_output($meta['features'][$i],$i);
                $i++;
            }//close while
            print '<div class="landing-page-wrapper">';
            print implode("\n",$features);
            print '</div>';
        }//clsoe if
    }

        function info_footer_hook()
        {
            global $post;
            $postid = is_admin()?$_GET['post']:$post->ID;
            $template_file = get_post_meta($postid,'_wp_page_template',TRUE);
            if(in_array($template_file,$this->templates)){
            ?><script type="text/javascript">
                
                </script><?php
            }
        }
        
        function enqueue_admin(){
            $postid = $_GET['post'];
            $template_file = get_post_meta($postid,'_wp_page_template',TRUE);
            if(in_array($template_file,$this->templates)){
                //js
                wp_enqueue_script('jquery-ui-core');
                wp_enqueue_script('jquery-ui-sortable');
                wp_enqueue_script('landing-admin',WP_PLUGIN_URL.'/msd-specialty-pages/lib/js/landing-input.js',array('jquery'));
                //css
                wp_enqueue_style('landing-admin',WP_PLUGIN_URL.'/msd-specialty-pages/lib/css/landing.css');
            }
        }
}
add_action( 'init', array( 'MSDLandingPage', 'add_metaboxes' ) );