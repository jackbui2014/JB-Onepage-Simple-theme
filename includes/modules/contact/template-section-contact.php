<!-- Contact Section-->
<?php
global $jb_theme_options;
$address = __('Earth', JB_DOMAIN);
if( isset($jb_theme_options['jb_address'] )){
  $address =  $jb_theme_options['jb_address'];
}
$phone = '090xxxxxx';
if( isset($jb_theme_options['phone_number'] )){
  $phone =  $jb_theme_options['phone_number'];
}
$email = 'abc@example.com';
if( isset($jb_theme_options['business_email'] )){
  $email =  $jb_theme_options['business_email'];
}
?>
<section id="contact" data-background="<?php echo TEMPLATEURL. '/images' ?>/bg-contact.jpg" class="parallax clearfix split">
  <div class="parallax-overlay bg-strip"></div>
  <div class="title-padding">
    <h2><?php _e('CONTACT US', JB_DOMAIN); ?></h2><i class="fa fa-paper-plane fa-3x"></i>
  </div>
  <div class="container">
    <div class="row contact-inn">
      <div class="col-md-4 item"><i class="fa fa-map-marker fa-2x"></i>
        <p>
          <?php echo $address;?>
        </p>
      </div>
      <div class="col-md-4 item"><i class="fa fa-phone fa-2x"></i>
        <p><?php echo $phone; ?></p>
      </div>
      <div class="col-md-4 item"><i class="fa fa-envelope fa-2x"></i>
        <p><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></p>
      </div>
    </div>
    <div class="row map-container">
      <div class="col-md-6">
        <div id="map">
          <?php $url = 'https://www.google.com/maps/embed/v1/place?key=AIzaSyA8uOZyP_tmNtj_mwAZ7twoXmHOj9rb4RU&q='.urlencode($address); ?>
          <iframe src="<?php echo $url; ?>" width="100%" height="320px" frameborder="0" style="border:0"></iframe>
        </div>
      </div>
      <div class="col-md-6">
<!--        <form role="form">-->
<!--          <div class="form-group">-->
<!--            <input type="text" placeholder="NAME" class="form-control"/>-->
<!--          </div>-->
<!--          <div class="form-group">-->
<!--            <input type="text" placeholder="EMAIL" class="form-control"/>-->
<!--          </div>-->
<!--          <div class="form-group">-->
<!--            <textarea id="message" rows="5" placeholder="MESSAGE..." class="form-control"></textarea>-->
<!--          </div>-->
<!--          <button type="submit" class="btn btn-default pull-right"><i class="fa fa-paper-plane">SEND MESSAGE</i></button>-->
<!--        </form>-->
        <?php
          $contact = '[contact-form-7 id="55" title="Contact form 1"]';
          if( isset($jb_theme_options['contact_form']) ) {
            $contact = $jb_theme_options['contact_form'];
          }
          echo do_shortcode($contact);
        ?>
      </div>
    </div>
  </div>
</section>
<!-- / Contact Section-->