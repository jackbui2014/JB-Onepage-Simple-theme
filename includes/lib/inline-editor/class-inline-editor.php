<?php
class JB_Inline_Editor extends JB_Base{
	private static $instance    = NULL;
	/**
	 * Get class instance.
	 *
	 * @since  1.0
	 * @return JB_Uploader instance
	 * @author JACK BUI
	 */
	public static function get_instance() {
		if ( NULL == static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}
	public function __construct() {

	}
	public function init(){
		$this->add_ajax('jb-uploader-action', 'jb_uploader_action');		
	}
}
