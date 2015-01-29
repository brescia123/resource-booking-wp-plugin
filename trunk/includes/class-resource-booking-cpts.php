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

		$labels = array(
			'name'               => _x( 'Products', 'post type general name' ),
			'singular_name'      => _x( 'Product', 'post type singular name' ),
			'add_new'            => _x( 'Add New', 'book' ),
			'add_new_item'       => __( 'Add New Product' ),
			'edit_item'          => __( 'Edit Product' ),
			'new_item'           => __( 'New Product' ),
			'all_items'          => __( 'All Products' ),
			'view_item'          => __( 'View Product' ),
			'search_items'       => __( 'Search Products' ),
			'not_found'          => __( 'No products found' ),
			'not_found_in_trash' => __( 'No products found in the Trash' ), 
			'parent_item_colon'  => '',
			'menu_name'          => 'Products'
		);
		$args = array(
			'labels'        => $labels,
			'description'   => 'Holds our products and product specific data',
			'public'        => true,
			'menu_position' => 5,
			'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
			'has_archive'   => true,
		);

		register_post_type( 'product', $args ); 

	}
}
