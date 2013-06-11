<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/home/digitallearning/dl.brenemanjaech.org/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'dl_brenemanjaech_org');

/** MySQL database username */
define('DB_USER', 'dlbrenemanjaecho');

/** MySQL database password */
define('DB_PASSWORD', 'iDfcjx2^');

/** MySQL hostname */
define('DB_HOST', 'mysql.dl.brenemanjaech.org');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'lHWJO1iT*!*?DC]sh`![?/dH?(jhsuZ)S8!{qQ++US{U:7@S`;JF X6Zy}:$~G-9');
define('SECURE_AUTH_KEY',  '|/-D||Yg0aY!aSFa#Yl9M1YoO|3hhw qw20(r&&2GqVM++|uW+,B@>m(Z22g#L`{');
define('LOGGED_IN_KEY',    'T<Y5l/$2;[U2R{|nY6C6N%p@#7{eZ%4AJvZl,*`HsEb9(51/eF2jg2oHf0z8uad.');
define('NONCE_KEY',        '+D0D.dy+6%NIuVMY|0~Is>x8-9q7+LXBs~[k6;BL>%G2Mz[5;Y/ioL8AmhN6KJ!O');
define('AUTH_SALT',        'LV:ZW>`6Td;XT<_;wtBG;%/yJl61JJG2Y24Z-xC[:rPByG:tqeBNU+sJ=0K(U*+J');
define('SECURE_AUTH_SALT', 'sn$^~+OJ7#IfMhs G*Y1h%_J!dK`Tb_dW|GEX//[L=@,qU6M#{hY+,:8{,^(1W?t');
define('LOGGED_IN_SALT',   'TE5g^bu?BTSPxaM%*#B^o F+IcX$}$548}KG-Eni?H2==n9)/q@`;+#`tM=#SPp!');
define('NONCE_SALT',       'W;4>B-GH@{pG]Q;|6hYQ7GFMkO]JOfBa&h2hx;;pDw-yfXu/ZjOz,IO:!xzWSbxC');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'prod_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
