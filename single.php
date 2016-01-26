<?php
// remove blog
global $post;
get_header();

if(have_posts()) { the_post();

?>

<!-- Breadcrumb Blog -->
<div class="section-detail-wrapper breadcrumb-blog-page">
    <ol class="breadcrumb">
        <li><a href="<?php echo home_url() ?>" title="<?php echo get_bloginfo( 'name' ); ?>" ><?php _e("Home", JB_DOMAIN); ?></a></li>
        <li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
    </ol>
</div>
<!-- Breadcrumb Blog / End -->

<!-- Page Blog -->
<section id="blog-page">
	<div class="container">
    	<div class="row">
        
        	<!-- Column left -->
        	<div class="col-md-9 col-xs-12">
            
            	<div class="blog-wrapper">
                    <!-- post title -->
                	<div class="section-detail-wrapper padding-top-bottom-20">
                		<h1 class="media-heading title-blog"><?php the_title(); ?></h1>
                        <span class="time-calendar"><i class="fa fa-calendar"></i><?php the_date(); ?> </span>
                        <div class="clearfix"></div>
                    </div>
                    <!--// post title -->
                    
                    <div class="section-detail-wrapper padding-top-bottom-20">
                		<?php 
                            the_content(); 
                            the_tags( '<div class="place-meta"><span class="tag-links">', '', '</span></div>' );
                            wp_link_pages( array(
                                'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', JB_DOMAIN ) . '</span>',
                                'after'       => '</div>',
                                'link_before' => '<span>',
                                'link_after'  => '</span>',
                            ) );

                        /**
                         * get recent post  exclude current post
                        */
                        $recent_posts = wp_get_recent_posts( 
                                array( 
                                    'exclude' => array($post->ID), 
                                    'numberposts' => 5 , 
                                    'post_type' => 'post', 
                                    'post_status' => 'publish'
                                ) ,
                                OBJECT
                            );

                        ?>

                    </div>
                   
                     <?php  comments_template();
                    ?>
                    
                </div>
            </div>
            <!-- Column left / End --> 
            
            <!-- Column right -->
            <!-- Column right / End -->
		</div>
    </div>
</section>
<!-- Page Blog / End -->   

<?php
	//the_content();
}

get_footer();

