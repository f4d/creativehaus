<?php
/*
 * Template Name: Artist Admin
 */ 
 
require_once(ABSPATH . "wp-admin" . '/includes/image.php');
require_once(ABSPATH . "wp-admin" . '/includes/file.php');
require_once(ABSPATH . "wp-admin" . '/includes/media.php'); 


$user_id = get_current_user_id();
global $wpdb;
$user_info = get_userdata($user_id); 
$user_firstname = $user_info->first_name;
$user_last_name = $user_info->last_name;
$user_city = get_user_field ("user_city");
$user_state = get_user_field ("user_state");
$user_zip = get_user_field ("user_zip");
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

$first_twenty = 1;
$second_twenty = 1;
$rest_fill = 0;
	if ( '' == $user_firstname ) {
		$first_twenty = 0;
	}
	if ( '' == $user_last_name ) {
		$first_twenty = 0;
	}
	if ( '' == $user_email ) {
		$first_twenty = 0;
	}
	if ( '' == $user_city ) {
		$first_twenty = 0;
	}
	if ( '' == $user_state ) {
		$first_twenty = 0;
	}
	if ( '' == $user_zip ) {
		$first_twenty = 0;
	}
	if ( '' == $user_biography ) {
		$first_twenty = 0;
	}
	if ( '' == $twitter_url ) {
		$second_twenty = 0;
	}
	if ( '' == $artist_url ) {
		$second_twenty = 0;
	}
	if ( '' == $itunes_url ) {
		$second_twenty = 0;
	}
	if ( '' == $facebook_url ) {
		$second_twenty = 0;
	}
	if ( '' == $google_plus ) {
		$second_twenty = 0;
	}
	
	

update_user_meta ( $user_id, 'soundhouse_artist', 'soundhouse_artist' );

$band_members = get_user_meta($user_id,"band_members",true);

/*
 * Check if artist is inserted in the custom post type
 */ 
$artist_id = get_user_meta($user_id,"artist_post_id",true);
$term_list = wp_get_post_terms($artist_id, 'artist_list', array("fields" => "names"));


if ( empty ( $artist_id ) || empty ($term_list) ) {
	
	$loction = get_permalink ( 213 );
	?>
		<script>
			window.location = "<?php echo $loction ; ?>";
		</script>
	<?php
}
get_header();
$press_items = get_user_meta($user_id,"press_items",true);
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

if ( isset ( $_POST['save_profile'] ) )  {
	if (!empty ($_FILES['user_profile_image']['tmp_name'])) {
		$profile_image_id = media_handle_upload( 'user_profile_image', 0 );
		update_user_meta ( $user_id, 'user_profile_image', $profile_image_id );
	    update_post_meta($artist_id, '_thumbnail_id', $profile_image_id); 
	
	}
	
	/*
	 * Adding multiple images
	 */ 
	if (!empty ($_FILES['user_multiple_images']['name']['0'])) {
		$files = $_FILES["user_multiple_images"];
		 $multiple_images = array();  
		foreach ($files['name'] as $key => $value) {             
                if ($files['name'][$key]) {
                    $file = array(
                        'name' => $files['name'][$key],
                         'type' => $files['type'][$key],
                        'tmp_name' => $files['tmp_name'][$key],
                        'error' => $files['error'][$key],
                        'size' => $files['size'][$key]
                    );
                    $_FILES = array ("multiple_attachments" => $file);
                    foreach ($_FILES as $file => $array) {                
						$newupload = media_handle_upload( $file,'0' );
						array_push($multiple_images, $newupload);
                    }
                }
            }
            if (!empty ( $_POST['hidden-artist-images-multi'] ) ) {
				foreach ( $_POST['hidden-artist-images-multi'] as $image ) : 
					array_push($multiple_images, $image);
				endforeach;
				
			}
			update_user_meta ( $user_id, 'user_multiple_image', $multiple_images );
	} else {
		$multiple_images = array();  
		if (!empty ( $_POST['hidden-artist-images-multi'] ) ) {
			foreach ( $_POST['hidden-artist-images-multi'] as $image ) : 
				array_push($multiple_images, $image);
			endforeach;
		}
		
		update_user_meta ( $user_id, 'user_multiple_image', $multiple_images );
		
	}
}
/******************
 * Save Artist Blog
 *****************/ 
if ( isset ( $_POST['artist_blog_save'] ) ) {
	$title  = $_POST['artist_blog_title'];
	$content = $_POST['artist_blog_content'];
	$my_post = array(
		'post_title'    => $title,
		'post_content'  => $content,
		'post_status'   => 'publish',
		'post_author'   => $user_id,
		'post_type'   => 'artist-blog'
	);
	// Insert the post into the database
	$artist_post_id = wp_insert_post( $my_post );
	$artist_blog_image = media_handle_upload( 'art_blog_image', $artist_post_id );
	update_post_meta($artist_post_id, '_thumbnail_id', $artist_blog_image);
}
$user_multiple_image = get_user_meta($user_id,"user_multiple_image",true);


/*******************
 * Save artist show
 ******************/ 
