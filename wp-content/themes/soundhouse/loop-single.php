<?php
/**
 * The loop that displays a single post.
 *
 * The loop displays the posts and the post content. See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop-single.php.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.2
 */
?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
        <div class="inner-content-area">
        <div class="entry-content">
          <div class="single-post row">
			 
            <div class="col-lg-9 col-md-9 single-content">
              
              <div class="row post-content">
              <div class="col-lg-12 col-md-12 col-sm-12">
				<h1><?php the_title(); ?></h1>
				<p class="post-date"><?php the_time('F j, Y') ?>  |  Author - <?php the_author() ?></p>
              </div>
              
              
                <div class="col-lg-5 col-md-5 col-sm-5">
					<?php the_post_thumbnail('blog-thum'); ?>
                  <div class="comment">
                    <a href="<?php echo get_comments_link( $post->ID ); ?>"><h2 class="text-center">COMMENT</h2></a>
                      <?php
							$id = get_the_ID();
							$args = array(
								'post_id' => $id, 
								'count' => true 
							);
							$comments = get_comments($args);
						?>
                    <p class="pull-left">COMMENTS ( <span><?php echo $comments; ?></span> )</p>
                    <a href="#" target="_blank" class="pull-right">SHARE</a> </div>
                    
                  <div>
                  <?php if( 'artist-blog' !=  get_post_type( $post ) ) : ?>
                  <h2>MORE PHOTOS</h2>
                  <div class="row phtotos">
                     <?php
						if( function_exists( 'easy_image_gallery' ) ) {
							echo easy_image_gallery();
						}
					?>
                  </div>
                  <?php endif; ?>
                </div>
                    
                    
                </div>
                <div class="col-lg-7 col-md-7 col-sm-7 ">
					<?php the_content(); ?>
                </div>
              </div>
              
              
            </div>
			<?php get_sidebar(); ?>
          </div>
          <div class="row">
                <div class="col-lg-12 col-md-12 back-link"> <a class="scrollup" href="javascript: void();">Back to Top <span> >> </span></a> </div>
              </div>
        </div>
      </div>
    </div>
    
    
    <div class="profile-comments">
              <div class="col-lg-12 col-md-12">
                <div class="top-heading">
                  <h2 class="col-lg-9 col-md-9 col-sm-7 col-xs-6">Profile Comments</h2>
                  <div class="leave-comment col-lg-3 col-md-3 col-sm-5 col-xs-6"> <a href="#">LEAVE A COMMENT</a> </div>
                </div>
                <div class="coments-list">
                <div class="comments_form" ><?php comments_template( '', true ); ?></div>
                  <!--<div class="coment">
                    <div class="col-lg-1 col-md-1 col-sm-2 col-xs-2"> <img class="img-responsive " alt="profile-comment" src="<?php bloginfo('template_url'); ?>/images/profile-comments.png"> </div>
                    <div class="col-lg-11 col-md-11 col-sm-10 col-xs-10">
                      <h2>George Shows - <span>April 10 2014</span></h2>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a nisl feugiat, auctor dui sit amet, sollicitudin urna. Maecenas nec dapibus leo. Aliquam id urna eu risus condimentum feugiat consequat sed ligula. Proin nec vestibulum arcu. Etiam at libero eget turpis egestas porttitor vitae sed neque. Duis et aliquam purus, dictum malesuada libero. Proin ut dui dolor. elit. Nullam turpis metus, ullamcorper et urna nec.</p>
                    </div>
                  </div>
                  <div class="coment">
                    <div class="col-lg-1 col-md-1 col-sm-2 col-xs-2"> <img class="img-responsive " alt="profile-comment" src="<?php bloginfo('template_url'); ?>/images/profile-comments.png"> </div>
                    <div class="col-lg-11 col-md-11 col-sm-10 col-xs-10">
                      <h2>Stephen Flowers - <span>April 10 2014</span></h2>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a nisl feugiat, auctor dui sit amet, sollicitudin urna. Maecenas nec dapibus leo!!!!!</p>
                    </div>
                  </div>
                  <div class="coment">
                    <div class="col-lg-1 col-md-1 col-sm-2 col-xs-2"> <img class="img-responsive " alt="profile-comment" src="<?php bloginfo('template_url'); ?>/images/profile-comments.png"> </div>
                    <div class="col-lg-11 col-md-11 col-sm-10 col-xs-10">
                      <h2>Daletron 3000 - <span>April 10 2014</span></h2>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit!!!!!!!!!!!</p>
                    </div>
                  </div>-->
                </div>
                <!-- <a href="#" class="view-more">Show All Comments <span> &gt;&gt;</span></a>-->
               </div>
            </div>
             
              
				

<?php endwhile; // end of the loop. ?>              
 

            <?php //get_sidebar(); ?>
 





