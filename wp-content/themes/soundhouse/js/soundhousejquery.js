/**
 * Login using ajax
 */ 
jQuery(document).on('click','#login_ajax', function (){
	var email_id = jQuery('#user_email').val();
	var password = jQuery('#user_password').val();
	jQuery('#signin_ajax_loader_show').show();
	jQuery.ajax({
		type : "post",
		url : myAjax.ajaxurl,
		data : {
			action: "sandhouse_login", 
			email_id : email_id,
			password : password
		},
		success: function(response) {
			if (response == '1' ) {
				window.location = myAjax.site_url;
			}  else if  ( response == '2' ) {
				window.location = myAjax.artist_admin_url;
			} else {
				jQuery('#invalid_credential').html('Invalid username or password');
				jQuery('#signin_ajax_loader_show').hide();
			}
		}
	});
});

/**
 * Modal pop up
 */ 
jQuery(document).ready(function(){
	jQuery('.log-in-soundhouse').click(function(){
		jQuery('#myModal2').modal('show');
	});
	jQuery('#user_profile_image_trig').click(function(){
		jQuery('#user_profile_image').trigger('click');
	});
	jQuery('.selectpicker').selectpicker();
	jQuery('#startdate').attr('readonly', true);
	//jQuery('#timeofevent').timepicker();
});


/**
 * image uploading for artist registration
 */ 
function sliderimag1(input) {
	if (input.files && input.files[0]) {
			var reader = new FileReader();
			jQuery('#slidimg1').remove();
			jQuery('#slid-1').empty();		
			jQuery('<img id="slidimg1" src="#" alt="Upload Image" />').insertBefore(jQuery("#user_profile_image_trig"));
			reader.onload = function (e) {
				jQuery('#slidimg1')
					.attr('src', e.target.result)
					.width(341)
					.height(216);
			};
			reader.readAsDataURL(input.files[0]);
		}
}

/**
 * Artist admin section starts here
 * Band member artist admin 
 */ 

jQuery(document).on('click','#artist-admin-band', function () {
	var ret = true;
	jQuery('.error').empty();
	var artistarray = new Array();
	var member_count = jQuery('#hidden_count_band').val();
	var mydata = 'action=add_ban_member&total_count='+member_count;

	jQuery('.artistname').each( function () {
		var artistname = jQuery(this).val();
		var aid = jQuery(this).attr('id');
		var subid = aid.substring(11);
		var artistemail = jQuery('#artistemail_'+subid).val();
		var artistgenre = jQuery('#artistgenre_'+subid ).val();
		if ( artistname == '' ) {
			var artist_error_div = '#artist_error_'+subid;
			jQuery(artist_error_div).html('Please enter artist name');
			ret = false;
		}
		if ( artistemail == '' ) {
			var artistemail_error__div = '#artistemail_error_'+subid;
			jQuery(artistemail_error__div).html('Please enter artist email');
			ret = false;
		} else if ( ! validateEmail(artistemail)) {
			var artistemail_error__div = '#artistemail_error_'+subid;
			jQuery(artistemail_error__div).html('Please enter valid email');
			ret = false;
		}
	}); 
	
	if(true == ret ) {
		mydata += "&artistname_admin=" +  jQuery("#artistname_admin").val();
		mydata += "&artistemail_admin=" +  jQuery("#artistemail_admin").val();
		mydata += "&artistgenre_admin=" +  jQuery("#artistgenre_admin").val();
		for(var i =1;i<=member_count;i++)
		{
			//var t= parseInt(i)+1;
			
			mydata += "&artistname_"+i+"=" +  jQuery("#artistname_"+i).val();
			mydata += "&artistemail_"+i+"=" +  jQuery("#artistemail_"+i).val();
			mydata += "&artistgenre_"+i+"=" +  jQuery("#artistgenre_"+i).val();
			

		}
		jQuery('#ajax_loader').show();
		jQuery.ajax({
			type : "post",
			url : myAjax.ajaxurl,
			data : mydata,
			success: function(response) {
				jQuery('#band_members_list').html(response);
				jQuery('#bandmember').modal('hide');
				jQuery('#ajax_loader').hide();
			}
		});
	}
});

/**
 * Add band members
 */ 
jQuery(document).on('click','#band_member_add', function () {
	var member_count = jQuery('#hidden_count_band').val();
	member_count++;
	jQuery('#hidden_count_band').val(member_count);
	var html = '';
	html += '<div class="form-group col-lg-4 col-md-4 col-sm-4">';
	html += '<input type="text" id = "artistname_'+member_count+'" class="form-control artistnamenew"  placeholder="Artist Name">';
	html += '<div class = "error" id= "artist_error_'+member_count+'" ></div>';
	html += '</div>';
	html += '<div class="form-group  col-lg-4 col-md-4 col-sm-4">';
	html += '<input type="text" id = "artistemail_'+member_count+'" class="form-control artistemail"  placeholder="Email Address">';
	html += '<div class = "error" id= "artistemail_error_'+member_count+'" ></div>';
	html += '</div>';
	html += '<div class="form-group  col-lg-4 col-md-4 col-sm-4">';
	html += '<select class="turnintodropdown selectpicker artistgenre" id = "artistgenre_'+member_count+'">';
	html += '<option>Vocals</option>';
	html += '<option>Vocals</option>';
	html += '<option>Guitar</option>';
	html += '<option>Bass</option>';
	html += '<option>Piano</option>';
	html += '<option>Keyboard</option>';
	html += '<option>Drums</option>';
	html += '<option>Congos</option>';
	html += '<option>Cello</option>';
	html += '<option>Violin</option>';
	html += '<option>Glockenspiel</option>';
	html += '<option>Organ</option>';
	html += '<option>Viola</option>';
	html += '<option>Saxophone</option>';
	html += '<option>Trumpet</option>';
	html += '<option>Trombone</option>';
	html += '<option>Tuba</option>';
	html += '</select>';
	html += '</div>';
	html += '<div class="clearfix"></div>';
	jQuery('.members-div').append(html);
	jQuery('.selectpicker').selectpicker();
});

