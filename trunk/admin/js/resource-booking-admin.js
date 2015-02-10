(function($) {
    'use strict';

    // Document ready
    $(function() {
        var calendar = $('#calendar');

        // Calendar configuration
        calendar
            .fullCalendar({
                header: {
                    left: 'title',
                    center: 'agendaDay,agendaWeek,month',
                    right: 'today prev,next'
                },
                weekends: false,
                defaultView: 'agendaWeek',
                allDaySlot: false,
            })
    });

})(jQuery);
