<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wp-agency');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');
	
define('USE_MYSQL', 0);
define('DB_DIR', '/db/');
	
define('DB_FILE', 'wp.sqlite');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'Y~ mjQb_**y?/cI/!1WuR77y$g.)}*0`;%NX*_O{yu]LyFc%=IVvA/#JO<t@djBr');
define('SECURE_AUTH_KEY',  '`;#ii>EVetY`*l0VDCEYt,LyC}~vOUiv7>4l~*#e/0q?$/C-Vv1V[AU/#w<Sy@(1');
define('LOGGED_IN_KEY',    'S4F(1)E&Y n{QertPB^{GA/obr|(zT8HS@enY~HROPNX9d4!c`)W!7<Ik7n7Dgm3');
define('NONCE_KEY',        '[uu(FOxV}x&Ih]9o3i+iM4{%U>ohMJZ@SL`RW$Wz%cW&)#2q)n$7l[>:zzB?`h-;');
define('AUTH_SALT',        'qZm-I>hOs4Cp!vm +*0jVN]8KPQ++o ~@=#i?&QKgm+z2T%B+jjFOR`]C9}!&|nR');
define('SECURE_AUTH_SALT', 'B9zBqAq^1cm<{23La/5Dd#s&bEOwxHKDVnQ>NhG<6n2E:|Cw3P2):8bVOnOtXZTy');
define('LOGGED_IN_SALT',   '&>XAMg]!3pYml)3y&DKKN^P>*5B|gU&&/H>ZXr9;Nw~0=:]Zq4>[o*q0>7dgAhyP');
define('NONCE_SALT',       'ba>GC>(6m#rtt>G N8)-@7+)$mnFRZ)]jlY{U~S);mOcG,&43qE}qZ,<P8T#b,w-');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'FS_CHMOD_DIR', ( 0755 & ~ umask() ) );
define( 'FS_CHMOD_FILE', ( 0644 & ~ umask() ) );
define( 'WP_AUTO_UPDATE_CORE', false );
define( 'WP_CRON_LOCK_TIMEOUT', 3 );
define( 'DISABLE_WP_CRON', true);
define( 'WP_POST_REVISIONS', false );
define( 'WP_ALLOW_REPAIR', false);
define( 'WP_MEMORY_LIMIT', '128M' );
define( 'WP_MAX_MEMORY_LIMIT', '512M' );
define( 'WP_ALLOW_MULTISITE', false);
//define( 'WP_HOME', 'http://restwp.dev' );
//define( 'WP_PLUGIN_URL', 'http://restwp.dev/wp-content/plugins');
//define( 'WP_CONTENT_URL', 'http://restwp.dev/wp-content');
//define( 'WP_SITEURL', 'http://restwp.dev' );
define( 'UPLOADS', 'wp-content/uploads' );
define( 'WP_CONTENT_DIR', $_SERVER['DOCUMENT_ROOT'] . '/wp-content' );
define( 'WP_PLUGIN_DIR', $_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins' );
define( 'SAVEQUERIES', false );
define('JWT_AUTH_SECRET_KEY', 'your-top-secrect-key');
define( 'JWT_AUTH_CORS_ENABLE', true);







//define('WPLANG', 'tr_TR');

//define('WP_USE_THEMES', false);
//define( 'WP_DEFAULT_THEME', 'liberapp');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */


define( 'WP_DEBUG', false);
define( 'WP_DEBUG_LOG', false );
define( 'WP_DEBUG_DISPLAY', false );
ini_set( 'error_log', $_SERVER['DOCUMENT_ROOT'] . '/wp-content/error_php.log' );
ini_set('log_errors','Off');
@ini_set( 'display_errors', 0 );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
