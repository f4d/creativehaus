<?php
/*
 * Template Name: Artist Registration
 */ 

/*
 * include files neccessary for image uploading
 */ 
require_once(ABSPATH . "wp-admin" . '/includes/image.php');
require_once(ABSPATH . "wp-admin" . '/includes/file.php');
require_once(ABSPATH . "wp-admin" . '/includes/media.php');
$user_id = get_current_user_id();

/*
 * Update user profile info
 * Update firstname, lastname, city, state, zip, facebook , twitter, artist, itunes, bio, googleplus
 */  
if ( isset ( $_POST['profilesubmit'] ) )  {
	$first_name = sanitize_text_field ( $_POST['firstname'] );
	$last_name = sanitize_text_field ( $_POST['lastname'] );
	$user_city = sanitize_text_field ( $_POST['user_city'] );
	$user_state = sanitize_text_field ( $_POST['user_state'] );
	$user_zip = sanitize_text_field ( $_POST['user_zip'] );
	$facebook_url = sanitize_text_field ( $_POST['facebook_url'] );
	$twitter_url = sanitize_text_field ( $_POST['twitter_url'] );
	$artist_url = sanitize_text_field ( $_POST['artist_url'] );
	$itunes_url = sanitize_text_field ( $_POST['itunes_url'] );
	$user_biography = sanitize_text_field ( $_POST['user_biography'] );
	$google_plus = sanitize_text_field ( $_POST['google_plus'] );
	$youtube_url = sanitize_text_field ( $_POST['youtube_url'] );
	$vimeo_url = sanitize_text_field ( $_POST['vimeo_url'] );
	$myspace_url = sanitize_text_field ( $_POST['myspace_url'] );
	
	/*
	 * Create an array for updating and maintaining data with s2members profile fields
	 */ 
	$wp_s2member = array(
		'user_city' => $user_city,
		'user_state' => $user_state,
		'user_zip' => $user_zip,
		'facebook_url' => $facebook_url,
		'twitter_url' => $twitter_url,
		'artist_url' => $artist_url,
		'itunes_url' => $itunes_url,
		'google_plus' => $google_plus,
		'youtube_url' => $youtube_url,
		'vimeo_url' => $vimeo_url,
		'myspace_url' => $myspace_url,
		'user_biography' => $user_biography
	);
	wp_update_user ( array ( 'ID' => $user_id, 'first_name' => $first_name, 'last_name' => $last_name ) );
	$artist_post_id = get_user_meta($user_id,"artist_post_id",true);
	
	/*
	 * Update user genre taxonomy if selected
	 */ 
	$arrr= array();
	$artist_genre = $_POST['artist_genre'];
	if ( $artist_genre != -1 ) {
		array_push($arrr, $artist_genre);
		$my_post_data = array(
			'ID'           => $artist_post_id,
			'post_title'   => $first_name.' '.$last_name
		);
		wp_set_object_terms( $artist_post_id, $artist_genre, 'artist_list');
	} else {
		$my_post_data = array(
			'ID'           => $artist_post_id,
			'post_title'    => $first_name.' '.$last_name,
		);
	}
	wp_update_post ( $my_post_data ) ;
	/*
	 * Upload profile image if selected
	 */ 
	if (!empty ($_FILES['user_profile_image']['tmp_name'])) {
		$profile_image_id = media_handle_upload( 'user_profile_image', 0 );
		update_user_meta ( $user_id, 'user_profile_image', $profile_image_id );
		update_post_meta($artist_id, '_thumbnail_id', $profile_image_id); 
	}
	update_user_meta ( $user_id, 'wp_s2member_custom_fields', $wp_s2member );
	wp_redirect( get_permalink ( 232 ) );
}
/*
 * Get profile data to display on page
 */ 
