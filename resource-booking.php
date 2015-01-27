<?php

// THIS IS A COMMENT WITH A TEMPLATE ENTRY Resource Booking

/**
 * The WordPress Plugin Boilerplate.
 *
 * A foundation off of which to build well-documented WordPress plugins that
 * also follow WordPress Coding Standards and PHP best practices.
 *
* @package   Resource_Booking
* @author    Giacomo Bresciani brescia123@gmail.com
* @license   GPL-2.0+
* @link      https://github.com/brescia123/resource-booking-wp-plugin
* @copyright 2014 Giacomo Bresciani
 *
 * @wordpress-plugin
 * Plugin Name:       Resource Booking
 * Plugin URI:        
 * Description:       @TODO
 * Version:           1.0.0
 * Author:            Giacomo Bresciani
 * Author URI:        https://github.com/brescia123
 * Text Domain:       plugin-name-locale
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/brescia123/resource-booking-wp-plugin
 * WordPress-Plugin-Boilerplate: v2.6.1
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

require_once( plugin_dir_path( __FILE__ ) . 'public/class-resource-booking.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 */

register_activation_hook( __FILE__, array( 'Resource_Booking', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Resource_Booking', 'deactivate' ) );

add_action( 'plugins_loaded', array( 'Resource_Booking', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

/*
 * @TODO:
 *
 * If you want to include Ajax within the dashboard, change the following
 * conditional to:
 *
 * if ( is_admin() ) {
 *   ...
 * }
 *
 * The code below is intended to to give the lightest footprint possible.
 */
if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-resource-booking-admin.php' );
	add_action( 'plugins_loaded', array( 'Resource_Booking_Admin', 'get_instance' ) );

}
