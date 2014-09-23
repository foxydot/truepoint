<?php

	global $wp_version;
	$wp35 = false;
	if(version_compare($wp_version,'3.5','>=')){
		$wp35 = true;
	}

    $def_reconocer = get_option("def_reconocer");
    $def_tipo = get_option("def_tipo");
	$def_autodetect = get_option("def_autodetect");	// New! v1.4
    
    $def_tooltip_width = get_option("def_tooltip_width");
    $def_tooltip_height = get_option("def_tooltip_height");
    $def_term_text_color = get_option("def_term_text_color");
    $def_term_text_underline = get_option("def_term_text_underline");
    $def_tooltip_bg_color = get_option("def_tooltip_bg_color");
    $def_tooltip_text_color = get_option("def_tooltip_text_color");
    $def_tooltip_border = get_option("def_tooltip_border");
    $def_tooltip_border_color = get_option("def_tooltip_border_color");
    $def_tooltip_border_weight = get_option("def_tooltip_border_weight");
    $def_tooltip_border_radius = get_option("def_tooltip_border_radius");
    $def_padding = get_option("def_padding");
    $def_custom_css = get_option("def_custom_css");
    
    $def_trigger = get_option("def_trigger");
    $def_effect_type = get_option("def_effect_type");
    $def_slide_direction = get_option("def_slide_direction");
    $def_opacity = get_option("def_opacity");
    $def_tooltip_position = get_option("def_tooltip_position");
    
