<?php
/**
 * Created by PhpStorm.
 * User: Jack Bui
 * Date: 8/21/2015
 * Time: 1:12 PM
 */
class JB_Section_Manager extends JB_Base
{
    private static $instance    = NULL;
    public  $jb_section_list = array();
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
    public  function __construct(){
    }
    /**
      * Get jb sections list
      * @param void
      * @return array section list
      * @since 1.0
      * @package JBTHEME
      * @category void
      * @author JACK BUI
      */
    public  function jb_get_section_list(){
        global $jb_theme_options;
        if( isset( $jb_theme_options['jb_section_list'] )) {
            return (array)$jb_theme_options['jb_section_list'];
        }
        return array();
    }
    /**
      * Set jb section list
      * @param array/string $section_list
      * @return void
      * @since 1.0
      * @package JBTHEME
      * @category void
      * @author JACK BUI
      */
    public function jb_set_section_list($section_list){
        if( !is_array($section_list) ){
            $section_list = array($section_list);
        }
        $this->jb_section_list = $section_list;
        $this->jb_save_section_list();
    }
    /**
      * Save section list to option
      * @param array $section_list
      * @return void
      * @since 1.0
      * @package JBTHEME
      * @category void
      * @author JACK BUI
      */
    public function jb_save_section_list(){
        global $jb_theme_options, $ReduxFramework;
        $section_list = $this->jb_get_section_list();
        $this->jb_section_list = wp_parse_args((array)$this->jb_section_list, $section_list);
        $ReduxFramework->set('jb_section_list',   $this->jb_section_list);
    }
    /**
      * save section when new a class extend of section class
      * @param string $string section name
      * @param object $class_object
      * @return void
      * @since 1.0
      * @package JBTHEME
      * @category void
      * @author JACK BUI
      */
    public function save_section( $string = '', $class_object ){
        global  $jb_theme_options;
        //if( !isset($jb_theme_options[$string]) ){
            $this->save_section_infor($string, $class_object);
        //}
    }
    /**
     * save section information
     * @param string $string section name
     * @param object $class_object
     * @return void
     * @since 1.0
     * @package JBTHEME
     * @category void
     * @author JACK BUI
     */
    public function save_section_infor( $string = '', $class_object ){
        global  $ReduxFramework;
        $ReduxFramework->set($string, $class_object);
        $this->jb_set_section_list($string);
    }
    /**
     * update section information
     * @param string $string section name
     * @param array $section_infor
     * @return void
     * @since 1.0
     * @package JBTHEME
     * @category void
     * @author JACK BUI
     */
    public function update_section_infor( $string = '', $section_infor= array() ){
        $saved_infor = $this->get_section($string);
        foreach( $section_infor as $key => $value ){
            $saved_infor->$key = $value;
        }
        $saved_infor = serialize($saved_infor);
        $this->save_section_infor($string, $saved_infor);

    }
    /**
     * save section
     * @param string $string the option name
     * @return void
     * @since 1.0
     * @package JBTHEME
     * @category void
     * @author JACK BUI
     */
    public function get_section( $string = ''){
        global $jb_theme_options;
        if( !isset($jb_theme_options[$string]) ){
            return array();
        }
        return unserialize($jb_theme_options[$string]);
    }
    /**
     * Get jb sections list infor
     * @param void
     * @return array section list
     * @since 1.0
     * @package JBTHEME
     * @category void
     * @author JACK BUI
     */
    public function jb_get_section_list_infor(){
        $section_list = $this->jb_get_section_list();
        $section_arr = array();
        foreach( $section_list as $key => $value){
            $section_arr[$value] = $this->get_section($value);
        }
        $section_arr = $this->jb_order_section_list($section_arr);
        return $section_arr;
    }
    /**
     * Get jb sections list infor
     * @param array $section_arr
     * @return array $section_arr after order
     * @since 1.0
     * @package JBTHEME
     * @category void
     * @author JACK BUI
     */
    public function jb_order_section_list($section_arr){
        $temp = array();
        foreach( $section_arr as $key => $value ){
            $temp[$key] = $value->order;
        }
        asort($temp);
        foreach( $temp as $key => $value ){
            $temp[$key] = $section_arr[$key];
        }
        $section_arr = $temp;
        return $section_arr;
    }
}