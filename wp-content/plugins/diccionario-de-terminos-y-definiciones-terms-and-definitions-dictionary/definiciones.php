<?php
/* 
Plugin Name: Diccionario de Términos y Definiciones
Plugin URI: http://www.codigonexo.com/
Description: Crea un diccionario de términos y definiciones interactivo. Also in English: It creates an interactive diccionary of terms and definitions.
Version: 1.5.3
Author: Codigonexo
Author URI: http://www.codigonexo.com/
License: GPLv2 or Later

    Copyright (C) 2012, Codigonexo

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

    ---
    
    (Esta traducción es meramente informativa y carece de validez legal:)
    
    Este programa es software libre. Puede redistribuirlo y/o modificarlo bajo 
    los términos de la Licencia Pública General de GNU según es publicada por la 
    Fundación para el Software Libre, bien de la versión 2 de dicha Licencia o 
    bien (según su elección) de cualquier versión posterior.

    Este programa se distribuye con la esperanza de que sea útil, pero SIN NINGUNA 
    GARANTÍA, incluso sin la garantía MERCANTIL implícita o sin garantizar la 
    CONVENIENCIA PARA UN PROPÓSITO PARTICULAR. Véase la Licencia Pública General de 
    GNU para más detalles.

    Debería haber recibido una copia de la Licencia Pública General junto con este 
    programa. Si no ha sido así, visite <http://www.gnu.org/licenses/>.

*/

/**
 * Comprueba la versión de WordPress / Check WordPress version
 */
global $wp_version;
$wp35 = false;
if(version_compare($wp_version,'3.5','>=')){
    $wp35 = true;
}
    
/**
 * Crea el tipo personalizado Definiciones / Creates the custom type Definiciones
 */
add_action('init','def_create_post_type');
function def_create_post_type(){
    $dpt = 'definiciones';
    
    register_post_type(
        'definiciones',
        array(
            'labels'=>array(
                'name'=>__('Definitions',$dpt),
                'singular_name'=>__('Definition',$dpt),
                'add_new'=>__('Add New',$dpt),
                'add_new_item'=>__('Add New Definition',$dpt),
                'edit_item'=>__('Edit Definition',$dpt),
                'new_item'=>__('New Definition',$dpt),
                'view_item'=>__('View Definition',$dpt),
                'search_items'=>__('Search Definition',$dpt),
                'not_found'=>__('No definitions found',$dpt),
                'not_found_in_trash'=>__('No definitions found in trash',$dpt),
                //'parent_item_colon'=>"",
                //'menu_name'=>__('Definitions',$dpt)
            ),
        'public'=>true,
        'has_archive'=>true,
        'menu_position'=>20,        // Después de "Páginas"
        //'menu_icon'=>plugins_url('/img/icons-16.png',__FILE__),
        'hierarchical'=>true,
        'supports'=>array(
                'title',
                'editor',
                'author',
                'revisions',
                'page-attributes'
            ),
        'taxonomies'=>array(
                'def_family'
            ),
        'rewrite'=>array(
                'slug'=>__('definiciones')
            )
        )  
    );
    
    // Registro la nueva taxonomia / Registering the new taxonomy
    register_taxonomy('def_family',$dpt,array(
            "labels"=>array(
                "name"=>__('Families',$dpt),
                "singular_name"=>__('Family',$dpt),
                "search_items"=>__('Search Families',$dpt),
                "popular_items"=>__('Popular Families',$dpt),
                "all_items"=>__('All Families',$dpt),
                "parent_item"=>__('Parent Family',$dpt),
                "parent_item_colon"=>__('Parent Family:',$dpt),
                "edit_item"=>__('Edit Family',$dpt),
                "update_item"=>__('Update Family',$dpt),
                "add_new_item"=>__('Add New Family',$dpt),
                "new_item_name"=>__('New Family Name',$dpt),
                "seperate_items_with_commas"=>__('Separate Families with commas',$dpt),
                "add_or_remove_items"=>__('Add or remove Families',$dpt),
                "choose_from_most_used"=>__('Choose from the most used Families',$dpt),
                //"menu_name"=>__('Families',$dpt)
            ),
            "public"=>true,
            "hierarchical"=>true,
            "rewrite"=>array(
                "slug"=>__('family')
            )
        )
    );
}

