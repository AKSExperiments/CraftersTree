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
define( 'DB_NAME', 'crafterstree' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'yolo' );

/** MySQL hostname */
define( 'DB_HOST', '10.126.32.3' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'd/<N8dc{/qe;kjnQu!GpGW?7jcire_PF0rBn-1aYwH.Xy7cB?Kvz^WjNJjh/oY&X' );
define( 'SECURE_AUTH_KEY',  'Q Q&6ftIwr`;kIXe<%]BoyET+gOv^^+k[9*I_$y15%2j;;g(r$+&zJp?ZiCvkRD=' );
define( 'LOGGED_IN_KEY',    '[rUVxIQO(8v2A#pVdxK-Us^%/^rFb4PfL!CqMOFh>:Nr*P4J.l*>,U+*I$E#!2X/' );
define( 'NONCE_KEY',        'w%yd/%Jxd!x|9%YW>u$0F6$8QgpBrA?;`D`DQ$Em_z~JSmf- $]%:aHFN*&f6_?}' );
define( 'AUTH_SALT',        'H0t8?pVF>eBBgRSwa,OX1TT(o#+w#A#F<lENd;I-E|L2 9(o_ZY?bq}sjgY(blwT' );
define( 'SECURE_AUTH_SALT', 'xOa:=Z(-e_x%6ax?yaIjk!nyg?&Alo+M-=c5z8(Ak|>=^BdzjWRS;G-o<h5N6&p7' );
define( 'LOGGED_IN_SALT',   'lm+{3<[nuxND!1c39-8i>I}UXJhrf^_K[2}fJ3c*hTdv{ 9i~o:UTPn~u[~?&1}C' );
define( 'NONCE_SALT',       ',o#qAIqjF{t#OI,Oh|4+>>IGhY6~Adu88rC>>5p4|#{ar rS|-=sXz!:*x?Il`.l' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'crafterstree_';

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
define( 'WP_DEBUG', true );
define('FS_METHOD', 'direct');

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );

set_time_limit(300);
