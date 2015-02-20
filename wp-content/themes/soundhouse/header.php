<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<script>
document.createElement("article");
document.createElement("aside");
document.createElement("audio");
document.createElement("canvas");
document.createElement("command");
document.createElement("datalist");
document.createElement("details");
document.createElement("embed");
document.createElement("figcaption");
document.createElement("figure");
document.createElement("footer");
document.createElement("header");
document.createElement("hgroup");
document.createElement("keygen");
document.createElement("mark");
document.createElement("meter");
document.createElement("nav");
document.createElement("output");
document.createElement("progress");
document.createElement("rp");
document.createElement("rt");
document.createElement("ruby");
document.createElement("section");
document.createElement("source");
document.createElement("summary");
document.createElement("time");
document.createElement("video");
</script>
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:800,400,700' rel='stylesheet' type='text/css'>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	//mp3j_addscripts(); 
	wp_head();
?>
</head>


<body <?php body_class(); ?>>
<div class="modal fade" id="myModal2">
<form method = "post" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <h2 class="text-center modal-title">Sign in to Soundhouse</h2>
      </div>
      
		  <div class="modal-body">
			
			<div class="inner-form">
			  <div class="form-group">
				<input type="email" id = "user_email" class="form-control" placeholder="Emaill Address"/>
			  </div>
			  <div class="form-group">
				<input type="password" id= "user_password" class="form-control" placeholder="Password"/>
			  </div>
			  <div id= "invalid_credential"></div>
			  <div class="form-group">
				<div id = "signin_ajax_loader_show" style= "display:none" ><img src= "<?php bloginfo('template_url'); ?>/images/ajaxloader.gif" /></div>
				<a href="<?php echo get_the_permalink('684'); ?>"><p class="text-center">Not registered? Sign Up Now!</p></a>
			  </div>
			</div>
			
		  </div>
		
      <div class="modal-footer text-center">
        <button class=" button-info btn btn-primary btn-lg ;pgm" id = "login_ajax" type="button">Sign in</button>
      </div>
    </div>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
  </form> 
</div>
<!-- /.modal --> 

<?php

$current_user_id = get_current_user_id();
$soun_artst = get_user_meta($current_user_id,"soundhouse_artist",true);   
?>
<!-- /container -->
<div class="wrap">
  <header>
    <div class="topbar">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-xs-12  col-sm-4 left">
            <div class="form-group  col-lg-6 col-md-6">
            <form role="search" method="post" id="searchform" class="searchform" action="<?php echo get_permalink(9); ?>">
				<div>
					<input type="text" value="<?php if ( isset ( $_POST['searchforartist'] ) ) { echo $_POST['artistsearchname']; } ?>" name="artistsearchname" id="artistsearchname" placeholder="Search Artists" />
					<span id= "searchheaderclick" class="glyphicon glyphicon-search form-control-feedback"></span>
					<input name= "searchforartist" type="submit" style="display:none" id="searchsubmit" value="<?php esc_attr_x( 'Search', 'submit button' ); ?>" />
				</div>
			</form>
              
        </div>
          </div>
          <div class="col-lg-6 col-md-6 col-xs-12 col-sm-8  right">
            <ul class="nav navbar-nav navbar-right">
				<?php if ( is_user_logged_in() ) {
					?>
					<?php if (!empty($soun_artst )) : ?>
						<li><a href="<?php echo get_permalink(232); ?>" >Admin</a></li>
					<?php endif; ?>
					<li><a href="<?php echo wp_logout_url( site_url() ); ?>" >Logout</a></li>
					<?php
				} else {
					?>
					<li><a href="<?php echo site_url();?>/pricing">Artist Register</a></li>
					<li><a href="javascript:void(0)" class= "log-in-soundhouse" >Log In</a></li>
					<?php
				}
				?>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="logo-area text-center"> <a href="<?php echo site_url();   ?>" class="logo"><img src="<?php bloginfo('template_url'); ?>/images/logo.png" alt="logo"/></a> </div>
    </div>
  </header>
  <!-- end header -->

  <div class="container main-body">
    <div class="content-area col-lg-12 col-md-12">
      <nav class="navbar navbar-default" role="navigation">
        <div class="container"> 
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
            
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            
			<ul class="nav navbar-nav">
				<li class="active"><a href="<?php echo site_url(); ?>/artists/">Artists</a></li>
				<li><a href="<?php echo site_url(); ?>/blog/">Blog </a></li>
				<li><a href="<?php echo site_url(); ?>/pricing/">Pricing </a></li>
				<li><a href="<?php echo site_url(); ?>/gigsevents/">Gigs + Events </a></li>
				<li><a href="<?php echo site_url(); ?>/about/"> About </a></li>
				<li><a href="<?php echo site_url(); ?>/contact/">Contact</a></li>
              </ul>
              
            </div>
            <!-- /.navbar-collapse --> 
          </div>
        </div>
      </nav>
      <!--<nav>
        <div class="col-lg-12 col-md-12  col-xs-12 col-sm-12 ">
            <?php // wp_nav_menu(array('theme_location'=>'primary','menu_class'=>'nav navbar-nav')); ?>
        </div>
      </nav> -->
      <nav class="main-menu">
      <?php if (!empty($soun_artst )) : ?>
		<?php if ( current_user_is("s2member_level2") ) : ?>
			<?php wp_nav_menu( array( 'container_class' => 'col-lg-5 col-md-5  col-xs-12 col-sm-6 navbar-left left-menu ', 'items_wrap' => '<ul id="%1$s" class="nav navbar-nav">%3$s</ul>', 'theme_location' => 'leftnavartist' ) ); ?>
		<?php else : ?>
			<?php wp_nav_menu( array( 'container_class' => 'col-lg-5 col-md-5  col-xs-12 col-sm-6 navbar-left', 'items_wrap' => '<ul id="%1$s" class="nav navbar-nav  navbar-right left-menu">%3$s</ul>', 'theme_location' => 'leftnav' ) ); ?>
		<?php endif; ?>
      <?php else : ?>
		<?php wp_nav_menu( array( 'container_class' => 'col-lg-5 col-md-5  col-xs-12 col-sm-6 navbar-left', 'items_wrap' => '<ul id="%1$s" class="nav navbar-nav  navbar-right left-menu">%3$s</ul>', 'theme_location' => 'leftnav' ) ); ?>
      <?php endif; ?>
      
        <?php if (!empty($soun_artst )) : ?>
			<?php if ( current_user_is("s2member_level2") ) : ?>
				<?php wp_nav_menu( array( 'container_class' => 'col-lg-5 col-md-5 col-sm-6  col-xs-12 pull-right right-menu', 'items_wrap' => '<ul id="%1$s" class="nav navbar-nav  right-menu">%3$s</ul>', 'theme_location' => 'rightnavartist' ) ); ?>
			<?php else: ?>
				<?php wp_nav_menu( array( 'container_class' => 'col-lg-5 col-md-7 col-sm-6  col-xs-12 navbar-right', 'items_wrap' => '<ul id="%1$s" class="nav navbar-nav  right-menu">%3$s</ul>', 'theme_location' => 'rightnav' ) ); ?>
			<?php endif; ?>
		<?php else : ?>
			<?php wp_nav_menu( array( 'container_class' => 'col-lg-5 col-md-7 col-sm-6  col-xs-12 navbar-right', 'items_wrap' => '<ul id="%1$s" class="nav navbar-nav  right-menu">%3$s</ul>', 'theme_location' => 'rightnav' ) ); ?>
		<?php endif; ?>
        
      
      </nav>
