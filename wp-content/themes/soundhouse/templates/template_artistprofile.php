<?php
/*
 * Template Name: Artist Profile
 */
if ( !isset ( $_REQUEST['artist-id'] ) || '' == trim ( $_REQUEST['artist-id'] ) ) {
	wp_redirect(get_permalink(9));
}
$user_info = get_user_by( 'id', $_REQUEST['artist-id'] );
if ( empty ( $user_info ) ) {
	wp_redirect(get_permalink(9));
}
$user_id = $_REQUEST['artist-id'];
$user_firstname = $user_info->first_name;
$user_last_name = $user_info->last_name;
$user_city = get_user_field ("user_city");
$user_state = get_user_field ("user_state");
$user_biography = get_user_field ("user_biography");
$facebook_url = get_user_field ("facebook_url");
$twitter_url = get_user_field ("twitter_url");
$artist_url = get_user_field ("artist_url");
$itunes_url = get_user_field ("itunes_url");
$user_multiple_image = get_user_meta($user_id,"user_multiple_image",true);
$band_members = get_user_meta($user_id,"band_members",true);
$press_items = get_user_meta($user_id,"press_items",true);
get_header();
?>
   <div class="inner-content-area">
        <div class="entry-content">
        yahoooooo
        <?php echo  mp3j_put( '[mp3-jplayer tracks="Beetein-Lamhein.mp3" ]'); ?>
                      <?php //mp3j_put('[mp3-jplayer etc…]'); ?>
                      
          <div class="profile">
            <h1 class="pull-left"><?php echo $user_firstname.' '.$user_last_name; ?> - <span>British Indie Rock</span></h1>
            <div class="right-info pull-right">
              <h5 >BAND WEBSITE</h5>
              <h4><a href= "<?php echo $artist_url; ?>" target= "_blank" ><?php echo $artist_url; ?></a></h4>
            </div>
            <div class="profile-banner">
				<?php 
					$userpofile = get_user_meta($user_id,"user_profile_image",true);
					if ( !is_wp_error ( $userpofile ) && !empty ( $userpofile ) ) :
						$img1 = wp_get_attachment_image_src($userpofile, 'artist-profile-page-pic');
						//echo '<pre>';print_r($img1); echo '</pre>';
					?>
						<img class= "prof-img" src="<?php echo $img1['0']; ?>" alt="photo" />
					<?php endif; ?>
              <div class="banner-bottom ">
                <div class="col-lg-6 col-md-6 col-sm-6">
                  <ul class="thumnail">
					<?php if ( !empty ( $user_multiple_image ) ) : ?>
					<?php foreach ( $user_multiple_image as $image ) : ?>
						<?php $img1 = wp_get_attachment_image_src($image, 'artist-profile-multiple-pic'); ?>
						<?php $fullimage = wp_get_attachment_image_src($image, 'artist-gallery-images'); ?>
						<li><a rel="lightbox" href="<?php echo $fullimage['0']; ?>" ><img src="<?php echo $img1['0']; ?>" class="img-responsive" alt="thumbnail"/></a></li>
					<?php endforeach; ?>
					<?php else : ?>
						<?php $img1 = wp_get_attachment_image_src( 317, 'artist-profile-multiple-pic'); ?>
						<li><a href="#"><img src="<?php echo $img1['0']; ?>" class="img-responsive" alt="thumbnail"/></a></li>
						<li><a href="#"><img src="<?php echo $img1['0']; ?>" class="img-responsive" alt="thumbnail"/></a></li>
						<li><a href="#"><img src="<?php echo $img1['0']; ?>" class="img-responsive" alt="thumbnail"/></a></li>
						<li><a href="#"><img src="<?php echo $img1['0']; ?>" class="img-responsive" alt="thumbnail"/></a></li>
					<?php endif; ?>
                  </ul>
                  </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                  <ul class="sharing-us">
                    <li><a href="#"><img src="<?php bloginfo('template_url'); ?>/images/profileicon.png" alt="first-icon"/></a></li>
                    <li><a href="#"><img src="<?php bloginfo('template_url'); ?>/images/profileicon2.png" alt="second-icon"/></a></li>
                    <li><a href="#"><img src="<?php bloginfo('template_url'); ?>/images/profileicon3.png" alt="third-icon"/></a></li>
                    <li><a href="#"><img src="<?php bloginfo('template_url'); ?>/images/profileicon4.png" alt="fourth-icon"/></a></li>
                    <li><a href="#"><img src="<?php bloginfo('template_url'); ?>/images/profileicon5.png" alt="fifth-icon"/></a></li>
                    <li><a href="#"><img src="<?php bloginfo('template_url'); ?>/images/profileicon6.png" alt="sixth-icon"/></a></li>
                  </ul>
                </div>
              </div>
            </div>
            
            <div class="top-playlist">
              <div class="row">
                <div class="col-lg-5 col-md-5">
                  <ul class="playlist">
                    <li>
                      <h2 class="pull-left">TOP PLAYLIST</h2>
                      
                      <section class="pull-right play-option"> <a href="#">Play All</a> | <a href="#">Queue All</a></section>
                    </li>
                    <li> <span class="glyphicon glyphicon-pause"></span> This Charming Man</li>
                    <li> <span class="icon-play"></span>Asleep</li>
                    <li> <span class="icon-play"></span>Please, Please, Please</li>
                    <li> <span class="icon-play"></span>How Soon is Now?</li>
                    <li> <span class="icon-play"></span>There is a Light</li>
                    <li> <span class="icon-play"></span>Heaven Knows Im Miserable</li>
                    <li> <span class="icon-play"></span>Bigmouth Strikes Again</li>
                  </ul>
                </div>
				<div class="col-lg-7 col-md-7">
					<div class="video-section">
						<h2>POPULAR VIDEO</h2>
						<img src="images/video.png" alt="video" class="img-responsive"/> <span class="glyphicon glyphicon-play"></span> 
						<ul class="playlist">
							<li> <span class="icon-play"></span>Video 1</li>
							<li> <span class="icon-play"></span>Video 2</li>
							<li> <span class="icon-play"></span>Video 3</li>
							<li> <span class="icon-play"></span>Video 4</li>
						</ul>
					</div>
				</div>
			</div>
            <div class="artist-biography">
              <div class="top-heading">
                <h2 class="col-lg-9 col-md-9 col-sm-9 col-xs-6">Artist Biography</h2>
                <div class="band col-lg-3 col-md-3 col-sm-3 col-xs-6">
                  <h2>Band Members</h2>
                </div>
              </div>
              <div class="biography-content">
                <div class="col-lg-9 col-md-9">
                  <p><?php echo $user_biography; ?></p>
                </div>
                <div class="col-lg-3 col-md-3">
					<ul class="brand-name ">
						<?php if (!empty ($band_members))  : ?>
							<?php foreach ( $band_members as $key =>$band ) : ?>
								<li><span><?php  echo $band['artistname']; ?> </span><?php  echo $band['artistgenre']; ?></li>
							<?php endforeach; ?>
						<?php else : ?>
							<li>No  band member </li>
						<?php endif; ?>
                  </ul>
                </div>
              </div>
            </div>
            <div class="recent-show row ">
              <div class="col-lg-9 col-md-9 col-xs-12">
                <div class="show-pannel">
                  <h2>Recent Shows</h2>
                  <ul class="show-list">
                    <li><span>April 10 -</span> <span>LOVEGOAT</span> - Austin, TX</li>
                    <li><span>April 8 -</span> <span>The Boiler Room</span> - San Antonio, TX</li>
                    <li><span>April 7 -</span> <span>Thirsty Hippo</span> - Houston, TX</li>
                    <li><span>April 5 -</span> <span>Boom Boom Room</span> - New Orleans, TX</li>
                    <li><a href="#" class="view-more">View All Shows <span>&gt;&gt;</span></a></li>
                  </ul>
                </div>
              </div>
              <div class="contact-brand">
                <div class="col-lg-3 col-md-3 ">
                  <h2>Contact Band</h2>
                  <form method= "post" >
                    <div class="form-group">
                      <input type="text" name="name" class="form-control" placeholder="Name"/>
                    </div>
                    <div class="form-group">
                      <input type="email" name="name" class="form-control" placeholder="Email"/>
                    </div>
                    <div class="form-group">
                      <textarea  class="form-control" rows="3" placeholder="Message"></textarea>
                    </div>
                    <div class="form-group">
                      <input type="submit" value="SEND"/>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="press-release">
              <div class="col-lg-12 col-md-12">
                <h2>Press Release</h2>
                <ul class="press-list">
					<?php 
					if (!empty ($press_items))  : 
						//echo '<pre>';print_r($press_items); echo '</pre>';
						foreach ( $press_items as $key =>$press ) : 
							
						?>
						<li>
							<span><?php echo $press['date_of_release'] ; ?> </span>- <?php echo $press['publication_name'] ; ?> - "<?php echo $press['title_of_article'] ; ?>" - <a href="<?php echo $press['link_to_article'] ; ?>" target= "_blank"> <?php echo $press['link_to_article'] ; ?> </a>
						</li>
						<?php endforeach; ?>
					<?php else : ?>
						<li>No press release</li>
					<?php endif; ?>
                </ul>
              </div>
            </div>
            <div class="recent-blogs">
				<h2>Recent Blogs</h2>
				
                
                <?php

					// The Query
					$the_query = new WP_Query( array(
												'post_type' => 'artist-blog',
												'author' => $user_id,
											) );

					// The Loop
					if ( $the_query->have_posts() ) {
						while ( $the_query->have_posts() ) {
							$the_query->the_post();
							?>
							<div class="col-lg-12 col-md-12">
								<p class="sub-title"><span><?php the_time('F j, Y'); ?></span> - <?php the_title(); ?></p>
								<div  class="blog ">
									<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'artist-profle-blog-image'); ?>
									<?php if ( !empty ($image) ): ?>
									<img src="<?php echo $image['0']; ?>" alt="blogimg" class="img-responsive pull-left" />
									<?php else : ?>
									<?php $img1 = wp_get_attachment_image_src( 317, 'artist-profle-blog-image'); ?>
									<img src="<?php echo $img1['0']; ?>" alt="blogimg" class="img-responsive pull-left" />
									<?php endif; ?>
									<p><?php the_excerpt(); ?></p>
								</div>
							</div>
							<?php
						}
					} else {
						echo '<div class="col-lg-12 col-md-12">';
						echo '<p>No blog post found</p>';
						echo '</div>';
					}
					/* Restore original Post Data */
					wp_reset_postdata();
				?>
              
            </div>
            <div class="profile-comments">
              <div class="col-lg-12 col-md-12">
                <div class="top-heading">
                  <h2 class="col-lg-9 col-md-9 col-sm-7 col-xs-6">Profile Comments</h2>
                  <div class="leave-comment col-lg-3 col-md-3 col-sm-5 col-xs-6"> <a href="#">LEAVE A COMMENT</a> </div>
                </div>
                <div class="coments-list">
                  <div class="coment">
                    <div class="col-lg-1 col-md-1 col-sm-2 col-xs-2"> <img src="images/profile-comments.png" alt="profile-comment" class="img-responsive "/> </div>
                    <div class="col-lg-11 col-md-11 col-sm-10 col-xs-10">
                      <h2>George Shows - <span>April 10 2014</span></h2>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a nisl feugiat, auctor dui sit amet, sollicitudin urna. Maecenas nec dapibus leo. Aliquam id urna eu risus condimentum feugiat consequat sed ligula. Proin nec vestibulum arcu. Etiam at libero eget turpis egestas porttitor vitae sed neque. Duis et aliquam purus, dictum malesuada libero. Proin ut dui dolor. elit. Nullam turpis metus, ullamcorper et urna nec.</p>
                    </div>
                  </div>
                  <div class="coment">
                    <div class="col-lg-1 col-md-1 col-sm-2 col-xs-2"> <img src="images/profile-comments.png" alt="profile-comment" class="img-responsive "/> </div>
                    <div class="col-lg-11 col-md-11 col-sm-10 col-xs-10">
                      <h2>Stephen Flowers - <span>April 10 2014</span></h2>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a nisl feugiat, auctor dui sit amet, sollicitudin urna. Maecenas nec dapibus leo!!!!!</p>
                    </div>
                  </div>
                  <div class="coment">
                    <div class="col-lg-1 col-md-1 col-sm-2 col-xs-2"> <img src="images/profile-comments.png" alt="profile-comment" class="img-responsive "/> </div>
                    <div class="col-lg-11 col-md-11 col-sm-10 col-xs-10">
                      <h2>Daletron 3000 - <span>April 10 2014</span></h2>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit!!!!!!!!!!!</p>
                    </div>
                  </div>
                </div>
                <a class="view-more" href="#">Show All Comments <span> &gt;&gt;</span></a> </div>
            </div>
            
            
          </div>
        </div>
      </div>
    </div>
  
<?php
get_footer();

