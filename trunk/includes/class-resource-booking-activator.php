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
		$db_man = new Resource_Booking_DB();
		$db_man->create();
	}

}
