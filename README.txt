=== WPCustom Category Image ===
Tags: wordpress, category, wordpress category image , custom category image
Requires at least: 3.5
Tested up to: 3.6 beta 3
Stable tag: 1.0

The WPCustom Category Image plugin allow users to upload their very own custom category (taxonomy) image to obtain a much more personalized look and feel.

== Description ==

"Customization is a good thing." 

The WPCustom Category Image plugin allow users to upload their very own custom category (taxonomy) image to obtain a much more personalized look and feel.

== Installation ==

You can either install it automatically from the WordPress admin, or do it manually:

1. Unzip the archive and put the `wpcustom-category-image` folder into your plugins folder (/wp-content/plugins/).
2. Activate the plugin from the Plugins menu.

= Usage =

Go to *Wp-Admin -> Posts(or post type) -> Categories (or taxonomy)* to see Custom Category Image options

If you want to add the images to your theme:

* category_image($params,$echo)
* category_image_src($params,$echo)


*$params (array)* (optional)

* term_id (optional)
* size    (array or defined size (add_image_size))

*$echo (boolean)* (optional) - default- false


== Screenshots ==

1. Add New Category
2. Edit Category
3. Choose Category Image