<?php
/**
 * Theme option for redux framwork 
 *
 * @since 1.0
 * @author JACK BUI
 */

if ( !class_exists( 'ReduxFramework' ) && file_exists( get_template_directory() . '/includes/lib/settings/redux/ReduxCore/framework.php' ) ) {
    require_once( get_template_directory() . '/includes/lib/settings/redux/ReduxCore/framework.php' );
}
if ( !isset( $redux_demo ) && file_exists( get_template_directory() . '/includes/lib/settings/jb.config.php' ) ) {
    require_once( get_template_directory() . '/includes/lib/settings/jb.config.php' );
}
// Font Awesome for Redux Framework
function redux_icon_font() {
    wp_register_style(
        'redux-font-awesome',
        get_template_directory_uri() . '/includes/lib/css/font-awesome.min.css',
        array(),
        time(),
        'all'
    );  
    wp_enqueue_style( 'redux-font-awesome' );
}
add_action( 'redux/page/jb_theme_options/enqueue', 'redux_icon_font' );

