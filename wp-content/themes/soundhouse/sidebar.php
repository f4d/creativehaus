<?php
/**
 * The Sidebar containing the primary and secondary widget areas.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>

<div class="col-lg-3 col-md-3 sidebar">
              <aside>
              <?php dynamic_sidebar('mostpop'); ?>
              <?php dynamic_sidebar('tweets'); ?>
              <div class="sponsors">
                  <h2>SPONSORS</h2>
                  <div class="logos">
                    <ul class="text-center">
				
						<?php 
					//	$i = 0;
						//$thiscount =0;
						$args = array(
							'showposts'=> 6,
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
						
						
						?>
						<li>
							<?php if ( !empty ( $website) ) {
								$target = 'target = "__blank"';
							} else {
								$target = '';
							}
							?>
							<a  <?php echo $target; ?> href = "<?php echo $websitelink; ?>" >
								<?php the_post_thumbnail('sponsor-sidebar'); ?>
							</a>
						</li>  
						<?php
							?>
							
						<?php endwhile; // End the loop. Whew. ?>
						<?php 
				wp_reset_query(); ?> 
					</ul>
                  </div>
                </div>

              </aside>
             </div>