if ( isset ($_POST['save_artists_show'] ) ) {
	$venue_name = $_POST['venue_name'];
	$venue_address = $_POST['venue_address'];
	$venue_city = $_POST['venue_city'];
	$venue_state = $_POST['venue_state'];
	$venue_zip = $_POST['venue_zip'];
	$venue_dateofevent1 = $_POST['venue_dateofevent'];
	$no_of_shows = $_POST['no_of_shows'];
	$venue_cost = $_POST['venue_cost'];
	$venue_url = $_POST['venue_url'];
	$venue_timeofevent = $_POST['venue_timeofevent'];
	$recurring = $_POST['recurring_shows'];
	$venue_latitude = $_POST['venue_latitude'];
	$venue_longitude = $_POST['venue_longitude'];
	$location_table = $wpdb->prefix.'event_location';
	if ( $recurring == 'on') {
		$recuring_type = $_POST['recuring_type'];
		
		if (!empty ($_FILES['venueimage1']['tmp_name'])) {
			$artist_show_image1 = media_handle_upload( 'venueimage1', 0 );
		}
		if (!empty ($_FILES['venueimage2']['tmp_name'])) {
			$artist_show_image2 = media_handle_upload( 'venueimage2', 0 );
		}
		if (!empty ($_FILES['venueimage3']['tmp_name'])) {
			$artist_show_image3 = media_handle_upload( 'venueimage3', 0 );
		}
		
		$inc =0;
		while ( $inc < $no_of_shows )  {
			if ( $inc == 0) {
				$venue_dateofevent = strtotime( date("Y-m-d", strtotime($venue_dateofevent1)) );
			} else {
				if ('weekly' == $_POST['recuring_type']) {
					$venue_dateofevent = strtotime( date("Y-m-d", strtotime($venue_dateofevent1)) . " +$inc week");
				} else {
					$venue_dateofevent = strtotime( date("Y-m-d", strtotime($venue_dateofevent1)) . " +$inc month");
				}
			}
			$venue_dateofevent_full= date('Y-m-d',$venue_dateofevent);
			
			$inc++;
			$my_post_data = array(
				'post_title'    => $user_firstname.' '.$user_last_name ,
				'post_status'   => 'publish',
				'post_author'   => $user_id,
				'post_type'   => 'artist-events'
			);
			// Insert the post into the database
			$event_post_id = wp_insert_post( $my_post_data );
			update_post_meta ( $event_post_id, 'venue_name', $venue_name );
			update_post_meta ( $event_post_id, 'venue_address', $venue_address );
			update_post_meta ( $event_post_id, 'venue_city', $venue_city );
			update_post_meta ( $event_post_id, 'venue_state', $venue_state );
			update_post_meta ( $event_post_id, 'venue_zip', $venue_zip );
			update_post_meta ( $event_post_id, 'venue_dateofevent', $venue_dateofevent_full );
			update_post_meta ( $event_post_id, 'venue_cost', $venue_cost );
			update_post_meta ( $event_post_id, 'venue_url', $venue_url );
			update_post_meta ( $event_post_id, 'venue_timeofevent', $venue_timeofevent );
			update_post_meta ( $event_post_id, 'recurring', 'recurring' );
			if (!empty ($_FILES['venueimage1']['tmp_name'])) {
				update_post_meta($event_post_id, 'venueimage1', $artist_show_image1);
			}
			if (!empty ($_FILES['venueimage2']['tmp_name'])) {
				update_post_meta($event_post_id, 'venueimage2', $artist_show_image2);
			}
			if (!empty ($_FILES['venueimage3']['tmp_name'])) {
				update_post_meta($event_post_id, 'venueimage3', $artist_show_image3);
			}
			$location_query = "insert into $location_table ( event_id, longitude, latitude) values ( '$event_post_id', '$venue_longitude', '$venue_latitude') ";
			$wpdb->query($location_query);
			update_post_meta ( $event_post_id, 'venue_latitude', $venue_latitude );
			update_post_meta ( $event_post_id, 'venue_longitude', $venue_longitude );
		}
	} else {
		$my_post_data = array(
		'post_title'    => $user_firstname.' '.$user_last_name ,
		'post_status'   => 'publish',
		'post_author'   => $user_id,
		'post_type'   => 'artist-events'
		);
		// Insert the post into the database
		$event_post_id = wp_insert_post( $my_post_data );
		$venue_dateofevent = strtotime( date("Y-m-d", strtotime($venue_dateofevent1)) );
		$venue_dateofevent_full= date('Y-m-d',$venue_dateofevent);
		update_post_meta ( $event_post_id , 'venue_name', $venue_name );
		update_post_meta ( $event_post_id , 'venue_address', $venue_address );
		update_post_meta ( $event_post_id , 'venue_city', $venue_city );
		update_post_meta ( $event_post_id , 'venue_state', $venue_state );
		update_post_meta ( $event_post_id , 'venue_zip', $venue_zip );
		update_post_meta ( $event_post_id , 'venue_dateofevent', $venue_dateofevent_full );
		update_post_meta ( $event_post_id , 'venue_cost', $venue_cost );
		update_post_meta ( $event_post_id , 'venue_url', $venue_url );
		update_post_meta ( $event_post_id , 'venue_timeofevent', $venue_timeofevent );
		if (!empty ($_FILES['venueimage1']['tmp_name'])) {
			$artist_show_image1 = media_handle_upload( 'venueimage1', 0 );
			update_post_meta($event_post_id, 'venueimage1', $artist_show_image1);
		}
		if (!empty ($_FILES['venueimage2']['tmp_name'])) {
			$artist_show_image2 = media_handle_upload( 'venueimage2', 0 );
			update_post_meta($event_post_id, 'venueimage2', $artist_show_image2);
		}
		if (!empty ($_FILES['venueimage3']['tmp_name'])) {
			$artist_show_image3 = media_handle_upload( 'venueimage3', 0 );
			update_post_meta($event_post_id, 'venueimage3', $artist_show_image3);
		}
		$location_query = "insert into $location_table ( event_id, longitude, latitude) values ( '$event_post_id', '$venue_longitude', '$venue_latitude') ";
		$wpdb->query($location_query);
		update_post_meta ( $event_post_id, 'venue_latitude', $venue_latitude );
		update_post_meta ( $event_post_id, 'venue_longitude', $venue_longitude );
	}
}



/*************************
 * Edit show functionality
 ************************/ 
if ( isset ($_POST['save_artists_show_edit'] ) ) {
	$location_table = $wpdb->prefix.'event_location';
	$event_post_id = $_POST['show_to_edit'];
	$venue_name = $_POST['venue_name_edit'];
	$venue_address = $_POST['venue_address_edit'];
	$venue_city = $_POST['venue_city_edit'];
	$venue_state = $_POST['venue_state_edit'];
	$venue_zip = $_POST['venue_zip_edit'];
	$venue_dateofevent1 = $_POST['venue_dateofevent_edit'];
	if (isset ( $_POST['no_of_shows_edit'] ) ) {
		$no_of_shows = $_POST['no_of_shows_edit'];
	}
	$venue_cost = $_POST['venue_cost_edit'];
	$venue_url = $_POST['venue_url_edit'];
	$venue_timeofevent = $_POST['venue_timeofevent_edit'];
	$venue_dateofevent = strtotime( date("Y-m-d", strtotime($venue_dateofevent1)) );
	$venue_dateofevent_full= date('Y-m-d',$venue_dateofevent);
	$venue_latitude = $_POST['venue_latitude_edit'];
	$venue_longitude = $_POST['venue_longitude_edit'];
	
	update_post_meta ( $event_post_id, 'venue_name', $venue_name );
	update_post_meta ( $event_post_id, 'venue_address', $venue_address );
	update_post_meta ( $event_post_id, 'venue_city', $venue_city );
	update_post_meta ( $event_post_id, 'venue_state', $venue_state );
	update_post_meta ( $event_post_id, 'venue_zip', $venue_zip );
	update_post_meta ( $event_post_id, 'venue_dateofevent', $venue_dateofevent_full );
	update_post_meta ( $event_post_id, 'venue_cost', $venue_cost );
	update_post_meta ( $event_post_id, 'venue_url', $venue_url );
	update_post_meta ( $event_post_id, 'venue_timeofevent', $venue_timeofevent );
	
	if (!empty ($_FILES['venueimage1_edit']['tmp_name'])) {
		$artist_show_image1 = media_handle_upload( 'venueimage1_edit', 0 );
		update_post_meta($event_post_id, 'venueimage1', $artist_show_image1);
	}
	if (!empty ($_FILES['venueimage2_edit']['tmp_name'])) {
		$artist_show_image2 = media_handle_upload( 'venueimage2_edit', 0 );
		update_post_meta($event_post_id, 'venueimage2', $artist_show_image2);
	}
	if (!empty ($_FILES['venueimage3_edit']['tmp_name'])) {
		$artist_show_image3 = media_handle_upload( 'venueimage3_edit', 0 );
		update_post_meta($event_post_id, 'venueimage3', $artist_show_image3);
	}
	if  ( $venue_latitude != '' ) {
		$location_query = "update $location_table set  longitude = '$venue_longitude' , latitude = '$venue_latitude' where event_id = '$event_post_id' ";
		$wpdb->query($location_query);
		update_post_meta ( $event_post_id, 'venue_latitude', $venue_latitude );
		update_post_meta ( $event_post_id, 'venue_longitude', $venue_longitude );
	}
} 


