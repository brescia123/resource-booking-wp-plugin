<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      0.1.0
 *
 * @package    Resource_Booking
 * @subpackage Resource_Booking/admin
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Resource_Booking
 * @subpackage Resource_Booking/admin
 * @author     Your Name <email@example.com>
 */
class Resource_Booking_Admin {

	/*
	Constants
	*/
	const FULLCALENDAR_VERSION = '2.2.6';
	const MOMENT_VERSION = '2.9.0';

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $Resource_Booking    The ID of this plugin.
	 */
	private $Resource_Booking;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1.0
	 * @var      string    $Resource_Booking       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $Resource_Booking, $version ) {

		$this->Resource_Booking = $Resource_Booking;
		$this->version = $version;
		$this->resource_metabox = new Resource_Booking_Res_Mb();

	}

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->Resource_Booking, plugin_dir_url( __FILE__ ) . 'css/resource-booking-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'fullcalendar', 'http://cdnjs.cloudflare.com/ajax/libs/fullcalendar/'.self::FULLCALENDAR_VERSION.'/fullcalendar.min.css', array(), self::FULLCALENDAR_VERSION, 'all' );

	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->Resource_Booking, plugin_dir_url( __FILE__ ) . 'js/resource-booking-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'momentjs', 'http://cdnjs.cloudflare.com/ajax/libs/moment.js/'.self::MOMENT_VERSION.'/moment.min.js', array( 'jquery' ), self::MOMENT_VERSION, true );
		wp_enqueue_script( 'fullcalendar', 'http://cdnjs.cloudflare.com/ajax/libs/fullcalendar/'.self::FULLCALENDAR_VERSION.'/fullcalendar.min.js', array( 'jquery', 'momentjs' ), self::FULLCALENDAR_VERSION, true );

	}

	/**
	 * Callback to create and configure the metaboxes
	 *
	 * @since    0.1.0
	 */
	public function rb_add_metaboxes() {

		$this->resource_metabox->rb_add_res_mb();

	}

	/**
	 * Callback to store Metaboxes values
	 *
	 * @since    0.1.0
	 */
	public function rb_store_metaboxes($post_id, $post){
		
		$this->resource_metabox->rb_store_mb_values($post_id, $post);

	}
}
