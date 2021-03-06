<?php
add_filter('img_caption_shortcode_width','msdlab_remove_inline_width');
function msdlab_remove_inline_width(){
    return false;
}
add_shortcode('button','msdlab_button_function');
function msdlab_button_function($atts, $content = null){	
	extract( shortcode_atts( array(
      'url' => null,
	  'target' => '_self'
      ), $atts ) );
	$ret = '<div class="button-wrapper">
<a class="button" href="'.$url.'" target="'.$target.'">'.remove_wpautop($content).'</a>
</div>';
	return $ret;
}
add_shortcode('hero','msdlab_landing_page_hero');
function msdlab_landing_page_hero($atts, $content = null){
	$ret = '<div class="hero">'.remove_wpautop($content).'</div>';
	return $ret;
}
add_shortcode('callout','msdlab_landing_page_callout');
function msdlab_landing_page_callout($atts, $content = null){
	$ret = '<div class="callout">'.remove_wpautop($content).'</div>';
	return $ret;
}
function column_shortcode($atts, $content = null){
	extract( shortcode_atts( array(
	'cols' => '3',
	'position' => '',
	), $atts ) );
	switch($cols){
		case 5:
			$classes[] = 'one-fifth';
			break;
		case 4:
			$classes[] = 'one-fouth';
			break;
		case 3:
			$classes[] = 'one-third';
			break;
		case 2:
			$classes[] = 'one-half';
			break;
	}
	switch($position){
		case 'first':
		case '1':
			$classes[] = 'first';
		case 'last':
			$classes[] = 'last';
	}
	return '<div class="'.implode(' ',$classes).'">'.$content.'</div>';
}
add_shortcode('mailto','msdlab_mailto_function');
function msdlab_mailto_function($atts, $content){
    extract( shortcode_atts( array(
    'email' => '',
    'querystring' => '',
    ), $atts ) );
    $content = trim($content);
    if($email == '' && preg_match('|[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}|i', $content, $matches)){
        $email = $matches[0];
    }
    $email = antispambot($email);
    $content = antispambot($content);
    $querystring = $querystring!=''?'?'.$querystring:'';
    return '<a href="mailto:'.$email.$querystring.'">'.$content.'</a>';
}
add_shortcode('columns','column_shortcode');

add_shortcode('sitemap','msdlab_sitemap');

add_filter('jpb_visual_shortcodes','msdlab_recent_viewpoints_by_category_image');
function msdlab_recent_viewpoints_by_category_image($params){
    $params[] = array(
        'shortcode' => 'viewpoints',
        'image' => get_stylesheet_directory_uri().'/lib/img/viewpoints_placeholder.png',
        'command' => ''
    );
    return $params;
}
add_shortcode('viewpoints','msdlab_recent_viewpoints_by_category');
function msdlab_recent_viewpoints_by_category($atts){
    extract( shortcode_atts( array(
    'category' => FALSE,
    'cat' => FALSE,
    'title' => '',
    ), $atts ) );
    if($category || $cat){
        $category = $cat?$cat:$category;
    }
    if($title == ''){
        $category_info = get_category_by_slug($category);
        $title = 'Truepoint Viewpoints on '.$category_info->name;
    }
    $args = array(
            'post_type' => 'post',
            'posts_per_page' => 2
        ); 
    if($category){
        $args['category_name'] = $category;
    }
    $viewpoints = new WP_Query($args);
    $ret = '';
    if($viewpoints->have_posts()){
        while($viewpoints->have_posts()){
            $viewpoints->the_post();
            $ret .= '<section class="widget">
            '.msdlab_author_image(TRUE).'
            <header class="entry-header">
                <h2 class="entry-title" itemprop="headline">
                    <a href="'.get_permalink().'" title="'.get_the_title().'" rel="bookmark">'.get_the_title().'</a>
                </h2> 
                <p class="entry-meta">By '.msdlab_post_author_bio().'
                    <br>
                    <time class="entry-time" itemprop="datePublished" datetime="'.get_the_time('c').'">'.get_the_date().'</time>
               </p>
           </header>
           <div class="entry-content" itemprop="text">
                <p class="entry-permalink">
                    <a href="'.get_permalink().'" title="Permalink" rel="bookmark">Read More&nbsp;&gt;</a>
                </p>
           </div>
           <footer class="entry-footer clearfix"></footer>
        </section>';
        }
        $ret = '<div class="recent-viewpoints"><h3 class="col-md-12">'.$title.'</h3><div class="row">'.$ret.'</div></div>';
    } 
    return $ret;
}
add_shortcode('script','msdlab_javascript_cheater');
function msdlab_javascript_cheater($attr,$content){
    $ret = '<script';
    foreach($attr AS $k=>$v){
        $ret .= ' '.$k.'="'.$v.'"';
    }
    $ret .= '>';
    $ret .= apply_filters('the_content',$content);
    $ret .= '</script>';
    return $ret;
}