/******************
 * Save Artist Blog
 ******************/ 
if ( isset ( $_POST['save_song'] ) ) {
	$title  = $_POST['song_name'];
	$artist_album_select = $_POST['artist_album_select'];
	$artist_album_select_arr = array();
	array_push ( $artist_album_select_arr, $artist_album_select );
	$attachment_id  = $_POST['aaiu_image_id'];
	$post_content = wp_get_attachment_url($attachment_id);
	$my_post = array(
		'post_title'    => $title,
		'post_status'   => 'publish',
		'post_content'  => $post_content,
		'post_author'   => $user_id,
		'post_type'   => 'artist-songs',
		'tax_input' => array( 'artist-songs-list' => $artist_album_select_arr )
	);
	// Insert the post into the database
	$artist_song_id = wp_insert_post( $my_post );
	update_post_meta ( $artist_song_id, 'song_id', $attachment_id );
	set_post_format( $artist_song_id, 'audio' );
}

/*******************
 * Save Video Songs
 * ************************/
if ( isset ( $_POST['video_save_song'] ) ) {
	$title  = $_POST['video_song_name'];
	$attachment_id  = $_POST['aaivu_image_id'];
	$post_content = wp_get_attachment_url($attachment_id);
	echo 'coming in';
	$my_post = array(
		'post_title'    => $title,
		'post_status'   => 'publish',
		'post_content'  => $post_content,
		'post_author'   => $user_id,
		'post_type'   => 'artist-songs'
	);
	// Insert the post into the database
	$artist_song_id = wp_insert_post( $my_post );
	update_post_meta ( $artist_song_id, 'song_id', $attachment_id );
	set_post_format( $artist_song_id, 'video' );
}
$user_multiple_image = get_user_meta($user_id,"user_multiple_image",true);
$term_list = wp_get_post_terms($artist_id, 'artist_list', array("fields" => "names"));


?>

<!--- Audio Songs Pop Up ---->
<div class="modal fade" id="songspopup">
  <div class="modal-dialog">
    <div class="modal-content">
    <form class="form-inline" method= "post" role="form" enctype="multipart/form-data" id= "song_add_form" >
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h4 class="modal-title">Add Song</h4>
		</div>
		<div class="modal-body">
			<div class= "admin-songs-idv">
				<div class="form-group col-lg-6 col-md-6 col-sm-6">
					<input type="text" name= "song_name" id= "song_name" class="form-control"  placeholder="Song Name">
					<div class = "error" id= "song_name_error" ></div>
				</div>
				<div class="form-group  col-lg-6 col-md-6 col-sm-6">
					<?php 
					echo do_shortcode('[AAIU theme="true"]'); 
					?>
					<div class="clearfix"></div>
					<div class = "soundhouse_errors" id= "song_song_error" ></div>
				</div>
			</div>
			<div class= "admin-songs-idv">
				<div class="form-group  col-lg-6 col-md-6 col-sm-6">
					<?php
						$wp_options = $wpdb->prefix."options";
						$search_user = 'album_user_'.$user_id;
						$search_tax_query = "select * from $wp_options where option_value= '$search_user' ";
						$search_tax_res = $wpdb->get_results($search_tax_query);
						$albums_arr = array();
						foreach ( $search_tax_res as $album_id_tax) {
							$album_id =  substr($album_id_tax->option_name,12);
							array_push($albums_arr , $album_id);
						}
					?>
					<div id= "artist_album_select_div" >
					<select class = "selectpicker" name= "artist_album_select" id= "artist_album_select" >
						<?php if ( !empty ( $albums_arr ) )  : ?>
							<option value= "-1">Select Album</option>
							<?php
								$artsttaxonomy = 'artist-songs-list';
								$artist_tax_terms = get_terms($artsttaxonomy,array( 'orderby' => 'name', 'hide_empty' => false ));
								foreach ($artist_tax_terms as $artist_tax_term) 
								{
									if (in_array($artist_tax_term->term_id, $albums_arr)) {
										echo '<option value= "'.$artist_tax_term->term_id.'" >'.$artist_tax_term->name.'</option>';
									}
								}
								?>
						<?php else : ?>
							<option value= "-1">No album added</option>
						<?php endif; ?>
					</select>
					<div class = "error" id= "album_select_error" ></div>
					</div>
				</div>
				<div class="form-group  col-lg-6 col-md-6 col-sm-6">
					<input id= "create_album_name" type = "text" name= "artist_album" value "" class="form-control"  placeholder="Create New Album" />
					
					<div class = "error" id= "album_name_error" ></div>
					<button id= "create_album" type="submit" class=" button-info btn btn-primary btn-md" name= "create_album" >Save Album</button>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<div class="col-lg-12 col-md-12 col-xs-12 text-left">
				<input id= "save_song_click" type="submit" class="button-save btn btn-primary" value ="Save changes" name= "save_song" />
			</div>
		</div>
		</form>
    </div>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>
<!-- /.Audio songs pop up modal --> 

<!---- Video Songs pop up------>
<div class="modal fade" id="videosongspop">
	<div class="modal-dialog">
		<form class="form-inline" role="form" method ="post">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Add Video Song</h4>
			</div>
			<div class="modal-body">
				
					<div class="form-group col-lg-6 col-md-6 col-sm-6">
						<input id= "video_song_name" name= "video_song_name" type="text" class="form-control"  placeholder="Song Name">
						<div class = "error" id= "video_song_name_error" ></div>
					</div>
					<div class="form-group  col-lg-6 col-md-6 col-sm-6">
						<?php 
							echo do_shortcode('[AAIVU theme="true"]'); 
						?>
						<div class = "error" id= "video_song_error" ></div>
					</div>
				
			</div>
			<div class="modal-footer">
				<div class="col-lg-12 col-md-12 col-xs-12 text-left">
					<input id= "video_save_song_click" type="submit" class="button-save btn btn-primary" value ="Save changes" name= "video_save_song" />
				</div>
			</div>
		</div>
		<!-- /.modal-content --> 
		</form>
	</div>
	<!-- /.modal-dialog --> 
</div>
<!-- /. video songs modal --> 


