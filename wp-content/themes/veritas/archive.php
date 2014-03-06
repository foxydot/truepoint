<?php

global $wp_filter;
//ts_var( $wp_filter['body_class'] );

remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
add_action('genesis_before_loop','msdlab_archive_title');
function msdlab_archive_title(){
    print '<h1 class="entry-title" itemprop="headline">Archives for '. get_the_date( _x( 'F Y', 'monthly archives date format', 'veritas' ) ) .'</h1>';
}

remove_action('genesis_sidebar','genesis_do_sidebar');
add_action('genesis_sidebar','msdlab_do_blog_sidebar');
genesis();
