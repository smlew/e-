    var calendarEl = document.getElementById('calendarEl');
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

                    var eventStart = new Date(dateStr + ' ' + (startTime || '00:00') + ':00');
                    var eventEnd = endTime ? new Date(dateStr + ' ' + endTime + ':00') : new Date(eventStart.getTime());

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
                    formData.append('startTime', eventStart.toISOString());
                    formData.append('endTime', eventEnd.toISOString());

                    const xhttp = new XMLHttpRequest();
                    xhttp.onload = function() {
                        if (xhttp.status === 200) {
                            window.addEvent();
                            // Обновите календарь после добавления события
                            calendar.refetchEvents();
                        } else {
                            alert(this.responseText);
                        }
                    };
                    xhttp.open('POST', 'ajax/events/add.php');
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
        }
    });
    calendar.render();
