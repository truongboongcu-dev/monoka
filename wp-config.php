<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'lpwfrcbs_monoke' );

/** Database username */
define( 'DB_USER', 'lpwfrcbs_monoke' );

/** Database password */
define( 'DB_PASSWORD', 'yY{QK]{1dB8ItlU0' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '$; aZV&qtX.GaHXrz3ljHSM4Bygbf@?=5E{)_gy%-#*b$i{7ma;foP|hM_=Hs~`f' );
define( 'SECURE_AUTH_KEY',  '*ogwIeR(@zpM(1>&Yv-wJ#sgGoPT)|]60{y&>>uzh7w~|JQ$:J(WXThjvjHJ404>' );
define( 'LOGGED_IN_KEY',    'K{=QIj70Z)1WboY9UjmbOyt1er>w<QM4^r>_m]CBtW$`;W@`{0ZQeJQvRDZO4F74' );
define( 'NONCE_KEY',        'X:n?AxW5#m7Z2:sb^ hHy^k&q.&-$5~~ 62O5Ll0B7cbmh.W^O`Z[{fs<Y~bU[Wd' );
define( 'AUTH_SALT',        '%etH!R21OSXPb<6L@*D_ GYYT[P0ky^XxvI!IN#sK)6*eA*>`9FKJIKtIU[?uG >' );
define( 'SECURE_AUTH_SALT', 'gkEolGStT)X>R>p}~F4;c>[<Hvcd#vz&Q|Kc<CLNf[*O<0lLMzy%f$LW)$SIt>tH' );
define( 'LOGGED_IN_SALT',   '%l=pFazG[IuyGtcvh%{%iP4OYI75MM<uQo5{v]0_61:xL%WCNl#3b{DIOSpy2Z7+' );
define( 'NONCE_SALT',       'PYz5C_FAh!~Mx4sl8Q[N&Cgx%.KXi>@fkCGGSN/#Sya>c!- DY!y7t39<;`J!x4&' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
