<?php
global $jb_post_factory, $post;
$blog_obj = $jb_post_factory->get('post');
$args = array(
    'post_type'=>'post',
    'post_status'=> 'publish',
    'showposts'=>2
);
query_posts($args);
if( have_posts() ): ?>
<!-- Blog Section-->
<section id="blog" class="clearfix bgColor3">
  <div class="container">
    <div class="row row-padding">
      <div class="title-padding">
        <h2>blog</h2><span class="line"></span>
      </div>
      <div class="blog-list">
      <?php while( have_posts() ): the_post();
        $blog = $blog_obj->convert($post); ?>
        <div class="item col-md-6">
          <div class="img"><img src="<?php echo $blog->the_post_thumbnail; ?>" alt=""/></div>
          <h2><a href=""><?php echo $post->post_title; ?></a></h2>
            <i class="fa fa-calendar"><?php echo $blog->post_date; ?></i>
            <i class="fa fa-comments-o">200		</i><i class="fa fa-eye">3000	</i>
          <p><?php echo $post->post_excerpt; ?><a href="#">read more</a></p>
        </div>
      <?php endwhile; ?>
      </div>
      <div class="pager">
        <a href="<?php echo jb_get_page_link('list-blogs') ?>"><?php _e('View all posts >> ', JB_DOMAIN); ?></a>
<!--        <ul>-->
<!--          <li><a>prev</a></li>-->
<!--          <li class="active"><a>1</a></li>-->
<!--          <li><a>2</a></li>-->
<!--          <li><a>3</a></li>-->
<!--          <li><a>10</a></li>-->
<!--          <li><a>next</a></li>-->
<!--        </ul>-->
      </div>
    </div>
  </div>
</section>
<!-- / Blog Section-->
<?php endif; ?>