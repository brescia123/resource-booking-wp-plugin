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
		$start_datetime = $_POST['start_datetime'];
		$end_datetime = $_POST['end_datetime'];

		$reservations = $this->rb_db->get_reservations_by_res_interval( $res_id, $start_datetime, $end_datetime);

		$response = new stdClass();

		if ( $reservations ) {
			$response->success = TRUE;
			$response->reservations = array_map( array( $this, 'reservation_to_obj_repr' ), $reservations );
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
		$start_datetime = $_POST['start_datetime'];
		$end_datetime = $_POST['end_datetime'];

		$new_reservation = $this->rb_db->save_reservation( $res_id, $title, $start_datetime, $end_datetime );
			
		$response = new stdClass();

		if ( $new_reservation ) {
			$response->success = TRUE;
			$response->reservation = $this->reservation_to_obj_repr( $new_reservation );
		} else {
			$response->success = FALSE;
		}

		echo json_encode($response);

		wp_die(); // this is required to terminate immediately and return a proper response
	}

	/**
	 * Helper function that converts a resource object retrieved from the DB to the representation required by
	 * the front-end. Needs to be enconded in JSON.
	 *
	 * @since    0.1.0
	 */
	private function reservation_to_obj_repr( $reservation ) {
		$reservation_obj = new stdClass();

		$reservation_obj->resource_id = $reservation->resource_id;
		$reservation_obj->title = $reservation->title;
		$reservation_obj->start_datetime = $reservation->start;
		$reservation_obj->end_datetime = $reservation->end;

		return $reservation_obj;
	}
}