<!--- add shows pop up -->
<div class="modal fade" id="artistshows">
	<div class="modal-dialog">
		
		<div class="modal-content">
			<form enctype="multipart/form-data" class="form-inline" role="form" method = "post" >
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Add Show</h4>
			</div>
			<div class="modal-body">
				
					<div class= "venue_details">
						<div class="form-group  col-lg-4 col-md-4 col-sm-4">
							<input id= "venue_name" name= "venue_name" type = "text" class="geoloc form-control"  placeholder = "Venue name">
							<div class = "error" id= "venue_name_error" ></div>
						</div>
						<div class="form-group  col-lg-4 col-md-4 col-sm-4">
							<input id= "venue_address" name= "venue_address" type = "text" class="geoloc form-control"  placeholder = "Address">
							<div class = "error" id= "venue_address_error" ></div>
						</div>
						<div class="form-group  col-lg-4 col-md-4 col-sm-4">
							<input id= "venue_city" name= "venue_city" type = "text" class="geoloc form-control"  placeholder = "City">
							<div class = "error" id= "venue_city_error" ></div>
						</div>
					</div>
					<div class= "venue_details">
						<div class="form-group  col-lg-4 col-md-4 col-sm-4">
							<input id= "venue_state" name= "venue_state" type = "text" class = "form-control"  placeholder = "State">
							<div class = "error" id= "venue_state_error" ></div>
						</div>
						<div class="form-group  col-lg-4 col-md-4 col-sm-4">
							<input id= "venue_zip" name= "venue_zip" type = "text" class = "form-control"  placeholder = "Zip Code">
							<div class = "error" id= "venue_zip_error" ></div>
						</div>
						<div class="form-group  col-lg-4 col-md-4 col-sm-4">
							<input name= "venue_dateofevent" id="startdate" type = "text" class = "form-control"  placeholder = "Date of event">
							<div class = "error" id= "venue_dateofevent_error" ></div>
						</div>
					</div>
					<div class= "venue_details">
						<div class="form-group  col-lg-4 col-md-4 col-sm-4">
							<input name= "venue_timeofevent" id="timeofevent" type = "text" class = "form-control"  placeholder = "Time of event">
							<div class = "error" id= "venue_timeofevent_error" ></div>
						</div>
						<div class="form-group  col-lg-4 col-md-4 col-sm-4">
							<input id= "venue_cost" name= "venue_cost" type = "text" class="form-control"  placeholder = "Cost of event">
							<div class = "error" id= "venue_cost_error" ></div>
						</div>
						<div class="form-group  col-lg-4 col-md-4 col-sm-4">
							<input id= "venue_url" name = "venue_url" type = "text" class = "form-control"  placeholder = "Venue Url">
							<div class = "error" id= "venue_url_error" ></div>
						</div>
					</div>
					<div class= "venue_details">
						<div class="form-group  col-lg-4 col-md-4 col-sm-4">
							<div id= "show_venue_image_1">
							</div>
							<input type= "file" onchange = "show_venue_image1(this);" name= "venueimage1" />
						</div>
						<div class="form-group  col-lg-4 col-md-4 col-sm-4">
							<div id= "show_venue_image_2">
							</div>
							<input type= "file" onchange = "show_venue_image2(this);" name= "venueimage2" />
						</div>
						<div class="form-group  col-lg-4 col-md-4 col-sm-4">
							<div id= "show_venue_image_3">
							</div>
							<input type= "file" onchange = "show_venue_image3(this);" name= "venueimage3" />
						</div>
					</div>
					
					<div class= "venue_details">
						<div class="form-group  col-lg-4 col-md-4 col-sm-4">
							<span>Recurring Show ? </span> <input name= "recurring_shows" type = "checkbox" class = "recurring_shows_class" id = "recurring_shows" />
						</div>
						<div style = "display:none" class="recuring_type_div form-group  col-lg-4 col-md-4 col-sm-4">
							<select name= "recuring_type" class="recuring_type_class selectpicker" id = "recuring_type">
								<option value = "weekly" >Weekly</option>
								<option value = "monthly" >Monthly</option>
							</select>
						</div>
						<div style = "display:none" class="no_of_shows_div form-group  col-lg-4 col-md-4 col-sm-4">
							<input name= "no_of_shows" id="no_of_shows" type = "text" class = "form-control"  placeholder = "No of shows">
							<div class = "error" id= "venue_nos_error" ></div>
						</div>
					</div>
					<input type= "hidden" id= "venue_latitude" name= "venue_latitude" value = "" />
					<input type= "hidden" id= "venue_longitude" name= "venue_longitude" value = "" />
			</div>
			<div class="modal-footer">
				<div class="col-lg-12 col-md-12 col-xs-12 text-left">
					<!-- <button id= "save_artists_show" type="button" class="button-save btn btn-primary">Save changes</button> -->
					<input name= "save_artists_show" id= "save_artists_show" type="submit" value ="Save changes" class="button-save btn btn-primary" />
					<div id = "ajax_loader_show" style= "display:none" ><img src= "<?php bloginfo('template_url'); ?>/images/ajaxloader.gif" /></div>
				</div>
			</div>
			</form>
		</div>
		<!-- /.modal-content --> 
	</div>
	<!-- /.modal-dialog --> 
</div>
<!-- /.add shows modal edn --> 

<!--- edit shows pop up -->
<div class="modal fade" id="artistshows-edit">
	<div class="modal-dialog">
		<div class="modal-content">
		<form enctype="multipart/form-data" class="form-inline" role="form" method = "post" >
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Edit Show</h4>
			</div>
			<div class="modal-body edit-show-box" id= 'edit-show-form'>
			</div>
			<div class="modal-footer">
				<div class="col-lg-12 col-md-12 col-xs-12 text-left">
					<!-- <button id= "save_artists_show_edit" type="button" class="button-save btn btn-primary">Save changes</button> -->
					<input name= "save_artists_show_edit" id= "save_artists_show_edit" type="submit" value ="Save changes" class="button-save btn btn-primary" />
					<div id = "ajax_loader_show_edit" style= "display:none" >
						<img src= "<?php bloginfo('template_url'); ?>/images/ajaxloader.gif" />
					</div>
				</div>
			</div>
		</form>
		</div>
		<!-- /.modal-content --> 
	</div>
	<!-- /.modal-dialog --> 
</div>
<!-- /.add shows modal edn --> 


<!---Artist blog writing section --->
<div class="modal fade" id="artistblog">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method= "post" enctype="multipart/form-data" class="form-inline" role="form">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title">Write Blog</h4>
					<div class="form-group col-lg-12 col-md-12 col-sm-12" id= "blog-content-title" >
						<div class="form-group col-lg-6 col-md-6 col-sm-6">
							<input type="text" maxlength = "50" name= "artist_blog_title" id= "artist_blog_title" class="form-control"  placeholder="Title">
							<div class= "error" id= "artist_blog_title_error" ></div>
						</div>
						<div class="form-group col-lg-3 col-md-3 col-sm-3">
							<button id= "add_artist_blog_image_trig" class=" button-info btn btn-primary btn-lg" type="button">Add image</button>
							<div style= "display:none">
								<input type="file"  onchange = "artist_blog_image(this)" name= "art_blog_image" id= "add_artist_blog_image">
							</div>
							<div class= "error" id= "artist_blog_image_error" ></div>
						</div>
					</div>
					<div class="form-group col-lg-12 col-md-12 col-sm-12">
						<div class="form-group  col-lg-6 col-md-6 col-sm-6">
							<textarea name= "artist_blog_content" maxlength = "1000" cols= "50" id= "artist_blog_content" rows= "15" placeholder="Content" class="form-control"></textarea>
							<div class= "error" id= "artist_blog_content_error" ></div>
						</div>
						<div id= "artist_blog_featured_image" class="form-group  col-lg-6 col-md-6 col-sm-6">
						</div>
					</div>
				</div>
				<div class="modal-body">
				</div>
				<div class="modal-footer">
					<div class="col-lg-12 col-md-12 col-xs-12 text-left"> 
						<input type="submit" class=" button-save btn btn-primary btn-lg" id= "artist_blog_save" name= "artist_blog_save" value= "Save Blog" / >
					</div>
				</div>
			</form>
		</div>
		<!-- /.modal-content --> 
	</div>
	<!-- /.modal-dialog --> 
