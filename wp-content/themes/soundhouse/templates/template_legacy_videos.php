<?php
/*
 * Template Name: Leagacy Videos
 */ 
get_header();
?>
  <div class="inner-content-area">
        <div class="entry-content">
          <div class="legacy">
            <h1>LEGACY TOUR</h1>
            <?php if ( have_posts() ) : while( have_posts() ) : the_post(); ?>
				<?php
					echo get_the_post_thumbnail($post->ID , array( 861, 285), array( 'class' => 'img-responsive leagacyimg' ));
				?>
			<?php 
				endwhile; endif; 
			?>
            <div class="row legacy-videos">
				<?php
					$args = array( 'post_type' => 'legacy-video', 'posts_per_page' => 4, 'paged' => get_query_var('paged') );
					$loop = new WP_Query( $args );
					while ( $loop->have_posts() ) : $loop->the_post();
				?>
					<div class="col-lg-6 col-md-6 col-sm-6">
						<h2 class="video-title"><?php the_title(); ?></h2>
						<?php the_content(); ?>
					</div>
				<?php
					endwhile;
				?>
			<div class="col-lg-12 col-md-12">
				<p class="paged"><?php wp_pagenavi( array( 'query' => $loop ) ); ?></p>
			</div>
			<?php 
				wp_reset_query(); 
			?>              
			</div>
          </div>
        </div>
      </div>
<?php
get_footer();
?>
