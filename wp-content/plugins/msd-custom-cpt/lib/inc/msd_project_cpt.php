<?php 
if (!class_exists('MSDProjectCPT')) {
    class MSDProjectCPT {
        //Properties
        var $cpt = 'project';
        var $states = array('AL'=>"Alabama",
        'AK'=>"Alaska",
        'AZ'=>"Arizona",
        'AR'=>"Arkansas",
        'CA'=>"California",
        'CO'=>"Colorado",
        'CT'=>"Connecticut",
        'DE'=>"Delaware",
        'DC'=>"District Of Columbia",
        'FL'=>"Florida",
        'GA'=>"Georgia",
        'HI'=>"Hawaii",
        'ID'=>"Idaho",
        'IL'=>"Illinois",
        'IN'=>"Indiana",
        'IA'=>"Iowa",
        'KS'=>"Kansas",
        'KY'=>"Kentucky",
        'LA'=>"Louisiana",
        'ME'=>"Maine",
        'MD'=>"Maryland",
        'MA'=>"Massachusetts",
        'MI'=>"Michigan",
        'MN'=>"Minnesota",
        'MS'=>"Mississippi",
        'MO'=>"Missouri",
        'MT'=>"Montana",
        'NE'=>"Nebraska",
        'NV'=>"Nevada",
        'NH'=>"New Hampshire",
        'NJ'=>"New Jersey",
        'NM'=>"New Mexico",
        'NY'=>"New York",
        'NC'=>"North Carolina",
        'ND'=>"North Dakota",
        'OH'=>"Ohio",
        'OK'=>"Oklahoma",
        'OR'=>"Oregon",
        'PA'=>"Pennsylvania",
        'RI'=>"Rhode Island",
        'SC'=>"South Carolina",
        'SD'=>"South Dakota",
        'TN'=>"Tennessee",
        'TX'=>"Texas",
        'UT'=>"Utah",
        'VT'=>"Vermont",
        'VA'=>"Virginia",
        'WA'=>"Washington",
        'WV'=>"West Virginia",
        'WI'=>"Wisconsin",
        'WY'=>"Wyoming");

        //Methods
        /**
        * PHP 4 Compatible Constructor
        */
        public function MSDProjectCPT(){$this->__construct();}
    
        /**
         * PHP 5 Constructor
         */
        function __construct(){
            global $current_screen;
            //"Constants" setup
            $this->plugin_url = plugin_dir_url('msd-custom-cpt/msd-custom-cpt.php');
            $this->plugin_path = plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php');
            //Actions
            add_action( 'init', array(&$this,'register_taxonomy_project_type') );
            add_action( 'init', array(&$this,'register_taxonomy_market_sector') );
            add_action( 'init', array(&$this,'register_cpt_project') );
            add_action('admin_head', array(&$this,'plugin_header'));
            add_action('wp_enqueue_scripts', array(&$this,'add_front_scripts') );
            add_action('admin_enqueue_scripts', array(&$this,'add_admin_scripts') );
            add_action('admin_enqueue_scripts', array(&$this,'add_admin_styles') );
            add_action('admin_footer',array(&$this,'info_footer_hook') );
            // important: note the priority of 99, the js needs to be placed after tinymce loads
            add_action('admin_print_footer_scripts',array(&$this,'admin_print_footer_scripts'),99);
            
            add_action('wp_enqueue_scripts',array(&$this,'get_project_list'));
            
            // connect your ajax handler to the custom action hook for your action
            add_action('wp_ajax_my_frontend_action', array($this, 'frontend_ajax_handler'));
            add_action('wp_ajax_nopriv_my_frontend_action', array($this, 'frontend_ajax_handler'));
            
            //Filters
            add_filter( 'pre_get_posts', array(&$this,'custom_query') );
            add_filter( 'enter_title_here', array(&$this,'change_default_title') );
            
            // hook add_query_vars function into query_vars
            add_filter('query_vars', array(&$this,'add_query_vars'));
            // hook add_rewrite_rules function into rewrite_rules_array
            add_filter('rewrite_rules_array', array(&$this,'add_rewrite_rules'));
        }

        function register_taxonomy_project_type(){
            
            $labels = array( 
                'name' => _x( 'Project types', 'project-types' ),
                'singular_name' => _x( 'Project type', 'project-types' ),
                'search_items' => _x( 'Search project types', 'project-types' ),
                'popular_items' => _x( 'Popular project types', 'project-types' ),
                'all_items' => _x( 'All project types', 'project-types' ),
                'parent_item' => _x( 'Parent project type', 'project-types' ),
                'parent_item_colon' => _x( 'Parent project type:', 'project-types' ),
                'edit_item' => _x( 'Edit project type', 'project-types' ),
                'update_item' => _x( 'Update project type', 'project-types' ),
                'add_new_item' => _x( 'Add new project type', 'project-types' ),
                'new_item_name' => _x( 'New project type name', 'project-types' ),
                'separate_items_with_commas' => _x( 'Separate project types with commas', 'project-types' ),
                'add_or_remove_items' => _x( 'Add or remove project types', 'project-types' ),
                'choose_from_most_used' => _x( 'Choose from the most used project types', 'project-types' ),
                'menu_name' => _x( 'Project types', 'project-types' ),
            );
        
            $args = array( 
                'labels' => $labels,
                'public' => true,
                'show_in_nav_menus' => true,
                'show_ui' => true,
                'show_tagcloud' => false,
                'hierarchical' => true, //we want a "category" style taxonomy, but may have to restrict selection via a dropdown or something.
        
                'rewrite' => array('slug'=>'project-type','with_front'=>false),
                'query_var' => true
            );
        
            register_taxonomy( 'project_type', array($this->cpt), $args );
        }

        function register_taxonomy_market_sector(){
            
            $labels = array( 
                'name' => _x( 'Market sectors', 'market-sectors' ),
                'singular_name' => _x( 'Market sector', 'market-sectors' ),
                'search_items' => _x( 'Search market sectors', 'market-sectors' ),
                'popular_items' => _x( 'Popular market sectors', 'market-sectors' ),
                'all_items' => _x( 'All market sectors', 'market-sectors' ),
                'parent_item' => _x( 'Parent market sector', 'market-sectors' ),
                'parent_item_colon' => _x( 'Parent market sector:', 'market-sectors' ),
                'edit_item' => _x( 'Edit market sector', 'market-sectors' ),
                'update_item' => _x( 'Update market sector', 'market-sectors' ),
                'add_new_item' => _x( 'Add new market sector', 'market-sectors' ),
                'new_item_name' => _x( 'New market sector name', 'market-sectors' ),
                'separate_items_with_commas' => _x( 'Separate market sectors with commas', 'market-sectors' ),
                'add_or_remove_items' => _x( 'Add or remove market sectors', 'market-sectors' ),
                'choose_from_most_used' => _x( 'Choose from the most used market sectors', 'market-sectors' ),
                'menu_name' => _x( 'Market sectors', 'market-sectors' ),
            );
        
            $args = array( 
                'labels' => $labels,
                'public' => true,
                'show_in_nav_menus' => true,
                'show_ui' => true,
                'show_tagcloud' => false,
                'hierarchical' => true, //we want a "category" style taxonomy, but may have to restrict selection via a dropdown or something.
        
                'rewrite' => array('slug'=>'market-sector','with_front'=>false),
                'query_var' => true
            );
        
            register_taxonomy( 'market_sector', array($this->cpt), $args );
        }
        
        function register_cpt_project() {
        
            $labels = array( 
                'name' => _x( 'Projects', 'project' ),
                'singular_name' => _x( 'Project', 'project' ),
                'add_new' => _x( 'Add New', 'project' ),
                'add_new_item' => _x( 'Add New Project', 'project' ),
                'edit_item' => _x( 'Edit Project', 'project' ),
                'new_item' => _x( 'New Project', 'project' ),
                'view_item' => _x( 'View Project', 'project' ),
                'search_items' => _x( 'Search Project', 'project' ),
                'not_found' => _x( 'No project found', 'project' ),
                'not_found_in_trash' => _x( 'No project found in Trash', 'project' ),
                'parent_item_colon' => _x( 'Parent Project:', 'project' ),
                'menu_name' => _x( 'Project', 'project' ),
            );
        
            $args = array( 
                'labels' => $labels,
                'hierarchical' => false,
                'description' => 'Project',
                'supports' => array( 'title', 'editor', 'author', 'thumbnail' ),
                'taxonomies' => array( 'project_type', 'market_sector' ),
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
                'rewrite' => array('slug'=>'project','with_front'=>false),
                'capability_type' => 'post'
            );
        
            register_post_type( $this->cpt, $args );
        }
        
        function plugin_header() {
            global $post_type;
            ?>
            <?php
        }
        
        function add_query_vars($aVars) {
            $aVars[] = "msd_state";
            return $aVars;
        }
 
        function add_rewrite_rules($aRules) {
            $aNewRules['projects-state/?$'] = 'index.php?pagename=projects-state';
            $aNewRules['projects-state/([^/]+)/?$'] = 'index.php?pagename=projects-state&msd_state=$matches[1]';
            $aNewRules['projectInfo'] = 'index.php?pagename=projectInfo';
            $aRules = $aNewRules + $aRules;
            return $aRules;
        }
         
        function get_project_list(){
            global $wp,$wp_query;
            if($wp->query_vars["pagename"] == 'projects-state'){
                remove_action('genesis_entry_header','genesis_do_post_title');
                remove_action('genesis_post_title','genesis_do_post_title');
                remove_action('genesis_entry_content','genesis_do_post_content');
                remove_action( 'genesis_post_content', 'genesis_do_post_content' );
                    
                if(isset($wp_query->query_vars['msd_state'])) {
                    wp_enqueue_script('imagemapster',plugin_dir_url(dirname(__FILE__)).'js/jquery.imagemapster.min.js',array('jquery'),FALSE,TRUE);
                    wp_enqueue_script('showProjectInfo',plugin_dir_url(dirname(__FILE__)).'js/showProjectInfo.js',array('jquery'),FALSE,TRUE);
                    // localize it (define ajax object for your variables)
                    wp_localize_script('showProjectInfo', 'MyAjaxObject', array(
                        'ajax_url' => admin_url('admin-ajax.php'),
                        'nonce' => wp_create_nonce('my-frontend-action-nonce'),
                    ));
                    add_action('genesis_post_content',array(&$this,'state_title'));
                    add_action( 'genesis_post_content', array(&$this,'display_project_list') );
                    add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_sidebar_content_sidebar' );
                    remove_action('genesis_sidebar_alt','genesis_do_sidebar_alt');
                    add_action('genesis_sidebar_alt',array(&$this,'msdlab_do_state_sidebar_alt'));
                    add_action('print_footer_scripts',array(&$this,'print_footer_scripts'));
                } else {
                    add_action( 'genesis_post_content', array(&$this,'display_selection_map') );
                    wp_enqueue_script('imagemapster',plugin_dir_url(dirname(__FILE__)).'js/jquery.imagemapster.min.js',array('jquery'),FALSE,TRUE);
                    wp_enqueue_script('imagemapster-front',plugin_dir_url(dirname(__FILE__)).'js/plugin.jquery.js',array('jquery','imagemapster'),FALSE,TRUE);
                }
            } 
        }

        public function frontend_ajax_handler()
            {
                global $wpdb;
                // now you can access the database
                // make sure the request is legit
                if (!wp_verify_nonce($_POST['nonce'], 'my-frontend-action-nonce')) {
                    exit; 
                }
        
                // print out the POST array
                $post = get_post($_POST['id']);
                print $this->msd_sidebar_project_info_box($post);
                exit; 
            }
        
        function state_title(){
            global $wp,$wp_query;
            $state = urldecode($wp_query->query_vars['msd_state']);
            print '<h1 class="entry-title">'.$this->states[$state].'</h1>';
        }
        
        function display_project_list(){
            global $wp,$wp_query,$location_info,$client_info,$additional_files;
            $state = urldecode($wp_query->query_vars['msd_state']);
            $args = array(
                'post_type' => 'project',
                'numberposts' => 100,
                'post_status' => array( 'publish'),
                'meta_query' => array(
                        array(
                            'key' => '_location_project_states',
                            'value' => $state,
                            'compare' => 'LIKE'
                        ),
                       array(
                           'key' => '_project_feature',
                           'value' => 'true',
                           'compare' => '='
                       )
                    )
            );
            $projects = get_posts($args);
            if(count($projects)>0){
                foreach($projects AS $project){
                    $list .= '<li><a href="'.get_post_permalink($project->ID).'">'.$project->post_title.'</a></li>';
                }
            } else {
                $list = 'Sorry, there are no project abstracts available for '.$this->state[$state].'.';
            }
            print '<h3>Featured Projects</h3><ul class="featured-projects">'.$list.'</ul>';
            $list = '';
            $args = array(
                'post_type' => 'project',
                'numberposts' => 100,
                'post_status' => array( 'publish'),
                'meta_query' => array(
                        array(
                            'key' => '_location_project_states',
                            'value' => $state,
                            'compare' => 'LIKE'
                        ),
                       'meta_qurery' => array(
                            'relation' => 'OR',
                            array(
                               'key' => '_project_feature',
                               'value' => 'true',
                               'compare' => '!='
                           ),
                            array(
                               'key' => '_project_feature',
                               'compare' => 'NOT EXISTS'
                           )  
                        )      
                    )
            );
            $projects = get_posts($args);
            if(count($projects)>0){
                foreach($projects AS $project){
                    $list .= '<li><a href="#'.$project->ID.'" id="'.$project->ID.'">'.$project->post_title.'</a></li>';
                }
            } else {
                $list = 'Sorry, there are no additional projects available for '.$this->state[$state].'.';
            }
            print '<h3>Additional Projects</h3><ul class="additional-projects">'.$list.'</ul>';
        }
        
        function display_selection_map(){
            $map = '
            <div class="imagemap">
                <img id="usa_image_map" src="'.plugin_dir_url(dirname(__FILE__)).'img/map.png" usemap="#usa_image_map">
            </div>
<map id="usa_image_map" name="usa_image_map">
    <area href="TX" state="TX" full="Texas" shape="poly" coords="259,256,275,257,298,258,296,275,296,288,296,289,299,292,301,293,302,293,302,291,303,293,305,293,305,291,307,293,306,295,309,296,311,296,314,296,316,298,317,296,320,297,322,299,323,299,323,301,324,302,326,300,327,300,329,300,329,302,333,304,334,303,335,300,336,300,337,302,340,302,343,303,345,304,347,303,347,301,350,301,351,302,353,300,354,300,355,302,358,302,359,300,360,300,362,302,364,304,366,304,368,305,370,307,372,305,374,306,374,314,374,321,375,329,376,331,377,334,378,338,381,341,381,344,382,344,381,350,379,354,380,356,380,358,380,363,378,365,379,368,374,369,367,372,366,374,364,375,362,376,362,377,358,380,356,382,352,385,347,386,343,389,342,390,338,392,335,393,332,397,329,397,329,398,330,400,329,404,329,407,328,410,327,413,328,415,329,420,329,425,331,426,330,428,328,429,324,426,320,425,319,425,317,425,314,423,310,422,304,419,302,417,302,412,299,411,299,409,299,409,299,406,299,406,298,405,299,402,298,400,296,399,293,396,290,392,287,389,287,388,284,379,283,376,282,374,282,374,278,370,275,368,275,367,274,365,269,365,263,364,261,362,258,364,255,365,254,367,253,370,250,374,248,376,246,375,245,374,243,374,241,372,241,372,239,371,236,369,230,363,229,360,229,354,227,350,226,347,224,347,224,345,221,344,219,342,214,337,213,335,210,332,209,329,207,327,206,327,205,323,211,324,232,326,253,327,254,310,257,270,259,256,260,256">
    <area href="TX" state="TX" shape="poly" coords="332,426,331,421,329,416,329,410,329,404,332,399,335,395,337,393,338,393,334,398,331,403,329,407,329,411,329,416,332,421,332,425,332,425,332,426">
    <area href="NH" state="NH" full="New Hampshire" shape="rect" coords="512,29,586,44">
    <area href="VT" state="VT" full="Vermont" shape="rect" coords="543,49,586,62">
    <area href="MA" state="MA" full="Massachusetts" shape="rect" coords="515,68,585,80">
    <area href="RI" state="RI" full="Rhode Island" shape="rect" coords="650,149,711,161">
    <area href="CT" state="CT" full="Connecticut" shape="rect" coords="655,167,711,179">
    <area href="NJ" state="NJ" full="New Jersey" shape="rect" coords="656,185,711,198">
    <area href="DE" state="DE" full="Delaware" shape="rect" coords="665,204,711,216">
    <area href="MD" state="MD" full="Maryland" shape="rect" coords="667,223,711,235">
    <area href="DC" state="DC" full="District of Columbia" shape="rect" coords="654,239,711,252">
    <area href="WV" state="WV" full="West Virginia" shape="rect" coords="649,257,711,270">
    <area href="SC" state="SC" full="South Carolina" shape="poly" coords="551,314,551,314,548,314,548,312,547,310,545,308,544,308,542,304,540,299,537,299,536,297,535,295,533,293,532,293,530,290,528,289,524,287,524,287,523,284,522,284,520,280,518,280,515,278,513,277,513,276,514,275,515,274,515,272,520,270,526,267,531,266,543,266,545,267,546,270,549,269,559,269,560,269,570,275,577,281,573,284,572,289,571,293,569,294,569,296,567,296,566,299,563,301,562,303,561,304,558,306,556,307,557,309,553,313,551,314">
    <area href="HI" state="HI" full="Hawaii" shape="poly" coords="169,391,170,389,172,388,172,389,170,391,169,391">
    <area href="HI" state="HI" shape="poly" coords="176,389,181,390,182,390,183,387,183,385,180,384,177,386,176,389">
    <area href="HI" state="HI" shape="poly" coords="199,395,201,400,203,399,204,399,205,400,208,400,208,398,206,398,205,395,203,392,199,395,199,395">
    <area href="HI" state="HI" shape="poly" coords="213,402,214,401,218,401,218,401,222,401,222,402,221,404,217,403,213,402">
    <area href="HI" state="HI" shape="poly" coords="217,406,218,409,221,407,221,407,220,405,217,405,217,406">
    <area href="HI" state="HI" shape="poly" coords="222,405,224,403,227,404,230,405,233,407,233,409,231,410,227,411,226,410,222,405">
    <area href="HI" state="HI" shape="poly" coords="234,416,236,415,238,416,243,419,245,421,247,422,248,425,251,428,251,428,248,431,245,431,244,431,242,432,240,435,239,437,237,437,235,435,234,431,235,430,233,426,232,425,232,422,233,422,235,419,236,419,234,418,234,416">
    <area href="AK" state="AK" full="Alaska" shape="poly" coords="114,344,114,405,116,406,118,406,119,405,121,405,121,407,125,413,126,414,128,413,129,413,129,410,131,410,131,409,133,408,135,410,135,412,137,413,137,414,140,416,143,420,145,422,146,425,147,428,151,428,155,430,155,434,156,436,155,438,154,440,152,439,152,437,149,436,149,435,148,436,149,437,149,440,148,440,146,440,145,438,146,440,146,441,146,441,143,437,143,435,141,434,141,430,140,430,140,433,140,433,139,430,138,428,137,427,138,431,138,432,137,431,134,427,133,426,132,424,131,422,130,421,130,419,131,419,131,418,129,419,127,417,125,415,122,413,119,411,119,409,119,407,118,409,116,410,113,409,109,407,105,407,104,407,100,404,98,404,96,400,94,400,92,401,92,404,92,402,93,403,92,406,95,404,95,405,92,408,91,408,91,407,90,406,89,407,87,405,85,407,83,408,81,410,77,410,77,408,80,408,80,407,78,407,79,404,80,402,80,401,80,400,84,398,85,399,86,399,86,398,83,397,80,399,77,401,77,404,75,405,72,406,70,408,70,410,71,410,72,411,70,414,65,417,60,420,59,421,54,422,50,423,52,424,51,425,50,426,49,425,46,425,46,427,45,427,45,425,43,426,41,427,38,426,36,428,34,428,32,428,31,429,29,428,27,428,26,428,25,429,24,428,24,427,26,426,31,426,34,425,35,424,38,423,39,422,41,422,42,424,43,423,44,422,47,421,49,420,50,420,50,420,51,420,52,418,55,416,56,414,58,410,59,410,59,407,58,409,56,409,55,407,54,407,53,408,53,410,53,410,51,406,50,407,50,406,50,405,47,405,45,406,43,406,44,404,44,403,44,401,45,401,46,401,45,399,45,396,45,395,44,396,40,396,38,395,38,392,37,390,37,389,38,389,38,387,39,386,38,386,38,386,37,384,38,380,41,378,43,377,44,374,46,374,48,374,48,376,50,376,53,374,53,374,54,375,56,375,57,374,58,371,58,366,56,367,54,368,53,367,50,366,47,366,44,363,44,360,44,359,43,357,41,355,42,354,47,353,48,353,49,354,50,354,50,353,53,353,54,353,55,353,54,355,54,356,56,357,59,359,61,358,59,355,59,353,59,352,56,350,56,350,56,349,56,346,54,342,52,339,54,338,56,338,58,338,61,338,64,335,65,333,67,332,68,332,71,332,73,330,74,330,74,331,78,331,80,329,80,329,83,330,85,332,84,332,85,333,86,332,89,332,89,335,90,336,95,337,100,340,101,339,105,341,107,341,108,340,111,341,114,344">
    <area href="AK" state="AK" shape="poly" coords="31,365,32,368,32,369,30,368,29,366,28,365,26,365,26,363,27,361,28,363,29,364,31,365">
    <area href="AK" state="AK" shape="poly" coords="29,389,32,389,35,390,35,391,34,393,32,393,29,391,29,389">
    <area href="AK" state="AK" shape="poly" coords="14,378,15,380,16,381,15,382,14,380,14,378,14,378">
    <area href="AK" state="AK" shape="poly" coords="4,431,7,430,9,429,11,429,11,431,13,431,14,429,14,428,16,428,18,430,17,431,14,432,12,431,9,431,6,431,5,432,4,431">
    <area href="AK" state="AK" shape="poly" coords="40,428,41,430,42,428,41,428,40,428">
    <area href="AK" state="AK" shape="poly" coords="42,431,43,428,44,429,44,431,42,431">
    <area href="AK" state="AK" shape="poly" coords="59,429,60,430,61,429,60,428,59,429">
    <area href="AK" state="AK" shape="poly" coords="65,420,66,424,68,425,72,422,75,421,74,419,74,417,73,418,71,418,71,417,73,417,76,416,77,415,74,414,75,413,73,414,70,417,66,419,65,420">
    <area href="AK" state="AK" shape="poly" coords="96,406,98,404,97,403,95,404,96,406">
    <area href="FL" state="FL" full="Florida" shape="poly" coords="548,337,549,343,552,350,556,356,558,361,562,365,565,368,566,370,565,371,565,372,566,377,569,380,571,383,573,387,577,393,578,399,578,407,578,409,578,411,576,413,577,413,576,415,576,417,577,419,575,421,572,422,569,422,569,423,567,424,566,423,565,422,565,421,564,418,562,414,559,413,557,413,556,413,554,410,553,407,551,404,550,404,549,405,548,405,546,401,544,398,542,395,540,392,537,390,539,388,541,384,541,383,538,383,536,383,537,383,539,384,538,387,537,388,536,385,535,381,535,379,536,376,536,369,533,366,533,364,529,363,527,362,526,361,524,359,523,357,521,356,519,353,516,353,514,351,512,351,509,352,509,353,509,354,509,355,507,355,504,357,502,359,499,359,497,360,497,358,495,356,493,356,492,355,486,352,481,350,477,351,473,351,469,353,466,353,466,347,464,346,463,344,463,342,470,341,489,339,494,339,498,339,500,341,501,343,507,343,515,342,530,341,534,341,538,341,538,343,540,344,540,341,539,337,539,336,544,337,548,337">
    <area href="FL" state="FL" shape="poly" coords="557,434,558,433,560,433,560,431,562,430,563,431,564,431,564,431,562,432,559,433,557,434,557,434">
    <area href="FL" state="FL" shape="poly" coords="566,430,567,431,569,429,573,426,576,423,578,419,578,417,578,415,578,415,577,417,576,420,574,425,571,428,568,428,566,430">
    <area href="GA" state="GA" full="Georgia" shape="poly" coords="500,274,497,275,490,275,484,276,484,278,484,279,485,281,487,287,489,295,490,299,491,302,492,308,494,312,495,314,496,317,497,317,497,319,496,323,496,325,496,326,497,329,497,333,497,335,497,336,498,336,498,339,500,341,501,343,507,343,515,342,530,341,534,341,538,341,538,343,540,344,540,341,539,337,539,336,544,337,548,337,547,332,548,325,550,322,549,320,552,315,551,314,551,314,548,314,548,312,547,310,545,308,544,308,542,304,540,299,537,299,536,297,535,295,533,293,532,293,530,290,528,289,524,287,524,287,523,284,522,284,520,280,518,280,515,278,513,277,513,276,514,275,515,274,515,272,514,272,510,273,505,274,500,274">
    <area href="AL" state="AL" full="Alabama" shape="poly" coords="453,353,452,342,450,329,450,318,451,296,451,284,451,279,457,278,476,277,484,276,484,278,484,279,485,281,487,287,489,295,490,299,491,302,492,308,494,312,495,314,496,317,497,317,497,319,496,323,496,325,496,326,497,329,497,333,497,335,497,336,498,336,499,339,494,339,489,339,470,341,463,342,463,344,464,346,466,347,467,353,461,355,460,355,461,353,461,353,459,348,458,348,457,351,456,353,455,353,453,353">
    <area href="NC" state="NC" full="North Carolina" shape="poly" coords="603,231,605,234,607,239,608,241,609,242,608,242,608,243,608,246,606,247,605,248,605,251,602,252,600,251,599,251,598,251,598,251,598,252,599,252,600,253,599,257,602,257,602,259,604,257,605,257,603,260,601,263,600,263,599,263,597,263,593,265,589,269,587,272,585,277,584,278,581,279,577,281,570,275,560,269,559,269,549,269,546,270,545,267,543,266,531,266,526,267,520,270,515,272,514,272,510,273,505,274,500,274,500,271,501,269,503,269,504,266,507,264,509,263,512,260,516,259,516,257,519,254,520,254,523,252,525,252,527,252,527,250,530,248,530,246,530,243,533,244,539,243,550,242,563,239,578,237,591,234,599,232,603,231">
    <area href="NC" state="NC" shape="poly" coords="606,255,608,253,610,251,611,251,611,249,611,245,610,243,609,242,610,242,612,245,612,248,612,251,610,252,608,254,607,255,606,255">
    <area href="TN" state="TN" full="Tennessee" shape="poly" coords="505,247,467,251,456,252,453,252,450,252,450,255,444,255,439,256,431,256,431,260,429,265,428,267,428,270,427,272,424,274,425,276,425,279,423,281,429,281,447,279,451,279,457,278,476,277,484,276,490,275,497,275,500,274,500,271,501,269,503,269,504,266,507,264,509,263,512,260,516,259,516,257,519,254,520,254,523,252,525,252,527,252,527,250,530,248,530,246,530,243,529,243,527,245,521,245,512,246,505,247">
    <area href="RI" state="RI" full="Rhode Island" shape="poly" coords="633,145,633,142,632,139,632,134,635,134,637,134,639,137,641,140,639,142,638,141,638,143,635,144,633,145">
    <area href="CT" state="CT" full="Connecticut" shape="poly" coords="634,145,633,142,632,139,632,134,628,135,612,139,612,141,614,146,614,152,613,154,614,155,617,153,620,151,621,149,622,149,624,149,628,148,634,145">
    <area href="MA" state="MA" full="Massachusetts" shape="poly" coords="653,140,654,140,654,139,655,139,656,140,655,141,652,141,653,140">
    <area href="MA" state="MA" shape="poly" coords="645,141,647,139,648,139,650,140,648,141,647,142,645,141">
    <area href="MA" state="MA" shape="poly" coords="620,125,633,122,635,122,636,119,639,118,641,122,639,125,639,126,641,128,641,128,642,128,644,129,647,134,650,134,651,134,653,132,652,130,650,129,649,129,648,128,649,128,650,128,652,128,653,131,654,132,654,134,651,135,648,137,645,140,644,141,644,140,646,140,646,138,645,136,644,137,643,138,643,140,641,140,639,137,637,134,635,134,632,134,628,135,612,139,611,134,611,127,615,126,620,125">
    <area href="ME" state="ME" full="Maine" shape="poly" coords="669,71,671,72,672,75,672,76,671,80,669,80,667,83,663,86,660,85,659,86,658,87,657,88,659,89,658,89,658,92,656,92,656,90,656,89,655,89,653,87,652,88,653,89,653,90,653,91,653,93,653,95,652,96,650,97,650,98,646,101,644,101,644,100,641,103,642,105,641,106,641,110,640,115,638,114,638,112,635,111,635,109,629,92,626,81,628,81,629,81,629,80,629,75,631,72,632,69,631,68,631,63,632,62,632,60,632,59,632,56,633,52,635,46,637,43,638,43,638,43,638,44,639,45,641,46,642,45,642,44,645,42,647,41,647,41,652,43,653,44,659,65,664,65,665,67,665,70,667,72,668,72,668,71,667,71,669,71">
    <area href="ME" state="ME" shape="poly" coords="654,92,655,92,656,92,656,94,655,95,654,92">
    <area href="ME" state="ME" shape="poly" coords="659,88,660,89,662,87,662,86,660,86,659,88">
    <area href="NH" state="NH" shape="poly" coords="639,118,639,117,640,115,638,114,638,112,635,111,635,109,629,92,626,81,626,81,625,83,624,82,623,81,623,83,622,87,622,91,623,93,623,96,621,99,619,100,619,101,620,102,620,108,619,115,619,118,620,119,620,122,620,124,620,125,633,122,635,122,636,119,639,118">
    <area href="VT" state="VT" shape="poly" coords="611,127,611,123,609,115,608,115,606,113,607,112,606,110,605,107,605,104,605,100,603,95,602,92,622,87,622,91,623,93,623,96,621,99,619,100,619,101,620,102,620,108,619,115,619,118,620,119,620,122,620,124,620,125,615,126,611,127">
    <area href="NY" state="NY" full="New York" shape="poly" coords="600,152,599,152,598,152,596,150,594,146,592,146,590,144,577,147,545,153,539,155,539,149,541,148,542,147,542,146,543,146,545,144,545,143,547,141,548,140,548,140,547,137,545,137,544,133,546,131,549,131,552,129,554,129,559,129,560,130,562,130,563,129,565,128,569,128,570,127,572,125,572,123,574,123,575,122,575,120,575,119,575,118,575,116,575,115,574,115,572,115,572,114,572,112,576,108,577,107,578,105,580,102,582,99,584,98,585,96,587,95,591,95,593,95,597,93,602,92,603,95,605,100,605,104,605,107,606,110,607,112,606,113,608,115,609,115,611,123,611,127,611,134,611,138,612,141,614,146,614,152,613,154,614,155,614,156,612,158,613,158,614,158,614,158,616,155,617,155,618,155,620,155,626,153,628,151,629,150,632,151,629,154,626,155,621,160,620,160,615,161,612,162,611,162,611,160,611,158,611,156,609,155,605,155,603,154,600,152">
    <area href="NJ" state="NJ" full="New Jersey" shape="poly" coords="600,152,599,155,599,156,597,158,597,160,598,161,598,163,596,164,597,165,597,166,599,167,600,168,602,170,604,171,604,172,602,174,601,176,599,178,598,179,597,179,597,180,596,182,597,184,599,185,603,188,606,188,606,189,605,190,605,191,606,191,608,190,608,186,611,183,613,179,614,175,613,174,613,167,611,164,611,165,609,165,608,165,609,164,611,163,611,162,611,160,611,158,611,156,609,155,605,155,603,154,600,152">
    <area href="PA" state="PA" full="Pennsylvania" shape="poly" coords="597,179,598,179,599,178,601,176,602,174,604,172,604,171,602,170,600,168,599,167,597,166,597,165,596,164,598,163,598,161,597,160,597,158,599,156,599,155,600,152,599,152,598,152,596,150,594,146,592,146,590,144,577,147,545,153,539,155,539,149,535,153,534,154,531,156,533,170,534,178,537,191,540,191,549,190,576,185,587,182,593,181,594,180,596,179,597,179">
    <area href="DE" state="DE" shape="poly" coords="596,182,597,180,597,179,596,179,594,180,593,182,594,185,596,188,597,196,599,200,602,200,606,199,605,194,604,194,602,192,600,189,599,186,597,185,596,183,596,182">
    <area href="MD" state="MD" shape="poly" coords="606,199,602,200,599,200,597,196,596,188,594,185,593,181,587,182,576,185,549,190,550,194,551,197,551,197,552,196,554,194,556,194,557,192,558,191,559,191,561,191,563,189,565,188,566,188,567,188,569,190,571,191,572,192,575,193,575,195,578,196,580,197,581,196,582,197,581,200,581,201,580,203,580,205,580,206,584,207,587,207,589,208,590,208,591,206,590,205,590,203,588,202,587,198,588,194,588,193,587,191,590,188,591,186,591,187,590,188,590,191,590,192,591,192,591,196,590,197,590,200,590,199,591,197,593,199,591,200,591,203,593,205,596,205,597,205,599,209,600,209,600,212,599,215,599,220,599,222,601,222,602,219,602,217,602,212,605,208,606,203,606,199">
    <area href="MD" state="MD" shape="poly" coords="595,206,596,208,596,209,596,211,596,206,595,206">
    <area href="WV" state="WV" shape="poly" coords="549,190,550,194,551,197,551,197,552,196,554,194,556,194,557,192,558,191,559,191,561,191,563,189,565,188,566,188,567,188,569,190,571,191,572,192,571,195,566,193,563,192,563,196,563,197,562,200,561,200,559,202,559,204,557,204,556,206,555,210,554,210,552,209,551,208,550,208,550,211,548,216,545,224,545,224,545,227,544,228,542,227,540,230,538,229,537,232,530,233,528,234,527,233,525,233,524,230,521,229,520,227,518,224,517,223,515,221,515,221,515,217,516,216,518,216,518,214,518,213,519,209,519,206,521,206,521,207,521,208,523,207,524,206,523,205,523,203,523,202,525,200,526,199,527,199,529,198,531,195,533,193,533,188,533,185,533,182,533,179,533,178,534,177,537,191,540,191,549,190">
    <area href="VA" state="VA" full="Virginia" shape="poly" coords="524,230,525,233,527,233,528,234,530,233,532,232,538,229,540,230,542,227,544,228,545,227,545,224,545,224,548,216,550,211,550,208,551,208,552,209,554,210,555,210,556,206,557,204,559,204,559,202,561,200,562,200,563,197,563,196,563,192,566,193,571,195,572,191,575,193,575,195,578,196,580,197,581,196,582,197,581,200,581,201,580,203,580,205,580,206,584,207,585,208,589,209,590,210,593,210,594,212,593,215,594,215,594,217,596,218,596,220,593,219,593,220,594,221,594,221,596,222,596,224,596,225,595,227,595,227,597,227,599,226,600,226,603,231,599,232,591,234,578,237,563,239,550,242,539,243,533,244,530,243,529,243,527,245,521,245,512,246,505,247,507,246,511,244,514,242,514,241,515,239,518,236,521,233,524,230">
    <area href="KY" state="KY" full="Kentucky" shape="poly" coords="524,230,521,233,518,236,515,239,514,241,514,242,511,244,507,246,505,247,467,251,456,252,453,252,450,252,450,255,444,255,439,256,431,256,432,255,434,254,435,253,435,251,436,249,435,248,435,246,437,245,439,245,440,245,443,246,444,246,444,245,443,242,443,241,445,240,446,239,448,239,447,238,446,236,448,236,449,233,450,232,455,231,458,231,458,233,460,233,461,230,463,230,464,231,465,232,467,231,467,229,469,227,470,227,470,228,473,228,474,227,474,225,476,222,479,220,480,216,482,216,485,215,487,213,486,212,485,211,485,209,488,209,491,209,493,210,494,213,498,213,499,215,500,215,503,214,505,214,506,215,508,213,509,212,510,212,511,214,512,215,515,216,515,221,515,221,517,223,518,224,520,227,521,229,524,230">
    <area href="OH" state="OH" full="Ohio" shape="poly" coords="531,156,526,159,523,161,521,163,518,166,515,167,513,167,509,169,508,169,505,167,501,167,500,166,497,165,494,166,487,167,481,167,482,179,483,188,485,205,485,209,488,209,491,209,493,210,494,213,498,213,499,215,500,215,503,214,505,214,506,215,508,213,509,212,510,212,511,214,512,215,515,217,516,216,518,216,518,214,518,213,519,209,519,206,521,206,521,207,521,208,523,207,524,206,523,205,523,203,523,202,525,200,526,199,527,199,529,198,531,195,533,193,533,188,533,185,533,182,533,179,533,178,534,178,533,170,531,156">
    <area href="MI" state="MI" full="Michigan" shape="poly" coords="422,74,423,73,425,72,428,69,430,68,431,69,427,73,424,74,422,75,422,74">
    <area href="MI" state="MI" shape="poly" coords="484,98,485,99,487,99,488,98,485,96,484,96,483,97,484,98">
    <area href="MI" state="MI" shape="poly" coords="506,143,503,137,502,131,500,128,498,127,497,128,494,129,493,133,491,135,490,136,489,135,490,129,491,127,491,125,493,124,493,116,491,115,491,114,490,113,491,112,491,113,491,111,490,110,489,107,487,107,484,107,480,104,478,104,477,104,476,104,474,103,473,104,470,106,470,108,471,108,473,109,473,110,471,110,470,110,468,111,468,113,468,114,468,118,466,119,465,119,465,116,467,115,467,113,467,113,465,113,464,116,462,117,461,118,461,119,461,119,461,122,459,122,459,122,460,125,459,128,458,131,458,135,458,136,458,137,458,138,458,140,460,145,462,149,463,152,463,156,462,161,460,164,460,166,458,168,457,169,461,169,476,167,481,167,481,167,487,167,494,166,498,165,497,164,497,164,499,161,500,159,500,156,501,155,502,155,502,152,503,149,504,150,504,151,505,151,506,150,506,143">
    <area href="MI" state="MI" shape="poly" coords="410,95,412,95,414,94,416,92,416,92,417,92,421,91,423,89,426,88,426,87,428,85,429,84,430,83,431,81,434,80,438,79,439,80,439,80,436,81,435,83,433,84,433,86,431,88,431,90,431,90,432,89,434,87,436,89,437,89,440,89,440,90,442,92,444,94,446,94,448,93,449,95,450,95,451,94,452,94,453,93,456,91,458,90,463,89,467,89,468,87,470,87,470,92,470,92,472,92,473,92,478,91,479,90,479,90,479,95,482,98,483,98,484,99,483,99,482,99,479,98,478,99,476,99,474,100,473,100,468,99,464,99,464,101,458,101,457,102,455,104,455,105,455,105,453,104,450,106,449,106,449,104,448,104,447,107,446,110,443,116,442,116,441,115,440,107,437,107,437,104,428,103,425,102,419,100,413,99,410,95">
    <area href="WY" state="WY" full="Wyoming" shape="poly" coords="257,119,249,118,226,116,214,114,194,111,179,109,178,117,175,135,171,157,170,164,169,173,174,174,186,176,192,176,207,178,234,181,252,182,255,150,257,132,257,119">
    <area href="MT" state="MT" full="Montana" shape="poly" coords="259,104,260,95,261,77,262,66,263,56,240,53,219,51,197,48,174,44,161,41,137,37,134,52,137,57,135,61,137,64,139,65,142,73,144,75,145,76,147,77,147,78,142,91,142,93,144,95,145,95,148,93,149,92,150,93,149,97,152,106,154,107,155,108,156,110,155,112,156,115,157,116,158,113,161,113,163,115,164,114,167,114,170,116,172,115,173,113,175,113,176,113,176,116,178,117,179,109,194,111,214,114,226,116,249,118,257,119,259,107,259,104">
    <area href="ID" state="ID" full="Idaho" shape="poly" coords="102,143,105,130,108,117,110,114,111,110,110,108,109,108,108,107,108,107,109,104,112,101,113,100,114,99,114,97,115,96,118,92,121,89,121,86,119,84,117,81,118,74,120,62,124,47,126,38,127,35,137,37,134,52,137,57,135,61,137,64,139,65,142,73,144,75,145,76,147,77,147,78,142,91,142,93,144,95,145,95,148,93,149,92,150,93,149,97,152,106,154,107,155,108,156,110,155,112,156,115,157,116,158,113,161,113,163,115,164,114,167,114,170,116,172,115,173,113,175,113,176,113,176,116,178,117,175,135,172,157,168,156,162,155,155,154,146,152,137,151,131,149,124,148,117,146,102,143">
    <area href="WA" state="WA" full="Washington" shape="poly" coords="68,19,71,20,78,22,84,23,98,28,116,32,127,35,126,38,124,47,120,62,118,74,118,81,107,79,96,76,85,76,85,75,81,77,77,77,76,75,75,76,71,75,71,74,67,73,66,73,63,72,62,74,57,73,53,70,53,69,53,64,52,61,49,61,48,59,47,59,45,57,44,58,42,56,42,54,44,53,46,50,44,50,44,47,47,47,45,44,44,40,44,38,44,32,43,29,44,23,47,23,48,25,50,27,53,29,56,30,58,30,60,32,62,32,64,32,64,30,65,29,67,29,67,29,67,31,65,31,65,32,66,33,67,35,68,37,69,36,69,35,68,35,68,32,68,31,68,30,68,29,69,26,68,24,67,20,67,20,68,19">
    <area href="WA" state="WA" shape="poly" coords="61,23,62,23,62,24,64,23,65,23,66,24,65,26,65,26,65,28,64,28,63,26,63,26,62,27,61,26,61,23">
   
    <area href="CA" state="CA" full="California" shape="poly" coords="99,296,102,295,104,293,104,291,101,291,101,290,101,289,101,285,103,284,105,282,105,278,107,276,108,275,110,273,112,272,112,271,111,270,110,269,110,266,107,262,108,260,106,257,95,241,81,220,65,195,56,182,57,177,62,158,68,135,58,133,48,130,39,127,34,125,26,123,20,122,20,125,19,131,15,139,13,141,13,142,11,143,11,146,10,148,12,151,13,154,14,156,14,161,13,164,12,167,11,170,13,173,14,176,17,180,17,182,17,185,17,185,17,187,21,191,20,194,20,195,20,197,20,203,21,205,23,207,25,207,26,209,24,212,23,213,22,213,22,216,22,218,24,221,26,225,26,228,27,230,30,235,31,236,32,239,32,239,32,241,32,242,31,248,30,249,32,251,35,251,38,253,41,254,43,254,45,257,47,260,48,262,51,263,54,264,56,266,56,268,55,268,55,269,57,269,59,269,62,273,65,276,65,278,67,281,67,283,67,290,68,291,74,292,89,294,99,296">
    <area href="CA" state="CA" shape="poly" coords="35,259,36,260,36,261,34,261,33,260,33,259,35,259">
    <area href="CA" state="CA" shape="poly" coords="37,259,38,258,40,260,42,261,41,261,38,261,37,260,37,259">
    <area href="CA" state="CA" shape="poly" coords="52,273,53,275,53,275,55,276,55,275,54,274,53,272,52,272,52,273">
    <area href="CA" state="CA" shape="poly" coords="50,279,52,282,53,283,52,284,51,282,50,279">
    <area href="AZ" state="AZ" full="Arizona" shape="poly" coords="100,296,98,297,98,298,98,299,112,306,120,312,131,318,143,326,152,327,172,330,173,320,176,301,181,262,184,239,165,237,146,233,122,229,119,242,119,242,118,245,116,245,115,242,113,242,113,241,112,241,111,242,110,242,110,248,110,248,109,258,108,260,107,262,110,266,110,269,111,270,112,271,112,272,110,273,108,275,107,276,105,278,105,282,103,284,101,285,101,289,101,290,101,291,104,291,104,293,102,295,100,296">
    <area href="NV" state="NV" full="Nevada" shape="poly" coords="102,143,117,146,124,148,131,149,137,151,136,155,133,167,131,182,129,189,128,199,125,211,123,221,122,230,119,242,119,242,118,245,116,245,115,242,113,242,113,241,112,241,111,242,110,242,110,248,110,248,109,258,108,260,106,257,95,241,81,220,65,195,56,182,57,177,62,158,68,135,92,141,102,143">
    <area href="UT" state="UT" full="Utah" shape="poly" coords="184,240,165,237,146,233,122,229,123,221,125,211,128,199,129,189,131,182,133,167,136,155,137,151,146,152,155,154,162,155,168,156,172,157,170,164,169,173,174,174,186,176,193,176,191,192,188,209,185,229,185,237,184,240">
    <area href="CO" state="CO" full="Colorado" shape="poly" coords="272,248,275,201,276,185,252,182,234,181,207,178,192,176,191,192,188,209,185,229,185,237,184,240,209,242,236,246,260,248,264,248,272,248">
    <area href="NM" state="NM" full="New Mexico" shape="poly" coords="206,327,205,323,211,324,232,326,253,327,254,310,257,270,259,256,260,256,260,248,236,246,209,242,184,240,181,262,176,301,173,320,172,330,183,331,184,324,196,326,206,327">
    <area href="OR" state="OR" full="Oregon" shape="poly" coords="102,143,105,130,108,117,110,114,111,110,110,108,109,108,108,107,108,107,109,104,112,101,113,100,114,99,114,97,115,96,118,92,121,89,121,86,119,84,118,81,107,79,96,76,85,76,85,75,81,77,77,77,76,75,75,76,71,75,71,74,67,73,66,73,63,72,62,74,57,73,53,70,53,69,53,64,52,61,49,61,48,59,47,59,42,60,41,65,38,72,36,77,32,87,28,97,22,106,20,108,20,114,19,119,20,122,26,123,34,125,39,127,48,130,58,133,68,135">
    <area href="OR" state="OR" shape="poly" coords="102,143,68,135,92,141,102,143">
    <area href="ND" state="ND" full="North Dakota" shape="poly" coords="342,107,341,101,341,96,339,86,338,80,338,77,336,73,336,65,337,63,335,59,314,59,300,58,281,57,263,56,262,66,261,77,260,95,259,104,300,107,342,107">
    <area href="SD" state="SD" full="South Dakota" shape="poly" coords="343,162,343,161,341,159,343,155,344,152,341,150,341,148,342,146,344,146,344,141,344,119,343,117,340,115,339,113,339,112,341,111,342,110,342,107,300,107,259,104,259,107,257,119,257,132,255,151,266,152,281,152,294,153,311,154,319,154,320,155,324,158,325,158,328,157,331,157,333,157,334,158,338,158,340,160,341,161,341,163,342,163,343,162">
    <area href="NE" state="NE" full="Nebraska" shape="poly" coords="352,194,353,195,353,197,354,200,356,203,352,203,320,203,291,201,275,200,276,185,252,182,255,151,266,152,281,152,294,153,311,154,319,154,320,155,324,158,325,158,328,157,331,157,333,157,334,158,338,158,340,160,341,161,341,163,342,163,344,162,344,167,347,172,347,176,349,178,349,182,350,185,350,190,352,194">
    <area href="IA" state="IA" full="Iowa" shape="poly" coords="411,161,411,162,413,162,413,163,414,164,417,167,417,169,417,171,416,174,415,176,413,177,412,177,408,179,407,180,407,182,407,182,409,183,409,186,407,188,407,188,407,191,406,191,404,192,404,193,404,194,404,196,401,193,400,191,395,192,387,192,369,193,359,193,353,194,352,194,350,190,350,185,349,182,349,178,347,176,347,172,344,167,344,162,342,161,341,159,343,155,344,152,341,150,341,148,342,146,343,146,352,146,388,146,401,146,404,145,404,148,406,149,406,150,404,152,404,155,407,158,408,158,410,158,411,161">
    <area href="MS" state="MS" full="Mississippipi" shape="poly" coords="453,353,452,354,449,354,448,353,446,353,441,355,440,354,438,357,437,358,437,356,436,353,433,350,434,345,434,344,432,344,426,345,409,346,408,344,409,338,411,334,415,328,414,326,415,326,416,324,414,323,414,321,413,318,413,314,413,312,413,309,412,307,413,305,412,304,413,303,413,299,416,296,415,295,418,291,419,290,419,289,419,287,421,284,423,283,423,281,429,281,447,279,451,279,451,284,451,296,450,318,450,329,452,342,453,353">
    <area href="IN" state="IN" full="Indiana" shape="poly" coords="449,233,448,230,449,227,450,225,452,222,453,219,453,215,452,213,452,211,452,207,452,202,451,190,450,179,449,170,452,171,452,172,453,172,455,170,457,169,461,169,476,167,481,167,481,167,482,179,483,188,485,205,485,209,485,211,486,212,487,213,485,215,482,216,480,216,479,220,476,222,474,225,474,227,473,228,470,228,470,227,469,227,467,229,467,231,465,232,464,231,463,230,461,230,460,233,458,233,458,231,455,231,450,232,449,233">
    <area href="IL" state="IL" full="Illinois" shape="poly" coords="448,233,448,230,449,227,450,225,452,222,453,219,453,215,452,213,452,211,452,207,452,202,451,190,450,179,449,170,449,170,448,168,447,165,446,164,445,162,444,158,437,159,418,161,411,160,411,162,413,162,413,163,414,164,417,167,417,169,417,171,416,174,415,176,413,177,412,177,408,179,407,180,407,182,407,182,409,183,409,186,407,188,407,188,407,191,406,191,404,192,404,193,404,194,404,195,403,197,403,200,404,206,410,211,414,213,413,217,414,218,419,218,421,219,421,221,419,226,419,228,420,231,425,235,428,236,429,239,431,241,431,243,431,246,433,248,435,248,435,246,437,245,439,245,440,245,443,246,444,246,444,245,443,242,443,241,445,240,446,239,448,239,447,238,446,236,448,236,448,233">
    <area href="MN" state="MN" full="Minnesota" shape="poly" coords="342,107,341,101,341,96,339,86,338,80,338,77,336,73,336,65,337,63,335,59,357,59,357,53,358,53,359,53,361,54,362,58,362,62,364,63,367,63,368,65,372,65,372,66,376,66,376,65,377,65,378,64,379,65,381,65,384,67,388,68,389,68,390,68,391,68,392,70,393,71,394,71,395,71,395,72,397,73,399,73,400,72,402,70,404,69,404,71,405,71,406,71,407,71,413,71,414,73,415,73,415,72,419,72,418,74,415,75,408,78,405,80,403,81,401,84,399,86,398,87,395,91,394,91,392,93,392,94,390,95,389,98,389,104,389,105,385,107,383,112,383,112,386,113,386,116,385,119,385,121,385,126,387,128,389,128,391,131,393,131,396,135,401,138,403,140,404,146,401,146,388,146,352,146,343,146,344,141,344,119,343,117,340,115,339,113,339,112,341,111,342,110,342,107">
    <area href="WI" state="WI" full="Wisconsin" shape="poly" coords="444,158,444,155,443,152,443,148,442,146,443,143,443,141,444,140,444,137,443,134,444,134,445,131,446,130,445,128,445,127,446,125,448,120,449,116,449,113,449,113,449,113,446,118,444,121,443,122,442,124,441,125,440,126,439,125,439,125,440,122,441,119,443,118,443,116,442,116,441,115,440,107,437,107,437,104,428,103,425,102,419,100,413,99,410,95,410,96,410,96,409,95,407,95,406,95,404,95,404,95,404,94,406,92,407,91,405,89,404,90,401,92,396,94,394,95,392,94,392,94,390,95,389,98,389,104,389,105,385,107,383,112,383,112,386,113,386,116,385,119,385,121,385,126,387,128,389,128,391,131,393,131,396,135,401,138,403,140,404,145,404,148,406,149,406,150,404,152,404,155,407,158,408,158,410,158,411,161,418,161,437,159,444,158">
    <area href="MO" state="MO" full="Missouri" shape="poly" coords="404,196,401,193,400,191,395,192,387,192,369,193,359,193,353,194,352,194,353,195,353,197,354,200,356,203,359,205,361,205,362,206,362,208,360,209,360,210,362,213,363,215,365,216,366,225,365,251,365,254,366,259,383,258,400,258,415,257,423,257,424,259,424,261,422,263,421,265,425,266,429,265,431,260,431,256,433,255,434,254,435,253,435,251,436,249,435,248,433,248,431,246,431,243,431,241,429,239,428,236,425,235,420,231,419,228,419,226,421,221,421,219,419,218,414,218,413,217,414,213,410,211,404,206,403,200,403,197,404,196">
    <area href="AR" state="AR" full="Arkansas" shape="poly" coords="429,265,425,266,421,265,422,263,424,261,424,259,423,257,415,257,400,258,383,258,366,259,367,264,367,270,368,278,368,305,370,307,372,305,374,306,374,314,391,314,404,314,413,314,413,312,413,309,412,307,413,305,412,304,413,303,413,299,416,296,415,295,418,291,419,290,419,289,419,287,421,284,423,283,423,281,425,280,425,276,424,274,427,272,428,270,428,267,429,265">
    <area href="OK" state="OK" full="Oklahoma" shape="poly" coords="272,248,264,248,260,248,260,248,260,256,275,257,298,258,296,275,296,288,296,289,299,292,301,293,302,293,302,291,303,293,305,293,305,291,307,293,306,295,309,296,311,296,314,296,316,298,317,296,320,297,322,299,323,299,323,301,324,302,326,300,327,300,329,300,329,302,333,304,334,303,335,300,336,300,337,302,340,302,343,303,345,304,347,303,347,301,350,301,351,302,353,300,354,300,355,302,358,302,359,300,360,300,362,302,364,304,366,304,368,305,368,278,367,270,367,264,366,259,365,254,365,251,356,251,322,251,290,249,272,248">
    <area href="KS" state="KS" full="Kansas" shape="poly" coords="365,251,356,251,322,251,290,249,272,248,275,200,291,201,320,203,352,203,356,203,359,205,361,205,362,206,362,208,360,209,360,210,362,213,363,215,365,216,366,225,365,251">
    <area href="LA" state="LA" full="Louisiana" shape="poly" coords="437,357,437,356,436,353,433,350,434,345,434,344,432,344,426,345,409,346,408,344,409,338,411,334,415,328,414,326,415,326,416,324,414,323,414,321,413,318,413,314,404,314,391,314,374,314,374,321,375,329,376,331,377,334,378,338,381,341,381,344,382,344,381,350,379,354,380,356,380,358,380,363,378,365,379,368,382,367,388,366,395,369,400,370,403,369,405,370,407,371,408,369,406,368,404,368,401,367,406,366,407,366,410,366,410,368,410,370,414,370,416,371,415,372,414,373,415,374,421,377,424,376,425,374,426,374,428,372,428,373,429,375,428,376,428,377,431,375,432,373,433,373,431,372,431,371,431,370,433,370,434,369,434,369,440,374,441,374,443,374,444,375,446,373,446,372,445,372,443,370,438,369,436,368,437,366,438,366,439,365,437,365,437,365,440,365,441,362,440,361,440,359,439,359,437,361,437,362,434,362,434,361,435,359,437,358,437,357">

    </map>';
        print $map;
        }
        
        function msdlab_do_state_sidebar_alt(){
            global $wp_query,$states,$areas;
            $state = urldecode($wp_query->query_vars['msd_state']);
            $areas = '{key:"'.$state.'",selected:true},';
            $ret = '<img id="usa_image_map" src="'.get_stylesheet_directory_uri().'/lib/img/map.png" usemap="#usa_image_map" class="imagemap">';
            $ret .= $this->msd_get_usa_imagemap();
            print $ret;
        }
        
        function msd_sidebar_project_info_box($post = false){
            global $location_info,$client_info,$additional_files,$states,$areas;
            if(!$post){
              global $post; 
            }
            $location_info->the_meta($post->ID);
            $client_info->the_meta($post->ID);
            $client = $client_info->get_the_value('client');
            $client = $client[0];
            $project_types = get_the_terms($post->ID, 'project_type');
            $project_types_args = array(
                'show_option_all'    => '',
                'orderby'            => 'name',
                'order'              => 'ASC',
                'style'              => 'list',
                'hide_empty'         => 1,
                'title_li'           => __( '' ),
                'show_option_none'   => __(''),
                'number'             => null,
                'echo'               => 0,
                'taxonomy'           => 'project_type',
                'walker'             => null,
                'selected'           => $project_types
            );
            $market_sectors = get_the_terms($post->ID, 'market_sector');
            $market_sectors_args = array(
                'show_option_all'    => '',
                'orderby'            => 'name',
                'order'              => 'ASC',
                'style'              => 'list',
                'hide_empty'         => 1,
                'title_li'           => __( '' ),
                'show_option_none'   => __(''),
                'number'             => null,
                'echo'               => 0,
                'taxonomy'           => 'market_sector',
                'walker'             => null,
                'selected'           => $market_sectors
            );
            $selected_states = $location_info->get_the_value('project_states');
            $ret = '<h4>Client:</h4>
            <ul class="client-name">
                <li>'.$client['name'].'</li>
            </ul>';
            $ret .= '<h4>Services:</h4>
            <ul class="services">';
                $ret .= $this->list_applied_tax($project_types_args);
            $ret .= '</ul>';
            $ret .= '<h4>Markets:</h4>
            <ul class="markets">';
                $ret .= $this->list_applied_tax($market_sectors_args);
            $ret .= '</ul>';
            $ret .= '<h4>States:</h4>
            <img id="usa_image_map" src="'.get_stylesheet_directory_uri().'/lib/img/map.png" usemap="#usa_image_map" class="imagemap">
            <ul class="states">';
                foreach($selected_states AS $selected_state){
                    $ret .= '<li><a href="/projects-state/'.$selected_state.'">'.$states[$selected_state].'</a></li>';
                    $areas .= '{key:"'.$selected_state.'",selected:true},';
                }
            $ret .= '</ul>';
            
            $ret = $this->msd_sidebar_project_info_box_wrapper($ret);
            $ret .= $this->msd_get_usa_imagemap();
            print $ret;
        }

function msd_sidebar_project_info_box_wrapper($content){
    global $post,$location_info,$client_info,$additional_files;
    $ret = '<div class="sidebar-info-box">
        <h3>Project Information</h3>
        '.$content.'
    </div>';
    return $ret;
}

function msd_get_usa_imagemap(){
    global $areas;
    return '<map id="usa_image_map" name="usa_image_map">
    <area href="#" state="TX" full="Texas" shape="poly" coords="259,256,275,257,298,258,296,275,296,288,296,289,299,292,301,293,302,293,302,291,303,293,305,293,305,291,307,293,306,295,309,296,311,296,314,296,316,298,317,296,320,297,322,299,323,299,323,301,324,302,326,300,327,300,329,300,329,302,333,304,334,303,335,300,336,300,337,302,340,302,343,303,345,304,347,303,347,301,350,301,351,302,353,300,354,300,355,302,358,302,359,300,360,300,362,302,364,304,366,304,368,305,370,307,372,305,374,306,374,314,374,321,375,329,376,331,377,334,378,338,381,341,381,344,382,344,381,350,379,354,380,356,380,358,380,363,378,365,379,368,374,369,367,372,366,374,364,375,362,376,362,377,358,380,356,382,352,385,347,386,343,389,342,390,338,392,335,393,332,397,329,397,329,398,330,400,329,404,329,407,328,410,327,413,328,415,329,420,329,425,331,426,330,428,328,429,324,426,320,425,319,425,317,425,314,423,310,422,304,419,302,417,302,412,299,411,299,409,299,409,299,406,299,406,298,405,299,402,298,400,296,399,293,396,290,392,287,389,287,388,284,379,283,376,282,374,282,374,278,370,275,368,275,367,274,365,269,365,263,364,261,362,258,364,255,365,254,367,253,370,250,374,248,376,246,375,245,374,243,374,241,372,241,372,239,371,236,369,230,363,229,360,229,354,227,350,226,347,224,347,224,345,221,344,219,342,214,337,213,335,210,332,209,329,207,327,206,327,205,323,211,324,232,326,253,327,254,310,257,270,259,256,260,256">
    <area href="#" state="TX" shape="poly" coords="332,426,331,421,329,416,329,410,329,404,332,399,335,395,337,393,338,393,334,398,331,403,329,407,329,411,329,416,332,421,332,425,332,425,332,426">
    <area href="#" state="NH" full="New Hampshire" shape="rect" coords="512,29,586,44">
    <area href="#" state="VT" full="Vermont" shape="rect" coords="543,49,586,62">
    <area href="#" state="MA" full="Massachusetts" shape="rect" coords="515,68,585,80">
    <area href="#" state="RI" full="Rhode Island" shape="rect" coords="650,149,711,161">
    <area href="#" state="CT" full="Connecticut" shape="rect" coords="655,167,711,179">
    <area href="#" state="NJ" full="New Jersey" shape="rect" coords="656,185,711,198">
    <area href="#" state="DE" full="Delaware" shape="rect" coords="665,204,711,216">
    <area href="#" state="MD" full="Maryland" shape="rect" coords="667,223,711,235">
    <area href="#" state="DC" full="District of Columbia" shape="rect" coords="654,239,711,252">
    <area href="#" state="WV" full="West Virginia" shape="rect" coords="649,257,711,270">
    <area href="#" state="SC" full="South Carolina" shape="poly" coords="551,314,551,314,548,314,548,312,547,310,545,308,544,308,542,304,540,299,537,299,536,297,535,295,533,293,532,293,530,290,528,289,524,287,524,287,523,284,522,284,520,280,518,280,515,278,513,277,513,276,514,275,515,274,515,272,520,270,526,267,531,266,543,266,545,267,546,270,549,269,559,269,560,269,570,275,577,281,573,284,572,289,571,293,569,294,569,296,567,296,566,299,563,301,562,303,561,304,558,306,556,307,557,309,553,313,551,314">
    <area href="#" state="HI" full="Hawaii" shape="poly" coords="169,391,170,389,172,388,172,389,170,391,169,391">
    <area href="#" state="HI" shape="poly" coords="176,389,181,390,182,390,183,387,183,385,180,384,177,386,176,389">
    <area href="#" state="HI" shape="poly" coords="199,395,201,400,203,399,204,399,205,400,208,400,208,398,206,398,205,395,203,392,199,395,199,395">
    <area href="#" state="HI" shape="poly" coords="213,402,214,401,218,401,218,401,222,401,222,402,221,404,217,403,213,402">
    <area href="#" state="HI" shape="poly" coords="217,406,218,409,221,407,221,407,220,405,217,405,217,406">
    <area href="#" state="HI" shape="poly" coords="222,405,224,403,227,404,230,405,233,407,233,409,231,410,227,411,226,410,222,405">
    <area href="#" state="HI" shape="poly" coords="234,416,236,415,238,416,243,419,245,421,247,422,248,425,251,428,251,428,248,431,245,431,244,431,242,432,240,435,239,437,237,437,235,435,234,431,235,430,233,426,232,425,232,422,233,422,235,419,236,419,234,418,234,416">
    <area href="#" state="AK" full="Alaska" shape="poly" coords="114,344,114,405,116,406,118,406,119,405,121,405,121,407,125,413,126,414,128,413,129,413,129,410,131,410,131,409,133,408,135,410,135,412,137,413,137,414,140,416,143,420,145,422,146,425,147,428,151,428,155,430,155,434,156,436,155,438,154,440,152,439,152,437,149,436,149,435,148,436,149,437,149,440,148,440,146,440,145,438,146,440,146,441,146,441,143,437,143,435,141,434,141,430,140,430,140,433,140,433,139,430,138,428,137,427,138,431,138,432,137,431,134,427,133,426,132,424,131,422,130,421,130,419,131,419,131,418,129,419,127,417,125,415,122,413,119,411,119,409,119,407,118,409,116,410,113,409,109,407,105,407,104,407,100,404,98,404,96,400,94,400,92,401,92,404,92,402,93,403,92,406,95,404,95,405,92,408,91,408,91,407,90,406,89,407,87,405,85,407,83,408,81,410,77,410,77,408,80,408,80,407,78,407,79,404,80,402,80,401,80,400,84,398,85,399,86,399,86,398,83,397,80,399,77,401,77,404,75,405,72,406,70,408,70,410,71,410,72,411,70,414,65,417,60,420,59,421,54,422,50,423,52,424,51,425,50,426,49,425,46,425,46,427,45,427,45,425,43,426,41,427,38,426,36,428,34,428,32,428,31,429,29,428,27,428,26,428,25,429,24,428,24,427,26,426,31,426,34,425,35,424,38,423,39,422,41,422,42,424,43,423,44,422,47,421,49,420,50,420,50,420,51,420,52,418,55,416,56,414,58,410,59,410,59,407,58,409,56,409,55,407,54,407,53,408,53,410,53,410,51,406,50,407,50,406,50,405,47,405,45,406,43,406,44,404,44,403,44,401,45,401,46,401,45,399,45,396,45,395,44,396,40,396,38,395,38,392,37,390,37,389,38,389,38,387,39,386,38,386,38,386,37,384,38,380,41,378,43,377,44,374,46,374,48,374,48,376,50,376,53,374,53,374,54,375,56,375,57,374,58,371,58,366,56,367,54,368,53,367,50,366,47,366,44,363,44,360,44,359,43,357,41,355,42,354,47,353,48,353,49,354,50,354,50,353,53,353,54,353,55,353,54,355,54,356,56,357,59,359,61,358,59,355,59,353,59,352,56,350,56,350,56,349,56,346,54,342,52,339,54,338,56,338,58,338,61,338,64,335,65,333,67,332,68,332,71,332,73,330,74,330,74,331,78,331,80,329,80,329,83,330,85,332,84,332,85,333,86,332,89,332,89,335,90,336,95,337,100,340,101,339,105,341,107,341,108,340,111,341,114,344">
    <area href="#" state="AK" shape="poly" coords="31,365,32,368,32,369,30,368,29,366,28,365,26,365,26,363,27,361,28,363,29,364,31,365">
    <area href="#" state="AK" shape="poly" coords="29,389,32,389,35,390,35,391,34,393,32,393,29,391,29,389">
    <area href="#" state="AK" shape="poly" coords="14,378,15,380,16,381,15,382,14,380,14,378,14,378">
    <area href="#" state="AK" shape="poly" coords="4,431,7,430,9,429,11,429,11,431,13,431,14,429,14,428,16,428,18,430,17,431,14,432,12,431,9,431,6,431,5,432,4,431">
    <area href="#" state="AK" shape="poly" coords="40,428,41,430,42,428,41,428,40,428">
    <area href="#" state="AK" shape="poly" coords="42,431,43,428,44,429,44,431,42,431">
    <area href="#" state="AK" shape="poly" coords="59,429,60,430,61,429,60,428,59,429">
    <area href="#" state="AK" shape="poly" coords="65,420,66,424,68,425,72,422,75,421,74,419,74,417,73,418,71,418,71,417,73,417,76,416,77,415,74,414,75,413,73,414,70,417,66,419,65,420">
    <area href="#" state="AK" shape="poly" coords="96,406,98,404,97,403,95,404,96,406">
    <area href="#" state="FL" full="Florida" shape="poly" coords="548,337,549,343,552,350,556,356,558,361,562,365,565,368,566,370,565,371,565,372,566,377,569,380,571,383,573,387,577,393,578,399,578,407,578,409,578,411,576,413,577,413,576,415,576,417,577,419,575,421,572,422,569,422,569,423,567,424,566,423,565,422,565,421,564,418,562,414,559,413,557,413,556,413,554,410,553,407,551,404,550,404,549,405,548,405,546,401,544,398,542,395,540,392,537,390,539,388,541,384,541,383,538,383,536,383,537,383,539,384,538,387,537,388,536,385,535,381,535,379,536,376,536,369,533,366,533,364,529,363,527,362,526,361,524,359,523,357,521,356,519,353,516,353,514,351,512,351,509,352,509,353,509,354,509,355,507,355,504,357,502,359,499,359,497,360,497,358,495,356,493,356,492,355,486,352,481,350,477,351,473,351,469,353,466,353,466,347,464,346,463,344,463,342,470,341,489,339,494,339,498,339,500,341,501,343,507,343,515,342,530,341,534,341,538,341,538,343,540,344,540,341,539,337,539,336,544,337,548,337">
    <area href="#" state="FL" shape="poly" coords="557,434,558,433,560,433,560,431,562,430,563,431,564,431,564,431,562,432,559,433,557,434,557,434">
    <area href="#" state="FL" shape="poly" coords="566,430,567,431,569,429,573,426,576,423,578,419,578,417,578,415,578,415,577,417,576,420,574,425,571,428,568,428,566,430">
    <area href="#" state="GA" full="Georgia" shape="poly" coords="500,274,497,275,490,275,484,276,484,278,484,279,485,281,487,287,489,295,490,299,491,302,492,308,494,312,495,314,496,317,497,317,497,319,496,323,496,325,496,326,497,329,497,333,497,335,497,336,498,336,498,339,500,341,501,343,507,343,515,342,530,341,534,341,538,341,538,343,540,344,540,341,539,337,539,336,544,337,548,337,547,332,548,325,550,322,549,320,552,315,551,314,551,314,548,314,548,312,547,310,545,308,544,308,542,304,540,299,537,299,536,297,535,295,533,293,532,293,530,290,528,289,524,287,524,287,523,284,522,284,520,280,518,280,515,278,513,277,513,276,514,275,515,274,515,272,514,272,510,273,505,274,500,274">
    <area href="#" state="AL" full="Alabama" shape="poly" coords="453,353,452,342,450,329,450,318,451,296,451,284,451,279,457,278,476,277,484,276,484,278,484,279,485,281,487,287,489,295,490,299,491,302,492,308,494,312,495,314,496,317,497,317,497,319,496,323,496,325,496,326,497,329,497,333,497,335,497,336,498,336,499,339,494,339,489,339,470,341,463,342,463,344,464,346,466,347,467,353,461,355,460,355,461,353,461,353,459,348,458,348,457,351,456,353,455,353,453,353">
    <area href="#" state="NC" full="North Carolina" shape="poly" coords="603,231,605,234,607,239,608,241,609,242,608,242,608,243,608,246,606,247,605,248,605,251,602,252,600,251,599,251,598,251,598,251,598,252,599,252,600,253,599,257,602,257,602,259,604,257,605,257,603,260,601,263,600,263,599,263,597,263,593,265,589,269,587,272,585,277,584,278,581,279,577,281,570,275,560,269,559,269,549,269,546,270,545,267,543,266,531,266,526,267,520,270,515,272,514,272,510,273,505,274,500,274,500,271,501,269,503,269,504,266,507,264,509,263,512,260,516,259,516,257,519,254,520,254,523,252,525,252,527,252,527,250,530,248,530,246,530,243,533,244,539,243,550,242,563,239,578,237,591,234,599,232,603,231">
    <area href="#" state="NC" shape="poly" coords="606,255,608,253,610,251,611,251,611,249,611,245,610,243,609,242,610,242,612,245,612,248,612,251,610,252,608,254,607,255,606,255">
    <area href="#" state="TN" full="Tennessee" shape="poly" coords="505,247,467,251,456,252,453,252,450,252,450,255,444,255,439,256,431,256,431,260,429,265,428,267,428,270,427,272,424,274,425,276,425,279,423,281,429,281,447,279,451,279,457,278,476,277,484,276,490,275,497,275,500,274,500,271,501,269,503,269,504,266,507,264,509,263,512,260,516,259,516,257,519,254,520,254,523,252,525,252,527,252,527,250,530,248,530,246,530,243,529,243,527,245,521,245,512,246,505,247">
    <area href="#" state="RI" full="Rhode Island" shape="poly" coords="633,145,633,142,632,139,632,134,635,134,637,134,639,137,641,140,639,142,638,141,638,143,635,144,633,145">
    <area href="#" state="CT" full="Connecticut" shape="poly" coords="634,145,633,142,632,139,632,134,628,135,612,139,612,141,614,146,614,152,613,154,614,155,617,153,620,151,621,149,622,149,624,149,628,148,634,145">
    <area href="#" state="MA" full="Massachusetts" shape="poly" coords="653,140,654,140,654,139,655,139,656,140,655,141,652,141,653,140">
    <area href="#" state="MA" shape="poly" coords="645,141,647,139,648,139,650,140,648,141,647,142,645,141">
    <area href="#" state="MA" shape="poly" coords="620,125,633,122,635,122,636,119,639,118,641,122,639,125,639,126,641,128,641,128,642,128,644,129,647,134,650,134,651,134,653,132,652,130,650,129,649,129,648,128,649,128,650,128,652,128,653,131,654,132,654,134,651,135,648,137,645,140,644,141,644,140,646,140,646,138,645,136,644,137,643,138,643,140,641,140,639,137,637,134,635,134,632,134,628,135,612,139,611,134,611,127,615,126,620,125">
    <area href="#" state="ME" full="Maine" shape="poly" coords="669,71,671,72,672,75,672,76,671,80,669,80,667,83,663,86,660,85,659,86,658,87,657,88,659,89,658,89,658,92,656,92,656,90,656,89,655,89,653,87,652,88,653,89,653,90,653,91,653,93,653,95,652,96,650,97,650,98,646,101,644,101,644,100,641,103,642,105,641,106,641,110,640,115,638,114,638,112,635,111,635,109,629,92,626,81,628,81,629,81,629,80,629,75,631,72,632,69,631,68,631,63,632,62,632,60,632,59,632,56,633,52,635,46,637,43,638,43,638,43,638,44,639,45,641,46,642,45,642,44,645,42,647,41,647,41,652,43,653,44,659,65,664,65,665,67,665,70,667,72,668,72,668,71,667,71,669,71">
    <area href="#" state="ME" shape="poly" coords="654,92,655,92,656,92,656,94,655,95,654,92">
    <area href="#" state="ME" shape="poly" coords="659,88,660,89,662,87,662,86,660,86,659,88">
    <area href="#" state="NH" shape="poly" coords="639,118,639,117,640,115,638,114,638,112,635,111,635,109,629,92,626,81,626,81,625,83,624,82,623,81,623,83,622,87,622,91,623,93,623,96,621,99,619,100,619,101,620,102,620,108,619,115,619,118,620,119,620,122,620,124,620,125,633,122,635,122,636,119,639,118">
    <area href="#" state="VT" shape="poly" coords="611,127,611,123,609,115,608,115,606,113,607,112,606,110,605,107,605,104,605,100,603,95,602,92,622,87,622,91,623,93,623,96,621,99,619,100,619,101,620,102,620,108,619,115,619,118,620,119,620,122,620,124,620,125,615,126,611,127">
    <area href="#" state="NY" full="New York" shape="poly" coords="600,152,599,152,598,152,596,150,594,146,592,146,590,144,577,147,545,153,539,155,539,149,541,148,542,147,542,146,543,146,545,144,545,143,547,141,548,140,548,140,547,137,545,137,544,133,546,131,549,131,552,129,554,129,559,129,560,130,562,130,563,129,565,128,569,128,570,127,572,125,572,123,574,123,575,122,575,120,575,119,575,118,575,116,575,115,574,115,572,115,572,114,572,112,576,108,577,107,578,105,580,102,582,99,584,98,585,96,587,95,591,95,593,95,597,93,602,92,603,95,605,100,605,104,605,107,606,110,607,112,606,113,608,115,609,115,611,123,611,127,611,134,611,138,612,141,614,146,614,152,613,154,614,155,614,156,612,158,613,158,614,158,614,158,616,155,617,155,618,155,620,155,626,153,628,151,629,150,632,151,629,154,626,155,621,160,620,160,615,161,612,162,611,162,611,160,611,158,611,156,609,155,605,155,603,154,600,152">
    <area href="#" state="NJ" full="New Jersey" shape="poly" coords="600,152,599,155,599,156,597,158,597,160,598,161,598,163,596,164,597,165,597,166,599,167,600,168,602,170,604,171,604,172,602,174,601,176,599,178,598,179,597,179,597,180,596,182,597,184,599,185,603,188,606,188,606,189,605,190,605,191,606,191,608,190,608,186,611,183,613,179,614,175,613,174,613,167,611,164,611,165,609,165,608,165,609,164,611,163,611,162,611,160,611,158,611,156,609,155,605,155,603,154,600,152">
    <area href="#" state="PA" full="Pennsylvania" shape="poly" coords="597,179,598,179,599,178,601,176,602,174,604,172,604,171,602,170,600,168,599,167,597,166,597,165,596,164,598,163,598,161,597,160,597,158,599,156,599,155,600,152,599,152,598,152,596,150,594,146,592,146,590,144,577,147,545,153,539,155,539,149,535,153,534,154,531,156,533,170,534,178,537,191,540,191,549,190,576,185,587,182,593,181,594,180,596,179,597,179">
    <area href="#" state="DE" shape="poly" coords="596,182,597,180,597,179,596,179,594,180,593,182,594,185,596,188,597,196,599,200,602,200,606,199,605,194,604,194,602,192,600,189,599,186,597,185,596,183,596,182">
    <area href="#" state="MD" shape="poly" coords="606,199,602,200,599,200,597,196,596,188,594,185,593,181,587,182,576,185,549,190,550,194,551,197,551,197,552,196,554,194,556,194,557,192,558,191,559,191,561,191,563,189,565,188,566,188,567,188,569,190,571,191,572,192,575,193,575,195,578,196,580,197,581,196,582,197,581,200,581,201,580,203,580,205,580,206,584,207,587,207,589,208,590,208,591,206,590,205,590,203,588,202,587,198,588,194,588,193,587,191,590,188,591,186,591,187,590,188,590,191,590,192,591,192,591,196,590,197,590,200,590,199,591,197,593,199,591,200,591,203,593,205,596,205,597,205,599,209,600,209,600,212,599,215,599,220,599,222,601,222,602,219,602,217,602,212,605,208,606,203,606,199">
    <area href="#" state="MD" shape="poly" coords="595,206,596,208,596,209,596,211,596,206,595,206">
    <area href="#" state="WV" shape="poly" coords="549,190,550,194,551,197,551,197,552,196,554,194,556,194,557,192,558,191,559,191,561,191,563,189,565,188,566,188,567,188,569,190,571,191,572,192,571,195,566,193,563,192,563,196,563,197,562,200,561,200,559,202,559,204,557,204,556,206,555,210,554,210,552,209,551,208,550,208,550,211,548,216,545,224,545,224,545,227,544,228,542,227,540,230,538,229,537,232,530,233,528,234,527,233,525,233,524,230,521,229,520,227,518,224,517,223,515,221,515,221,515,217,516,216,518,216,518,214,518,213,519,209,519,206,521,206,521,207,521,208,523,207,524,206,523,205,523,203,523,202,525,200,526,199,527,199,529,198,531,195,533,193,533,188,533,185,533,182,533,179,533,178,534,177,537,191,540,191,549,190">
    <area href="#" state="VA" full="Virginia" shape="poly" coords="524,230,525,233,527,233,528,234,530,233,532,232,538,229,540,230,542,227,544,228,545,227,545,224,545,224,548,216,550,211,550,208,551,208,552,209,554,210,555,210,556,206,557,204,559,204,559,202,561,200,562,200,563,197,563,196,563,192,566,193,571,195,572,191,575,193,575,195,578,196,580,197,581,196,582,197,581,200,581,201,580,203,580,205,580,206,584,207,585,208,589,209,590,210,593,210,594,212,593,215,594,215,594,217,596,218,596,220,593,219,593,220,594,221,594,221,596,222,596,224,596,225,595,227,595,227,597,227,599,226,600,226,603,231,599,232,591,234,578,237,563,239,550,242,539,243,533,244,530,243,529,243,527,245,521,245,512,246,505,247,507,246,511,244,514,242,514,241,515,239,518,236,521,233,524,230">
    <area href="#" state="KY" full="Kentucky" shape="poly" coords="524,230,521,233,518,236,515,239,514,241,514,242,511,244,507,246,505,247,467,251,456,252,453,252,450,252,450,255,444,255,439,256,431,256,432,255,434,254,435,253,435,251,436,249,435,248,435,246,437,245,439,245,440,245,443,246,444,246,444,245,443,242,443,241,445,240,446,239,448,239,447,238,446,236,448,236,449,233,450,232,455,231,458,231,458,233,460,233,461,230,463,230,464,231,465,232,467,231,467,229,469,227,470,227,470,228,473,228,474,227,474,225,476,222,479,220,480,216,482,216,485,215,487,213,486,212,485,211,485,209,488,209,491,209,493,210,494,213,498,213,499,215,500,215,503,214,505,214,506,215,508,213,509,212,510,212,511,214,512,215,515,216,515,221,515,221,517,223,518,224,520,227,521,229,524,230">
    <area href="#" state="OH" full="Ohio" shape="poly" coords="531,156,526,159,523,161,521,163,518,166,515,167,513,167,509,169,508,169,505,167,501,167,500,166,497,165,494,166,487,167,481,167,482,179,483,188,485,205,485,209,488,209,491,209,493,210,494,213,498,213,499,215,500,215,503,214,505,214,506,215,508,213,509,212,510,212,511,214,512,215,515,217,516,216,518,216,518,214,518,213,519,209,519,206,521,206,521,207,521,208,523,207,524,206,523,205,523,203,523,202,525,200,526,199,527,199,529,198,531,195,533,193,533,188,533,185,533,182,533,179,533,178,534,178,533,170,531,156">
    <area href="#" state="MI" full="Michigan" shape="poly" coords="422,74,423,73,425,72,428,69,430,68,431,69,427,73,424,74,422,75,422,74">
    <area href="#" state="MI" shape="poly" coords="484,98,485,99,487,99,488,98,485,96,484,96,483,97,484,98">
    <area href="#" state="MI" shape="poly" coords="506,143,503,137,502,131,500,128,498,127,497,128,494,129,493,133,491,135,490,136,489,135,490,129,491,127,491,125,493,124,493,116,491,115,491,114,490,113,491,112,491,113,491,111,490,110,489,107,487,107,484,107,480,104,478,104,477,104,476,104,474,103,473,104,470,106,470,108,471,108,473,109,473,110,471,110,470,110,468,111,468,113,468,114,468,118,466,119,465,119,465,116,467,115,467,113,467,113,465,113,464,116,462,117,461,118,461,119,461,119,461,122,459,122,459,122,460,125,459,128,458,131,458,135,458,136,458,137,458,138,458,140,460,145,462,149,463,152,463,156,462,161,460,164,460,166,458,168,457,169,461,169,476,167,481,167,481,167,487,167,494,166,498,165,497,164,497,164,499,161,500,159,500,156,501,155,502,155,502,152,503,149,504,150,504,151,505,151,506,150,506,143">
    <area href="#" state="MI" shape="poly" coords="410,95,412,95,414,94,416,92,416,92,417,92,421,91,423,89,426,88,426,87,428,85,429,84,430,83,431,81,434,80,438,79,439,80,439,80,436,81,435,83,433,84,433,86,431,88,431,90,431,90,432,89,434,87,436,89,437,89,440,89,440,90,442,92,444,94,446,94,448,93,449,95,450,95,451,94,452,94,453,93,456,91,458,90,463,89,467,89,468,87,470,87,470,92,470,92,472,92,473,92,478,91,479,90,479,90,479,95,482,98,483,98,484,99,483,99,482,99,479,98,478,99,476,99,474,100,473,100,468,99,464,99,464,101,458,101,457,102,455,104,455,105,455,105,453,104,450,106,449,106,449,104,448,104,447,107,446,110,443,116,442,116,441,115,440,107,437,107,437,104,428,103,425,102,419,100,413,99,410,95">
    <area href="#" state="WY" full="Wyoming" shape="poly" coords="257,119,249,118,226,116,214,114,194,111,179,109,178,117,175,135,171,157,170,164,169,173,174,174,186,176,192,176,207,178,234,181,252,182,255,150,257,132,257,119">
    <area href="#" state="MT" full="Montana" shape="poly" coords="259,104,260,95,261,77,262,66,263,56,240,53,219,51,197,48,174,44,161,41,137,37,134,52,137,57,135,61,137,64,139,65,142,73,144,75,145,76,147,77,147,78,142,91,142,93,144,95,145,95,148,93,149,92,150,93,149,97,152,106,154,107,155,108,156,110,155,112,156,115,157,116,158,113,161,113,163,115,164,114,167,114,170,116,172,115,173,113,175,113,176,113,176,116,178,117,179,109,194,111,214,114,226,116,249,118,257,119,259,107,259,104">
    <area href="#" state="ID" full="Idaho" shape="poly" coords="102,143,105,130,108,117,110,114,111,110,110,108,109,108,108,107,108,107,109,104,112,101,113,100,114,99,114,97,115,96,118,92,121,89,121,86,119,84,117,81,118,74,120,62,124,47,126,38,127,35,137,37,134,52,137,57,135,61,137,64,139,65,142,73,144,75,145,76,147,77,147,78,142,91,142,93,144,95,145,95,148,93,149,92,150,93,149,97,152,106,154,107,155,108,156,110,155,112,156,115,157,116,158,113,161,113,163,115,164,114,167,114,170,116,172,115,173,113,175,113,176,113,176,116,178,117,175,135,172,157,168,156,162,155,155,154,146,152,137,151,131,149,124,148,117,146,102,143">
    <area href="#" state="WA" full="Washington" shape="poly" coords="68,19,71,20,78,22,84,23,98,28,116,32,127,35,126,38,124,47,120,62,118,74,118,81,107,79,96,76,85,76,85,75,81,77,77,77,76,75,75,76,71,75,71,74,67,73,66,73,63,72,62,74,57,73,53,70,53,69,53,64,52,61,49,61,48,59,47,59,45,57,44,58,42,56,42,54,44,53,46,50,44,50,44,47,47,47,45,44,44,40,44,38,44,32,43,29,44,23,47,23,48,25,50,27,53,29,56,30,58,30,60,32,62,32,64,32,64,30,65,29,67,29,67,29,67,31,65,31,65,32,66,33,67,35,68,37,69,36,69,35,68,35,68,32,68,31,68,30,68,29,69,26,68,24,67,20,67,20,68,19">
    <area href="#" state="WA" shape="poly" coords="61,23,62,23,62,24,64,23,65,23,66,24,65,26,65,26,65,28,64,28,63,26,63,26,62,27,61,26,61,23">
   
    <area href="#" state="CA" full="California" shape="poly" coords="99,296,102,295,104,293,104,291,101,291,101,290,101,289,101,285,103,284,105,282,105,278,107,276,108,275,110,273,112,272,112,271,111,270,110,269,110,266,107,262,108,260,106,257,95,241,81,220,65,195,56,182,57,177,62,158,68,135,58,133,48,130,39,127,34,125,26,123,20,122,20,125,19,131,15,139,13,141,13,142,11,143,11,146,10,148,12,151,13,154,14,156,14,161,13,164,12,167,11,170,13,173,14,176,17,180,17,182,17,185,17,185,17,187,21,191,20,194,20,195,20,197,20,203,21,205,23,207,25,207,26,209,24,212,23,213,22,213,22,216,22,218,24,221,26,225,26,228,27,230,30,235,31,236,32,239,32,239,32,241,32,242,31,248,30,249,32,251,35,251,38,253,41,254,43,254,45,257,47,260,48,262,51,263,54,264,56,266,56,268,55,268,55,269,57,269,59,269,62,273,65,276,65,278,67,281,67,283,67,290,68,291,74,292,89,294,99,296">
    <area href="#" state="CA" shape="poly" coords="35,259,36,260,36,261,34,261,33,260,33,259,35,259">
    <area href="#" state="CA" shape="poly" coords="37,259,38,258,40,260,42,261,41,261,38,261,37,260,37,259">
    <area href="#" state="CA" shape="poly" coords="52,273,53,275,53,275,55,276,55,275,54,274,53,272,52,272,52,273">
    <area href="#" state="CA" shape="poly" coords="50,279,52,282,53,283,52,284,51,282,50,279">
    <area href="#" state="AZ" full="Arizona" shape="poly" coords="100,296,98,297,98,298,98,299,112,306,120,312,131,318,143,326,152,327,172,330,173,320,176,301,181,262,184,239,165,237,146,233,122,229,119,242,119,242,118,245,116,245,115,242,113,242,113,241,112,241,111,242,110,242,110,248,110,248,109,258,108,260,107,262,110,266,110,269,111,270,112,271,112,272,110,273,108,275,107,276,105,278,105,282,103,284,101,285,101,289,101,290,101,291,104,291,104,293,102,295,100,296">
    <area href="#" state="NV" full="Nevada" shape="poly" coords="102,143,117,146,124,148,131,149,137,151,136,155,133,167,131,182,129,189,128,199,125,211,123,221,122,230,119,242,119,242,118,245,116,245,115,242,113,242,113,241,112,241,111,242,110,242,110,248,110,248,109,258,108,260,106,257,95,241,81,220,65,195,56,182,57,177,62,158,68,135,92,141,102,143">
    <area href="#" state="UT" full="Utah" shape="poly" coords="184,240,165,237,146,233,122,229,123,221,125,211,128,199,129,189,131,182,133,167,136,155,137,151,146,152,155,154,162,155,168,156,172,157,170,164,169,173,174,174,186,176,193,176,191,192,188,209,185,229,185,237,184,240">
    <area href="#" state="CO" full="Colorado" shape="poly" coords="272,248,275,201,276,185,252,182,234,181,207,178,192,176,191,192,188,209,185,229,185,237,184,240,209,242,236,246,260,248,264,248,272,248">
    <area href="#" state="NM" full="New Mexico" shape="poly" coords="206,327,205,323,211,324,232,326,253,327,254,310,257,270,259,256,260,256,260,248,236,246,209,242,184,240,181,262,176,301,173,320,172,330,183,331,184,324,196,326,206,327">
    <area href="#" state="OR" full="Oregon" shape="poly" coords="102,143,105,130,108,117,110,114,111,110,110,108,109,108,108,107,108,107,109,104,112,101,113,100,114,99,114,97,115,96,118,92,121,89,121,86,119,84,118,81,107,79,96,76,85,76,85,75,81,77,77,77,76,75,75,76,71,75,71,74,67,73,66,73,63,72,62,74,57,73,53,70,53,69,53,64,52,61,49,61,48,59,47,59,42,60,41,65,38,72,36,77,32,87,28,97,22,106,20,108,20,114,19,119,20,122,26,123,34,125,39,127,48,130,58,133,68,135">
    <area href="#" state="OR" shape="poly" coords="102,143,68,135,92,141,102,143">
    <area href="#" state="ND" full="North Dakota" shape="poly" coords="342,107,341,101,341,96,339,86,338,80,338,77,336,73,336,65,337,63,335,59,314,59,300,58,281,57,263,56,262,66,261,77,260,95,259,104,300,107,342,107">
    <area href="#" state="SD" full="South Dakota" shape="poly" coords="343,162,343,161,341,159,343,155,344,152,341,150,341,148,342,146,344,146,344,141,344,119,343,117,340,115,339,113,339,112,341,111,342,110,342,107,300,107,259,104,259,107,257,119,257,132,255,151,266,152,281,152,294,153,311,154,319,154,320,155,324,158,325,158,328,157,331,157,333,157,334,158,338,158,340,160,341,161,341,163,342,163,343,162">
    <area href="#" state="NE" full="Nebraska" shape="poly" coords="352,194,353,195,353,197,354,200,356,203,352,203,320,203,291,201,275,200,276,185,252,182,255,151,266,152,281,152,294,153,311,154,319,154,320,155,324,158,325,158,328,157,331,157,333,157,334,158,338,158,340,160,341,161,341,163,342,163,344,162,344,167,347,172,347,176,349,178,349,182,350,185,350,190,352,194">
    <area href="#" state="IA" full="Iowa" shape="poly" coords="411,161,411,162,413,162,413,163,414,164,417,167,417,169,417,171,416,174,415,176,413,177,412,177,408,179,407,180,407,182,407,182,409,183,409,186,407,188,407,188,407,191,406,191,404,192,404,193,404,194,404,196,401,193,400,191,395,192,387,192,369,193,359,193,353,194,352,194,350,190,350,185,349,182,349,178,347,176,347,172,344,167,344,162,342,161,341,159,343,155,344,152,341,150,341,148,342,146,343,146,352,146,388,146,401,146,404,145,404,148,406,149,406,150,404,152,404,155,407,158,408,158,410,158,411,161">
    <area href="#" state="MS" full="Mississippipi" shape="poly" coords="453,353,452,354,449,354,448,353,446,353,441,355,440,354,438,357,437,358,437,356,436,353,433,350,434,345,434,344,432,344,426,345,409,346,408,344,409,338,411,334,415,328,414,326,415,326,416,324,414,323,414,321,413,318,413,314,413,312,413,309,412,307,413,305,412,304,413,303,413,299,416,296,415,295,418,291,419,290,419,289,419,287,421,284,423,283,423,281,429,281,447,279,451,279,451,284,451,296,450,318,450,329,452,342,453,353">
    <area href="#" state="IN" full="Indiana" shape="poly" coords="449,233,448,230,449,227,450,225,452,222,453,219,453,215,452,213,452,211,452,207,452,202,451,190,450,179,449,170,452,171,452,172,453,172,455,170,457,169,461,169,476,167,481,167,481,167,482,179,483,188,485,205,485,209,485,211,486,212,487,213,485,215,482,216,480,216,479,220,476,222,474,225,474,227,473,228,470,228,470,227,469,227,467,229,467,231,465,232,464,231,463,230,461,230,460,233,458,233,458,231,455,231,450,232,449,233">
    <area href="#" state="IL" full="Illinois" shape="poly" coords="448,233,448,230,449,227,450,225,452,222,453,219,453,215,452,213,452,211,452,207,452,202,451,190,450,179,449,170,449,170,448,168,447,165,446,164,445,162,444,158,437,159,418,161,411,160,411,162,413,162,413,163,414,164,417,167,417,169,417,171,416,174,415,176,413,177,412,177,408,179,407,180,407,182,407,182,409,183,409,186,407,188,407,188,407,191,406,191,404,192,404,193,404,194,404,195,403,197,403,200,404,206,410,211,414,213,413,217,414,218,419,218,421,219,421,221,419,226,419,228,420,231,425,235,428,236,429,239,431,241,431,243,431,246,433,248,435,248,435,246,437,245,439,245,440,245,443,246,444,246,444,245,443,242,443,241,445,240,446,239,448,239,447,238,446,236,448,236,448,233">
    <area href="#" state="MN" full="Minnesota" shape="poly" coords="342,107,341,101,341,96,339,86,338,80,338,77,336,73,336,65,337,63,335,59,357,59,357,53,358,53,359,53,361,54,362,58,362,62,364,63,367,63,368,65,372,65,372,66,376,66,376,65,377,65,378,64,379,65,381,65,384,67,388,68,389,68,390,68,391,68,392,70,393,71,394,71,395,71,395,72,397,73,399,73,400,72,402,70,404,69,404,71,405,71,406,71,407,71,413,71,414,73,415,73,415,72,419,72,418,74,415,75,408,78,405,80,403,81,401,84,399,86,398,87,395,91,394,91,392,93,392,94,390,95,389,98,389,104,389,105,385,107,383,112,383,112,386,113,386,116,385,119,385,121,385,126,387,128,389,128,391,131,393,131,396,135,401,138,403,140,404,146,401,146,388,146,352,146,343,146,344,141,344,119,343,117,340,115,339,113,339,112,341,111,342,110,342,107">
    <area href="#" state="WI" full="Wisconsin" shape="poly" coords="444,158,444,155,443,152,443,148,442,146,443,143,443,141,444,140,444,137,443,134,444,134,445,131,446,130,445,128,445,127,446,125,448,120,449,116,449,113,449,113,449,113,446,118,444,121,443,122,442,124,441,125,440,126,439,125,439,125,440,122,441,119,443,118,443,116,442,116,441,115,440,107,437,107,437,104,428,103,425,102,419,100,413,99,410,95,410,96,410,96,409,95,407,95,406,95,404,95,404,95,404,94,406,92,407,91,405,89,404,90,401,92,396,94,394,95,392,94,392,94,390,95,389,98,389,104,389,105,385,107,383,112,383,112,386,113,386,116,385,119,385,121,385,126,387,128,389,128,391,131,393,131,396,135,401,138,403,140,404,145,404,148,406,149,406,150,404,152,404,155,407,158,408,158,410,158,411,161,418,161,437,159,444,158">
    <area href="#" state="MO" full="Missouri" shape="poly" coords="404,196,401,193,400,191,395,192,387,192,369,193,359,193,353,194,352,194,353,195,353,197,354,200,356,203,359,205,361,205,362,206,362,208,360,209,360,210,362,213,363,215,365,216,366,225,365,251,365,254,366,259,383,258,400,258,415,257,423,257,424,259,424,261,422,263,421,265,425,266,429,265,431,260,431,256,433,255,434,254,435,253,435,251,436,249,435,248,433,248,431,246,431,243,431,241,429,239,428,236,425,235,420,231,419,228,419,226,421,221,421,219,419,218,414,218,413,217,414,213,410,211,404,206,403,200,403,197,404,196">
    <area href="#" state="AR" full="Arkansas" shape="poly" coords="429,265,425,266,421,265,422,263,424,261,424,259,423,257,415,257,400,258,383,258,366,259,367,264,367,270,368,278,368,305,370,307,372,305,374,306,374,314,391,314,404,314,413,314,413,312,413,309,412,307,413,305,412,304,413,303,413,299,416,296,415,295,418,291,419,290,419,289,419,287,421,284,423,283,423,281,425,280,425,276,424,274,427,272,428,270,428,267,429,265">
    <area href="#" state="OK" full="Oklahoma" shape="poly" coords="272,248,264,248,260,248,260,248,260,256,275,257,298,258,296,275,296,288,296,289,299,292,301,293,302,293,302,291,303,293,305,293,305,291,307,293,306,295,309,296,311,296,314,296,316,298,317,296,320,297,322,299,323,299,323,301,324,302,326,300,327,300,329,300,329,302,333,304,334,303,335,300,336,300,337,302,340,302,343,303,345,304,347,303,347,301,350,301,351,302,353,300,354,300,355,302,358,302,359,300,360,300,362,302,364,304,366,304,368,305,368,278,367,270,367,264,366,259,365,254,365,251,356,251,322,251,290,249,272,248">
    <area href="#" state="KS" full="Kansas" shape="poly" coords="365,251,356,251,322,251,290,249,272,248,275,200,291,201,320,203,352,203,356,203,359,205,361,205,362,206,362,208,360,209,360,210,362,213,363,215,365,216,366,225,365,251">
    <area href="#" state="LA" full="Louisiana" shape="poly" coords="437,357,437,356,436,353,433,350,434,345,434,344,432,344,426,345,409,346,408,344,409,338,411,334,415,328,414,326,415,326,416,324,414,323,414,321,413,318,413,314,404,314,391,314,374,314,374,321,375,329,376,331,377,334,378,338,381,341,381,344,382,344,381,350,379,354,380,356,380,358,380,363,378,365,379,368,382,367,388,366,395,369,400,370,403,369,405,370,407,371,408,369,406,368,404,368,401,367,406,366,407,366,410,366,410,368,410,370,414,370,416,371,415,372,414,373,415,374,421,377,424,376,425,374,426,374,428,372,428,373,429,375,428,376,428,377,431,375,432,373,433,373,431,372,431,371,431,370,433,370,434,369,434,369,440,374,441,374,443,374,444,375,446,373,446,372,445,372,443,370,438,369,436,368,437,366,438,366,439,365,437,365,437,365,440,365,441,362,440,361,440,359,439,359,437,361,437,362,434,362,434,361,435,359,437,358,437,357">

    </map>';
    }

    function list_applied_tax( $args = '' ) {
        global $post;
        $defaults = array(
            'show_option_all' => '', 'show_option_none' => __('No categories'),
            'orderby' => 'name', 'order' => 'ASC',
            'style' => 'list',
            'show_count' => 0, 'hide_empty' => 1,
            'use_desc_for_title' => 1, 'child_of' => 0,
            'feed' => '', 'feed_type' => '',
            'feed_image' => '', 'exclude' => '',
            'exclude_tree' => '', 'current_category' => 0,
            'hierarchical' => true, 'title_li' => __( 'Categories' ),
            'echo' => 1, 'depth' => 0,
            'taxonomy' => 'category', 'selected' => get_the_terms($post->ID, 'category')
        );
    
        $r = wp_parse_args( $args, $defaults );
    
        if ( !isset( $r['pad_counts'] ) && $r['show_count'] && $r['hierarchical'] )
            $r['pad_counts'] = true;
    
        if ( true == $r['hierarchical'] ) {
            $r['exclude_tree'] = $r['exclude'];
            $r['exclude'] = '';
        }
    
        if ( !isset( $r['class'] ) )
            $r['class'] = ( 'category' == $r['taxonomy'] ) ? 'categories' : $r['taxonomy'];
    
        extract( $r );
    
        if ( !taxonomy_exists($taxonomy) )
            return false;
    
        $all_categories = get_categories( $r );
        
        foreach($selected AS $s){
            $activetax[] = $s->term_id;
        }
            
        foreach($all_categories AS $ac){
            if(in_array($ac->term_id, $activetax)){
                $categories[] = $ac;
            }
        }
                    
        $output = '';
        if ( $title_li && 'list' == $style )
                $output = '<li class="' . esc_attr( $class ) . '">' . $title_li . '<ul>';
    
        if ( empty( $categories ) ) {
            if ( ! empty( $show_option_none ) ) {
                if ( 'list' == $style )
                    $output .= '<li class="cat-item-none">' . $show_option_none . '</li>';
                else
                    $output .= $show_option_none;
            }
        } else {
            if ( ! empty( $show_option_all ) ) {
                $posts_page = ( 'page' == get_option( 'show_on_front' ) && get_option( 'page_for_posts' ) ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/' );
                $posts_page = esc_url( $posts_page );
                if ( 'list' == $style )
                    $output .= "<li class='cat-item-all'><a href='$posts_page'>$show_option_all</a></li>";
                else
                    $output .= "<a href='$posts_page'>$show_option_all</a>";
            }
    
            if ( empty( $r['current_category'] ) && ( is_category() || is_tax() || is_tag() ) ) {
                $current_term_object = get_queried_object();
                if ( $current_term_object && $r['taxonomy'] === $current_term_object->taxonomy )
                    $r['current_category'] = get_queried_object_id();
            }
    
            if ( $hierarchical )
                $depth = $r['depth'];
            else
                $depth = -1; // Flat.
    
            $output .= walk_category_tree( $categories, $depth, $r );
        }
    
        if ( $title_li && 'list' == $style )
            $output .= '</ul></li>';
    
        $output = apply_filters( 'wp_list_categories', $output, $args );
    
        if ( $echo )
            echo $output;
        else
            return $output;
    }
    
    function print_footer_scripts()
        {
        global $wp,$wp_query, $areas;
            if($wp->query_vars["pagename"] == 'projects-state') {
                print '<script type="text/javascript">/* <![CDATA[ */
                    jQuery(function($)
                    {
                        var img = $(\'.imagemap\');
                        
                        img.mapster({
                            mapKey: \'state\',
                            isSelectable: false,
                            highlight: false,
                            areas : ['.$areas.']
                        });
                    });
                /* ]]> */</script>';
            } 
        }      
        function add_front_scripts(){
           global $post_type;
            if($post_type == $this->cpt){
               wp_enqueue_script('imagemapster',plugin_dir_url(dirname(__FILE__)).'js/jquery.imagemapster.min.js',array('jquery'),FALSE,TRUE);
            }
        }
         
        function add_admin_scripts() {
            global $current_screen;
            if($current_screen->post_type == $this->cpt){
                wp_enqueue_script('media-upload');
                wp_enqueue_script('thickbox');
                wp_enqueue_script('imagemapster',plugin_dir_url(dirname(__FILE__)).'js/jquery.imagemapster.min.js',array('jquery'),FALSE,TRUE);
            }
        }
        
        function add_admin_styles() {
            global $current_screen;
            if($current_screen->post_type == $this->cpt){
                wp_enqueue_style('thickbox');
                wp_enqueue_style('custom_meta_css',plugin_dir_url(dirname(__FILE__)).'css/meta.css');
            }
        }   
            
       function admin_print_footer_scripts()
        {
            global $current_screen, $areas;
            if($current_screen->post_type == $this->cpt){
                print '<script type="text/javascript">/* <![CDATA[ */
                    jQuery(function($)
                    {
                        var i=1;
                        $(\'.customEditor textarea\').each(function(e)
                        {
                            var id = $(this).attr(\'id\');
             
                            if (!id)
                            {
                                id = \'customEditor-\' + i++;
                                $(this).attr(\'id\',id);
                            }
             
                            tinyMCE.execCommand(\'mceAddControl\', false, id);
             
                        });
                                            
                        var img = $(\'.imagemap\'),
                            list = $(\'#statelist\');
                        
                        img.mapster({
                            mapKey: \'state\',
                            boundList: list.find(\'input\'),
                            listKey: \'value\',
                            listSelectedAttribute: \'checked\',
                            areas : ['.$areas.']
                        });
                    });
                /* ]]> */</script>';
                }
        }

        function change_default_title( $title ){
            global $current_screen;
            if  ( $current_screen->post_type == $this->cpt ) {
                return __('Project Title','project');
            } else {
                return $title;
            }
        }
        
        function info_footer_hook()
        {
            global $current_screen;
            if($current_screen->post_type == $this->cpt){
                ?><script type="text/javascript">
                        jQuery('#postdivrich').before(jQuery('#_contact_info_metabox'));
                    </script><?php
            }
        }
        

        function custom_query( $query ) {
            if(!is_admin()){
                $is_project = ($query->query_vars['project_type'] || $query->query_vars['market_sector'])?TRUE:FALSE;
                if($query->is_main_query() && $query->is_search){
                    $searchterm = $query->query_vars['s'];
                    // we have to remove the "s" parameter from the query, because it will prevent the posts from being found
                    $query->query_vars['s'] = "";
                    
                    if ($searchterm != "") {
                        $query->set('meta_value',$searchterm);
                        $query->set('meta_compare','LIKE');
                    };
                    $query->set( 'post_type', array('post','page',$this->cpt) );
                }
                elseif( $query->is_main_query() && $query->is_archive && $is_project ) {
                    $meta_query = array(
                           array(
                               'key' => '_project_feature',
                               'value' => 'true',
                               'compare' => '='
                           )
                       );
                    $query->set( 'meta_query', $meta_query);
                    $query->set( 'post_type', array('post','page',$this->cpt) );
                    $query->set('posts_per_page', 30);
                }
            }
        }           
  } //End Class
} //End if class exists statement