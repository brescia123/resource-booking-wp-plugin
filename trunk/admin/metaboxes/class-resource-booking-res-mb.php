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
	const TIME_INTERVAL_MK = 'time_interval';
	const RES_COLOR_MK = 'res_color';

	private $time_interval_field;
	private $res_color_field;
	private $selected_time_interval;
	private $selected_res_color;

	/**
	 * Add the Metabox
	 *
	 * @since    0.1.0
	 */
	public function rb_add_res_mb($post) {
	    add_meta_box( 
	        'config',
	        __( 'Configuration' ),
	        array( $this, 'rb_config_res_mb_callback' ),
	        'resource',
	        'normal',
	        'default',
	        array($post)
	    );
	}

	/**
	 * Render Resource Meta Box content.
	 *
	 * @since    0.1.0
	 */
 	public function rb_config_res_mb_callback($post) {
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

		// The values array represents the possible colors
		$res_color_field = array(
			'label' 	=> 'Resource Color', 
			'desc' 		=> 'The color representing the resource on calendar', 
			'id' 		=> 'res-color',
			'values' 	=> array(
				0 => array( 'label' => 'Green', 'value' => '#7bd148' ), 
				1 => array( 'label' => 'Bold blue', 'value' => '#5484ed' ), 
				2 => array( 'label' => 'Blue', 'value' => '#a4bdfc' ), 
				3 => array( 'label' => 'Turquoise', 'value' => '#46d6db' ), 
				4 => array( 'label' => 'Light', 'value' => '#7ae7bf' ), 
				5 => array( 'label' => 'Bold green', 'value' => '#51b749' ), 
				6 => array( 'label' => 'Yellow', 'value' => '#fbd75b' ), 
				7 => array( 'label' => 'Orange', 'value' => '#ffb878' ), 
				8 => array( 'label' => 'Red', 'value' => '#ff887c' ), 
				9 => array( 'label' => 'Bold red', 'value' => '#dc2127' ), 
				10 => array( 'label' => 'Purple', 'value' => '#dbadff' ), 
				11 => array( 'label' => 'Gray', 'value' => '#e1e1e1' ), 
				)
		);

		// Get the time-interval value
		$selected_time_interval = get_post_meta( $post->ID, self::TIME_INTERVAL_MK, true );
		if( !$selected_time_interval ){
			$selected_time_interval = 30;
		}

		// Get the color value
		$selected_res_color = get_post_meta( $post->ID, self::RES_COLOR_MK, true );
		if( !$selected_res_color ){
			$selected_res_color = '#7bd148';
		}

		// Html for the time-interval meta_box
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

		// Html for the res-color meta_box
		echo '<table class="form-table">';
			// Color Resource
			echo '<tr>
                <th><label for="'.$res_color_field['id'].'">'.$res_color_field['label'].'</label></th>
                <td>';
                   	echo '<select name="'.$res_color_field['id'].'" id="'.$res_color_field['id'].'">';
   					foreach ($res_color_field['values'] as $option) {
    					echo '<option', $selected_res_color == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'" style="color:'.$option['value'].'">'.$option['label'].'</option>';
    				}
    				echo '</select><br /><span class="description">'.$res_color_field['desc'].'</span>';
        	echo '</td></tr>';
		echo '</table>';

		// Include other html components of this page
		include($_SERVER['DOCUMENT_ROOT'].'/wp-content/plugins/resource-booking/admin/partials/resource-booking-admin-display.php');

	}

	/**
	 * Store the values selected in the Metaboxes
	 *
	 * @since    0.1.0
	 */
	public function rb_store_mb_values($post_id) {

		$post = get_post($post_id);


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

  		/* Get the current meta values */
  		$time_interval = get_post_meta($post_id, self::TIME_INTERVAL_MK, true);
  		$res_color = get_post_meta($post_id, self::RES_COLOR_MK, true);
  		$new_time_interval = $_POST['time-interval'];
  		$new_res_color = $_POST['res-color'];

  		/* If the value is changed replace it */
  		if($new_time_interval && '' == $time_interval){
			add_post_meta( $post_id, self::TIME_INTERVAL_MK, $new_time_interval );
  		} elseif ($new_time_interval && $new_time_interval != $time_interval ){
  			update_post_meta( $post_id, self::TIME_INTERVAL_MK, $new_time_interval );
  		}  		
  		if($new_res_color && '' == $res_color){
			add_post_meta( $post_id, self::RES_COLOR_MK, $new_res_color );
  		} elseif ($new_res_color && $new_res_color != $res_color ){
  			update_post_meta( $post_id, self::RES_COLOR_MK, $new_res_color );
  		}
	}
}

?>