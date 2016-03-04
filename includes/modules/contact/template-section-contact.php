<!-- Contact Section-->
<section id="contact" data-background="<?php echo TEMPLATEURL. '/images' ?>/bg-contact.jpg" class="parallax clearfix split">
  <div class="parallax-overlay bg-strip"></div>
  <div class="title-padding">
    <h2>CONTACT US</h2><i class="fa fa-paper-plane fa-3x"></i>
  </div>
  <div class="container">
    <div class="row contact-inn">
      <div class="col-md-4 item"><i class="fa fa-map-marker fa-2x"></i>
        <p>
          <Phu>Nhuan Dist., HCMC</Phu>
        </p>
      </div>
      <div class="col-md-4 item"><i class="fa fa-phone fa-2x"></i>
        <p><a href="#">0902712704</a></p>
      </div>
      <div class="col-md-4 item"><i class="fa fa-envelope fa-2x"></i>
        <p><a href="#">contact@jbprovider.com</a></p>
      </div>
    </div>
    <div class="row map-container">
      <div class="col-md-6">
        <div id="map">
          <iframe src="https://www.google.com/maps/embed?pb=!1m24!1m12!1m3!1d7838.5494841224145!2d106.7069277698037!3d10.790257037493284!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m9!1i0!3e6!4m0!4m5!1s0x317528b28e9680b3%3A0x603a6c9101ab3453!2zUGjhuqFtIFZp4bq_dCBDaMOhbmgsIHBoxrDhu51uZyAxOSwgQsOsbmggVGjhuqFuaCwgSOG7kyBDaMOtIE1pbmgsIFZpZXRuYW0!3m2!1d10.7901834!2d106.7116056!5e0!3m2!1sen!2s!4v1430476172118" width="100%" height="320px" frameborder="0" style="border:0"></iframe>
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
        <?php echo do_shortcode('[contact-form-7 id="55" title="Contact form 1"]'); ?>
      </div>
    </div>
  </div>
</section>
<!-- / Contact Section-->