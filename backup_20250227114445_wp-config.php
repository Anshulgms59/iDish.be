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
define('DB_NAME', 'idish_uvq');

/** MySQL database username */
define('DB_USER', 'idish_uvq');

/** MySQL database password */
define('DB_PASSWORD', 'tw_xyelejc5n');

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
define('AUTH_KEY', 'H~feDzS)jU=rFz1BoESXX5s.3p&U`YSGx~|LyTZvqvE<`d`EVIe5] P ayx=C|o>');
define('SECURE_AUTH_KEY', '<l.EDB(MfOv;nc!-qnIrf`<Nn)@P/EzYl=Hq0^05S[/G<z~p`L6kY2Y1_axfYNTu');
define('LOGGED_IN_KEY', '<Edo4!2P8Z+5FAJiS>BN[wiC]-dx~f=u5:vYL82H5L9()7OOConqs79@NEuqwV+d');
define('NONCE_KEY', 'I5HB+n1L#G .r=GPA<W_vbP@.Q;b2<(_[`PW|f%xWWH<1,B#k^-Z:(3&#/TFFi,[');
define('AUTH_SALT', '[$n1? n_;e~iui1BT%(Qm0Uo>vhF*8v0PzaJ69vg !xv*-6l@7%thDRW)xC<4g(&');
define('SECURE_AUTH_SALT', '|b9*P(eY!lH~CfnMmIw2y1:91-[,S1S40AQMC;XGO7;08dC j-YH,=U~6m#J-X+C');
define('LOGGED_IN_SALT', 'Zq< 0SFJ=ja.dse9n6m]LYnzuP`,/D$2xur]?`mAUKbv^Z<-p >vmZtT)[k8d.5B');
define('NONCE_SALT', '!lS/0t[#.y7w|FDwR9$J:|y,.|rh/QoDfa95c#t]-&6QGR!UBZSds_ga_0l*8I?1');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'AhV_';

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