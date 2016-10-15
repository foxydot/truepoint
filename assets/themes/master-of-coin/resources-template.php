<?php
/*
Template Name: Reources Page
*/
add_action('genesis_entry_content','msdlab_resource_blocks');
function msdlab_resource_blocks(){
    global $resources;
    while($resources->have_fields('blocks')){
        $title = $resources->get_the_value('title');
        $post_type = $resources->get_the_value('post_type');
        $post_id = $resources->get_the_value('content');
        $post = get_post($post_id);
        switch($post_type){
            case 'post':
            break;
            case 'page':
                if($title == "Infographic" || $title == "EBoook"){
                    $content = get_infographic($post_id);
                    ts_data($content);
                }
            break;
            case 'msd_video':
            break;
            case 'news':
            break;
            case 'press':
            break;
            case 'event':
            break;
            case 'team_member':
            break;
        }
        print '<div class="block col-sm-4">
            <div class="block-content">'.$content.'</div>
            <div class="block-banner">
                <div class="banner">'.$title.'</div>
                <div class="title">'.$post->post_title.'</div>
            </div>
        </div>';
    }
}

function get_infographic($post_id){
    return get_attached_media( 'image', $post_id );
}
genesis();
