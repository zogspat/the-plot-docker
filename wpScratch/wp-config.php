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

if ($_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
$_SERVER['HTTPS']='on';

if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
$_SERVER['HTTP_HOST'] = $_SERVER['HTTP_X_FORWARDED_HOST'];
}

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', '$DBNAME' );

/** MySQL database username - deliberate reuse */
define( 'DB_USER', '$DBNAME' );

/** MySQL database password */
define( 'DB_PASSWORD', '$MYSQL_PASSWORD' );

/** MySQL hostname */
define( 'DB_HOST', 'mysql' );

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
define( 'AUTH_KEY',         '5<0Ro5X#; Qkb)qhL!(=eR*n1mB<vW[1F7/,:Z._dZF+9P={4PsnL(tt<-737l|3' );
define( 'SECURE_AUTH_KEY',  '~V<A9N50G]&.ZIPz},TtUOV{@(tHwCEoCLHpsU8awW+&W!MYw:%8X?j?6PxU #y*' );
define( 'LOGGED_IN_KEY',    'Y9kur2l_4V7S@I[:+iD)BjDbF|7:b?nCb;;D;tAy@sm| yjq p19GdFfNO`sru8W' );
define( 'NONCE_KEY',        'yh NdEA.u.{hY/qt:xdcxvPNb-p.OfoeLm?Cw%E7Mltfwztv{6ZU8tQj4=B~/_tM' );
define( 'AUTH_SALT',        '%_utU5vBcp~b1P;~?uYQ$3+#i*yVBU^ZI}Ez5,[?T^sMAn(j$P.W=t52+bQ9Q>rw' );
define( 'SECURE_AUTH_SALT', '>pa{KM.X{g^u#_rd-}6r k/2b4I9w.eQ%%.;--$ N(*6,1w~P]9<eglg[c;R2)Ut' );
define( 'LOGGED_IN_SALT',   'wC=3jUnkg4{3cr}wnHoM)D k-lDbPv6B0+8WgREO4]eNgNFl>f*Mq$(aAd_D?%Y`' );
define( 'NONCE_SALT',       'g:o;}<pVCMZEw5:YM@mdJj]cS2uqJwFSmb:;&SngK$LQz5PYj)C_%xN@vXTN}/K2' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
        define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** https://orbisius.com/blog/make-wordpress-work-behind-nginx-reverse-proxy-p6412
 * Sets up WordPress vars and included files. 
 */

require_once( ABSPATH . 'wp-settings.php' );

/* $_SERVER['REQUEST_URI'] = str_replace("/wp-admin/", "/blog/wp-admin/",  $_SERVER['REQUEST_URI']);
*/
