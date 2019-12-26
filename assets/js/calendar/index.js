import { Calendar } from "@fullcalendar/core";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import esLocale from "@fullcalendar/core/locales/es"
import momentPlugin from "@fullcalendar/moment"

import "@fullcalendar/core/main.css";
import "@fullcalendar/daygrid/main.css";
import "@fullcalendar/timegrid/main.css";

import "./index.css";
import moment, {defaultFormat} from "moment"; // this will create a calendar.css file reachable to 'encore_entry_link_tags'

// $("#booking_beginAt_date, #booking_endAt").datetimepicker();

// require("eonasdan-bootstrap-datetimepicker-bootstrap4beta");

import 'eonasdan-bootstrap-datetimepicker-bootstrap4beta';

$(function() {
    var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate(), date.getHours(), date.getMinutes());
    // Datetime picker initialization.
    // See http://eonasdan.github.io/bootstrap-datetimepicker/
    $('.dateStart').datetimepicker({
        locale: 'es',
        timeZone: 'UTC +1',
        icons: {
            time: 'far fa-clock',
            date: 'far fa-calendar',
            up: 'fas fa-arrow-up',
            down: 'fas fa-arrow-down',
            previous: 'fas fa-chevron-left',
            next: 'fas fa-chevron-right',
            today: 'fas fa-calendar-check',
            clear: 'far fa-trash-alt',
            close: 'far fa-times-circle'
        }
    });
});

document.addEventListener("DOMContentLoaded", () => {
    var calendarEl = document.getElementById("calendar-holder");

    var eventsUrl = calendarEl.dataset.eventsUrl;

    var calendar = new Calendar(calendarEl, {
        locale: esLocale,
        defaultView: "dayGridMonth",
        editable: false,

        selectable: false,
        eventSources: [
            {
                url: eventsUrl,
                method: "POST",
                // editable: false,
                extraParams: {
                    filters: JSON.stringify({}),
                },
                failure: () => {
                    // alert("There was an error while fetching FullCalendar!");
                },
            },
        ],
        header: {
            left: "prev,next today myButton",
            center: "title",
            right: "dayGridMonth,timeGridWeek,timeGridDay",
        },
        dateClick: function(info) {
            // alert('Clicked on: ' + info.dateStr);
            // alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
            // alert('Current view: ' + info.view.type);
            // change the day's background color just for fun
            // info.dayEl.style.backgroundColor = 'red';
            $("#titleEventAdd").html('Crear nota');
            $("#addEventModal").modal();
        },
        customButtons: {
            myButton: {
                text: 'Crear',
                click:function () {
                    $("#titleEventAdd").html('Crear nota');
                    $("#addEventModal").modal();
                }
            },
        },
        eventClick: function(info){
            var eventObj = info.event;

            $("#titleEvent").html(eventObj.title);
            $("#descriptionEvent").html(eventObj.extendedProps.description);
            $("#calendarModal").modal();
        },
        plugins: [interactionPlugin, dayGridPlugin, timeGridPlugin, momentPlugin], // https://fullcalendar.io/docs/plugin-index
        timeZone: "UTC",
    });
    calendar.render();
});