<?php
/**
 * Event details meta box
 */ 
function eventdetails() {

	$screens = array( 'artist-events' );
	foreach ( $screens as $screen ) {
		add_meta_box(
			'product_manage_id','Event Details',
			'eventdetails_callback',
			$screen, 'normal', 'high'
		);
	}
}
add_action( 'add_meta_boxes', 'eventdetails' );

/**
 * Events callback function
 */ 
function eventdetails_callback( $post ) {
	
	wp_nonce_field( 'soundhouse_event_nonce', 'soundhouse_event_nonce_meta' );
	
	$venue_name = get_post_meta( $post->ID, 'venue_name', true );
	$venue_address = get_post_meta( $post->ID, 'venue_address', true );
	$venue_city = get_post_meta( $post->ID, 'venue_city', true );
	$venue_state = get_post_meta( $post->ID, 'venue_state', true );
	$venue_zip = get_post_meta( $post->ID, 'venue_zip', true );
	$venue_dateofevent = get_post_meta( $post->ID, 'venue_dateofevent', true );
	$venue_cost = get_post_meta( $post->ID, 'venue_cost', true );
	$venue_url = get_post_meta( $post->ID, 'venue_url', true );
	$venue_timeofevent = get_post_meta( $post->ID, 'venue_timeofevent', true );
	?>
	Venue Name <input type = "text" name= "venue_name" value= "<?php echo $venue_name; ?>" /><br>
	Address <input type = "text" name= "venue_address" value= "<?php echo $venue_address; ?>" /><br>
	City <input type = "text" name= "venue_city" value= "<?php echo $venue_city; ?>" /><br>
	State <input type = "text" name= "venue_state" value= "<?php echo $venue_state; ?>" /><br>
	Zip Code <input type = "text" name= "venue_zip" value= "<?php echo $venue_zip; ?>" /><br>
	Date of event <input type = "text" id= "venue_dateofevent" name= "venue_dateofevent" value= "<?php echo $venue_dateofevent; ?>" /><br>
	Time of event <input type = "text" name= "venue_timeofevent" value= "<?php echo $venue_timeofevent; ?>" /><br>
	Coist of event <input type = "text" name= "venue_cost" value= "<?php echo $venue_cost; ?>" /><br>
	Venue Url <input type = "text" name= "venue_url" value= "<?php echo $venue_url; ?>" />
	<?php
}

/**
 * Save event details
 */ 
function saveeventdetails ( $post_id ) {
	
	// Check if our nonce is set.
	if ( ! isset( $_POST['soundhouse_event_nonce_meta'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['soundhouse_event_nonce_meta'], 'soundhouse_event_nonce' ) ) {
		return;
	} 
	
	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	
	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}
	
	$venue_name = sanitize_text_field( $_POST['venue_name'] );
	$venue_address = sanitize_text_field ( $_POST['venue_address'] );
	$venue_city = sanitize_text_field ( $_POST['venue_city'] );
	$venue_state = sanitize_text_field ( $_POST['venue_state'] );
	$venue_zip = sanitize_text_field ( $_POST['venue_zip'] );
	$venue_dateofevent = sanitize_text_field ( $_POST['venue_dateofevent'] );
	$venue_cost = sanitize_text_field ( $_POST['venue_cost'] );
	$venue_url = sanitize_text_field ( $_POST['venue_url'] );
	$venue_timeofevent = sanitize_text_field ( $_POST['venue_timeofevent'] );
	
	update_post_meta ( $post_id, 'venue_name', $venue_name );
	update_post_meta ( $post_id, 'venue_address', $venue_address );
	update_post_meta ( $post_id, 'venue_city', $venue_city );
	update_post_meta ( $post_id, 'venue_state', $venue_state );
	update_post_meta ( $post_id, 'venue_zip', $venue_zip );
	update_post_meta ( $post_id, 'venue_dateofevent', $venue_dateofevent );
	update_post_meta ( $post_id, 'venue_cost', $venue_cost );
	update_post_meta ( $post_id, 'venue_url', $venue_url );
	update_post_meta ( $post_id, 'venue_timeofevent', $venue_timeofevent );
}

add_action( 'save_post', 'saveeventdetails' );
