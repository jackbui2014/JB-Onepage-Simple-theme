<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * This is post class controler
 *
 *
 * @since  1.0
 *
 * @author Jack Bui
 */
class JB_Posts extends JB_Base {
	private static $instance = NULL;
	public $meta;
	public $default_field = array(
		'post_title'
		);

	/**
	 * store instance current after converted post data
	 */
	public $current_post;
	public $current_main_post;
	public $wp_query;
	protected $create_rules = array();
	protected $update_rules = array(
        'ID'=>'required',
        'post_type' => 'required'
        );
	protected $validateErrorMessage = array();
	/**
	 * get the instance.
	 *
	 * @since  1.00
	 *
	 * @return \JB_Post
	 *
	 * @author Jack Bui
	 */
	public static function get_instance() {
		if ( static::$instance == NULL ) {
			static::$instance = new static();
		}

		return static::$instance;
	}
	public function __construct($post_type = '', $taxs = array() , $meta_data = array() , $localize = array()) {
        
        $post_type = ($post_type) ? $post_type : 'post';
        if ($post_type == 'post' && empty($taxs)) {
            $taxs = array(
                'tag',
                'category'
            );
        }
        
        $this->post_type = $post_type;
        $this->taxs = apply_filters('jb_post_taxs', $taxs, $post_type);
        $defaults = array(
            'address',
            'avatar',
            'post_count',
            'comment_count',
            'featured_image',           
        );
        $this->meta = apply_filters('jb_post_meta_fields', wp_parse_args($meta_data, $defaults) , $post_type);
        
        /**
         * setup convert field of post data
         */
        $this->convert = array(
            'post_parent',
            'post_title',
            'post_name',
            'post_content',
            'post_excerpt',
            'post_author',
            'post_status',
            'ID',
            'post_type',
            'comment_count',
            'guid',
            'tax_input',
            'author_name'
        );
        
        $this->localize = $localize;
    }
	public function init() {
		$this->add_ajax( 'jb-sync-post', 'sync_post' );
	}
    /**
     * Generate the post label for register custom posttype.
     *
     * @since  1.0
     *
     * @param $type_name
     * @return array
     * @author JackBui
     */
    public function jb_generate_label(  ) {
        $type_name = $this->post_type;
        $type_name_upper = ucfirst( $type_name );
        $label           = array(
            'name'               => $type_name_upper,
            'singular_name'      => $type_name_upper,
            'add_new'            => __( 'Add New', JB_DOMAIN ),
            'add_new_item'       => sprintf( __( 'Add New %1$s', JB_DOMAIN ), $type_name_upper ),
            'edit_item'          => sprintf( __( 'Edit %1$s', JB_DOMAIN ), $type_name_upper ),
            'new_item'           => sprintf( __( 'New %1$s', JB_DOMAIN ), $type_name_upper ),
            'all_items'          => sprintf( __( 'All %1$ss', JB_DOMAIN ), $type_name_upper ),
            'view_item'          => sprintf( __( 'View %1$s', JB_DOMAIN ), $type_name_upper ),
            'search_items'       => sprintf( __( 'Search %1$s', JB_DOMAIN ), $type_name_upper ),
            'not_found'          => sprintf( __( 'No %1$s found', JB_DOMAIN ), $type_name_upper ),
            'not_found_in_trash' => sprintf( __( 'No %1$ss found in Trash', JB_DOMAIN ), $type_name_upper ),
            'parent_item_colon'  => '',
            'menu_name'          => $type_name_upper
        );

        return $label;
    }
    /**
     * Generate the post label for register custom posttype.
     *
     * @since  1.0
     *
     * @param $type_name
     * @return array
     * @author JackBui
     */
    public function jb_generate_tax_label( $type_name) {
        $type_name_upper = ucfirst( $type_name );
        $labels = array(
            'name' => $type_name_upper,
            'singular_name' => $type_name_upper ,
            'search_items' => sprintf(__('Search %s', JB_DOMAIN), $type_name_upper) ,
            'popular_items' => sprintf(__('Popular %s', JB_DOMAIN), $type_name_upper) ,
            'all_items' => sprintf(__('All %s', JB_DOMAIN), $type_name_upper) ,
            'parent_item' => sprintf(__('Parent %s', JB_DOMAIN), $type_name_upper) ,
            'parent_item_colon' => sprintf(__('Parent %s', JB_DOMAIN), $type_name_upper),
            'edit_item' => sprintf(__('Edit %s', JB_DOMAIN), $type_name_upper),
            'update_item' => __('Update Project Category', JB_DOMAIN),
            'add_new_item' => sprintf(__('Add New %s', JB_DOMAIN), $type_name_upper),
            'new_item_name' => sprintf(__('New %s Name', JB_DOMAIN), $type_name_upper) ,
            'add_or_remove_items' => sprintf(__('Add or remove %s', JB_DOMAIN), $type_name_upper),
            'choose_from_most_used' => __('Choose from most used jbtheme', JB_DOMAIN) ,
            'menu_name' => sprintf(__('%s', JB_DOMAIN), $type_name_upper) ,
        );

        return $labels;
    }
    /**
     * Register posttype.
     *
     * @since  1.0
     *
     * @return void
     *
     * @author Jack Bui
     */
    public function jb_register_post_type() {
        global $jb_post_factory;
        $post_objects = $jb_post_factory->get_all();
        if ( $post_objects != NULL ) {
            foreach ( $post_objects as $key => $post_object ) {
                if ( method_exists( $post_object, 'register_post_type' ) && $key != 'post') {
                    $post_object->register_post_type();
                }
                if ( method_exists( $post_object, 'register_taxonomy' ) ) {
                    $post_object->register_taxonomy();
                }
            }
        }
    }
    /**
     * Return this posttype
     *
     * @param void
     * @return void
     * @since 1.0
     * @package JBTHEME
     * @category void
     * @author JACK BUI
     */
    public function get_post_type(){
        return $this->post_type;
    }
	/**
	 * Sync post after change.
	 *
	 * @since  1.0
	 *
	 * @return void
	 *
	 * @author Jack Bui
	 */
	public function sync_post($request) {
		if(!is_array($request) ){
			$request = $_REQUEST;
		}		
        extract($request); 
        switch ($method) {
            case 'create':
                $result = $this->insert($request);
                break;
            case 'update':
                $result = $this->update($request);                
                break;

            case 'remove':
                $result = $this->delete($request['ID']);
                break;

            case 'read':
                $result = $this->get($request['ID']);
                break;

            default:
                return new WP_Error('invalid_method', __("Invalid method", JB_DOMAIN));
        }   
        if ($result != false && !is_wp_error($result)) {
            $response = array(
                'msg'=>'success',
                'success'=> 'success',
                'data'=>$result
                )    ;
        }
        else{
            $response = array(
                'msg'=>'failed',
                'success'=> 'error',
                'data'=>$result->get_error_message()
                )    ;
        }
        wp_send_json($response);
	}

