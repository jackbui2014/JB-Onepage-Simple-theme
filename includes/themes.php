<?php
class JB_Theme extends JB_Base{
	private static $instance    = NULL;
	/**
	 * Get class instance.
	 *
	 * @since  1.0
	 * @return JB_Theme instance
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
		$this->add_action( 'init' , 'wp_init' );
		$this->add_action( 'after_setup_theme' , 'theme_setup' );
		$this->add_action('wp_enqueue_scripts', 'enqueue_script');
		$this->add_action( 'jb_load_script', 'jb_load_script');
		$this->add_action( 'jb_load_admin_script', 'jb_load_admin_script');
		$this->add_action( 'jb_load_style', 'jb_load_style');
		$this->add_action( 'jb_load_admin_style', 'jb_load_admin_style');
		$this->add_action( 'jb_template', 'jb_load_template');		
		if ( current_user_can('subscriber') && !current_user_can('upload_files') ){
    		$this->add_action('admin_init', 'allow_subscriber_uploads');
		}
	}
	public function wp_init(){
		$jb_post = JB_Posts::get_instance();
		$jb_post->jb_register_post_type();
	}
	public function allow_subscriber_uploads() {
	    $subscriber = get_role('subscriber');
	    $subscriber->add_cap('upload_files');
	}
	public function theme_setup(){
	}
	public function enqueue_script(){
		$this->enqueue_style();
		 wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-1.1', TEMPLATEURL . '/js/jquery-1.11.1.min.js', array() , true);
		wp_enqueue_script('bootstrap-js', TEMPLATEURL . '/js/bootstrap.js', array() , true);
		wp_enqueue_script('carousel-js', TEMPLATEURL . '/js/owl.carousel.min.js', array() , true);
		wp_enqueue_script('isotope-js', TEMPLATEURL . '/js/isotope.js', array() , true);
		wp_enqueue_script('smooth-scroll-js', TEMPLATEURL . '/js/smooth-scroll.js', array('jquery') , true);
		wp_enqueue_script('customs-js', TEMPLATEURL . '/js/custom.js', array(
			'jquery',
             'backbone',
             'underscore'
			),
			true);
		wp_enqueue_script('main-js', TEMPLATEURL . '/js/main.js', array(
			'jquery',
			'backbone',
			'underscore',
			'jb-lib-js'
		), true);
//		$this->add_script('main-js', TEMPLATEURL. '/js/main.js', array(), THEME_VERSION, true);
	}
	public function enqueue_style(){
		// $url = TEMPLATEURL. '/includes/lib/load-styles.php';       
        wp_enqueue_style('bootstrap-css', TEMPLATEURL. '/css/bootstrap.min.css', array(), THEME_VERSION );
        wp_enqueue_style('full-slider', TEMPLATEURL. '/css/full-slider.css', array(), THEME_VERSION );
        wp_enqueue_style('font-awesome-css', TEMPLATEURL. '/css/font-awesome.css', array(), THEME_VERSION );
        wp_enqueue_style('carousel', TEMPLATEURL. '/css/assets/owl.carousel.css', array(), THEME_VERSION );
        wp_enqueue_style('main-style-css', TEMPLATEURL. '/css/style.css', array(), THEME_VERSION );
	}
	public function jb_load_script($scripts){	
		$scripts->add('main-js', TEMPLATEURL. '/js/main.js', array('jquery', 'underscore', 'backbone', 'jb-lib-js'), THEME_VERSION, true);
		$scripts->name .= 'main-js,';		
	}
	public function jb_load_admin_script($scripts){
		//$scripts->add('')
	}
	public function jb_load_style($styles){		
		$styles->add('bootstrap-css', TEMPLATEURL. '/includes/lib/css/bootstrap.min.css', array(), THEME_VERSION, true);
		$styles->name .= 'bootstrap-css,';
		$styles->add('font-awesome-css', TEMPLATEURL. '/includes/lib/css/font-awesome.min.css', array(), THEME_VERSION, true);
		$styles->name .= 'font-awesome-css,';
		$styles->add('style-css', TEMPLATEURL. '/css/styles.css', array(), THEME_VERSION, true);	

	}
	public function jb_load_admin_style($styles){
		
	}
	public function jb_load_template(){		
		get_template_part('template-js/js-post', 'item');
	}

}