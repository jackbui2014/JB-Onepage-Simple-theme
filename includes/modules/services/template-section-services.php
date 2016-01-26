<?php
$services = JB_Section_Manager()->get_section('services');
if( !empty($services) ):
  global $jb_post_factory, $post;
  $service_obj = $jb_post_factory->get('jb_services');
  $args = array(
      'post_type'=>'jb_services',
      'post_status'=> 'publish'
  );
  query_posts($args);
  if( have_posts() ):
?>
<section id="services" class="clearfix bgColor2">
  <div class="container">
    <div class="row row-padding">
      <div class="title-padding">
        <h2><?php echo $services->name; ?></h2><span class="line"></span>
        <p><?php echo $services->description;?></p>
      </div>
      <div class="owl-carousel">
      <?php while( have_posts() ): the_post();
        $service = $service_obj->convert($post); ?>
        <div class="item"><i class="fa bg <?php echo $service->post_icon.' '. $service->post_background ?>"></i>
          <h3><?php echo $service->post_title; ?></h3>
          <p><?php echo $service->post_content;?></p>
        </div>
      <?php
        endwhile;
        wp_reset_query();
      ?>
      </div>
    </div>
  </div>
</section>
<?php
  endif;
endif;