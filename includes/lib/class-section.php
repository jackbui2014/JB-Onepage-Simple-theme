<?php

/**
 * Created by PhpStorm.
 * User: Jack Bui
 * Date: 8/21/2015
 * Time: 1:12 PM
 */
class JB_Section extends JB_Base
{
    private static $instance    = NULL;
    public $order;
    public $status;
    public $data_type;
    public $template_url;
    public $name;
    public $description;
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
     * @param integer $order
     * @param integer $status 1 if active and 0 if deactive
     * @param string $data_type is a post type or option
     * @param string $template_url is template path to html template
     * @param string $name
     * @param string $description
     * @return void
     * @since 1.0
     * @package JBTHEME
     * @category void
     * @author JACK BUI
     */
    public  function __construct( $order = 0, $status = 1, $data_type = "post", $template_url = '', $name = '', $description = ''  ) {
      $this->order = $order;
      $this->status = $status;
      $this->data_type =$data_type;
      $this->template_url = $template_url;
      $this->name = $name;
      $this->description = $description;
      $this->init();
    }
    /**
      * Init of JB_Section class
      * @param void
      * @return void
      * @since 1.0
      * @package JBTHEME
      * @category void
      * @author JACK BUI
      */
    public function init(){
        //$this->render();
    }
    /**
      * SET template url for section
      * @param string $template_name
      * @return void
      * @since 1.0
      * @package JBTHEME
      * @category void
      * @author JACK BUI
      */
    public function setTemplateUrl( $template_url){
        $this->template_url = $template_url;
    }   
    /**
      * set order number for section
      * @param integer $order
      * @return void
      * @since 1.0
      * @package JBTHEME
      * @category void
      * @author JACK BUI
      */
    public function setOrder( $order){
        $this->order = $order;
    }   
    /**
      * get order number for section
      * @param vodi
      * @return integer $order of this section
      * @since 1.0
      * @package JBTHEME
      * @category void
      * @author JACK BUI
      */
    public function getOrder(){
        return $this->order;
    }   
    /**
      * set status  for this section
      * @param integer $status
      * @return void
      * @since 1.0
      * @package JBTHEME
      * @category void
      * @author JACK BUI
      */
    public function setStatus( $status){
        $this->status = $status;
    }   
    /**
      * get status  for this section
      * @param void
      * @return integer $status
      * @since 1.0
      * @package JBTHEME
      * @category void
      * @author JACK BUI
      */
    public function getStatus(){
        return $this->status;
    }   
    /**
      * set data type  for this section
      * @param string $status
      * @return void
      * @since 1.0
      * @package JBTHEME
      * @category void
      * @author JACK BUI
      */
    public function setDataType( $data_type){
        $this->data_type = $data_type;
    }   
    /**
      * get data type  for this section
      * @param void
      * @return string $status
      * @since 1.0
      * @package JBTHEME
      * @category void
      * @author JACK BUI
      */
    public function getDataType(){
        return $this->data_type;
    }
    /**
      * Render html template of this section
      * @param void
      * @return void
      * @since 1.0
      * @package JBTHEME
      * @category void
      * @author JACK BUI
      */
    public function render(){
        if( $this->status == 1 ) {
            get_template_part($this->template_url);
        }
    }

}