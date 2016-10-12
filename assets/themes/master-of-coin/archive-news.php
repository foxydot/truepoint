<?php
add_action('genesis_before_loop','msdlab_add_page_content_to_archive');

remove_all_actions('msdlab_title_area');
add_action('msdlab_title_area','msdlab_archive_title');
remove_action('genesis_before_loop','genesis_do_cpt_archive_title_description');
add_action('genesis_before_loop','msdlab_do_cpt_archive_description');
function msdlab_archive_title(){
    if (msdlab_get_cpt_archive_title()):
        print msdlab_get_cpt_archive_title();
        return;
    elseif ( is_day() ) :
        $title = sprintf( __( 'Daily Archives: %s', 'veritas' ), '<span>' . get_the_date() . '</span>' );
    elseif ( is_month() ) :
        $title = sprintf( __( 'Monthly Archives: %s', 'veritas' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'veritas' ) ) . '</span>' );
    elseif ( is_year() ) :
        $title = sprintf( __( 'Yearly Archives: %s', 'veritas' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'veritas' ) ) . '</span>' );
    elseif ( is_cpt('news') ):
        $title = sprintf( __( '%s', 'veritas' ), '<span>News</span>' );
    else :
        $title = _e( 'Archives', 'veritas' );
    endif;
    print '<h1 class="entry-title" itemprop="headline">'.$title.'</h1>';
}

remove_action( 'genesis_entry_header', 'msdlab_post_info', 12 ); //remove the info (date, posted by,etc.)
remove_action( 'genesis_entry_footer', 'msdlab_post_meta' ); //remove the meta (filed under, tags, etc.)

genesis();
