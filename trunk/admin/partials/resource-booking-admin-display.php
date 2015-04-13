<?php

/**
 * Provide a dashboard view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      0.1.0
 *
 * @package    Resource_Booking
 * @subpackage Resource_Booking/admin/partials
 */
?>

<!-- Calendar -->
<h4><span id="important">IMPORTANT! </span>Any changes you make on the calendar will be saved even without pressing the button "Update".</h4>
<div id="calendar"></div>

<div id="event-dialog" title="Basic dialog">
	<label for="reservation-title">Name</label>
    <input type="text" id="reservation-title" value="" class="text ui-widget-content ui-corner-all">
	<p>From <span class="dialog-date" id="reservation-start"></span></p>
	<p>To <span class="dialog-date" id="reservation-end"></span></p>
</div>