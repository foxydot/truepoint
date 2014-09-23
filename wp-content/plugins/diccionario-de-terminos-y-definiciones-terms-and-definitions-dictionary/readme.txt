=== Terms and Definitions Dictionary ===
Contributors: JuanJedi, codigonexo
Donate link: http://www.codigonexo.com/thanks
Tags: Dictionary, Terms, Definitions, Definiciones, Términos, Diccionario
Requires at least: 3.4.2
Tested up to: 3.5.1
Stable tag: 1.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Creates an interactive dictionary of terms and definitions with jQuery and shortcodes.

== Description ==

This plugin creates a complete Dictionary on your site. It defines a new post type, Definitions, and its own taxonomy, Families (of Terms and Definitions).

This plugin is very useful if you need to explain to your visitors technical words or something else, just moving their mouse over the word.

It is fully configurable along its options page: color, size, movement, effects, autodetection...

For adding a definition to your post, first, you must create the definition in the Definitions section. After that, go to your post, and write "[def]Term[/def]", where Term is the title of your definition (or the slug, or the ID, if you have configured the plugin that way).

It allows .mo and .po translation files. The plugin supports:

* English, Spanish.
* Italian, Brazilian Portuguese and Portuguese (Thanks to Javier Valenzuela!).

== Installation ==

1. Upload the directory to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently asked questions ==

= Where are the Definitions located? =

All the definitions that you creates with the Definitions section are located in your Database, in the wp_posts table, with the post_type = 'definiciones'.

= Does It works with pages? =

Yes, it do. It works with post, pages, and every type that use "the_content" to generate its content. This plugin acts on the_content() function.

= jQuery? Do I have to write code? =

No, absolutely. With the options form, the jQuery settings will be auto written.

= The jQuery effect does not appear! Why? =

First, check the options form. Have you selected the jQuery Effects mode? I assume yes. If this is happening, probably other plugin uses JavaScript or jQuery too and is not working. When JavaScript launches an error, the rest of JS code does not work. Try deactivate your other plugins.

= The jQuery effect STILL does not appear!! =

Ok, ok, don't panic. Use the support page and I will try to help you.

= Can I configure the effect of the plugin for every post? =

If you want to have different effects in every single post, nope, you can not. If you want different colors, size, etc, you can play with CSS.

= Has the shortcodes any additional option? =

Yes, three: [def url='http://www.yoursite.com/]Term[/def] will convert the Term also in a link; [def id='id1']Term[/def] will add to the span where the Term is located the id "id1"; and [def class='class1'] will add to the span the class 'class1'.

= Is the auto detection case sensitive? =

No, if you write 'hello' and have a definition called 'Hello', it will works.

= Do the auto detection works in slug or id modes? =

No, the auto detection works always in Title mode, no matter what did you selected in the options form. The auto detection was created to be compatible with old entries without edit them.

= I want to set auto detection for old posts, but I don't want it in new posts =

Set in the options page "Auto Detect" -> "Yes, when there is no other definitions". Then, in your new posts, set at least one definition. The autodetection will not work in that post.

== Screenshots ==

1. New Custom Type and Taxonomy for Definitions.
2. The options page.
3. An example of the tooltip.

== Changelog ==

= 1.5.3 - 15/02/2013 =

* Fixed some bugs.
* Added italian and portuguese translations (thanks to Javier Valenzuela!).

= 1.5.2 - 10/01/2013 = 

* Bug fixed: now the auto detection allows more than 5 terms.
* New feature: [dic] Short Code. It allows to add the complete dictionary to a post or a page, using [dic]. By default, it will list the terms by family ([dic] or [dic order=fam], but you can list them by title using [dic order=abc]. 
* Added /css/dic-style.css for the Families Dictionary's style.

= 1.5.1 - 24/12/2012 =

* Now the plugin uses WPs jQuery version. jQuery tools now is loaded from /js directory.

= 1.5 - 21/12/2012 =

* "About" page added.
* Now "Settings" is renamed to "Options" and is located under "Definitions" menu.
* Fixed minor bugs.
* When searching definitions by title, this is not case sensitive.
* First public version in WordPress.org repositories! :)

= 1.4.3 - 20/12/2012 =
* Removed useless code.

= 1.4.2 - 20/12/2012 =
* Widget improved with nested Families. "Depth" option deprecated.               
* Auto detection improved in single Definitions entries. Now the definition is not defined in its own definition.

=  1.4.1 - 19/12/2012 =
*Now you can set the auto detect only if there is no other definitions in the post. Else, it will only appears the definitions manually established.

= 1.4 - 19/12/2012 =
* New feature: Terms auto detect. All coincidences will be shown if this option is selected.                 
* Improved style of terms in the text, inheriting the context's style.

= 1.3.6 - 19/12/2012 =
* Added CSS attribute to tooltip z-index: 99;
* If URL attribute is not set, the term will not appear as a link.

= 1.3.5 - 18/12/2012 =
* WordPress 3.5 ready.
* Color selectors in the plugin's options section now are like WordPress 3.5.

= 1.3.4 - 18/12/2012 =
* Added widget options: title and list depth.
* Plugin's options improved.

= 1.3.3 - 18/12/2012 =
* Widget fixed.

= 1.3.2 - 27/11/2012 =
* Widget added.

= 1.3.1 - 27/11/2012 =
* App icons added, made by Layla Sierra.

= 1.3 - 26/11/2012 =
* Added custom URL to the short-tag: [def url="http://url.com"]Term[/def]

= 1.2 - 26/11/2012 =
* Options page now works.
* The options modify the result in the post view.
* Two new options added: Tooltip Text Color and Opacity.
* Added support to HTML5 fields in options page.
* Added suport to recognize Definition Slug and Definition ID.
                        
= 1.1 - 24/11/2012 =
* Options page added.
                        
= 1.0 - 23/11/2012 =
* Basic functionality created.
* Plugin improved with jQuery.