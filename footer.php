<?php wp_footer();
global $jb_theme_options;
?>
<footer>
      <div class="container">
        <div class="row">
            <div class="col-md-6 pull-left">
                <?php
                $copyright = __('JB OnePage Simple theme', ET_DOMAIN);
                if( isset($jb_theme_options['copyright'] ) ):
                    $copyright = $jb_theme_options['copyright'];
                endif;
                ?>
                <p><?php echo sprintf(__('%s <a href="http://jbprovider.com">Powered by JB Provider', JB_DOMAIN), $copyright); ?></p>
            </div>
          <div class="col-md-6 pull-right">
            <ul>
              <?php if( isset($jb_theme_options['facebook_link']) ): ?>
              <li><a href="<?php echo $jb_theme_options['facebook_link']; ?>"><i class="fa fa-facebook fa-2x"></i></a></li>
              <?php endif; ?>
              <?php if( isset($jb_theme_options['twitter_link']) ): ?>
              <li><a href="<?php echo $jb_theme_options['twitter_link'] ?>"><i class="fa fa-twitter fa-2x"></i></a></li>
              <?php endif; ?>
              <?php if( isset($jb_theme_options['googleplus_link']) ): ?>
              <li><a href="<?php echo $jb_theme_options['googleplus_link']; ?>"><i class="fa fa-google-plus fa-2x"></i></a></li>
              <?php endif; ?>
              <?php   if( isset($jb_theme_options['dribble_link']) ): ?>
              <li><a href="<?php echo $jb_theme_options['dribble_link']; ?>"><i class="fa fa-dribble fa-2x"></i></a></li>
              <?php endif ?>
              <?php   if( isset($jb_theme_options['website_link']) ): ?>
              <li><a href="<?php echo $jb_theme_options['website_link']; ?>"><i class="fa fa-globe fa-2x"></i></a></li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>
    </footer>
    <!-- / footer-->
    <!-- scripts-->
  </body>
</html>