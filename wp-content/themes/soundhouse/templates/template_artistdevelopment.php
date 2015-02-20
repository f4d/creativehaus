<?php
/*
 * Template Name: Artist Development
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
          <div class="contact-information row">
            <div class="col-lg-4 col-md-4 col-xs-12">
              <div class="top-image">
				<?php
					$image = get_field('contact_image');
					if( !empty($image) ): ?>
						<img src="<?php echo $image['url']; ?>" alt="message" />
					<?php endif; 
					?>
				<img src="<?php echo site_url();?>/wp-content/uploads/2014/07/direction.png" alt="direction" class="driecimg"/></div>
              <div class="description">
                <h2>Contact Us</h2>
                <p> <?php  the_field ('contact_us_text'); ?></p>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-xs-12">
              <div class="top-image">
				<?php
					$image = get_field('one-on-one_image');
					if( !empty($image) ): ?>
						<img src="<?php echo $image['url']; ?>" alt="message" />
					<?php endif; 
					?>
				<img src="<?php echo site_url();?>/wp-content/uploads/2014/07/direction.png" alt="direction" class="driecimg"/></div>
              <div class="description">
                <h2>Setup a one-on-one
                  with Michael Britton</h2>
                <p> <?php  the_field ('one-on-one_text'); ?></p>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-xs-12">
				<?php
					$image = get_field('learn_how_to_take_your_music_image');
					if( !empty($image) ): ?>
						<img src="<?php echo $image['url']; ?>" alt="message" />
					<?php endif; 
					?>
              <div class="description">
                <h2>Learn How to Take Your
                  Music to the Next Level</h2>
                <p> <?php  the_field ('learn_how_to_take_your_music_text'); ?></p>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-xs-12 get-form artist-development">
              <?php gravity_form('2', $display_title=true, $display_description=true, $display_inactive=false, $field_values=null, $ajax=true); ?>
            </div>
          </div>
        </div>
   
       
	
</div>

<?php
get_footer();
