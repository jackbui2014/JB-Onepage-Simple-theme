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
if(!function_exists('JBFilterCategories')) {
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
    function JBFilterCategories($taxonomy = 'category', $args = array(), $current = "", $custom_filter = true) {
        $terms = get_terms($taxonomy, $args);
        $search_item = get_query_var('s');
        ?>
        <div class="dropdown">
            <button class="button-dropdown-menu" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Categories
                <span class="caret"></span>
            </button>
            <ul id="accordion" class="accordion <?php echo ($custom_filter) ? 'custom-filter-query' : ''?> dropdown-menu" aria-labelledby="dLabel">
                <?php
                if(is_search()) {
                    // render link all
                    ?>
                    <li>
                        <div class="link">
                            <a href="<?php echo get_site_url() . "?s=$search_item&$taxonomy=0"; ?>" data-name="<?php echo $taxonomy; ?>" data-value="0">
                                <?php _e('All', ET_DOMAIN); ?>
                            </a>
                        </div>
                    </li>
                    <?php
                }
                foreach($terms as $term) {
                    // Get term link
                    if(is_search()) {
                        $term_link = get_site_url() . "?s=$search_item&$taxonomy=$term->term_id";
                    } else {
                        $term_link = get_term_link($term);
                    }

                    $current_term = get_term($current);
                    ?>
                    <li class="<?php echo (!is_wp_error($current_term) && $current_term->parent == $term->term_id) ? 'open active' : '';  ?>">
                        <?php
                        // Get child term
                        $child_terms = get_terms($taxonomy, array('parent' => $term->term_id));
                        ?>
                        <div class="link">
                            <a href="<?php echo $term_link; ?>" data-name="<?php echo $taxonomy; ?>" data-value="<?php echo $term->term_id ?>" class="<?php echo ($current == $term->term_id) ? 'active' : ''; ?>"><?php echo $term->name; ?>


                            </a>
                            <?php
                            if(!empty($child_terms)) :
                                echo '<i class="fa fa-chevron-right"></i>';
                            endif;
                            ?>
                        </div>

                        <?php if(!empty($child_terms)) { ?>
                            <ul class="submenu">
                                <?php
                                foreach($child_terms as $child) {
                                    // Get term link
                                    if(is_search()) {
                                        $term_link = get_site_url() . "?s=$search_item&$taxonomy=$child->term_id";
                                    } else {
                                        $term_link = get_term_link($child);
                                    }

                                    ?>
                                    <li><a href="<?php echo $term_link; ?>" data-name="<?php echo $taxonomy; ?>" data-value="<?php echo $child->term_id; ?>" class="<?php echo ($current == $child->term_id) ? 'active' : ''; ?>"><?php echo $child->name; ?></a></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        <?php } ?>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <?php
    }
}
if(!function_exists('jb_pagination')):
    /**
     * render posts list pagination link
     * @param $wp_query The WP_Query object for post list
     * @param $current if use default query, you can skip it
     * @param string $type
     * @param string $text
     * @author JACK BUI
     */
    function jb_pagination( $query, $current = '', $type = 'page', $text = '') {
        $query_var  =   array();
        /**
         * posttype args
         */
        $query_var['post_type']     =   $query->query_vars['post_type'] != ''  ? $query->query_vars['post_type'] : 'post' ;
        $query_var['post_status']   =   isset( $query->query_vars['post_status'] ) ? $query->query_vars['post_status'] : 'publish';
        $query_var['orderby']       =   isset( $query->query_vars['orderby'] ) ? $query->query_vars['orderby'] : 'date';
        // taxonomy args
        $query_var['showposts']   =   isset( $query->query_vars['showposts'] ) ? $query->query_vars['showposts'] : '';
        /**
         * order
         */
        $query_var['order']         =   $query->query_vars['order'];

        if(!empty($query->query_vars['meta_key']))
            $query_var['meta_key']      =   isset( $query->query_vars['meta_key'] ) ? $query->query_vars['meta_key'] : 'rating_score';

        $query_var  =   array_merge($query_var, (array)$query->query );
        $query_var['paginate'] = $type;
        echo '<script type="application/json" class="jb_query">'. json_encode($query_var). '</script>';

        if( ($query->max_num_pages <= 1  ) || !$type ) return ;
        $style = '';
        echo '<div class="paginations" '.$style.'>';
        if($type === 'page') {
            $big = 999999999; // need an unlikely integer
            echo paginate_links( array(
                'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format'    => '?paged=%#%',
                'current'   => max( 1, ($current) ? $current : get_query_var('paged') ),
                'total'     => $query->max_num_pages,
                'next_text' => '<i class="fa fa-angle-double-right"></i>',
                'prev_text' => '<i class="fa fa-angle-double-left"></i>',
            ) );
        }else {
            if($query->max_num_pages == $current) {
                return false;
            }

            if($text == '') {
                $text = __("Load more", ET_DOMAIN);
            }
            echo '<a id="'.$query_var['post_type'].'-inview" class="inview load-more-post" >'. $text .'</a>';
        }

        echo '</div>';

    }
endif;
