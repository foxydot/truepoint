<?php
/*
Plugin Name: MSD Sharethis Email Override
Description: Simple email replacement for Sharethis bar.
Version: 0.1
Author: Catherine M OBrien Sandrick (CMOS)
Author URI: http://msdlab.com/biological-assets/catherine-obrien-sandrick/
License: GPL v2
*/

class MSDSharethisEmailOverride{
    function __construct(){
        add_action('wp_footer',array(&$this,'display_button'));
    }
    
    function display_button(){
        $display_string = '
                
        
    <a href="mailto:?subject='.get_the_title().'&body=Here is something from TruepointWealth that might interest you:%0D%0A%0D%0A'.get_the_title().'%0D%0A'.get_the_permalink().'" target="_blank" st_title="'.get_the_title().'" st_url="'.get_the_permalink().'" class="msdlab_email">
        <span class="stButton" style="text-decoration: none; color: rgb(0, 0, 0); display: inline-block; cursor: pointer; padding-left: 0px; padding-right: 0px; width: 16px;top:3px;">
            <span class="chicklets email"></span>
        </span>
    </a>
    ';
        $script = '<script>
        jQuery(document).ready(function($) {
            $(".entry-content .no-break").append($(".msdlab_email"));
        });
        </script>';
    print $display_string;
    print $script;
    }
}

$msd_sharethis_email_override = new MSDSharethisEmailOverride;