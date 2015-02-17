<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      0.1.0
 *
 * @package    Resource_Booking
 * @subpackage Resource_Booking/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      0.1.0
 * @package    Resource_Booking
 * @subpackage Resource_Booking/includes
 * @author     Your Name <email@example.com>
 */
class Resource_Booking_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    0.1.0
	 */
	public static function activate() {
		global $wpdb;

		// Create reservation table
		$reservation_table_name = $wpdb->prefix . "reservations";

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $reservation_table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			resource_id mediumint(9) NOT NULL,
			start datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			end datetime DEFAULT '0000-00-00 00:00:00' NOT NULL, 
			UNIQUE KEY id (id)
		) $charset_collate;";

		// Compare with db if there are differences executes the sql
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

}
