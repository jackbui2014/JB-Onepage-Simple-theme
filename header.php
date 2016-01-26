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
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <?php wp_head() ?>
    <title>JB Template</title>
    <!-- Bootstrap Core CSS-->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries-->
    <!-- WARNING: Respond.js doesn't work if you view the page via file://-->
    <!--if lt IE 9
    script(src='https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js')
    script(src='https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js')
    -->
  </head>
  <body>
    <!-- Header-->
    <header>
      <!-- Static navbar-->
      <?php if ( has_nav_menu( 'primary' ) ) : ?>
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar" class="navbar-toggle collapsed"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><a href="#" class="navbar-brand"><img src="<?php echo TEMPLATEURL ?>/images/logo.png" alt="logo"/></a>
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