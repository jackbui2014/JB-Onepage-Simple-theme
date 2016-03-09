<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage MicrojobEngine
 * @since MicrojobEngine 1.0
 */
global $post;
global $wp_query, $jb_post_factory, $post;
$post_object    = $jb_post_factory->get('post');
$current        = $post_object->convert($post);
$cats = get_the_category($post->ID);
$breadcrum = '';
if( $cats ) {
    $cat_link = get_term_link($cats['0']->term_id);
    $parent = $cats['0']->parent;
    $breadcrum = '<h2><a href="' . $cat_link . '">' . $cats["0"]->name . '</a></h2>';
    if ($parent != 0) {
        $parent = get_term_by('ID', $parent, 'category');
        $parent_link = get_term_link($parent);
        $breadcrum = '<h2><a class="margin-right-10" href="'.$parent_link.'">' . $parent->name . '</a><i class="fa fa-angle-right"></i><a class="sub-caterogies margin-left-10" href="'.$cat_link.'">' . $cats['0']->name . '</a></h2>';
    }
}
get_header();
the_post();
?>
<div id="content" class="container">
    <!-- block control  -->
    <div class="row block-posts post-detail" id="post-control">
<!--        <div class="row title-top-pages">-->
<!--            <h1 class="block-title"><a href="--><?php //the_permalink(); ?><!--">--><?php //the_title() ?><!--</a></h1>-->
<!--        </div>-->
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 posts-container">
            <h1 class="margin-bottom-20"><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h1>
            <div class="breadscrums">
                <?php echo $breadcrum; ?>
            </div>
            <div class="post-excerpt margin-bottom-20 text-bold"><?php echo $current->post_excerpt; ?></div>
            <div class="post-thumb margin-bottom-20"><img attr="<?php echo $current->post_title;?>" src="<?php echo $current->the_post_thumbnail; ?>" /> </div>
            <div class="blog-wrapper">
                <div class="row">
                    <div class="blog-content">
                        <p class="author-post">Written by <?php the_author();?></p>
                        <p class="date-post"><?php the_time('M j');  ?> <sup><?php the_time('S');?></sup>, <?php the_time('Y');?></p>

                        <h2 class="title-blog">
                            <a href="<?php the_permalink(); ?>"><?php the_title() ?></a>
                        </h2><!-- end title -->
                        <div class="post-content">
                            <?php
                            the_content();
                            wp_link_pages( array(
                                'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', ET_DOMAIN ) . '</span>',
                                'after'       => '</div>',
                                'link_before' => '<span>',
                                'link_after'  => '</span>',
                            ) );
                            ?>
                        </div>
                        <div class="cmt">
                            <p><span class="text-comment">comments</span>(<?php comments_number(); ?>)</p>
                        </div><!-- end cmt count -->
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <?php comments_template(); ?>
        </div><!-- RIGHT CONTENT -->
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 blog-sidebar" id="right_content">
            <div class="menu-left">
                <p class="title-menu"><?php _e('Categories', ET_DOMAIN); ?></p>
                <?php JBFilterCategories('category', array('parent' => 0)); ?>
            </div>
        </div><!-- RIGHT CONTENT -->
    </div>
    <!--// block control  -->
</div>
<?php
get_footer();
?>