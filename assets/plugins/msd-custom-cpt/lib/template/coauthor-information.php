<?php global $wpalchemy_media_access; ?>
<div class="my_meta_control gform_wrapper">
<ul class='gform_fields top_label description_below'>
    <li class='gfield' >
<div class='ginput_container' style="-moz-column-count: 3;
-moz-column-gap: 10px;
-webkit-column-count: 3;
-webkit-column-gap: 10px;
column-count: 3;
column-gap: 10px;">
    <?php 
    $team = new MSDTeamDisplay;
    $team_members = $team->get_all_team_members();
    foreach ($team_members as $item):
    $mb->the_field('team_members'); ?>
    <input type="checkbox" name="<?php $mb->the_name(); ?>[]" value="<?php echo $item->ID; ?>"<?php $mb->the_checkbox_state($item->ID); ?>/> <?php echo $item->post_title; ?><br/>
    <?php endforeach; ?>
</div></li>
</ul>
</div>