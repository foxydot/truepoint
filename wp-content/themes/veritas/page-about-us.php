<?php
/*
Template Name: About Us Section Template
*/
remove_action('genesis_sidebar','genesis_do_sidebar');
add_action('genesis_sidebar','msdlab_do_about_us_sidebar');
function msdlab_do_about_us_sidebar(){
    if(is_active_sidebar('aboutus')){
        print '<div class="about-us-widget-area">';
        dynamic_sidebar('aboutus');
        print '</div>';
    }
}
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );
genesis();
