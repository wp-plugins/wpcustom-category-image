<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class WPCustomCategoryImage{

	// array with all taxonomies
	private $taxonomies;

	public static function install(){

		if(!( WP_VERSION >= WP_MIN_VERSION)){
			// NO GOD! PLEASE NO!!! NOOOOOOOOOO
			$message = '<a href="http://www.youtube.com/watch?v=umDr0mPuyQc" target="_blank">';
			$message.= __('Sorry, WPCustom Category Image works only under Wordpress 3.5 or higher',TXT_DOMAIN);
			$message.= '</a>';

			wpcci_error( $message , E_USER_ERROR);

			return;
		}
	}

	// initialize wp custom category image
	public static function initialize(){

		$CategoryImage = new static;
		$CategoryImage->taxonomies =  get_taxonomies();

		add_action('admin_init'            , array($CategoryImage,'admin_init'));
		add_action('admin_enqueue_scripts' , array($CategoryImage,'enqueue_assets'));
		add_action('edit_term'             , array($CategoryImage,'save_image'));
		add_action('create_term'           , array($CategoryImage,'save_image'));
	}


	public function admin_init(){

		if( is_array($this->taxonomies) ){
			foreach( $this->taxonomies as $taxonomy ){
				add_action( $taxonomy.'_add_form_fields'  , array($this,'taxonomy_field') );
				add_action( $taxonomy.'_edit_form_fields' , array($this,'taxonomy_field') );
			}
		}

	}


	// enqueue css and js files
	public function enqueue_assets( $hook ){

		if( $hook != 'edit-tags.php'){
			return;
		}

		wp_enqueue_media();

		wp_enqueue_script(
			'category-image-js', 
			plugins_url( '/js/categoryimage.js', __FILE__ ), 
			array('jquery'), 
			'1.0.0', 
			true 
		);

		$_data = array(
			'wp_version' => WP_VERSION,
			'label'      => array(
				'title'  => __('Choose Category Image',TXT_DOMAIN),
				'button' => __('Choose Image',TXT_DOMAIN)
			)
		);

		wp_localize_script(
			'category-image-js', 
			'CategoryImage', 
			$_data 
		);

		wp_enqueue_style(
			'category-image-css',
			plugins_url( '/css/categoryimage.css', __FILE__ )
		);
	}

	public function save_image($term_id){
		$attachment_id = isset($_POST['categoryimage_attachment']) ? (int) $_POST['categoryimage_attachment'] : null;
		if(!is_null($attachment_id) && $attachment_id > 0 && !empty($attachment_id)){
			update_option('categoryimage_'.$term_id, $attachment_id);
		}else{
			delete_option('categoryimage_'.$term_id);
		}
	}

	public function get_attachment_id( $term_id ){
		return get_option('CategoryImage_'.$term_id);
	}

	public function has_image( $term_id ){
		return ($this->get_attachment_id( $term_id ) !== false);
	}

	public static function get_category_image( $params = array(), $onlysrc=false ){
		$params = array_merge(array(
			'size'    => 'full',
			'term_id' => null,
			'alt'     => null
		),$params);

		$term_id = $params['term_id'];
		$size    = $params['size'];


		if(!$term_id){
			if(is_category()){
				$term_id = get_query_var('cat');
			}elseif(is_tax()){
				$current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
				$term_id = $current_term->term_id;	
			}
		}


		if(!$term_id){
			return;
		}


		$attachment_id   = get_option('categoryimage_'.$term_id);
		$attachment_meta = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
		$attachment_alt  = trim(strip_tags( $attachment_meta ));

		$attr = array(
			'alt'=> (is_null($params['alt']) ?  $attachment_alt : $params['alt'])
		);

		if( $onlysrc === true ){
			$src = wp_get_attachment_image_src( $attachment_id , $size , false );
			return is_array($src) ? $src[0] : null;
		}

		
		return wp_get_attachment_image( $attachment_id, $size, false , $attr ); 
	}

	public function taxonomy_field( $taxonomy ){

		$params = array(
			'label'  => array(
				'image'        => __('Image',TXT_DOMAIN),
				'upload_image' => __('Upload/Edit Image',TXT_DOMAIN),
				'remove_image' => __('Remove image',TXT_DOMAIN)
			),
			'categoryimage_attachment'=>null
		);


		if(isset($taxonomy->term_id)){
			if($this->has_image($taxonomy->term_id)){

				$image = self::get_category_image(array(
					'term_id' => $taxonomy->term_id
				),true);

				$attachment_id = $this->get_attachment_id($taxonomy->term_id);


				$params = array_merge($params,array(
					'categoryimage_image'      => $image,
					'categoryimage_attachment' => $attachment_id
				));
			}
		}

		$html = ___template('form-option-image',$params);
		echo $html;
	}

}