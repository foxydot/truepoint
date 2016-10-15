<?php
//$post_types = get_post_types(array('public'=>true,'show_ui'=>true));
$post_types = array(
    'post' => 'Post',
    'page' => 'Page',
    'msd_video' => 'Video',
    'news' => 'News',
    'press' => 'Press Release',
    'event' => 'Event',
    'team_member' => 'Team Member',
);
$contents = array();
foreach($post_types AS $k=>$v){
    $args = array(
        'post_type' => $k,
        'posts_per_page' => 50,
    );
    $contents[$k] = get_posts($args);
}
?>
<style>
    .msdlab_block{
        border: 1px solid #ddd;
        padding: 8px;
    }
    .dodelete{
        float: right;
    }
</style>
<div class="msdlab_meta_control" id="msdlab_meta_control">
    <p id="warning" style="display: none;background:lightYellow;border:1px solid #E6DB55;padding:5px;">Order has changed. Please click Save or Update to preserve order.</p>
    <div class="row">
    <?php $b = 1; ?>
    <?php while($mb->have_fields_and_multi('blocks')): ?>
    <?php $mb->the_group_open(); ?>
    <?php $block_name = strlen($mb->get_the_value('block-name'))==0?'Block '.$s:$mb->get_the_value('block-name')?>
    <div id="<?php print $block_name; ?>" class="msdlab_block">
        <div class="block_data">
        <div class="block_params">
        <a href="#" class="dodelete button">X</a>
        <div class="cell">
            <?php $mb->the_field('title'); ?>
            <?php $field_value = $mb->get_the_value(); ?>
            <div class="input_container">
                <select name="<?php $mb->the_name(); ?>" class="banner">
                    <option value="">Select Block Banner</option>
                    <?php 
                    $banners = array('Viewpoint','Quarterly Insight','Infographic','EBook','Video','In the News','Press Release','Event','Team Member');
                    foreach($banners AS $banner){
                        $selected = ($field_value == $banner)?' selected="selected"':'';
                        print '<option value="'.$banner.'"'.$selected.'>'.$banner.'</option>
                        ';
                    }?>
                </select>
            </div>
        </div>
        <div class="cell">
            <?php $mb->the_field('post_type'); ?>
            <?php $field_value = $mb->get_the_value(); ?>
            <div class="input_container">
                <select name="<?php $mb->the_name(); ?>" class="post_type">
                    <option value="">Select Post Type</option>
                    <?php foreach($post_types AS $k=>$v){
                        $selected = ($field_value == $k)?' selected="selected"':'';
                        print '<option value="'.$k.'"'.$selected.'>'.$v.'</option>
                        ';
                    }?>
                </select>
            </div>
        </div>
        <div class="cell">
            <?php $mb->the_field('content'); ?>
            <?php $field_value = $mb->get_the_value(); ?>
            <?php
foreach($contents as $k=>$v){
    print '<div id="select_'.$k.'" style="display: none;visibility: hidden">';
    print '<option value="">Select Content</option>';      
    foreach($v as $post){
        $selected = ($field_value == $post->ID)?' selected="selected"':'';
        print '<option value="'.$post->ID.'"'.$selected.'>'.$post->post_title.'</option>
        ';
    }
    print '</div>';
}
?> 
            <div class="input_container">
                <select name="<?php $mb->the_name(); ?>" class="content">
                </select>
            </div>
        </div>
        </div>
        </div>
    </div>
    <?php $b++; ?>
    <?php $mb->the_group_close(); ?>
    <?php endwhile; ?>
    </div>
    <p style="margin-bottom:15px; padding-top:5px;"><a href="#" class="docopy-blocks button">Add Block</a>
</div>
<script>
jQuery(document).ready(function($) {
    $(".wpa_group.wpa_group-blocks").addClass("col-sm-4").addClass("col-xs-12");  
    $("select.content").html(function(){
        var type = $(this).parents(".msdlab_block").find("select.post_type").val();
        if(type!=''){
            return $(this).parents(".msdlab_block").find("#select_"+type).html();
        }
    });
    $("select.post_type").change(function(){   
        var type=$(this).val();
        var target = $(this).parents(".msdlab_block").find("select.content");
        var html = $(this).parents(".msdlab_block").find("#select_"+type).html();
        target.html(html);
    });
    $( "#wpa_loop-blocks" )
      .sortable({
        change: function(){
            $("#warning").show();
        }
      });
});
</script>