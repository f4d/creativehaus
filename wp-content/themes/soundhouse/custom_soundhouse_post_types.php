<?php

add_image_size( 'soundhouse-members-images', 277, 190 );
add_image_size( 'blog-thum', 248, 248 );
add_image_size( 'sponsor-image', 280, 125 );
add_image_size( 'sponsor-sidebar', 106, 52 );
add_image_size( 'admin-artist-profile-pic', 340, 343 );
add_image_size( 'admin-artist-multiple-pic', 63, 60, true );
add_image_size( 'admin-directory-pic', 27, 27 );
add_image_size( 'artist-profile-page-pic', 861, 285, true );
add_image_size( 'artist-profile-multiple-pic', 56, 56, true );
add_image_size( 'artist-gallery-images', 800, 800, true );
add_image_size( 'artist-profle-blog-image', 89, 89, true );

/*
 * Create artist post type
 */ 
add_action( 'init', 'artist_post_type' );
function artist_post_type() {
	register_post_type( 'artist',
		array(
			'labels' => array(
				'name' => __( 'Artists' ),
				'singular_name' => __( 'Artists' )
			),
		'public' => true,
		'has_archive' => false,
		'rewrite'           => array( 'slug' => 'artist' ),
		'supports' => array( 'title', 'editor',  'excerpt', 'thumbnail' ),
		)
	);
}


/*
 * Create sponsors taxonomy
 */ 

add_action( 'init', 'create_artist_taxonomies', 0 );
function create_artist_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Categories' ),
		'all_items'         => __( 'All Categories' ),
		'parent_item'       => __( 'Parent Categories' ),
		'parent_item_colon' => __( 'Parent Categories:' ),
		'edit_item'         => __( 'Edit Categories' ),
		'update_item'       => __( 'Update Categories' ),
		'add_new_item'      => __( 'Add New Category' ),
		'new_item_name'     => __( 'New Category Name' ),
		'menu_name'         => __( 'Categories' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
	);
	register_taxonomy( 'artist_list', 'artist', $args );
}

/*
 * Create sponsers post type
 */ 

add_action( 'init', 'sponsors_post_type' );
function sponsors_post_type() {
	register_post_type( 'sponsors',
		array(
			'labels' => array(
				'name' => __( 'Sponsors' ),
				'singular_name' => __( 'Sponsors' )
			),
		'public' => true,
		'has_archive' => false,
		'rewrite'           => array( 'slug' => 'sponsors' ),
		'supports' => array( 'title', 'editor',  'excerpt', 'thumbnail' ),
		)
	);
}


/*
 * Create sponsors taxonomy
 */ 

add_action( 'init', 'create_sponsors_taxonomies', 0 );
function create_sponsors_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Categories' ),
		'all_items'         => __( 'All Categories' ),
		'parent_item'       => __( 'Parent Categories' ),
		'parent_item_colon' => __( 'Parent Categories:' ),
		'edit_item'         => __( 'Edit Categories' ),
		'update_item'       => __( 'Update Categories' ),
		'add_new_item'      => __( 'Add New Category' ),
		'new_item_name'     => __( 'New Category Name' ),
		'menu_name'         => __( 'Categories' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
	);
	register_taxonomy( 'sponsors_list', 'sponsors', $args );
}



add_action( 'init', 'soundhousemembers_post_type' );
function soundhousemembers_post_type() {
	register_post_type( 'soundhouse-members',
		array(
			'labels' => array(
				'name' => __( 'Sound House Members' ),
				'singular_name' => __( 'Sound House Members' )
			),
		'public' => true,
		'has_archive' => false,
		'rewrite'           => array( 'slug' => 'soundhouse-members' ),
		'supports' => array( 'title', 'editor',  'excerpt', 'thumbnail' ),
		)
	);
}


/*
 * Create sponsors taxonomy
 */ 

add_action( 'init', 'create_soundhousemembers_taxonomies', 0 );
function create_soundhousemembers_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'SoundHouse Memeber Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'SoundHouse Memeber Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search SoundHouse Memeber Categories' ),
		'all_items'         => __( 'All SoundHouse Memeber Categories' ),
		'parent_item'       => __( 'Parent SoundHouse Memeber Categories' ),
		'parent_item_colon' => __( 'Parent SoundHouse Memeber Categories:' ),
		'edit_item'         => __( 'Edit SoundHouse Memeber Categories' ),
		'update_item'       => __( 'Update SoundHouse Memeber Categories' ),
		'add_new_item'      => __( 'Add New SoundHouse Memeber Category' ),
		'new_item_name'     => __( 'New SoundHouse Memeber Category Name' ),
		'menu_name'         => __( 'SoundHouse Memeber Categories' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
	);
	register_taxonomy( 'soundhouse-members_list', 'soundhouse-members', $args );
}


/*
 * Create artists blog post type
 */ 



add_action( 'init', 'artistblog_post_type' );
function artistblog_post_type() {
	register_post_type( 'artist-blog',
		array(
			'labels' => array(
				'name' => __( "Artist's Blog" ),
				'singular_name' => __( "Artist's Blog" )
			),
		'public' => true,
		'has_archive' => true,
		'rewrite'           => array( 'slug' => 'artist-blog' ),
		'supports' => array( 'title', 'editor',  'excerpt', 'thumbnail', 'comments' ,'author'),
		)
	);
}


