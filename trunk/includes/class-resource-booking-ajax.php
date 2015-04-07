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
	 * Ajax callback that returns the future resevations for a resource
	 *
	 * @since    0.1.0
	 */
	public function res_reservations_callback() {

		$res_id = $_POST['res_id'];
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];

		$resevations = $this->rb_db->get_reservations_by_res_interval($res_id, $start_date, $end_date);

		echo json_encode($resevations);

		wp_die(); // this is required to terminate immediately and return a proper response
	}
}
