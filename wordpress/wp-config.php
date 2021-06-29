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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', '127.0.0.1' );

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
define( 'AUTH_KEY',         's!z?4Hets~Z0YClWQ{}j:H1P}kqGAWp|Ujw=#=hk!`v;qEoPjL|j@?iOln>w+C~.' );
define( 'SECURE_AUTH_KEY',  'Nm06$H)bsCki<,t<%T.^C^V11XF0~W?fI{`ty[*Fe/9#GSy2,>:hHz&K5EHIn$(b' );
define( 'LOGGED_IN_KEY',    '~m{Fs/JA2<[xK-B4iXD=YtDnrkY g@Ims7Et]UKQ.jiILB)7t]3x7F8_LCG=p=~d' );
define( 'NONCE_KEY',        '&rVKi:T6.Llm%Z7JL01}KPnjzF5ix?7<PH^|@8`s=~9dyrU.-y}X|sz#=E9G18 z' );
define( 'AUTH_SALT',        'e3t=7RW2[7lctL.?aG?Y9~RpX%g1UEW!BL.65L8F&cDZRw<#39dbcn&I=<_&~!v*' );
define( 'SECURE_AUTH_SALT', ']OS3w=YDJQ?y4a[]?L`-JHmxPuv~+#7R|IObp7FM=|f1gIA,VZOCvVO;$y/U<+ K' );
define( 'LOGGED_IN_SALT',   'ZAB #[<aVw*cj*!VsCQ_ 9]C@q(z>d8:_j,P/Si0Z6Lf.BxMWMzQAY#bF,[:_`FD' );
define( 'NONCE_SALT',       'u:Z.Ve~wW;.pIc<xQZgk!zb?|ymzQk+?K[Nllh#Jnfi}BI}H_Q##{Z:<et~aL5#h' );

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
