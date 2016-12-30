<?php global $wpalchemy_media_access; ?>
<div class="my_meta_control" id="subtitle_metabox">
    <div class="table">
    <div class="row">
    	<div class="cell">
    	    <label>Subtitle</label>
            <div class="input_container">
    		<?php $mb->the_field('subtitle'); ?>
    		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" />
    		</div>
    	</div>
        <div class="cell">
            <label>Intro Text</label>
            <div class="input_container">
                <?php 
                $mb->the_field('intro');
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