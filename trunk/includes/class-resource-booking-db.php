<?php

/**
 * Database Manager Class
 *
 * @link       http://example.com
 * @since      0.1.0
 *
 * @package    Resource_Booking
 * @subpackage Resource_Booking/includes
 */

class Resource_Booking_DB {

	/**
	 * The version of the database
	 *
	 * @since    0.1.0
	 */
	public static $rb_db_version = 2;

	/**
	 * Creates the database
	 *
	 * @since    0.1.0
	 */
	public static function create_tables() {

		global $wpdb;

		// Table name
		$reservation_table_name = $wpdb->prefix . 'rb_reservations';

		$charset_collate = $wpdb->get_charset_collate();

		// Sql query
		$sql = "CREATE TABLE $reservation_table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			resource_id mediumint(9) NOT NULL,
			title text DEFAULT 'Not specified' NOT NULL,
			start datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			end datetime DEFAULT '0000-00-00 00:00:00' NOT NULL, 
			UNIQUE KEY id (id)
		) $charset_collate;";

		// Compare with db if there are differences executes the sql
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		// Update database version
		update_option( 'rb_db_version', self::$rb_db_version );	
	}


	/**
	 * Returns the list of reservations for a given resource in a given interval
	 *
	 * @since    0.1.0
	 */
	public function get_reservations_by_res_interval( $res_id, $start_date, $end_date ) {

		global $wpdb;

		$reservation_table_name = $wpdb->prefix . 'rb_reservations';
		$query = 'SELECT * from '.$reservation_table_name
				.' WHERE resource_id = '.$res_id
				.' AND start > "'.$start_date.'"'
				.' AND start < "'.$end_date.'"'
				.';';
		$reservation_rows = $wpdb->get_results( $query );

		return $reservation_rows;
	}

	/**
	 * Store a reservation in the db and return the added row 
	 *
	 * @since    0.1.0
	 */
	public function save_reservation( $res_id, $title, $start_date, $end_date ) {

		global $wpdb;

		$reservation_table_name = $wpdb->prefix . 'rb_reservations';
		$data = array(
			'created' => current_time('mysql'),
			'resource_id' => $res_id,
			'start' => $start_date,
			'end' => $end_date,
			'title' => $title
		 );

		$result = $wpdb->insert( $reservation_table_name, $data );
		$new_res_id = $wpdb->insert_id;

		if( ! $result ) {
			return false;
		} else {
			$reservation = $wpdb->get_row( 'SELECT * from '.$reservation_table_name.' WHERE id = '.$new_res_id );
			return $reservation;
		}
	}




	/**
	 * Check if the if the database needs to be updated
	 *
	 * @since    0.1.0
	 */
	public function check_version() {
		global $wpdb;

		$reservation_table_name = $wpdb->prefix . 'rb_reservations';

		if( get_option('rb_db_version') != self::$rb_db_version || 
				$wpdb->get_var("SHOW TABLES LIKE '$reservation_table_name'") != $reservation_table_name){

			self::create_tables();
		}
	}
}
