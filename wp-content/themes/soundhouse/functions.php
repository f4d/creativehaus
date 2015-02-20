<?php
/**
 * TwentyTen functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, twentyten_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'twentyten_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640;

/** Tell WordPress to run twentyten_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'twentyten_setup' );

if ( ! function_exists( 'twentyten_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override twentyten_setup() in a child theme, add your own twentyten_setup to your child theme's
 * functions.php file.
 *
 * @uses add_theme_support() To add support for post thumbnails, custom headers and backgrounds, and automatic feed links.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses add_editor_style() To style the visual editor.
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Post Format support. You can also use the legacy "gallery" or "asides" (note the plural) categories.
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
	) );

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'twentyten', get_template_directory() . '/languages' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'twentyten' ),
		
	) );
   register_nav_menus( array(
		'leftnav' => __( 'Left Navigation', 'twentyten' ),
	) );
	register_nav_menus( array(
		'leftnavartist' => __( 'Left Navigation For Artist', 'twentyten' ),
	) );
	
	register_nav_menus( array(
		'rightnav' => __( 'Right Navigation', 'twentyten' ),
	) );
	register_nav_menus( array(
		'rightnavartist' => __( 'Right Navigation for Artist', 'twentyten' ),
	) );
	

	// This theme allows users to set a custom background.
	add_theme_support( 'custom-background', array(
		// Let WordPress know what our default background color is.
		'default-color' => 'f1f1f1',
	) );

	// The custom header business starts here.

	$custom_header_support = array(
		// The default image to use.
		// The %s is a placeholder for the theme template directory URI.
		'default-image' => '%s/images/headers/path.jpg',
		// The height and width of our custom header.
		'width' => apply_filters( 'twentyten_header_image_width', 940 ),
		'height' => apply_filters( 'twentyten_header_image_height', 198 ),
		// Support flexible heights.
		'flex-height' => true,
		// Don't support text inside the header image.
		'header-text' => false,
		// Callback for styling the header preview in the admin.
		'admin-head-callback' => 'twentyten_admin_header_style',
	);

	add_theme_support( 'custom-header', $custom_header_support );

	if ( ! function_exists( 'get_custom_header' ) ) {
		// This is all for compatibility with versions of WordPress prior to 3.4.
		define( 'HEADER_TEXTCOLOR', '' );
		define( 'NO_HEADER_TEXT', true );
		define( 'HEADER_IMAGE', $custom_header_support['default-image'] );
		define( 'HEADER_IMAGE_WIDTH', $custom_header_support['width'] );
		define( 'HEADER_IMAGE_HEIGHT', $custom_header_support['height'] );
		add_custom_image_header( '', $custom_header_support['admin-head-callback'] );
		add_custom_background();
	}

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be 940 pixels wide by 198 pixels tall.
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( $custom_header_support['width'], $custom_header_support['height'], true );

	// ... and thus ends the custom header business.

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
		'berries' => array(
			'url' => '%s/images/headers/berries.jpg',
			'thumbnail_url' => '%s/images/headers/berries-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Berries', 'twentyten' )
		),
		'cherryblossom' => array(
			'url' => '%s/images/headers/cherryblossoms.jpg',
			'thumbnail_url' => '%s/images/headers/cherryblossoms-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Cherry Blossoms', 'twentyten' )
		),
		'concave' => array(
			'url' => '%s/images/headers/concave.jpg',
			'thumbnail_url' => '%s/images/headers/concave-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Concave', 'twentyten' )
		),
		'fern' => array(
			'url' => '%s/images/headers/fern.jpg',
			'thumbnail_url' => '%s/images/headers/fern-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Fern', 'twentyten' )
		),
		'forestfloor' => array(
			'url' => '%s/images/headers/forestfloor.jpg',
			'thumbnail_url' => '%s/images/headers/forestfloor-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Forest Floor', 'twentyten' )
		),
		'inkwell' => array(
			'url' => '%s/images/headers/inkwell.jpg',
			'thumbnail_url' => '%s/images/headers/inkwell-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Inkwell', 'twentyten' )
		),
		'path' => array(
			'url' => '%s/images/headers/path.jpg',
			'thumbnail_url' => '%s/images/headers/path-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Path', 'twentyten' )
		),
		'sunset' => array(
			'url' => '%s/images/headers/sunset.jpg',
			'thumbnail_url' => '%s/images/headers/sunset-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Sunset', 'twentyten' )
		)
	) );
}
endif;

if ( ! function_exists( 'twentyten_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in twentyten_setup().
 *
 * @since Twenty Ten 1.0
 */
function twentyten_admin_header_style() {
?>
<style type="text/css" id="twentyten-admin-header-css">
/* Shows the same border as on front end */
#headimg {
	border-bottom: 1px solid #000;
	border-top: 4px solid #000;
}
/* If header-text was supported, you would style the text with these selectors:
	#headimg #name { }
	#headimg #desc { }
*/
</style>
<?php
}
endif;

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) )
		$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'twentyten_page_menu_args' );

/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @since Twenty Ten 1.0
 * @return int
 */
function twentyten_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'twentyten_excerpt_length' );

if ( ! function_exists( 'twentyten_continue_reading_link' ) ) :
/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since Twenty Ten 1.0
 * @return string "Continue Reading" link
 */
function twentyten_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyten' ) . '</a>';
}
endif;

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and twentyten_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string An ellipsis
 */
function twentyten_auto_excerpt_more( $more ) {
	return ' &hellip;' . twentyten_continue_reading_link();
}
add_filter( 'excerpt_more', 'twentyten_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string Excerpt with a pretty "Continue Reading" link
 */
function twentyten_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= twentyten_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'twentyten_custom_excerpt_more' );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in Twenty Ten's style.css. This is just
 * a simple filter call that tells WordPress to not use the default styles.
 *
 * @since Twenty Ten 1.2
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Deprecated way to remove inline styles printed when the gallery shortcode is used.
 *
 * This function is no longer needed or used. Use the use_default_gallery_style
 * filter instead, as seen above.
 *
 * @since Twenty Ten 1.0
 * @deprecated Deprecated in Twenty Ten 1.2 for WordPress 3.1
 *
 * @return string The gallery style filter, with the styles themselves removed.
 */
function twentyten_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
// Backwards compatibility with WordPress 3.0.
if ( version_compare( $GLOBALS['wp_version'], '3.1', '<' ) )
	add_filter( 'gallery_style', 'twentyten_remove_gallery_css' );

