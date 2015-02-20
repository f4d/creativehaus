<?php
/*
 * Template Name: about template
 */ 
get_header();

?>
<div id="container" class= "inner-content-area">
	<div class="fancy-header">
	<?php 
		if ( have_posts() ) : while( have_posts() ) : the_post();
			the_content();
		endwhile; endif; 
	?>
	</div>
  <div class="entry-content">
	
		<?php 
		$args = array(
			'post_type'=> 'soundhouse-members'
		);
		?>
		<?php query_posts( $args ); ?>
		<?php while ( have_posts() ) : the_post(); ?>
		 <div class="row post">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
				<?php
					$image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'soundhouse-members-images');
				?>
				<img src="<?php echo $image['0']; ?>" alt="post1" class="img-responsive grey"/>
			</div>
            <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
              <h4><?php  the_title(); ?></h4>
				<?php the_content(); ?>
            </div>
          </div>
         
		<?php endwhile; // End the loop. Whew. ?>
		
	</div>

</div>
	<div class="contact-info">
      <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
        <div class="address-info">
          <h1>NEED TO CONTACT US?</h1>
          <div class="col-lg-6 col-md-6 col-xs-12">
            <h2>ADDRESS</h2>
            <p>1234 MUSIC DRIVE<br/>
              SUITE 45B<br/>
              SAN DIEGO, CA 90210</p>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <h2>EMAIL US</h2>
            <p>SUPPORT@SOUNDHOUSEPROMOTIONS.COM</p>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-sm-12 col-md-2 col-xs-12">
        <div class="media">
          <ul class="social">
            <li><a href="https://www.facebook.com/pages/Soundhouse-Promotions/1411658695731249"><span class="icon-facebook"></span></a></li>
            <li><a href="https://www.youtube.com/channel/UCbx21T0l7_ttr26tZ9d2_Zw"><span class="icon-googleplus"></span></a></li>
            <li><a href="https://twitter.com/SoundHouseInc"><span class="icon-twitter"></span></a></li>
          </ul>
        </div>
      </div>
      <div class="col-lg-4 col-sm-12 col-md-4 col-xs-12"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d107382.8697437975!2d-117.14666165895346!3d32.74676613949476!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80d9530fad921e4b%3A0xd3a21fdfd15df79!2sSan+Diego%2C+CA%2C+USA!5e0!3m2!1sen!2sin!4v1406268849594" width="100%" height="200" frameborder="0" style="border:0"></iframe></div>
    </div>
<?php
get_footer();

