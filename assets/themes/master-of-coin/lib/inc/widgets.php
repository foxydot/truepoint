<?php
/**
 * Connected Class
 */
if(class_exists('MSDConnected')){
class CustomConnected extends MSDConnected {
    function widget( $args, $instance ) {
        extract($args);
        extract($instance);
        $title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );
        $text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
        echo $before_widget;
        if ( !empty( $title ) ) { print $before_title.$title.$after_title; } 
        if($id == "header-right"){
            if ( !empty( $text )){ print '<div class="connected-text">'.$text.'</div>'; }
        }
        print '<div class="wrap">';
        if(($address||$phone||$tollfree||$fax||$email||$social)&&$form_id > 0){
            print '<div class="col-md-7">';
        }
        if ( $form_id > 0 ){
            print '<div class="connected-form">';
            print do_shortcode('[gravityform id="'.$form_id.'" title="true" description="false" ajax="true"]');
            print '</div>';
            //add_action( 'wp_footer', array(&$this,'tabindex_javascript'), 60);
        }
        if(($address||$phone||$tollfree||$fax||$email||$social)&&$form_id > 0){
            print '</div>';
        }
        if(($address||$phone||$tollfree||$fax||$email||$social)&&$form_id > 0){
            print '<div class="col-md-5 align-right">';
        }
        if ( $social ){
            $social = do_shortcode('[msd-social]');
            if( $social ){ print '<div class="connected-social">'.$social.'</div>'; }
        }   
        if ( $address ){
            $bizname = do_shortcode('[msd-bizname]'); 
            if ( $bizname ){
                print '<div class="connected-bizname">'.$bizname.'</div>';
            }
            $address = do_shortcode('[msd-address]'); 
            if ( $address ){
                print '<div class="connected-address">'.$address.'</div>';
            }
        }
        if ( $phone ){
            $phone = '';
            if((get_option('msdsocial_tracking_phone')!='')){
                if(wp_is_mobile()){
                  $phone .= '<a href="tel:+1'.get_option('msdsocial_tracking_phone').'">'.get_option('msdsocial_tracking_phone').'</a> ';
                } else {
                  $phone .= '<span>'.get_option('msdsocial_tracking_phone').'</span> ';
                }
              $phone .= '<span itemprop="telephone" style="display: none;">'.get_option('msdsocial_phone').'</span> ';
            } else {
                if(wp_is_mobile()){
                  $phone .= (get_option('msdsocial_phone')!='')?'<a href="tel:+1'.get_option('msdsocial_phone').'" itemprop="telephone">'.get_option('msdsocial_phone').'</a> ':'';
                } else {
                  $phone .= (get_option('msdsocial_phone')!='')?'<span itemprop="telephone">'.get_option('msdsocial_phone').'</span> ':'';
                }
            }
            if ( $phone ){ print '<div class="connected-phone">'.$phone.'</div>'; }
        }
        if ( $tollfree ){
            $tollfree = '';
            if((get_option('msdsocial_tracking_tollfree')!='')){
                if(wp_is_mobile()){
                  $tollfree .= '<a href="tel:+1'.get_option('msdsocial_tracking_tollfree').'">'.get_option('msdsocial_tracking_tollfree').'</a> ';
                } else {
                  $tollfree .= '<span>'.get_option('msdsocial_tracking_tollfree').'</span> ';
                }
              $tollfree .= '<span itemprop="telephone" style="display: none;">'.get_option('msdsocial_tollfree').'</span> ';
            } else {
                if(wp_is_mobile()){
                  $tollfree .= (get_option('msdsocial_tollfree')!='')?'<a href="tel:+1'.get_option('msdsocial_tollfree').'" itemprop="telephone">'.get_option('msdsocial_tollfree').'</a> ':'';
                } else {
                  $tollfree .= (get_option('msdsocial_tollfree')!='')?'<span itemprop="telephone">'.get_option('msdsocial_tollfree').'</span> ':'';
                }
            }
            if ( $tollfree ){
                if($phone){
                    print ' or ';
                }
                 print '<div class="connected-tollfree">'.$tollfree.'</div>'; 
            }
        }
        if ( $fax ){
            $fax = (get_option('msdsocial_fax')!='')?'Fax: <span itemprop="faxNumber">'.get_option('msdsocial_fax').'</span> ':'';
            if ( $fax ){ print '<div class="connected-fax">'.$fax.'</div>'; }
        }
        if ( $email ){
            $email = (get_option('msdsocial_email')!='')?'Email: <span itemprop="email"><a href="mailto:'.antispambot(get_option('msdsocial_email')).'">'.antispambot(get_option('msdsocial_email')).'</a></span> ':'';
            if ( $email ){ print '<div class="connected-email">'.$email.'</div>'; }
        }
        
        if(($address||$phone||$tollfree||$fax||$email||$social)&&$form_id > 0){
            print '</div>';
        }
        if($id != "header-right"){
            if ( !empty( $text )){ print '<div class="connected-text">'.$text.'</div>'; }
        }
        print '</div>';
        
        echo $after_widget;
    }
}

