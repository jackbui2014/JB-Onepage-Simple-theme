<?php
/**
 * The template for displaying post details in a loop
 * @since 1.0
 * @package FreelanceEngine
 * @category Template
 */
global $wp_query, $jb_post_factory, $post;
$post_object    = $jb_post_factory->get('post');
$current        = $post_object->convert($post);
?>
<li class="post-item clearfix">
    <div class="image-avatar col-lg-4 col-md-4 col-sm-5 col-xs-12">
        <a href="<?php echo $current->permalink; ?>">
            <img src="<?php echo $current->the_post_thumbnail; ?>" alt="" class="img-responsive">
        </a>
    </div>
    <div class="info-items col-lg-8 col-md-8 col-sm-7 col-xs-12">
        <h2 class="post-title"><a href="<?php echo $current->permalink ?>"><?php echo $current->post_title; ?></a></h2>
        <p class="post-info">
            <i class="fa fa-user"> <?php echo $current->author_name; ?></i>
            <i class="fa fa-calendar"><?php echo $current->post_date; ?></i>
            <i class="fa fa-comments-o">200		</i><i class="fa fa-eye">3000	</i>
        </p>
        <div class="group-function">
            <?php echo $current->post_excerpt; ?>
            <a href="<?php echo $current->permalink; ?>" class="more"><?php _e('Read more', ET_DOMAIN); ?></a>
            <p class="total-comments"><?php echo $current->comment_number; ?></p>
        </div>
    </div>
</li>