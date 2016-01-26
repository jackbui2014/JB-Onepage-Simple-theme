<?php
$about = JB_Section_Manager()->get_section('about');
if( !empty($about) ):
global $jb_post_factory, $post;
$about_obj = $jb_post_factory->get('jb_about');
$args = array(
'post_type'=>'jb_about',
'post_status'=> 'publish'
);
query_posts($args);
if( have_posts() ): ?>
<!-- About us-->
<section id="about-us" class="clearfix bgColor2">
  <div class="container">
    <div class="row">
      <div class="title-padding">
        <h2><?php echo $about->name; ?></h2><span class="line"></span>
        <p><?php echo $about->description; ?> </p>
      </div>
      <div class="content">
      <?php while( have_posts() ): the_post();
        $about = $about_obj->convert($post);
        ?>
        <div class="col-md-3 col-sm-6 col-xs-12 item-padding">
          <div class="overlay">
            <div class="img"><img src="<?php echo $about->the_post_thumbnail; ?>" alt=""/></div>
            <ul class="social">
              <li><a href="<?php echo $about->fb_url; ?>" target="_blank"><i class="fa fa-facebook fa-2x"></i></a></li>
              <li><a href="<?php echo $about->tw_url; ?>" target="_blank"><i class="fa fa-twitter fa-2x"></i></a></li>
              <li><a href="<?php echo $about->gplus_url; ?>" target="_blank"><i class="fa fa-google fa-2x"></i></a></li>
              <li><a href="<?php echo $about->website_url; ?>" target="_blank"><i class="fa fa-link fa-2x"></i></a></li>
            </ul>
          </div>
          <h3><?php echo $about->post_title; ?></h3>
          <p><?php echo $about->post_content; ?></p>
        </div>
      <?php endwhile; ?>
      </div>
    </div>
  </div>
</section>
<?php
  endif;
endif; ?>