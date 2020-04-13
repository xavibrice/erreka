
import { Calendar } from "@fullcalendar/core";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import esLocale from "@fullcalendar/core/locales/es";
import momentPlugin from "@fullcalendar/moment";
import listPlugin from '@fullcalendar/list';

// import "@fullcalendar-scheduler";
import "@fullcalendar/core/main.css";
import "@fullcalendar/daygrid/main.css";
import "@fullcalendar/timegrid/main.css";

import "./index.css";


const routes = require('../../../public/js/fos_js_routes');
import Routing from '../../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min';

Routing.setRoutingData(routes);


$(document).ready(function(){

    var calendarEl = document.getElementById("calendar-holder");

    var eventsUrl = calendarEl.dataset.eventsUrl;

    var calendar = new Calendar(calendarEl, {
        locale: esLocale,
        timeZone: "UTC +1",
        height: 'parent',
        defaultView: "timeGridWeek",
        selectable: true,
        editable: true,
        minTime: '08:00:00',
        maxTime: '21:00:00',
        hiddenDays: [0],
        header:{
            left: 'prev,next today',
            center: 'title',
            right: "timeGridWeek,timeGridDay",
        },
        eventSources: [
            {
                url: eventsUrl,
                method: "POST",
                // editable: false,
                extraParams: {
                    filters: JSON.stringify({}),
                },
                failure: () => {
                    alert("There was an error while fetching FullCalendar!");
                },
            },
        ],
        // dateClick: function(info) {
        //     alert('clicked ' + info.dateStr);
        // },
        select: function(info) {
            // alert('selected ' + info.startStr + ' to ' + info.endStr);
            let start = calendar.formatDate(info.startStr, "DD-MM-YYYYTHH:mm:ss");
            let end = calendar.formatDate(info.endStr, "DD-MM-YYYYTHH:mm:ss");
            $("#titleEventAdd").html('Crear');
            $("#booking_beginAt").val(start);
            $("#booking_endAt").val(end);
            $("#addEventModal").modal();
        },
        eventClick: function(info){
            var eventObj = info.event;
            $('#btn-delete-edit').attr('href', Routing.generate('booking_editar', {id: eventObj.extendedProps.idBooking}));

            $("#titleEvent").html(eventObj.title);
            $("#descriptionEvent").html(eventObj.extendedProps.description);
            $("#calendarModal").modal();


            $("#btn-delete-booking").on('click', function () {
                if (eventObj.extendedProps.idBooking) {
                    // info.jsEvent.preventDefault(); // don't let the browser navigate
                    var event = calendar.getEventById(info.event.id);
                    event.remove();
                    $("#calendarModal").modal('hide');

                    // let url = Routing.generate
                }
                $.ajax({
                    url: Routing.generate('booking_delete', {id: eventObj.extendedProps.idBooking}),
                    method: "DELETE",
                    success: function () {
                        // alert('ok');

                    }
                });
            });


        },
        eventDrop: function(info) {
            // alert(info.event.title + " was dropped on " + info.event.start.toISOString());
            let start = calendar.formatDate(info.event.start, "DD-MM-YYYY HH:mm:ss");
            let end = calendar.formatDate(info.event.end, "DD-MM-YYYY HH:mm:ss");

            // alert(start + end);
            $.ajax({
                url: Routing.generate('booking_edit', {id: info.event.extendedProps.idBooking}),
                data: 'beginAt='+start+'&endAt='+end,
                method: "POST",
                success: function () {
                    // alert('ok');
                }
            });

            // if (!confirm("Are you sure about this change?")) {
            //     info.revert();
            // }
        },
        eventResize: function(info) {
            let start = calendar.formatDate(info.event.start, "DD-MM-YYYY HH:mm:ss");
            let end = calendar.formatDate(info.event.end, "DD-MM-YYYY HH:mm:ss");

            // alert(start + end);
            $.ajax({
                url: Routing.generate('booking_edit', {id: info.event.extendedProps.idBooking}),
                data: 'beginAt='+start+'&endAt='+end,
                method: "POST",
                success: function () {
                    // alert('ok');
                }
            });
            // alert(info.event.title + " end is now " + info.event.end.toISOString());
            //
            // if (!confirm("is this okay?")) {
            //     info.revert();
            // }
        },
        allDaySlot: false,
        // events: eventsUrl,  // request to load current events
        plugins: [interactionPlugin, dayGridPlugin, timeGridPlugin, momentPlugin, listPlugin], // https://fullcalendar.io/docs/plugin-index
    });

    calendar.render();
});