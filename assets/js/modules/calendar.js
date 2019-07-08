
import '@fullcalendar/core/main.css';
import '@fullcalendar/daygrid/main.css';
import '@fullcalendar/timegrid/main.css';
import '@fullcalendar/list/main.css';

import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';

export default class ShowCalendar {

    static init () 
    {

        

        var calendarEl = document.getElementById('calendar-holder');
        var vehicleId = document.getElementById("vehicleId").innerHTML;

        if (calendarEl === null) 
        {

            return;

        }

        var calendar = new Calendar(calendarEl, {

            defaultView: 'dayGridMonth',
            editable: true,
            eventSources: [
                            {

                                url: "/fc-load-events",
                                method: "POST",
                                extraParams: {
                                filters: JSON.stringify({ vehicle: vehicleId }),
                                },
                                failure: () => {},

                            },
                          ],
            header: {

                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay',

                    },
            plugins: [ dayGridPlugin, timeGridPlugin, listPlugin ], // https://fullcalendar.io/docs/plugin-index
            timeZone: 'UTC',

        });

        calendar.render();

    }

}
