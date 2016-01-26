<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
class JB_Data_Section_Work extends JB_Posts
{
    public static $instance = NULL;
    public $post_type = 'jb_work';

    public function __construct($post_type = '', $taxs = array(), $meta_data = array(), $localize = array())
    {
        parent::__construct('jb_work', $taxs, $meta_data, $localize);
        $this->taxs = array('work_category');
        $this->create_rules = array(
            'post_title' => 'required',
            'post_content' => 'required'
        );
        $this->meta = array();
        $this->defautl_field = array(
            'post_title',
            'post_content'
        );
        $this->convert = array(
            'ID',
            'post_type',
            'post_status',
            'post_content',
            'post_title',
            'post_author',
            'work_category_slug'
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
    /**
     * Register taxonomies for this post type
     *
     * @param void
     * @return void
     * @since 1.0
     * @package JBTHEME
     * @category void
     * @author JACK BUI
     */
    public  function  register_taxonomy(){
        $labels = $this->jb_generate_tax_label('work category');
        $args = array(
            'labels' => $labels,
            'public' => true,
            'show_in_nav_menus' => true,
            'show_admin_column' => true,
            'hierarchical' => true,
            'show_tagcloud' => true,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array(
                'slug' => jb_get_option('work_category_slug', 'work_category') ,
                'hierarchical' => jb_get_option('work_category_hierarchical', false)
            ) ,
            'capabilities' => array(
                'manage_terms',
                'edit_terms',
                'delete_terms',
                'assign_terms'
            )
        );
        register_taxonomy('work_category', array('jb_work') , $args);
    }
    /**
     * Override convert function
     *
     * @param void
     * @return void
     * @since 1.0
     * @package JBTHEME
     * @category void
     * @author JACK BUI
     */
    public  function convert($post_data = array(), $thumbnail = 'medium_post_thumbnail', $excerpt = true, $singular = false){
        $data = parent::convert($post_data, $thumbnail, $excerpt, $singular );
        $data->work_category_slug = '';
        $cat_list = $data->tax_input['work_category'];
        if( !empty($cat_list) ){
            foreach($cat_list as $key => $cat ){
                $data->work_category_slug .= $cat->slug.' ';
            }
        }
        return $data;

    }
}