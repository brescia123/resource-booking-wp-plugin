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
	public $rb_db_version;

	public function __construct(){
		$this->rb_db_version = 1;
	}

	/**
	 * Creates the database
	 *
	 * @since    0.1.0
	 */
	public function create() {
		global $wpdb;

		$reservation_table_name = $wpdb->prefix . 'reservations';

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

		update_option( 'rb_db_version', $this->rb_db_version );	
	}


	/**
	 * Check if the if the database needs to be updated
	 *
	 * @since    0.1.0
	 */
	public function check_version() {
		if( get_option('rb_db_version') != $this->rb_db_version ){
			$this->create();
		}
	}
}
