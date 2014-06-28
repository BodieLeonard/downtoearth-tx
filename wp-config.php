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
define('DB_NAME', 'db421767514');

/** MySQL database username */
define('DB_USER', 'dbo421767514');

/** MySQL database password */
define('DB_PASSWORD', 'Summer123@');

/** MySQL hostname */
define('DB_HOST', 'db421767514.db.1and1.com');

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
define('AUTH_KEY',         'i=A%b0j)|<|2T*76:GJ9.3`G+1[Hf#-A*|Bw[Me}:6w2/`Yz+dj}{s[>fAYO~R26');
define('SECURE_AUTH_KEY',  '=e.3(Rj8QcE+wt7aq&.QWEXhuL9CcoSl;Bj]0*V{)ZT[>-f Kq})5rFTQ$hdnlUV');
define('LOGGED_IN_KEY',    'D=>|Mrm{*F}J10LQ..;sU#>STg!YqBG~y>yV-nY[ZJR*h$|qERhJ=M5|u~EV|((I');
define('NONCE_KEY',        '1HJD+gv:2gjBDFC2+(e7Aj{-1Q[]E|hI+z7&{Mtn)c#pS>+}DCg1,$K.1!KU(|SF');
define('AUTH_SALT',        '6f_Y@zo2;DRNBbW|n_w/L~/E_D#],B&jEGJk&-*mIf0|I4i5y]~#FTH7LJ$k<ycp');
define('SECURE_AUTH_SALT', '~gqd7 f=FW?/e1M#mkW$!%ih+$(|k7N-o-mPG96AJ;}`@6(;sI#[Lqmu7}K{`n!^');
define('LOGGED_IN_SALT',   '<+)DZNqfORlY/a0M$jnDwIThf:_9(!OK]#;zrm<6cY=4&{o5{L#(XX0p|Eptqk<S');
define('NONCE_SALT',       '=GzT.FX5PH+POZkK1~;x)6+CZnUh]+F oGCz=&l9WyF@Nbd,Ouy1U@8!jX>?}?t&');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