/**
 * Añade las opciones del plugin / Adds the plugin options to WordPress
 */
function def_create_options(){
    /* Tipo de Contenido / Content Type */
    add_option('def_reconocer','post_title');               // Reconocimiento del término / Term Recognition
    add_option('def_tipo','jquery');                        // Tipo de efecto / Effect Type
    add_option('def_autodetect','no');
    
    /* Estilo y CSS / Style & CSS */
    add_option('def_tooltip_width','300px');                  // Ancho del tooltip / Tooltip Width
    add_option('def_tooltip_height','auto');                // Alto del tooltip / Tooltip Height
    add_option('def_term_text_color','#000000');            // Color de texto del término / Term text color
    add_option('def_term_text_underline','dashed');         // Tipo de Subrayado del término / Term text underlined style
    add_option('def_tooltip_bg_color','#f0f0f0');           // Color de fondo del tooltip / Tooltip background color
    add_option('def_tooltip_text_color','#000000');         // Color del texto del tooltip / Tooltip background color
    add_option('def_tooltip_border','solid');               // Tipo de borde del tooltip / Tooltip border type
    add_option('def_tooltip_border_color','#e0e0e0');       // Color del borde del tooltip / Tooltip border color
    add_option('def_tooltip_border_weight','2px');          // Ancho de borde del tooltip / Tooltip border weight
    add_option('def_tooltip_border_radius','15px');         // Radio de borde del tooltip / Tooltip Border Radius
    add_option('def_padding','10px');                       // Espacio entre borde y texto (padding) / Space between border and text (padding)
    add_option('def_custom_css','');                        // CSS propio / Custom CSS
    
    /* Efectos / Effects */
    add_option('def_trigger','hover');                      // Disparador del efecto / Effect Trigger
    add_option('def_effect_type','slide');                  // Tipo de efecto / Effect Type
    add_option('def_opacity','1');
    add_option('def_slide_direction','right');              // Dirección del efecto Slide / Slide Effect Direction
    add_option('def_tooltip_position','bottom right');      // Posición del Tooltip / Tooltip Position    
}

/**
 * Obtiene un array con los nombres de las opciones / Gets an array with options names
 */
function def_options_names(){
    $opts = array(
        "def_reconocer",
        "def_tipo",
        "def_autodetect",
        
        "def_tooltip_width",
        "def_tooltip_height",
        "def_term_text_color",
        "def_term_text_underline",
        "def_tooltip_bg_color",
        "def_tooltip_text_color",
        "def_tooltip_border",
        "def_tooltip_border_color",
        "def_tooltip_border_weight",
        "def_tooltip_border_radius",
        "def_padding",
        "def_custom_css",
        
        "def_trigger",
        "def_effect_type",
        "def_opacity",
        "def_slide_direction",
        "def_tooltip_position"
    );
    return $opts;  
}

/**
 * Guarda las opciones / Save the options
 */
function def_save_options(){
    $ok = true;
    //echo("<pre>");
    $opts = def_options_names();
    foreach($opts as $op){
        if($ok){
            $opcion = get_option($op);
            if($opcion != $_POST[$op]){
                //echo("update_option('op','value') => $op, $_POST[$op] (old: $opcion)<br>");
                $ok = update_option("$op","$_POST[$op]");
            }        
        } else {
            break;
        }
    }    
    //echo("</pre>");
    return $ok;   
       
}

/**
 * Borra las opciones / Delete the options
 */
function def_delete_options(){
    $opts = def_options_names(); 
    
    foreach($opts as $op){
        delete_option($op);
    }       
}

/**
 * Obtiene un array con todas las opciones / Gets an array with all the options
 */
function def_get_options(){
    $opts = def_options_names(); 
    
    $options = array();
    foreach($opts as $op){
        $options[$op] = get_option($op);
    }         
    return $options;
}

/**
 * Añade los iconos / Adds the icons
 */
