<?php
if(!class_exists('WP_Scripts')){
    $parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
    require_once( $parse_uri[0] . 'wp-load.php' );
}
class JB_LoadScripts extends WP_Scripts
{
    private static $instance;
    public $name = '';
    public $c = 1;
    /**
     * Get WE_LoadScript instance.
     *
     * @since  0.9.0
     *
     * @see \WE_LoadScript::$instance
     * @return WE_LoadScript
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
    public function jb_add_script( &$scripts ){
        if ( ! defined( 'SCRIPT_DEBUG' ) ) {
            define( 'SCRIPT_DEBUG', $develop_src );
        }

        if ( ! $guessurl = site_url() ) {
            $guessed_url = true;
            $guessurl = wp_guess_url();
        }
        $scripts->base_url = $guessurl;
        do_action('jb_load_script', $scripts);
        if(current_user_can('manage_options'))
        {
             do_action('jb_load_admin_script', $scripts);
        }
        do_action('jb_after_load_script', $scripts);
    }
    /**
     * Get file content of script file
     *
     * @param string $path
     * @return string $content of file
     * @since 0.9.0
     * @packet WE
     * @category MINIFY
     * @author: Tambh
     *
     */
    public function get_file($path) {
        if ( function_exists('realpath') )
            $path = realpath($path);

        if ( ! $path || ! @is_file($path) )
            return '';

        return @file_get_contents($path);
    }
}
