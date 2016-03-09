<?php
/**
 * Get jb option
 * 
 * @param string $option_name is name of option
 * @return string option
 * @author Tambh 
 * 
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if( !function_exists('JB_Options') ) {
	/**
	 * Get instance of class JB_Options
	 * @param void
	 * @return void
	 * @since 1.0
	 * @package JBPROVIDER
	 * @category JB_THEME
	 * @author JACK BUI
	 */
	function JB_Options(){
		return JB_Options::get_instance();
	}
}
/**
 * Get jb theme option
 * @param string $option_name name of option
 * @param string $default
 * @return mixed $option value
 * @since 1.0
 * @package JBPROVIDER
 * @category JB_THEME
 * @author JACK BUI
 */
function jb_get_option( $option_name = '', $default = '' ){
	if( !JB_Options()->get($option_name) ){
		return $default;
	}
	else{
		return JB_Options()->get($option_name);
	}
}
/**
 * Get jb theme option
 * @param string $option_name name of option
 * @param string $default
 * @return mixed $option value
 * @since 1.0
 * @package JBPROVIDER
 * @category JB_THEME
 * @author JACK BUI
 */
function jb_set_option( $option_name = '', $option_value = '' ){
	JB_Options()->set($option_name, $option_value);
}
if( !function_exists('JB_Color') ) {
	/**
	 * Get instance of class JB_Color
	 * @param void
	 * @return void
	 * @since 1.0
	 * @package JBPROVIDER
	 * @category JB_THEME
	 * @author JACK BUI
	 */
	function JB_Color(){
		return JB_Color::get_instance();
	}
}
if(!function_exists('JB_Menu')){
	/**
	* Get instance for JB_Menu class
	* @param void
	* @return void
	* @since 1.0
	* @package JBPROVIDER
	* @category JB_THEME
	* @author JACK BUI
	*/
	function JB_Menu(){
		return JB_Menu::get_instance();
	}
}
if(!function_exists('JB_Section_Manager')){
	/**
	 * Get instance for JB_Menu class
	 * @param void
	 * @return void
	 * @since 1.0
	 * @package JBPROVIDER
	 * @category JB_THEME
	 * @author JACK BUI
	 */
	function JB_Section_Manager(){
		return JB_Section_Manager::get_instance();
	}
}
/**
 * get page link from a page template
 *
 * @param string $page is template name
 * @param array $params is attribute for this page
 * @param boolean $create if true will create a new page.
 * @return void
 * @since 1.0
 * @package JBTHEME
 * @category void
 * @author JACK BUI
 */
if( !function_exists( 'jb_get_page_link' ) ){
	function jb_get_page_link($pages, $params = array() , $create = true) {

		$page_args = array(
			'post_title' => '',
			'post_content' => __('Please fill out the form below ', JB_DOMAIN) ,
			'post_type' => 'page',
			'post_status' => 'publish'
		);

		if (is_array($pages)) {

			// page data is array (using this for insert page content purpose)
			$page_type = $pages['page_type'];
			$page_args = wp_parse_args($pages, $page_args);
		} else {

			// pages is page_type string (using this only insert a page template)
			$page_type = $pages;
			$page_args['post_title'] = $page_type;
		}
		/**
		 * get page template link option and will return if it not empty
		 */
		$link = get_option($page_type, '');
		if ($link) {
			$return = add_query_arg($params, $link);
			return apply_filters('jb_get_page_link', $return, $page_type, $params);
		}

		// find post template
		$pages = get_pages(array(
			'meta_key' => '_wp_page_template',
			'meta_value' => 'page-' . $page_type . '.php',
			'numberposts' => 1
		));

		// page not existed
		if (empty($pages) || !is_array($pages)) {

			// return false if set create is false and doesnot generate page
			if (!$create) return false;
			if( !	get_option('auto_create_page', false) ){
				// insert page
				$id = wp_insert_post($page_args);

				if ($id) {

					// update page template option
					update_post_meta($id, '_wp_page_template', 'page-' . $page_type . '.php');
				}
			}
			else{
				$id = -1;
			}
		} else {

			// page exists
			$page = array_shift($pages);
			$id = $page->ID;
		}
		if($id != -1 ){
			$return = get_permalink($id);
		}
		else{
			$return = home_url();
		}
		/**
		 * update transient page link
		 */
		update_option('page-' . $page_type . '.php', $return);

		if (!empty($params) && is_array($params)) {
			$return = add_query_arg($params, $return);
		}

		return apply_filters('jb_get_page_link', $return, $page_type, $params);
	}
}