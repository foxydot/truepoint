<?php
/*
 * Add styles and scripts
*/
add_action('wp_enqueue_scripts', 'msdlab_add_styles');
add_action('wp_enqueue_scripts', 'msdlab_add_scripts');

function msdlab_add_styles() {
    global $is_IE;
    if(!is_admin()){
        //use cdn        
            wp_enqueue_style('bootstrap-style','//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.no-icons.min.css');
            $queue[] = 'bootstrap-style';
            wp_enqueue_style('font-awesome-style','//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css');
            $queue[] = 'font-awesome-style';
        //use local
            //wp_enqueue_style('bootstrap-style',get_stylesheet_directory_uri().'/lib/bootstrap/css/bootstrap.css');
            //wp_enqueue_style('font-awesome-style',get_stylesheet_directory_uri().'/lib/font-awesome/css/font-awesome.css',array('bootstrap-style'));
        wp_enqueue_style('msd-style',get_stylesheet_directory_uri().'/lib/css/style.css',$queue);
        $queue[] = 'msd-style';
        if($is_IE){
            wp_enqueue_script('ie-style',get_stylesheet_directory_uri().'/lib/css/ie.css');
            $queue[] = 'ie-style';
        }
        if(is_front_page()){
            wp_enqueue_style('msd-homepage-style',get_stylesheet_directory_uri().'/lib/css/homepage.css',$queue);
            $queue[] = 'msd-homepage-style';
        }        
    }
}

function msdlab_add_scripts() {
    global $is_IE;
    if(!is_admin()){
        wp_enqueue_script('grayscale',get_stylesheet_directory_uri().'/lib/js/grayscale.js',$queue);
        $queue[] = 'jquery';
        wp_enqueue_script('equalHeights',get_stylesheet_directory_uri().'/lib/js/jquery.equal-height-columns.js',$queue);
        //use cdn
            wp_enqueue_script('bootstrap-jquery','//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js',$queue);
        //use local
            //wp_enqueue_script('bootstrap-jquery',get_stylesheet_directory_uri().'/lib/bootstrap/js/bootstrap.min.js',$queue);
            $queue[] = 'bootstrap-jquery';
            $queue[] = 'grayscale';
        wp_enqueue_script('msd-jquery',get_stylesheet_directory_uri().'/lib/js/theme-jquery.js',$queue);
        if($is_IE){
            wp_enqueue_script('columnizr',get_stylesheet_directory_uri().'/lib/js/jquery.columnizer.js',$queue);
            wp_enqueue_script('ie-fixes',get_stylesheet_directory_uri().'/lib/js/ie-jquery.js',$queue);
        }
        if(is_front_page()){
            wp_enqueue_script('msd-homepage-jquery',get_stylesheet_directory_uri().'/lib/js/homepage-jquery.js',$queue);
        }
    }
}