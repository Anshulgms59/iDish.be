<?php
if(!defined('DISALLOW_FILE_EDIT')){define('DISALLOW_FILE_EDIT', true);}
?><?php
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
define('DB_NAME', 'idish_JRv');

/** MySQL database username */
define('DB_USER', 'idish_JRv');

/** MySQL database password */
define('DB_PASSWORD', '(2KE&o0cBb4I');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY', '^5LZCdR2X#:k Bey!I:cYj=+Y?@7#NbGSjTKYu[M.9WgQVg5W +K$yI;/MsCg@jA');
define('SECURE_AUTH_KEY', 'fqdHoZiw~$m*OOR>(PA3iXDMF=(9pH_Wt2nIj$?J5P#z&+:~js:B1ZTlH$Y4kT`S');
define('LOGGED_IN_KEY', '6:*5gP`hrl5%O_,M./g~A<8e@@UeoT5M.|_h3stN Os<NgAfULt,(LIRlLw&u@JF');
define('NONCE_KEY', '*]l4O/SYTi51Pak3)k,B-yMgN_30];+.gM#UD<sqcLlYThuz:xtT4SdPh&[SzZX4');
define('AUTH_SALT', '23>Z-Z9C#D,ZTBgGv&]-~K$wU>-tSPnh+&b;3KJFZGR73Y<9A&T#A4#cfR.HmV;+');
define('SECURE_AUTH_SALT', '-iWO`[~vufE/-bydh%N[i(Jk>%ZGlh*tef;VO*zN_tAaAYE!usrXpXiNv2tCSL?M');
define('LOGGED_IN_SALT', 'kC?hKf`Fr)9jr7qjgrrx1=5;mTm/)m)Fn3=tg+WGi%3KImLg[gqidxg!=3K0Yqk&');
define('NONCE_SALT', '*[nfMgqK7BU#!jB8_4Pvwh+:FNeCuqdh1pdSj^/fk=B8]jA5v- AS|h>dseW !hR');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'pVY_';

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
	{define('ABSPATH', dirname(__FILE__) . '/');}

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');