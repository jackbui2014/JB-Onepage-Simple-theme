<?php
/**
 * Created by PhpStorm.
 * User: Jack Bui
 * Date: 3/7/2016
 * Time: 10:56 AM
 */
if(!function_exists('jb_favicon')) {
    /**
     * render mobile icon, favicon image get from option
     * @author Jack Bui
     * @return void
     */
    function jb_favicon () {
        global $jb_theme_options;
        $img = get_template_directory_uri()."/img/favicon.png";
        if( isset($jb_theme_options['favicon']['url']) ){
            $img = $jb_theme_options['favicon']['url'];
        }
        echo '<link href="'. $img .'" rel="shortcut icon" type="image/x-icon">';
    }
}
if( !function_exists('jb_Logo') ){
    /**
     * Description
     *
     * @param void
     * @return void
     * @since 1.0
     * @package JBTHEME
     * @category void
     * @author JACK BUI
     */
    function jb_Logo($option_name = 'site_logo', $echo = true){
        global $jb_theme_options;
        $site_logo = $jb_theme_options[$option_name];
        if (!empty($site_logo)) {
            $img = $site_logo['url'];
        }
        else{
            $img = TEMPLATEURL. '/img/logo.jpg';
        }
        if($echo == false) {
            return '<img alt="' . get_bloginfo("name") . '" src="' . $img . '" />';
        } else {
            echo '<img alt="' . get_bloginfo("name") . '" src="' . $img . '" />';
        }

    }
}