<?php
/**
 * home page template
 * @package JB
 * @author JACK BUI
 */
get_header();
global $jb_theme_options;
$sections = JB_Section_Manager()->jb_get_section_list_infor();
foreach($sections as $key => $value ){
  if( $key == 'slider') {
    $value->render();
  }
}

?>
  <div id="pageWrapper">
    <!-- Content Wrapper-->
    <div class="contentWrapper">
      <?php
        foreach($sections as $key => $value ){
          if( $key != 'slider') {
            $value->render();
          }
        }
      ?>
    </div>
  </div>
<?php
get_footer();