</div>

<!---Artist press section section --->
<div class="modal fade" id="press_items">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Press Items</h4>
				<form class="form-inline" role="form">
					<div class = "press-items-div">
					<?php
					if (!empty ($press_items))  :
					$countpress = 0;
					foreach ( $press_items as $key =>$press ) : 
					$countpress++;
					?>
					<div  class= "press-items-class">
						<div id= "items-div-<?php echo $countpress; ?>" class = "col-lg-11 col-md-11 col-sm-11" >
							<div class="form-group col-lg-3 col-md-3 col-sm-3">
								<input value = "<?php echo $press['date_of_release'] ; ?>" type="text"  id= "date_of_release_<?php echo $countpress; ?>" class="date_of_release form-control"  placeholder="Date of Release">
								<div class = "error" id= "date_of_release_error_<?php echo $countpress; ?>" ></div>
							</div>
							<div class="form-group  col-lg-3 col-md-3 col-sm-3">
								<input value = "<?php echo $press['publication_name'] ; ?>" type="text" id= "publication_name_<?php echo $countpress; ?>" class="form-control"  placeholder="Publication Name">
								<div class = "error" id= "publication_name_error_<?php echo $countpress; ?>" ></div>
							</div>
							<div class="form-group  col-lg-3 col-md-3 col-sm-3">
								<input value = "<?php echo $press['title_of_article'] ; ?>" type="text" id= "title_of_article_<?php echo $countpress; ?>" class="form-control"  placeholder="Title of Article">
								<div class = "error" id= "title_of_article_error_<?php echo $countpress; ?>" ></div>
							</div>
							<div class="form-group  col-lg-3 col-md-3 col-sm-3">
								<input value = "<?php echo $press['link_to_article'] ; ?>" type="text" id= "link_to_article_<?php echo $countpress; ?>" class="form-control"  placeholder="Link to Article">
								<div class = "error" id= "link_to_article_error_<?php echo $countpress; ?>" ></div>
							</div>
							<div class="clearfix"></div>
						</div>
						<div id= "items-div-delete-<?php echo $countpress; ?>" class = "itesms-delete col-lg-1 col-md-1 col-sm-1">
							<a href= "javascript:;">Delete</a>
						</div>
					</div>
					<?php endforeach; ?>
					<?php else : ?>
					<div class= "press-items-class">
						<div id= "items-div-1" class = "col-lg-11 col-md-11 col-sm-11">
							<div class="form-group col-lg-3 col-md-3 col-sm-3">
								<input type="text"  id= "date_of_release_1" class="date_of_release form-control"  placeholder="Date of Release">
								<div class = "error" id= "date_of_release_error_1" ></div>
							</div>
							<div class="form-group  col-lg-3 col-md-3 col-sm-3">
								<input type="text" id= "publication_name_1" class="form-control"  placeholder="Publication Name">
								<div class = "error" id= "publication_name_error_1" ></div>
							</div>
							<div class="form-group  col-lg-3 col-md-3 col-sm-3">
								<input type="text" id= "title_of_article_1" class="form-control"  placeholder="Title of Article">
								<div class = "error" id= "title_of_article_error_1" ></div>
							</div>
							<div class="form-group  col-lg-3 col-md-3 col-sm-3">
								<input type="text" id= "link_to_article_1" class="form-control"  placeholder="Link to Article">
								<div class = "error" id= "link_to_article_error_1" ></div>
							</div>
						<div class="clearfix"></div>
						</div>
						<div id= "items-div-delete-1" class = "itesms-delete col-lg-1 col-md-1 col-sm-1">
							<a href= "javascript:;">Delete</a>
						</div>
					</div>
					<?php endif; ?>	
					</div>
				</form>
			</div>
			<div class="modal-body">
				<div class="col-lg-6 col-md-6 col-xs-6"> <button id= "add_more_press" class=" button-info btn btn-primary btn-md" type="button">Add press item</button></div>
			</div>
			<div class="modal-footer">
				<div class="col-lg-12 col-md-12 col-xs-12 text-left">
					<button type="button" id= "save_press_items" class="button-save btn btn-primary">Save changes</button>
					<div id ="ajax_loader_press" style= "display:none" ><img src= "<?php bloginfo('template_url'); ?>/images/ajaxloader.gif" /></div>
				</div>
			</div>
		</div>
		<?php if (!empty ($press_items))  : ?>
			<input type = "hidden" id = "hidden_press_items_count" name= "hidden_press_items_count" value = "<?php echo $countpress; ?>" />
		<?php else : ?>
			<input type = "hidden" id = "hidden_press_items_count" name= "hidden_press_items_count" value = "1" />
		<?php endif; ?>
		<!-- /.modal-content --> 
	</div>
	<!-- /.modal-dialog --> 
</div>
<!-- /.modal --> 

