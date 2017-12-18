<?php
add_action('genesis_after_loop','msdlab_add_disclaimer_once');

function msdlab_add_disclaimer_once(){
    global $post;
    $disclaimer_text = genesis_get_option('disclaimer_text');
    if(strlen($disclaimer_text) < 1){
        return false;
    }
    if(!is_cpt('post')){
        return false;
    }
    print '<div class="disclaimer-text">'.$disclaimer_text.'</div>';
}