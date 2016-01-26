<?php
$work = JB_Section_Manager()->get_section('work');
if( !empty($work) ):
  global $jb_post_factory, $post;
  $work_obj = $jb_post_factory->get('jb_work');
  $args = array(
      'post_type'=>'jb_work',
      'post_status'=> 'publish'
  );
  query_posts($args);
  if( have_posts() ):
?>
<section id="work" class="clearfix bgColor3">
  <div class="container">
    <div class="row row-padding">
      <div class="title-padding">
        <h2><?php echo $work->name; ?></h2><span class="line"></span>
        <p><?php echo $work->description; ?></p>
      </div>
    </div>
  </div>
  <div class="work-list clearfix">
    <div class="button-group filter-button-group">
      <button data-filter="*"><?php _e('ALL', JB_DOMAIN); ?></button>
      <?php
      $terms = get_terms('work_category', 'orderby=count');
      if( !empty($terms) ) {
        foreach ($terms as $key => $term) {
          ?>
          <button data-filter=".<?php echo $term->slug; ?>"><?php echo $term->name; ?></button>
        <?php }
        }
        ?>
    </div>
    <div class="grid">
    <?php while( have_posts() ): the_post();
      $work = $work_obj->convert($post);
      ?>
      <div class="element-item <?php echo $work->work_category_slug; ?>">
        <figure class="effect-layla"><img alt="" src="<?php echo $work->the_post_thumbnail; ?>"/>
          <figcaption>
            <h2><?php echo $work->post_title; ?></h2>
            <p><?php echo $work->post_content; ?> </p>
          </figcaption>
        </figure>
      </div>
    <?php endwhile; ?>
    </div>
  </div>
</section>
<?php
  endif;
endif;
?>