/*
 * Create artists blog taxonomy
 */ 

add_action( 'init', 'create_artistblog_taxonomies', 0 );
function create_artistblog_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Artist Blog Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'Artist Blog Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Artist Blog Categories' ),
		'all_items'         => __( 'All Artist Blog Categories' ),
		'parent_item'       => __( 'Parent Artist Blog Categories' ),
		'parent_item_colon' => __( 'Parent Artist Blog Categories:' ),
		'edit_item'         => __( 'Edit Artist Blog Categories' ),
		'update_item'       => __( 'Update Artist Blog Categories' ),
		'add_new_item'      => __( 'Add New Artist Blog Category' ),
		'new_item_name'     => __( 'New Artist Blog Category Name' ),
		'menu_name'         => __( 'Artist Blog Categories' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
	);
	register_taxonomy( 'artist-blog-list', 'artist-blog', $args );
}



/*
 * Create artists blog post type
 */ 
add_action( 'init', 'artistevents_post_type' );
function artistevents_post_type() {
	register_post_type( 'artist-events',
		array(
			'labels' => array(
				'name' => __( "Events & Gigs" ),
				'singular_name' => __( "Events & Gigs" )
			),
		'public' => true,
		'has_archive' => true,
		'rewrite'           => array( 'slug' => 'artist-events' ),
		'supports' => array( 'title', 'editor',  'excerpt', 'thumbnail', 'comments' ,'author'),
		)
	);
}


/*
 * Create artists blog taxonomy
 */ 
add_action( 'init', 'create_artistevents_taxonomies', 0 );

function create_artistevents_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Events Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'Events Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Events Categories' ),
		'all_items'         => __( 'All Events Categories' ),
		'parent_item'       => __( 'Parent Events Categories' ),
		'parent_item_colon' => __( 'Parent Events Categories:' ),
		'edit_item'         => __( 'Edit Events Categories' ),
		'update_item'       => __( 'Update Events Categories' ),
		'add_new_item'      => __( 'Add New Events Category' ),
		'new_item_name'     => __( 'New Events Category Name' ),
		'menu_name'         => __( 'Events Categories' ),
	);
	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
	);
	register_taxonomy( 'artist-events-list', 'artist-events', $args );
}


/*
 * Create artists songs type
 */ 
add_action( 'init', 'artistsongs_post_type' );
function artistsongs_post_type() {
	register_post_type( 'artist-songs',
		array(
			'labels' => array(
				'name' => __( "Artist Songs" ),
				'singular_name' => __( "Artist Songs" )
			),
		'public' => true,
		'has_archive' => true,
		'rewrite'           => array( 'slug' => 'artist-songs' ),
		'supports' => array( 'title', 'editor', 'thumbnail', 'author' ,'post-formats'),
		)
	);
}


/*
 * Create artists blog taxonomy
 */ 
add_action( 'init', 'create_artistsongs_taxonomies', 0 );

function create_artistsongs_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Artist Album', 'taxonomy general name' ),
		'singular_name'     => _x( 'Artist Album', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Artist Album' ),
		'all_items'         => __( 'All Artist Album' ),
		'parent_item'       => __( 'Parent Artist Album' ),
		'parent_item_colon' => __( 'Parent Artist Album:' ),
		'edit_item'         => __( 'Edit Artist Album' ),
		'update_item'       => __( 'Update Artist Album' ),
		'add_new_item'      => __( 'Add New Artist Album' ),
		'new_item_name'     => __( 'New Artist Album Name' ),
		'menu_name'         => __( 'Artist Album' ),
	);
	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
	);
	register_taxonomy( 'artist-songs-list', 'artist-songs', $args );
}



/*
 * Create artists songs type
 */ 
add_action( 'init', 'legacy_video_post_type' );
function legacy_video_post_type() {
	register_post_type( 'legacy-video',
		array(
			'labels' => array(
				'name' => __( "Legacy Videos" ),
				'singular_name' => __( "Legacy Videos" )
			),
		'public' => true,
		'has_archive' => false,
		'rewrite'           => array( 'slug' => 'legacy-video' ),
		'supports' => array( 'title', 'editor', 'thumbnail', 'author' ,'post-formats'),
		)
	);
}


/****
 * Create legacy videos post type
 ***/ 
add_action( 'init', 'create_legacyvideos_taxonomies', 0 );

function create_legacyvideos_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Legacy Category', 'taxonomy general name' ),
		'singular_name'     => _x( 'Legacy Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Legacy Category' ),
		'all_items'         => __( 'All Legacy Category' ),
		'parent_item'       => __( 'Parent Legacy Category' ),
		'parent_item_colon' => __( 'Parent Legacy Category:' ),
		'edit_item'         => __( 'Edit Legacy Category' ),
		'update_item'       => __( 'Update Legacy Category' ),
		'add_new_item'      => __( 'Add New Legacy Category' ),
		'new_item_name'     => __( 'New Legacy Category' ),
		'menu_name'         => __( 'Legacy Category' ),
	);
	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
	);
	register_taxonomy( 'legacy-video-list', 'legacy-video', $args );
}
