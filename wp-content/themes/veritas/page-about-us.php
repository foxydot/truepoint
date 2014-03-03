<?php
/*
Template Name: About Us Section Template
*/
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );
genesis();
