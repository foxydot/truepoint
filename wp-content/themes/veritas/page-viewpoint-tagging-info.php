<?php
function get_all_content_info_into_table(){
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1
    );
    $posts = new WP_Query($args);
    if ( $posts->have_posts() ) {
            echo '
            <style>td{border: 1px solid #999;}</style>
            <table>
            <tr><th>Title</th><th>Author</th><th>Categories</th><th>Tags</th></tr>';
        while ( $posts->have_posts() ) {
            $posts->the_post();
            echo '<tr>';
            echo '<td>' . get_the_title() . '</td>';
            echo '<td>' . get_the_author() . '</td>';
            echo '<td>' . get_the_category_list() . '</td>';
            echo '<td>' . get_the_tag_list() . '</td>';
            echo '</tr>';
        }
            echo '</table>';
    } else {
        // no posts found
    }
}
add_action('genesis_loop','get_all_content_info_into_table');
genesis();
