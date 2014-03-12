<?php
/*
Template Name: About You Section Template
*/
wp_enqueue_script('grayscale',get_stylesheet_directory_uri().'/lib/js/grayscale.js',FALSE,FALSE,TRUE);
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
function msdlab_do_post_tabs() {
    global $aboutyou_metabox;
    $aboutyou_metabox->the_meta();
    $nav_tabs = $tab_content = array();
    $i=0;
    while($aboutyou_metabox->have_fields('tabs')):
        $attachment_id = get_attachment_id_from_src($aboutyou_metabox->get_the_value('image'));
        $image = wp_get_attachment_image_src( $attachment_id, 'tab' );
        $nav_tabs[$i] = '<li'.($i==0?' class="active"':'').'><a href="#'.sanitize_title(wp_strip_all_tags($aboutyou_metabox->get_the_value('title'))).'" data-toggle="tab" data-option-value=".'.sanitize_title(wp_strip_all_tags($aboutyou_metabox->get_the_value('title'))).'"><img class="img-circle grayscale" src="'.$image[0].'" /><img class="img-circle logo-mark" src="'.get_stylesheet_directory_uri().'/lib/img/logo_mark.svg" /><h4 class="tab-title">'.$aboutyou_metabox->get_the_value('title').'</h4></a></li>';       
        $tab_content[$i] = '<div class="tab-pane fade'.($i==0?' in active':'').'" id="'.sanitize_title(wp_strip_all_tags($aboutyou_metabox->get_the_value('title'))).'"><h3 class="content-title">'.wp_strip_all_tags($aboutyou_metabox->get_the_value('title')).'</h3>'.apply_filters('the_content',$aboutyou_metabox->get_the_value('content')).'</div>';
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
    ?>
    <script>
    function graytabs(){
        var tabimg = jQuery('.nav-tabs li .grayscale').not('.nav-tabs li.active .grayscale');
        grayscale(tabimg);
    }
    jQuery(window).load(function($){
        graytabs();
    });
    jQuery(document).ready(function($) {
        
        //tab greys
        /*jQuery('.nav-tabs li .grayscale').not('.nav-tabs li.active .grayscale').mouseenter(function(){
            grayscale.reset($(this));
        });
        jQuery('.nav-tabs li .grayscale').not('.nav-tabs li.active .grayscale').mouseleave(function(){
            grayscale($(this));
        });*/
       
        var hash = window.location.hash.replace('tab-', '');
        hash && $('ul.nav a[href="' + hash + '"]').tab('show');
        var filter = $('.nav-tabs .active a').attr('href').replace('#','');  
        console.log(filter);
        $('.about-you-widget-area .widget').show();  
        $('.about-you-widget-area .widget:not(.' + filter + ', .all)').hide();  
        jQuery('.nav-tabs li').on('show.bs.tab',function(e){
            console.log(e.target);
            grayscale.reset(jQuery(e.target).find('.grayscale'));
            grayscale(jQuery(e.relatedTarget).find('.grayscale'));
            var filter = $(e.target).attr('href').replace('#','');  
            console.log(filter);
            $('.about-you-widget-area .widget').show();  
            $('.about-you-widget-area .widget:not(.' + filter + ', .all)').hide();  
        });
        
    });
    </script>
    <?php
}
add_action('genesis_after_loop','msdlab_do_post_tabs');


remove_action('genesis_before_content_sidebar_wrap', 'genesis_do_breadcrumbs'); //to outside of the loop area
genesis();