/**
 * User bio edit html
 */ 
jQuery(document).on('click','#admin_user_bio_edit', function() {
	jQuery('#admin_user_bio_edit').hide();
	jQuery('#admin_user_bio_update').show();
	var texts = jQuery('#hidden_bio_admin').text();
	var htmls = '<textarea id= "admin_user_bio_textarea" >'+texts+'</textarea>';
	jQuery('#admin_user_bio').html(htmls);
});

/**
 * User bio update ajax
 */ 
jQuery(document).on('click','#admin_user_bio_update', function() {
	var bio_texts = jQuery('#admin_user_bio_textarea').val();
	jQuery.ajax({
		type : "post",
		url : myAjax.ajaxurl,
		data : {
			action: "update_biography", 
			user_bio : bio_texts
		},
		success: function(response) {
			jQuery('#admin_user_bio_edit').show();
			jQuery('#admin_user_bio_update').hide();
			jQuery('#hidden_bio_admin').text(bio_texts);
			jQuery('#admin_user_bio').html(bio_texts.substring(0, 100));
		}
	});
	
});


jQuery(document).ready(function(){
	jQuery('.main-img').click(function(){
		jQuery('#user_profile_image').trigger('click');
	});
	jQuery('#add_artist_blog_image_trig').click(function(){
		jQuery('#add_artist_blog_image').trigger('click');
	});
	jQuery('.user_multiple_images_add').click(function(){
		
		jQuery('#user_multiple_images').trigger('click');
	});
	jQuery('#searchartist').click(function(){
		var artistname = jQuery.trim ( jQuery('#artistsearchname').val() );
		jQuery('#searchartisthidden').trigger('click');
	});
	jQuery("#inputSuccess2").geocomplete().bind("geocode:result", function(event, result){
    console.log(result.formatted_address);
		getcding_result_get(result.formatted_address);
    
  });;
});

/**
 * Admin profile image upload
 */ 
function admin_profileimage(input) {
	if (input.files && input.files[0]) {
			var reader = new FileReader();
			jQuery('#slidimg1').remove();
			jQuery('#slid-1').empty();
			jQuery('.main-img').html('<img id="slidimg1" src="#" class="img-responsive" alt="" />');
			//jQuery('<img id="slidimg1" src="#" alt="Upload Image" />').insertBefore(jQuery(".main-img"));
			reader.onload = function (e) {
				jQuery('#slidimg1')
					.attr('src', e.target.result)
					.width(340)
					.height(227);
			};
			reader.readAsDataURL(input.files[0]);
		}
}

/**
 * Press section dynamic html
 */ 
jQuery(document).on('click','#add_more_press', function () {
	var member_count = jQuery('#hidden_press_items_count').val();
	member_count++;
	jQuery('#hidden_press_items_count').val(member_count);
	var html = '';
	html += '<div class= "press-items-class"><div id= "items-div-'+member_count+'" class = "col-lg-11 col-md-11 col-sm-11" >';
	html += '<div class="form-group col-lg-3 col-md-3 col-sm-3">';
	html += '<input type="text" id = "date_of_release_'+member_count+'" class="form-control date_of_release"  placeholder="Date of Release">';
	html += '<div class = "error" id= "date_of_release_error_'+member_count+'" ></div>';
	html += '</div>';
	html += '<div class="form-group  col-lg-3 col-md-3 col-sm-3">';
	html += '<input type="text" id = "publication_name_'+member_count+'" class="form-control publication_name"  placeholder="Publication Name">';
	html += '<div class = "error" id= "publication_name_error_'+member_count+'" ></div>';
	html += '</div>';
	html += '<div class="form-group  col-lg-3 col-md-3 col-sm-3">';
	html += '<input type="text" id = "title_of_article_'+member_count+'" class="form-control title_of_article"  placeholder="Title of Article">';
	html += '<div class = "error" id= "title_of_article_error_'+member_count+'" ></div>';
	html += '</div>';
	html += '<div class="form-group  col-lg-3 col-md-3 col-sm-3">';
	html += '<input type="text" id = "link_to_article_'+member_count+'" class="form-control link_to_article"  placeholder="Link to Article">';
	html += '<div class = "error" id= "link_to_article_error_'+member_count+'" ></div>';
	html += '</div>';
	html += '<div class="clearfix"></div>';
	html += '</div>';
	html += '<div id= "items-div-delete-'+member_count+'" class = "itesms-delete col-lg-1 col-md-1 col-sm-1">';
	html += '<a href= "javascript:;">Delete</a>';
	html += '</div>';
	html += '</div>';
	jQuery('.press-items-div').append(html);
});


/**
 * Saving and validation of press items 
 */ 
jQuery(document).on('click','#save_press_items', function () {
	var ret = true;
	jQuery('.error').empty();
	var pressarray = new Array();
	var member_count = jQuery('#hidden_press_items_count').val();
	var mydata = 'action=add_press_items&total_count='+member_count;

	jQuery('.date_of_release').each( function () {
		var date_of_release = jQuery(this).val();
		var aid = jQuery(this).attr('id');
		var subid = aid.substring(16);
		var date_of_release = jQuery('#date_of_release_'+subid).val();
		var publication_name = jQuery('#publication_name_'+subid ).val();
		var title_of_article = jQuery('#title_of_article_'+subid ).val();
		var link_to_article = jQuery('#link_to_article_'+subid ).val();
		if ( date_of_release == '' ) {
			var date_of_release_error_div = '#date_of_release_error_'+subid;
			jQuery(date_of_release_error_div).html('Please enter date of release');
			ret = false;
		}
		if ( publication_name == '' ) {
			var publication_name_error__div = '#publication_name_error_'+subid;
			jQuery(publication_name_error__div).html('Please enter publication name');
			ret = false;
		}
		if ( title_of_article == '' ) {
			var title_of_article_div = '#title_of_article_error_'+subid;
			jQuery(title_of_article_div).html('Please enter title of article');
			ret = false;
		}
		if ( link_to_article == '' ) {
			var link_to_article_div = '#link_to_article_error_'+subid;
			jQuery(link_to_article_div).html('Please enter link of article');
			ret = false;
		}
	}); 
	
	if(true == ret ) {
		for(var i =1;i<=member_count;i++)
		{
			mydata += "&date_of_release_"+i+"=" +  jQuery("#date_of_release_"+i).val();
			mydata += "&publication_name_"+i+"=" +  jQuery("#publication_name_"+i).val();
			mydata += "&title_of_article_"+i+"=" +  jQuery("#title_of_article_"+i).val();
			mydata += "&link_to_article_"+i+"=" +  jQuery("#link_to_article_"+i).val();
		}
		jQuery('#ajax_loader_press').show();
		jQuery.ajax({
			type : "post",
			url : myAjax.ajaxurl,
			data : mydata,
			success: function(response) {
				jQuery('#press_item_list').html(response);
				jQuery('#press_items').modal('hide');
				jQuery('#ajax_loader_press').hide();
			}
		});
	}
});

