<?php

/**
 * The Custom Post Types definitions class
 *
 * @link       http://example.com
 * @since      0.1.0
 *
 * @package    Resource_Booking
 * @subpackage Resource_Booking/includes
 */

/**
 * The Custom Post Types definitions class
 *
 * Defines the cpt attributes and relationships
 *
 * @package    Resource_Booking
 * @subpackage Resource_Booking/includes
 * @author     Your Name <email@example.com>
 */
class Resource_Booking_Cpts {

	/**
	 * Register Custom Post Types.
	 *
	 * @since    0.1.0
	 */
	public function register_cpts() {


		// Resources Post Type
		$labels = array(
			'name'               => _x( 'Resources', 'post type general name' ),
			'singular_name'      => _x( 'Resource', 'post type singular name' ),
			'add_new'            => _x( 'Add New', 'resource' ),
			'add_new_item'       => __( 'Add New Resource' ),
			'edit_item'          => __( 'Edit Resource' ),
			'new_item'           => __( 'New Resource' ),
			'all_items'          => __( 'All Resources' ),
			'view_item'          => __( 'View Resource' ),
			'search_items'       => __( 'Search Resources' ),
			'not_found'          => __( 'No resources found' ),
			'not_found_in_trash' => __( 'No resources found in the Trash' ), 
			'parent_item_colon'  => '',
			'menu_name'          => 'Resources'
		);
		$args = array(
			'labels'        => $labels,
			'description'   => 'Holds resources for booking',
			'public'        => true,
			'menu_position' => 5,
			'menu_icon'		=> 'dashicons-screenoptions',
			'supports'      => array( 'title', 'thumbnail', 'custom-fields' ),
			'has_archive'   => true,
		);

		register_post_type( 'resource', $args ); 

	}
}
