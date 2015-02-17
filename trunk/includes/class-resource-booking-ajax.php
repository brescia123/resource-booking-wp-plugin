<?php

/**
 * Ajax Callbacks Class
 *
 * @link       http://example.com
 * @since      0.1.0
 *
 * @package    Resource_Booking
 * @subpackage Resource_Booking/includes
 */

class Resource_Booking_ajax {

	/**
	 * Ajax callback that returns the future resevations for a resource
	 *
	 * @since    0.1.0
	 */
	public function res_reservations_callback() {
		echo "res_reservations_callback";

		wp_die(); // this is required to terminate immediately and return a proper response
	}
}
