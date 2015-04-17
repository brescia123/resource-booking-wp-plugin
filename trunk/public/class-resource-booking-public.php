<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      0.1.0
 *
 * @package    Resource_Booking
 * @subpackage Resource_Booking/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Resource_Booking
 * @subpackage Resource_Booking/public
 * @author     Your Name <email@example.com>
 */
class Resource_Booking_Public {

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

	private $rb_db;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1.0
	 * @var      string    $Resource_Booking       The name of the plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $Resource_Booking, $version ) {

		$this->Resource_Booking = $Resource_Booking;
		$this->version = $version;
		$this->rb_db = new Resource_Booking_DB();

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Resource_Booking_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Resource_Booking_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		global $post;
		if( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'resource_booking') ) {		
			wp_enqueue_style( 'wp-jquery-ui-dialog' );
			wp_enqueue_style( 'fullcalendar', 'http://cdnjs.cloudflare.com/ajax/libs/fullcalendar/'.self::FULLCALENDAR_VERSION.'/fullcalendar.min.css', array(), self::FULLCALENDAR_VERSION, 'all' );
		}

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_styles_fix() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Resource_Booking_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Resource_Booking_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		global $post;
		if( has_shortcode( $post->post_content, 'resource_booking') ) {		
			wp_enqueue_style( $this->Resource_Booking, plugin_dir_url( __FILE__ ) . 'css/resource-booking-public.css', array(), $this->version, 'all' );
		}
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Resource_Booking_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Resource_Booking_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// Add script to the page only if there is the plugin shortcode
		global $post;
		if( has_shortcode( $post->post_content, 'resource_booking') ) {
			wp_enqueue_script( $this->Resource_Booking, plugin_dir_url( __FILE__ ) . 'js/resource-booking-public.js', array( 'jquery' ), $this->version, false );
			// in JavaScript, object properties are accessed as ajax_object.*
			wp_localize_script( $this->Resource_Booking, 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'we_value' => 1234 ) );
			wp_enqueue_script( 'momentjs', 'http://cdnjs.cloudflare.com/ajax/libs/moment.js/'.self::MOMENT_VERSION.'/moment.min.js', array( 'jquery' ), self::MOMENT_VERSION, true );
			wp_enqueue_script( 'fullcalendar', 'http://cdnjs.cloudflare.com/ajax/libs/fullcalendar/'.self::FULLCALENDAR_VERSION.'/fullcalendar.min.js', array( 'jquery', 'momentjs' ), self::FULLCALENDAR_VERSION, true );
		}	
	}

	/**
	 * return the HTML to be replaced to the shortcode
	 *
	 * @since    0.1.0
	 */
	public function res_booking_shortcode( $atts, $content = "" ) {

		// Extracts attributes and fill the missing with deafault values
		extract( shortcode_atts( array(
        	'resource_id' => '0',
    	), $atts ) );

		$resource = get_post($resource_id);
		if( !$resource ) {
			return '<h4>The resource '.$resource_id.' is no more available. Please contact the site administrator.</h4>';
		}

		// Get the time-interval value
		$selected_time_interval = get_post_meta( $resource_id, Resource_Booking_Res_Mb::TIME_INTERVAL_MK, true );
		if( !$selected_time_interval ){
			$selected_time_interval = 30;
		}

		// Get the color value
		$selected_res_color = get_post_meta( $resource_id, Resource_Booking_Res_Mb::RES_COLOR_MK, true );
		if( !$selected_res_color ){
			$selected_res_color = '#7bd148';
		}


		$contents = '<script type="text/javascript">
						if(typeof resourcesInfo === "undefined"){
							resourcesInfo = {};
						}
						resourcesInfo["'.$resource_id.'"] = {
				    		"timeInterval": "'.$selected_time_interval.'",
				    		"resColor": "'.$selected_res_color.'"
						};
					</script>';

		$contents = $contents.'<h2>'.$resource->post_title.'</h2>';
		$contents = $contents.'<div id="'.$resource_id.'" class="calendar"></div>';

		return $contents;

	}
}
