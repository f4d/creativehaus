<?php
/*
 * single artist page
 * 
 */ 
get_header();
if ( have_posts() ) : while ( have_posts() ) : the_post();
$post_id = get_the_ID();
$user_id = get_post_meta( $post_id, 'artist_id', true ); 
$user_info = get_userdata($user_id); 
$user_firstname = $user_info->first_name;
$user_last_name = $user_info->last_name;
$user_city = get_user_field ("user_city");
$user_state = get_user_field ("user_state");
$user_biography = get_user_field ("user_biography");

$facebook_url = get_user_field ("facebook_url");

if(!empty($facebook_url)){ 
$expfb = explode('://',$facebook_url);
if($expfb[0]!=$facebook_url) {
	$fburl = $expfb[0].'://'.$expfb[1];
	}
	else
	{
	$fburl = 'https://'.$expfb[0];
	}
 } else {
	 
	 $fburl = '#';
	 }
 

$twitter_url = get_user_field ("twitter_url");
if(!empty($twitter_url)){ 
$exptw = explode('://',$twitter_url);
if($exptw[0]!=$twitter_url) {
	$twurl = $exptw[0].'://'.$exptw[1];
	}
	else
	{
	$twurl = 'https://'.$exptw[0];
	}
} else {
	 $twurl = '#';
	}
	
$artist_url = get_user_field ("artist_url");
if(!empty($artist_url)){  
$expart = explode('://',$artist_url);
if($expart[0]!=$artist_url) {
	$arturl = $expart[0].'://'.$expart[1];
	}
	else
	{
	$arturl = 'https://'.$expart[0];
	}
  }else {
	  
	  $arturl = '#';
	  }

$itunes_url = get_user_field ("itunes_url");
if(!empty($itunes_url)){  
$expitn = explode('://',$itunes_url);
if($expitn[0]!=$itunes_url) {
	$tuneurl = $expitn[0].'://'.$expitn[1];
	}
	else
	{
	$tuneurl = 'https://'.$expitn[0];
	}
} else {
	 $tuneurl = '#';
	}

$google_plus = get_user_field ("google_plus");
if(!empty($google_plus)){  
$expgoo = explode('://',$google_plus);
if($expgoo[0]!=$google_plus) {
	$googleurl = $expgoo[0].'://'.$expgoo[1];
	}
	else
	{
	$googleurl = 'https://'.$expgoo[0];
	}
 } else{
	 $googleurl = '#';
	 }

$youtube_url = get_user_field ("youtube_url");

if(!empty($youtube_url)){  
$expyou = explode('://',$youtube_url);
if($expyou[0]!=$youtube_url) {
	$youurl = $expyou[0].'://'.$expyou[1];
	}
	else
	{
	$youurl = 'https://'.$expyou[0];
	}
 } else{
	 $youurl = '#';
	 }

$vimeo_url = get_user_field ("vimeo_url");

if(!empty($vimeo_url)){  
$expvim = explode('://',$vimeo_url);
if($expvim[0]!=$vimeo_url) {
	$vimurl = $expvim[0].'://'.$expvim[1];
	}
	else
	{
	$vimurl = 'https://'.$expvim[0];
	}
 } else{
	 $vimurl = '#';
	 }

$myspace_url = get_user_field ("myspace_url");

if(!empty($myspace_url)){  
$expspace = explode('://',$myspace_url);
if($expspace[0]!=$myspace_url) {
	$spaceurl = $expspace[0].'://'.$expspace[1];
	}
	else
	{
	$spaceurl = 'https://'.$expspace[0];
	}
 } else{
	 $spaceurl = '#';
	 }
 



$admin_band_member = get_user_meta($user_id,"admin_band_member",true);

if (!empty ($admin_band_member) ) {
	extract($admin_band_member);
	$adminname = $artistname;
	$adminemail = $artistemail;
	$admingenre = $artistgenre;
} else {
	$adminname = '';
	$adminemail = '';
	$admingenre = '';
}