/**********Artist blog display image to be uploaded ***********/
function artist_blog_image(input) {
	if (input.files && input.files[0]) {
			var reader = new FileReader();
			jQuery('#artistimg1').remove();
			
			jQuery('#artist_blog_featured_image').html('<img id="artistimg1" src="#" class="img-responsive" alt="" />');
			reader.onload = function (e) {
				jQuery('#artistimg1')
					.attr('src', e.target.result)
					.width(340)
					.height(325);
			};
			reader.readAsDataURL(input.files[0]);
		}
}

/**
 * Blog save validation 
 */ 
jQuery(document).on( 'click','#artist_blog_save', function () {
	var ret  = true;
	jQuery('.error').empty();
	var title = jQuery.trim( jQuery('#artist_blog_title').val() );
	var content = jQuery.trim( jQuery('#artist_blog_content').val() );
	if ( '' == title ) {
		jQuery('#artist_blog_title_error').html('Please enter blog title');
		ret = false;
	}
	if ( '' == content ) {
		jQuery('#artist_blog_content_error').html('Please enter blog content');
		ret = false;
	}
	var image = jQuery('#add_artist_blog_image').val();
	var validd=  checkimage_validation (image);
	/* if ( ! validd ) {
		jQuery('#artist_blog_image_error').html('Please upload image');
		ret = false;
	} */
	return ret;
});


/**
 * on change blog image validation
 */ 
jQuery("#add_artist_blog_image").change(function() {
    var val = jQuery(this).val();
	var validd=  checkimage_validation (val);
	/*if ( ! validd ) {
		jQuery('#artist_blog_image_error').html('Please upload image');
		ret = false;
	}else {
		jQuery('#artist_blog_image_error').html('');
	}  */
});

/**
 * validate image
 */ 
function checkimage_validation (val) {
	var ret = true;
	switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
		case 'gif': case 'jpg': case 'png':
			ret = true;
			break;
		default:
			jQuery(this).val('');
			ret = false;
			break;
	}
	return ret;
}

/**
 * validate email
 */ 
function validateEmail(sEmail) {
	var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
	if (filter.test(sEmail)) {
		return true;
	}
	else {
		return false;
	}
}

/**
 * jQuery remove press items
 */ 
jQuery(document).on('click','.itesms-delete', function () {
	var divid = jQuery(this).attr('id');
	jQuery(this).remove();
	var newid = divid.substring(17);
	jQuery('#items-div-'+newid).remove();
	
});

/**
 * jQuery remove images from frontend admin page
 */ 
jQuery('.delete-multi-image').click(function() {
	var abcde = jQuery(this).attr('id');
	var newid = abcde.substring(19);
	jQuery('#user-multiple-images-'+newid).html('<div class="thumb-img text-center"><span class="glyphicon glyphicon-plus"></span></div>');
	return false;
});


/**
 * Add shows validations and get longitude and latitude
 */ 
jQuery(document).on( 'click','#save_artists_show', function () {
	var ret = true;
	var nret = true;
	jQuery('.error').empty();
	var artist_id = jQuery.trim( jQuery('#artist_id').val() );
	var venue_name = jQuery.trim( jQuery('#venue_name').val() );
	var venue_address = jQuery.trim( jQuery('#venue_address').val() );
	var venue_city = jQuery.trim( jQuery('#venue_city').val() );
	var venue_state = jQuery.trim( jQuery('#venue_state').val() );
	var venue_zip = jQuery.trim( jQuery('#venue_zip').val() );
	var venue_dateofevent = jQuery.trim( jQuery('#startdate').val() );
	var venue_cost = jQuery.trim( jQuery('#venue_cost').val() );
	var venue_url = jQuery.trim( jQuery('#venue_url').val() );
	var timeofevent = jQuery.trim( jQuery('#timeofevent').val() );
	var recurring_shows = jQuery( '#recurring_shows' ).is(":checked");
	if ( '' == venue_name ) {
		jQuery('#venue_name_error').html('Please enter venue name');
		ret = false;
	}
	if ( '' == timeofevent ) {
		jQuery('#venue_timeofevent_error').html('Please enter venue time');
		ret = false;
	}
	if ( '' == venue_address ) {
		jQuery('#venue_address_error').html('Please enter venue adress');
		ret = false;
	}
	if ( '' == venue_city ) {
		jQuery('#venue_city_error').html('Please enter venue city');
		ret = false;
	}
	if ( '' == venue_state ) {
		jQuery('#venue_state_error').html('Please enter venue state');
		ret = false;
	}
	if ( '' == venue_zip ) {
		jQuery('#venue_zip_error').html('Please enter venue zip');
		ret = false;
	}
	if ( '' == venue_dateofevent ) {
		jQuery('#venue_dateofevent_error').html('Please enter venue date');
		ret = false;
	}
	if ( '' == venue_cost ) {
		jQuery('#venue_cost_error').html('Please enter venue cost');
		ret = false;
	}
	if ( '' == venue_url ) {
		jQuery('#venue_url_error').html('Please enter venue url');
		ret = false;
	}
	if ( recurring_shows ==  true ) {
		var no_of_shows = jQuery.trim( jQuery('#no_of_shows').val() );
		var recuring_type = jQuery('#recuring_type').val();
		if ( '' == no_of_shows ) {
			jQuery('#venue_nos_error').html('Please enter no. of shows');
			ret = false;
		}
	}
	
	jQuery('#artistshows').addClass( "show_custom" );
	return ret;
	
});


