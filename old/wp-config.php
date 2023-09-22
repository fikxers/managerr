<?php

































/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'realeoki_mg100' );

/** Database username */
define( 'DB_USER', 'realeoki_mg100' );

/** Database password */
define( 'DB_PASSWORD', '25(@]auG88!p-rwS' );

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
define( 'AUTH_KEY',         '9ptlrv2ahdpa1jqdjthrpthqh2f5zwbdq3q2wsqv5iueajamwksvfhmuwbngbb53' );
define( 'SECURE_AUTH_KEY',  'ziriknstnnbggy3hvaebgchcl28qo0sh0xqdkivnbu66vqlxvaksugjd7u1nnbzs' );
define( 'LOGGED_IN_KEY',    'h8lg9scu0enhphmewpn3wpgkrbbg4wjksu8fgl2f5t3nsox7cgct6r1pvsywwknh' );
define( 'NONCE_KEY',        'lcxeckkmxcaasgtbnual7rkhkuaargvzgwvlm9d79bzfjbx94rkxunwd55frgj8x' );
define( 'AUTH_SALT',        '14wjxqnizl9hy3ttqumn1fuzzajaawwhjk2g7jglvh1ek1ua5lbtedtvdevs10na' );
define( 'SECURE_AUTH_SALT', 'nd65zqqlnuxqeafu5mzyk6cfen539wm0lgxxdlvprke1emmzj0slrfppcrxrdhj9' );
define( 'LOGGED_IN_SALT',   'lfyfmcqplf5uumzlvebmjpmlrfurw39fk2ojylgqmdqlfxvolhbwohewyeblanli' );
define( 'NONCE_SALT',       'l0fz36v0zeny7tqenqhz9ydrjsclv8gajjpi9y3mnsdesmnn30axumqscmue694a' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpl9_';

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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
