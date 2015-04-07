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

	private $rb_db;

	public function __construct() {

		$this->rb_db = new Resource_Booking_DB();

	}

	/**
	 * Ajax callback that returns the future reservations for a resource
	 *
	 * @since    0.1.0
	 */
	public function res_reservations_callback() {

		$res_id = $_POST['res_id'];
		$start = $_POST['start'];
		$end = $_POST['end'];

		$reservations = $this->rb_db->get_reservations_by_res_interval( $res_id, $start, $end);

		$response = new stdClass();

		if ( $reservations != FALSE ) {
			$response->success = TRUE;
			$response->reservations = $reservations;
		} else {
			$response->success = FALSE;
		}
		echo json_encode($response);

		wp_die(); // this is required to terminate immediately and return a proper response
	}

	/**
	 * Ajax callback that store a new reservation for a resource and return it
	 *
	 * @since    0.1.0
	 */
	public function res_save_reservation_callback() {

		$res_id = $_POST['res_id'];
		$title = $_POST['title'];
		$start = $_POST['start'];
		$end = $_POST['end'];

		$response = new stdClass();

		if( $this->rb_db->validate_reservation( $res_id, $start, $end ) ){
			// Store the reservation
			$new_reservation = $this->rb_db->save_reservation( $res_id, $title, $start, $end );
			
			if ( $new_reservation ) {
				$response->success = TRUE;
				$response->reservation = $new_reservation;
			} else {
				$response->success = FALSE;
			}

		} else {
				$response->success = FALSE;
		}

		echo json_encode($response);

		wp_die(); // this is required to terminate immediately and return a proper response
	}
}
