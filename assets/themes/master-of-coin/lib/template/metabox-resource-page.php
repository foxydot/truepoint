<?php global $wpalchemy_media_access; ?>
<div class="my_meta_control" id="resource_page_sidebar_metabox">
    <div class="table">
    <div class="row">
    	<div class="cell">
    	    <label>Resource Sidebar Content</label>
            <div class="input_container">
                <?php 
                $mb->the_field('resource_sidebar');
                $mb_content = html_entity_decode($mb->get_the_value(), ENT_QUOTES, 'UTF-8');
                $mb_editor_id = sanitize_key($mb->get_the_name());
                $mb_settings = array('textarea_name'=>$mb->get_the_name(),'textarea_rows' => '5',);
                wp_editor( $mb_content, $mb_editor_id, $mb_settings );
                ?>
           </div>
        </div>
    </div>
    </div>
</div>