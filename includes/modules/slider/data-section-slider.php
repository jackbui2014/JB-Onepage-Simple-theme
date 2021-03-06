<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
class JB_Data_Section_Slider extends JB_Posts
{
    public static $instance = NULL;
    public $post_type = 'jb_slider';

    public function __construct($post_type = '', $taxs = array(), $meta_data = array(), $localize = array())
    {
        parent::__construct('jb_slider', $taxs, $meta_data, $localize);
        $this->taxs = array();
        $this->create_rules = array(
            'post_title' => 'required',
            'the_post_thumbnail' => 'required'
        );
        $this->meta = array();
        $this->defautl_field = array(
            'post_title'
        );
        $this->convert = array(
            'ID',
            'post_type',
            'post_status',
            'post_content',
            'post_title',
            'post_author'
        );
    }

    /**
     * Get the JB_Data_Section_Slider instance.
     *
     * @param void
     * @return void
     * @since  1.0
     * @return \JB_Posts
     * @author Jack Bui
     */
    public static function get_instance()
    {
        if (NULL === static::$instance) {

            static::$instance = new static();
        }

        return static::$instance;
    }
    /**
     * register posttype jb_Slider
     * @param void
     * @return void
     * @since 1.0
     * @package JBTHEME
     * @category void
     * @author JACK BUI
     */
    public function  register_post_type(){
        $type_name = $this->get_post_type();
        register_post_type( $type_name, array(
            'labels'             => $this->jb_generate_label(),
            'public'             => TRUE,
            'publicly_queryable' => FALSE,
            'show_ui'            => TRUE,
            'show_in_menu'       => TRUE,
            'query_var'          => TRUE,
            'capability_type'    => 'post',
            'has_archive'        => FALSE,
            'hierarchical'       => FALSE,
            'menu_position'      => NULL,
            'supports'           => array(
                'title',
                'editor',
                'thumbnail',
                'custom-fields'
            )
        ) );
    }
}