$user_info = get_userdata($user_id); 
$user_firstname = $user_info->first_name;
$user_last_name = $user_info->last_name;
$user_email = $user_info->user_email;
$user_city = get_user_field ("user_city");
$user_state = get_user_field ("user_state");
$user_zip = get_user_field ("user_zip");
$facebook_url = get_user_field ("facebook_url");
$twitter_url = get_user_field ("twitter_url");
$artist_url = get_user_field ("artist_url");
$itunes_url = get_user_field ("itunes_url");
$user_biography = get_user_field ("user_biography");
$google_plus = get_user_field ("google_plus");
$youtube_url = get_user_field ("youtube_url");
$vimeo_url = get_user_field ("vimeo_url");
$myspace_url = get_user_field ("myspace_url");

		
get_header();

$artist_id = get_user_meta($user_id,"artist_post_id",true);


$rest_fill = get_user_meta ( $user_id,"rest_fill",true );


if ( empty ( $artist_id ) ) {
	$my_post_data = array(
		'post_title'    => $user_firstname.' '.$user_last_name ,
		'post_status'   => 'publish',
		'post_author'   => $user_id,
		'post_type'   => 'artist'
	);
	// Insert the post into the database
	$artist_post_id = wp_insert_post( $my_post_data );
	update_post_meta ( $artist_post_id, 'artist_id', $user_id );
	update_user_meta ( $user_id, 'artist_post_id', $artist_post_id );
}
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
		<ul class="limit">
			<li><span>&frasl;</span>20%</li>
			<li><span>&frasl;</span>40%</li>
			<li><span>&frasl;</span>60%</li>
			<li><span>&frasl;</span>80%</li>
			<li>finish</li>
		</ul>
		<div class="progress">
			<div id = "progress-bar-filled" class="progress-bar progress-bar-success progress-bar-striped active" style="width: 0%"> <span class="sr-only">20%</span> </div>
			<div id = "progress-bar-remaining" class="progress-bar progress-bar-warning " style="width: 98%"> <span class="sr-only">50% Complete (warning)</span> </div>
			<div class="progress-bar progress-bar-success progress-bar-striped " style="width: 2%"> <span class="sr-only">10% Complete (danger)</span> </div>
		</div>
		<div class="artist-regestration">
			<div class="row">
			<form method = "post" enctype="multipart/form-data" > <!--- form start here -->
				<div class="col-lg-8 col-md-8">
				<div class="location-info row">
					<div class="form-group col-lg-6 col-md-6">
						<label>Your Info</label>
						<input id= "artist_firstname" type="text" required maxlength = "70" class="form-control" name="firstname" placeholder="First Name" value = "<?php echo $user_firstname; ?>" />
						
						<input id= "artist_lastname" type="text" required maxlength = "70" class="form-control" name="lastname" placeholder="Last Name" value = "<?php echo $user_last_name; ?>" />
						<input id= "artist_email" type="email" readonly class="form-control" placeholder="Email Address" value= "<?php echo $user_email; ?>"/>
						<?php
						/*
						 * Get previous taxonomy
						 */ 
						$categories = get_the_terms($artist_id,'artist_list');
						if($categories)
						{
							foreach($categories as $catslug) {	 
								$catid =  $catslug->term_id;
							}
						}
						else
						{
							$catid = -1;
						} 
						?>
						<select name= "artist_genre" id= "artist_genre" class = "form-control selectpicker" >
						<option value = "-1" >Select Genre</option>
						<?php
						
						$taxonomy = 'artist_list';
						$tax_terms = get_terms($taxonomy,array( 'hide_empty' => false ));
						foreach ($tax_terms as $tax_term) 
						{
							if($catid==$tax_term->term_id)
							{
								$selected  = "selected";
							}
							else
							{
								$selected  = "";
							}
							echo '<option value= "'.$tax_term->slug.'" '.$selected.' >'.$tax_term->name.'</option>';
						}
						?>
						</select>
						<div class = "soundhouse_errors" id= "artist_genre_error" ></div>
					</div>
					<div class="form-group col-lg-6 col-md-6">
					<label>Your Location</label>
						<input id= "artist_city" type="text"  maxlength = "70" class="form-control" name="user_city" placeholder="City" value= "<?php echo $user_city; ?>" />
						<span class = "soundhouse_errors" id= "artist_city_error" ></span>
						<input id= "artist_state" type="text"  maxlength = "70" class="form-control" name="user_state" placeholder="State" value= "<?php echo $user_state; ?>" />
						<span class = "soundhouse_errors" id= "artist_state_error" ></span>
						<input id= "artist_zip" type="text"  maxlength = "70" class="form-control" name="user_zip" placeholder="Zip" value= "<?php echo $user_zip; ?>" />
						<span class = "soundhouse_errors" id= "artist_zip_error" ></span>
					</div>
					<div class="col-lg-12 col-md-12">
						<div class="cpartition"></div>
					</div>
				</div>
					<div class="form-group ">
						<textarea id= "artist_biography" class="form-control" rows="7" cols="5" name = "user_biography" placeholder="Your Biography" ><?php echo $user_biography; ?></textarea>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 social-side">
					<label>Your Social Network</label>
					<div class="form-group social-links">
						<input type="text" maxlength = "70" id = "facebook_url" class="form-control" name="facebook_url" placeholder="Facebook URL" value= "<?php echo $facebook_url; ?>"/>
						<input type="text" maxlength = "70" id = "twitter_url" class="form-control" name="twitter_url" placeholder="Twitter URL" value= "<?php echo $twitter_url; ?>" />
						<input type="text" maxlength = "70" id = "artist_url" class="form-control" name="artist_url" placeholder="Artist Website URL" value= "<?php echo $artist_url; ?>" />
						<input type="text" maxlength = "70" id = "itunes_url" class="form-control" name="itunes_url" placeholder="iTunes URL" value= "<?php echo $itunes_url; ?>" />
						<input type="text" maxlength = "70" id = "google_plus" class="form-control" name="google_plus" placeholder="Google plus URL" value= "<?php echo $google_plus; ?>" />
						<input type="text" maxlength = "70" id = "youtube_url" class="form-control" name="youtube_url" placeholder="YouTube URL" value= "<?php echo $youtube_url; ?>" />
						<input type="text" maxlength = "70" id = "vimeo_url" class="form-control" name="vimeo_url" placeholder="Vimeo URL" value= "<?php echo $vimeo_url; ?>" />
						<input type="text" maxlength = "70" id = "myspace_url" class="form-control" name="myspace_url" placeholder="Myspace URL" value= "<?php echo $myspace_url; ?>" />
					</div>
			</div>
                </div>
                <div class="col-lg-12 col-md-12">
                  <div class="cpartition"></div>
                </div>
                <div class="your-profile col-lg-12 col-md-12">
					<label>Your Profile</label>
					<div >
						<input style = "display:none" type="file" name="user_profile_image" id="user_profile_image" onchange="sliderimag1(this);" ><br>
					</div>
					<?php 
					?>
					
					<?php 
						$user_profile_image = get_user_meta($user_id,"user_profile_image",true); 
						if ( !empty ($user_profile_image ) ) :
							$user_profile_image1 = wp_get_attachment_image_src($user_profile_image, 'admin-artist-profile-pic');
							?>
							<img id= "slidimg1" src="<?php echo $user_profile_image1['0']; ?>" alt="photo" class="img-responsive"/>
							<?php
						endif;
					?>
					
					<button id= "user_profile_image_trig" class=" button-info btn btn-primary btn-lg" type="button">add profile image</button>
				</div>
				<div class="col-lg-12 col-md-12">
					<div class="cpartition"></div>
				</div>
				<div class="col-lg-12 col-md-12 text-center signup-buttom">
					<div class="btn-group">
						<input id= "artist_profile_submit" type="submit" name= "profilesubmit" class=" btn btn-danger  btn-lg" value = "submit" />
						<button type="button" class="  btn btn-danger  btn-lg" data-toggle="dropdown"> <span class="glyphicon glyphicon-log-in"></span> </button>
					</div>
				</div>
			</form>
			<input type= "hidden" value= "<?php echo $rest_fill; ?>" id ="rest_to_fill" />
			</div>
		</div>
		</div>
</div>


<?php
get_footer();

 
