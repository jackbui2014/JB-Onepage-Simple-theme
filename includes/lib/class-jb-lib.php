<?php 
class JB_Lib extends JB_Base
{
	private static $instance    = NULL;
	/**
	 * Get class instance.
	 *
	 * @since  1.0
	 * @return JB_Lib instance
	 * @author JACK BUI
	 */
	public static function get_instance() {
		if ( NULL == static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}
	/**
	  * The construct of class JB_Lib
	  * @param void
	  * @return void
	  * @since 1.0
	  * @package JBTHEME
	  * @category void
	  * @author JACK BUI
	  */
	public function __construct() {
		$this->add_action( 'after_setup_theme', 'jb_theme_init');
		$this->add_action('wp_enqueue_scripts', 'add_lib_main_scripts');
		$this->add_action('wp_footer', 'add_theme_template');
		$this->init();
	}
	/**
	  * Init of class JB_Lib
	  * @param void
	  * @return void
	  * @since 1.0
	  * @package JBTHEME
	  * @category void
	  * @author JACK BUI
	  */
	public function init(){
		$jb_post = JB_Posts::get_instance();
		$jb_post->init();
		$jb_option = JB_Options::get_instance();
		$jb_option->init();
		$this->ajaxInit();
	}
	/**
	  * Init all action, ajax, filter
	  * @param void
	  * @return void
	  * @since 1.0
	  * @package JBTHEME
	  * @category void
	  * @author JACK BUI
	  */
	public function ajaxInit(){
	}
	/**
	  * Add main script of
	  * @param void
	  * @return void
	  * @since 1.0
	  * @package JBTHEME
	  * @category void
	  * @author JACK BUI
	  */
	public function add_lib_main_scripts(){	
		$this->add_lib_main_style();	
		wp_enqueue_script('jquery');
		wp_enqueue_script('backbone');
		wp_enqueue_script('underscore');
		wp_enqueue_script('marionette', TEMPLATEURL . '/includes/lib/js/backbone.marionette.min.js', array(
            'jquery',
            'backbone',
            'underscore',
        ) , true);            
		$this->add_script('jb-lib-js', TEMPLATEURL. '/includes/lib/js/lib.js', array('jquery', 'underscore', 'backbone', 'marionette'), THEME_VERSION, true);	
		$vars = array(
            'ajaxURL' => admin_url('admin-ajax.php'),
            'confirm_message' => __("Are you sure to delete this?", JB_DOMAIN),
            );
		$vars = apply_filters('jb_globals', $vars);
		wp_localize_script('jb-lib-js', 'jb_globals', $vars);
	}
	/**
	  * Add lib style
	  * @param void
	  * @return void
	  * @since 1.0
	  * @package JBTHEME
	  * @category void
	  * @author JACK BUI
	  */
	public function add_lib_main_style(){		
		//$this->add_style('bootstrap-css', TEMPLATEURL. '/includes/lib/css/bootstrap.min.css', array(), THEME_VERSION, true);	
		//$this->add_style('font-awesome', TEMPLATEURL. '/includes/lib/css/font-awesome.min.css', array(), THEME_VERSION, true);	
		$this->add_style('jb-lib-css', TEMPLATEURL. '/includes/lib/css/lib.css', array(), THEME_VERSION, true);	
	}
	/**
	  * add theme template
	  * @param void
	  * @return void
	  * @since 1.0
	  * @package JBTHEME
	  * @category void
	  * @author JACK BUI
	  */
	public function add_theme_template(){		
		if( current_user_can('manage_options') ){
			do_action('jb_admin_template');
		}
		do_action('jb_template');
	}
	/**
	* Setup theme
	* @param void
	* @return void
	* @since 1.0
	* @package JBPROVIDER
	* @category JB_THEME
	* @author JACK BUI
	*/
	public function jb_theme_init(){
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );
		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );
		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
		) );
		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
		) );
		add_theme_support('post-thumbnails');
		JB_Menu()->init();
		$color_scheme  = JB_Color()->jb_get_color_scheme();
		$default_color = trim( $color_scheme[0], '#' );
		// Setup the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'jb_custom_background_args', array(
			'default-color'      => $default_color,
			'default-attachment' => 'fixed',
		) ) );

	}
}
