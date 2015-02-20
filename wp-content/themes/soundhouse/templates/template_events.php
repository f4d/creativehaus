<?php
/**
 * Template Name: Events & Gigs Template
 */ 
$ip = $_SERVER['REMOTE_ADDR'];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://www.telize.com/geoip/$ip");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
$response = curl_exec($ch);
curl_close($ch);
$response_a = json_decode ( $response );
$searchlong = $response_a->longitude;
$searchlat = $response_a->latitude;
get_header();
?>

    <div class="inner-content-area">
        <div class="entry-content">
			<div id = "events_ajax_loader" style="display:none" >
				<img src= "<?php bloginfo('template_url'); ?>/images/ajaxloader.gif" />
			</div>
          <div class="directory">
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6">
                <h1>GIGS & EVENTS IN YOUR AREA</h1>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-6 ">
              <div class="form-group  col-lg-6 col-md-6">
					<select name= "artist_genre" id= "artist_genre_events" class = "form-control selectpicker" >
						<option value = "-1" >All Genre</option>
						<?php
						$taxonomy = 'artist_list';
						$tax_terms = get_terms($taxonomy,array( 'hide_empty' => false ));
						foreach ($tax_terms as $tax_term) 
						{
							echo '<option value= "'.$tax_term->term_id.'" >'.$tax_term->name.'</option>';
						}
						?>
					</select>
				</div>
				<div class="form-group  col-lg-6 col-md-6">
					<input type="text" class="form-control" value="" id="inputSuccess2" placeholder="Search City">
					<span id= "search-using-loc" class="glyphicon glyphicon-search form-control-feedback"></span> 
				</div>
			</div>
			</div>
			<input type = "hidden" id= "user_longitude" value = "<?php echo $searchlong; ?>" />
			<input type = "hidden" id= "user_latitude" value = "<?php echo $searchlat; ?>" />
			<?php
			global $wpdb;
			$posts_table= $wpdb->prefix.'posts';
			$postmeta_table= $wpdb->prefix.'postmeta';
			$location_table = $wpdb->prefix.'event_location';

			$query = "select pos.* ,ROUND((((acos(sin(($searchlat *pi()/180)) * 
					sin((loc.latitude *pi()/180))+cos(($searchlat*pi()/180)) * 
					cos(( loc.latitude *pi()/180)) * cos((($searchlong - loc.longitude)* 
					pi()/180))))*180/pi())*60*1.1515),2) as distance
					from $posts_table as pos 
					INNER JOIN $location_table as loc ON loc.event_id = pos.ID
					JOIN $postmeta_table d ON (loc.event_id = d.post_id and d.meta_key = 'venue_dateofevent' and d.meta_value >= CURDATE())
					GROUP BY pos.ID HAVING distance BETWEEN -1 AND 10 OR distance IS NULL 
					order by d.meta_value 
					";
            $res = $wpdb->get_results($query);
          //  echo '<pre>';print_r($res); echo '</pre>';
				$countevents = 0;
				$args = array(
					'post_type'=> 'artist-events'
				);
			?>
			<?php //foreach ( $res as $r ) :  ?>
				<div class="events panel-group" id="accordion">
					<div class="over-lay" style="display:none"></div>
					<?php foreach ( $res as $r ) :  ?>
						<?php $countevents++; ?>
						<div class="panel panel-default">
							<div class="table">
							<?php 
								$author_id = $r->post_author; 
								$post_id = $r->ID;
								$venue_name = get_post_meta( $post_id, 'venue_name', true );
								$venue_address = get_post_meta( $post_id, 'venue_address', true );
								$venue_city = get_post_meta( $post_id, 'venue_city', true );
								$venue_state = get_post_meta( $post_id, 'venue_state', true );
								$venue_zip = get_post_meta( $post_id, 'venue_zip', true );
								$venue_dateofevent = get_post_meta( $post_id, 'venue_dateofevent', true );
								$venue_dateofevent =  date("d M Y", strtotime ( $venue_dateofevent));
								$venue_cost = get_post_meta( $post_id, 'venue_cost', true );
								$venue_url = get_post_meta( $post_id, 'venue_url', true );
								$venue_timeofevent = get_post_meta( $post_id, 'venue_timeofevent', true );
								$venueimage1 = get_post_meta( $post_id, 'venueimage1', true );
								$venueimage2 = get_post_meta( $post_id, 'venueimage2', true );
								$venueimage3 = get_post_meta( $post_id, 'venueimage3', true );
							?>
							<?php $userpofile = get_user_meta($author_id,"user_profile_image",true); ?>
							<?php $img1 = wp_get_attachment_image_src($userpofile, 'admin-directory-pic'); ?>
								<img src="<?php echo $img1['0']; ?>" alt=""/>
								<?php echo $r->post_title; ?> - <i><?php echo $venue_name; ?></i> - <?php echo $venue_city; ?>, <?php echo $venue_zip; ?>  | <?php echo $venue_dateofevent; ?> @<?php echo $venue_timeofevent; ?>
								<div  class="view">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $countevents;?>" class="pop">View</a>
								</div>
							
							</div>
							 <div id="collapse<?php echo $countevents;?>" class="panel-collapse collapse">
								<div class="" id="eventmodel" style ="display:block">
								  <div class="">
									<div class="modal-content">
									<div class="modal-header">
									  </div>
									  <div class="modal-body">
										<div class="gigeventinfo">
										  <h3>Event details</h3>
										  <ul>
											<li>
											  <h2><?php echo $r->post_title; ?></h2>
											</li>
											<li>
											  <p><strong><?php echo $venue_name; ?> - <?php echo $venue_city; ?>, <?php echo $venue_state; ?>  |</strong> <?php echo $venue_dateofevent; ?> <strong>|</strong> <?php echo $venue_timeofevent; ?></p>
											</li>
											<?php $band_members = get_user_meta($r->post_author,"band_members",true); ?>
											<li><strong>PERFORMING ACTS</strong>
											<?php if (!empty ($band_members))  : ?>
											<p>
											<?php
											foreach ( $band_members as $key =>$band ) : ?>
												
													<?php  echo $band['artistname'].'<br/>';?>
												
											<?php endforeach; ?>
											<?php else : ?>
											No performer
											</p>
											
											<?php endif; ?>
											</li>
										  </ul>
										  <div class="row bottom-event-list">
											<div class="col-lg-3 col-md-3 col-sm-3">
												<?php if ( !empty ($venueimage1 ) ) : ?>
												<?php $img1 = wp_get_attachment_image_src($venueimage1, 'admin-artist-profile-pic'); ?>
												<img src="<?php echo $img1['0']; ?>" alt="" class="img-responsive"/>
												<?php endif; ?>
											</div>
											<div class="col-lg-3 col-md-3 col-sm-3">
												<?php if ( !empty ($venueimage2 ) ) : ?>
												<?php $img2 = wp_get_attachment_image_src($venueimage2, 'admin-artist-profile-pic'); ?>
												<img src="<?php echo $img2['0']; ?>" alt="" class="img-responsive"/>
												<?php endif; ?>
											</div>
											<div class="col-lg-3 col-md-3 col-sm-3">
												<?php if ( !empty ($venueimage3 ) ) : ?>
												<?php $img3 = wp_get_attachment_image_src($venueimage3, 'admin-artist-profile-pic'); ?>
												<img src="<?php echo $img3['0']; ?>" alt="" class="img-responsive"/>
												<?php endif; ?>
											</div>
										  <div class="col-lg-3 col-md-3  col-sm-3 text-center">
										  <h2>$<?php echo $venue_cost; ?></h2>
										  <p><?php echo $venue_name.' '.$venue_address; ?><br/>
										  
										<?php echo $venue_city; ?>, <?php echo $venue_state; ?> <?php echo $venue_zip; ?></p>
										<address>
											<?php echo $venue_name.' '.$venue_address.' '.$venue_city.' '.$venue_state; ?>
										</address>
								<!-- <button class=" button-info btn btn-primary btn-lg" type="button">
										
								</button> -->
										</div>
										  </div>
										  
										</div>
									  </div>
									</div>
									<!-- /.modal-content --> 
								  </div>
								  <!-- /.modal-dialog --> 
								</div>


							</div>
						</div>
						  <?php endforeach; // End the loop. Whew. ?>
						</tbody>
					  </table>
				</div>
          </div>
        </div>
      </div>
		<script>
			jQuery(document).on('click','.pop', function () {
				var abc = jQuery(this).hasClass('collapsed');
				console.log(abc+ ' is this' );
			});
			jQuery(document).ready(function () {
				//Convert address tags to google map links - Copyright Michael Jasper 2011
				jQuery('address').each(function () {
					var link = "<a class= 'button-info btn btn-primary btn-lg' href='http://maps.google.com/maps?q=" + encodeURIComponent( jQuery(this).text() ) + "' target='_blank'>View Map</a>";
					jQuery(this).html(link);
				});
			});
		</script>
		
<?php
get_footer();