/*
 * Find geolocation on blur of venue 
 * in case of show add
 */ 
jQuery(document).on('blur','.geoloc', function () {
	var venue_name = jQuery.trim( jQuery('#venue_name').val() );
	var venue_address = jQuery.trim( jQuery('#venue_address').val() );
	var venue_city = jQuery.trim( jQuery('#venue_city').val() );
	var venue_state = jQuery.trim( jQuery('#venue_state').val() );
	var address = venue_address+'+'+venue_city+'+'+venue_state;
	getcding_result( address );
	
});


/*
 * Find geolocation on blur of venue 
 * In case of show edit
 */ 
jQuery(document).on('blur','.geoloc-edit', function () {
	var venue_name = jQuery.trim( jQuery('#venue_name_edit').val() );
	var venue_address = jQuery.trim( jQuery('#venue_address_edit').val() );
	var venue_city = jQuery.trim( jQuery('#venue_city_edit').val() );
	var venue_state = jQuery.trim( jQuery('#venue_state_edit').val() );
	var address = venue_address+'+'+venue_city+'+'+venue_state;
	getcding_result_edit( address );
	
});

function getcding_result_edit(address) {

	var nret;
	var geocoder = new google.maps.Geocoder();
		geocoder.geocode( { 'address': address}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			var latitude = results[0].geometry.location.lat();
			var longitude = results[0].geometry.location.lng();
			console.log(latitude + '  is ' + longitude );
			jQuery('#venue_latitude_edit').val(latitude);
			jQuery('#venue_longitude_edit').val(longitude);
			nret = true;
		} else {
			nret = true;
		}
	}); 
}


function getcding_result(address) {
	var nret;
	var geocoder = new google.maps.Geocoder();
		geocoder.geocode( { 'address': address}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			var latitude = results[0].geometry.location.lat();
			var longitude = results[0].geometry.location.lng();
			jQuery('#venue_latitude').val(latitude);
			jQuery('#venue_longitude').val(longitude);
			var lon = jQuery('#venue_longitude').val();
			nret = true;
			
		} else {
			nret = true;
		}
		
	}); 
	return nret;
}

/**
 * get post detail on clicking edit button
 */ 
jQuery(document).on('click','.editshow', function () {
	jQuery('#artistshows-edit').modal('show');
	var itsid = jQuery(this).attr('id');
	var subid = itsid.substring(9);
	//jQuery('#ajax_loader_show').show();
			jQuery.ajax({
				type : "post",
				url : myAjax.ajaxurl,
				data : {
					action: "edit_artist_show_detail", 
					post_id : subid
				},
				success: function(response) {
					jQuery('#edit-show-form').html(response);
					jQuery('#startdate_edit').datepicker({
						dateFormat : 'MM-dd-yy',
						minDate: 0,
					});
				}
	});
});




/**
 * Edit artist show validations and get logitude and latitude
 */ 
jQuery(document).on( 'click','#save_artists_show_edit', function () {
	var ret = true;
	jQuery('.error').empty();
	var artist_id = jQuery.trim( jQuery('#artist_id').val() );
	var show_to_edit = jQuery.trim( jQuery('#show_to_edit').val() );
	var venue_name = jQuery.trim( jQuery('#venue_name_edit').val() );
	var venue_address = jQuery.trim( jQuery('#venue_address_edit').val() );
	var venue_city = jQuery.trim( jQuery('#venue_city_edit').val() );
	var venue_state = jQuery.trim( jQuery('#venue_state_edit').val() );
	var venue_zip = jQuery.trim( jQuery('#venue_zip_edit').val() );
	var venue_dateofevent = jQuery.trim( jQuery('#startdate_edit').val() );
	var venue_cost = jQuery.trim( jQuery('#venue_cost_edit').val() );
	var venue_url = jQuery.trim( jQuery('#venue_url_edit').val() );
	var timeofevent = jQuery.trim( jQuery('#timeofevent_edit').val() );
	if ( '' == venue_name ) {
		jQuery('#venue_name_error_edit').html('Please enter venue name');
		ret = false;
	}
	if ( '' == timeofevent ) {
		jQuery('#venue_timeofevent_error_edit').html('Please enter venue time');
		ret = false;
	}
	if ( '' == venue_address ) {
		jQuery('#venue_address_error_edit').html('Please enter venue adress');
		ret = false;
	}
	if ( '' == venue_city ) {
		jQuery('#venue_city_error_edit').html('Please enter venue city');
		ret = false;
	}
	if ( '' == venue_state ) {
		jQuery('#venue_state_error_edit').html('Please enter venue state');
		ret = false;
	}
	if ( '' == venue_zip ) {
		jQuery('#venue_zip_error_edit').html('Please enter venue zip');
		ret = false;
	}
	if ( '' == venue_dateofevent ) {
		jQuery('#venue_dateofevent_error_edit').html('Please enter venue date');
		ret = false;
	}
	if ( '' == venue_cost ) {
		jQuery('#venue_cost_error_edit').html('Please enter venue cost');
		ret = false;
	}
	if ( '' == venue_url ) {
		jQuery('#venue_url_error_edit').html('Please enter venue url');
		ret = false;
	}
	if ( ret == true ) {
		var geocoder = new google.maps.Geocoder();
		var address = venue_address+'+'+venue_city+'+'+venue_state;
		geocoder.geocode( { 'address': address}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				var latitude = results[0].geometry.location.lat();
				var longitude = results[0].geometry.location.lng();
				jQuery('#venue_latitude_edit').val(latitude);
				jQuery('#venue_longitude_edit').val(longitude);
			}
			
		}); 
		ret =true;
	}
	return ret;
});

