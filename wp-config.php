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
define('DB_NAME', 'giaohang_happy');

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

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'HyYzlV>>M?|YWWm?hFw95OG[ta?5gQ2Yg-:f$zD#j[dNB[),*82Ip4i3f3(9z:H!');
define('SECURE_AUTH_KEY',  'Qzuz2U/46;%WEBlc)dw7Vlny:q49)s58>,ohO()R+A8t~K?N<KZ2FT*L<r.)>b?r');
define('LOGGED_IN_KEY',    'f`e(bhnK_R|FnEoq1p1|SC~=3*2=@JDS>rPci#O&Qr3E,LeMhxBzVZ[Ao@Qp(NVu');
define('NONCE_KEY',        'DxM~&hs!J(HKI2MDk;F_$?:)13DK0Lw$%StyyV!0+~&8`Ro/5fd!C&N/H my|<ZF');
define('AUTH_SALT',        'bM]zZ5Def%~G:x^g{/XH`EV>/$7k!s0SMjF:W&3;yVZ].UJb-4/r) AB {[_4LM$');
define('SECURE_AUTH_SALT', '+CMhwohAxJH<CDL9J3T9N]IlwJ3.GeO ,:eq~bwj-F@WH5:7@d1o4pZgokMy<7A|');
define('LOGGED_IN_SALT',   '.c:-LQ|:*9{vK-zP&Iynf:*yy[tB,-7y8J1N hY^Ym,(5mBYa:T)+<^tt<1%Qk@s');
define('NONCE_SALT',       '8=<hnnEV4MGQ xY*,bo]TG[Q^apjxc^md{H&-{rz.azS<d{,BV5k#2RI=F_BrP-A');

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
