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

	/**
	 * Callback to pass to the hook to create and add the metabox
	 *
	 * @since    0.1.0
	 */
	public function rb_add_res_mb( )
	{
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
 	public function rb_config_res_mb_callback( ) 
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

}

?>