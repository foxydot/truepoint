<?php
add_action('genesis_before_loop','msdlab_add_page_content_to_archive');

add_action('msdlab_title_area','msdlab_news_archive_title');
function msdlab_news_archive_title(){
    print '<h1 class="entry-title" itemprop="headline">Truepoint News</h1>';
}

remove_action( 'genesis_entry_header', 'msdlab_post_info', 12 ); //remove the info (date, posted by,etc.)
remove_action( 'genesis_entry_footer', 'msdlab_post_meta' ); //remove the meta (filed under, tags, etc.)

genesis();
