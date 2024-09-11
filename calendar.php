<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalendarz</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="./css/styles.css">

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/rrule@5.10.1/main.global.min.js" type='module'></script>
    <script src="https://cdn.jsdelivr.net/npm/rrule@2.6.8/dist/es5/rrule.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <style>
        #calendar {
        max-width: 900px;
        margin: 0 auto;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

<?php
    include 'config.php';
    include 'nav-bar.php';
?>

<div class="container-xl">
    <div id='calendar'></div>
</div>


<?php
    include 'footer.php'
?>

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

<script src="./js/login-script.js"></script>
    
</body>
</html>