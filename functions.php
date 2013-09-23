<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if(!function_exists('___template')){
	function ___template( $name , $params = array() ){

		$filename = PATH_TEMPLATES . $name . '.php';

		if( file_exists($filename) ){
			foreach($params as $param=>$value){
				$$param = $value;
			}

			include $filename;
		}

	}
}


if(!function_exists('category_image')){
	function category_image( $params = array(), $echo = false ){
		
		$image_header = WPCustomCategoryImage::get_category_image($params);
		

		if( !$echo ){
			return $image_header;
		}

		echo $image_header;
	}
}


if(!function_exists('category_image_src')){
	function category_image_src( $params = array(), $echo = false ){
		
		$image_header = WPCustomCategoryImage::get_category_image($params,true);

		if( !$echo ){
			return $image_header;
		}

		echo $image_header;
	}
}

// thanks to http://www.squarepenguin.com/wordpress/?p=6
function wpcci_error($message, $errno){
	$action = isset($_GET['action']) ? trim($_GET['action']) : null;
    if(!is_null($action) && $action === 'error_scrape') {
    	die( $message );
    } else {
        trigger_error($message, $errno);
    }
}