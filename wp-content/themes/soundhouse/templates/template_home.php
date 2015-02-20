<?php
/*
 * Template Name: Home
 */
 get_header();
 if(strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'],'Android') )  { 
	 $value = 2; ?>
	 <style>.hidden-xs { display: block !important; } </style>
	 <?php
 } else {
	 $value = 4;
	 
	  }
?>
<?php                   
				global $wpdb;
				$featured_artist = $wpdb->prefix."featured_artist";
				$qry = "select * from $featured_artist WHERE   DATEDIFF(NOW(), payment_date) <= 7  ";
				$sql = mysql_query($qry); 
				while ($result = mysql_fetch_array($sql)){
				
				$art_feat_id[]  = $result['user_id'];
				
				} ?>

 <link rel="stylesheet" type="text/css" href="csslider/jquery.bxslider.css"/>
   <div class="banner text-center"> 
      
    <?php // echo do_shortcode('[metaslider id=6]'); ?>
     <?php  echo do_shortcode('[rev_slider home]'); ?>
      </div>
    <div class="inner-content-area">
        <aside class="col-lg-3 col-md-3 col-xs-12 col-sm-3">
          <?php dynamic_sidebar('legacy-tour');   ?>
             <?php dynamic_sidebar('sph-sponsors');   ?>
        
        </aside>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
          <div class="artist">
            <h2>FEATURED ARTISTS</h2>
            <div class="bs-example bs-example-tabs">
              <ul role="tablist" class="nav nav-tabs" id="myTab">
				<?php
				$liArray = array();
				$temp = array();
				$temp ['html'] = ' <a data-toggle="tab" role="tab" href="#rock">Rock</a>';
				$temp['value'] = 'rock';
				$liArray[]= $temp;
				/******************/
				$temp =array();
				$temp ['html'] = '<a data-toggle="tab" role="tab" href="#hip-hop">Hip-Hop</a>';
				$temp['value'] = 'hip-hop';
				$liArray[]= $temp;
				/******************/
				$temp= array();
				$temp ['html'] = '  <a data-toggle="tab" role="tab" href="#country">Country</a>';
				$temp['value'] = 'country';
				$liArray[]= $temp;
				/******************/
				$temp= array();
				$temp ['html'] = ' <a data-toggle="tab" role="tab" href="#alternative">Alternative</a>';
				$temp['value'] = 'alternative';
				$liArray[]= $temp;
				/******************/
				$temp= array();
				$temp ['html'] = ' <a data-toggle="tab" role="tab" href="#pop">Pop</a>';
				$temp['value'] = 'pop';
				$liArray[]= $temp;
				/******************/
				/******************/
				$temp= array();
				$temp ['html'] = ' <a data-toggle="tab" role="tab" href="#misc">Misc</a>';
				$temp['value'] = 'misc';
				$liArray[]= $temp;
				shuffle($liArray);
				$i=0;
				$activeDiv = '';
				foreach($liArray as $li)
				{
					if($i==0)
					{
						$finalArr[] = '<li class="active">'.$li['html'].'</li>';
						$activeDiv = $li['value'];
					}
					else
					{
						$finalArr[] = '<li>'.$li['html'].'</li>';
					}
					$i++;
					
				}
				$str = implode("", $finalArr);
				echo $str;
				/******************/ 
				?>
                
                
              </ul>
              <div class="tab-content" id="myTabContent">
				<?php
				if ( $activeDiv == 'rock') {
					$rockeclasses = 'active in';
				} else {
					$rockeclasses = '';
				}
				?>
                <div id="rock" class="tab-pane fade <?php echo $rockeclasses; ?>">
                  <div id="carousel-example-generic-rock" class="carousel slide hidden-xs row" data-ride="carousel"> 
            <!-- Wrapper for slides -->
                <div class="carousel-inner">
                  <?php 

				 $count = 1;
				 $activeclass = "active";
			     $args = array(
								'post_type' => 'artist',
								'showposts' => -1,
								'orderby' => 'rand',
								'author__in' => $art_feat_id,
								'tax_query' => array(
							array(
									'taxonomy' => 'artist_list',
									'field' => 'ID',
									'terms' => 21
								)
							)
					);
					$featquery = new WP_Query( $args );  
					$totartists = $featquery->found_posts;   
					$activecount = 1;
                  while($featquery->have_posts()) : $featquery->the_post();
                  if($activecount == 1) { ?>
                  	<div class="item <?php if($count == 1){ echo 'active'; }  ?>">
					<?php } ?>	
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
					<a id="music-track-rock-<?php the_ID(); ?>" class="feat-block-rock" href="javascript: void(0);"><?php the_post_thumbnail('featured-artist-thum'); ?></a>
					<p><?php the_title(); ?></p>
					</div>
					<?php
						// close item div
						if($activecount == $value){  
							// close item div
								echo '</div>';
								$activecount = 0;		
							}
					?>
					<?php
					$activecount++;
					$count++;
					endwhile;
					wp_reset_query();  
					if($activecount > 1){
						// close item div again if artist comes in odd numbers
						echo '</div>';
						}
					?>
					
                 </div><!-- close .carousel-inner -->
              <div class="controller"> <a href="#carousel-example-generic-rock" class="prev left fa fa-chevron-left btn btn-primary" data-slide="prev"></a> <a href="#carousel-example-generic-rock" class="next right fa fa-chevron-right btn btn-primary" data-slide="next"></a> </div>
          </div><!-- closr carousel -->
                   
                   <?php 
				
                  $argsmusic = array(
								'post_type' => 'artist',
								'showposts' => -1,
								'orderby' => 'rand',
								'author__in' => $art_feat_id,
								'tax_query' => array(
							array(
									'taxonomy' => 'artist_list',
									'field' => 'ID',
									'terms' => 21
								)
							)
					);
                  $featquerymusic = new WP_Query( $argsmusic ); 
                  $countrocknew = 0;
                  while($featquerymusic->have_posts()) : $featquerymusic->the_post();
                  $countrocknew++; ?>
                  <?php if ( $countrocknew== 1 ) : ?>
					<div id="music-rock-<?php the_ID(); ?>" class="row music-info-rock music-info">
					<?php else : ?>
					<div id="music-rock-<?php the_ID(); ?>" class="row music-info-rock music-info" style= "display:none">
					<?php endif; ?>
                    <div class="col-lg-3 col-md-3 col-sm-12"><?php the_post_thumbnail('featured-artist-thum'); ?> </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                      <h3><?php the_title(); ?></h3>
                      <?php 
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
                   <?php echo fetch_author_song ($user_id_post);?>
                    
                    </div><!-- close .col-lg-6 col-md-6 col-sm-12 -->
                    <div class="col-lg-3 col-md-3 col-sm-12">
                  
                      <ul class="social">
                        <li><a target="_blank" href="<?php echo $fburl; ?>"><span class="icon-facebook"></span></a></li>
                        <li><a target="_blank" href="<?php echo $twurl; ?>"><span class="icon-twitter"></span></a></li>
                        <li><a target="_blank" href="<?php echo $googleurl; ?>"><span class="icon-googleplus"></span></a></li>
                      </ul>
                    </div><!-- close .col-lg-3 -->
                  </div><!-- close #myrock -->
                   <?php $rowid ++;
					endwhile;
					wp_reset_query();  
					?>
                </div><!-- close .tab-pane -->
                
                <?php
				if ( $activeDiv == 'hip-hop') {
					$hiphopclasses = 'active in';
				} else {
					$hiphopclasses = '';
				}
				?>
				<div id="hip-hop" class="tab-pane fade <?php echo $hiphopclasses; ?>">
                  
                 <div id="carousel-example-generic-hip-hop" class="carousel slide hidden-xs row" data-ride="carousel"> 
            <!-- Wrapper for slides -->
                <div class="carousel-inner">
                  <?php 

				 $count = 1;
				 $activeclass = "active";
			     $args = array(
								'post_type' => 'artist',
								'showposts' => -1,
								'orderby' => 'rand',
								'author__in' => $art_feat_id,
								'tax_query' => array(
							array(
									'taxonomy' => 'artist_list',
									'field' => 'ID',
									'terms' => 63
								)
							)
					);
					$featquery = new WP_Query( $args );   
					 
                  $activecount = 1;
                  while($featquery->have_posts()) : $featquery->the_post();
                   if($activecount == 1) { ?>
                  	<div class="item <?php if($count == 1){ echo 'active'; }  ?>">
					<?php } ?>	  
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
					<a id="music-track-hip-hop-<?php the_ID(); ?>" class="feat-block-hip-hop" href="javascript: void(0);"><?php the_post_thumbnail('featured-artist-thum'); ?></a>
					<p><?php the_title(); ?></p>
					</div>
					<?php
						// close item div
						if($activecount == $value){  
							// close item div
								echo '</div>';
								$activecount = 0;		
							}
					?>
					<?php
					$activecount++;
					$count++;
					endwhile;
					wp_reset_query();  
					if($activecount > 1){
						// close item div again if artist comes in odd numbers
						echo '</div>';
						}
					?>
                   
           
             </div> <!--carousel-inner-->
            <div class="controller"> <a href="#carousel-example-generic-hip-hop" class="prev left fa fa-chevron-left btn btn-primary" data-slide="prev"></a> <a href="#carousel-example-generic-hip-hop" class="next right fa fa-chevron-right btn btn-primary" data-slide="next"></a> </div>
          </div> <!--carousel-example-generic-hip-hop -->
                  
                   
                   <?php 
				
                  $argsmusic = array(
								'post_type' => 'artist',
								'showposts' => -1,
								'orderby' => 'rand',
								'author__in' => $art_feat_id,
								'tax_query' => array(
							array(
									'taxonomy' => 'artist_list',
									'field' => 'ID',
									'terms' => 63
								)
							)
					);
                  $featquerymusic = new WP_Query( $argsmusic ); 
                  $counthipnew = 0;
                  while($featquerymusic->have_posts()) : $featquerymusic->the_post();
                  $counthipnew++; ?>
                  <?php if ( $counthipnew== 1 ) : ?>
					<div id="music-hip-hop-<?php the_ID(); ?>" class="row music-info-hip-hop music-info">
					<?php else : ?>
					<div id="music-hip-hop-<?php the_ID(); ?>" class="row music-info-hip-hop music-info" style= "display:none">
					<?php endif; ?>
                    <div class="col-lg-3 col-md-3 col-sm-12"><?php the_post_thumbnail('featured-artist-thum'); ?> </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                      <h3><?php the_title(); ?></h3>
                    <?php 
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
                   <?php echo fetch_author_song ($user_id_post);?>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12">
                
                      <ul class="social">
                        <li><a target="_blank" href="<?php echo $fburl; ?>"><span class="icon-facebook"></span></a></li>
                        <li><a target="_blank" href="<?php echo $twurl; ?>"><span class="icon-twitter"></span></a></li>
                        <li><a target="_blank" href="<?php echo $googleurl; ?>"><span class="icon-googleplus"></span></a></li>
                      </ul>
                    </div>
                  </div>
                   <?php $rowid ++;
					endwhile;
					wp_reset_query();  
					?>
                   
              </div> <!--tab-pane -->
              
                <?php
				if ( $activeDiv == 'country') {
					$countryclasses = 'active in';
				} else {
					$countryclasses = '';
				}
				?>
				<div id="country" class="tab-pane fade <?php echo $countryclasses; ?>">
                   <div id="carousel-example-generic-country" class="carousel slide hidden-xs row" data-ride="carousel"> 
            <!-- Wrapper for slides -->
                <div class="carousel-inner">
                  <?php 

				 $count = 1;
				 $activeclass = "active";
			     $args = array(
								'post_type' => 'artist',
								'showposts' => -1,
								'orderby' => 'rand',
								'author__in' => $art_feat_id,
								'tax_query' => array(
							array(
									'taxonomy' => 'artist_list',
									'field' => 'ID',
									'terms' => 7
								)
							)
					);
					$featquery = new WP_Query( $args );    
                  $activecount = 1;
                  while($featquery->have_posts()) : $featquery->the_post();
                   if($activecount == 1) { ?>
                  	<div class="item <?php if($count == 1){ echo 'active'; }  ?>">
					<?php } ?>	   
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
					<a id="music-track-country-<?php the_ID(); ?>" class="feat-block-country" href="javascript: void(0);"><?php the_post_thumbnail('featured-artist-thum'); ?></a>
					<p><?php the_title(); ?></p>
					</div>
					<?php
					 // close item div
						if($activecount == $value){  
							// close item div
								echo '</div>';
								$activecount = 0;		
							}
					?>
					<?php
					$activecount++;
					$count++;
					endwhile;
					wp_reset_query();  
					if($activecount > 1){
						// close item div again if artist comes in odd numbers
						echo '</div>';
						}		
					?>
                   
          </div> <!--close carousel-inner -->
            <div class="controller"> <a href="#carousel-example-generic-country" class="prev left fa fa-chevron-left btn btn-primary" data-slide="prev"></a> <a href="#carousel-example-generic-country" class="next right fa fa-chevron-right btn btn-primary" data-slide="next"></a> </div>
          </div> <!--Close carousel-example-generic-country -->
                  
                   <?php 
				
                  $argsmusic = array(
								'post_type' => 'artist',
								'showposts' => -1,
								'orderby' => 'rand',
								'author__in' => $art_feat_id,
								'tax_query' => array(
							array(
									'taxonomy' => 'artist_list',
									'field' => 'ID',
									'terms' => 7
								)
							)
					);
                  $featquerymusic = new WP_Query( $argsmusic ); 
                  $countcountrynew = 0;
                  while($featquerymusic->have_posts()) : $featquerymusic->the_post();
                  $countcountrynew++; ?>
                  <?php if ( $countcountrynew== 1 ) : ?>
					<div id="music-country-<?php the_ID(); ?>" class="row music-info-country music-info">
					<?php else : ?>
					<div id="music-country-<?php the_ID(); ?>" class="row music-info-country music-info" style= "display:none">
					<?php endif; ?>
                    <div class="col-lg-3 col-md-3 col-sm-12"><?php the_post_thumbnail('featured-artist-thum'); ?> </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                      <h3><?php the_title(); ?></h3>
					<?php 
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
                   <?php echo fetch_author_song ($user_id_post);?>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12">
                
                      <ul class="social">
                        <li><a target="_blank" href="<?php echo $fburl; ?>"><span class="icon-facebook"></span></a></li>
                        <li><a target="_blank" href="<?php echo $twurl; ?>"><span class="icon-twitter"></span></a></li>
                        <li><a target="_blank" href="<?php echo $googleurl; ?>"><span class="icon-googleplus"></span></a></li>
                      </ul>
                    </div>
                  </div>
                   <?php $rowid ++;
					endwhile;
					wp_reset_query();  
					?>
                 </div> <!-- tab-pane -->
                <?php
				if ( $activeDiv == 'alternative') {
					$alternativeclasses = 'active in';
				} else {
					$alternativeclasses = '';
				}
				?>
				<div id="alternative" class="tab-pane fade <?php echo $alternativeclasses; ?>">
                 
                 <div id="carousel-example-generic-alternative" class="carousel slide hidden-xs row" data-ride="carousel"> 
            <!-- Wrapper for slides -->
                <div class="carousel-inner">
                  <?php 

				 $count = 1;
				 $activeclass = "active";
			     $args = array(
								'post_type' => 'artist',
								'showposts' => -1,
								'orderby' => 'rand',
								'author__in' => $art_feat_id,
								'tax_query' => array(
							array(
									'taxonomy' => 'artist_list',
									'field' => 'ID',
									'terms' => 64
								)
							)
					);
				  $featquery = new WP_Query( $args );    
                  $activecount = 1;
                  while($featquery->have_posts()) : $featquery->the_post();?>
              <?php   if($activecount == 1) { ?>
                  	<div class="item <?php if($count == 1){ echo 'active'; }  ?>">
					<?php } ?>	  
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
					<a id="music-track-alternative-<?php the_ID(); ?>" class="feat-block-alternative" href="javascript: void(0);"><?php the_post_thumbnail('featured-artist-thum'); ?></a>
					<p><?php the_title(); ?></p>
					</div>
					<?php
					 // close item div
						if($activecount == $value){  
							// close item div
								echo '</div>';
								$activecount = 0;		
							}
					?>
					<?php
					$activecount++;
					$count++;
					endwhile;
					wp_reset_query(); 
					if($activecount > 1){
						// close item div again if artist comes in odd numbers
						echo '</div>';
						} 
					?>
         
           
             </div> <!-- close carousel-inner-->
            <div class="controller"> <a href="#carousel-example-generic-alternative" class="prev left fa fa-chevron-left btn btn-primary" data-slide="prev"></a> <a href="#carousel-example-generic-alternative" class="next right fa fa-chevron-right btn btn-primary" data-slide="next"></a> </div>
          </div> <!--carousel-example-generic-alternative -->
       
                  <?php 
				
                  $argsmusic = array(
								'post_type' => 'artist',
								'showposts' => -1,
								'orderby' => 'rand',
								'author__in' => $art_feat_id,
								'tax_query' => array(
							array(
									'taxonomy' => 'artist_list',
									'field' => 'ID',
									'terms' => 64
								)
							)
					);
                  $featquerymusic = new WP_Query( $argsmusic ); 
                  $countalternativenew = 0;
                  while($featquerymusic->have_posts()) : $featquerymusic->the_post();
                  $countalternativenew++; ?>
                  <?php if ( $countalternativenew== 1 ) : ?>
					<div id="music-alternative-<?php the_ID(); ?>" class="row music-info-alternative music-info">
					<?php else : ?>
					<div id="music-alternative-<?php the_ID(); ?>" class="row music-info-alternative music-info" style= "display:none">
					<?php endif; ?>
                    <div class="col-lg-3 col-md-3 col-sm-12"><?php the_post_thumbnail('featured-artist-thum'); ?> </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                      <h3><?php the_title(); ?></h3>
                      <?php 
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
                   <?php echo fetch_author_song ($user_id_post);?>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12">
                
                      <ul class="social">
                        <li><a target="_blank" href="<?php echo $fburl; ?>"><span class="icon-facebook"></span></a></li>
                        <li><a target="_blank" href="<?php echo $twurl; ?>"><span class="icon-twitter"></span></a></li>
                        <li><a target="_blank" href="<?php echo $googleurl; ?>"><span class="icon-googleplus"></span></a></li>
                      </ul>
                    </div>
                  </div>
                   <?php $rowid ++;
					endwhile;
					wp_reset_query();  
					?>
                  </div> <!-- tab-pane -->
                <?php
				if ( $activeDiv == 'pop') {
					$popclasses = 'active in';
				} else {
					$popclasses = '';
				}
				?>
				<div id="pop" class="tab-pane fade <?php echo $popclasses; ?>">
                <div id="carousel-example-generic-pop" class="carousel slide hidden-xs row" data-ride="carousel"> 
            <!-- Wrapper for slides -->
                <div class="carousel-inner">
                  <?php 

				 $count = 1;
				 $activeclass = 1;
			     $args = array(
								'post_type' => 'artist',
								'showposts' => -1,
								'orderby' => 'rand',
								'author__in' => $art_feat_id,
								'tax_query' => array(
							array(
									'taxonomy' => 'artist_list',
									'field' => 'ID',
									'terms' => 6
								)
							)
					);
					$featquery = new WP_Query( $args );    
                  $activecount = 1;
                  while($featquery->have_posts()) : $featquery->the_post();
                if($activecount == 1) { ?>
                  	<div class="item <?php if($count == 1){ echo 'active'; }  ?>">
					<?php } ?>  
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
					<a id="music-track-pop-<?php the_ID(); ?>" class="feat-block-pop" href="javascript: void(0);"><?php the_post_thumbnail('featured-artist-thum'); ?></a>
					<p><?php the_title(); ?></p>
					</div>
					<?php
						// close item div
						if($activecount == $value){  
							// close item div
								echo '</div>';
								$activecount = 0;		
							}
					?>
					<?php $activeclass ++;
					$activecount++;
					$count++;
					endwhile;
					wp_reset_query(); 
					if($activecount > 1){
						// close item div again if artist comes in odd numbers
						echo '</div>';
						}	
					?>
                    
           
             </div><!--Close carousel-inner -->
            <div class="controller"> <a href="#carousel-example-generic-pop" class="prev left fa fa-chevron-left btn btn-primary" data-slide="prev"></a> <a href="#carousel-example-generic-pop" class="next right fa fa-chevron-right btn btn-primary" data-slide="next"></a> </div>
          </div><!--Close carousel-example-generic-pop -->
           <?php 
				
                  $argsmusic = array(
								'post_type' => 'artist',
								'showposts' => -1,
								'orderby' => 'rand',
								'author__in' => $art_feat_id,
								'tax_query' => array(
							array(
									'taxonomy' => 'artist_list',
									'field' => 'ID',
									'terms' => 6
								)
							)
					);
                  $featquerymusic = new WP_Query( $argsmusic ); 
                  $countpop = 0;
                  while($featquerymusic->have_posts()) : $featquerymusic->the_post();
                  $countpop++; ?>
                  <?php if ( $countpop== 1 ) : ?>
					<div id="music-pop-<?php the_ID(); ?>" class="row music-info-pop music-info">
					<?php else : ?>
					<div id="music-pop-<?php the_ID(); ?>" class="row music-info-pop music-info" style= "display:none">
					<?php endif; ?>
                    <div class="col-lg-3 col-md-3 col-sm-12"><?php the_post_thumbnail('featured-artist-thum'); ?> </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                      <h3><?php the_title(); ?></h3>
                    <?php 
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
                   <?php echo fetch_author_song ($user_id_post);?>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12">
                
                      <ul class="social">
                        <li><a target="_blank" href="<?php echo $fburl; ?>"><span class="icon-facebook"></span></a></li>
                        <li><a target="_blank" href="<?php echo $twurl; ?>"><span class="icon-twitter"></span></a></li>
                        <li><a target="_blank" href="<?php echo $googleurl; ?>"><span class="icon-googleplus"></span></a></li>
                      </ul>
                    </div>
                  </div>
                   <?php $rowid ++;
					endwhile;
					wp_reset_query();  
					?>
                  </div> <!-- tab-pane-->
                <?php
				if ( $activeDiv == 'misc') {
					$miscclasses = 'active in';
				} else {
					$miscclasses = '';
				}
				?>
				<div id="misc" class="tab-pane fade <?php echo $miscclasses; ?>">
                 
                 <div id="carousel-example-generic-misc" class="carousel slide hidden-xs row" data-ride="carousel"> 
            <!-- Wrapper for slides -->
                <div class="carousel-inner">
                  <?php 
					$args = array( 'exclude' => array(6,7,21,63,64) );
					$terms = get_terms('artist_list', $args);
					$termids = array();
					foreach ($terms as $term) {
						array_push($termids, $term->term_id);
					}	
				 $count = 1;
				 $activeclass = "active";
			     $args = array(
								'post_type' => 'artist',
								'showposts' => -1,
								'orderby' => 'rand',
								'author__in' => $art_feat_id,
								'tax_query' => array(
							array(
									'taxonomy' => 'artist_list',
									'field' => 'ID',
									'terms' => $termids
								)
							)
					);
					$featquery = new WP_Query( $args );    
                  $activecount = 1;
                  while($featquery->have_posts()) : $featquery->the_post();
                  
                 if($activecount == 1) { ?>
                  	<div class="item <?php if($count == 1){ echo 'active'; }  ?>">
					<?php } ?>	
					  
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
					<a id="music-track-misc-<?php the_ID(); ?>" class="feat-block-misc" href="javascript: void(0);"><?php the_post_thumbnail('featured-artist-thum'); ?></a>
					<p><?php the_title(); ?></p>
					</div>
					<?php
					  // close item div
						if($activecount == $value){  
							// close item div
								echo '</div>';
								$activecount = 0;		
							}
					?>
					<?php
					$activecount++;
					$count++;
					endwhile;
					wp_reset_query();  
					if($activecount > 1  ){
						// close item div again if artist comes in odd numbers
						echo '</div>';
						}
					?>
                  
             </div> <!--Close carousel-inner --> 
            <div class="controller"> <a href="#carousel-example-generic-misc" class="prev left fa fa-chevron-left btn btn-primary" data-slide="prev"></a> <a href="#carousel-example-generic-misc" class="next right fa fa-chevron-right btn btn-primary" data-slide="next"></a> </div>
          </div> <!--close carousel-example-generic-misc -->
                 
          <?php 
				
                  $argsmusic = array(
								'post_type' => 'artist',
								'showposts' => -1,
								'orderby' => 'rand',
								'author__in' => $art_feat_id,
								'tax_query' => array(
							array(
									'taxonomy' => 'artist_list',
									'field' => 'ID',
									'terms' => $termids
								)
							)
					);
                  $featquerymusic = new WP_Query( $argsmusic ); 
                  $countmiscnew = 0;
                  while($featquerymusic->have_posts()) : $featquerymusic->the_post();
                  $countmiscnew++; ?>
                  <?php if ( $countmiscnew== 1 ) : ?>
					<div id="music-misc-<?php the_ID(); ?>" class="row music-info-misc music-info">
					<?php else : ?>
					<div id="music-misc-<?php the_ID(); ?>" class="row music-info-misc music-info" style= "display:none">
					<?php endif; ?>
                    <div class="col-lg-3 col-md-3 col-sm-12"><?php the_post_thumbnail('featured-artist-thum'); ?> </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                      <h3><?php the_title(); ?></h3>
                    <?php 
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
                   <?php echo fetch_author_song ($user_id_post);?>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12">
               
                      <ul class="social">
                        <li><a target="_blank" href="<?php echo $fburl; ?>"><span class="icon-facebook"></span></a></li>
                        <li><a target="_blank" href="<?php echo $twurl; ?>"><span class="icon-twitter"></span></a></li>
                        <li><a target="_blank" href="<?php echo $googleurl; ?>"><span class="icon-googleplus"></span></a></li>
                      </ul>
                    </div>
                  </div>
                   <?php $rowid ++;
					endwhile;
					wp_reset_query();  
					?>
        
       </div><!--tab-pane -->
              
              </div>
            </div>
          </div>
        </div>
      </div>
        </div>




<script type="text/javascript">

</script>



<?php get_footer(); ?>
