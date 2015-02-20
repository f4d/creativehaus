<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage cambria
 * @since cambria 1.0
 */

get_header(); ?>

	<div class="bottom-content inner-pages">
        <div class="wrapper">
            <div class="container-fluid">
               
				
					<h1>Our Team</h1>
					<?php
						$args = array( 'post_type' => 'our-team', 'posts_per_page' => 9 );
						$loop = new WP_Query( $args );
						$count = 0;
						
						while ( $loop->have_posts() ) : $loop->the_post();
							$count++;
						endwhile;
						
						wp_reset_query();
						/* Queue the first post, that way we know
						 * what date we're dealing with (if that is the case).
						 *
						 * We reset this later so we can run the loop
						 * properly with a call to rewind_posts().
						 */
						$args = array( 'post_type' => 'our_team', 'posts_per_page' => 9 );
						$loop = new WP_Query( $args );
						$i = 0;
						$thiscount =0;
						while ( $loop->have_posts() ) : $loop->the_post();
						$thiscount++;
						
						if ( 0 == $i ) {
							?>
							<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="row">
							<?php
						}
							
							
							if ( 0 == $i ) {
								$portclass = "col-lg-4 col-md-4 col-sm-4 col-xs-12 portfolio-item left";
							} else if ( 1 == $i ) {
								$portclass = "col-lg-4 col-md-4 col-sm-4 col-xs-12 portfolio-item center";
							} else if ( 2 == $i ) {
								$portclass = "col-lg-4 col-md-4 col-sm-4 col-xs-12 portfolio-item right";
							}
							?>
							
							<div class = "<?php echo $portclass; ?>" >
								<div class="photo">
									<?php the_post_thumbnail('our-team-images'); ?>
								</div>
								<div class="client">
									<a href = "<?php echo get_permalink(); ?>" ><h2 class="name"><?php the_title(); ?></h2></a><br>
									
									<div class="clear"></div>
								</div>
							</div>
							
						<?php
							
							
							$i++;
						
							if ( 3 == $i || $count == $thiscount ) {
								$i = 0;
								?>
									</div>
									</div>
								 </div>
								<?php
							}
							
							
							
							?>

<?php
	/* Since we called the_post() above, we need to
	 * rewind the loop back to the beginning that way
	 * we can run the loop properly, in full.
	 */
	endwhile;

	/* Run the loop for the archives page to output the posts.
	 * If you want to overload this in a child theme then include a file
	 * called loop-archive.php and that will be used instead.
	 */
	 //get_template_part( 'loop', 'archive' );
?>

			
                    <!-- col 12 ends here -->
               
            </div>
        </div>
    </div>
<?php get_footer(); ?>