add_action( 'admin_head', 'def_menu_icons' );
function def_menu_icons() {
    ?>
    <style type="text/css" media="screen" name="def-icons">
    #menu-posts-definiciones .wp-menu-image {
            background: url("<?=plugins_url('/img/icon-def.png',__FILE__)?>") no-repeat 9px 7px !important;
            overflow: hidden;
        }
    #menu-posts-definiciones:hover .wp-menu-image, #menu-posts-definiciones.wp-has-current-submenu .wp-menu-image {
            background: url("<?=plugins_url('/img/icon-def-hover.png',__FILE__)?>") 9px 7px no-repeat !important;
        }
    #icon-edit.icon32-posts-definiciones {
        background: url("<?=plugins_url('/img/icon-def-grande.png',__FILE__)?>") 8px 1px no-repeat !important;
        }
    </style>
<?php 
}

/**
 * Obtiene una lista con todas las definiciones / Obtains all definitions
 */
function get_all_definitions(){
    global $wpdb;
    
    $count = $wpdb->get_var("SELECT count(*) FROM $wpdb->posts WHERE post_type='definiciones' AND post_status='publish'");
    
    $args = array(
        "post_type"=>"definiciones",
        "post_status"=>"publish",
        "orderby"=>"title",
        "order"=>"ASC",
        "numberposts"=>-1   // In some rare cases, this is not valid and only gets 5 posts. The rest of this function fixes the problem. Thanks to Javier Valenzuela for discover this!
    );
    
    if(sizeof(get_posts($args)) != $count){
        $theposts = $wpdb->get_results("SELECT ID FROM $wpdb->posts WHERE post_type='definiciones' AND post_status='publish'",ARRAY_A);
        $defs = array();
        foreach($theposts as $thepost){
            $def = get_post($thepost["ID"]);
            $defs[] = $def;
        }
    } else {
        $defs = get_posts($args);
    }
    
    return $defs;
}

/**
 * Añade un enlace al menú de opciones / Adds a link to the Options menu
 */
function def_option_menu(){
    //add_options_page( __('Dictionary > Options','definiciones'), __('Dictionary','definiciones'), 'manage_options', 'def_options', 'load_def_options' );
    add_submenu_page( 'edit.php?post_type=definiciones', __('Dictionary > Options','definiciones'), __('Options','definiciones'), 'manage_options', 'admin.php?page=/includes/optionsform.php', 'load_def_options' );
    add_submenu_page( null, __('About','definiciones'), __('About','definiciones'), 'manage_options', '/includes/about-en.php', 'load_def_changelog' ); 
    add_submenu_page( null, 'Acerca de', 'Acerca de', 'read', '/includes/about.php', 'load_def_changelog' );
}
add_action('admin_menu','def_option_menu');

/**
 * Carga el Historial de cambios / Loads the changelog page
 */
function load_def_changelog(){
    if(get_bloginfo('language') != 'es-ES')
        include_once(plugin_dir_path( __FILE__ ).'/includes/about-en.php');
    else
        include_once(plugin_dir_path( __FILE__ ).'/includes/about.php');
}
 
/**
 * Carga el formulario de opciones / Loads the options form
 */
function load_def_options(){
    if(isset($_POST['action']) && $_POST['action'] == 'save'){
        $ok = def_save_options();
    }
    ?>
        <div class="wrap">
            <h2><?=__('Terms and Definitions Diccionary','definiciones')?></h2>
    <?php
    if(isset($_POST['action']) && $_POST['action'] == 'save'){
        if($ok){
            ?>
                <div class="fade updated"><?=__('Options saved.','definiciones')?></div>
            <?php
        } else {
            ?>
                <div class="fade error"><?=__('There was a problem when saving the options.','definiciones')?></div>
            <?php
        }
    }
    include_once(plugin_dir_path( __FILE__ ).'/includes/optionsform.php');
    ?>
        </div>
    <?php
}

/**
 * Añade estilos al formulario de opciones
 */
function def_admin_style(){
    wp_enqueue_style('def_admin-style', plugins_url('/css/admin-style.css',__FILE__));
}
add_action('admin_head','def_admin_style');

/**
 * Activa el plugin correctamente / Activate the plugin correctle
 */
function def_activate_plugin(){
    def_create_post_type();
    def_create_options();
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'def_activate_plugin' );

/**
 * Desactiva el plugin correctamente / Deactivate the plugin correctly
 */
function def_deactivate_plugin(){
    def_delete_options();
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'def_deactivate_plugin' );

/**
 * Carga la traducción / Loads the translation
 */
