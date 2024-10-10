
var calendarEl = document.getElementById('calendarEl');

function closeModal() {
    document.getElementById('eventModal').style.display = 'none';
    
}
window.onclick = function(event) {

    var modal = document.getElementById("eventModal");
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
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
                    maxDate.setFullYear(currentDate.getFullYear() + 1);

                    var eventDate = new Date(dateStr + 'T00:00:00');

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
                            alert("Zły формат czasu. Wykorzystaj HH:MM.");
                            return;
                        }

                        if (confirm('Chcesz wpisać konkretny czas zakończenia?')) {
                            endTime = prompt('Wprowadź czas w formacie HH:MM (24H)');
                            if (!timePattern.test(endTime)) {
                                alert("Zły формат czasu zakończenia. Wykorzystaj HH:MM.");
                                return;
                            }
                        }
                    }

                    var eventStart = new Date(dateStr + ' ' + (startTime || '00:00'));
                    var eventEnd = endTime ? new Date(dateStr + ' ' + endTime) : new Date(eventStart.getTime());

                    if (eventEnd < eventStart) {
                        alert("Data zakończenia nie może być wcześniej niż rozpoczęcia");
                        return;
                    }

                    var name = prompt('Wprowadź nazwę wydarzenia');
                    if (!name) {
                        alert("Nazwa wydarzenia jest wymagana");
                        return;
                    }

                    var description = prompt('Wprowadź opis wydarzeenia');

                    const formData = new FormData();
                    formData.append('name', name);
                    formData.append('description', description);
                    formData.append('startTime', eventStart.toISOString().slice(0, 19).replace('T', ' '));
                    formData.append('endTime', eventEnd.toISOString().slice(0, 19).replace('T', ' '));
                    
                    const xhttp = new XMLHttpRequest();
                    xhttp.onload = function() {
                        if (xhttp.status === 200) {
                            calendar.addEvent({
                                title: name,
                                start: eventStart,
                                end: eventEnd,
                                description: description
                            });

                            calendar.refetchEvents();
                        } else {
                            alert(this.responseText);
                        }
                    };
                    xhttp.open('POST', 'ajax/events/add.php');
                    //xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencode');
                    xhttp.send(formData);
                }
            }
        },
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
                        end: info.event.end
                    };
                    calendar.addEvent(eventCopy);

                });
                return false;
            }
        },
        eventClick: function(info) {
                document.getElementById('eventTitle').innerText = info.event.title;
                document.getElementById('eventStart').innerText = info.event.start.toLocaleString();
                document.getElementById('eventEnd').innerText = info.event.end ? info.event.end.toLocaleString() : '';
                document.getElementById('eventDescription').innerText = info.event.extendedProps.description || 'Brak opisu';
                document.getElementById('eventModal').style.display = 'block';
            },
        });
        calendar.render();
