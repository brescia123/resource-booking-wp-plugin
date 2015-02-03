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
			'labels'        => $labels,
			'description'   => 'Holds resources for booking',
			'public'        => true,
			'menu_position' => 20,
			'menu_icon'		=> 'dashicons-screenoptions',
			'supports'      => array( 'title', 'thumbnail' ),
			'has_archive'   => true,
		);

		register_post_type( 'resource', $args ); 

	}

	/**
	 * Add all the meta_boxes
	 *
	 */
	public function rb_add_meta_boxes( )
	{
	    add_meta_box( 
	        'config',
	        __( 'Configuration' ),
	        array( $this, 'rb_config_meta_box_callback' ),
	        'resource',
	        'normal',
	        'default'
	    );
	}

	/**
	 * Render Meta Box content.
	 *
	 */
 	public function rb_config_meta_box_callback( ) 
	{
		wp_nonce_field( 'rb_config_meta_box', 'rb_config_meta_box_nonce' );


		// The values array represents the possible intervals, the value is in minutes
		$time_interval_field = array(
			'label' 	=> 'Time Interval', 
			'desc' 		=> 'The time interval to book the resource', 
			'id' 		=> 'time-interval',
			'values' 	=> array(
				0 => array(
					'label' => '1/2 hour', 
					'value' => 30
					), 
				1 => array(
					'label' => '1 hour', 
					'value' => 60
					), 
				2 => array(
					'label' => '2 hour', 
					'value' => 120
					)
				)
			);

		// Get the field
		$selected_time_interval = get_post_meta( $post->ID, '_my_meta_value_key', true );

		// Html for the meta_box
		echo '<table class="form-table">';

			// Time Interval
			echo '<tr>
                <th><label for="'.$time_interval_field['id'].'">'.$time_interval_field['label'].'</label></th>
                <td>';
                   	echo '<select name="'.$time_interval_field['id'].'" id="'.$time_interval_field['id'].'">';
   					foreach ($time_interval_field['values'] as $option) {
    					echo '<option', $selected_time_interval == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
    				}
    				echo '</select><br /><span class="description">'.$time_interval_field['desc'].'</span>';
        	echo '</td></tr>';
		echo '</table>';


	}

	/**
	 * Load a script if in a Resource admin page
	 *
	 * @since    0.1.0
	 */
	public function resource_admin_script($value='')
	{
		# code...
	}

}
