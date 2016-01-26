<?php
if(!class_exists('WP_Styles')){
    $parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
    require_once( $parse_uri[0] . 'wp-load.php' );
}
class JB_LoadStyles extends WP_Styles
{
    private static $instance;
    public $name = '';
    public $c = 1;
    public $dir = 'ltr';
    /**
     * Get WE_LoadStyles instance.
     *
     * @since  0.9.0
     *
     * @see \WE_LoadStyles::$instance
     * @return WE_LoadStyles
     *
     * @author Tambh
     */
    public static function get_instance(){
        if(null == static::$instance){
            static::$instance = new static();
        }
        return static::$instance;
    }
    /**
     * Load script to your site
     *
     * @param string $load
     * @return string js code
     * @since 0.9.0
     * @author: Tambh
     *
     */
    public function jb_add_styles( &$styles ){
        if ( ! defined( 'SCRIPT_DEBUG' ) ) {
            define( 'SCRIPT_DEBUG', $develop_src );
        }

        if ( ! $guessurl = site_url() ) {
            $guessed_url = true;
            $guessurl = wp_guess_url();
        }
        $styles->base_url = $guessurl;       
        do_action('jb_load_style', $styles);       
        if(current_user_can('manage_options'))
        {
          do_action('jb_load_admin_style', $styles);
        }
        do_action('jb_after_load_style', $styles);
    }
}
