<?php

    /**
     * The plugin bootstrap file
     *
     * This file is read by WordPress to generate the plugin information in the plugin
     * admin area. This file also includes all of the dependencies used by the plugin,
     * registers the activation and deactivation functions, and defines a function
     * that starts the plugin.
     *
     * @link              https://www.linkedin.com/in/mustafa-shaaban22/
     * @since             1.0.0
     * @package           Nh_Configurations
     *
     * @wordpress-plugin
     * Plugin Name:       NH Configurations
     * Plugin URI:        https://bitbucket.org/AppenzaStudio/nh/src
     * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
     * Version:           1.0.0
     * Author:            NINJA MASTER -> Mustafa Shaaban
     * Author URI:        https://www.linkedin.com/in/mustafa-shaaban22/
     * License:           GPL-2.0+
     * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
     * Text Domain:       nh-configurations
     * Domain Path:       /languages
     */

    // If this file is called directly, abort.
    if (!defined('WPINC')) {
        die;
    }

    /**
     * Currently plugin version.
     * Start at version 1.0.0 and use SemVer - https://semver.org
     * Rename this for your plugin and update it as you release new versions.
     */
    define('NH_CONFIGURATIONS_VERSION', '1.0.0');

    if (!defined('PLUGIN_URL')) {
        define('PLUGIN_URL', plugin_dir_url(__FILE__));
    }

    if (!defined('PLUGIN_PATH')) {
        define('PLUGIN_PATH', plugin_dir_path(__FILE__));
    }

    if (!defined('NH_CONFIGURATION')) {
        define('NH_CONFIGURATION', get_option('nh_configurations')?: []);
    }

    /**
     * The core plugin class that is used to define internationalization,
     * admin-specific hooks, and public-facing site hooks.
     */
    require plugin_dir_path(__FILE__) . 'includes/class-nh-configurations.php';

    /**
     * Begins execution of the plugin.
     *
     * Since everything within the plugin is registered via hooks,
     * then kicking off the plugin from this point in the file does
     * not affect the page life cycle.
     *
     * @since    1.0.0
     */
    function run_ninja_configurations()
    {

        $plugin = new Nh_Configurations();
        $plugin->run();

    }

    run_ninja_configurations();