add_action('widgets_init', create_function('', 'return register_widget("CustomConnected");'));
}


if(class_exists('RecentPostsPlus')){
    class CustomRPP extends RecentPostsPlus {
        
    private $default_config = array(
        'title' => '',
        'count' => 5,
        'include_post_thumbnail' => 'false',
        'include_post_excerpt' => 'false',
        'truncate_post_title' => '',
        'truncate_post_title_type' => 'char',
        'truncate_post_excerpt' => '',
        'truncate_post_excerpt_type' => 'char',
        'truncate_elipsis' => '...',
        'post_thumbnail_width' => '50',
        'post_thumbnail_height' => '50',
        'post_date_format' => 'M j',
        'wp_query_options' => '',
        'widget_output_template' => '<li>{THUMBNAIL}<a title="{TITLE_RAW}" href="{PERMALINK}">{TITLE}</a>{EXCERPT}</li>', //default format
        'show_expert_options' => 'false'
    );
        
    function parse_output($instance) {
        $output = '';
        
        foreach($this->default_config as $key => $val) {
            $$key = (empty($instance[$key])) ? $val : $instance[$key];
        }
        
        $default_query_args = array(
            'post_type' => 'post', 
            'posts_per_page' => $count, 
            'orderby' => 'date', 
            'order' => 'DESC',
            'ignore_sticky_posts' => 1
        );
        $query_args = json_decode($wp_query_options, true);
        if($query_args == NULL) $query_args = array();
        
        $the_query = new WP_Query( array_merge($default_query_args, $query_args) );
        if( $the_query->have_posts() ) {
            
            //Deal with custom date formats, get a list of the custom tags ie {DATE[D \of j]}, {DATE[M j]}, etc...
            $date_matches = array();
            preg_match_all('/\{DATE\[(.*?)\]\}/', $widget_output_template, $date_matches);
            
            //Deal with custom meta tags, e.g. [META[key]]
            $meta_matches = array();
            preg_match_all('/\{META\[(.*?)\]\}/', $widget_output_template, $meta_matches);
            
            //check if custom ellipsis has been defined, use strpos before preg_match since it is a lot faster
            $truncate_elipsis_template = '';
            
            if(preg_match('/\{ELLIPSIS\}(.*?)\{\/ELLIPSIS\}/', $widget_output_template, $ellipsis_match) > 0) {
                $truncate_elipsis_template = $ellipsis_match[1];
            }
            
            while ( $the_query->have_posts() ) { $the_query->the_post();
                
                $ID = get_the_ID();
                
                if($include_post_thumbnail == "false") {
                    $POST_THUMBNAIL = '';
                } else {
                    $POST_THUMBNAIL = get_the_post_thumbnail($ID, array($post_thumbnail_width, $post_thumbnail_height));
                }
                
                $POST_TITLE_RAW = strip_tags(get_the_title($ID));
                if(empty($truncate_post_title))
                    $POST_TITLE = $POST_TITLE_RAW;
                else {
                    if($truncate_post_title_type == "word")
                        $POST_TITLE = $this->_truncate_words($POST_TITLE_RAW, $truncate_post_title, $truncate_elipsis);
                    else
                        $POST_TITLE = $this->_truncate_chars($POST_TITLE_RAW, $truncate_post_title, $truncate_elipsis);
                }
                
                $widget_ouput_template_params = array(
                    '{ID}' => $ID,
                    '{THUMBNAIL}' => $POST_THUMBNAIL,
                    '{TITLE_RAW}' => $POST_TITLE_RAW,
                    '{TITLE}' => $POST_TITLE,
                    '{PERMALINK}' => get_permalink($ID),
                    '{DATE}' => get_the_date($post_date_format),
                    '{AUTHOR}' => $this->get_author_coauthor_info('name'), //override with coauthor information
                    '{AUTHOR_LINK}' => $this->get_author_coauthor_info('link'),//get_the_author_link(), //override with coauthor information
                    '{AUTHOR_AVATAR}' => ((strpos($widget_output_template, '{AUTHOR_AVATAR}') !== FALSE) ? get_avatar(get_the_author_meta('user_email')) : ""), //override with coauthor information
                    '{COMMENT_COUNT}' => ((strpos($widget_output_template, '{COMMENT_COUNT}') !== FALSE) ? get_comments_number() : "") //Only load comment count if necessary since it might cause more db queries
                );
                
                //Deal with custom date formats, parse the custom tags and add the date value
                foreach($date_matches[0] as $key => $date_match) {
                    if(!empty($date_matches[1][$key]))
                        $widget_ouput_template_params[$date_match] = get_the_date($date_matches[1][$key]);
                    else
                        $widget_ouput_template_params[$date_match] = '';
                }
                
                //Deal with meta fields
                foreach($meta_matches[0] as $key => $meta_match) {
                    if(!empty($meta_matches[1][$key]))
                        $widget_ouput_template_params[$meta_match] = get_post_meta($ID, $meta_matches[1][$key], true);
                    else
                        $widget_ouput_template_params[$meta_match] = '';
                }
                
                //Deal with {ELLIPSIS}{/ELLIPSIS} tags, we parse it with the template tags, so you can use these tags in the excerpt
                $truncate_elipsis_excerpt = $truncate_elipsis;
                if(!empty($truncate_elipsis_template)) {
                    $truncate_elipsis_excerpt = str_replace(array_keys($widget_ouput_template_params), array_values($widget_ouput_template_params), $truncate_elipsis_template);
                    $widget_output_template = preg_replace('/\{ELLIPSIS\}(.*?)\{\/ELLIPSIS\}/', '', $widget_output_template); //remove {ELLIPSIS}{/ELLIPSIS} tags from widget_output_template
                }
                
                //Deal with post excerpt
                if($include_post_excerpt == "false") {
                    $POST_EXCERPT_RAW = $POST_EXCERPT = '';
                } else {
                    $POST_EXCERPT_RAW = $this->_custom_trim_excerpt();
                    if(empty($truncate_post_excerpt))
                        $POST_EXCERPT = $POST_EXCERPT_RAW;
                    else
                        $POST_EXCERPT = $this->_custom_trim_excerpt($truncate_post_excerpt, $truncate_elipsis_excerpt, $truncate_post_excerpt_type);
                }
                
                $widget_ouput_template_params['{EXCERPT_RAW}'] = $POST_EXCERPT_RAW;
                $widget_ouput_template_params['{EXCERPT}'] = $POST_EXCERPT;
                
                //Deal with embedded php code, only eval if php tags exist and current user is admin
                $widget_output_template_eval = $widget_output_template;
                
                if(preg_match("/<\?(.*?)\?>/", $widget_output_template) > 0) {
                    ob_start();
                    $eval_result = eval("?>".$widget_output_template);
                    $widget_output_template_eval = ob_get_clean();
                }
                
                $output .= str_replace(array_keys($widget_ouput_template_params), array_values($widget_ouput_template_params), $widget_output_template_eval);
                
            } //end while
        }
        
        wp_reset_postdata();
        
        return $output;
    }

function get_author_coauthor_info($info,$post_id = false){
    if(!$post_id){
        global $post;
    } else {
        $post = get_post($post_id);
    }
    $author_id = get_the_author_meta('ID');
    $coauthors = get_post_meta($post->ID,'_coauthor_team_members', TRUE);
    if($coauthors){
        $total_coauthors = count($coauthors);
        $i = 0;
        foreach($coauthors AS $coauthor){
            $i++;
            $coauthor_data = get_post_meta($coauthor);
            $args = array(
            'post_type' => 'team_member',
            'meta_key'  => '_team_member__team_user_id',
            'meta_value'=> $coauthor_data['_team_member__team_user_id'][0]
        );
        $coauthor_bio[$i] = array_pop(get_posts($args));
        }
    }
    switch($info){
        case 'avatar':
            //get author avatars
            break;
        case 'avatarlink':
            //get author link(s) wrapped around avatars
            $author_link = get_the_author_link();
            break;
        case 'link': 
            //get the author link(s) wrapped around names
            $author = get_the_author();
            $author_link = get_the_author_link();
            break;
        case 'name':
        default:
            //get the author and coauthor name
            $ret = get_the_author();
            $i=0;
            if($total_coauthors > 0){
                foreach($coauthor_bio AS $ca){
                    $i++;
                    if($i == $total_coauthors){
                        $ret .= ' and ';
                    } else {
                        $ret .= ', ';
                    }
                    $ret .= esc_html( $ca->post_title );
                }
            }
            break;
        }
        return $ret;
    }
}

add_action('widgets_init', create_function('', 'return register_widget("CustomRPP");'));
}