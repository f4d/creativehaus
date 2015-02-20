<?php
# Database Configuration
define( 'DB_NAME', 'wp_shpromo' );
define( 'DB_USER', 'shpromo' );
define( 'DB_PASSWORD', 'lTBUTXG3JHJ3UR0ZH9tJ' );
define( 'DB_HOST', '127.0.0.1' );
define( 'DB_HOST_SLAVE', '127.0.0.1' );
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', 'utf8_unicode_ci');
$table_prefix = 'wp_';

# Security Salts, Keys, Etc
define('AUTH_KEY',         ',0|tmyBYChSQ[+Q?Zk8Jh^m_Gqd$kln}@Iu3-FM<r^qSKeH2BsokB60i$*rARQd;');
define('SECURE_AUTH_KEY',  '[c:Wp0H|.~*VJd!jybud1k&Obk]cj|YEM|kF/jn^SLK7KJl7ThH<I1y#Vs8H%OTw');
define('LOGGED_IN_KEY',    'rV@1dx~ZWD6}o8XsH;Rd5@hzZ?9Yx+g{9e1-o$.Lm%DlSI^eW<01_7?Hvy&M1`De');
define('NONCE_KEY',        'G`#|@rOsp~+i0+zMO0}M_,Nk)?BsW&A-#EIww-$a+!|87o+W?&)&q%*j[B_AK;}7');
define('AUTH_SALT',        'SS( s`Fn$-}k,tE}zfd<PKx-=|vXuj-v./f3d@+BiW^AAU}( .K}~dDA[cM2`L $');
define('SECURE_AUTH_SALT', '5Rn6(?!4|}vQ&--4>w~c gAO6RJn?7_))o*zPLEvlT?}JH+IJG8?Ma:U?dC}~<%0');
define('LOGGED_IN_SALT',   'mP1OV^l9Gw-:5,m%@/VwL#Ss(!L*-0yE)G+sjw-h_Z,zUcy{8C}yz&TW+EllB#&G');
define('NONCE_SALT',       'YnA:Tut|wz1*|zj-yzvqhn+~ ^7e4,W$.iZow}KzW 9zaeF|*+|s,gDUB[lob`A2');


# Localized Language Stuff

define( 'WP_CACHE', TRUE );

define( 'WP_AUTO_UPDATE_CORE', false );

define( 'PWP_NAME', 'shpromo' );

define( 'FS_METHOD', 'direct' );

define( 'FS_CHMOD_DIR', 0775 );

define( 'FS_CHMOD_FILE', 0664 );

define( 'PWP_ROOT_DIR', '/nas/wp' );

define( 'WPE_APIKEY', 'cac70c44a76f08547ddc8670c588b4bea128e12c' );

define( 'WPE_FOOTER_HTML', "" );

define( 'WPE_CLUSTER_ID', '2186' );

define( 'WPE_CLUSTER_TYPE', 'pod' );

define( 'WPE_ISP', true );

define( 'WPE_BPOD', false );

define( 'WPE_RO_FILESYSTEM', false );

define( 'WPE_LARGEFS_BUCKET', 'largefs.wpengine' );

define( 'WPE_SFTP_PORT', 22 );

define( 'WPE_LBMASTER_IP', '198.58.115.168' );

define( 'WPE_CDN_DISABLE_ALLOWED', true );

define( 'DISALLOW_FILE_EDIT', FALSE );

define( 'DISALLOW_FILE_MODS', FALSE );

define( 'DISABLE_WP_CRON', false );

define( 'WPE_FORCE_SSL_LOGIN', false );

define( 'FORCE_SSL_LOGIN', false );

/*SSLSTART*/ if ( isset($_SERVER['HTTP_X_WPE_SSL']) && $_SERVER['HTTP_X_WPE_SSL'] ) $_SERVER['HTTPS'] = 'on'; /*SSLEND*/

define( 'WPE_EXTERNAL_URL', false );

define( 'WP_POST_REVISIONS', FALSE );

define( 'WPE_WHITELABEL', 'wpengine' );

define( 'WP_TURN_OFF_ADMIN_BAR', false );

define( 'WPE_BETA_TESTER', false );

umask(0002);

$wpe_cdn_uris=array ( );

$wpe_no_cdn_uris=array ( );

$wpe_content_regexs=array ( );

$wpe_all_domains=array ( 0 => 'shpromo.wpengine.com', 1 => 'soundhousepromotions.com', 2 => 'www.soundhousepromotions.com', );

$wpe_varnish_servers=array ( 0 => 'pod-2186', );

$wpe_special_ips=array ( 0 => '198.58.115.168', );

$wpe_ec_servers=array ( );

$wpe_largefs=array ( );

$wpe_netdna_domains=array ( );

$wpe_netdna_domains_secure=array ( );

$wpe_netdna_push_domains=array ( );

$wpe_domain_mappings=array ( );

$memcached_servers=array ( );
define('WPLANG','');

# WP Engine ID


define('PWP_DOMAIN_CONFIG', 'soundhousepromotions.com' );

# WP Engine Settings






# That's It. Pencils down
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
require_once(ABSPATH . 'wp-settings.php');

$_wpe_preamble_path = null; if(false){}