add_shortcode('tp-grid','msdlab_tpgrid_shortcode_handler');
add_shortcode('tp-square','msdlab_tpsquare_shortcode_handler');
add_shortcode('tp-col','msdlab_tpcolumn_shortcode_handler');
function msdlab_tpgrid_shortcode_handler($atts,$content){
    extract( shortcode_atts( array(
        'classes' => '',
        'recent' => false,
        'channel' => false,
        'link' => false,
        'style' => 'display',
        'cat' => false
    ), $atts ) );
    if(!$recent){
        $ret = '
        <div class="tp-grid" class="'.$classes.'">
            '.do_shortcode(remove_wpautop($content)).'
        </div>';
    } else {
        switch($channel){
            case 'quarterly':
                $icon = 'quadrants';
                $title = 'Quarterly Insights';
                $more = 'Quarterly Insights';
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => $recent,
                    'cat' => 42
                ); 
                $link = !$link?'/category/quarterly-insight/':$link;
            break;
            case 'events':
                $icon = 'calendar';
                $title = 'Events';
                $more = 'Events';
                $args = array(
                    'post_type' => 'event',
                    'posts_per_page' => $recent,
                    'meta_query' => array(
                        array(
                            'key' => '_date_event_end_datestamp',
                            'value' => time()-86400,
                            'compare' => '>'
                        ),
                        array(
                            'key' => '_date_event_end_datestamp',
                            'value' => mktime(0, 0, 0, date("m")+12, date("d"), date("Y")),
                            'compare' => '<'
                        )
                    ),
                    'meta_key' => '_date_event_end_datestamp',
                    'orderby'=>'meta_value_num',
                    'order'=>'ASC',
                    ); 
                    
                $args2 = array(
                    'post_type' => 'event',
                    'meta_query' => array(
                        array(
                            'key' => '_date_event_end_datestamp',
                            'value' => time()-86400,
                            'compare' => '<='
                        ),
                    ),
                    'meta_key' => '_date_event_end_datestamp',
                    'orderby'=>'meta_value_num',
                    'order'=>'DESC',
                    ); 
                $link = !$link?'/resources/events/':$link;
            break;
            case 'press':
                $icon = 'topicbubble';
                $title = 'Press Releases';
                $more = 'Press Releases';
                $args = array(
                    'post_type' => 'press',
                    'posts_per_page' => $recent,
                ); 
                $link = !$link?'/resources/press-release/':$link;
            break;
            case 'news':
                $icon = 'arrow';
                $title = 'In The News';
                $more = 'News';
                $args = array(
                    'post_type' => 'news',
                    'posts_per_page' => $recent,
                ); 
                $link = !$link?'/resources/news/':$link;
            break;
            case 'viewpoints':
            default:
                $icon = 'logo';
                $title = 'Viewpoints';
                $more = 'Viewpoints';
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => $recent,
                );
                if($cat){
                    $args['cat'] = $cat;
                }
                $link = !$link?'/resources/truepoint-viewpoint/':$link;
            break;
        }
        $ret = '<div class="grid-hdr row">
            <div class="col-xs-12">
                <h3><i class="icon icon-'.$icon.'"></i> '.$title.'</h3>
            </div>';
            $ret .= '
        </div>';
        $loop = new WP_Query($args);
        
        if($loop->have_posts()){
        $ctr = 0;
        $ret .= '
        <div class="tp-grid" class="'.$classes.'">';
            while($loop->have_posts()){
                $ctr++;
                $loop->the_post();
                $ret .= '
                <div class="tp-square" id="'.$post->post_name.'">
                    <div class="off">
                        <div class="icon-holder">
                            <h3><a href="'.get_the_permalink().'">'.get_the_title().'</a></h3>
                        </div>';
                        if(wp_is_mobile() || $style == 'display'){
                            $ret .= '
                            <div class="content-holder excerpt">'.msdlab_get_excerpt($post->ID,30,'').'</div>
                            <div class="link-holder excerpt"><a href="'.get_the_permalink().'" class="morelink">more ></a></div>';
                        }
                        $ret .= '
                        <div class="title-holder">';
                        if($args['post_type']=='post'){
                            $ret .= '
                            <div class="author">'.msdlab_post_author_bio().'</div>';
                            }
                        $ret .= '
                            <div class="date">'.get_the_date().'</div>
                        </div>';
                        if(!wp_is_mobile() && $style != 'display'){
                            $ret .= '
                        <div class="on">
                            <div class="icon-holder">
                                <i class="icon icon-'.$icon.'"></i>
                            </div>
                            <div class="content-holder">'.msdlab_get_excerpt($post->ID,30,'').'</div>
                            <div class="link-holder"><a href="'.get_the_permalink().'" class="morelink">more ></a></div>
                        </div>';
                        }
                        $ret .= '
                    </div>
                </div>';
            }

        if($ctr<3 && $channel == 'events'){
            //do second query to get recent but past events.
            $args2['posts_per_page'] = $recent - $ctr;
            $loop2 = new WP_Query($args2);
            if($loop2->have_posts()){
                while($loop2->have_posts()){
                    $loop2->the_post();
                    $ret .= '
                    <div class="tp-square" id="'.$post->post_name.'">
                        <div class="off">
                            <div class="icon-holder">
                                <h3>Past Event: '.get_the_title().'</h3>
                            </div>
                            <div class="title-holder">
                                <div class="date">'.get_the_date().'</div>
                            </div>
                            <div class="on">
                                <div class="icon-holder">
                                    <i class="icon icon-'.$icon.'"></i>
                                </div>
                                <div class="content-holder">'.msdlab_get_excerpt($post->ID,30,'').'</div>
                                <div class="link-holder"><a href="'.get_the_permalink().'" class="morelink">more ></a></div>
                            </div>
                        </div>
                    </div>';
                }
                }
            }

        $ret .= '<div class="grid-ftr">';
            if($link){
            $ret .= '<div class="col-xs-12">
                <a href="'.$link.'" class="more">More '.$more.'</a>
            </div>';
            }
            $ret .= '
        </div>';
        $ret .= '
        </div>';
        wp_reset_postdata();
        }
        $ret = '<div class="tp-grid-channel">'.$ret.'</div>';
    }
    return $ret;
}
function msdlab_tpsquare_shortcode_handler($atts,$content){
    extract( shortcode_atts( array(
    'id' => FALSE,
    'url' => FALSE,
    'title' => '',
    'icon' => '',
    ), $atts ) );
    if(!$id){$id = sanitize_title_with_dashes($title);}
    $ret = '
    <div class="tp-square" id="'.$id.'">
        <div class="off">
            <div class="icon-holder">
                <i class="icon icon-'.$icon.'"></i>
            </div>';
            if(wp_is_mobile()){
                $ret .= '<div class="content-holder">'.do_shortcode(remove_wpautop($content)).'</div>';
                if($url){
                $ret .= '<div class="link-holder"><a href="'.$url.'" class="morelink">more ></a></div>';
                }
            }
            $ret .= '
            <div class="title-holder">
                <h3>'.$title.'</h3>
            </div>';
            if(!wp_is_mobile()){
            $ret .= '<div class="on">
                <div class="icon-holder">
                    <i class="icon icon-'.$icon.'"></i>
                </div>
                <div class="title-holder">
                    <h3>'.$title.'</h3>
                </div>
                <div class="content-holder">'.do_shortcode(remove_wpautop($content)).'</div>';
                if($url){
                $ret .= '<div class="link-holder"><a href="'.$url.'" class="morelink">more ></a></div>';
                }
                $ret .= '
            </div>';
            }
            $ret .= '
        </div>
    </div>';
    return $ret;
}

