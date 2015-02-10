<?php

/**
 * The definitions class for the Resource's metabox
 *
 * @link       http://example.com
 * @since      0.1.0
 *
 * @package    Resource_Booking
 * @subpackage Resource_Booking/admin/metaboxes
 */

/**
 * The Resource Metabox definitions class
 *
 * Defines the metabox behaviour and provide all needed methods 
 *
 * @package    Resource_Booking
 * @subpackage Resource_Booking/includes
 * @author     Your Name <email@example.com>
 */

class Resource_Booking_Res_Mb {

	/* Constants */
	const NONCE_NAME = 'rb_config_meta_box_nonce';

	/**
	 * The select field containing the time intervals
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      $time_interval_field    The array containing the informations of time intervals select field
	 */
	private $time_interval_field;

	/**
	 * Add the Metabox
	 *
	 * @since    0.1.0
	 */
	public function rb_add_res_mb( ) {
	    add_meta_box( 
	        'config',
	        __( 'Configuration' ),
	        array( $this, 'rb_config_res_mb_callback' ),
	        'resource',
	        'normal',
	        'default'
	    );
	}

	/**
	 * Render Resource Meta Box content.
	 *
	 * @since    0.1.0
	 */
 	public function rb_config_res_mb_callback( ) {
		wp_nonce_field( basename( __FILE__ ), self::NONCE_NAME );


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
		// $selected_time_interval = get_post_meta( $post->ID, '_my_meta_value_key', true );

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

        // Calendar
		echo '<div id="calendar"></div>';

	}

	/**
	 * Store the values selected in the Metaboxes
	 *
	 * @since    0.1.0
	 */
	public function rb_store_mb_values($post_id, $post) {

		/* Verify the nonce */
		if(!isset($_POST[self::NONCE_NAME]) || !wp_verify_nonce($_POST[self::NONCE_NAME], basename( __FILE__ ))){
			return $post_id;
		}

		/* Get the post type */
  		$post_type = get_post_type_object( $post->post_type );

		/* Check current user permission */
  		if ( !current_user_can( $post_type->cap->edit_post, $post_id ) ){
    		return $post_id;
  		}

		add_post_meta( $post_id, 'prova', $post );
	}
}

?>