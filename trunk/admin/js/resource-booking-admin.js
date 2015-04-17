(function($) {
    'use strict';

    // Document ready
    $(function() {
        var calendar = $('#calendar');
        var postId = $('#post_ID').val();
        var timeIntervalSelect = $('#time-interval');
        var eventDialog = $('#event-dialog');
        var resColorSelect = $('#res-color');
        var timeInterval = '00:' + timeIntervalSelect.find('option:selected').val() + ':00';
        var resColor = resColorSelect.find('option:selected').val();

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
            editable: true,
            height: 'auto',
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
            eventResize: updateEvent,
            eventDrop: updateEvent,
            eventClick: showEventDialog
        };
        calendar.fullCalendar(calendarOpts);


        /*  
         *   SERVER COMMUNICATION  
         */

        // Makes a POST request to the server for a new reservation
        function newEvent(start, end, jsEvent, view) {
            var title = prompt('Name:');
            if (title) {
                var data = {
                        'action': 'res_save_reservation_callback',
                        'res_id': postId,
                        'title': title,
                        'start': start.format(),
                        'end': end.format()
                    }
                    // Post the new event to the server
                jQuery.post(ajax_object.ajax_url, data, function(response_json) {
                    var response = JSON.parse(response_json);

                    if (response.success) {
                        var event = resToEvent(response.reservation);
                        calendar.fullCalendar('renderEvent', event, true);
                    } else {
                        alert('Error: \n' + response_json);
                    }
                });
            }
        }

        // Makes a POST request to the server to get all the events in a given time interval
        function getEvents(start, end, timezone, callback) {
            var data = {
                'action': 'res_reservations_callback',
                'res_id': postId,
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

        // Makes a POST request to the server to update a reservation
        function updateEvent(event, delta, revertFunc) {
            var data = {
                'action': 'res_update_reservation_callback',
                'id': event.id,
                'res_id': postId,
                'title': event.title,
                'start': event.start.format(),
                'end': event.end.format()
            }
            jQuery.post(ajax_object.ajax_url, data, function(response_json) {
                var response = JSON.parse(response_json);

                if (response.success) {
                    calendar.fullCalendar('updateEvent', event);
                } else {
                    alert('Error: \n' + response_json);
                    revertFunc()
                }
            });
        }

        // Makes a POST request to the server to delete a reservation
        function deleteEvent(event) {
            var data = {
                'action': 'res_delete_reservation_callback',
                'id': event.id
            }
            jQuery.post(ajax_object.ajax_url, data, function(response_json) {
                var response = JSON.parse(response_json);

                if (response.success) {
                    calendar.fullCalendar('removeEvents', event.id);
                } else {
                    alert('Error: \n' + response_json);
                }
            });
        }

        /*  
         *   DIALOGS  
         */

        // Configure event modal
        eventDialog.dialog({
            autoOpen: false,
            dialogClass: 'wp-dialog',
            resizable: false,
            closeOnEscape: true,
            modal: true,
            buttons: {
                'Delete': function() {
                    var event = $(this).data('event');
                    deleteEvent(event);
                    eventDialog.dialog('close');
                },
                'Update': function() {
                    var event = $(this).data('event');
                    var newTitle = $(this).find('#reservation-title').val();
                    if (newTitle !== event.title) {
                        event.title = newTitle;
                        updateEvent(event);
                    }
                    eventDialog.dialog('close');
                }
            }
        });

        function showEventDialog(calEvent, jsEvent, view) {
            eventDialog.find('#reservation-start').text(calEvent.start.format('LLLL'));
            eventDialog.find('#reservation-end').text(calEvent.end.format('LLLL'));
            eventDialog.find('#reservation-title').val(calEvent.title);
            eventDialog
                .data('event', calEvent)
                .dialog('option', 'title', 'Reservation')
                .dialog('open');
        }

        function promptForNewTitle(calEvent, jsEvent, view) {
            eventDialog
                .data('')
                .dialog('open');
            // var newTitle = prompt('New name:');
            // if (newTitle) {
            //     calEvent.title = newTitle
            //     updateEvent(calEvent);
            // }
        }

        // Reacts to new time interval selection
        timeIntervalSelect.change(function() {
            var minutesTot = $(this).val();
            var hours = parseInt(minutesTot / 60);
            var minutesRel = minutesTot % 60;

            calendarOpts.slotDuration = '00:' + minutesTot + ':00';
            calendar.fullCalendar('destroy');
            calendar.fullCalendar(calendarOpts);
        });

        // Reacts to new resource color selection
        resColorSelect.change(function() {
            var newColor = $(this).val();
            calendarOpts.eventColor = newColor;
            calendar.fullCalendar('destroy');
            calendar.fullCalendar(calendarOpts);
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
