<?php
/*
Template Name: Reources Page
*/

add_action('genesis_after_loop',array('MSDResourcePage','resource_page_sidebar_output'));
add_action('genesis_after_loop',array('MSDLandingPage','landing_page_output'));
add_filter('msdlab_landing_page_output_classes','msdlab_switch_to_two_col');

function msdlab_switch_to_two_col($classes){
    if(($key = array_search('col-sm-4', $classes)) !== false) {
        unset($classes[$key]);
    }
    $classes[] = 'col-sm-6';
    return $classes;
}

genesis();
