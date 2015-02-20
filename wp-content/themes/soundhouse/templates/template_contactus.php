<?php
/*
 * Template Name: Contact Us template
 */ 

get_header();
?>
<div id="container" class= "inner-content-area">
  
	  <div class="fancy-header">
	  <h1><?php the_title(); ?></h1>
	  <?php 
		if ( have_posts() ) : while( have_posts() ) : the_post();
			the_content();
		endwhile; endif; 
		
		
		global $post;
		$post_id = $post->ID;
	?>	
	</div>
        <div class="entry-content">
			<div class="contact">
            <div class="row">
              <div class="col-lg-7 col-md-7  col-sm-7">
                <div class="row">
                  <div class="col-lg-5 col-md-5 col-sm-5 col-xs-6 ">
                    <div class="address">
                      <h2>ADDRESS</h2>
                      <p><?php echo get_post_meta($post_id,'address', true); ?></p>
                    </div>
                    <div class="phone">
                      <h2>PHONE</h2>
                      <p><?php echo get_post_meta($post_id,'phone', true); ?></p>
                    </div>
                    <ul class="follow-us">
                      <li><a href="#"><span class="icon-facebook"></span></a></li>
                      <li><a href="#"><span class="icon-twitter"></span></a></li>
                      <li><a href="#"><span class="icon-googleplus"></span></a></li>
                    </ul>
                  </div>
                  <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6">
                    <div class="email-info">
                      <h2>EMAIL US</h2>
                      <p><?php echo get_post_meta($post_id,'email_us', true); ?></p>
                    </div>
                    <div class="fax-info">
                      <h2>FAX</h2>
                      <p><?php echo get_post_meta($post_id,'fax', true); ?></p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-5 col-md-5  col-sm-5">
              <div class="contact-reg">
				<?php gravity_form('1', $display_title=true, $display_description=true, $display_inactive=false, $field_values=null, $ajax=true); ?>
              </form>
              </div>
              </div>
            </div>
          </div>
        </div>
</div>

<?php
get_footer();