/**
 * Function to fill the progress bar
 */
jQuery(document).ready(function () {
	var artist_firstname = jQuery.trim ( jQuery('#artist_firstname').val() );
	var artist_lastname = jQuery.trim ( jQuery('#artist_lastname').val() );
	var artist_email = jQuery.trim ( jQuery('#artist_email').val() );
	var artist_city = jQuery.trim ( jQuery('#artist_city').val() );
	var artist_state = jQuery.trim ( jQuery('#artist_state').val() );
	var artist_zip = jQuery.trim ( jQuery('#artist_zip').val() );
	var artist_biography = jQuery.trim( jQuery('#artist_biography').val() );
	var facebook_url = jQuery.trim ( jQuery('#facebook_url').val() );
	var twitter_url = jQuery.trim ( jQuery('#twitter_url').val() );
	var artist_url = jQuery.trim ( jQuery('#artist_url').val() );
	var itunes_url = jQuery.trim ( jQuery('#itunes_url').val() );
	var google_plus = jQuery.trim ( jQuery('#google_plus').val() );
	var first_twenty = 1;
	var second_twenty = 1;
	if ( '' == artist_firstname ) {
		first_twenty = 0;
	}
	if ( '' == artist_lastname ) {
		first_twenty = 0;
	}
	if ( '' == artist_email ) {
		first_twenty = 0;
	}
	if ( '' == artist_city ) {
		first_twenty = 0;
	}
	if ( '' == artist_state ) {
		first_twenty = 0;
	}
	if ( '' == artist_zip ) {
		first_twenty = 0;
	}
	if ( '' == artist_biography ) {
		first_twenty = 0;
	}
	if ( '' == facebook_url ) {
		second_twenty = 0;
	}
	if ( '' == twitter_url ) {
		second_twenty = 0;
	}
	if ( '' == artist_url ) {
		second_twenty = 0;
	}
	if ( '' == itunes_url ) {
		second_twenty = 0;
	}
	if ( '' == google_plus ) {
		second_twenty = 0;
	}
	var to_fille= parseInt( second_twenty) + parseInt(first_twenty);
	var rest_to_fill = jQuery('#rest_to_fill').val();
	var total_fill = parseInt(to_fille) + parseInt(rest_to_fill);
	//~ if ( 0 == first_twenty &&  0 == second_twenty )  {
		//~ jQuery('#progress-bar-filled').width('0%');
		//~ jQuery('#progress-bar-remaining').width('98%');
	//~ } else if ( 1 == first_twenty &&  0 == second_twenty ) {
		//~ jQuery('#progress-bar-filled').width('18.5%');
		//~ jQuery('#progress-bar-remaining').width('79.5%');
	//~ }else if ( 0 == first_twenty &&  1 == second_twenty ) {
		//~ jQuery('#progress-bar-filled').width('18.5%');
		//~ jQuery('#progress-bar-remaining').width('79.5%');
	//~ }else if ( 1 == first_twenty &&  1 == second_twenty ) {
		//~ jQuery('#progress-bar-filled').width('37.8%');
		//~ jQuery('#progress-bar-remaining').width('60.2%');
	//~ }
	if ( 0 == total_fill  )  {
		jQuery('#progress-bar-filled').width('0%');
		jQuery('#progress-bar-remaining').width('98%');
	} else if ( 1 == total_fill  ) {
		jQuery('#progress-bar-filled').width('18.5%');
		jQuery('#progress-bar-remaining').width('79.5%');
	}else if ( 2 == total_fill  ) {
		jQuery('#progress-bar-filled').width('37.8%');
		jQuery('#progress-bar-remaining').width('60.2%');
	}else if ( 3 == total_fill  ) {
		jQuery('#progress-bar-filled').width('47.8%');
		jQuery('#progress-bar-remaining').width('50.2%');
	}else if ( 4 == total_fill  ) {
		jQuery('#progress-bar-filled').width('57.8%');
		jQuery('#progress-bar-remaining').width('40.2%');
	}else if ( 5 == total_fill  ) {
		jQuery('#progress-bar-filled').width('67.8%');
		jQuery('#progress-bar-remaining').width('30.2%');
	}else if ( 6 == total_fill  ) {
		jQuery('#progress-bar-filled').width('77.8%');
		jQuery('#progress-bar-remaining').width('20.2%');
	}else if ( 7 == total_fill  ) {
		jQuery('#progress-bar-filled').width('87.8%');
		jQuery('#progress-bar-remaining').width('10.2%');
	}else if ( 8 == total_fill  ) {
		jQuery('#progress-bar-filled').width('98%');
		jQuery('#progress-bar-remaining').width('0%');
	}
});


jQuery(document).ready(function () {
	var to_fille = jQuery('#first_to_fill').val();
	var rest_to_fill = jQuery('#rest_to_fill').val();
	var total_fill = parseInt(to_fille) + parseInt(rest_to_fill);
	if ( 0 == total_fill  )  {
		jQuery('#progress-bar-filled').width('0%');
		jQuery('#progress-bar-remaining').width('98%');
	} else if ( 1 == total_fill  ) {
		jQuery('#progress-bar-filled').width('18.5%');
		jQuery('#progress-bar-remaining').width('79.5%');
	}else if ( 2 == total_fill  ) {
		jQuery('#progress-bar-filled').width('37.8%');
		jQuery('#progress-bar-remaining').width('60.2%');
	}else if ( 3 == total_fill  ) {
		jQuery('#progress-bar-filled').width('47.8%');
		jQuery('#progress-bar-remaining').width('50.2%');
	}else if ( 4 == total_fill  ) {
		jQuery('#progress-bar-filled').width('57.8%');
		jQuery('#progress-bar-remaining').width('40.2%');
	}else if ( 5 == total_fill  ) {
		jQuery('#progress-bar-filled').width('67.8%');
		jQuery('#progress-bar-remaining').width('30.2%');
	}else if ( 6 == total_fill  ) {
		jQuery('#progress-bar-filled').width('77.8%');
		jQuery('#progress-bar-remaining').width('20.2%');
	}else if ( 7 == total_fill  ) {
		jQuery('#progress-bar-filled').width('87.8%');
		jQuery('#progress-bar-remaining').width('10.2%');
	}else if ( 8 == total_fill  ) {
		jQuery('#progress-bar-filled').width('98%');
		jQuery('#progress-bar-remaining').width('0%');
	}
});