$user_multiple_image = get_user_meta($user_id,"user_multiple_image",true);
$band_members = get_user_meta($user_id,"band_members",true);
$press_items = get_user_meta($user_id,"press_items",true);
$google_plus = get_user_field ("google_plus");


$artist_id = get_user_meta($user_id,"artist_post_id",true);
$term_list = wp_get_post_terms($artist_id, 'artist_list', array("fields" => "names"));

?>
	<div class="inner-content-area">
		<div class="entry-content">
			<div class="profile">
			<h1 class="pull-left"><?php echo $user_firstname.' '.$user_last_name; ?> - <span><?php if (!empty ($term_list) ) echo $term_list['0'];?></span></h1>
            <div class="right-info pull-right">
              <h5 >BAND WEBSITE</h5>
              <?php if (!empty( $artist_url ) ) : ?>
              <h4><a href= "<?php echo $artist_url; ?>" target= "_blank" ><?php echo $artist_url; ?></a></h4>
              <?php else : ?>
              <h4>Website not mentioned</h4>
              <?php endif; ?>
            </div>
            <div class="profile-banner">
				<?php 
					$userpofile = get_user_meta($user_id,"user_profile_image",true);
					if ( !is_wp_error ( $userpofile ) && !empty ( $userpofile ) ) :
						$img1 = wp_get_attachment_image_src($userpofile, 'artist-profile-page-pic');
						//echo '<pre>';print_r($img1); echo '</pre>';
					?>
						<img class= "prof-img" src="<?php echo $img1['0']; ?>" width="<?php echo $img1[1]; ?>" height="<?php echo $img1[2]; ?>"  alt="photo" />
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
                    <li><a target = "_blank" href="<?php echo $tuneurl; ?>"><img src="<?php bloginfo('template_url'); ?>/images/profileicon2.png" alt="second-icon"/></a></li>
                    <li><a target = "_blank" href="<?php echo $fburl; ?>"><img src="<?php bloginfo('template_url'); ?>/images/profileicon3.png" alt="third-icon"/></a></li>
                    <li><a target = "_blank" href="<?php echo $twurl	; ?>"><img src="<?php bloginfo('template_url'); ?>/images/profileicon4.png" alt="fourth-icon"/></a></li>
                    <li><a target = "_blank" href="<?php echo $googleurl; ?>"><img src="<?php bloginfo('template_url'); ?>/images/profileicon6.png" alt="sixth-icon"/></a></li>
                    <li><a target = "_blank" href="<?php echo $youurl; ?>"><img src="<?php bloginfo('template_url'); ?>/images/YouTube1.png" alt="Youtube"/></a></li>
                    <li><a target = "_blank" href="<?php echo $vimurl; ?>"><img src="<?php bloginfo('template_url'); ?>/images/Vimeo1.png" alt="Vimeo"/></a></li>
                    <li><a target = "_blank" href="<?php echo $spaceurl; ?>"><img src="<?php bloginfo('template_url'); ?>/images/myspace2.png" alt="Myspace"/></a></li>
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
						</li>
					</ul>
					<?php
						$countevents = 0;
						$songargs = array(
							'post_type'=> 'artist-songs',
							'author' => $user_id,
							'tax_query' => array(
								array(
									'taxonomy' => 'post_format',
									'field' => 'slug',
									'terms' => 'post-format-audio',
									'operator' => 'IN'
								))
						);
						query_posts( $songargs );
						$countsongs = 0;
						while ( have_posts() ) : the_post();
							$countsongs++;
							$post_id_song = get_the_ID();
							$song_guid = get_post_meta( $post_id_song ,'song_id' , true );
							if ( !isset ( $attached_url ) ) {
								$attached_url = get_the_content();
								$title  = get_the_title();
								$arr = '{ title:"'.$title.'", mp3:"'.$attached_url.'"}';
							} else {
								$attached_url = get_the_content();
								$title  = get_the_title();
								$arr .= ',{ title:"'.$title.'", mp3:"'.$attached_url.'"}';
							}
							$resul = wp_get_attachment_metadata($song_guid);
						endwhile;
						// Reset Query
						wp_reset_query();
						if ($countsongs == 0 ) {
							echo '<p>Artist have not uploaded songs</p>';
						}
						// Reset Query
						wp_reset_query();
						
					?>
	<?php if ($countsongs > 0 ) { ?>
		<div id="jp_container_2" class="jp-audio">
			<div class="jp-type-playlist">
				<div class="jp-gui jp-interface">
					<ul class="jp-controls">
						<li>
							<a href="javascript:;" class="jp-previous" tabindex="1">previous</a>
						</li>
						<li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
						<li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
						<li><a href="javascript:;" class="jp-next" tabindex="1">next</a></li>
						<li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
						<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
						<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
					</ul>
					
					<div class="jp-volume-bar">
						<div class="jp-volume-bar-value"></div>
					</div>
					<div class="jp-time-holder">
						<div class="jp-current-time"></div>
						<div class="jp-duration"></div>
					</div>
					<ul class="jp-toggles">
						<li><a href="javascript:;" class="jp-shuffle" tabindex="1" title="shuffle">shuffle</a></li>
						<li><a href="javascript:;" class="jp-shuffle-off" tabindex="1" title="shuffle off">shuffle off</a></li>
						<li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
						<li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
					</ul>
				</div>
				<div class="jp-playlist">
						
					<ul>
					
						<li>
						</li>
					</ul>
				</div>
				<div class="jp-no-solution">
					<span>Update Required</span>
					To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
				</div>
			</div>
		</div>
                  
                       
                      
                   
                    
                   
						<div id="jquery_jplayer_2" class="jp-jplayer"></div>
						<?php } ?>
                </div>
				<div class="col-lg-7 col-md-7">
					<div class="video-section">
						<h2>POPULAR VIDEO</h2>
						<!-- <img src="<?php //bloginfo('template_url'); ?>/images/video.png" alt="video" class="img-responsive"/> <span class="glyphicon glyphicon-play"></span> -->
						<ul class="playlist">
						<?php
						$countvideosong = 0;
						$songargs = array(
							'post_type'=> 'artist-songs',
							'author' => $user_id,
							'tax_query' => array(
								array(
									'taxonomy' => 'post_format',
									'field' => 'slug',
									'terms' => 'post-format-video',
									'operator' => 'IN'
								))
						);
						query_posts( $songargs );
						$countvideosong = 0;
						echo '<div class="events panel-group" id="accordion">';
						while ( have_posts() ) : the_post();
							$countvideosong++;
							echo '<div class="panel panel-default">';
							echo '<div class="table">';
								$post_id_song = get_the_ID();
								$song_guid = get_post_meta( $post_id_song ,'song_id' , true );
								$attached_url = get_the_content();
							echo '</div>';
							echo '<div  class="view">';
									echo '<a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$countvideosong.'" class="pop">'.get_the_title().'</a>';
								echo '</div>';
								if( $countvideosong == 1) {
									echo '<div id="collapse'.$countvideosong.'" class="panel-collapse collapse in">';
								} else {
									echo '<div id="collapse'.$countvideosong.'" class="panel-collapse collapse">';
								}
									echo do_shortcode( '[video id ="play_video_song" src="'.$attached_url.'" width="480" height="270"]' );
								echo '</div>';
							
							echo '</div>';
							
						endwhile;
						echo '</ul>';
						// Reset Query
						wp_reset_query();
						if ( $countvideosong == 0 ) {
							echo 'No video song uploaded by the artist';
						}
						?>
					</div>
				</div>
			</div>
            <div class="artist-biography">
            
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
            
            <div class="top-heading">
              <h2 class="col-lg-9 col-md-9 col-sm-9 col-xs-6">Artist Biography</h2>
                    <p><?php echo $user_biography; ?></p>
              </div>
            </div>
            
               <div class="band col-lg-3 col-md-3 col-sm-3 col-xs-12">
                  <h2>Band Members</h2>
                 <div class="biography-content">
					<ul class="brand-name ">
					 <li><span><?php  echo $adminname; ?> </span><?php  echo $admingenre; ?></li>
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
                  <?php
						$countevents = 0;
						$eventargs = array(
							'post_type'=> 'artist-events',
							'author' => $user_id
						);
						query_posts( $eventargs );
						while ( have_posts() ) : the_post();
							$countevents++;
							$post_id = get_the_ID();
							echo '<li>';
							echo '<span>'.date("M-d-Y", strtotime(get_post_meta( $post_id ,'venue_dateofevent' , true )) ) .'</span> - ';
							echo '<span>'.get_post_meta( $post_id ,'venue_name' , true ).'</span> - ';
							echo get_post_meta( $post_id ,'venue_city' , true ).', '.get_post_meta( $post_id ,'venue_state' , true );
							echo '</li>';
						endwhile;
						wp_reset_query(); 
						if ( $countevents  == 0 ) {
							echo '<li>No shows added by artist</li>';
						} 
					?>
                  </ul>
                </div>
              </div>
              <div class="contact-brand">
                <div class="col-lg-3 col-md-3 ">
                  <h2>Contact Band</h2>
                
                    <div class="form-group">
                      <input type="text" id="artist_contact_name" name="name" class="form-control" placeholder="Name"/>
                      <div class="soundhouse_errors" id="acnameei"></div>
                    </div>
                    <div class="form-group">
                      <input type="email" id="artist_contact_email" name="name" class="form-control" placeholder="Email"/>
                      <div class="soundhouse_errors" id="acemailei"></div>
                    </div>
                    <div class="form-group">
                      <textarea  id="artist_contact_message" class="form-control" rows="3" placeholder="Message"></textarea>
                      <div class="soundhouse_errors" id="acmessageei"></div>
                    </div>
                    <div class="form-group">
                      <input id="artist_contact_but" type="submit" value="SEND"/>                      
                      <input id="artist_contact_hidden" type="hidden" value="<?php echo $user_id; ?>"/>
                    </div>
                  <div id = "ajax_loader_show" ></div>
                </div>
              </div>
            </div>
            <div class="press-release">
              <div class="col-lg-12 col-md-12">
                <h2>Press Release</h2>
                <ul class="press-list">
					<?php 
					if (!empty ($press_items))  : 
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
									<p><?php $content = get_the_content();
                                        $content = strip_tags($content);
                                       echo substr($content, 0, 400); ?></p>
                                     </div>
                                     <div class="readmore">
                                 <a  href="<?php echo get_permalink();  ?>">READ MORE</a>
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
                  <h2 class="col-lg-9 col-md-9 col-sm-7 col-xs-6">Comments</h2>
                  <div class="leave-comment col-lg-3 col-md-3 col-sm-5 col-xs-6"> <a href="#">LEAVE A COMMENT</a> </div>
                </div>
                <div class="coments-list">
					<div class="comments_form" ><?php comments_template( '', true ); ?>
					</div>
                </div>
               </div>
            </div>
             
     
            
          </div>
        </div>
      </div>
    </div>
	<?php endwhile; endif; ?>  
	

<script type="text/javascript">
//<![CDATA[
jQuery(document).ready(function(){

	
	new jPlayerPlaylist({
		jPlayer: "#jquery_jplayer_2",
		cssSelectorAncestor: "#jp_container_2"
	}, [
		<?php echo $arr; ?>
	], {
		swfPath: "js",
		supplied: "oga, mp3",
		wmode: "window",
		smoothPlayBar: true,
		keyEnabled: true,
		autoPlay : true
	});
});
//]]>
</script>	
	
<?php

get_footer();

