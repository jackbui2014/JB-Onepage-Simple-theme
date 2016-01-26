<?php
/**
 * home page template
 * @package JB
 * @author JACK BUI
 */
get_header();
if ( has_nav_menu( 'primary' ) ) : ?>
    <nav id="site-navigation" class="main-navigation" role="navigation">
        <?php
        // Primary navigation menu.
        wp_nav_menu( array(
            'menu_class'     => 'nav-menu',
            'theme_location' => 'primary',
        ) );
        ?>
    </nav><!-- .main-navigation -->
<?php endif;
jb_uploader_button_html(array('echo'=>true)); ?>
<div class="post_container">
	<ul class="list_post">
		<?php 
			  global $post, $jb_post_factory;
                    $args = array(
                        'post_type' => 'post',
                        'post_status' => array( 'publish'),
                        'orderby' => 'date',
                        'order' => 'DESC'                   
                    ) ; 
                    query_posts($args);
                    if( have_posts() ){                        
                        while ( have_posts() ) {                            
                            the_post();
                            $jb_post    =   $jb_post_factory->get('post');
                            $convert    =   $jb_post->convert($post);                                                       
                            $post_arr[] =   $convert;                                                        
                        }                                               
                    }
                    wp_reset_query();
		?>
	</ul>
	<?php echo '<script type="json/data" class="" id="post_data"> ' . json_encode($post_arr) . '</script>'; ?>
	
</div>
<?php
get_footer();