jQuery(document).on ( 'keyup','#inputSuccess2', function () {
	
	var searchterm = jQuery(this).val();
	//console.log(searchterm);
	getcding_result_get(searchterm);
});


function getcding_result_get(address) {

	var nret;
	var geocoder = new google.maps.Geocoder();
		geocoder.geocode( { 'address': address}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			var latitude = results[0].geometry.location.lat();
			var longitude = results[0].geometry.location.lng();
		//alert(longitude);
			jQuery('#user_latitude').val(latitude);
			jQuery('#user_longitude').val(longitude);
			//nret = true;
		} else {
			//nret = true;
		}
	}); 
}

jQuery('body').on ( 'click','.pac-item', function () { 
alert("jai ho ")	;
});
jQuery('#search-using-loc').click( function () {
	jQuery('#events_ajax_loader').show();
	jQuery('.over-lay').show();
	var search = jQuery('#artist_genre_events').val();
	var searchlong = jQuery('#user_longitude').val();
	var searchlat = jQuery('#user_latitude').val();
		jQuery.ajax({
			type : "post",
			url : myAjax.ajaxurl,
			data : {
				action: "search_events_gigs", 
				event_cat : search,
				searchlat : searchlat,
				searchlong : searchlong
			},
			success: function(response) {
				jQuery('#accordion').html(response);
				jQuery('#events_ajax_loader').hide();
				jQuery('.over-lay').hide();
				jQuery('address').each(function () {
					var link = "<a class= 'button-info btn btn-primary btn-lg' href='http://maps.google.com/maps?q=" + encodeURIComponent( jQuery(this).text() ) + "' target='_blank'>View Map</a>";
					jQuery(this).html(link);
				});
			}
		});
});

/**
 * Shows searching searching
 */ 
jQuery(document).on('change','#artist_genre_events', function () {
	jQuery('#events_ajax_loader').show();
	jQuery('.over-lay').show();
	var search = jQuery(this).val();
	var searchlong = jQuery('#user_longitude').val();
	var searchlat = jQuery('#user_latitude').val();
		jQuery.ajax({
			type : "post",
			url : myAjax.ajaxurl,
			data : {
				action: "search_events_gigs", 
				event_cat : search,
				searchlat : searchlat,
				searchlong : searchlong
			},
			success: function(response) {
				jQuery('#accordion').html(response);
				jQuery('#events_ajax_loader').hide();
				jQuery('.over-lay').hide();
				jQuery('address').each(function () {
					var link = "<a class= 'button-info btn btn-primary btn-lg' href='http://maps.google.com/maps?q=" + encodeURIComponent( jQuery(this).text() ) + "' target='_blank'>View Map</a>";
					jQuery(this).html(link);
				});
			}
		});
});

jQuery(document).on('change','#recurring_shows', function (){
	var recurring_shows = jQuery( '#recurring_shows' ).is(":checked");
	if ( recurring_shows == true ) {
		jQuery('.recuring_type_div').show();
		jQuery('.no_of_shows_div').show();
	} else {
		jQuery('.recuring_type_div').hide();
		jQuery('.no_of_shows_div').hide();
	}
});

/**
 * Show venue image 1 upload
 */ 
function show_venue_image1(input) {
	if (input.files && input.files[0]) {
			var reader = new FileReader();
			jQuery('#venueimg1').remove();
			jQuery('#show_venue_image_1').empty();
			jQuery('#show_venue_image_1').html('<img id="venueimg1" src="#" class="img-responsive" alt="" />');
			reader.onload = function (e) {
				jQuery('#venueimg1')
					.attr('src', e.target.result)
					.width(300)
					.height(200);
			};
			reader.readAsDataURL(input.files[0]);
		}
}

/**
 * Show venue image 2 upload
 */ 
function show_venue_image2(input) {
	if (input.files && input.files[0]) {
			var reader = new FileReader();
			jQuery('#venueimg2').remove();
			jQuery('#show_venue_image_2').empty();
			jQuery('#show_venue_image_2').html('<img id="venueimg2" src="#" class="img-responsive" alt="" />');
			reader.onload = function (e) {
				jQuery('#venueimg2')
					.attr('src', e.target.result)
					.width(300)
					.height(200);
			};
			reader.readAsDataURL(input.files[0]);
			reader.readAsDataURL(input.files[0]);
		}
}

/**
 * Show venue image 3 upload
 */ 
function show_venue_image3(input) {
	if (input.files && input.files[0]) {
			var reader = new FileReader();
			jQuery('#venueimg3').remove();
			jQuery('#show_venue_image_3').empty();
			jQuery('#show_venue_image_3').html('<img id="venueimg3" src="#" class="img-responsive" alt="" />');
			reader.onload = function (e) {
				jQuery('#venueimg3')
					.attr('src', e.target.result)
					.width(300)
					.height(200);
			};
			reader.readAsDataURL(input.files[0]);
		}
}


/**
 * Show venue image 1 upload
 */ 
function edit_venue_image1(input) {
	if (input.files && input.files[0]) {
			var reader = new FileReader();
			jQuery('#edit_venueimg1').remove();
			jQuery('#edit_venue_image_1').empty();
			jQuery('#edit_venue_image_1').html('<img id="edit_venueimg1" src="#" class="img-responsive" alt="" />');
			reader.onload = function (e) {
				jQuery('#edit_venueimg1')
					.attr('src', e.target.result)
					.width(300)
					.height(200);
			};
			reader.readAsDataURL(input.files[0]);
		}
}

/**
 * Show venue image 2 upload
 */ 