function def_load_textdomain(){
    load_plugin_textdomain('definiciones',false,dirname(plugin_basename(__FILE__)).'/lang/');
}
add_action('plugins_loaded','def_load_textdomain');

/**
 * Instancia el Widget / Instance the Widget
 */
function def_create_widget(){
    include_once(plugin_dir_path( __FILE__ ).'/includes/widget.php');
    register_widget('def_Widget');
}
add_action('widgets_init','def_create_widget');

/**
 * Crea y añade el estilo a las definiciones en el front-end / Create and add CSS style to front-end definitions
 */
function def_front_style(){
    //echo("<link href='".plugins_url('/css/front-style.css',__FILE__)."' name='definiciones' rel='stylesheet' />");    // DEPRECATED
    $opts = def_get_options();
    ?>
    <style type="text/css" >
        .tooltip{
            display:none;
            z-index: 99;
            <?php
                if($opts["def_custom_css"] != ""){
                    echo($opts["def_custom_css"]);
                } else {
            ?>
            width: <?=$opts["def_tooltip_width"]?>;
            height: <?=$opts["def_tooltip_height"]?>;
            background-color: <?=$opts["def_tooltip_bg_color"]?>;
            color: <?=$opts["def_tooltip_text_color"]?>;
            border: <?=$opts["def_tooltip_border_weight"]?> <?=$opts["def_tooltip_border"]?> <?=$opts["def_tooltip_border_color"]?>;
            padding: <?=$opts["def_padding"]?>;
            border-radius: <?=$opts["def_tooltip_border_radius"]?>; 
            <?php
                }
            ?>
        }
        
        .definicion{
            border-bottom: 1px <?=$opts["def_term_text_underline"]?> <?=$opts["def_term_text_color"]?>;
            color: <?=$opts["def_term_text_color"]?>;
            font-family: inherit;
            font-style: inherit;
            font-weight: inherit;
            font-size: 100%;
        }
    </style>        
    <?php
}
add_action('wp_head','def_front_style');

/**
 * Carga jQuery y jQuery Tools en WordPress. / Loads jQuery and jQuery Tools on WordPress
 */
function def_enqueue_jquery() {
    wp_enqueue_script('jquery');
    wp_deregister_script( 'jquery-tools' );
    wp_register_script( 'jquery-tools', plugins_url('js/jquery.tools.min.js', __FILE__ ),array(),null);
    wp_enqueue_script( 'jquery-tools',false,array(),null );
}    
add_action('wp_enqueue_scripts', 'def_enqueue_jquery',10);

/**
 * Carga jQuery en el Admin CP / Loads jQuery on Admin CP
 */
add_action('admin_enqueue_scripts', 'def_enqueue_jquery',10);

/**
 * Carga el Color Picker de WordPress 3.5 / Loads WordPress 3.5 ColorPicker.
 */
if($wp35)
    add_action( 'admin_enqueue_scripts', 'def_enqueue_color_picker' );
