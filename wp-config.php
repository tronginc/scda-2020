<?php
/**
 * The base configuration for WordPress updated
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
define( 'DB_NAME', 'scda');

/** MySQL database username */
define( 'DB_USER', 'scdauser');

/** MySQL database password */
define( 'DB_PASSWORD', '@123');

/** MySQL hostname */
define( 'DB_HOST', 'db:3306');

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '');

define( 'WP_DEBUG', true );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'a`F3bAS{m]#9D4n~=Hlky}qoIS3Y-NxyVwyLouLC1 o3CB^&!-Px+9vhf]D++X[Y' );
define( 'SECURE_AUTH_KEY',  ':obn)G3kl,Gy9=[K[h$1Q#zG!<^`7N2aIkC[8hk<,UNFF# HQuQb m/b@j>Gf;MS' );
define( 'LOGGED_IN_KEY',    '9hJ_z-.$Lj~SWhn.W+{=mr!VIiU$=kCZ[Lh(G?P<o^@^+P}*9bl#I*`57b4rQFnQ' );
define( 'NONCE_KEY',        'GOKfKbY&t`Ok5W7#;aVc&/~?i+;]fba`9&p^Y?%<(pOzK`R~K)~7EP/;<xU9$a9<' );
define( 'AUTH_SALT',        '@Y6/9V.qf3zA-Y+~Tw1|GY<O:yMZ5oSNd541D[n inCvW0W-v@S~QPJpDD;Qr<-7' );
define( 'SECURE_AUTH_SALT', '[Q1a@>PfH*t#gN{n,al2zXACo!UBX/FZsNVCj^ym8FGCNQ u1Odfz(p?>tZ4:MyD' );
define( 'LOGGED_IN_SALT',   '[q+/Gkm:df^.`[_[vBU=~`M6<*@<-laVtuWC1,&Af_4{fDUhZ,w[f/~ZL%:RnM>^' );
define( 'NONCE_SALT',       'r;_YT1Cz.!-#7coA;Ky=>wXl~{Fwo+N*R5KOj0]0=Qbi)p:!Zcz9{d^BAH^rQt%t' );

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