function edit_venue_image2(input) {
	if (input.files && input.files[0]) {
			var reader = new FileReader();
			jQuery('#edit_venueimg2').remove();
			jQuery('#edit_venue_image_2').empty();
			jQuery('#edit_venue_image_2').html('<img id="edit_venueimg2" src="#" class="img-responsive" alt="" />');
			reader.onload = function (e) {
				jQuery('#edit_venueimg2')
					.attr('src', e.target.result)
					.width(300)
					.height(200);
			};
			reader.readAsDataURL(input.files[0]);
			reader.readAsDataURL(input.files[0]);
		}
}

/**
 * Show venue image 3 upload
 */ 
function edit_venue_image3(input) {
	if (input.files && input.files[0]) {
			var reader = new FileReader();
			jQuery('#edit_venueimg3').remove();
			jQuery('#edit_venue_image_3').empty();
			jQuery('#edit_venue_image_3').html('<img id="edit_venueimg3" src="#" class="img-responsive" alt="" />');
			reader.onload = function (e) {
				jQuery('#edit_venueimg3')
					.attr('src', e.target.result)
					.width(300)
					.height(200);
			};
			reader.readAsDataURL(input.files[0]);
		}
}


/**
 * Save song validations
 * 
 */ 
jQuery(document).on( 'click', '#save_song_click' , function () {
	var ret = true;
	jQuery('.error').empty();
	jQuery('#song_song_error').empty();
	
	var song_name = jQuery.trim ( jQuery('#song_name').val() );
	var aaiu_image_id = jQuery.trim ( jQuery('#aaiu_image_id').val() );
	var artist_album = jQuery('#artist_album_select').val();
	if ( '' == song_name ) {
		jQuery('#song_name_error').html('Please enter song name');
		ret = false;
	}
	if ( undefined == aaiu_image_id || '' == aaiu_image_id ) {
		jQuery('#song_song_error').html('Please upload song');
		ret = false;
	}
	if ( '-1' == artist_album ) {
		jQuery('#album_select_error').html('Please select album');
		ret = false;
	}
	var countsongs = 0;
	jQuery('.aaiu-uploaded-files').each(function () {
		countsongs++;
	});
	if ( countsongs > 1) {
		jQuery('#song_song_error').html('Please upload only 1 song');
		ret = false;
	} 
	
	jQuery('#songspopup').addClass( "song_custom" );
	return ret;
	
});

jQuery(document).on('click', '#create_album', function () {
	jQuery('.error').empty();
	var ret = true;
	var album_name = jQuery.trim ( jQuery('#create_album_name').val() );
	if ( '' == album_name ) {
		jQuery('#album_name_error').html('Please enter album name');
		ret = false;
	}
	if (ret == true) {
		jQuery.ajax({
			type : "post",
			url : myAjax.ajaxurl,
			data : {
				action: "add_artist_album", 
				album_name : album_name
			},
			success: function( response ) {
				if ( response == '-1' ) {
					jQuery('#album_name_error').html('This name album already exist');
				} else {
					jQuery('#artist_album_select_div').html(response);
					jQuery('.selectpicker').selectpicker();
					jQuery('#create_album_name').val('');
					jQuery('#album_name_error').html('Album created successfully');
				}
			}
		});
	}
	return false;
});

/**
 * Remove delete message
 * 
 */ 
jQuery(document).on('click','#aaiu-uploader', function () {
	jQuery('.aaiu-uploaded-files-to-delete').remove();
});

/**
 * On press enter login
 */ 
jQuery(document).on('keypress', '#user_password', function (e) {
	var p = e.which;
     if(p==13){
		jQuery('#login_ajax').trigger('click');
     }
});

jQuery(document).on('click','#artist_profile_submit' , function () {
	var ret = true;
	jQuery('.soundhouse_errors').empty();
	var artist_genre = jQuery('#artist_genre').val();
	var artist_city = jQuery.trim(jQuery('#artist_city').val() ) ;
	var artist_state = jQuery.trim ( jQuery('#artist_state').val() ) ;
	var artist_zip = jQuery.trim ( jQuery('#artist_zip').val() ) ;
	
	if ( artist_city == '' ) {
		jQuery('#artist_city_error').html('Please select genre');
		ret = false;
	}
	if ( artist_state == '' ) {
		jQuery('#artist_state_error').html('Please enter state');
		ret = false;
	}
	if ( artist_zip == '' ) {
		jQuery('#artist_zip_error').html('Please enter zip');
		ret = false;
	}
	
	if (artist_genre == -1 ) {
		jQuery('#artist_genre_error').html('Please select genre');
		ret = false;
	}
	return ret;
});

/**********************
 * Video Song Uploading
 *********************/
jQuery(document).on( 'click', '#video_save_song_click' , function () {
	var ret = true;
	jQuery('.error').empty();
	var song_name = jQuery.trim ( jQuery('#video_song_name').val() );
	var aaiu_image_id = jQuery.trim ( jQuery('#aaivu_image_id').val() );
	if ( '' == song_name ) {
		jQuery('#video_song_name_error').html('Please enter song name');
		ret = false;
	}
	if ( undefined == aaiu_image_id || '' == aaiu_image_id ) {
		jQuery('#video_song_error').html('Please upload song');
		ret = false;
	}
	jQuery('#videosongspop').addClass( "cust" );
	
	
	return ret;
	
});

/*****************
* Change video song
*****************/
jQuery(document).on( 'click', '.video-songs-play' , function () {
	var song_id = jQuery(this).attr('id');
	var newid = "#video-songs-"+song_id.substring(6);
	var songurl = jQuery(newid).html();
	console.log(song_id);
	console.log(newid);
	console.log(songurl);
	jQuery("#wp_mep_1").val(songurl);
});

