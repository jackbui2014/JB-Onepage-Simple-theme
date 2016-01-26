<?php
class JB_Menu extends JB_Base
{
    private static $instance    = NULL;
    public $menus;
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
     * The construct of class JB_Menu
     * @param array $menus
     * @return void
     * @since 1.0
     * @package JBTHEME
     * @category void
     * @author JACK BUI
     */
    public function __construct( $menus = array() ) {
        $this->set_list_menus( $menus );
    }
    /**
    * Init class JB_Menu
    * @param void
    * @return void
    * @since 1.0
    * @package JBPROVIDER
    * @category JB_THEME
    * @author JACK BUI
    */
    public function init(){
        $menus = $this->get_list_menus();
        $this->register_menu($menus);
        $this->add_filter( 'walker_nav_menu_start_el', 'jb_nav_description', 10, 4 );
    }
    /**
    * Register a new menu location
    * @param void
    * @return void
    * @since 1.0
    * @package JBPROVIDER
    * @category JB_THEME
    * @author JACK BUI
    */
    public function register_menu( $param = array()){
        register_nav_menus($param);
    }
    /**
    * Get list of menu location
    * @param void
    * @return array  list of menu
    * @since 1.0
    * @package JBPROVIDER
    * @category JB_THEME
    * @author JACK BUI
    */
    public function get_list_menus(){
        return apply_filters('jb_list_menus', $this->menus);
    }
    /**
    * Set list menus
    * @param array $menus list of menus
    * @return void
    * @since 1.0
    * @package JBPROVIDER
    * @category JB_THEME
    * @author JACK BUI
    */
    public function set_list_menus( $menus = array() ){
        $default = array(
            'primary' => __( 'Primary Menu', JB_DOMAIN )
        );
        $menus = wp_parse_args( $menus, $default );
        $this->menus = $menus;
    }
    /**
     * Display descriptions in main navigation.
     *
     * @since Twenty Fifteen 1.0
     *
     * @param string  $item_output The menu item output.
     * @param WP_Post $item        Menu item object.
     * @param int     $depth       Depth of the menu.
     * @param array   $args        wp_nav_menu() arguments.
     * @return string Menu item with possible description.
     */
    public function jb_nav_description( $item_output, $item, $depth, $args ) {
        if ( 'primary' == $args->theme_location && $item->description ) {
            $item_output = str_replace( $args->link_after . '</a>', '<div class="menu-item-description">' . $item->description . '</div>' . $args->link_after . '</a>', $item_output );
        }
        return $item_output;
    }
}
