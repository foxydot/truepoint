<?php 
if (!class_exists('MSDPressCPT')) {
    class MSDPressCPT {
        //Properties
        var $cpt = 'press';

        //Methods
        /**
        * PHP 4 Compatible Constructor
        */
        public function MSDPressCPT(){$this->__construct();}
    
        /**
         * PHP 5 Constructor
         */
        function __construct(){
            global $current_screen;
            //"Constants" setup
            $this->plugin_url = plugin_dir_url('msd-custom-cpt/msd-custom-cpt.php');
            $this->plugin_path = plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php');
            //Actions
            add_action( 'init', array(&$this,'register_cpt_press') );
            add_action('admin_head', array(&$this,'plugin_header'));
            add_action('wp_enqueue_scripts', array(&$this,'add_front_scripts') );
            add_action('admin_enqueue_scripts', array(&$this,'add_admin_scripts') );
            add_action('admin_enqueue_scripts', array(&$this,'add_admin_styles') );
            add_action('admin_footer',array(&$this,'info_footer_hook') );
            // important: note the priority of 99, the js needs to be placed after tinymce loads
            add_action('admin_print_footer_scripts',array(&$this,'admin_print_footer_scripts'),99);
            
            //Filters
            //add_filter( 'pre_get_posts', array(&$this,'custom_query') );
            add_filter( 'enter_title_here', array(&$this,'change_default_title') );
            
        }
        
        function register_cpt_press() {
        
            $labels = array( 
                'name' => _x( 'Press Releases', 'press' ),
                'singular_name' => _x( 'Press Release', 'press' ),
                'add_new' => _x( 'Add New', 'press' ),
                'add_new_item' => _x( 'Add New Press Release', 'press' ),
                'edit_item' => _x( 'Edit Press Release', 'press' ),
                'new_item' => _x( 'New Press Release', 'press' ),
                'view_item' => _x( 'View Press Release', 'press' ),
                'search_items' => _x( 'Search Press Releases', 'press' ),
                'not_found' => _x( 'No press releases found', 'press' ),
                'not_found_in_trash' => _x( 'No press releases found in Trash', 'press' ),
                'menu_name' => _x( 'Press Release', 'press' ),
            );
        
            $args = array( 
                'labels' => $labels,
                'hierarchical' => false,
                'description' => 'Press',
                'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'genesis-cpt-archives-settings' ),
                'taxonomies' => array(),
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'menu_position' => 20,
                
                'show_in_nav_menus' => true,
                'publicly_queryable' => true,
                'exclude_from_search' => true,
                'has_archive' => true,
                'query_var' => true,
                'can_export' => true,
                'rewrite' => array('slug'=>'resources/press-release','with_front'=>false),
                'capability_type' => 'post'
            );
        
            register_post_type( $this->cpt, $args );
        }
        
        function plugin_header() {
            global $post_type;
            ?>
            <?php
        }
        
        
    function print_footer_scripts()
        {

        }      
        function add_front_scripts(){
           global $post_type;
            if($post_type == $this->cpt){
            }
        }
         
        function add_admin_scripts() {
            global $current_screen;
            if($current_screen->post_type == $this->cpt){
            }
        }
        
        function add_admin_styles() {
            global $current_screen;
            if($current_screen->post_type == $this->cpt){
            }
        }   
            
       function admin_print_footer_scripts()
        {
            global $current_screen, $areas;
            if($current_screen->post_type == $this->cpt){}
        }

        function change_default_title( $title ){
            global $current_screen;
            if  ( $current_screen->post_type == $this->cpt ) {
                return __('Press Title','press');
            } else {
                return $title;
            }
        }
        
        function info_footer_hook()
        {
            global $current_screen;
            if($current_screen->post_type == $this->cpt){
                ?><script type="text/javascript">
                    </script><?php
            }
        }
          
  } //End Class
} //End if class exists statement