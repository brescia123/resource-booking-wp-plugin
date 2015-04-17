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
	 * Register Custom Post Types. (Resource)
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
			'labels'        		=> $labels,
			'description'   		=> 'Holds resources for booking',
			'public'        		=> false,
			'publicly_queryable'    => false,
			'menu_position' 		=> 20,
			'menu_icon'				=> 'dashicons-screenoptions',
			'supports'      		=> array( 'title', 'thumbnail' ),
			'has_archive'   		=> true,
		);

		register_post_type( 'resource', $args ); 
	}

	/**
	 * Called when a Resource is deleted. It deletes all the reservations of the the deleted Resource.
	 *
	 * @since    0.1.0
	 */
	public function delete_resource_reservations($post_id) {
		$post = get_post($post_id);
		if( $post->post_type === 'resource' ) {
			$rb_db = new Resource_Booking_DB();
			$rb_db->delete_resource_reservations( $post_id );
		}
	}
}