function msdlab_tpcolumn_shortcode_handler($atts,$content){
    extract( shortcode_atts( array(
        'id' => FALSE,
        'url' => FALSE,
        'title' => '',
        'subtitle' => '',
        'icon' => '',
        'color' => 'blue'
    ), $atts ) );
    if(!$id){$id = sanitize_title_with_dashes($title);}
    $ret = '
    <div class="tp-column" id="'.$id.'">
        <div class="top border-'.$color.'">
            <div class="inner">
                <div class="icon-holder">
                    <i class="icon icon-'.$icon.'"></i>
                </div>';
        $ret .= '
                <div class="title-holder">
                    <h3>'.$title.'</h3>
                    <h4>'.$subtitle.'</h4>
                </div>
            </div>
        </div>
        <div class="bottom border-'.$color.'">
            <div class="inner">'.do_shortcode(remove_wpautop($content)).'</div>
        </div>
    </div>';
    return $ret;
}

add_shortcode('icon','msdlab_icon_shortcodes');
function msdlab_icon_shortcodes($atts){
    $classes[] = 'msd-icon icon';
    foreach($atts AS $att){
        switch($att){
            case "circle":
            case "square":
            case "block":
                $classes[] = $att;
                break;
            default:
                $classes[] = 'icon-'.$att;
                break;
        }
    }
    return '<i class="'.implode(" ",$classes).'"></i>';
}
add_shortcode('homepage_news_widget','msdlab_homepage_news_widget_handler');
function msdlab_homepage_news_widget_handler($atts){
    extract( shortcode_atts( array(
    'classes' => '',
    'recent' => 2,
    ), $atts ) );
    $args = array(
        'post_type' => 'news',
        'posts_per_page' => $recent,
    ); 
    $loop = new WP_Query($args);
        
    if($loop->have_posts()){
    $ret .= '
    <div class="news-grid '.$classes.'">';
        while($loop->have_posts()){
            $loop->the_post();
            $ret .= '
            <div class="news-square" id="'.$post->post_name.'">
                <div class="date"><span class="number">'.get_the_date('j').'</span><span class="month">'.get_the_date('M').'</span></div>
                <div class="info">
                    <h3>'.get_the_title().'</h3>
                    <div class="content-holder">'.msdlab_get_excerpt($post->ID,30,'').'</div>
                    <div class="link-holder"><a href="'.get_the_permalink().'" class="morelink">more ></a></div>
                </div>
            </div>';
        }
    $ret .= '
    </div>';
    }
    return $ret;
}
