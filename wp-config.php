<?php
define( 'WP_CACHE', false ); // Added by WP Rocket
define( 'THEMES_DIR',  dirname( __FILE__ ) . '/wp-content/themes/rnd' );

//define( 'WP_CACHE', true ); // Added by WP Rocket

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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */

define('WP_SITEURL', 'http://' . $_SERVER['SERVER_NAME'] );
define('WP_HOME',    'http://' . $_SERVER['SERVER_NAME'] );


define( 'DB_NAME', 'shynhpre_mium' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         '{V%(O]m>t[,CEe@sdqW+B7aHXu0vbOWj0${Ztxs{o# 3T#J],a`oa0xe^Hq*BAl$' );
define( 'SECURE_AUTH_KEY',  '8OXX,^<x;h3SZI8w-vxr({l~r=3T{wJG)O|X<>HaC*YFwETP+q?0~A9c[b+qxx]y' );
define( 'LOGGED_IN_KEY',    'ZJM_L:Jci9u1oQ3Vd?!cJ/))7Fpik5@~)FG3m_-h}5x.Dfd=!=$laiRGcNKbk$gY' );
define( 'NONCE_KEY',        'H.G2ZCEV7B<c<e(]1k;wG/Dw!]6>Nr?,Dq`qo Pe{{ei#u$mow`oI#!wQ?9Tvn~C' );
define( 'AUTH_SALT',        'ot1j d E[kPv|px3==~g,$~8`}!%?wx!GDFWTsb@.<vbVf_&({:j|)[Cp}WX1]78' );
define( 'SECURE_AUTH_SALT', 'f;)A@=Z(!F|k{r;qB84M3;[t[D6?BH^|N>2431?Er]Ck< YAFFIZ?uo5t~-[GGF>' );
define( 'LOGGED_IN_SALT',   'H43R/l0!7JiofSOeU)nP7$-ybn4dWr-X-0/:X!MUw6K/t/V_Qp4=;BE:Cw&B+k2K' );
define( 'NONCE_SALT',       '#a!jpf{VZ&y;,>[si3=18jVnqRF-V{:}c+hvekU{1`FOr`/,s) v93fYVD/xzeT{' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'shynhpremium_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
