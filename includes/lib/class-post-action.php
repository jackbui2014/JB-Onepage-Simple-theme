<?php
class JB_PostAction extends JB_Base{
    public static $instance;
    /**
     * getInstance method
     *
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    /**
     * the constructor of this class
     *
     */
    public  function __construct($post_type = 'post'){
        $this->post_type = $post_type;
    }
    /**
     * init
     *
     * @param void
     * @return void
     * @since 1.0
     * @package JBTHEME
     * @category void
     * @author JACK BUI
     */
    public function init(){
        $this->add_ajax( 'jb-fetch-posts', 'fetch_posts' );
    }
    /**
     * ajax callback fetch post
     *
     * @author  Jack Bui
     * @version 1.0
     */
    public function fetch_posts() {
        global $jb_post_factory;
        $post = $jb_post_factory->get($this->post_type);

        $page = $_REQUEST['page'];
        extract($_REQUEST);
        $thumb = isset($_REQUEST['thumbnail']) ? $_REQUEST['thumbnail'] : 'thumbnail';
        $query_args = array(
            'paged' => $page,
            'thumbnail' => $thumb,
            'post_status' => 'publish',
            'post_type' => $this->post_type
        );
        // check args showposts
        if (isset($query['showposts']) && $query['showposts']) $query_args['showposts'] = $query['showposts'];
        if (isset($query['posts_per_page']) && $query['posts_per_page']) $query_args['posts_per_page'] = $query['posts_per_page'];
        $query_args = $this->filter_query_args($query_args);
        /**
         * filter fetch post query args
         * @param Array $query_args
         * @param object $this
         * @since 1.2
         * @author Dakachi
         */
        $query_args = apply_filters( 'jb_fetch_'.$this->post_type . '_args' , $query_args, $this );
        if (isset($query['category_name']) && $query['category_name']) $query_args['category_name'] = $query['category_name'];
        //check query post parent
        if (isset($query['post_parent']) && $query['post_parent'] != '') {
            $query_args['post_parent'] = $query['post_parent'];
        }

        //check query author
        if (isset($query['author']) && $query['author'] != '') {
            $query_args['author'] = $query['author'];
        }
        if (isset($query['s']) && $query['s']) {
            $query_args['s'] = $query['s'];
        }

        /**
         * fetch data
         */
        $data = $post->fetch($query_args);
        if(isset($_REQUEST['text'])) {
            $load_more_text = $_REQUEST['text'];
        } else {
            $load_more_text = "";
        }
        jb_pagination($data['query'], $page, $_REQUEST['paginate'], $load_more_text);
        $paginate = ob_get_clean();
        /**
         * send data to client
         */
        if (!empty($data)) {
            wp_send_json(array(
                'data' => $data['posts'],
                'paginate' => $paginate,
                'msg' => __("Successs", ET_DOMAIN) ,
                'success' => true,
                'max_num_pages' => $data['max_num_pages'],
                'total' => $data['query']->found_posts
            ));
        } else {
            wp_send_json(array(
                'success' => false,
                'data' => array()
            ));
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
}