?>
	<h3><?=__('Plugin options','definiciones')?></h3>
	<form id="def_form" method="post">
		<table class="def_table_form">
			<tr>
				<th colspan="2">
					<?=__('Content type','definiciones'); ?>
				</th>
			</tr>
			<tr>
				<td class="td_label">
					<label for="def_autodetect"><?=__('Autodetect Terms','definiciones')?></label>
				</td>
				<td class="td_input">
					<select name="def_autodetect" id="def_autodetect">
						<option value="no" <?=($def_autodetect == 'no' ? 'selected="selected"' : '')?> ><?=__('No','definiciones')?></option>
						<option value="si" <?=($def_autodetect == 'si' ? 'selected="selected"' : '')?> ><?=__('Yes','definiciones')?></option>
						<option value="si_partial" <?=($def_autodetect == 'si_partial' ? 'selected="selected"' : '')?> ><?=__('Yes, when there is no other definitions','definiciones')?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="td_label">
					<label for="def_reconocer"><?=__('Term Recognition','definiciones')?></label>
				</td>
				<td class="td_input">
					<select name="def_reconocer" id="def_reconocer">
						<option value="post_title" <?=($def_reconocer == 'post_title' ? 'selected="selected"' : '')?> ><?=__('By Post Title','definiciones')?></option>
						<option value="post_name" <?=($def_reconocer == 'post_name' ? 'selected="selected"' : '')?> ><?=__('By Post Slug','definiciones')?></option>
						<option value="id" <?=($def_reconocer == 'id' ? 'selected="selected"' : '')?> ><?=__('By Post ID','definiciones')?></option>
					</select>
					<img src="<?=plugins_url(plugin_basename('definiciones-pro').'/img/info.jpg')?>" class="tooltip infoimg" title='<?=__('You can introduce the terms into your post as: [def]Term[/def], where Term can be Definition Title, Definition Slug or Definition ID. If Title is selected, you have to take care of do not have two Definitions with the same title. If Slug is selected, you should know the slug of the Definition (you can found it editing the Definition, below the Content editor; if you could not find it, in the header of the site press the Options button and select Slug). If ID is selected, you can find the Definition ID in the URL: "/post.php?post=X", being X the ID (always a number). Choosing Slug or ID solves the problem of having two definitions with same title, but is not recommended in order to avoid confusions.','definiciones')?>'>
				</td>
			<tr>
				<td class="td_label">
					<?=__('Type','definiciones')?>
				</td>
				<td class="td_input">
					<select name='def_tipo' id='def_tipo'>
						<option value='html' <?=($def_tipo == 'html' ? 'selected="selected"' : '')?> ><?=__('HTML "title" Attribute','definiciones')?></option>
						<option value='jquery' <?=($def_tipo == 'jquery' ? 'selected="selected"' : '')?> ><?=__('Effects Globe (jQuery)','definiciones')?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" class="td_advice">
					<?=__('<i><b>Attention:</b> if effects doesn´t work in the visitor´s browser, type will be "HTML title Attribute"</i>','definiciones')?>
				</td>
			</tr>
		</table>
		<table class="def_table_form" id="def_table_jquery_opts">
			<tr>
				<th colspan="2">
					<?=__('Style & CSS','definiciones')?>
				</th>
			</tr>
			<tr>
			    <td colspan="2">
			        <b><u><?=__('Term text','definiciones');?></b></u>
			    </td>
			</tr>
            <tr>
                <td class="td_label">
                    <label for="def_term_text_color"><?=__('Term text color','definiciones')?></label>
                </td>
                <td class="td_input"> 
                    <?php if($wp35){ ?>
						<input type="text" value="<?=$def_term_text_color?>" class="def-wp-color-field" name="def_term_text_color" id="def_term_text_color" title="<?=__('Hexadecimal values (#000000) or HTML format (red, blue...)','definiciones')?>" />
					<?php }else{ ?>
                    	<input type="color" name="def_term_text_color" class="colorbox" id="def_term_text_color" value="<?=$def_term_text_color?>" title="<?=__('Hexadecimal values (#000000) or HTML format (red, blue...)','definiciones')?>">
                	<?php } ?>
                </td>
            </tr>
            <tr>
                <td class="td_label">
                    <label for="def_term_text_underline"><?=__('Term text underlined','definiciones')?></label>
                </td>
                <td class="td_input"> 
                    <select name="def_term_text_underline" id="def_term_text_underline">
                        <option value="solid" <?=($def_term_text_underline == 'solid' ? 'selected="selected"' : '')?> ><?=__('Solid line','definiciones')?></option>
                        <option value="dashed" <?=($def_term_text_underline == 'dashed' ? 'selected="selected"' : '')?> ><?=__('Dashed line','definiciones')?></option>
                        <option value="dotted" <?=($def_term_text_underline == 'dotted' ? 'selected="selected"' : '')?> ><?=__('Dotted line','definiciones')?></option>
                        <option value="none" <?=($def_term_text_underline == 'none' ? 'selected="selected"' : '')?> ><?=__('None','definiciones')?></option>
                    </select>
                </td>               
            </tr>
            <tr>
                <td colspan="2">
                    <hr>
                </td>
            </tr>
			<tr>
			    <td colspan="2">
			        <b><u><?=__('Tooltip','definiciones');?></u></b>
			    </td>
			</tr>
			<tr>
				<td class="td_label">
					<label for="def_tooltip_width"><?=__('Width','definiciones')?></label>
				</td>
				<td class="td_input">
					<input type="text" id="def_tooltip_width" name="def_tooltip_width" value="<?=$def_tooltip_width?>" title="<?=__('Insert the value followed of unit (px, %, em...)','definiciones')?>">
				</td>
			</tr>
			<tr>
				<td class="td_label">
					<label for="def_tooltip_height"><?=__('Height','definiciones')?></label>
				</td>
				<td class="td_input">
					<input type="text" id="def_tooltip_height" name="def_tooltip_height" value="<?=$def_tooltip_height?>" title="<?=__('Insert the value followed of unit (px, %, em...)','definiciones')?>">
				</td>
			</tr>
			<tr>
				<td class="td_label">
					<label for="def_tooltip_bg_color"><?=__('Tooltip Background Color','definiciones')?></label>
				</td>
				<td class="td_input">
                    <?php if($wp35){ ?>
						<input type="text" value="<?=$def_tooltip_bg_color?>" class="def-wp-color-field" name="def_tooltip_bg_color" id="def_tooltip_bg_color" title="<?=__('Hexadecimal values (#000000) or HTML format (red, blue...)','definiciones')?>" />
					<?php }else{ ?>
						<input type="color" name="def_tooltip_bg_color" id="def_tooltip_bg_color" value="<?=$def_tooltip_bg_color?>" class="colorbox" title="<?=__('Hexadecimal values (#000000) or HTML format (red, blue...)','definiciones')?>">
					<?php } ?>
				</td>
			</tr>
			<tr>
			    <td class="td_label">
			        <label for="def_tooltip_text_color"><?=__('Tooltip Text Color','definiciones')?></label>
			    </td>
			    <td class="td_input">
                    <?php if($wp35){ ?>
						<input type="text" value="<?=$def_tooltip_text_color?>" class="def-wp-color-field" name="def_tooltip_text_color" id="def_tooltip_text_color" title="<?=__('Hexadecimal values (#000000) or HTML format (red, blue...)','definiciones')?>" />
					<?php }else{ ?>
			        	<input type="color" name="def_tooltip_text_color" id="def_tooltip_text_color" value="<?=$def_tooltip_text_color?>" class="colorbox" title="<?=__('Hexadecimal values (#000000) or HTML format (red, blue...)','definiciones')?>">
			    	<?php } ?>
			    </td>
			</tr>
			<tr>
				<td class="td_label">
					<label for="def_tooltip_border"><?=__('Tooltip Border Type','definiciones')?></label>
				</td>
				<td class="td_input">
					<select name="def_tooltip_border" id="def_trigger">
                        <option value="solid" <?=($def_tooltip_border == 'solid' ? 'selected="selected"' : '')?> ><?=__('Solid line','definiciones')?></option>
                        <option value="dashed" <?=($def_tooltip_border == 'dashed' ? 'selected="selected"' : '')?> ><?=__('Dashed line','definiciones')?></option>
                        <option value="dotted" <?=($def_tooltip_border == 'dotted' ? 'selected="selected"' : '')?> ><?=__('Dotted line','definiciones')?></option>
                        <option value="none" <?=($def_tooltip_border == 'none' ? 'selected="selected"' : '')?> ><?=__('None','definiciones')?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="td_label">
					<label for="def_tooltip_border_color"><?=__('Tooltip Border Color','definiciones')?></label>
				</td>
				<td class="td_input">
                    <?php if($wp35){ ?>
						<input type="text" value="<?=$def_tooltip_border_color?>" class="def-wp-color-field" name="def_tooltip_border_color" id="def_tooltip_border_color" title="<?=__('Hexadecimal values (#000000) or HTML format (red, blue...)','definiciones')?>" />
					<?php }else{ ?>
						<input type="color" id="def_tooltip_border_color" name="def_tooltip_border_color" value="<?=$def_tooltip_border_color?>" class="colorbox" title="Introduzca un valor en hexadecimal (#000000) o en formato HTML/CSS">
					<?php } ?>
				</td>
			</tr>
			<tr>
				<td class="td_label">
					<label for="def_tooltip_border_weight"><?=__('Tooltip Border Weight','definiciones')?></label>
				</td>
				<td class="td_input">
					<input type="text" name="def_tooltip_border_weight" id="def_tooltip_border_weight" value="<?=$def_tooltip_border_weight?>" title="<?=__('Insert the value followed of unit (px, %, em...)','definiciones')?>">
				</td>
			</tr>
            <tr>
                <td class="td_label">
                    <label for="def_tooltip_border_radius"><?=__('Tooltip Border Radius','definiciones')?></label>
                </td>
                <td class="td_input">
                    <input type="text" name="def_tooltip_border_radius" id="def_tooltip_border_radius" value="<?=$def_tooltip_border_radius?>" title="<?=__('Only for compatible browsers','definiciones')?>">
                </td>
            </tr>
			<tr>
				<td class="td_label">
					<label for="def_padding"><?=__('Space between border and text (padding)','definiciones')?></label>
				</td>
				<td class="td_input">
					<input type="text" name="def_padding" id="def_padding" value="<?=$def_padding?>" title="<?=__('Insert the value followed of unit (px, %, em...)','definiciones')?>">
				</td>
			</tr>
			<tr>
				<td class="td_label">
					<label for="def_custom_css"><?=__('Specify your own Tooltip CSS (only attributes and values).<br><b>Note</b>: If you use this, the above fields will be ignored.','definiciones')?></label>
				</td>
				<td class="td_input" align="left">
					.tooltip{<br>
					<textarea name="def_custom_css" id="def_custom_css" rows="10" cols="30" style="margin-left:20px;"><?=$def_custom_css?></textarea><br>
					}
				</td>
			</tr>
			<tr>
				<td>
					
				</td>
			</tr>
			
			<tr>
				<th colspan="2">
					<?=__('Effects','definiciones')?>
				</th>
			</tr>
			<tr>
				<td class="td_label">
					<label for="def_trigger"><?=__('Effect Event Trigger','definiciones')?></label>
				</td>
				<td class='td_input'>
					<select name="def_trigger" id="def_trigger">
						<option value="hover" <?=($def_trigger == 'hover' ? 'selected="selected"' : '')?> ><?=__('Mouse Hover to show (Mouse Out to hide)','definiciones')?></option>
						<option value="click" <?=($def_trigger == 'click' ? 'selected="selected"' : '')?> ><?=__('Clicking on Term (Click on tooltip to hide)','definiciones')?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="td_label">
					<label for="def_effect_type"></label><?=__('Effect Type','definiciones')?>
				</td>
				<td class="td_input">
					<select name="def_effect_type" id="def_effect_type">
						<option value="toggle" <?=($def_effect_type == 'toggle' ? 'selected="selected"' : '')?> ><?=__('Toggle','definiciones')?></option>
						<option value="fade" <?=($def_effect_type == 'fade' ? 'selected="selected"' : '')?> ><?=__('Fade','definiciones')?></option>
						<option value="slide" <?=($def_effect_type == 'slide' ? 'selected="selected"' : '')?> ><?=__('Slide','definiciones')?></option>
					</select>
				</td>
			</tr>
			<tr id="tr_slide_direction">
				<td class="td_label">
					<label for="def_slide_direction"><?=__('Effect Direction','definiciones')?> Dirección</label>
				</td>
				<td class="td_input">
					<select name="def_slide_direction" id="def_slide_direction">
						<option value="up" <?=($def_slide_direction == 'up' ? 'selected="selected"' : '')?> ><?=__('Up','definiciones')?></option>
						<option value="down" <?=($def_slide_direction == 'down' ? 'selected="selected"' : '')?> ><?=__('Down','definiciones')?></option>
						<option value="left" <?=($def_slide_direction == 'left' ? 'selected="selected"' : '')?> ><?=__('Left','definiciones')?></option>
						<option value="right" <?=($def_slide_direction == 'right' ? 'selected="selected"' : '')?> ><?=__('Right','definiciones')?></option>
					</select>
				</td>
			</tr>
			<tr>
			    <td class="td_label">
			        <label for="def_opacity"><?=__("Opacity","definiciones");?></label>
			    </td>
			    <td>
			        <span id="def_opacity_count"><?=number_format($def_opacity,1)?></span> - <input type="range" name="def_opacity" id="def_opacity" min="0.0" max="1.0" step="0.1" value="<?=$def_opacity?>"> 
			        <img src="<?=plugins_url(plugin_basename('definiciones-pro').'/img/info.jpg')?>" class="tooltip infoimg" title='<?=__('Introduce a value between 0.0 and 1.0 (0.1, 0.2...)','definiciones');?>'>
			    </td>
			</tr>
			<tr>
				<td class="td_label">
					<?=__('Position','definiciones')?>
				</td>
				<td class="td_input">
					<table id="def_positions_table">
						<tr>
							<td>
								<input type="radio" name="def_tooltip_position" id="topleft" value="top left" <?=($def_tooltip_position == 'top left' ? 'checked="checked"' : '')?> ><label for="topleft"><?=__('Top Left','definiciones')?></label>
							</td>
							<td>
								<input type="radio" name="def_tooltip_position" id="topcenter" value="top center" <?=($def_tooltip_position == 'top center' ? 'checked="checked"' : '')?> ><label for="topcenter"><?=__('Top Center','definiciones')?></label>
							</td>
							<td>
								<input type="radio" name="def_tooltip_position" id="topright" value="top right" <?=($def_tooltip_position == 'top right' ? 'checked="checked"' : '')?> ><label for="topright"><?=__('Top Right','definiciones')?></label>
							</td>
						</tr>
						<tr>
							<td>
								<input type="radio" name="def_tooltip_position" id="centerleft" value="center left" <?=($def_tooltip_position == 'center left' ? 'checked="checked"' : '')?> ><label for="centerleft"><?=__('Center Left','definiciones')?></label>
							</td>
							<td>
								<i><?=__('Term','definiciones')?></i>
							</td>
							<td>
								<input type="radio" name="def_tooltip_position" id="centerright" value="center right" <?=($def_tooltip_position == 'center right' ? 'checked="checked"' : '')?> ><label for="centerright"><?=__('Center Right','definiciones')?></label>
							</td>
						</tr>
						<tr>
							<td>
								<input type="radio" name="def_tooltip_position" id="bottomleft" value="bottom left" <?=($def_tooltip_position == 'bottom left' ? 'checked="checked"' : '')?> ><label for="bottomleft"><?=__('Bottom Left','definiciones')?></label>
							</td>
							<td>
								<input type="radio" name="def_tooltip_position" id="bottomcenter" value="bottom center" <?=($def_tooltip_position == 'bottom center' ? 'checked="checked"' : '')?> ><label for="bottomcenter"><?=__('Bottom Center','definiciones')?></label>
							</td>
							<td>
								<input type="radio" name="def_tooltip_position" id="bottomright" value="bottom right" <?=($def_tooltip_position == 'bottom right' ? 'checked="checked"' : '')?> ><label for="bottomright"><?=__('Bottom Right','definiciones')?></label>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<input type="hidden" name="action" value="save">
		<p><input type="submit" id="savebutton" class="button-secondary" value="<?=__('Save all changes','definiciones')?>"></p>
	</form>
    <div>
        <p><i><?=__('Developed by','definiciones');?> <a href='http://www.codigonexo.com/'>Codigonexo</a> - <a href='<?=home_url("/wp-admin/admin.php?page=/includes/about.php")?>'><?=__('About','definiciones');?></a></i></p>
    </div>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('#def_opacity').change(function(){
		    jQuery('#def_opacity_count').text(parseFloat(jQuery('#def_opacity').val()).toFixed(1));
		});
		
		
	/*	jQuery('.colorbox').each(function(){
			jQuery(this).ColorPicker({
				flat: true,
				eventName: 'click'
			});
		});*/
		
		jQuery('.imginfo').each(function(){
			jQuery(this).tooltip({
				position: 'bottom right',
				effect: 'slide',
				direction: 'left'
			});
		});
		
		if(jQuery('#def_tipo').val() == "html")
            jQuery("#def_table_jquery_opts").hide();
		
		jQuery('#def_tipo').change(function(){
			if(jQuery('#def_tipo').val() == "html"){
				jQuery("#def_table_jquery_opts").fadeOut('fast');
			} else {
				jQuery("#def_table_jquery_opts").fadeIn('fast');
			}
		});
		
		if(jQuery('#def_effect_type').val() != "slide")
		    jQuery("#tr_slide_direction").hide();
		  
		jQuery('#def_effect_type').change(function(){
            if(jQuery('#def_effect_type').val() != "slide"){
                jQuery("#tr_slide_direction").fadeOut('fast');
            } else {
                jQuery("#tr_slide_direction").fadeIn('fast');
            }
		})
		
		// Repetir con el tipo de efecto y la dirección.
	});
</script>
