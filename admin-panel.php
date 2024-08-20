<?php
    include("config.php");

    if(isset($_SESSION['logged']) && $_SESSION['logged'] && isset($_SESSION['username']) && ($_SESSION['admin'])){
        $sql = "SELECT * FROM users WHERE id = '{$_SESSION['user_id']}'";
        $result = $mysqli -> query($sql);
        $row = $result -> fetch_assoc();
        if(!$row['admin']) {
            header("Location: /index.php");
        }
    }
    else {
        header("Location: /index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/styles.css">
    
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/rrule@5.10.1/main.global.min.js" type='module'></script>
    <script src="https://cdn.jsdelivr.net/npm/rrule@2.6.8/dist/es5/rrule.min.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        #calendar {
        max-width: 900px;
        margin: 0 auto;
        }
    </style>

    <title>Admin panel</title>

</head>
<body>
    <a href="#" onclick="addNews()" id="addNews">Dodaj nowość</a>

    <a href="#" onclick="apartments_list()" id="apartments">Lista mieszkań</a>

    <a href="#" onclick="residents_list()" id="residents">Lista mieszkańców</a>

    <a href="#" onclick="residency_history()" id="history">Historia zamieszkiwania</a>

    <a href="#" onclick="addEvent()" id="event">Dodaj wydarzenie</a>

    <div id="control_window"></div>
        
    <div id="notification" style="display: none; background: #f8d7da; color: #721c24; padding: 10px; margin-top: 10px;"></div>

    <div id='calendar'></div>

    <div id="eventModal" style="display:none;">
        <div>
            <span id="closeModal">&times;</span>
            <h2>Dodaj wydarzenie</h2>
            <label>Data (YYYY-MM-DD):</label>
            <input type="text" id="dateInput" placeholder="Wpisz datę"><br>
            <label>Nazwa:</label>
            <input type="text" id="nameInput" placeholder="Wpisz nazwę wydarzenia"><br>
            <label>Czas początku (HH:MM):</label>
            <input type="text" id="startTimeInput" placeholder="Wpisz czas początku"><br>
            <label>Czas zakończenia (HH:MM) - opcjonalnie:</label>
            <input type="text" id="endTimeInput" placeholder="13:00"><br>
            <div id="errorMessage" style="color: red;"></div>
            <button id="submitEvent">Dodaj wydarzenie</button>
        </div>
    </div>


    <script type='module'>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    center: 'addEventButton'
                },
                customButtons: {
                    addEventButton: {
                        text: 'add event...',
                        click: function() {
                            var dateStr = prompt('Wprowadź datę w formacie YYYY-MM-DD');
                            var datePattern = /^\d{4}-\d{2}-\d{2}$/;
                            var timePattern = /^\d{2}:\d{2}$/;

                            if (!datePattern.test(dateStr)) {
                                alert("Zły format daty. Wykorzystaj YYYY-MM-DD.");
                                return;
                            }

                            var currentDate = new Date();
                            var maxDate = new Date();
                            maxDate.setFullYear(currentDate.getFullYear() + 5);

                            var eventDate = new Date(dateStr + 'T00:00:00'); // Время по умолчанию

                            if (eventDate < currentDate) {
                                alert("Nie można planować wydarzenia na minione dni");
                                return;
                            }

                            if (eventDate > maxDate) {
                                alert("Data jest zbyt odległa");
                                return;
                            }

                            var startTime = null;
                            var endTime = null;

                            if (confirm('Chcesz wpisać konkretny czas?')) {
                                startTime = prompt('Wprowadź czas w formacie HH:MM (24H)');
                                if (!timePattern.test(startTime)) {
                                    alert("Zły format czasu. Wykorzystaj HH:MM.");
                                    return;
                                }

                                if (confirm('Chcesz wpisać konkretny czas zakończenia?')) {
                                    endTime = prompt('Wprowadź czas w formacie HH:MM (24H)');
                                    if (!timePattern.test(endTime)) {
                                        alert("Zły format czasu zakończenia. Wykorzystaj HH:MM.");
                                        return;
                                    }
                                }
                            }

                            var eventStart = new Date(dateStr + 'T' + (startTime || '00:00') + ':00');
                            var eventEnd = endTime ? new Date(dateStr + 'T' + endTime + ':00') : new Date(eventStart.getTime() + 60 * 60 * 1000);

                            if (eventEnd <= eventStart) {
                                alert("Data zakończenia nie może być wcześniej niż rozpoczęcia");
                                return;
                            }

                            var name = prompt('Wprowadź nazwę wydarzenia');
                            if (!name) {
                                alert("Nazwa wydarzenia jest wymagana");
                                return;
                            }

                            calendar.addEvent({
                                title: name,
                                start: eventStart,
                                end: eventEnd,
                                allDay: false
                            });

                            alert('Great. Now, update your database...');

                            const formData = new FormData();
                            formData.append('name', name);
                            formData.append('startTime', eventStart.toISOString());
                            formData.append('endTime', eventEnd.toISOString());

                            const xhttp = new XMLHttpRequest();
                            xhttp.onload = function() {
                                if (xhttp.status === 200) {
                                    alert('Event successfully added to the database!');
                                } else {
                                    alert('Error adding event to the database.');
                                }
                            };
                            xhttp.open('POST', 'ajax/events/add.php');
                            xhttp.send(formData);
                        }
                    }
                }
                ,
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
  
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="./js/admin-script.js"></script>
</body>
</html>