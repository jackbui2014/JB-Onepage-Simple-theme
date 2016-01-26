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
