<?php
/*
 * Template Name: Sponsors template
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
				<div class="sponsors-list text-center">
				
						<?php 
						$i = 0;
						$thiscount =0;
						$args = array(
							'post_type'=> 'sponsors'
						);
						?>
						<?php query_posts( $args ); ?>
						<?php while ( have_posts() ) : the_post(); ?>
						
						<?php
						
						global $post;
						$post_id = $post->ID;
						$website = get_post_meta( $post_id, 'sponsor_website' , true);
						if (empty ( $website) ) {
							$websitelink = 'javascript:;';
						} else {
							$websitelink = $website;
						}
						
						$thiscount++;
						
						if ( 0 == $i ) {
							?>
							<div class="row">
							<?php
						}
						?>
								<div class="col-lg-4 col-sm-4 col-md-4 col-xs-4">
									<?php
										$image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'sponsor-image');
										
									?>
									<?php if ( !empty ( $website) ) {
										$target = 'target = "__blank"';
									} else {
										$target = '';
									}
									?>
									<a  <?php echo $target; ?> href = "<?php echo $websitelink; ?>" >
										<img src="<?php echo $image['0']; ?>"  class="img-responsive"/>
									</a>
								</div>  
						<?php
							
							
							$i++;
						
							if ( 3 == $i || $count == $thiscount ) {
								$i = 0;
								?>
								</div>
								<?php
							}
							
							
							
							?>
							
						<?php endwhile; // End the loop. Whew. ?>
					
				</div>
		</div> <!--entry content -->
</div> <!--  container -->
	</div>
<?php
get_footer();

