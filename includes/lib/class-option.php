<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * This is post class controler
 *
 *
 * @since  1.0
 *
 * @author Jack Bui
 */
class JB_Options extends JB_Base {
	private static $instance = NULL;

	/**
	 * get the instance.
	 *
	 * @since  1.00
	 *
	 * @return \JB_Post
	 *
	 * @author Jack Bui
	 */
	public static function get_instance() {
		if ( static::$instance == NULL ) {
			static::$instance = new static();
		}

		return static::$instance;
	}
	public function __construct($option_name = 'jb_option') {        
        $this->init();
    }
	public function init() {		
		$this->add_ajax( 'jb-sync-option', 'sync_option' );		
	}

	/**
	 * Synce post after change.
	 *
	 * @since  1.0
	 *
	 * @return void
	 *
	 * @author Jack Bui
	 */
	public function sync_option($request) {
		if(!is_array($request) ){
			$request = $_REQUEST;
		}		
        extract($request); 
        if( isset($option_name) && isset($option_value) ){
            $this->set( $option_name = '', $option_value = '');
            $response = array( 
                'msg'=> __('Update successful!', JB_DOMAIN),
                'success'=>'success'
                );
        }
        else{
            $response = array( 
                'msg'=> __('Update failed!', JB_DOMAIN),
                'success'=>'error'
                );
        }
        wp_send_json($response);    
	}
    /**
     * Set option 
     *
     * @param string $option_name
     * @pram string $default
     * @return mixed $value of false
     * @author Jack Bui
     */
    public function get( $option_name = '', $default = ''){
        global $jb_theme_options;
        if( isset($jb_theme_options[$option_name] ) ){
            return $jb_theme_options[$option_name];
        }
        return false;
    }
    /**
     * get option 
     *
     * @param string $option_name
     * @param mixed $option_valu e
     * @return void
     * @author Jack Bui
     */
    public function set( $option_name = '', $option_value = ''){
        global  $ReduxFramework;
        if( $option_name != '' ){
            $ReduxFramework->set( $option_name, $option_value );
        }        
    }
}
