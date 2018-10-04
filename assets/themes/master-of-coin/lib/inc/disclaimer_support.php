<?php
add_action('genesis_after_loop','msdlab_add_disclaimer_once');

function msdlab_add_disclaimer_once(){
    global $post;
    $disclaimer_text = genesis_get_option('disclaimer_text');
    $quarterly_disclaimer_text = genesis_get_option('quarterly_disclaimer_text');
    if(strlen($disclaimer_text) < 1){
        return false;
    }
    if(!is_cpt('post')){
        return false;
    }
    if(has_category('quarterly-insight') && strlen($disclaimer_text) > 0){
        print '<div class="disclaimer-text">'.$quarterly_disclaimer_text.'</div>';
    } else {
        print '<div class="disclaimer-text">'.$disclaimer_text.'</div>';
    }
}