    /**
     * fetch postdata from database, use function convert
     * @param array $args query options, see more WP_Query args
     * @return array of objects post
     * @author Dakachi
     * @since 1.0
     */
    public function fetch($args) {

        $args['post_type'] = $this->post_type;
        if (isset($args['radius']) && $args['radius']) {
            $query = $this->nearbyPost($args);
        } else {
            $query = new WP_Query($args);
        }
        $data = array();

        $thumb = isset($args['thumbnail']) ? $args['thumbnail'] : 'thumbnail';
        // loop post
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                global $post;

                // convert post data
                $data[] = $this->convert($post, $thumb);
            }
        }
        if (!empty($data)) {

            /**
             * return array of data if success
             */
            return array(
                'posts' => $data,

                // post data
                'post_count' => $query->post_count,

                // total post count
                'max_num_pages' => $query->max_num_pages,

                // total pages
                'query' => $query

                // wp_query object


            );
        } else {
            return false;
        }
    }
    /**
     * filter query args
     *
     * @param array $query_args
     * @return void
     * @since 1.0
     * @package JBTHEME
     * @category void
     * @author JACK BUI
     */
    function filter_query_args($query_args) {
        return $query_args;
    }
	/**
	 * Insert post 
	 *
	 * @param array $args argument of post
     * @return mixed $validate_data of $args
	 * @author Jack Bui
	 */
	public function insert($args = array()){
		 global $current_user, $user_ID;             
        foreach ($args as $key => $value) {
            if ((in_array($key, $this->meta) || in_array($key, $this->convert)) && is_string($args[$key]) && $key != 'post_content') {
                $args[$key] = strip_tags($args[$key]);
            }
        }
		$validated_data = $this->prepare_data($args, $this->create_rules);
        if ( is_wp_error( $validated_data ) ) {
			return $validated_data;
		}
		$args = $validated_data;		
        // pre filter filter post args
        $args = apply_filters('jb_pre_insert_' . $this->post_type, $args);
        if (is_wp_error($args)) return $args;
        
        $args = wp_parse_args($args, array(
            'post_type' => $this->post_type
        ));
        
       	//set post status to pending
        $pending = jb_get_option('use_pending_'.$this->post_type, false); 
        if( $pending ){
        	$args['post_status'] = 'pendding';
        }
        if (!isset($args['post_status'])) {
            $args['post_status'] = 'draft';
        }
        
        // could not create with an ID
        if (isset($args['ID'])) {
            return new WP_Error('invalid_data', __("The ID already existed!", JB_DOMAIN));
        }
        
        if (!isset($args['post_author']) || empty($args['post_author'])) $args['post_author'] = $current_user->ID;
        
        if ( empty( $args['post_author'] ) ) return new WP_Error('missing_author', __('You must login to submit listing.', JB_DOMAIN));
        
        // filter tax_input
        $args = $this->_filter_tax_input($args);
        
        // filter post content strip invalid tag
        if(  isset($args['post_content']) ){
        	$args['post_content'] = $this->filter_content($args['post_content']);
    	}
        
        /**
         * insert post by wordpress function
         */       		
        $result = wp_insert_post($args, true);        
        /**
         * update custom field and tax
         */
        if ($result != false && !is_wp_error($result)) {
            $this->update_custom_field($result, $args);
            $args['ID'] = $result;
            $args['id'] = $result;
            
            /**
             * do action jb_insert_{$this->post_type}
             * @param Int $result Inserted post ID
             * @param Array $args The array of post data
             */
            do_action('jb_insert_' . $this->post_type, $result, $args);
            
            $result = (object)$args;
            
            /**
             * do action jb_insert_post
             * @param object $args The object of post data
             */
            do_action('jb_insert_post', $result);
            
            // localize text for js
            if (!empty($this->localize)) {
                foreach ($this->localize as $key => $localize) {
                    $a = array();
                    foreach ($localize['data'] as $loc) {
                        array_push($a, $result->$loc);
                    }
                    
                    $result->$key = vsprintf($localize['text'], $a);
                }
            }
            $result->permalink = get_permalink($result->ID);
            
            if (current_user_can('manage_options') || $result->post_author == $user_ID) {
                
                /**
                 * featured image not null and should be in carousels array data
                 */
                if (isset($args['featured_image']) && $args['featured_image'] != '') {
                    set_post_thumbnail($result->ID, $args['featured_image']);
                }
            }
        }
        
        return $result;
	}
	/**
	 * update post 
	 *
	 * @param array $args argument of post
     * @return
	 * @author Jack Bui
	 */
	public function update($args) {        
        global $current_user, $user_ID;
             
        foreach ($args as $key => $value) {
            if ((in_array($key, $this->meta) || in_array($key, $this->convert)) && is_string($args[$key]) && $key != 'post_content') {
                $args[$key] = strip_tags($args[$key]);
            }
        }       
        $validated_data = $this->prepare_data($args, $this->update_rules);
        if ( is_wp_error( $validated_data ) ) {
			return $validated_data;
		}        
		$args = $validated_data;        
        // unset post date
        if (isset($args['post_date'])) unset($args['post_date']);
        
        // filter args
        $args = apply_filters('jb_pre_update_' . $this->post_type, $args);        
        if (is_wp_error($args)) return $args;       
        // if missing ID, return errors        
        if (empty($args['ID'])) return new WP_Error('jb_missing_ID', __('Post not found!', JB_DOMAIN));       
        if (!current_user_can( 'edit_others_posts' )) {
            $post = get_post($args['ID']);
            if ($post->post_author != $user_ID) {
                return new WP_Error('permission_deny', __('You can not edit other posts!', JB_DOMAIN));
            }
            
            /**
             * check and prevent user publish post
             */
            if (isset($args['post_status']) && $args['post_status'] != $post->post_status && $args['post_status'] == 'publish') {
                unset($args['post_status']);
            }
            
            // unset($args['et_featured']);
            
        }                              
        $args = $this->_filter_tax_input($args);        
        // filter post content strip invalid tag
        if( isset($args['post_content']) ){
        	$args['post_content'] = $this->filter_content($args['post_content']);
    	}
        
        // update post data into database use wordpress function                  
        $result = wp_update_post($args, true);
                
        // catch event reject post
        if (isset($args['post_status']) && $args['post_status'] == 'reject' && isset($args['reject_message'])) {
            do_action('jb_reject_post', $args);
        }
        
        /**
         * update custom field and tax
         */

        if ($result != false && !is_wp_error($result)) {
            $this->update_custom_field($result, $args);            
            $post = get_post($result);               
            if (current_user_can('manage_options') || $post->post_author == $user_ID) {            
                /**
                 * featured image not null and should be in carousels array data
                 */                
                if ( isset( $args['featured_image'] ) && $args['featured_image'] != '') {                  
                    set_post_thumbnail( (int)$post->ID, (int)$args['featured_image']);                    
                }
            }                   
            // make an action so develop can modify it
            do_action('jb_update_' . $this->post_type, $result, $args);            
            $result = $this->convert($post);            
        }       
        return $result;
    }
	/**
	 * delete post 
	 *
	 * @param array $args argument of post
     * @return integer post result or false
	 * @author Jack Bui
	 */
	public function delete($ID, $force_delete = false) {
        
        if (!current_user_can('edit_others_posts')) {
            global $user_ID;
            $post = get_post($ID);
            if ($user_ID != $post->post_author) {
                return new WP_Error('permission_deny', __("You do not have permission to delete post.", JB_DOMAIN));
            }
        }
        
        if ($force_delete) {
            $result = wp_delete_post($ID, true);
        } else {
            $result = wp_trash_post($ID);
        }
        if ($result) do_action('jb_delete_' . $this->post_type, $ID);
        
        return $this->convert($result);
    }
    /**
	 * get post 
	 *
	 * @param array $args argument of post
     * @param mixed $post object
	 * @author Jack Bui
	 */
    public function get($ID) {
        $result = $this->convert(get_post($ID));
        return $result;
    }
    /**
	 * Convert post 
	 *
	 * @param array $args argument of post
     * @return mixed post after convert
	 * @author Jack Bui
	 */
    public function convert($post_data = array(), $thumbnail = 'medium_post_thumbnail', $excerpt = true, $singular = false) {
        $result = array();
        $post = (array)$post_data;        
        /**
         * convert need post data
         */
        foreach ($this->convert as $key) {
            if (isset($post[$key])) $result[$key] = $post[$key];
        }
        
        // array statuses
        $status = array(
            'reject' => __("REJECTED", JB_DOMAIN) ,
            'archive' => __("ARCHIVED", JB_DOMAIN) ,
            'pending' => __("PENDING", JB_DOMAIN) ,
            'draft' => __("DRAFT", JB_DOMAIN) ,
            'publish' => __("ACTIVE", JB_DOMAIN) ,
            'trash' => __("TRASHED", JB_DOMAIN)
        );
        
        $result['status_text'] = isset($status[$result['post_status']]) ? $status[$result['post_status']] : '';
        
        $result['post_date'] = get_the_date('', $post['ID']);
        
        // generate post taxonomy
        if (!empty($this->taxs)) {
            
            foreach ($this->taxs as $name) {
                $terms = wp_get_object_terms($post['ID'], $name);
                $arr = array();
                if (is_wp_error($terms)) continue;
                
                foreach ($terms as $term) {
                    $arr[] = $term->term_id;
                }
                $result[$name] = $arr;
                $result['tax_input'][$name] = $terms;
            }
        }        
        $meta = apply_filters('jb_' . $this->post_type . '_convert_metadata', $this->meta, $post, $singular);        
        // generate meta data
        if (!empty($meta)) {
            foreach ($meta as $key) {
                $result[$key] = get_post_meta($post['ID'], $key, true);
            }
        }
        
        if (!empty($this->localize)) {
            foreach ($this->localize as $key => $localize) {
                $a = array();
                foreach ($localize['data'] as $loc) {
                    array_push($a, $result[$loc]);
                }
                
                $result[$key] = vsprintf($localize['text'], $a);
            }
        }
        
        unset($result['post_password']);
        $result['id'] = $post['ID'];
        $result['permalink'] = get_permalink($result['ID']);
        $result['unfiltered_content'] = $result['post_content'];
        
        /**
         * get post content in loop
         */
        ob_start();
        echo apply_filters('the_content', $result['post_content']);
        $the_content = ob_get_clean();
        
        $result['post_content'] = $the_content;
        
        /* set post excerpt */
        if (isset($result['post_excerpt']) && $result['post_excerpt'] == '') {
            $result['post_excerpt'] = wp_trim_words($the_content, 20);
        }
        
        /**
         * return post thumbnail url
         */
        if (has_post_thumbnail($result['ID'])) {
            $result['featured_image'] = get_post_thumbnail_id($result['ID']);
            $feature_image = wp_get_attachment_image_src($result['featured_image'], $thumbnail);
            $result['the_post_thumnail'] = $feature_image['0'];
        } else {
            $result['the_post_thumnail'] = '';
            $result['featured_image'] = '';
        }
        $result['the_post_thumbnail'] = $result['the_post_thumnail'];
        $result['author_name'] = get_the_author_meta('display_name', $result->post_author);
        /**
         * assign convert post to current post
         */        
        $result = apply_filters('jb_convert_' . $this->post_type, (object)$result);                   
        return $result;
    }
	/**
     * filter tax input args and check existed
     * @since 1.0
     * @author Jack Bui
     * @return array
     */	
    function _filter_tax_input($args) {
        $args['tax_input'] = array();        
        if (!empty($this->taxs)) {
            foreach ($this->taxs as $tax_name) {
                if (is_taxonomy_hierarchical($tax_name)) {
                    if (isset($args[$tax_name]) && !empty($args[$tax_name])) {
                        
                        /**
                         * check term existed
                         */
                        if (is_array($args[$tax_name])) {
                            
                            // if tax input is array
                            foreach ($args[$tax_name] as $key => $value) {
                                $term = get_term_by('id', $value, $tax_name);
                                if (!$term) {
                                    unset($args[$tax_name][$key]);
                                }
                            }
                        } else {
                            
                            // if tax input ! is array
                            $term = get_term_by('id', $args[$tax_name], $tax_name);
                            if (!$term) {
                                unset($args[$tax_name]);
                            }                            
                        }
                        
                        // check term exist
                        
                        /**
                         * assign tax input
                         */
                        if (isset($args[$tax_name]) ) {
                            $args['tax_input'][$tax_name] = $args[$tax_name];
                        }
                    } else {
                        unset($args['tax_input'][$tax_name]);
                    }
                } else {
                    
                    /**
                     * assign tax input
                     */
                    if (isset($args[$tax_name])) {
                        if (is_array($args[$tax_name])) {
                            $temp = array();
                            foreach ($args[$tax_name] as $key => $value) {
                                if (isset($value['name'])) {
                                    $temp[] = $value['name'];
                                }
                            }
                            $args['tax_input'][$tax_name] = $temp;
                        } else {
                            $args['tax_input'][$tax_name] = $args[$tax_name];
                        }
                    } else {
                        unset($args['tax_input'][$tax_name]);
                    }
                }
            }
        }        
        return $args;
    }
    
    /**
     * filter content insert and skip invalid tag
     * @param string $content the post content be filter
     * @return String the string filtered
     * @author Jack Bui
     * @since 1.0
     */
    function filter_content($content) {
        $pattern = "/<[^\/>]*>(&nbsp;)*([\s]?)*<\/[^>]*>/";
        
        //use this pattern to remove any empty tag '<a target="_blank" rel="nofollow" href="$1">$3</a>'
        
        $content = preg_replace($pattern, '', $content);
        
        // $link_pattern = "/<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>/";
        $content = str_replace('<a', '<a target="_blank" rel="nofollow"', $content);
        $content = strip_tags($content, '<p><a><ul><ol><li><h6><span><b><em><strong><br>');
        
        return $content;
    }	
    /**
     * Update post custom field
     *  
     * @author Jack Bui
     */
    public function update_custom_field($result, $args) {        
        // update post meta
        if (!empty($this->meta)) {
            foreach ($this->meta as $key => $meta) {                               
                if (isset($args[$meta])) {
                    if (!is_array($args[$meta])) {
                        $args[$meta] = esc_attr($args[$meta]);
                    }
                    update_post_meta($result, $meta, $args[$meta]);
                }
            }
        }       
    }
    /**
	 * prepare data for save into database.
	 *
	 * @since    1.0
	 *
	 * @param array $data
	 *
	 * @return \stdClass|\WP_Error
	 *
	 * @author   Jack Bui
	 */
	public function prepare_data( $datas, $rulers ) {
		//Validate post data
		$validator = new JB_Validator( $datas, $rulers, array(), $this->validateErrorMessage);
		if ( $validator->fails() ) {
			return new WP_Error( 'input_not_valid', __( 'The value you inserted is not correct.',JB_DOMAIN), $validator->getMessages() );
		}
		//Get all valid field
		$post_data = $validator->valid();                
		//Get allowed field
        $post_field = wp_parse_args( $this->meta, $this->default_field );
        $post_field = wp_parse_args($this->convert, $post_field);   
        $post_field = wp_parse_args($this->taxs, $post_field) ;
		$post_field = array_flip( $post_field );              
		$post_data  = array_intersect_key( $post_data, $post_field );        
		// strip tags
		foreach ( $post_data as $key => $value ) {
			if ( is_string( $post_data[ $key ] ) ) {
				if ( 'post_content' === $key ) {
					// filter post content strip invalid tag
					$post_data[ 'post_content' ] = $this->filter_content( $value );
					$post_data[ 'post_excerpt' ] =  wp_trim_words( $value, 10 );
				} else {
					$post_data[ $key ] = strip_tags( $value );
				}
			}
		}

		$post_data = wp_parse_args( $post_data, array(
			'post_type' => $this->post_type
		) );
		//
		$post_data[ 'post_author' ] = $this->prepare_post_author( $post_data );
		// filter tax_input
		$post_data = $this->_filter_tax_input( $post_data );
		$post_data = apply_filters( 'jb_pre_insert_' . $this->post_type, $post_data );       
		return $post_data;
	}

	/**
	 * prepare for author data.
	 *
	 * @since    1.0
	 *
	 * @param $post_data
	 * @return mixed $post_data
	 * @author   Jack Bui
	 */
	public function prepare_post_author( $post_data ) {
		$post_type = get_post_type_object( $this->post_type );
		if ( ! isset( $post_data[ 'post_author' ] ) || empty( $post_data[ 'post_author' ] ) ) {
			if ( is_user_logged_in() ) {
				$post_data[ 'post_author' ] = get_current_user_id();
			} else {
				$post_data[ 'post_author' ] = - 1;
			}
		}

		return $post_data[ 'post_author' ];
	}
}
/**
 * class JB_PostFact
 * factory class to generate  post object
 */
class JB_PostFact
{
    
    static $objects;
    function __construct() {
        self::$objects = array(
            'post' => JB_Posts::get_instance()
        );
    }
    /**
     * set a post type object to machine
     * @param String $post_type
     * @param JB_Post object $object
     */
    public function set($post_type, $object) {
        self::$objects[$post_type] = $object;
    }
    
    /**
     * get post type object in class object instance
     * @param String $post_type The post type want to use
     * @return Object
     */
    public function get($post_type) {
        if (isset(self::$objects[$post_type])) return self::$objects[$post_type];
        return null;
    }
    public function get_all(){
		if ( isset( self::$objects ) ) {
			return self::$objects;
		}

		return NULL;
	}
}
/**
 * set a global object factory
 */
global $jb_post_factory;
$jb_post_factory = new JB_PostFact();
$jb_post_factory->set('post', new JB_Posts('post'));
