<?php
/*
Template Name: About You Section Template
*/
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
function msdlab_team_filter(){
   $terms = get_terms( 'practice_area' );
   $filters[] = '<a href="#" data-filter="*">All</a>';
   foreach($terms AS $term){
       $filters[] = '<a href="#" data-filter=".'.$term->slug.'">'.$term->name.'</a>';
   }
   $menu = '<div id="filters">'.implode(' | ', $filters).'</div>';
   print $menu;
}
add_action('genesis_entry_content','msdlab_team_filter');
function msdlab_team(){
    $msd_team_display = new MSDTeamDisplay;
    $team = $msd_team_display->get_all_team_members();
    print '<div id="team-members">';
    foreach($team AS $team_member){
        print $msd_team_display->team_display($team_member);
    }
    print '</div>';
}
add_action('genesis_entry_content','msdlab_team');
function msdlab_team_footer_scripts(){
    print '<script>
        jQuery(document).ready(function($) {
            $("#team-members").isotope({
              itemSelector : ".team-member",
              layoutMode : "fitRows"
            }); 
            
            // filter items when filter link is clicked
            $("#filters a").click(function(){
              var selector = $(this).attr("data-filter");
              $("#team-members").isotope({
                  itemSelector : ".team-member",
                  layoutMode : "fitRows",
                  filter: selector
                }); 
              return false;
            });   
        } );
    </script>';
}
add_action('wp_footer','msdlab_team_footer_scripts');
genesis();