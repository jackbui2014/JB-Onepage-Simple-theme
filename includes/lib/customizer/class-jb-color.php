<?php
class JB_Color extends JB_Base
{
    private static $instance = NULL;

    /**
     * Get class instance.
     *
     * @since  1.0
     * @return JB_Lib instance
     * @author JACK BUI
     */
    public static function get_instance()
    {
        if (NULL == static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * The construct of class JB_Color
     * @param void
     * @return void
     * @since 1.0
     * @package JBTHEME
     * @category void
     * @author JACK BUI
     */
    public function __construct()
    {

    }
    /**
     * Register color schemes for JB THEME
     *
     * Can be filtered with {@see 'twentyfifteen_color_schemes'}.
     *
     * The order of colors in a colors array:
     * 1. Main Background Color.
     * 2. Sidebar Background Color.
     * 3. Box Background Color.
     * 4. Main Text and Link Color.
     * 5. Sidebar Text and Link Color.
     * 6. Meta Box Background Color.
     *
     * @return array An associative array of color scheme options.
     * @since 1.0
     * @package JBPROVIDER
     * @category JB_THEME
     * @author JACK BUI
     */
    public function jb_get_color_schemes() {
        return apply_filters( 'jb_color_schemes', array(
            'default' => array(
                'label'  => __( 'Default', JB_DOMAIN ),
                'colors' => array(
                    '#f1f1f1',
                    '#ffffff',
                    '#ffffff',
                    '#333333',
                    '#333333',
                    '#f7f7f7',
                ),
            ),
            'dark'    => array(
                'label'  => __( 'Dark', JB_DOMAIN ),
                'colors' => array(
                    '#111111',
                    '#202020',
                    '#202020',
                    '#bebebe',
                    '#bebebe',
                    '#1b1b1b',
                ),
            ),
            'yellow'  => array(
                'label'  => __( 'Yellow', JB_DOMAIN ),
                'colors' => array(
                    '#f4ca16',
                    '#ffdf00',
                    '#ffffff',
                    '#111111',
                    '#111111',
                    '#f1f1f1',
                ),
            ),
            'pink'    => array(
                'label'  => __( 'Pink', JB_DOMAIN ),
                'colors' => array(
                    '#ffe5d1',
                    '#e53b51',
                    '#ffffff',
                    '#352712',
                    '#ffffff',
                    '#f1f1f1',
                ),
            ),
            'purple'  => array(
                'label'  => __( 'Purple', JB_DOMAIN ),
                'colors' => array(
                    '#674970',
                    '#2e2256',
                    '#ffffff',
                    '#2e2256',
                    '#ffffff',
                    '#f1f1f1',
                ),
            ),
            'blue'   => array(
                'label'  => __( 'Blue', JB_DOMAIN ),
                'colors' => array(
                    '#e9f2f9',
                    '#55c3dc',
                    '#ffffff',
                    '#22313f',
                    '#ffffff',
                    '#f1f1f1',
                ),
            ),
        ) );
    }
    /**
    * Get the current JB THEME color scheme.
    * @param void
    * @return void
    * @since 1.0
    * @package JBPROVIDER
    * @category JB_THEME
    * @author JACK BUI
    */
    public function jb_get_color_scheme() {
        $color_scheme_option = get_theme_mod( 'color_scheme', 'default' );
        $color_schemes       = $this->jb_get_color_schemes();

        if ( array_key_exists( $color_scheme_option, $color_schemes ) ) {
            return $color_schemes[ $color_scheme_option ]['colors'];
        }

        return apply_filters( 'jb_get_color_scheme', $color_schemes['default']['colors'] );
    }
}