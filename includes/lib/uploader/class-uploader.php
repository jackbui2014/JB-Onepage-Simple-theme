<?php
class JB_Uploader extends JB_Base{
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
	/**
	  * Init for JB_Uploader class
	  * @param void
	  * @return void
	  * @since 1.0
	  * @package JBTHEME
	  * @category void
	  * @author JACK BUI
	  */
	public function init(){
		$this->add_action('wp_enqueue_scripts', 'add_media_upload_scripts');
		$this->add_filter( 'ajax_query_attachments_args', 'show_current_user_attachments', 10, 1 );
		$this->add_ajax('jb-uploader-action', 'jb_uploader_action');		
		$this->add_filter('media_upload_tabs','remove_media_tab', 10, 1);
		$this->add_action( 'print_media_templates', 'custom_media_box' );
	}
	/**
	  * Add media upload script
	  * @param void
	  * @return void
	  * @since 1.0
	  * @package JBTHEME
	  * @category void
	  * @author JACK BUI
	  */
	public function add_media_upload_scripts() {
	    if ( is_admin() ) {	    	
	        return;
	    }
	    // $this->add_script('jb-uploader-js', TEMPLATEURL. '/includes/lib/uploader/js/uploader.js', 
	    // 				array('jquery', 'underscore', 'backbone','jb-main-js'), THEME_VERSION, true);	
	    wp_enqueue_media();
	}
	/**
	  * Show current user attachments
	  * @param void
	  * @return void
	  * @since 1.0
	  * @package JBTHEME
	  * @category void
	  * @author JACK BUI
	  */
	public function show_current_user_attachments( $query = array() ) {		
		global $user_ID;
		if( !current_user_can( 'manage_options' ) ){		    
		    if( $user_ID ) {
		        $query['author'] = $user_ID;
		    }
		}			
	    return $query;
	}
	public function jb_uploader_action(){
		$request = $_REQUEST;				
		extract($request);
		$respone = array(
			'success' => true,
			'msg' => 'success',
			'data'=> $data,
			'attachment'=> $attachment
			);
		do_action('jb-uploader-process', $respone);
		wp_send_json($respone);
	}
	public function remove_media_tab($tabs) {		
	
		return $tabs;
	}
	/**
	 * Add custom style to media popup
	 * @param void
	 * @return void
	 * @since 1.0
	 * @package JBTHEME
	 * @category void
	 * @author JACK BUI
	 */
	public function custom_media_box(){?>
		<style>
			.screen-reader-text, .screen-reader-text span, .ui-helper-hidden-accessible {
				position: absolute;
				margin: -1px;
				padding: 0;
				height: 1px;
				width: 1px;
				overflow: hidden;
				clip: rect(0 0 0 0);
				border: 0;
				word-wrap: normal!important;
			}
		</style>
	<?php }
}
