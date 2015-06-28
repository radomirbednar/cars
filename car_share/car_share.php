<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Car_share
 *
 * @wordpress-plugin
 * Plugin Name:       Car share
 * Plugin URI:        https://www.example.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress dashboard.
 * Version:           1.0.0
 * Author:            My name
 * Author URI:        https://www.example.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       car_share
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-car_share-activator.php
 */
function activate_car_share() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-car_share-activator.php';
	Car_share_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-car_share-deactivator.php
 */
function deactivate_car_share() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-car_share-deactivator.php';
	Car_share_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_car_share' );
register_deactivation_hook( __FILE__, 'deactivate_car_share' );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-car_share.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_car_share() {

	$plugin = new Car_share();
	$plugin->run();

}
run_car_share();