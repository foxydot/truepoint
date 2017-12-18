<?php

/**
 * Theme Options
 *
 * @package      MasterOfCoin
 * @author       MSDLab
 * @copyright    Copyright (c) 2015, Mad Science Dept.
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */


/**
 * Register Defaults
 * @author MSD Lab
 *
 * @param array $defaults
 * @return array modified defaults
 *
 */

add_action('admin_enqueue_scripts','msdlab_moc_options_scripts');
function msdlab_moc_options_scripts(){
    $screen = get_current_screen();
    if($screen->id == 'toplevel_page_genesis'){ //only do if on the options page
        // Include in admin_enqueue_scripts action hook
        wp_enqueue_media();
        wp_enqueue_script( 'custom-header' );
        wp_enqueue_style('bootstrap-style','//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css');
    }
}
function msdlab_moc_defaults( $defaults ) {

    $defaults['disclaimer_text'] = '';
    return $defaults;
}
add_filter( 'genesis_theme_settings_defaults', 'msdlab_moc_defaults' );


/**
 * Sanitization
 * @author MSD Lab
 *
 */

function msdlab_register_moc_sanitization_filters() {
    genesis_add_option_filter( 'safe_html', GENESIS_SETTINGS_FIELD,
        array(
            'disclaimer_text',
        ) );
}
add_action( 'genesis_settings_sanitizer_init', 'msdlab_register_moc_sanitization_filters' );


/**
 * Register Metabox
 * @author MSD Lab
 *
 * @param string $_genesis_theme_settings_pagehook
 */

function msdlab_register_moc_settings_box( $_genesis_theme_settings_pagehook ) {
    add_meta_box('msdlab-moc-settings', 'Master Of Coin Settings', 'msdlab_moc_settings_box', $_genesis_theme_settings_pagehook, 'main', 'high');
}
add_action('genesis_theme_settings_metaboxes', 'msdlab_register_moc_settings_box');

/**
 * Create Metabox
 * @author MSD Lab
 *
 */

function msdlab_moc_settings_box() {
    $disclaimer_text = esc_attr( genesis_get_option('disclaimer_text') );
    ?>
    <div class="row">
        <label class="col-md-2">Disclaimer Text</label>
        <div class="col-md-10">
            <textarea name="<?php echo GENESIS_SETTINGS_FIELD; ?>[disclaimer_text]" class="widefat" rows="5"><?php print $disclaimer_text; ?></textarea>
        </div>
    </div>


    <?php
}