if ( ! function_exists( 'twentyten_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentyten_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
			<div class="comment-author vcard">
				<?php echo get_avatar( $comment, 40 ); ?>
				<?php printf( __( '%s <span class="says">says:</span>', 'twentyten' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
			</div><!-- .comment-author .vcard -->
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'twentyten' ); ?></em>
				<br />
			<?php endif; ?>

			<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
				<?php
					/* translators: 1: date, 2: time */
					printf( __( '%1$s at %2$s', 'twentyten' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'twentyten' ), ' ' );
				?>
			</div><!-- .comment-meta .commentmetadata -->

			<div class="comment-body"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'twentyten' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'twentyten' ), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * To override twentyten_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 *
 * @since Twenty Ten 1.0
 * @uses register_sidebar
 */
function twentyten_widgets_init() {
	// Area 1, 
	register_sidebar( array(
		'name' => __( 'Header Search Widget Area', 'twentyten' ),
		'id' => 'header-search',
		'description' => __( 'Search Widget Area for Header', 'twentyten' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	) );

	// Area 2,
	register_sidebar( array(
		'name' => __( 'Home Legacy Tour Widget Area', 'twentyten' ),
		'id' => 'legacy-tour',
		'description' => __( 'Legacy Tour Widget Area for Home Page', 'twentyten' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	) );
	
	// Area 3, 
	register_sidebar( array(
		'name' => __( 'Home SPH sponsors Widget Area', 'twentyten' ),
		'id' => 'sph-sponsors',
		'description' => __( 'SPH sponsors Widget Area for Home Page', 'twentyten' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	) );
 
    // Area 4, 
	register_sidebar( array(
		'name' => __( 'Footer Copyright Widget Area', 'twentyten' ),
		'id' => 'copyright',
		'description' => __( 'Copyright Widget Area for footer', 'twentyten' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	) );
	
	// Area 5, 
	register_sidebar( array(
		'name' => __( 'Footer Webdesign Widget Area', 'soundhouse' ),
		'id' => 'webdesign',
		'description' => __( 'Webdesign Widget Area for footer', 'twentyten' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	) );    
	// Area 6, 
	register_sidebar( array(
		'name' => __( 'Most Popular posts', 'soundhouse' ),
		'id' => 'mostpop',
		'description' => __( 'Most Popular posts widget area', 'twentyten' ),
		'before_widget' => '<div class="mostpopular">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	) );
   	// Area 7, 
	register_sidebar( array(
		'name' => __( 'RECENT TWEETS', 'soundhouse' ),
		'id' => 'tweets',
		'description' => __( 'Recent tweets posts widget area', 'twentyten' ),
		'before_widget' => '<div class="recenttweets">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	) );   
	// Area 8, 
	register_sidebar( array(
		'name' => __( 'SPONSORS', 'soundhouse' ),
		'id' => 'sponsors',
		'description' => __( 'Sponsors widget area', 'twentyten' ),
		'before_widget' => '<div class="sponsors">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	) );    
}
/** Register sidebars by running twentyten_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'twentyten_widgets_init' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 *
 * To override this in a child theme, remove the filter and optionally add your own
 * function tied to the widgets_init action hook.
 *
 * This function uses a filter (show_recent_comments_widget_style) new in WordPress 3.1
 * to remove the default style. Using Twenty Ten 1.2 in WordPress 3.0 will show the styles,
 * but they won't have any effect on the widget in default Twenty Ten styling.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_remove_recent_comments_style() {
	add_filter( 'show_recent_comments_widget_style', '__return_false' );
}
add_action( 'widgets_init', 'twentyten_remove_recent_comments_style' );

if ( ! function_exists( 'twentyten_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_posted_on() {
	printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'twentyten' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'twentyten' ), get_the_author() ) ),
			get_the_author()
		)
	);
}
endif;

if ( ! function_exists( 'twentyten_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 * @since Twenty Ten 1.0
 */
function twentyten_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	} else {
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;

/**
 * Retrieves the IDs for images in a gallery.
 *
 * @uses get_post_galleries() first, if available. Falls back to shortcode parsing,
 * then as last option uses a get_posts() call.
 *
 * @since Twenty Ten 1.6.
 *
 * @return array List of image IDs from the post gallery.
 */
function twentyten_get_gallery_images() {
	$images = array();

	if ( function_exists( 'get_post_galleries' ) ) {
		$galleries = get_post_galleries( get_the_ID(), false );
		if ( isset( $galleries[0]['ids'] ) )
		 	$images = explode( ',', $galleries[0]['ids'] );
	} else {
		$pattern = get_shortcode_regex();
		preg_match( "/$pattern/s", get_the_content(), $match );
		$atts = shortcode_parse_atts( $match[3] );
		if ( isset( $atts['ids'] ) )
			$images = explode( ',', $atts['ids'] );
	}

	if ( ! $images ) {
		$images = get_posts( array(
			'fields'         => 'ids',
			'numberposts'    => 999,
			'order'          => 'ASC',
			'orderby'        => 'menu_order',
			'post_mime_type' => 'image',
			'post_parent'    => get_the_ID(),
			'post_type'      => 'attachment',
		) );
	}

	return $images;
}

//returns an assoc array with bitRate (kbps) and sampleRate (hz)
function getMP3BitRateSampleRate($filename)
{
if (!file_exists($filename)) {
return false;
}
 
$bitRates = array(
array(0,0,0,0,0),
array(32,32,32,32,8),
array(64,48,40,48,16),
array(96,56,48,56,24),
array(128,64,56,64,32),
array(160,80,64,80,40),
array(192,96,80,96,48),
array(224,112,96,112,56),
array(256,128,112,128,64),
array(288,160,128,144,80),
array(320,192,160,160,96),
array(352,224,192,176,112),
array(384,256,224,192,128),
array(416,320,256,224,144),
array(448,384,320,256,160),
array(-1,-1,-1,-1,-1),
);
$sampleRates = array(
array(11025,12000,8000), //mpeg 2.5
array(0,0,0),
array(22050,24000,16000), //mpeg 2
array(44100,48000,32000), //mpeg 1
);
$bToRead = 1024 * 12;
 
$fileData = array('bitRate' => 0, 'sampleRate' => 0);
$fp = fopen($filename, 'r');
if (!$fp) {
return false;
}
//seek to 8kb before the end of the file
fseek($fp, -1 * $bToRead, SEEK_END);
$data = fread($fp, $bToRead);
 
$bytes = unpack('C*', $data);
$frames = array();
$lastFrameVerify = null;
 
for ($o = 1; $o < count($bytes) - 4; $o++) {
 
//http://mpgedit.org/mpgedit/mpeg_format/MP3Format.html
//header is AAAAAAAA AAABBCCD EEEEFFGH IIJJKLMM
if (($bytes[$o] & 255) == 255 && ($bytes[$o+1] & 224) == 224) {
$frame = array();
$frame['version'] = ($bytes[$o+1] & 24) >> 3; //get BB (0 -> 3)
$frame['layer'] = abs((($bytes[$o+1] & 6) >> 1) - 4); //get CC (1 -> 3), then invert
$srIndex = ($bytes[$o+2] & 12) >> 2; //get FF (0 -> 3)
$brRow = ($bytes[$o+2] & 240) >> 4; //get EEEE (0 -> 15)
$frame['padding'] = ($bytes[$o+2] & 2) >> 1; //get G
if ($frame['version'] != 1 && $frame['layer'] > 0 && $srIndex < 3 && $brRow != 15 && $brRow != 0 &&
(!$lastFrameVerify || $lastFrameVerify === $bytes[$o+1])) {
//valid frame header
 
//calculate how much to skip to get to the next header
$frame['sampleRate'] = $sampleRates[$frame['version']][$srIndex];
if ($frame['version'] & 1 == 1) {
$frame['bitRate'] = $bitRates[$brRow][$frame['layer']-1]; //v1 and l1,l2,l3
} else {
$frame['bitRate'] = $bitRates[$brRow][($frame['layer'] & 2 >> 1)+3]; //v2 and l1 or l2/l3 (3 is the offset in the arrays)
}
 
if ($frame['layer'] == 1) {
$frame['frameLength'] = (12 * $frame['bitRate'] * 1000 / $frame['sampleRate'] + $frame['padding']) * 4;
} else {
$frame['frameLength'] = 144 * $frame['bitRate'] * 1000 / $frame['sampleRate'] + $frame['padding'];
}
 
$frames[] = $frame;
$lastFrameVerify = $bytes[$o+1];
$o += floor($frame['frameLength'] - 1);
} else {
$frames = array();
$lastFrameVerify = null;
}
}
if (count($frames) < 3) { //verify at least 3 frames to make sure its an mp3
continue;
}
 
$header = array_pop($frames);
$fileData['sampleRate'] = $header['sampleRate'];
$fileData['bitRate'] = $header['bitRate'];
 
break;
}
 
return $fileData;
}

//Hide Admin bar in the Front Area

show_admin_bar( false );



/* Removed the default content filter easy image gallery */

remove_filter( 'the_content', 'easy_image_gallery_append_to_content' ); 

/* Removed the default content filter easy image gallery end */


if ( ! function_exists( 'soundhouse_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentyten_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Ten 1.0
 */
function soundhouse_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<div class="coment" <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="col-lg-1 col-md-1 col-sm-2 col-xs-2">
			<?php echo get_avatar( $comment, 40 ); ?>
		</div> 
		<div id="comment-<?php comment_ID(); ?>" class="col-lg-11 col-md-11 col-sm-10 col-xs-10">
				<h2>
					<?php 
						printf( __( '%s <span class="says"></span>', 'twentyten' ), sprintf( '%s', get_comment_author_link() ) ); 
						echo '-';
						printf( __( '<span>%1$s at %2$s</span>', 'twentyten' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'twentyten' ), ' ' );
					?>
				</h2>
			<p class="comment-body"><?php comment_text(); ?></p>
		</div><!-- #comment-##  -->
	</div>
	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'twentyten' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'twentyten' ), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

/*
 * Function to css in wordpress 
 */ 
function load_custom_wp_admin_style() {
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-core'); 
	wp_enqueue_script('jquery-ui-datepicker');
	
	wp_enqueue_script( 'bootstrapjs', get_stylesheet_directory_uri() . '/js/bootstrap.js', array(), '1.0.0', true );
	wp_enqueue_script( 'scrollscript', get_stylesheet_directory_uri() . '/js/scroll.js', array(), '1.0.0', true );
	wp_enqueue_script( 'bootstrap-select', get_stylesheet_directory_uri() . '/js/bootstrap-select.min.js', array(), '1.0.0', true );
	wp_enqueue_script( 'jquerytimepickjs', get_stylesheet_directory_uri() . '/js/jquery.ui.timepicker.js', array(), '1.0.0', true );
	
	wp_enqueue_script( 'googlemapsapiplcase', 'http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places' );
	//wp_enqueue_script( 'googlemapsapi', 'http://maps.google.com/maps/api/js?sensor=false' );
	wp_enqueue_script( 'jquery.geocomplete', get_stylesheet_directory_uri() .'/js/jquery.geocomplete.js' );
	//wp_enqueue_script( 'jqueryvalidation', get_stylesheet_directory_uri() .'/js/jquery.validate.min.js' );
	//wp_enqueue_script( 'jqueryvalidationaddi', get_stylesheet_directory_uri() .'/js/additional-methods.js' );
	//wp_enqueue_script( 'jlogger', get_stylesheet_directory_uri() .'/js/logger.js' );
	
	wp_enqueue_script( 'soundhousejplayer', get_stylesheet_directory_uri() .'/js/jquery.jplayer.min.js' );
	wp_enqueue_script( 'soundhousejplayerplaylist', get_stylesheet_directory_uri() .'/js/jplayer.playlist.js' );
	
	wp_register_script( 'soundhouse_script', get_stylesheet_directory_uri() . '/js/soundhousejquery.js', array(), '1.0.0', true );
	wp_localize_script( 'soundhouse_script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'site_url' => site_url() , 'artist_admin_url' => site_url().'/artist-admin/'));        
	wp_enqueue_script( 'soundhouse_script');
	 
	wp_enqueue_style('jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
	wp_register_style( 'bootstrapmin', get_template_directory_uri() . '/css/bootstrap.min.css');
	
	wp_enqueue_style( 'bootstrapmin' );    
	wp_register_style( 'custom_style_css', get_template_directory_uri() . '/css/custom-style.css');
	wp_enqueue_style( 'custom_style_css' );   
	wp_register_style( 'style_csss', get_template_directory_uri() . '/css/style.css');
	wp_enqueue_style( 'style_csss' );   
	wp_register_style( 'icons_style_css', get_template_directory_uri() . '/icons/style.css');
	wp_enqueue_style( 'icons_style_css' );   
	wp_register_style( 'bootstrap-selectcss', get_template_directory_uri() . '/css/bootstrap-select.min.css');
	wp_enqueue_style( 'bootstrap-selectcss' );   
	wp_register_style( 'jquerytimepickcss', get_template_directory_uri() . '/css/jquery.ui.timepicker.css');
	wp_enqueue_style( 'jquerytimepickcss' );   
	wp_register_style( 'jplacuercss', get_template_directory_uri() . '/skin/blue.monday/jplayer.blue.monday.css');
	wp_enqueue_style( 'jplacuercss' );   
	wp_enqueue_style( 'soundhouseresponsive', get_template_directory_uri() . '/css/responsive.css');
	
	
	
	
	wp_enqueue_script('plupload-handlers');
	wp_enqueue_script( 'aaiu_upload', get_template_directory_uri() . '/js/aaiu_upload.js' );
	
	$max_file_size = 1000 * 1000 * 1000;
	$max_upload_no = 1000;
	$allow_ext = 'mp4,mp3';

	wp_localize_script('aaiu_upload', 'aaiu_upload', array(
		'ajaxurl' => admin_url('admin-ajax.php'),
		'nonce' => wp_create_nonce('aaiu_upload'),
		'remove' => wp_create_nonce('aaiu_remove'),
		'number' => $max_upload_no,
		'upload_enabled' => true,
		'confirmMsg' => __('Are you sure you want to delete this?'),
		'plupload' => array(
			'runtimes' => 'html5,flash,html4',
			'browse_button' => 'aaiu-uploader',
			'container' => 'aaiu-upload-container',
			'file_data_name' => 'aaiu_upload_file',
			'max_file_size' => $max_file_size . 'b',
			'url' => admin_url('admin-ajax.php') . '?action=aaiu_upload&nonce=' . wp_create_nonce('aaiu_allow'),
			'flash_swf_url' => includes_url('js/plupload/plupload.flash.swf'),
			'filters' => array(array('title' => __('Allowed Files'), 'extensions' => $allow_ext)),
			'multipart' => true,
			'urlstream_upload' => true,
		)
	));
	
	
}
add_action( 'wp_enqueue_scripts', 'load_custom_wp_admin_style' );

function soundhouse_wp_admin_style() {
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-core'); 
	wp_enqueue_script('jquery-ui-datepicker');
	wp_register_script( 'soundhouse_admin_script', get_stylesheet_directory_uri() . '/js/soudhouseadmin.js', array(), '1.0.0', true );
	wp_localize_script( 'soundhouse_admin_script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'site_url' => site_url()));        
	wp_enqueue_script( 'soundhouse_admin_script');
	wp_enqueue_style('jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
}
add_action( 'admin_enqueue_scripts', 'soundhouse_wp_admin_style' );

/*
 * Ajax login method
 */ 
function sandhouse_login()
{
		$return;
		$email_id = trim($_REQUEST["email_id"]);
		$password = trim($_REQUEST["password"]);
		$user = get_user_by( 'email', $email_id );
		$user_id = $user->ID;
		$hashpass = $user->user_pass;
		if($user_id != "0") {
				$chkpass = wp_check_password($password, $hashpass, $user_id);
				if($chkpass) {
					wp_set_current_user($user_id, $user->user_login);
					wp_set_auth_cookie($user_id, false, is_ssl());
					$soun_artst = get_user_meta($user_id,"soundhouse_artist",true);   
					if (current_user_is("s2member_level1") || current_user_is("s2member_level2")) :
						$return = "2";
					else :
						$return = "1";
					endif;
				}
				else
				{
					$return = "0";
				}
		}
		else
		{
			echo 'user id error';
			$return = "0";
		}
		echo $return;
		exit();
}
add_action('wp_ajax_sandhouse_login', 'sandhouse_login');
add_action('wp_ajax_nopriv_sandhouse_login', 'sandhouse_login');



/*
 * Ajax login method
 */ 
function add_ban_member()
{
		$user_id = get_current_user_id();
		$return = '';
		extract($_POST);
		
		//echo $return;
		$mainArr =array();
		//echo $total_count;
		///echo 'is artist admin name '.$artistname_admin;
		//echo '<br>eamin email '.$artistemail_admin;
		$admintemp = array();
		$admintemp['artistname'] = $artistname_admin;
		$admintemp['artistemail'] = $artistemail_admin;
		$admintemp['artistgenre'] = $artistgenre_admin;
		$return .= '<ul class = "band_members_list" >';
		$return .= '<li>';
		$return .= $artistname_admin. ' - ' .$artistgenre_admin;
		$return .= '</li>';
		update_user_meta ( $user_id, 'admin_band_member', $admintemp );
		for($i=1;$i<=$total_count;$i++)
		{
			$temp = array();
			$artistname = 'artistname_'.$i;
			$artistemail = 'artistemail_'.$i;
			$artistgenre = 'artistgenre_'.$i;
			
			$temp['artistname'] = $_POST[$artistname];
			$temp['artistemail'] = $_POST[$artistemail];
			$temp['artistgenre'] = $_POST[$artistgenre];
			if ( ! empty ($temp['artistname']) ) {
				$return .= '<li>';
				$return .= $_POST[$artistname].' - '.$_POST[$artistgenre];
				$return .= '</li>';
				$mainArr[] = $temp;
			}
		}
		$return .= '</ul>';
		update_user_meta ( $user_id, 'band_members', $mainArr );
		echo $return;
		exit();
}
add_action('wp_ajax_add_ban_member', 'add_ban_member');
add_action('wp_ajax_nopriv_add_ban_member', 'add_ban_member');

/*
 * Email Verfication 
 */
 function soundhouse_band_contact_email()
 {
	 
		
		$user_id=$_POST["user_id"];
		$acname=$_POST["acname"];
		$acemail=$_POST["acemail"];
		$acmessage=$_POST["acmessage"];
		$headers ="from:".$acemail;
		$user_info = get_userdata($user_id);
		$uemail = $user_info->user_email;
		//mail($uemail, $acname, $acmessage, $headers);
		
		
		        $to = $uemail; 
				$subject = "Contact Artist";
				$msg  = "<html><head><title>Sound House</title></head><body>";
				$msg .= "Message came from Sound House contact band:<br/><br/>";
				$msg .= "Name : ".$acname.'<br/>';
				$msg .= "Email : ".$acemail.'<br/>';
				$msg .= "Message : ".$acmessage.'<br/>';
				
				$msg .= "</body></html>";
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "From: Sound House <".$acemail.">" . "\r\n";
				$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
				
			 wp_mail($to,$subject,$msg,$headers);
		
		
		
		
 }
add_action('wp_ajax_soundhouse_band_contact_email', 'soundhouse_band_contact_email');
add_action('wp_ajax_nopriv_soundhouse_band_contact_email', 'soundhouse_band_contact_email');
 
 
function update_biography() {
	$user_id = get_current_user_id();
	$user_biography = $_POST['user_bio'];
	$user_city = get_user_field ("user_city");
	$user_state = get_user_field ("user_state");
	$user_zip = get_user_field ("user_zip");
	$facebook_url = get_user_field ("facebook_url");
	$twitter_url = get_user_field ("twitter_url");
	$artist_url = get_user_field ("artist_url");
	$itunes_url = get_user_field ("itunes_url");
	$wp_s2member = array(
		'user_city' => $user_city,
		'user_state' => $user_state,
		'user_zip' => $user_zip,
		'facebook_url' => $facebook_url,
		'twitter_url' => $twitter_url,
		'artist_url' => $artist_url,
		'itunes_url' => $itunes_url,
		'user_biography' => $user_biography
	);
	update_user_meta ( $user_id, 'wp_s2member_custom_fields', $wp_s2member );
	exit();
}

add_action('wp_ajax_update_biography', 'update_biography');
add_action('wp_ajax_nopriv_update_biography', 'update_biography');

/*
 * Add press items
 */
function add_press_items() {
	$user_id = get_current_user_id();
	$return = '';
	extract($_POST);
	$pressarray = array();
	for($i=1;$i<=$total_count;$i++)
	{
		$temp = array();
		$date_of_release = 'date_of_release_'.$i;
		$publication_name = 'publication_name_'.$i;
		$title_of_article = 'title_of_article_'.$i;
		$link_to_article = 'link_to_article_'.$i;
		$temp['date_of_release'] = $_POST[$date_of_release];
		$temp['publication_name'] = $_POST[$publication_name];
		$temp['title_of_article'] = $_POST[$title_of_article];
		$temp['link_to_article'] = $_POST[$link_to_article];
		if ( 'undefined' != $temp['publication_name'] ) {
			$pressarray[] = $temp;
		}
	}
	echo 'you have added '.$total_count.' Press items.';
	//echo '<pre>';print_r($pressarray); echo '</pre>';
	update_user_meta ( $user_id, 'press_items', $pressarray );
	exit();
}

add_action('wp_ajax_add_press_items', 'add_press_items');
add_action('wp_ajax_nopriv_add_press_items', 'add_press_items');


/*
 * Function to add events & gigs for aritsts
 * 
 */ 
function add_artist_show () {
	$user_id = get_current_user_id();
	$user_info = get_userdata($user_id); 
	$user_firstname = $user_info->first_name;
	$user_last_name = $user_info->last_name;
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
	$recurring = $_POST['recurring'];
	if ( $recurring == '1') {
		$recuring_type = $_POST['recuring_type'];
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
			//$venue_dateofevent1 = $venue_dateofevent_full;
			
			$inc++;
			$my_post_data = array(
				'post_title'    => 'SoundHouse Promotions Presents'.' - '.$user_firstname.' '.$user_last_name ,
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
		}
	} else {
		$my_post_data = array(
		'post_title'    => 'SoundHouse Promotions Presents'.' - '.$user_firstname.' '.$user_last_name ,
		'post_status'   => 'publish',
		'post_author'   => $user_id,
		'post_type'   => 'artist-events'
		);
		// Insert the post into the database
		$event_post_id = wp_insert_post( $my_post_data );
		$venue_dateofevent = strtotime( date("Y-m-d", strtotime($venue_dateofevent1)) );
		$venue_dateofevent_full= date('Y-m-d',$venue_dateofevent);
		update_post_meta ( $event_post_id, 'venue_name', $venue_name );
		update_post_meta ( $event_post_id, 'venue_address', $venue_address );
		update_post_meta ( $event_post_id, 'venue_city', $venue_city );
		update_post_meta ( $event_post_id, 'venue_state', $venue_state );
		update_post_meta ( $event_post_id, 'venue_zip', $venue_zip );
		update_post_meta ( $event_post_id, 'venue_dateofevent', $venue_dateofevent_full );
		update_post_meta ( $event_post_id, 'venue_cost', $venue_cost );
		update_post_meta ( $event_post_id, 'venue_url', $venue_url );
		update_post_meta ( $event_post_id, 'venue_timeofevent', $venue_timeofevent );
	}
	$countevents = 0;
	$args = array(
		'post_type'=> 'artist-events',
		'author' => $user_id
	);
	$respone= '';
	query_posts( $args );
	while ( have_posts() ) : the_post();
	$post_id = get_the_ID();
		$respone .= '<p>'.get_the_title(). ' - '. get_post_meta( $post_id ,'venue_dateofevent' , true ). ' - '.'<a id= "editshow-'.get_the_id().'" class= "editshow" href="javascript:;" >Edit</a></p>';
	endwhile;
	
	echo $respone;
	
	exit();
}

add_action('wp_ajax_add_artist_show', 'add_artist_show');
add_action('wp_ajax_nopriv_add_artist_show', 'add_artist_show');


/*
 * Get details of an event to edit and update
 */ 
function edit_artist_show_detail () {
		global $wpdb;
		$location_table = $wpdb->prefix.'event_location';
		
		$post_id = $_POST['post_id'];
		$qry = "select * from $location_table where event_id = '$post_id'";
		$res = $wpdb->get_row( $qry );
		
		$venue_name = get_post_meta( $post_id ,'venue_name' , true );
		$venue_address = get_post_meta( $post_id ,'venue_address' , true );
		$venue_city = get_post_meta( $post_id ,'venue_city' , true );
		$venue_state = get_post_meta( $post_id ,'venue_state' , true );
		$venue_zip = get_post_meta( $post_id ,'venue_zip' , true );
		$venue_dateofevent = get_post_meta( $post_id ,'venue_dateofevent' , true );
		$venue_cost = get_post_meta( $post_id ,'venue_cost' , true );
		$venue_url = get_post_meta( $post_id ,'venue_url' , true );
		$venue_timeofevent = get_post_meta( $post_id ,'venue_timeofevent' , true );
		$response .= '<div class= "venue_details">';
		$response .= '<div class="form-group  col-lg-4 col-md-4 col-sm-4">';
		$response .= '<input value = "'.$venue_name.'" id= "venue_name_edit" name= "venue_name_edit" type = "text" class="geoloc-edit form-control"  placeholder = "Venue name">';
		$response .= '<div class = "error" id= "venue_name_error_edit" ></div>';
		$response .= '</div>';
		$response .= '<div class="form-group  col-lg-4 col-md-4 col-sm-4">';
		$response .= '<input value = "'.$venue_address.'" id= "venue_address_edit" name= "venue_address_edit" type = "text" class="geoloc-edit form-control"  placeholder = "Address">';
		$response .= '<div class = "error" id= "venue_address_error_edit" ></div>';
		$response .= '</div>';
		$response .= '<div class="form-group  col-lg-4 col-md-4 col-sm-4">';
		$response .= '<input value = "'.$venue_city.'" id= "venue_city_edit" name= "venue_city_edit" type = "text" class="geoloc-edit form-control"  placeholder = "City">';
		$response .= '<div class = "error" id= "venue_city_error_edit" ></div>';
		$response .= '</div>';
		$response .= '</div>';
		$response .= '<div class= "venue_details">';
		$response .= '<div class="form-group  col-lg-4 col-md-4 col-sm-4">';
		$response .= '<input value = "'.$venue_state.'" id= "venue_state_edit" name= "venue_state_edit" type = "text" class = "geoloc-edit form-control"  placeholder = "State">';
		$response .= '<div class = "error" id= "venue_state_error_edit" ></div>';
		$response .= '</div>';
		$response .= '<div class="form-group  col-lg-4 col-md-4 col-sm-4">';
		$response .= '<input value = "'.$venue_zip.'" id= "venue_zip_edit" name= "venue_zip_edit" type = "text" class = "form-control"  placeholder = "Zip Code">';
		$response .= '<div class = "error" id= "venue_zip_error_edit" ></div>';
		$response .= '</div>';
		$response .= '<div class="form-group  col-lg-4 col-md-4 col-sm-4">';
		$response .= '<input value = "'.$venue_dateofevent.'" name= "venue_dateofevent_edit" id="startdate_edit" type = "text" class = "form-control"  placeholder = "Date of event">';
		$response .= '<div class = "error" id= "venue_dateofevent_error_edit" ></div>';
		$response .= '</div>';
		$response .= '</div>';
		$response .= '<div class= "venue_details">';
		$response .= '<div class="form-group  col-lg-4 col-md-4 col-sm-4">';
		$response .= '<input value = "'.$venue_timeofevent.'" name= "venue_timeofevent_edit" id="timeofevent_edit" type = "text" class = "form-control"  placeholder = "Time of event">';
		$response .= '<div class = "error" id= "venue_timeofevent_error_edit" ></div>';
		$response .= '</div>';
		$response .= '<div class="form-group  col-lg-4 col-md-4 col-sm-4">';
		$response .= '<input value = "'.$venue_cost.'" id= "venue_cost_edit" name= "venue_cost_edit" type = "text" class="form-control"  placeholder = "Cost of event">';
		$response .= '<div class = "error" id= "venue_cost_error_edit" ></div>';
		$response .= '</div>';
		$response .= '<div class="form-group  col-lg-4 col-md-4 col-sm-4">';
		$response .= '<input value = "'.$venue_url.'" id= "venue_url_edit" name = "venue_url_edit" type = "text" class = "form-control"  placeholder = "Venue Url">';
		$response .= '<div class = "error" id= "venue_url_error_edit" ></div>';
		$response .= '</div>';
		$response .= '</div>';
		$response .= '<div class= "venue_details">';
		$response .= '<div class="form-group  col-lg-4 col-md-4 col-sm-4">';
		$response .= '<div id= "edit_venue_image_1">';
		$venueimage1 = get_post_meta($post_id,"venueimage1",true);
		$img1 = wp_get_attachment_image_src($venueimage1, 'thumbnail');
		$response .= '<img src="'.$img1['0'].'" alt="photo" class="img-responsive"/>';
		$response .= '</div>';
		$response .= '<input type= "file" onchange = "edit_venue_image1(this);" name= "venueimage1_edit" />';
		$response .= '</div>';
		$response .= '<div class="form-group  col-lg-4 col-md-4 col-sm-4">';
		$response .= '<div id= "edit_venue_image_2">';
		$venueimage2 = get_post_meta($post_id,"venueimage2",true);
		$img2 = wp_get_attachment_image_src($venueimage2, 'thumbnail');
		$response .= '<img src="'.$img2['0'].'" alt="photo" class="img-responsive"/>';
		$response .= '</div>';
		$response .= '<input type= "file" onchange = "edit_venue_image2(this);" name= "venueimage2_edit" />';
		$response .= '</div>';
		$response .= '<div class="form-group  col-lg-4 col-md-4 col-sm-4">';
		$response .= '<div id= "edit_venue_image_3">';
		$venueimage3 = get_post_meta($post_id,"venueimage3",true);
		$img3 = wp_get_attachment_image_src($venueimage3, 'thumbnail');
		$response .= '<img src="'.$img3['0'].'" alt="photo" class="img-responsive"/>';
		$response .= '</div>';
		$response .= '<input type= "file" onchange = "edit_venue_image3(this);" name= "venueimage3_edit" />';
		$response .= '</div>';
		$response .= '</div>';
		$response .= '<input type= "hidden" id= "show_to_edit" name= "show_to_edit" value = "'.$post_id.'" />';
		$response .= '<input type= "hidden" id= "venue_latitude_edit" name= "venue_latitude_edit" value = "'.$res->latitude.'" />';
		$response .= '<input type= "hidden" id= "venue_longitude_edit" name= "venue_longitude_edit" value = "'.$res->longitude.'" />';
		echo $response;
		exit();
}
add_action('wp_ajax_edit_artist_show_detail', 'edit_artist_show_detail');
add_action('wp_ajax_nopriv_edit_artist_show_detail', 'edit_artist_show_detail');


/*
 * Function to update events for an artist
 */ 
function edit_artist_show_update() {
	$event_post_id = $_POST['show_to_edit'];
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
	$venue_dateofevent = strtotime( date("Y-m-d", strtotime($venue_dateofevent1)) );
	$venue_dateofevent_full= date('Y-m-d',$venue_dateofevent);
	
	update_post_meta ( $event_post_id, 'venue_name', $venue_name );
	update_post_meta ( $event_post_id, 'venue_address', $venue_address );
	update_post_meta ( $event_post_id, 'venue_city', $venue_city );
	update_post_meta ( $event_post_id, 'venue_state', $venue_state );
	update_post_meta ( $event_post_id, 'venue_zip', $venue_zip );
	update_post_meta ( $event_post_id, 'venue_dateofevent', $venue_dateofevent_full );
	update_post_meta ( $event_post_id, 'venue_cost', $venue_cost );
	update_post_meta ( $event_post_id, 'venue_url', $venue_url );
	update_post_meta ( $event_post_id, 'venue_timeofevent', $venue_timeofevent );
	
	$countevents = 0;
	$args = array(
		'post_type'=> 'artist-events',
		'author' => $user_id
	);
	$respone= '';
	query_posts( $args );
	while ( have_posts() ) : the_post();
	$post_id = get_the_ID();
		$respone .= '<p>'.get_the_title(). ' - '. get_post_meta( $post_id ,'venue_dateofevent' , true ). ' - '.'<a id= "editshow-'.get_the_id().'" class= "editshow" href="javascript:;" >Edit</a></p>';
	endwhile;
	echo $respone;
	exit();
}
add_action('wp_ajax_edit_artist_show_update', 'edit_artist_show_update');
add_action('wp_ajax_nopriv_edit_artist_show_update', 'edit_artist_show_update');




/**
 * Change gravity forms error message
 */ 
add_filter("gform_validation_message", "change_message", 10, 2);
function change_message($message, $form){
	return "Please complete form";
}

/**
 * 
 */ 
function search_events_gigs() {
	
	global $wpdb;
	$event_cat = $_POST['event_cat'];
	$searchlat = $_POST['searchlat'];
	$searchlong = $_POST['searchlong'];
	$posts_table= $wpdb->prefix.'posts';
	$postmeta_table= $wpdb->prefix.'postmeta';
	$location_table = $wpdb->prefix.'event_location';
	
	
	$args = array(
	'post_type'=> 'artist',
	'tax_query' => array(
		array(
			'taxonomy' => 'artist_list',
			'field' => 'term_id',
			'terms' => $event_cat
			)
		)
	);
	query_posts( $args );
	$response = '';
	while ( have_posts() ) : the_post();
		if ( ! isset ( $author_list ) ) {
			$author_list = get_the_author_ID();
		} else {
			$author_list .= ' , '.get_the_author_ID();
		}
	endwhile;
	
	//echo $author_list.' is the post';
	
	if ( $event_cat == '-1' ) {
		$artistargs = array(
			'post_type'=> 'artist-events',
		);
	} else {
		$artistargs = array(
			'post_type'=> 'artist-events',
			'author__in' => array( $author_list )
		);
	}
	if ( $event_cat == '-1' )  {
		$query = "select pos.*, ROUND((((acos(sin(($searchlat *pi()/180)) * 
				sin((loc.latitude *pi()/180))+cos(($searchlat*pi()/180)) * 
				cos(( loc.latitude *pi()/180)) * cos((($searchlong - loc.longitude)* 
				pi()/180))))*180/pi())*60*1.1515),2) as distance
				from $posts_table as pos 
				INNER JOIN $location_table as loc ON loc.event_id = pos.ID
				JOIN $postmeta_table d ON (loc.event_id = d.post_id and d.meta_key = 'venue_dateofevent' and d.meta_value >= CURDATE())
				GROUP BY pos.ID HAVING distance BETWEEN -1 AND 100 OR distance IS NULL 
				order by d.meta_value 
				";
	} else {
		$query = "select pos.*, ROUND((((acos(sin(($searchlat *pi()/180)) * 
				sin((loc.latitude *pi()/180))+cos(($searchlat*pi()/180)) * 
				cos(( loc.latitude *pi()/180)) * cos((($searchlong - loc.longitude)* 
				pi()/180))))*180/pi())*60*1.1515),2) as distance
				from $posts_table as pos 
				INNER JOIN $location_table as loc ON loc.event_id = pos.ID
				JOIN $postmeta_table d ON (loc.event_id = d.post_id and d.meta_key = 'venue_dateofevent' and d.meta_value >= CURDATE())
				WHERE pos.post_author IN ( $author_list )
				GROUP BY pos.ID HAVING distance BETWEEN -1 AND 100 OR distance IS NULL 
				order by d.meta_value 
				";
	}
	$res = $wpdb->get_results($query);		
	//query_posts( $artistargs );
	$countevents= 0;
	$response .= '<div class="over-lay" style="display:none"></div>';
	foreach ( $res as $r ) :
	$countevents++;
		$author_id = $r->post_author; 
		$post_id = $r->ID;
		$venue_name = get_post_meta ( $post_id, 'venue_name', true );
		$venue_address = get_post_meta ( $post_id, 'venue_address', true );
		$venue_city = get_post_meta ( $post_id, 'venue_city', true );
		$venue_state = get_post_meta ( $post_id, 'venue_state', true );
		$venue_zip = get_post_meta ( $post_id, 'venue_zip', true );
		$venue_dateofevent = get_post_meta ( $post_id, 'venue_dateofevent', true );
		$venue_dateofevent =  date("d M Y", strtotime ( $venue_dateofevent));
		$venue_cost = get_post_meta ( $post_id, 'venue_cost', true );
		$venue_url = get_post_meta ( $post_id, 'venue_url', true );
		$venue_timeofevent = get_post_meta( $post_id, 'venue_timeofevent', true );
		$userpofile = get_user_meta ( $author_id,"user_profile_image",true);
		$img1 = wp_get_attachment_image_src($userpofile, 'admin-directory-pic');
		$venueimage1 = get_post_meta( $post_id, 'venueimage1', true );
		$venueimage2 = get_post_meta( $post_id, 'venueimage2', true );
		$venueimage3 = get_post_meta( $post_id, 'venueimage3', true );
		$response .= '<div class="panel panel-default">';
		$response .= '<div class="table">';
			$response .= '<img src="'.$img1['0'].'" alt=""/> ';
			$response .= $r->post_title.' - <i> '.$venue_name.'</i> - '.$venue_city.', '.$venue_zip.' | '.$venue_dateofevent.' @'.$venue_timeofevent;
			$response .= '<div class="view">';
			$response .= '<a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$countevents.'" class="pop">View</a>';
			$response .= '</div>';
		$response .= '</div>';
		$response .= '<div id="collapse'.$countevents.'" class="panel-collapse collapse">';
		$response .= '<div class="" id="eventmodel" style ="display:block">
								  <div class="">
									<div class="modal-content">
									<div class="modal-header">
									  </div>
									  <div class="modal-body">
										<div class="gigeventinfo">
										  <h3>Event details</h3>
										  <ul>
											<li>
											  <h2>'.$r->post_title.'</h2>
											</li>
											<li>
											  <p><strong>'.$venue_name.' - '.$venue_city.', '.$venue_state.'   |</strong> '.$venue_dateofevent.' <strong>|</strong> '.$venue_timeofevent.'</p>
											</li>
											<li><strong>PERFORMING ACTS</strong><p>';
										$band_members = get_user_meta($author_id,"band_members",true);
										if (!empty ($band_members))  : 
											foreach ( $band_members as $key =>$band ) : 
		$response .=							$band['artistname'].'<br/>';
											endforeach;
										else :
		$response .=						'No performer';
										endif;
		$response .= 						'</p></li>
										</ul>
										<div class="row bottom-event-list">
										<div class="col-lg-3 col-md-3 col-sm-3">';
										if ( !empty ($venueimage1 ) ) :
											$img1 = wp_get_attachment_image_src($venueimage1, 'admin-artist-profile-pic');
		$response .=						'<img src="'.$img1['0'].'" alt="eveimg1" class="img-responsive"/>';
										endif;
		$response .=					'</div>';
		$response .=					'<div class="col-lg-3 col-md-3 col-sm-3">';
										if ( !empty ($venueimage2 ) ) :
											$img2 = wp_get_attachment_image_src($venueimage2, 'admin-artist-profile-pic');
		$response .=						'<img src="'.$img2['0'].'" alt="img2" class="img-responsive"/>';
										endif;
		$response .=					'</div>';
		$response .=					'<div class="col-lg-3 col-md-3 col-sm-3">';
										if ( !empty ($venueimage3 ) ) :
											$img3 = wp_get_attachment_image_src($venueimage3, 'admin-artist-profile-pic');
		$response .=						'<img src="'.$img3['0'].'" alt="eveimg1" class="img-responsive"/>';
										endif;
		$response .=					'</div>';
		$response .=					'<div class="col-lg-3 col-md-3  col-sm-3 text-center">
											<h2>$'.$venue_cost.'</h2>
											<p>'.$venue_name.' '.$venue_address.'<br/>
												'.$venue_city.', '.$venue_state.' '.$venue_zip.'</p>
												<address>
												'.$venue_name.' '.$venue_address.' '.$venue_city.' '.$venue_state.'
												</address>
										</div>
										</div>
										</div>
									  </div>
									</div>
								  </div>
								</div>';
		$response .= '</div>';
		$response .= '</div>';
	endforeach;
	if ( 0 == $countevents ) {
		$response .= '<div class="panel panel-default">';
		$response .= '<div class="table">';
		$response .= 'There are no events available for this genre';
		$response .= '</div>';
		$response .= '</div>';
	}
	echo $response;
	exit();
}
add_action('wp_ajax_search_events_gigs', 'search_events_gigs');
add_action('wp_ajax_nopriv_search_events_gigs', 'search_events_gigs');



function add_artist_album() {
	$response = '';
	global $wpdb;
	$user_id = get_current_user_id();
	$album_name = $_POST['album_name'];
	$taxonomy = 'artist-songs-list';
	$parent_term = term_exists( $album_name, $taxonomy );
	if ( empty ( $parent_term ) ) {
		$termres = wp_insert_term( $album_name, $taxonomy);
		$t_id = $termres['term_id'];
		update_option( "albumauthor_$t_id", 'album_user_'.$user_id );
		
		$wp_options = $wpdb->prefix."options";
		$search_user = 'album_user_'.$user_id;
		$search_tax_query = "select * from $wp_options where option_value= '$search_user' ";
		$search_tax_res = $wpdb->get_results($search_tax_query);
		$albums_arr = array();
		foreach ( $search_tax_res as $album_id_tax) {
			$album_id =  substr($album_id_tax->option_name,12);
			array_push($albums_arr , $album_id);
		}
			$response .= '<select class = "selectpicker" name= "artist_album" id= "artist_album_select" >';
			$response .= '<option value= "-1">Select Album</option>';
			$artsttaxonomy = 'artist-songs-list';
			$artist_tax_terms = get_terms($artsttaxonomy,array( 'orderby' => 'name', 'hide_empty' => false ));
			foreach ($artist_tax_terms as $artist_tax_term) 
			{
				if (in_array($artist_tax_term->term_id, $albums_arr)) {
					$response .= '<option value= "'.$artist_tax_term->term_id.'" >'.$artist_tax_term->name.'</option>';
				}
			}
			$response .= '</select>';
							
	} else {
		$response .= '-1';
	}
	echo $response;
	exit();
}
add_action ( 'wp_ajax_add_artist_album', 'add_artist_album' );
add_action ( 'wp_ajax_nopriv_add_artist_album', 'add_artist_album' );



/*
 * Display custom coulmn in songs taxonomy
 */ 
add_action('artist-songs-list_edit_form_fields','category_edit_form_fields');
add_action('artist-songs-list_edit_form', 'category_edit_form');
add_action('artist-songs-list_add_form_fields','category_edit_form_fields');
add_action('artist-songs-list_add_form','category_edit_form');


function category_edit_form() {
	if ( isset ( $_POST['albumauthor'] ) ) {
	}
}

function category_edit_form_fields ( $tag ) {
	$blogusers = get_users();
	$t_id = $tag->term_id; // Get the ID of the term you're editing  
	$ablum_author = get_option( "albumauthor_$t_id" ); // Do the check  
	
?>
	<tr class="form-field">
		<th valign="top" scope="row">
			Artist name
		</th>
		<td>
		<select name= "albumauthor" >
		<?php
			foreach ( $blogusers as $user ) {
				echo $user_id = $user->ID;
				$artist_post_id = get_user_meta($user_id,"artist_post_id",true);
				if ( !empty ( $artist_post_id ) ) {
					if ( $ablum_author == 'album_user_'.$user_id) {
						$selected  = ' selected ';
					} else {
						$selected = '';
					}
					echo '<option value= "'.$user_id.'" '.$selected.' >' . esc_html( $user->display_name ) . '</option>';
				}
			}
		?>
		</select>
		</td>
	</tr>
<?php 
}

// Save extra taxonomy fields callback function.
function save_taxonomy_custom_meta( $term_id ) {
	if ( isset( $_POST['albumauthor'] ) ) {
		$t_id = $term_id;
		$term_meta = get_option( "taxonomy_$t_id" );
		$cat_keys =  'album_user_'.$_POST['albumauthor'] ;
		update_option( "albumauthor_$t_id", $cat_keys );
		
	}
}  
add_action( 'edited_artist-songs-list', 'save_taxonomy_custom_meta', 10, 2 );  
add_action( 'create_artist-songs-list', 'save_taxonomy_custom_meta', 10, 2 );


require_once('events_dashboard.php');
require_once('custom_soundhouse_post_types.php');

/*
 * Add a column
 */ 
function add_artist_song_list_taxonomy_column( $columns ){
    $columns['artist_name'] = 'Artist'; 
    return $columns;
}
add_filter( "manage_edit-artist-songs-list_columns", 'add_artist_song_list_taxonomy_column', 10);


/*
 * Output in custom taxonomy coulmn for each taxonomy
 */ 
function custom_column_content(  $out, $column_name, $tax_id ){
     if ($column_name === 'artist_name') {
			$ablum_author = get_option( "albumauthor_$tax_id" );
			$ablum_author_id =  substr( $ablum_author, 11 );
			$user_info = get_userdata( $ablum_author_id );
			echo $user_info->display_name;
     }
}
add_action( "manage_artist-songs-list_custom_column", 'custom_column_content', 10, 3);



/*
 * Authorize .Net Payment function
 */ 
function cc_payment($post_values)
{
		// posting to: https://secure.authorize.net/gateway/transact.dll
		//$post_url = "https://secure.authorize.net/gateway/transact.dll";
		$post_url = "https://test.authorize.net/gateway/transact.dll";
		// This section takes the input fields and converts them to the proper format
		// for an http post.  For example: "x_login=username&x_tran_key=a1B2c3D4"
		$post_string = "";
		foreach( $post_values as $key => $value )
			{ $post_string .= "$key=" . urlencode( $value ) . "&"; }
		$post_string = rtrim( $post_string, "& " );

		// The following section provides an example of how to add line item details to
		// the post string.  Because line items may consist of multiple values with the
		// same key/name, they cannot be simply added into the above array.
		//
		// This section is commented out by default.
		/*
		$line_items = array(
			"item1<|>golf balls<|><|>2<|>18.95<|>Y",
			"item2<|>golf bag<|>Wilson golf carry bag, red<|>1<|>39.99<|>Y",
			"item3<|>book<|>Golf for Dummies<|>1<|>21.99<|>Y");
			
		foreach( $line_items as $value )
			{ $post_string .= "&x_line_item=" . urlencode( $value ); }
		*/

		// This sample code uses the CURL library for php to establish a connection,
		// submit the post, and record the response.
		// If you receive an error, you may want to ensure that you have the curl
		// library enabled in your php configuration
		$request = curl_init($post_url); // initiate curl object
			curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
			curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
			curl_setopt($request, CURLOPT_POSTFIELDS, $post_string); // use HTTP POST to send form data
			curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response.
			$post_response = curl_exec($request); // execute curl post and store results in $post_response
			// additional options may be required depending upon your server configuration
			// you can find documentation on curl options at http://www.php.net/curl_setopt
		curl_close ($request); // close curl object
		// This line takes the response and breaks it into an array using the specified delimiting character
	return	$response_array = explode($post_values["x_delim_char"],$post_response);

		// The results are output to the screen in the form of an html numbered list.
		$out = array();
	//	echo "<pre>"; print_r($response_array); echo "</pre>";
		//$out[]= "<OL>\n";
	
		//$out[]= "</OL>\n";
		//return $resp = implode('',$out);
		// individual elements of the array could be accessed to read certain response
		// fields.  For example, response_array[0] would return the Response Code,
		// response_array[2] would return the Response Reason Code.
		// for a list of response fields, please review the AIM Implementation Guide
}
	
require_once('featured_artist_admin.php');

function pagination(  )
{
	
$sql = mysql_query("select * from wp_featured_artist"); 
$total = mysql_num_rows($sql);
echo  $total;
$adjacents = 1;
$targetpage = "admin.php?page=manage_featured_artists"; //your file name
$limit = 1; //how many items to show per page
$page = $_GET['pg'];
echo $page;
if($page){ 
$start = ($page - 1) * $limit; //first item to display on this page
}else{
$start = 0;
}

/* Setup page vars for display. */
if ($page == 0) $page = 1; //if no page var is given, default to 1.
$prev = $page - 1; //previous page is current page - 1
$next = $page + 1; //next page is current page + 1
$lastpage = ceil($total/$limit); //lastpage.
$lpm1 = $lastpage - 1; //last page minus 1

$sql2 = "select * from wp_featured_artist where 1=1";
$sql2 .= " order by user_id desc limit $start ,$limit ";
$sql_query = mysql_query($sql2); 
$curnm = mysql_num_rows($sql_query);

/* CREATE THE PAGINATION */

$pagination = "";
if($lastpage > 1)
{ 
$pagination .= "<div class='pagination1'> <ul>";
if ($page > $counter+1) {
$pagination.= "<li><a href=\"$targetpage?page=$prev\">prev</a></li>"; 
}

if ($lastpage < 7 + ($adjacents * 2)) 
{ 
for ($counter = 1; $counter <= $lastpage; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a href='#' class='active'>$counter</a></li>";
else
$pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a></li>"; 
}
}
elseif($lastpage > 5 + ($adjacents * 2)) //enough pages to hide some
{
//close to beginning; only hide later pages
if($page < 1 + ($adjacents * 2)) 
{
for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
{
if ($counter == $page)
$pagination.= "<li><a href='#' class='active'>$counter</a></li>";
else
$pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a></li>"; 
}
$pagination.= "<li>...</li>";
$pagination.= "<li><a href=\"$targetpage?page=$lpm1\">$lpm1</a></li>";
$pagination.= "<li><a href=\"$targetpage?page=$lastpage\">$lastpage</a></li>"; 
}
//in middle; hide some front and some back
elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
{
$pagination.= "<li><a href=\"$targetpage?page=1\">1</a></li>";
$pagination.= "<li><a href=\"$targetpage?page=2\">2</a></li>";
$pagination.= "<li>...</li>";
for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a href='#' class='active'>$counter</a></li>";
else
$pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a></li>"; 
}
$pagination.= "<li>...</li>";
$pagination.= "<li><a href=\"$targetpage?page=$lpm1\">$lpm1</a></li>";
$pagination.= "<li><a href=\"$targetpage?page=$lastpage\">$lastpage</a></li>"; 
}
//close to end; only hide early pages
else
{
$pagination.= "<li><a href=\"$targetpage?page=1\">1</a></li>";
$pagination.= "<li><a href=\"$targetpage?page=2\">2</a></li>";
$pagination.= "<li>...</li>";
for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; 
$counter++)
{
if ($counter == $page)
$pagination.= "<li><a href='#' class='active'>$counter</a></li>";
else
$pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a></li>"; 
}
}
}

//next button
if ($page < $counter - 1) 
$pagination.= "<li><a href=\"$targetpage?page=$next\">next</a></li>";
else
$pagination.= "";
$pagination.= "</ul></div>\n"; 
}

}

/* add custom image size for featured Artist*/
add_image_size ('featured-artist-thum', 158, 158, true); 

/* add custom image size for featured Artist end*/

/* Display Featured Artist songs on home page  */
function fetch_author_song( $user_id_post ) {            
					$argsmart = array(
									'post_type'=> 'artist-songs',
									'post_status' => 'publish',
									'showposts' => 1,
									'orderby' => 'rand',
									'author__in' => $user_id_post,
									'tax_query' => array(
										array(
											'taxonomy' => 'post_format',
											'field' => 'slug',
											'terms' => array( 'post-format-audio' )
										)
									)
								);
					 $querymusicart = new WP_Query( $argsmart ); 
                      while($querymusicart->have_posts()) : $querymusicart->the_post();  
                      echo '<p>';
                      the_title(); 
                      echo '</p>';
                      echo '<p>';
                      the_content();
                      echo '</p>';
                     
					endwhile;
					wp_reset_query();  
					
					
} 

/* Display Featured Artist songs on home page end */
