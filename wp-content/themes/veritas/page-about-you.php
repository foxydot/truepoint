<?php
/*
Template Name: About You Section Template
*/
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
function msdlab_do_post_tabs() {
    global $aboutyou_metabox;
    $aboutyou_metabox->the_meta();
    $nav_tabs = $tab_content = array();
    $i=0;
    while($aboutyou_metabox->have_fields('tabs')):
        $nav_tabs[$i] = '<li'.($i==0?' class="active"':'').'><a href="#'.sanitize_key($aboutyou_metabox->get_the_value('title')).'" data-toggle="tab"><img class="img-circle" src="'.$aboutyou_metabox->get_the_value('image').'" /><h4 class="tab-title">'.$aboutyou_metabox->get_the_value('title').'</h4></a></li>';       
        $tab_content[$i] = '<div class="tab-pane fade'.($i==0?' in active':'').'" id="'.sanitize_key($aboutyou_metabox->get_the_value('title')).'"><h3 class="content-title">'.$aboutyou_metabox->get_the_value('title').'</h3>'.$aboutyou_metabox->get_the_value('content').'</div>';
        $i++;
    endwhile; //end loop
    print '<div class="about-you-tabs">
    ';
    print '<!-- Nav tabs -->
        <ul class="nav nav-tabs tabs-'.count($nav_tabs).'">
        '.implode("\n", $nav_tabs).'
        </ul>
        ';
    print '<!-- Tab panes -->
        <div class="tab-content">
        '.implode("\n", $tab_content).'
        </div>
        '; 
    print '</div>
    ';
    if(is_active_sidebar('aboutyou')){
        print '<div class="about-you-widget-area row">';
        dynamic_sidebar('aboutyou');
        print '</div>';
    }
}
add_action('genesis_after_loop','msdlab_do_post_tabs');
genesis();