<!---band members section --->
<div class="modal fade" id="bandmember">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">who is in your band?</h4>
        
         <form class="form-inline" role="form" enctype="multipart/form-data">
        <label class="heading-label">Add Yourself</label>
        <?php
			
		   ?>
          <div class="form-group col-lg-4 col-md-4 col-sm-4">
            <input value= "<?php echo $adminname; ?>" id = "artistname_admin" name = "artistname_admin" type="text" class="form-control artistname"  placeholder="Artist Name">
            <div class = "error" id= "artist_error_admin" ></div>
          </div>
          <div class="form-group  col-lg-4 col-md-4 col-sm-4">
            <input value= "<?php echo $adminemail; ?>" type="text" id = "artistemail_admin" class="form-control artistemail"  placeholder="Email Address">
            <div class = "error" id= "artistemail_error_admin" ></div>
          </div>
          <div class="form-group selectpicker col-lg-4 col-md-4 col-sm-4">
           	<select class="turnintodropdown artistgenre selectpicker" id = "artistgenre_admin">
				<option <?php if ($admingenre == 'Vocals') echo 'selected == "selected"'; ?> >Vocals</option>
				<option <?php if ($admingenre == 'Guitar') echo 'selected == "selected"'; ?> >Guitar</option>
				<option <?php if ($admingenre == 'Bass') echo 'selected == "selected"'; ?> >Bass</option>
				<option <?php if ($admingenre == 'Piano') echo 'selected == "selected"'; ?> >Piano</option>
  				<option <?php if ($admingenre == 'Keyboard') echo 'selected == "selected"'; ?> >Keyboard</option>
  				<option <?php if ($admingenre == 'Drums') echo 'selected == "selected"'; ?> >Drums</option>
  				<option <?php if ($admingenre == 'Congos') echo 'selected == "selected"'; ?> >Congos</option>
  				<option <?php if ($admingenre == 'Cello') echo 'selected == "selected"'; ?> >Cello</option>
  				<option <?php if ($admingenre == 'Violin') echo 'selected == "selected"'; ?> >Violin</option>
  				<option <?php if ($admingenre == 'Glockenspiel') echo 'selected == "selected"'; ?> >Glockenspiel</option>
  				<option <?php if ($admingenre == 'Organ') echo 'selected == "selected"'; ?> >Organ</option>
  				<option <?php if ($admingenre == 'Viola') echo 'selected == "selected"'; ?> >Viola</option>
  				<option <?php if ($admingenre == 'Saxophone') echo 'selected == "selected"'; ?> >Saxophone</option>
  				<option <?php if ($admingenre == 'Trumpet') echo 'selected == "selected"'; ?> >Trumpet</option>
  				<option <?php if ($admingenre == 'Trombone') echo 'selected == "selected"'; ?> >Trombone</option>
  				<option <?php if ($admingenre == 'Tuba') echo 'selected == "selected"'; ?> >Tuba</option>
			</select>
          </div>
          <div class="clearfix"></div>
        
          </form>
        
      </div>
      <div class="modal-body">
        <form class="form-inline" role="form" enctype="multipart/form-data">
        <label class="heading-label">Add Members</label>
				<div class = "members-div" id= "member-div-1" >
				
				<?php
				
				if (!empty ($band_members))  :
				$countband = 0;
				foreach ( $band_members as $key =>$band ) : 
				$countband++;
				 ?>
				
					<div class="form-group col-lg-4 col-md-4 col-sm-4">
						<input value = "<?php echo $band['artistname'] ; ?>" type="text" id = "artistname_<?php echo $countband; ?>" class="form-control artistnamenew"  placeholder="Artist Name">
						<div class = "soundhouse_errors" id= "artist_error_<?php echo $countband; ?>" ></div>
					  </div>
					<div class="form-group  col-lg-4 col-md-4 col-sm-4">
						<input value = "<?php echo $band['artistemail'] ; ?>" type="text" id = "artistemail_<?php echo $countband; ?>" class="form-control artistemail"  placeholder="Email Address">
						<div class = "soundhouse_errors" id= "artistemail_error_<?php echo $countband; ?>" ></div>
					  </div>
					<div class="form-group  col-lg-4 col-md-4 col-sm-4">
						<select class="turnintodropdown artistgenre selectpicker" id = "artistgenre_<?php echo $countband; ?>">
							<option <?php if ($band['artistgenre'] == 'Vocals') echo 'selected == "selected"'; ?> >Vocals</option>
							<option <?php if ($band['artistgenre'] == 'Guitar') echo 'selected == "selected"'; ?> >Guitar</option>
							<option <?php if ($band['artistgenre'] == 'Bass') echo 'selected == "selected"'; ?> >Bass</option>
							<option <?php if ($band['artistgenre'] == 'Piano') echo 'selected == "selected"'; ?> >Piano</option>
							<option <?php if ($band['artistgenre'] == 'Keyboard') echo 'selected == "selected"'; ?> >Keyboard</option>
							<option <?php if ($band['artistgenre'] == 'Drums') echo 'selected == "selected"'; ?> >Drums</option>
							<option <?php if ($band['artistgenre'] == 'Congos') echo 'selected == "selected"'; ?> >Congos</option>
							<option <?php if ($band['artistgenre'] == 'Cello') echo 'selected == "selected"'; ?> >Cello</option>
							<option <?php if ($band['artistgenre'] == 'Violin') echo 'selected == "selected"'; ?> >Violin</option>
							<option <?php if ($band['artistgenre'] == 'Glockenspiel') echo 'selected == "selected"'; ?> >Glockenspiel</option>
							<option <?php if ($band['artistgenre'] == 'Organ') echo 'selected == "selected"'; ?> >Organ</option>
							<option <?php if ($band['artistgenre'] == 'Viola') echo 'selected == "selected"'; ?> >Viola</option>
							<option <?php if ($band['artistgenre'] == 'Saxophone') echo 'selected == "selected"'; ?> >Saxophone</option>
							<option <?php if ($band['artistgenre'] == 'Trumpet') echo 'selected == "selected"'; ?> >Trumpet</option>
							<option <?php if ($band['artistgenre'] == 'Trombone') echo 'selected == "selected"'; ?> >Trombone</option>
							<option <?php if ($band['artistgenre'] == 'Tuba') echo 'selected == "selected"'; ?> >Tuba</option>
					</select>
					</div>
					<div class="clearfix"></div>
					<?php endforeach ; ?>
					<?php else: ?>
						<div class="form-group col-lg-4 col-md-4 col-sm-4">
						<input type="text"  id = "artistname_1" class="form-control artistnamenew"  placeholder="Artist Name">
						<div class = "error" id= "artist_error_1" ></div>
					  </div>
					<div class="form-group  col-lg-4 col-md-4 col-sm-4">
						<input type="text" id = "artistemail_1" class="form-control artistemail"  placeholder="Email Address">
						<div class = "error" id= "artistemail_error_1" ></div>
					  </div>
					<div class="form-group  col-lg-4 col-md-4 col-sm-4">
						<select class="turnintodropdown artistgenre selectpicker" id = "artistgenre_1">
							<option>Vocals</option>
							<option>Guitar</option>
							<option>Bass</option>
							<option>Piano</option>
							<option>Keyboard</option>
							<option>Drums</option>
							<option>Congos</option>
							<option>Cello</option>
							<option>Violin</option>
							<option>Glockenspiel</option>
							<option>Organ</option>
							<option>Viola</option>
							<option>Saxophone</option>
							<option>Trumpet</option>
							<option>Trombone</option>
							<option>Tuba</option>
					</select>
					</div>
					<div class="clearfix"></div>
				<?php endif; ?>
				</div>
		<div class="col-lg-6 col-md-6 col-xs-6"> 
			<button id= "band_member_add" class=" button-info btn btn-primary btn-md" type="button">Add members</button></div>
        </form>
      </div>
      <div class="modal-footer">
        <div class="col-lg-12 col-md-12 col-xs-12 text-left"> 
			<button type="button" class="button-save btn btn-primary" id= "artist-admin-band">Save changes</button>
			<div id ="ajax_loader" style= "display:none" ><img src= "<?php bloginfo('template_url'); ?>/images/ajaxloader.gif" /></div>
		</div>
      </div>
    </div>
    <!-- /.modal-content --> 
  </div>
  <?php if (!empty ($band_members))  : ?>
		<input type = "hidden" id = "hidden_count_band" name= "hidden_count_band" value = "<?php echo $countband; ?>" />
	<?php else : ?>
		<input type = "hidden" id = "hidden_count_band" name= "hidden_count_band" value = "1" />
  <?php endif; ?>
  <!-- /.modal-dialog --> 
