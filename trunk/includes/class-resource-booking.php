<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the dashboard.
 *
 * @link       http://example.com
 * @since      0.1.0
 *
 * @package    Resource_Booking
 * @subpackage Resource_Booking/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      0.1.0
 * @package    Resource_Booking
 * @subpackage Resource_Booking/includes
 * @author     Your Name <email@example.com>
 */
class Resource_Booking {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      Resource_Booking_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      string    $resource_booking    The string used to uniquely identify this plugin.
	 */
	protected $resource_booking;

	/**
	 * The current version of the plugin.
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since    0.1.0
	 */
	public function __construct() {

		$this->resource_booking = 'resource-booking';
		$this->version = '0.1.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_plugin_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Resource_Booking_Loader. Orchestrates the hooks of the plugin.
	 * - Resource_Booking_i18n. Defines internationalization functionality.
	 * - Resource_Booking_Admin. Defines all hooks for the dashboard.
	 * - Resource_Booking_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-resource-booking-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-resource-booking-i18n.php';

		/**
		 * The class responsible for defining Custom Post Types
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-resource-booking-cpts.php';

		/**
		 * The class responsible for managing the database
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-resource-booking-db.php';

		/**
		 * The class responsible for defining the metabox for the Resource adimn page
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/metaboxes/class-resource-booking-res-mb.php';

		/**
		 * The class responsible for defining all actions that occur in the Dashboard.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-resource-booking-admin.php';
		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-resource-booking-public.php';

		$this->loader = new Resource_Booking_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Resource_Booking_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Resource_Booking_i18n();
		$plugin_i18n->set_domain( $this->get_resource_booking() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the dashboard functionality
	 * of the plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Resource_Booking_Admin( $this->get_resource_booking(), $this->get_version() );

		// Styles and scripts hooks
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		// Resource metabox hook
		$this->loader->add_action( 'add_meta_boxes_resource', $plugin_admin, 'rb_add_metaboxes');
		// Store resource postmeta hook
		$this->loader->add_action( 'save_post_resource', $plugin_admin, 'rb_store_metaboxes');


	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Resource_Booking_Public( $this->get_resource_booking(), $this->get_version() );

		// Styles and scripts hooks
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the plugin as the Custom Post Type ones
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function define_plugin_hooks() {

		$plugin_cpts = new Resource_Booking_Cpts();
		$db_man = new Resource_Booking_DB();

		// New resource custom post type registration hook
		$this->loader->add_action( 'init', $plugin_cpts, 'register_cpts' );
		$this->loader->add_action( 'plugins_loaded', $db_man, 'check_version' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    0.1.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     0.1.0
	 * @return    string    The name of the plugin.
	 */
	public function get_resource_booking() {
		return $this->resource_booking;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     0.1.0
	 * @return    Resource_Booking_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     0.1.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