/*****************
* Featured artist of week 
*****************/
jQuery(document).on( 'click', '#payment_featured' , function () {
	jQuery('.soundhouse_errors').empty();
	var ret = true;
	var first_name = jQuery.trim ( jQuery('#first_name').val() ) ;
	var last_name = jQuery.trim ( jQuery('#last_name').val() ) ;
	var address = jQuery.trim ( jQuery('#address').val() ) ;
	var city = jQuery.trim ( jQuery('#city').val() ) ;
	var state = jQuery.trim ( jQuery('#state').val() ) ;
	var zip = jQuery.trim ( jQuery('#zip').val() ) ;
	var card_number = jQuery.trim ( jQuery('#card_number').val() ) ;
	var cvn = jQuery.trim ( jQuery('#cvn').val() ) ;
	var option_month = jQuery.trim ( jQuery('#option_month').val() ) ;
	var option_year = jQuery.trim ( jQuery('#option_year').val() ) ;
	
	if ( first_name == '' ) {
		jQuery('#first_name_error').html('Please enter first name');
		ret = false;
	}
	if ( last_name == '' ) {
		jQuery('#last_name_error').html('Please enter last name');
		ret = false;
	}
	if ( address == '' ) {
		jQuery('#address_error').html('Please enter address');
		ret = false;
	}
	if ( city == '' ) {
		jQuery('#city_error').html('Please enter city');
		ret = false;
	}
	if ( state == '' ) {
		jQuery('#state_error').html('Please enter state');
		ret = false;
	}
	if ( zip == '' ) {
		jQuery('#zip_error').html('Please enter zip');
		ret = false;
	}
	if ( card_number == '' ) {
		jQuery('#card_number_error').html('Please enter card number');
		ret = false;
	}
	if ( cvn == '' ) {
		jQuery('#cvn_error').html('Please enter CVV');
		ret = false;
	}
	if ( option_month == '' ) {
		jQuery('#option_month_error').html('Please select month');
		ret = false;
	}
	if ( option_year == '' ) {
		jQuery('#option_year_error').html('Please select year');
		ret = false;
	}
	return ret;
});

jQuery("#searchheaderclick").click( function () {
	jQuery("#searchsubmit").trigger('click');
});

jQuery(document).ready(function() {
	



}); 

	jQuery(document).on('click','.feat-block-rock', function () {
	var dividart = jQuery(this).attr('id');
	var newidart = dividart.substring(17);
	var divtodisplay = "#music-rock-"+newidart;
	console.log(newidart);
	console.log(divtodisplay);
	jQuery(".music-info-rock").hide();
	jQuery(divtodisplay).show();
	
});

jQuery(document).on('click','.feat-block-pop', function () {
	var dividart = jQuery(this).attr('id');
	var newidart = dividart.substring(16);
	var divtodisplay = "#music-pop-"+newidart;
	console.log(newidart);
	console.log(divtodisplay);
	jQuery(".music-info-pop").hide();
	jQuery(divtodisplay).show();
	
});
jQuery(document).on('click','.feat-block-alternative', function () {
	var dividart = jQuery(this).attr('id');
	var newidart = dividart.substring(24);
	var divtodisplay = "#music-alternative-"+newidart;
	console.log(newidart);
	console.log(divtodisplay);
	jQuery(".music-info-alternative").hide();
	jQuery(divtodisplay).show();
	
});
jQuery(document).on('click','.feat-block-country', function () {
	var dividart = jQuery(this).attr('id');
	var newidart = dividart.substring(20);
	var divtodisplay = "#music-country-"+newidart;
	console.log(newidart);
	console.log(divtodisplay);
	jQuery(".music-info-country").hide();
	jQuery(divtodisplay).show();
	
});
jQuery(document).on('click','.feat-block-hip-hop', function () {
	var dividart = jQuery(this).attr('id');
	var newidart = dividart.substring(20);
	var divtodisplay = "#music-hip-hop-"+newidart;
	console.log(newidart);
	console.log(divtodisplay);
	jQuery(".music-info-hip-hop").hide();
	jQuery(divtodisplay).show();
	
});
jQuery(document).on('click','.feat-block-misc', function () {
	var dividart = jQuery(this).attr('id');
	var newidart = dividart.substring(17);
	var divtodisplay = "#music-misc-"+newidart;
	console.log(newidart);
	console.log(divtodisplay);
	jQuery(".music-info-misc").hide();
	jQuery(divtodisplay).show();
	
});

/**********************
 * Artist Contact 
 *********************/
jQuery(document).on('click','#artist_contact_but', function () {
jQuery('.soundhouse_errors').empty();
jQuery('.form-control').empty();
	var acret = true;
	var acname = jQuery('#artist_contact_name').val();
	var acemail = jQuery('#artist_contact_email').val();
	var user_id = jQuery('#artist_contact_hidden').val();
	var acmessage = jQuery('#artist_contact_message').val();
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		if(!emailReg.test(acemail)) {
            		jQuery("#acemailei").html('Enter a valid email address');
           		 acret = false;
        	}
	if ( acname == '' ) {
		jQuery('#acnameei').html('Please enter band name');
		acret = false;
	}
	if ( acemail == '' ) {
		jQuery('#acemailei').html('Please enter email address');
		acret = false;
	}
	if (  acmessage == '' ) {
		jQuery('#acmessageei').html('Please enter message you want to deliver');
		acret = false;
	}
	jQuery(document).on('click','#artist_contact_name', function () {
		jQuery('#acnameei').empty();
	});
	jQuery(document).on('click','#artist_contact_email', function () {
		jQuery('#acemailei').empty();
	});
	jQuery(document).on('click','#artist_contact_message', function () {
		jQuery('#acmessageei').empty();
	});
		
	if(acret)
	{
	jQuery.ajax({
			type : "post",
			url : myAjax.ajaxurl,
			data : {
				action: "soundhouse_band_contact_email", 
				acname : acname,
				acemail: acemail,
				acmessage: acmessage,
				user_id: user_id
			},
			success: function( response ) {
				if ( response == '-1' ) {
					jQuery("#ajax_loader_show").html('Message has not been sent');
					
					
				} else {
					jQuery('.form-group').hide();
					jQuery('#ajax_loader_show').html(' Your message has been sent');					
				}
			},
			async: false
		});
	}
	
});

