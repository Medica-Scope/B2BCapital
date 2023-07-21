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
     * @link https://wordpress.org/documentation/article/editing-wp-config-php/
     *
     * @package WordPress
     */

    // ** Database settings - You can get this info from your web host ** //
    /** The name of the database for WordPress */
    define( 'DB_NAME', 'b2b' );

    /** Database username */
    define( 'DB_USER', 'root' );

    /** Database password */
    define( 'DB_PASSWORD', '' );

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
    define( 'AUTH_KEY',         '+7;@%ei~2:w~F[2(su $ !X9~7eGuU^)8K9pi<=Y<sGch&cXD&A`RSG3/Kd{E6Vl' );
    define( 'SECURE_AUTH_KEY',  'Z24p!/i=QTM)Y7p!({m6S)Z{NZG|=8$9mNDTcNXi5WMjc^1ew3(GoRFEtG9A?y}}' );
    define( 'LOGGED_IN_KEY',    '`TMRMl`L_qLii;`XxtK$oJ$1L{o,}Sv6E`@H?<E#oj]+>PHX^ uMf3,-;%ILT4W_' );
    define( 'NONCE_KEY',        'p*`Cg[R*p@8WSM|lnPsvb,deKT46k`%F}(Iw+k}t@q-#e?d4y8+RjQ>8@twedmAO' );
    define( 'AUTH_SALT',        'NOu){2x1C&tMC~Ho4N)a93:N:pYUL[#bu-O9{b#5:77Dx(N#5M#NV-F6refWg)5_' );
    define( 'SECURE_AUTH_SALT', 'jULalmIo/J`!(3(>4|2xt=gJuTF[U /d9.lP+ky^yE/eC;mbH_nMa^+LD!3?!hkL' );
    define( 'LOGGED_IN_SALT',   '{#Ww@/HJLrku{~)>KT/I.LAX$Hs<Dy@|!6uXTrz2WNW<u2GjT!DCL)RzAKRd4O}^' );
    define( 'NONCE_SALT',       'dA.{9+;.spFmwmw2c7be87=xY1<4)w(+},,P{Y.Um?vP:@H;sW6S4 01s9#;QA5<' );

    /**#@-*/

    /**
     * WordPress database table prefix.
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
     * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
     */
    define( 'WP_DEBUG', false );

    /* Add any custom values between this line and the "stop editing" line. */

    define('WP_HOME', 'http://'.$_SERVER['HTTP_HOST'].'/');
    define('WP_SITEURL', 'http://'.$_SERVER['HTTP_HOST'].'/');

    /* That's all, stop editing! Happy publishing. */

    /** Absolute path to the WordPress directory. */
    if ( ! defined( 'ABSPATH' ) ) {
        define( 'ABSPATH', __DIR__ . '/' );
    }

    /** Sets up WordPress vars and included files. */
    require_once ABSPATH . 'wp-settings.php';
