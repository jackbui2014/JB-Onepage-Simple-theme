<!-- Home Section-->
<?php
global $jb_post_factory, $post;
$slider_obj = $jb_post_factory->get('jb_slider');
$args = array(
  'post_type'=>'jb_slider',
  'post_status'=> 'publish'
);
query_posts($args);
if( have_posts() ):
  $i = 0;
?>
<div id="home">
<div id="myCarousel" class="carousel slide">
  <!-- Indicators-->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>
  <!-- Wrapper for Slides-->
  <div class="carousel-inner">
    <?php while( have_posts() ): the_post();
      $sliders = $slider_obj->convert($post);
      $cl = '';
      if( $i == 0):
        $cl = 'active';
      endif;
      ?>
    <div class="item <?php echo $cl; ?>">
      <!-- Set the first background image using inline CSS below.-->
      <div style="background-image:url('<?php echo $sliders->the_post_thumbnail;?>');" class="fill"></div>
    </div>
    <?php
      $i++;
      endwhile;
      wp_reset_query();
    ?>
  </div>
  <!-- Controls--><a href="#myCarousel" data-slide="prev" class="left carousel-control"><i class="fa fa-angle-left fa-5x"></i></a><a href="#myCarousel" data-slide="next" class="right carousel-control"><i class="fa fa-angle-right fa-5x"></i></a>
</div><i class="fa fa-chevron-circle-down fa-5x"></i>
</div>
<?php endif;
