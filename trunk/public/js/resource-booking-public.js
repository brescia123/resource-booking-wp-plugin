(function($) {
    'use strict';

    // Document ready
    $(function() {

        $('.calendar').each(function() {

            var resourceId = this.id;
            var timeInterval = '00:' + resourcesInfo[resourceId].timeInterval + ':00';
            var resColor = resourcesInfo[resourceId].resColor;

            // Calendar configuration
            var calendarOpts = {
                header: {
                    left: 'title',
                    center: 'agendaDay,agendaWeek,month',
                    right: 'today prev,next'
                },
                weekends: false,
                defaultView: 'agendaWeek',
                allDaySlot: false,
                eventColor: resColor,
                selectable: true,
                selectOverlap: false,
                eventOverlap: false,
                editable: false,
                resizable: false,
                slotDuration: timeInterval,
                views: {
                    week: {
                        titleFormat: 'MMMM D YYYY'
                    }
                },
                eventSources: [{
                    // Get events from the db
                    events: getEvents
                }],
                select: newEvent,
                // eventClick: showEventDialog
            };
            $(this).fullCalendar(calendarOpts);

            // Makes a POST request to the server to get all the events in a given time interval
            function getEvents(start, end, timezone, callback) {
                var data = {
                    'action': 'res_reservations_callback',
                    'res_id': resourceId,
                    'start': start.format(),
                    'end': end.format(),
                }
                jQuery.post(ajax_object.ajax_url, data, function(response_json) {
                    var response = JSON.parse(response_json);
                    if (response.success) {
                        var events = $.map(response.reservations, resToEvent);
                        callback(events);
                    } else {
                        alert('Error: \n' + response_json);
                    }
                });
            }

            // Makes a POST request to the server for a new reservation
            function newEvent(start, end, jsEvent, view) {
                var title = prompt('Name:');
                if (title) {
                    var data = {
                            'action': 'res_save_reservation_callback',
                            'res_id': resourceId,
                            'title': title,
                            'start': start.format(),
                            'end': end.format()
                        }
                        // Post the new event to the server
                    jQuery.post(ajax_object.ajax_url, data, function(response_json) {
                        var response = JSON.parse(response_json);

                        if (response.success) {
                            var event = resToEvent(response.reservation);
                            $(this).fullCalendar('renderEvent', event, true);
                        } else {
                            alert('Error: \n' + response_json);
                        }
                    });
                }
            }

        });

        /* Helper Methods */

        // Converts a reservation object retrieved from the server in FullCalendar event
        var resToEvent = function(reservation) {
            return {
                'id': reservation.id,
                'title': reservation.title,
                'start': reservation.start,
                'end': reservation.end,
                'allDay': false
            }
        }

        // Converts an envent to a reservation object
        var eventToRes = function(event) {
            return {
                'id': postId,
                'title': event.title,
                'start': event.start.toString(),
                'end': event.end.toString()
            }
        }
    });

})(jQuery);