</div>


    <div class="inner-content-area">
		<form method = "post"  enctype="multipart/form-data">
        <div class="fancy-header">
          <ul>
            <li>
              <h1><?php echo $user_firstname.' '.$user_last_name; ?> -</h1>
            </li>
            <li>
              <h1><?php echo $user_city; ?>, <?php echo $user_state; ?></h1>
            </li>
            <li>
              <h1><?php if (!empty ($term_list) ) echo $term_list['0'];?> <sup><a href= "<?php echo get_permalink(213); ?>">EDIT</a></sup></h1>
            </li>
          </ul>
          <br clear="all">
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
            <div id = "progress-bar-filled" class="progress-bar progress-bar-success progress-bar-striped active" style="width: 35%"> <span class="sr-only">20%</span> </div>
            <div id = "progress-bar-remaining" class="progress-bar progress-bar-warning " style="width: 63%"> <span class="sr-only">50% Complete (warning)</span> </div>
            <div class="progress-bar progress-bar-success progress-bar-striped " style="width: 2%"> <span class="sr-only">10% Complete (danger)</span> </div>
          </div>
          <div class="eidtable-info">
            <div class="row">
              <div class="col-lg-4 col-md-4 col-xs-12">
                <div class="photos">
                <?php
                $image1 = get_user_meta($user_id,"user_profile_image",true);
                
                ?>
					<div class="main-img">
						<div id= "main-img-hover"></div>
						<?php
						if ( !empty ($image1 ) ) :
							$img1 = wp_get_attachment_image_src($image1, 'admin-artist-profile-pic');
							echo '<input type = "hidden" name= "previous_profile_image" value = "'.$image1	.'" />';
							?>
							<img id= "profi-im" src="<?php echo $img1['0']; ?>" alt="photo" class="img-responsive"/>
						<?php else : ?>
							<?php $second_twenty =0; ?>
							<img src="<?php bloginfo('template_url');?>/images/photo1.png" alt="photo" class="img-responsive"/>
						<?php endif; ?>
					</div>
					<div >
						<input style = "display:none" type="file" name="user_profile_image" id="user_profile_image" onchange="admin_profileimage(this);" ><br>
					</div>
                  <div class="row  navigation">
					<?php if ( !empty ( $user_multiple_image ) ) : ?>
					<?php $rest_fill++; ?>
					<?php $countmultiple_image = 0; ?>
					<?php foreach ( $user_multiple_image as $image ) : ?>
						<?php $countmultiple_image++; ?>
						<div class="col-lg-3 col-md-3 col-xs-3 user_multiple_images_add" id= "user-multiple-images-<?php echo $countmultiple_image; ?>" >
							<div class= "delete-multi-image" id= "delete-multi-image-<?php echo $countmultiple_image; ?>"><a href= "javascript:;"><img src= "<?php bloginfo('template_url'); ?>/images/close.png" /></a></div>
							<?php $img1 = wp_get_attachment_image_src($image, 'admin-artist-multiple-pic'); ?>
							<img src="<?php echo $img1['0']; ?>" alt="photo" class="img-responsive"/>
							<input type= "hidden" value = "<?php echo $image; ?>" class= "hidden-artist-images-multi" name= "hidden-artist-images-multi[]" id= "hidden-artist-images-multi-<?php echo $countmultiple_image; ?>" >
						</div>
					<?php endforeach; ?>
						<?php if ($countmultiple_image < 4 ) : ?>
							<?php while( $countmultiple_image < 4 ) : ?>
								<?php $countmultiple_image++; ?>
								<div class="col-lg-3 col-md-3 col-xs-3 user_multiple_images_add">
									<div class="thumb-img text-center"><span class="glyphicon glyphicon-plus"></span></div>
								</div>
							<?php endwhile; ?>
						<?php endif; ?>
					<?php else : ?>
						<div class="col-lg-3 col-md-3 col-xs-3 user_multiple_images_add">
						  <div class="thumb-img text-center"><span class="glyphicon glyphicon-plus"></span></div>
						</div>
						<div class="col-lg-3 col-md-3 col-xs-3 user_multiple_images_add">
						  <div class="thumb-img text-center"><span class="glyphicon glyphicon-plus"></span></div>
						</div>
						<div class="col-lg-3 col-md-3 col-xs-3 user_multiple_images_add">
						  <div class="thumb-img text-center"><span class="glyphicon glyphicon-plus"></span></div>
						</div>
						<div class="col-lg-3 col-md-3 col-xs-3 user_multiple_images_add">
						  <div class="thumb-img text-center"><span class="glyphicon glyphicon-plus"></span></div>
						</div>
					<?php endif; ?>
                  </div>
                  <button type="button" class="user_multiple_images_add button-info btn btn-primary btn-lg">add photos</button>
                  <div style = "display:none" >
						<input  type="file" name="user_multiple_images[]" id="user_multiple_images"  multiple = "multiple" ><br>
						<input type= "hidden" name= "hidddeeeen" value ="18" />
					</div>
                </div>
                <div class="cpartition"></div>
                <div class="members"> <strong>Band Members</strong>
					<div id= "band_members_list">
					<?php if (!empty ($band_members))  : ?>
					<?php $rest_fill++; ?>
					<ul class = "band_members_list" >
						<li><?php  echo $adminname.' - '.$admingenre; ?></li>
						<?php foreach ( $band_members as $key =>$band ) : ?>
							<li>
								<?php  echo $band['artistname'].' - '.$band['artistgenre']?>
							</li>
						<?php endforeach; ?>
					</ul>					
					<?php else: ?>
					you have 0 members.
					<?php endif; ?>
					</div>
					<input type ="hidden" id = "artist_id" name= "artist_id" value = "<?php echo $user_id;?>" />
					<button type="button" id= "add_band_members" class=" button-info btn btn-primary btn-lg">add member</button>
				</div>
				<div class="cpartition"></div>
				<div class="members"> <strong>Artist Bio</strong>
					<p style= "display:none" id = "hidden_bio_admin"><?php echo $user_biography; ?></p>
					<p id= "admin_user_bio"><?php echo substr($user_biography,0,100).'...'; ?></p>
					<button id= "admin_user_bio_edit" type="button" class="button-info btn btn-primary btn-lg">Edit Bio</button>
					<button style= "display:none" id= "admin_user_bio_update" type="button" class="button-info btn btn-primary btn-lg">Update Bio</button>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-xs-12">
                <div class="members"> <strong>Songs</strong>
					<?php
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
							echo '<p>'.get_the_title();
							$song_guid = get_post_meta( $post_id_song ,'song_id' , true );
							echo '</p>';
						endwhile;
						if ($countsongs == 0 ) {
							echo '<p>You have 0 songs added</p>';
						} else {
							$rest_fill++;
						}
					?>
					<button type="button" class=" button-info btn btn-primary btn-lg" id= "songspopup_button">add song</button>
				</div>
				<div class="members"> <strong>Videos</strong>
					<?php
						$videoargs = array(
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
						query_posts( $videoargs );
						$countvideosongs = 0;
						while ( have_posts() ) : the_post();
							$countvideosongs++;
							$post_id_song = get_the_ID();
							echo '<p>'.get_the_title();
							$song_guid = get_post_meta( $post_id_song ,'song_id' , true );
							echo '</p>';
						endwhile;
						if ($countvideosongs == 0 ) {
							echo '<p>You have 0 video added</p>';
						} else {
							//$rest_fill++;
						}
					?>
					<button type="button" id= "videosongspop_button" class=" button-info btn btn-primary btn-lg">add Video</button>
				</div>
                <div class="members"> <strong>Shows</strong>
                <div id= "show-list" >
					<?php
						$countevents = 0;
						$args = array(
							'post_type'=> 'artist-events',
							'author' => $user_id
						);
						query_posts( $args );
						while ( have_posts() ) : the_post();
							$countevents++;
							$post_id = get_the_ID();
							echo '<p>'.get_the_title(). ' - '. get_post_meta( $post_id ,'venue_dateofevent' , true ). ' - '.'<a id= "editshow-'.get_the_id().'" class= "editshow" href="javascript:;" >Edit</a></p>';
						endwhile;
						
						if ( $countevents  == 0 ) {
							echo '<p>You have 0 shows added</p>';
						} else {
							$rest_fill++;
						}
					?>
                </div>
                  <button type="button" id= "add_artist_shows" class=" button-info btn btn-primary btn-lg">add Show</button>
                </div>
                <div class="cpartition"></div>
                <div class="members" > <strong>Press</strong>
					<?php if (!empty ($press_items))  : ?>
					<?php $rest_fill++; ?>
					<p id= "press_item_list" >you have added <?php echo $countpress;?> Press items.</p>
					<?php else : ?>
					<p id= "press_item_list">you have 0 Press items.</p>
					<?php endif; ?>
                  <button type="button" id ="add_press_items" class=" button-info btn btn-primary btn-lg">Add Press</button>
                </div>
                <div class="cpartition"></div>
                <div class="members"> <strong>Recent Blogs</strong>
					<?php
							$the_query = new WP_Query( array(
												'post_type' => 'artist-blog',
												'author' => $user_id,
											) );

					// The Loop
					if ( $the_query->have_posts() ) {
						$rest_fill++;
						while ( $the_query->have_posts() ) {
							$the_query->the_post();
							echo '<p><a href= "'.get_the_permalink().'">'.get_the_title().'.</a></p>';
						}
					} else {
						echo '<p>you have added a  Blogs posts.</p>';
					}
					?>
                  
                  <button id = "add_blog_item" type="button" class=" button-info btn btn-primary btn-lg">Add Blog</button>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-xs-12">
                <div class="share">
                  <ul>
                    <li><a href="<?php echo $fburl; ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/fb.png" alt="fb"/></a></li>
                    <li><a href="<?php echo $twurl; ?>" target="_blank"> <img src="<?php bloginfo('template_url'); ?>/images/twitter.png" alt="twitter"/></a></li>
                    <li><a href="<?php echo $googleurl; ?>" target="_blank"> <img src="<?php bloginfo('template_url'); ?>/images/google.png" alt="g"/> </a> </li>
                    <li><a href="<?php echo $youurl; ?>" target="_blank"> <img src="<?php bloginfo('template_url'); ?>/images/YouTube.png" alt="youtube"/> </a> </li>
                    <li><a href="<?php echo $vimurl; ?>" target="_blank"> <img src="<?php bloginfo('template_url'); ?>/images/Vimeo.png" alt="vimeo"/> </a> </li>
                    <li><a href="<?php echo $spaceurl; ?>" target="_blank"> <img src="<?php bloginfo('template_url'); ?>/images/myspace.png" alt="Myspace"/> </a> </li>
                    <li><a href="<?php echo $tuneurl; ?>" target="_blank"> <img src="<?php bloginfo('template_url'); ?>/images/itunes.png" alt="itunes"/></a></li>
                    <li><a href="<?php echo $arturl; ?>" target="_blank"> <img src="<?php bloginfo('template_url'); ?>/images/client-ic.png" alt="client"/></a></li>
                  </ul>
                  <button type="button" class=" button-info btn btn-primary btn-lg">share</button>
                </div>
              </div>
             <div class="col-lg-4 col-md-4 col-xs-12 become-featured-artist">
				<a href= "<?php echo get_permalink(667); ?>" class=" button-info btn btn-primary btn-lg" >Become Featured Artist</a>
             </div> 
            </div>
            <?php
				if ( 0 == $first_twenty &&  0 == $second_twenty )  {
					$tofill = 0;
				} else if ( 1 == $first_twenty &&  0 == $second_twenty ) {
					$tofill = 1;
				}else if ( 0 == $first_twenty &&  1 == $second_twenty ) {
					$tofill = 1;
				}else if ( 1 == $first_twenty &&  1 == $second_twenty ) {
					$tofill = 2;
				}
            ?>
            <input type = "hidden" value = "<?php echo $tofill; ?>" id= "first_to_fill" />
            <input type= "hidden" value= "<?php echo $rest_fill; ?>" id ="rest_to_fill" />
            <?php update_user_meta ( $user_id, 'rest_fill', $rest_fill ); ?>
            <div class="cpartition"></div>
            <div class="save-buttons">
				<input type="submit" class=" button-save btn btn-primary btn-lg" name= "save_profile" value= "Save edits" / >
				<a class=" button-save btn btn-primary btn-lg" href="<?php echo get_permalink($artist_id); ?>">View Profile</a>
			</div>
          </div>
        </div>
		</form>
      </div>
  
  
  
  <script type="text/javascript">
    jQuery(document).on('click','#add_band_members',function(){
        jQuery('#bandmember').modal('show');
    });
    jQuery(document).on('click','#add_press_items',function(){
        jQuery('#press_items').modal('show');
    });
    jQuery(document).on('click','#add_blog_item',function(){
        jQuery('#artistblog').modal('show');
    });
    jQuery(document).on('click','#add_artist_shows',function(){
        jQuery('#artistshows').modal('show');
    });
    jQuery(document).on('click','#songspopup_button',function(){
        jQuery('#songspopup').modal('show');
    });
    jQuery(document).on('click','#videosongspop_button',function(){
        jQuery('#videosongspop').modal('show');
    });
    
    
    
    jQuery(document).ready( function () {
		jQuery('.date_of_release').datepicker({
			dateFormat : 'MM-dd-yy'
		});
		jQuery('#enddate').datepicker({
			dateFormat : 'MM-dd-yy'
		});
		jQuery('#startdate').datepicker({
			dateFormat : 'MM-dd-yy',
			minDate: 0,
		});
	});
	jQuery(document).on('focus','.date_of_release',function () {
		jQuery('.date_of_release').datepicker({
			dateFormat : 'MM-dd-yy'
		});
	});
    
</script>
<script>

	
jQuery( document.body ).on( 'click', '.dropdown-menu li', function( event ) {
 
   var $target = jQuery( event.currentTarget );
 
   $target.closest( '.btn-group' )
      .find( '[data-bind="label"]' ).text( $target.text() )
         .end()
      .children( '.dropdown-toggle' ).dropdown( 'toggle' );
 
   return false;
 
});

</script>
<?php
get_footer();


