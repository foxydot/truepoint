<?php

class def_Widget extends WP_Widget {
    function def_Widget(){
        parent::__construct(false,__('Terms and Definitions Diccionary','definiciones'));
    }
    
    function widget($args,$instance){
        extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$depth = $instance['depth'];
		
		echo $before_widget;
		
		if(!$title)
			$title = __('Dictionary','definiciones');
		echo $before_title . $title . $after_title;
		
		if(!$depth)
			$depth = 1;
		
        $list = wp_list_categories( array(
                'taxonomy'=>'def_family',
                'orderby'=>'name',
                'title_li'=>'',
                'show_count'=>1,
                'pad_counts'=>0,
                'hierarchical'=>1,
                'hide_empty'=>0,
                'echo'=>0,
                //'depth'=>$depth,
                'style'=>'list'
            )
        );
        if($list){
        	$list = str_replace("family","familia",$list);
            echo("<ul id='def_wlist'>".$list."</ul>");
        }
        
		?>
			<script type='text/javascript'>
				jQuery(document).ready(function(){
					jQuery('ul.children').hide();
					jQuery('.cat-item').each(function(){
						if(jQuery(this).has('ul.children').length)
							jQuery(this).prepend('<a href="#" style="text-decoration: none;" class="def_toggle">[+]</a> ');
					});
					jQuery('#def_wlist .cat-item a.def_toggle').click(function(e){
						e.preventDefault();
						jQuery(this).parent().children('ul').toggle();
						if(jQuery(this).text() == "[+]")
							jQuery(this).text("[-]");
						else
							jQuery(this).text("[+]");	
					});
				});

			</script>
			<?php
		
		echo $after_widget;
		
    }
    
    function update($new_instance, $old_instance){
        // Save widget options
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['depth'] = strip_tags($new_instance['depth']);
	    return $instance;     
    }
    
    function form($instance){
        // Widget form.
        $title = esc_attr($instance['title']);
		$depth = esc_attr($instance['depth']);
		?>
		 <p>
	      	<label for="<?php echo $this->get_field_id('title'); ?>"><?= __('Widget Title','definiciones'); ?></label>
	      	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	     </p>		
		 <p>
	      	<label for="<?php echo $this->get_field_id('depth'); ?>"><?= __('List Depth','definiciones'); ?></label>
	      	<input class="widefat" id="<?php echo $this->get_field_id('depth'); ?>" name="<?php echo $this->get_field_name('depth'); ?>" type="text" value="<?php echo $depth; ?>" />
	     </p>	   
	     <?php  
    }
}

?>