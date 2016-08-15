<?php
/*
Template Name: Landing Page
*/
add_action('genesis_after_content','msdlab_feature_blocks');
function msdlab_feature_blocks(){
    print "feature blocks go here";
}
genesis();