function def_enqueue_color_picker( $hook_suffix ) {
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'jslib', plugins_url('js/jslib.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}

/**
 * Añade efectos jQuery UI tooltip al plugin. // Adds jQuery UI tooltip effects to the plugin.
 */
function def_tooltips(){
    $opts = def_get_options();
    $opacity = $opts["def_opacity"];
    $opacity = str_replace(",",".",$opacity);
    if($opts["def_tipo"] == "jquery"){
    ?>
       
       <script type="text/javascript">
           jQuery(document).ready(function(){
                jQuery('.definicion').each(function(){
                    jQuery(this).tooltip({
                        position: '<?=$opts['def_tooltip_position']?>',
                        effect: '<?=$opts['def_effect_type']?>',
                        direction: '<?=$opts['def_slide_direction']?>',
                        opacity: '<?=$opacity?>',
                        <?php
                            if($opts["def_trigger"] == 'click'){
                        ?>     
                        events: {
                            def: "click,blur",
                            tooltip: "click,click"
                        }
                        <?php
                            }
                        ?>
                    });
                });
            });
       </script>
    <?php
    }
}
add_action('wp_head', 'def_tooltips');

/**
 * Añade la shortcode "def" a WordPress / Adds the shortcode "def" to WordPress
 */
function def_shortcode($args,$content=null){
    if($content){
        $r = get_option("def_reconocer");

        switch($r){
            /* Reconoce el título de la definición */
            case "post_title":
                global $wpdb;
                $post_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE LOWER(post_title) = '".strtolower($content)."' AND post_type = 'definiciones' AND post_status = 'publish'");
                if($post_id){
                    $definition = get_post($post_id);
                    $definition = $definition->post_content;
                } else {
                    return $content;
                }
                break;
            
            /* Reconoce el slug de la definición */
            case "post_name":
                $args=array(
                  'name' => $content,
                  'post_type' => 'definiciones',
                  'post_status' => 'publish',
                  'numberposts' => 1
                );
                $definition = get_posts( $args );
                if($definition){
                    $content = $definition[0]->post_title;
                    $definition = $definition[0]->post_content;
                } else {
                    return $content;
                }
                break;
            
            /* Reconoce el ID de la definición */
            case "id":
                $definition = get_post($content);
                if($definition){
                    $content = $definition->post_title;
                    $definition = $definition->post_content;
                }
                else {
                    return $content;
                }
                break;
        }
        extract( shortcode_atts( array(
            'class'=>'',
            'id'=>"term_$content",
            'url'=>'#'
        ), $args) );
        $event = get_option("def_trigger");
        if($event == 'hover' && esc_attr($url) != "#")   // Si el evento es mousehover, nos permite establecer un enlace / If event is mousehover, we can set a link here.
            return "<a class='definicion ".esc_attr($class)."' id='".esc_attr($id)."' href='".esc_attr($url)."' target='_blank' title='".htmlspecialchars($definition)."'>".$content."</a>";
        else      // Si el evento es mouseclick, no podemos poner un enlace, pues perderiamos el tooltip / If event is mouseclick, we can't set a link here, because we would lose the tooltip.
            return "<span class='definicion ".esc_attr($class)."' id='".esc_attr($id)."' title=\"".htmlspecialchars($definition)."\">".$content."</span>";
    } else {
        return "";
    }
}
add_shortcode('def','def_shortcode',10,2);

/* New! v1.5.2 */
/**
 * Añade la shorttag "dic", que muestra todo el listado de términos, bien por orden alfabético o bien por familias, según los atributos.
 * Adds shorttag "dic", that shows all terms list, by alphabetic order or by families, as set in attributes.
 */
function dic_shortcode($args){
    extract( shortcode_atts( array(
        'order'=>'fam'
    ), $args) );
    
    $html = "";
    switch(esc_attr($order)){
        case 'fam':
            // Mostramos todas las familias anidadas, y, debajo de cada una, sus términos.
            $html .= get_fam_dictionary();
            break;
        case 'abc':
            // Obtenemos todos los términos ordenados por orden alfabético, y los mostramos debajo de cada letra (solo aparecen las letras con términos).
            $definitions = get_all_definitions();
            $lastword = "";
            foreach($definitions as $def){
                $word = strtoupper($def->post_title[0]);
                if($word != $lastword){
                    if($lastword != "")
                        $html .= "</ul>";
                    $html .= "<h2>$word</h2>";
                    $html .= "<ul>";
                    $lastword = $word;
                }
                $html .= "<li><a href='".get_permalink($def->ID)."'>".$def->post_title."</a></li>";
            }
            $html .= "</ul>";
            break;
    }
    return $html;
}
add_shortcode('dic','dic_shortcode',10,2);

function get_fam_dictionary($id=0){
    $repes = array();
    $families = get_categories( array(
        'taxonomy'=>'def_family',
        'parent'=>$id
    ) );
    foreach($families as $fam){

        if($fam->parent == 0)
            $html .= "<div class='fam_list_parent'>".$fam->name."</div>";
        else 
            $html .= "<div class='fam_list_child'>".$fam->name."</div>";
        
        // Obtenemos los términos.
        $posts = get_posts( array( 
            'numberposts'=>-1,
            'orderby'=>'post_title',
            'post_type'=>'definiciones',
            'def_family'=>$fam->slug
        ) );
        echo("<ul>");
        foreach($posts as $post){
            if(!in_array($post->post_title, $repes)){
                $html .= "<li><a href='".get_permalink($post->ID)."'>".$post->post_title."</a></li>";
                $repes[] = $post->post_title;
            }
        }
        
        // Llamamos a esta función con cada hijo.
        $children = get_categories( array( 
            'taxonomy'=>'def_family',
            'child_of'=>$fam->term_id
        ) );
        foreach($children as $child){
            if($child->parent == $fam->term_id)
                $html .= "<li><ul>".get_fam_dictionary($fam->term_id)."</ul></li>";
        }
        echo("</ul>");
    }
    return $html;
}

/**
 * Añade estilo al diccionario generado por [dic]
 * Adds style to dictionary generated by [dic]
 */
function def_dic_style(){
    wp_enqueue_style('def_dic-style', plugins_url('/css/dic-style.css',__FILE__));
}
add_action('wp_head','def_dic_style');

/* New! v1.4 */
/**
 * Si la opción "Autodetectar" está activada, ignora los [def] ya existentes y busca en the_content posibles definiciones para mostrar.
 * If "Autodetect" option is activated, ignore all [def] existants and search into the_content definitions to show.
 */

function def_auto_detect($content){
    global $post;
    $in_def = false;
    $this_def_title = "";
    if($post->post_type == "definiciones"){
        $in_def = true;
        $this_def_title = $post->post_title;
    }
    
    $contenido = $content;
    $links = def_get_links($contenido);
    $contenido = def_delete_links($contenido,$links);
    //var_dump($links);
    $contenido = str_replace("[def]", "", $contenido);
    $contenido = str_replace("[/def]", "", $contenido);
    
    $definitions = get_all_definitions();
    foreach($definitions as $def){
        $title = $def->post_title;
        if($title != $this_def_title)
            $contenido = preg_replace('#\b'.$title.'\b#iu',"[def]".$title."[/def]",$contenido);
    }
    //var_dump($contenido);
    $contenido = def_restore_links($contenido, $links);
    return $contenido;
}
if(get_option("def_autodetect") == "si")
    add_filter('the_content','def_auto_detect');
    
/**
 * Si la opción "Autodetectar si no hay otras definiciones" está marcada, buscará la etiqueta [def]. Si la encuentra, no hará nada. Si no, ejecutará la autodetección.
 * If "Autodetect when there is not other definitions" is selected, it will search for the [def] shortcode. If it founds it, it will not do anything. Else, it fires the auto detection.
 */ 
function def_auto_detect_partial($content){
    if(strpos($content, "[def]") === false)
        return def_auto_detect($content);
    else 
        return $content;
}   

if(get_option("def_autodetect") == "si_partial")
    add_filter('the_content','def_auto_detect_partial');

/**
 * Obtiene los links de un string.
 * Gets string's links.
 */
function def_get_links($string){
    $patron='/\<a (.*?)\>(.*?)\<\/a\>/is';
    preg_match_all ($patron, $string, $coincidencias1);
    $patron='/\[def (.*?)\]/is';
    preg_match_all ($patron, $string, $coincidencias2);
    $patron='/\<img (.*?)\>(.*?)\<\/img\>/is';
    preg_match_all ($patron, $string, $coincidencias3);
    $patron='/class\=(.*?)\>/is';
    preg_match_all ($patron, $string, $coincidencias4);
    $patron='/id\=(.*?)\>/is';    
    preg_match_all ($patron, $string, $coincidencias5);
    $coincidencias = array_merge($coincidencias1[0],$coincidencias2[0],$coincidencias3[0],$coincidencias4[0],$coincidencias5[0]);
    return $coincidencias;    
}

function def_delete_links($string,$links){
    $contenido = $string;
    $i = 0;
    foreach($links as $link){
        $contenido = str_replace($link, "[__DEF__LINK__".$i."__]", $contenido);
        $i++;
    }  
    return $contenido;
}

function def_restore_links($string,$links){
    $contenido = $string;
    $i=0;
    foreach($links as $link){
        $linkinit = substr($link,0,4);
        if($linkinit == "[def")
            $contenido = str_replace("[__DEF__LINK__".$i."__][def]", $link, $contenido);
        else
            $contenido = str_replace("[__DEF__LINK__".$i."__]", $link, $contenido);
        $i++;
    }      
    $patron=array('/\[__DEF__LINK__\]/is');
    preg_replace($patron,$links,$contenido);
    return $contenido;
}

?>