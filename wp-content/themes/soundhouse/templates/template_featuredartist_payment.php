<?php
/*
 * Template Name: Featured Artist of Week
 */ 

get_header();
	global $wpdb;
	$user_id= get_current_user_id();
	if( isset ( $_POST['payment'] ) )
	{
		
	
		extract($_POST);
		$expire_date = $option_month.''.$option_year;
		$post_values = array(

		// the API Login ID and Transaction Key must be replaced with valid values
		"x_login"			=> "4VT7h5zx8xw",
		"x_tran_key"		=> "4h2h8X3AChx636YX",

		"x_version"			=> "3.1",
		"x_delim_data"		=> "TRUE",
		"x_delim_char"		=> "|",
		"x_relay_response"	=> "FALSE",

		"x_type"			=> "AUTH_CAPTURE",
		"x_method"			=> "CC",
		"x_card_num"		=>  $card_number, //"4111111111111111",
		"x_exp_date"		=> $expire_date,

		"x_amount"			=> $bid_amount,
		"x_description"		=> "Auction Transaction",

		"x_first_name"		=> $first_name,
		"x_last_name"		=> $last_name,
		"x_address"			=> $address,
		"x_state"			=> $state,
		"x_zip"				=> $zip_code
		// Additional fields can be added here as outlined in the AIM integration
		// guide at: http://developer.authorize.net
		);
		$response = cc_payment($post_values);
		$sucess_status = $response[5];
		if( $sucess_status == 'Y' ) {
			$featured_artist = $wpdb->prefix.'featured_artist';
			$updateqry = "update $featured_artist set featured_artist_status= '0' where user_id= '$user_id'";
			$wpdb->query( $updateqry );
			$insert_qry = "insert into $featured_artist 
			 ( user_id, first_name , last_name, address, city, state, zip,transaction_id, payment_date, featured_artist_status )
			 
			 values ( '$user_id' , '$first_name', '$last_name', '$address', '$city', '$state', '$zip_code', '$response[6]', now(),  '1' )
			";
			$wpdb->query( $insert_qry );
		}
		
	}

?>
  <div class="inner-content-area">
        <div class="entry-content">
          <div class="payment-info">
            <h1>Payment Information</h1>
            <div class="plan">
              <form method= "post">
                <div class="package-details">
					<?
						if (isset ( $response ) ) {
							if($sucess_status=='Y'){
								echo '<h4>Your Payment has been accepted</h4>';
							} else {
								$MessageCcError  = $response[3];
								if($MessageCcError == "The credit card number is invalid.")
								{
									echo '<div class = "soundhouse_api_error soundhouse_errors">'.$MessageCcError ="Please enter valid card number".'</div>';
								} else {
									echo '<div class = "soundhouse_api_error soundhouse_errors">'.$MessageCcError.'</div>';
								}
								echo '<br>';
							}
							echo '<br>';
						}
						?>
                  <h2><span>Featured Artist of Week </span></h2>
                  
                </div>
                <div class="billing-form row">
                  <div class="col-lg-7 col-md-7  row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
						
                      <label>Billing Info</label>
                      <input type="hidden" name="bid_amount" id="bid_amount" value="4.95" />
						<input type="hidden" name="user_id"  value="<?php echo $user_id; ?>" /> 
                      <div class="form-group">
                        <input type="text" id="first_name" name="first_name" placeholder="First Name" class="form-control"/>
                        <div class = "soundhouse_errors" id= "first_name_error" ></div>
                      </div>
                      <div class="form-group">
                        <input type="text" id="last_name" name="last_name" placeholder="Last Name" class="form-control"/>
                        <div class = "soundhouse_errors" id= "last_name_error" ></div>
                      </div>
                      <div class="form-group">
                        <input type="text" id= "address" name="address" placeholder="Address"  class="form-control"/>
                        <div class = "soundhouse_errors" id= "address_error" ></div>
                      </div>
                      <div class="form-group">
                        <input type="text" id= "city" name="city" placeholder="City"  class="form-control"/>
                        <div class = "soundhouse_errors" id= "city_error" ></div>
                      </div>
                      <div class="form-group">
                        <input type="text" id= "state" name="state" placeholder="State"  class="form-control"/>
                        <div class = "soundhouse_errors" id= "state_error" ></div>
                      </div>
                      <div class="form-group">
                        <input type="text" id= "zip" name="zip" placeholder="Zip"  class="form-control"/>
                        <div class = "soundhouse_errors" id= "zip_error" ></div>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                      <label>Credit Card Information</label>
                      <div class="form-group">
                        <input type="text" id="card_number" name="card_number" placeholder="xxxx-xxxx-xxxx-xxxx" class="form-control"/>
                        <div class = "soundhouse_errors" id= "card_number_error" ></div>
                      </div>
                      <div class="form-group">
                        <input type="text" id="cvn" name="cvn" placeholder="CCV"  class="form-control"/>
                        <div class = "soundhouse_errors" id= "cvn_error" ></div>
                      </div>
                      <div class="form-group">
							<select name= "option_month" id= "option_month" class = "form-control selectpicker" >
								<option value="">Month</option>
								<option value="01">Jan</option>
								<option value="02">Feb</option>
								<option value="03">Mar</option>
								<option value="04">Apr</option>
								<option value="05">May</option>
								<option value="06">Jun</option>
								<option value="07">Jul</option>
								<option value="08">Aug</option>
								<option value="09">Sep</option>
								<option value="10">Oct</option>
								<option value="11">Nov</option>
								<option value="12">Dec</option>
							</select>
							<div class = "soundhouse_errors" id= "option_month_error" ></div>
							<select name= "option_year" id= "option_year" class = "form-control selectpicker" >
								<option value="">Year</option>
								<?php	$date = date('Y');
										for($i=$date;$i<=2035;$i++)
										{
											$j=substr($i,2);
											echo '<option value='.$j.'>'.$i.'</option>';
										}
								?>
							</select>
							<div class = "soundhouse_errors" id= "option_year_error" ></div>
                      </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                      <div class="cpartition"></div>
                    </div>
                  </div>
                  <div class="col-lg-5 col-md-5 ">
                    <ul class="payment-option">
						<li>
							<a href="#" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/pay1.png" alt="pay" class="img-responsive"/></a>
						</li>
						<li>
							<a href="#" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/pay2.png" alt="pay" class="img-responsive"/></a>
						</li>
						<li>
							<a href="#" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/pay3.png" alt="pay" class="img-responsive"/></a>
						</li>
						<li>
							<a href="#" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/pay4.png" alt="pay" class="img-responsive"/></a>
						</li>
                    </ul>
                  </div>
                  <div class="col-lg-12 col-md-12">
					<input id= "payment_featured" class=" button-info  btn-primary btn-lg" type = "submit" name ="payment" value = "Start Your Plan" />
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    
<?php
get_footer();

