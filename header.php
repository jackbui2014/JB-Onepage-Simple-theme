<?php
/**
 * This is header for all template
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @since 1.0
 *
 * @package JBTHEME
 *
 * @author: JACK BUI
 */
// global $jb_theme_options, $ReduxFramework;
// var_dump($jb_theme_options['header_support_email'] );
// $ReduxFramework->set('test_option', 'test thui nhe');
// var_dump($jb_theme_options['test_option'] );
// exit;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php global $user_ID; ?>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1 ,user-scalable=no">
  <title><?php wp_title( '|', true, 'right' ); ?></title>
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
  <?php jb_favicon(); ?>
  <?php
  wp_head();
  ?>
</head>
  <body>
    <!-- Header-->
    <header>
      <!-- Static navbar-->
      <?php if ( has_nav_menu( 'primary' ) ) : ?>
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar" class="navbar-toggle collapsed">
              <span class="sr-only"><?php _e('Toggle navigation', JB_DOMAIN); ?></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span><span class="icon-bar"></span>
            </button>
            <a href="<?php echo home_url();?>" class="navbar-brand"><?php jb_Logo() ?></a>
          </div>
          <div id="navbar" class="navbar-collapse collapse cl-effect-3">
            <?php
             //Primary navigation menu.
            wp_nav_menu( array(
                'menu_class'     => 'nav navbar-nav navbar-right nav-scroll',
                'theme_location' => 'primary',
                'container'=> 'none'
            ) );
            ?>
          </div>
          <!-- /.nav-collapse-->
        </div>
        <!-- /.container-fluid-->

      </nav>
      <?php endif; ?>
    </header>