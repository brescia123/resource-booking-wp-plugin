<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/brescia123/resource-booking-wp-plugin/trunk/resource-booking.php
 * @since             0.1.0
 * @package           /
 *
 * @wordpress-plugin
 * Plugin Name:       Resource Booking
 * Plugin URI:        https://github.com/brescia123/resource-booking-wp-plugin
 * Description:       Simple Resource Booking Plugin
 * Version:           0.1.0
 * Author:            Giacomo Bresciani
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       resource-booking
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-resource-booking-activator.php
 */
function activate_resource_booking() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-resource-booking-activator.php';
	Resource_Booking_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-resource-booking-deactivator.php
 */
function deactivate_resource_booking() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-resource-booking-deactivator.php';
	Resource_Booking_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_resource_booking' );
register_deactivation_hook( __FILE__, 'deactivate_resource_booking' );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-resource-booking.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.1.0
 */
function run_resource_booking() {

	$plugin = new Resource_Booking();
	$plugin->run();

}
run_resource_booking();
