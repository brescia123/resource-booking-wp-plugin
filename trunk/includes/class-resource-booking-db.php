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
	public static $rb_db_version = 1;

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
	public function get_reservations_by_res( $res_id, $start_date, $end_date ) {

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
