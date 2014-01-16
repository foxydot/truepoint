<?php
/*
Plugin Name: MSD WPSEO-qTranslate Patch
Version: 0.1
Description: Patch to make Yoast SEO play nice with qTranslate without having to constantly update Yoast.
Author: Mad Science Dept
*/
// Enable qTranslate for WordPress SEO
function qtranslate_filter($text){
	return __($text);
}
function add_qtranslate_filter(){
	add_filter('wpseo_title', 'qtranslate_filter', 10, 1);
	add_filter('wpseo_metadesc', 'qtranslate_filter', 10, 1);
	add_filter('wpseo_metakey', 'qtranslate_filter', 10, 1);
}
add_action('init','add_qtranslate_filter',99);