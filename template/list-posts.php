<?php
global $wp_query, $jb_post_factory, $post;
$post_object = $jb_post_factory->get('post');
$postdata    = array();
if(have_posts()){
    ?>
    <!-- blog list -->
    <ul class="post-list list_post" id="post-list">
        <?php
        while(have_posts()) { the_post();
            $convert    = $post_object->convert($post);
            $postdata[] = $convert;
            get_template_part('template/post', 'item');
        }
        /**
         * render post data for js
         */
        echo '<script type="data/json" class="postdata" >'.json_encode($postdata).'</script>';
        ?>
    </ul>
    <!--// blog list  -->
    <!-- pagination -->
    <?php
    echo '<div class="paginations-wrapper">';
    jb_pagination($wp_query, get_query_var('paged'));
    echo '</div>';
} else {
    _e( 'No posts yet!', ET_DOMAIN );
}
?>
<!--// pagination -->