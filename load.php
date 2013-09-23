<?php
/**
 * Plugin Name: WPCustom Category Image
 * Plugin URI: http://eduardostuart.com.br/
 * Description: "Customization is a good thing." The Category Image plugin allow users to upload their very own custom category (taxonomy) image to obtain a much more personalized look and feel.
 * Version: 1.0
 * Author: Eduardo Stuart
 * Author URI: http://eduardostuart.com.br
 * Tested up to: 3.5
 *
 * Text Domain: wpcustomcategoryimage
 * Domain Path: /i18n/languages/
 */


define('TXT_DOMAIN'     , 'wpcustomcategoryimage');
define('PATH_BASE'      , dirname(__FILE__) . DIRECTORY_SEPARATOR );
define('PATH_TEMPLATES' , PATH_BASE . 'templates/');
define('WP_VERSION'     , get_bloginfo('version'));
define('WP_MIN_VERSION' , 3.5);


load_plugin_textdomain(TXT_DOMAIN, FALSE, 'i18n/languages');



require_once 'functions.php';


require_once 'WPCustomCategoryImage.php';



WPCustomCategoryImage::initialize();


register_activation_hook( __FILE__ , array('WPCustomCategoryImage','install') );