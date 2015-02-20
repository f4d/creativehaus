<?php
/*
 * Template Name: Artist directory
 */ 

get_header();
?>

<script>

jQuery(document).ready(function(){
        
        var postcon = jQuery(".artist-pagi-block").contents();
        jQuery(".show_artist_pagi").html(postcon);
        
    });


</script>

    <div class="inner-content-area">
        <div class="entry-content">
          <div class="directory">
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6">
                <h1>ARTIST DIRECTORY</h1>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-6 ">
                <div class="form-group  col-lg-6 col-md-6">
				<form method= "post" >
                  <input type="text" class="form-control" value = "<?php if ( isset ( $_POST['searchforartist'] ) ) { echo $_POST['artistsearchname']; } ?>" id="artistsearchname" name = "artistsearchname" placeholder="Search Artists">
                  <span id= "searchartist" class="glyphicon glyphicon-search form-control-feedback"></span>
                  <input name= "searchforartist" type = "submit" style = "display:none" id = "searchartisthidden" />
				</form>
				 </div>
              </div>
            </div>
            <div class="directory-list">
            <?php 
            
            if ( !isset ($_POST['searchforartist'] ) ) {
				$wp_query= new WP_Query( array( 'showposts' =>10, 'post_type' => 'artist', 'order' => 'ASC', 'paged' => get_query_var('paged') ) );
			} else {
				$searchterm = $_POST['artistsearchname'];
				$wp_query= new WP_Query( array( 'showposts' =>10, 'post_type' => 'artist', 's' => $searchterm, 'order' => 'ASC', 'paged' => get_query_var('paged') ) );
			}

            ?>
            
 
              <table class="table">
                <tbody>
					
					
						<?php 
						while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
						<tr>
							<?php 
								$user_id = $qry->data->ID;
								$user_info = get_userdata($user_id); 
								$user_firstname = $user_info->first_name;
								$user_last_name = $user_info->last_name;
								$user_city = get_user_field ("user_city");
								$user_state = get_user_field ("user_state");
								$user_biography = get_user_field ("user_biography");
								
								$user_id_post = get_the_author_meta('id');
								$facebook_url = get_user_field ('facebook_url', $user_id_post );
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
								 

								$twitter_url = get_user_field ('twitter_url', $user_id_post );
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
								$google_plus = get_user_field ('google_plus', $user_id_post );
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

								
								
							?>
							<?php $userpofile = get_user_meta($user_id,"user_profile_image",true); ?>
							<td>
								<?php 
									if ( has_post_thumbnail() )  :
								?>
									<?php the_post_thumbnail('admin-directory-pic'); ?>
								<?php else : ?>
									<img height="27px" width="27px" src="<?php bloginfo('template_url');?>/images/photo1.png" alt="photo" class="img-responsive"/>
								<?php endif; ?>
							</td>
							<td><?php the_title(); ?></td>
							<?php $artist_id = get_user_meta($user_id,"artist_post_id",true);  ?>
							<td class="icons text-right"><a target= "_blank" href="<?php echo $fburl; ?>"><span class="icon-facebook"></span></a> <a target= "_blank" href="<?php echo $googleurl; ?>"><span class="icon-googleplus"></span></a> <a target= "_blank" href="<?php echo $twurl; ?>"> <span class="icon-twitter"></span></a></td>
							<td class="text-center view" ><a href="<?php echo get_permalink($artist_id); ?>" >View</a></td>
						</tr>
					   <?php 
						endwhile; 
						echo '<div class="artist-pagi-block">';
						wp_pagenavi( array( 'query' => $wp_query ) );
						echo '</div>';
						 ?>
						<?php 
						wp_reset_query();

						 ?>
								
					
                 
							</tbody>
							</table>
						
                  <div class="show_artist_pagi"></div>
            </div>
          </div>
        </div>
      </div>
  
<?php
get_footer();
