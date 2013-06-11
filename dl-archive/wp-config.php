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
define('AUTH_KEY',         'R8R3U?G%6EDFbgZ)Gi`jYP"Va_CIjrLSHrE$5VQQCzg9WBAONgyzKOR*pkTBQTL9');
define('SECURE_AUTH_KEY',  '7&T#J/Ig)AmRuQsZpfU$Hw8T6/H~nqU+dT~r0|gR;`$Lc?3(|tO@q6`dslb$EqMo');
define('LOGGED_IN_KEY',    '*e6~Fmw7$rGp|ZGld/9pwSqnaxJOuJ)FxKE9br!6xf~o~NVhg/?iT&uRf5_5um7E');
define('NONCE_KEY',        '%Jq1!Kg:xS77fR(G3xx@^%TlUSJtWU^WhDE^jBX`SMP0UPA~P4sx%@z@sR7dngb?');
define('AUTH_SALT',        'O_6O|`csTAhX92i_OR1_+"x#^J^:1/x*w:a:lbnc)zcepCoSPs3*Ni)S~!`+(rpd');
define('SECURE_AUTH_SALT', 'JQTS7R3oSmxGU_j1F9HRN(ARhj:g9XA#a+1fdOIUIOnO2lS#o1d5S~LwerM8^a@6');
define('LOGGED_IN_SALT',   '&tcwc)Mn)DgMN*M0z+J|kb0wZNmqlJMT6Zuw?cbiqsL6BuIeLdT*aHTrn;_t1gSr');
define('NONCE_SALT',       '#cvi$kM(&;P+65xQ_RclTbl$ajlxouuTgATM&qmh$w!Zrm@7"QV$_3pwH/5|Rnff');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_8ddmah_';

/**
 * Limits total Post Revisions saved per Post/Page.
 * Change or comment this line out if you would like to increase or remove the limit.
 */
define('WP_POST_REVISIONS',  10);

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

