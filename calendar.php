<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/rrule@5.10.1/main.global.min.js" type='module'></script>
    <script src="https://cdn.jsdelivr.net/npm/rrule@2.6.8/dist/es5/rrule.min.js"></script>

    <style>
        #calendar {
        max-width: 900px;
        margin: 0 auto;
        }
    </style>
</head>
<body>

<a href='index.php'>Strona główna</a>


<div id='calendar'></div>

<script type='module'>


  document.addEventListener('DOMContentLoaded', function() {

      var calendarEl = document.getElementById('calendar');

      var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          events: function(fetchInfo, successCallback, failureCallback) {
              var xhr = new XMLHttpRequest();
              xhr.open('GET', 'ajax/events/get_events.php');
              xhr.onload = function() {
                  if (xhr.status === 200) {
                      var events = JSON.parse(xhr.responseText);
                      successCallback(events);
                  } else {
                      failureCallback(xhr.statusText);
                  }
              };
              xhr.send();
          },
          eventRender: function(info) {
              // Обработка отображения рекуррентных событий
              if (info.event.extendedProps.rrule) {
                  var rrule = new RRule({
                      freq: RRule[info.event.extendedProps.rrule.freq.toUpperCase()],
                      byweekday: info.event.extendedProps.rrule.byweekday.map(day => RRule[day.toUpperCase()])
                  });

                  var occurrences = rrule.all();
                  occurrences.forEach(function(date) {
                      var eventCopy = {
                          title: info.event.title,
                          start: date,
                          end: info.event.end // или вычислить по длине исходного события
                      };
                      calendar.addEvent(eventCopy);
                  });

                  return false; // Не отображать исходное событие
              }
          }
      });

      calendar.render();
  });
</script>
    
</body>
</html>