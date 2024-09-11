const triggerTabList = document.querySelectorAll('#myTab button')
triggerTabList.forEach(triggerEl => {
    const tabTrigger = new bootstrap.Tab(triggerEl)

    triggerEl.addEventListener('click', event => {
        event.preventDefault()
        tabTrigger.show()
    })
})

function addNews() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        document.getElementById('control_window').innerHTML = this.response;
        $('#upload_news').off('submit').on('submit', (function(event) {
            event.preventDefault();
            var form = document.getElementById('upload_news');
            var formData = new FormData(form);
            $.ajax ({
                type: 'POST',
                url: '/ajax/admin-panel/news/upload_news.php',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response == 'ok') {
                        
                        document.getElementById('info_output_news').innerHTML = 'Nowość została pomyślnie dodana do bazy danych';
                    }
                    else {
                        document.getElementById('info_output_news').innerHTML = response;
                    }
                }
            });
        }));
    };
    xhttp.open("GET", "ajax/admin-panel/news/upload_news_form.php");
    xhttp.send();
}

function loadIssues() {
    const xhttp = new XMLHttpRequest();

    xhttp.onload = function() {
        const issues = JSON.parse(this.response);


        const controlWindow = document.getElementById('control_window');
        controlWindow.innerHTML = '';
        
        const table = document.createElement('table');
        const tbodyCreate = document.createElement('tbody');

        const h2 = document.createElement('h2');
        h2.innerHTML = "Lista usterek";

        table.className = "table table-striped table-hover";

        table.appendChild(tbodyCreate);
        controlWindow.appendChild(h2);
        controlWindow.appendChild(table);

        const tbody = table.getElementsByTagName('tbody')[0];
        tbody.innerHTML = '';

        const header = table.createTHead();
        const headerRow = header.insertRow(0);

        const headers = ['Mieszkanie', 'Opis', 'Data zgłoszenia', 'Status', 'Odznaczyć'];
        headers.forEach((headerText) => {
            const th = document.createElement('th');
            th.appendChild(document.createTextNode(headerText));
            headerRow.appendChild(th);
        });

        issues.forEach(issue => {
            const row = tbody.insertRow();

            row.insertCell(0).innerText = issue.number + (issue.letter ? issue.letter : '');
            row.insertCell(1).innerText = issue.descriptionL;
            row.insertCell(2).innerText = issue.created_at;
            row.insertCell(3).innerText = issue.status;

            row.onclick = (function () { viewIssue(issue.id); });

            const actionCell = row.insertCell(4);

            if (issue.status !== 'resolved') {
                const resolveBtn = document.createElement('button');
                resolveBtn.innerText = 'Oznacz jako naprawione';
                resolveBtn.onclick = (function (event) {
                    event.stopPropagation();
                    resolveIssue(issue.id);
                });
                actionCell.appendChild(resolveBtn);
            }
            tbody.appendChild(row);
        })



    };
    xhttp.open('GET', 'ajax/admin-panel/reports/get_reports.php', true);
    xhttp.send();
}

function viewIssue(id) {
    alert(id);
}

function resolveIssue(id) {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        alert(this.responseText);
    };
    xhttp.open('POST', 'ajax/admin-panel/reports/resolve.php', true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
    xhttp.send('id=' + encodeURIComponent(id));
}

function payments() {
    const controlWindow = document.getElementById('control_window');
    controlWindow.innerHTML = '';

    const header = document.createElement('h2');
    header.innerHTML = "Lista opłat";

    const searchForm = document.createElement('form');
    searchForm.id = 'searchForm';
    searchForm.method = 'get';

    const inputSearch = document.createElement('input');
    inputSearch.type = 'text';
    inputSearch.name = 'query';
    inputSearch.placeholder = 'Wyszukaj mieszkanie';

    const inputButton = document.createElement('input');
    inputButton.type = 'submit';
    inputButton.value = 'Szukaj';

    const buttonShow = document.createElement('button');
    buttonShow.innerHTML = 'Pokaż wszystkie mieszkania';
    buttonShow.onclick = function(event) {
        event.preventDefault();
        loadPayments(null, checkBox.checked ? 'no' : 'all');
    };

    const checkBox = document.createElement('input');
    checkBox.type = 'checkbox';
    checkBox.id = 'paid';
    checkBox.checked = false;

    const labelShow = document.createElement('label');
    labelShow.htmlFor = 'paid';
    labelShow.innerHTML = 'Pokaż tylko nieopłacone'



    const table = document.createElement('div');
    table.id = 'tableWindow';

    controlWindow.appendChild(header);
    controlWindow.appendChild(searchForm);
    searchForm.appendChild(inputSearch);
    searchForm.appendChild(inputButton);
    controlWindow.appendChild(checkBox);
    controlWindow.appendChild(labelShow);
    controlWindow.appendChild(document.createElement('br'))
    controlWindow.appendChild(buttonShow);

    controlWindow.appendChild(table);

    
    searchForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const query = event.target.query.value;
        if (query === '') {
            loadPayments(null, checkBox.checked ? 'no' : 'all');
        }
        else {
            loadPayments(query, checkBox.checked ? 'no' : 'all');
        }
        
    });

    loadPayments(null, checkBox.checked ? 'no' : 'all');
}

function loadPayments(number = null, paid, currentMonthYear = new Date().toISOString().substring(0, 7) + '-01') {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        const payments = JSON.parse(this.responseText);

        const controlWindow = document.getElementById('tableWindow');
        controlWindow.innerHTML = '';

        const table = document.createElement('table');
        const tbodyCreate = document.createElement('tbody');

        table.className = "table table-striped table-hover";
        
        table.appendChild(tbodyCreate);
        controlWindow.appendChild(table);
        
        const tbody = table.getElementsByTagName('tbody')[0];
        tbody.innerHTML = '';

        const header = table.createTHead();
        const headerRow = header.insertRow(0);

        const headers = ['Numer mieszkania', 'Kwota', 'Miesiąc zapłaty', 'Data zapłaty', 'Status', 'Odznaczyć'];
        headers.forEach((headerText) => {
            const th = document.createElement('th');
            th.appendChild(document.createTextNode(headerText));
            headerRow.appendChild(th);
        });

        payments.forEach(payment => {
            const row = tbody.insertRow();

            row.insertCell(0).innerText = payment.number;
            row.insertCell(1).innerText = payment.amount;

            const date = new Date(payment.month_year);
            const options = { year: 'numeric', month: 'long' };
            const formattedMonthYear = date.toLocaleString('pl-PL', options);

            row.insertCell(2).innerText = formattedMonthYear;
            row.insertCell(3).innerText = payment.payment_date || ' - ';

            if (payment.status == 'overdue') {
                row.insertCell(4).innerText = 'Zaległość';
            }
            else if (payment.status == 'paid') {
                row.insertCell(4).innerText = 'Opłacono';
            }
            else { row.insertCell(4).innerText = 'Nie opłacono'; }

            const actionCell = row.insertCell(5);
            if (payment.status !== 'paid') {
                const payButton = document.createElement('button');
                payButton.innerText = 'Odznaczyć jako opłacono';
                payButton.onclick = function () {
                    updatePaymentStatus(payment.id);
                };
                actionCell.appendChild(payButton);
            }
        });
    };
    xhttp.open('GET', 'ajax/admin-panel/payments/get_list.php?number=' + number + '&paid=' + paid, true);
    xhttp.send();
}

function updatePaymentStatus(paymentId) {
    alert(paymentId);
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        if (this.response.success) {
            loadPayments(null, checkBox.checked ? 'all' : 'no');
        } else {
            alert(this.responseText);
        }
    };
    xhttp.open('POST', 'ajax/admin-panel/payments/update_status.php', true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send('id=' + paymentId);
}


function addEvent() {

    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        const controlWindow = document.getElementById('control_window');
        controlWindow.innerHTML = ''; // очищаем содержимое элемента
        
        
        const response = JSON.parse(this.responseText);

        const divCalendar = document.createElement('div');
        divCalendar.id = 'calendar';
        controlWindow.appendChild(divCalendar);
        
        const xhttpCalendar = new XMLHttpRequest();
        xhttpCalendar.onload = function () {
            if (xhttpCalendar.status === 200) {
                document.getElementById('calendar').innerHTML = this.responseText;
        
                // Инициализация календаря
                const script = document.createElement('script');
                script.src = 'js/calendar-init.js';
                document.head.appendChild(script);
            } else {
                console.error("Błąd: " + xhttpCalendar.statusText);
            }
        };
        xhttpCalendar.open('GET', 'ajax/events/get_calendar.php', true);
        xhttpCalendar.send();

        // Создаем таблицу
        const table = document.createElement('table');

        table.className = "table table-striped table-hover";

        // Создаем заголовок таблицы
        const header = table.createTHead();
        const headerRow = header.insertRow(0);

        // Добавляем заголовки
        const headers = ['Nazwa', 'Początek', 'Koniec', 'Opis', 'Częstotliwość', 'Dni', 'Usuń'];
        headers.forEach((headerText) => {
            const th = document.createElement('th');
            th.appendChild(document.createTextNode(headerText));
            headerRow.appendChild(th);
        });

        // Создаем тело таблицы
        const tbody = document.createElement('tbody');
        table.appendChild(tbody);

        // Добавляем строки данных
        response.forEach(event => {
            const row = tbody.insertRow();

            // Заполняем строки
            const cells = [
                event.title || '',
                event.start || '',
                event.end || '',
                event.description || '',
                event.rrule?.freq || '',
                event.rrule?.byweekday || ''
                
            ];

            cells.forEach(cellText => {
                const cell = row.insertCell();
                cell.appendChild(document.createTextNode(cellText));
            });

            const deleteCell = row.insertCell();
            const deleteButton = document.createElement('i');
            deleteButton.className = 'fas fa-times delete';
            deleteButton.addEventListener('click', function() {
                if (confirm('Czy jesteś pewien że chcesz usunąć to wydarzenie?')) {
                    const xhttp = new XMLHttpRequest();
                    xhttp.onload = function() {
                        if (xhttp.status == 200) {
                            alert('Usunięcie powiodło się');
                            addEvent();
                        } else {
                            alert('Usunięcie nie powiodło się');
                        }
                    }
                    xhttp.open('POST', 'ajax/events/delete.php');
                    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    xhttp.send('id=' + encodeURIComponent(event.id));
                }
            });
            deleteCell.appendChild(deleteButton);
        });

        // Добавляем таблицу в controlWindow
        controlWindow.appendChild(table);
    }
    xhttp.open("GET", "/ajax/events/get_events.php");
    xhttp.send();
}

window.addEvent = addEvent;

function showNotification(message, type = 'error') {
    const notification = document.getElementById('notification');
    notification.style.display = 'block';
    notification.style.background = type === 'success' ? '#d4edda' : '#f8d7da';
    notification.style.color = type === 'success' ? '#155724' : '#721c24';
    notification.innerHTML = message;

    setTimeout(() => {
        notification.style.display = 'none';
    }, 3000);
}

function get_resident_list() {
    const xhttpGetList = new XMLHttpRequest();

    xhttpGetList.onload = function() {
        document.getElementById('resident_list_wrapper').innerHTML = this.responseText;
    }
    var ajaxPath = "/ajax/admin-panel/residents/get_list.php";
    xhttpGetList.open("GET", ajaxPath);
    xhttpGetList.send();
}

function residents_list() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        document.getElementById("control_window").innerHTML = this.response;
        get_resident_list();
        
        document.getElementById("resident_search").addEventListener('submit', function(event) {
            event.preventDefault();

            const query = event.target.query.value;

            const xhttp = new XMLHttpRequest();
            xhttp.onload = function () {
                document.getElementById("resident_list_wrapper").innerHTML = this.response;
            };
            xhttp.open('GET', '/ajax/admin-panel/residents/search.php?query=' + encodeURIComponent(query), true);
            xhttp.send();
        });

        document.getElementById("addResidentToApartment").addEventListener('submit', function(event) {
            event.preventDefault();
            const xhttp = new XMLHttpRequest;

            const form = document.getElementById("addResidentToApartment");
            const formData = new FormData(form);

            const params = new URLSearchParams;

            formData.foreach((value, key) => {
                params.append(key, value);
            })

            xhttp.onload = function() {
                const response = JSON.parse(this.responseText);

                if (response.success) {
                    residents_list();
                }

                else {
                    document.getElementById("output_info_add").innerHTML = response.message;
                }
            }
            xhttp.open("POST","ajax/admin-panel/residents/add_resident_to_apartment.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(params.toString());
        });
    }
    xhttp.open("GET", "/ajax/admin-panel/residents/list.php");
    xhttp.send();
}

function get_apartments_list(settled='a') {
    const xhttpGetList = new XMLHttpRequest;

    xhttpGetList.onload = function () {
        document.getElementById('apartments_list_wrapper').innerHTML = this.responseText;
    }
    var ajaxPath = "ajax/admin-panel/apartments/get_list.php?settled=";
    if      (settled == 's') { ajaxPath += "s"; }
    else if (settled == 'u') { ajaxPath += "u"; }
    else                     { ajaxPath += "a"; }
    xhttpGetList.open("GET", ajaxPath, true);
    xhttpGetList.send();
}

function apartments_list() {
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState === 4 && xhttp.status === 200) {
            document.getElementById('control_window').innerHTML = this.responseText;

            get_apartments_list('a');

            document.getElementById('searchForm').addEventListener('submit', function(event) {
                event.preventDefault();
                const query = event.target.query.value;
                
                const xhttp = new XMLHttpRequest();
                xhttp.onload = function() {
                    document.getElementById('apartments_list_wrapper').innerHTML = this.responseText;
                };
                xhttp.open("GET", "/ajax/admin-panel/apartments/search.php?query=" + encodeURIComponent(query), true);
                xhttp.send();
            });

            document.getElementById('addApartment').addEventListener('submit', function(event) {
                event.preventDefault();

                let isValid = true;

                const xhttp = new XMLHttpRequest;
                
                const form = document.getElementById("addApartment");
                const formData = new FormData(form);

                const number = event.target.number.value;
                const floor = event.target.floor.value;

                if (!/^\d+$/.test(number)) {
                    isValid = false;
                    alert("Numer mieszkania ma być liczbą");
                }

                if (!/^\d+$/.test(number)) {
                    isValid = false;
                    alert("Piętro ma być liczbą");
                }


                if (isValid) {
                    // Przetwarzamy FormData w URL-kodowany ciąg
                    const params = new URLSearchParams();
                    formData.forEach((value, key) => {
                        params.append(key, value);
                    });

                    xhttp.onload = function () {
                        const response = JSON.parse(this.responseText);
                        if(response.success){
                            apartments_list();
                        }
                        else {
                            document.getElementById("output_info_add").innerHTML = response.message;
                        }
                    };
                    xhttp.open("POST", "/ajax/admin-panel/apartments/add.php", true);
                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhttp.send(params.toString());
                }
            });
        }
    }
    xhttp.open("GET", "/ajax/admin-panel/apartments/list.php");
    xhttp.send();
}

function residency_history() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        document.getElementById('control_window').innerHTML = this.response;
        document.getElementById('searchHistoryForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const query = event.target.query.value;

            const serachXhttp = new XMLHttpRequest();
            serachXhttp.onload = function() {
                document.getElementById("search_result").innerHTML = this.responseText;
            };
            serachXhttp.open("GET", "/ajax/admin-panel/residency_history/get_list.php?query=" + encodeURIComponent(query), true);
            serachXhttp.send();
        });
    };
    xhttp.open("GET", "/ajax/admin-panel/residency_history/list.php");
    xhttp.send();
}

function deleteApartment(id) {
    const xhttp = new XMLHttpRequest();
    
    xhttp.onload = function() {
        if (this.status >= 200 && this.status < 300) {
            try {
                const response = JSON.parse(this.responseText);
                if (response.success) {
                    apartments_list(); // Обновляем список квартир после удаления
                } else {
                    document.getElementById("output_info_delete").innerHTML = 'Błąd usunięcia rekordu: ' + response.message;
                }
            } catch (e) {
                document.getElementById("output_info_delete").innerHTML = 'Błąd przetwarzania odpowiedzi serwera';
            }
        } else {
            document.getElementById("output_info_delete").innerHTML = 'Błąd usunięcia rekordu: ' + this.responseText;
        }
    };

    xhttp.open("POST", "/ajax/admin-panel/apartments/delete.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id=" + encodeURIComponent(id));
}

function openResidentModal(id) {
    var modal = document.getElementById("myModal");
    var modalBody = document.getElementById("modal-body");
    var xhr = new XMLHttpRequest();
    
    xhr.onload = function() {
        if (xhr.status === 200) {
            modalBody.innerHTML = xhr.responseText;
            modal.style.display = "block";

            document.getElementById("update_resident_modal").addEventListener('submit', function(event) {
                event.preventDefault();
                const xhttp = new XMLHttpRequest();
                const form = document.getElementById("update_resident_modal");
                const formData = new FormData(form);

                const params = new URLSearchParams();

                formData.forEach((value, key) => {
                    params.append(key, value);
                });

                xhttp.onload = function () {
                    const response = JSON.parse(this.responseText);
                    if (response.success) {
                        document.getElementById().innerHTML = this.responseText;
                    }
                    
                    
                };

                xhttp.open("POST", "ajax/admin-panel/residents/update.php", true)
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send(params.toString());
            });
        }

        var span = document.getElementsByClassName("close")[0];
        span.onclick = function() {
            var modal = document.getElementById("myModal");
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            var modal = document.getElementById("myModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    };
    xhr.open('GET', '/ajax/admin-panel/residents/get.php?id=' + id, true);
    xhr.send();
}

function openApartmentModal(id) {
    var modal = document.getElementById("myModal");
    var modalBody = document.getElementById("modal-body");
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/ajax/admin-panel/apartments/get.php?id=' + id, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            modalBody.innerHTML = xhr.responseText;
            modal.style.display = "block";

            document.getElementById("update_apartment_modal").addEventListener('submit', function(event) {
                event.preventDefault();

                const xhttp = new XMLHttpRequest();
                const form = document.getElementById("update_apartment_modal");
                const formData = new FormData(form);

                const params = new URLSearchParams();
                formData.forEach((value, key) => {
                    params.append(key, value);
                });

                xhttp.onload = function () {
                    const response = JSON.parse(this.responseText);
                    if (response.success) {
                        apartments_list(); // Обновление списка квартир после успешного обновления
                    } else {
                        document.getElementById("output_info_update").innerHTML = response.message;
                    }
                };

                xhttp.open("POST", "ajax/admin-panel/apartments/update.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send(params.toString());
            });

            document.getElementById("add_resident_form").addEventListener('submit', function(event) {
                event.preventDefault();
                const form = document.getElementById("add_resident_form");
                const formData = new FormData(form);
                const params = new URLSearchParams();

                formData.forEach((value, key) => {
                    params.append(key, value);
                })

                const xhttp = new XMLHttpRequest;
                xhttp.onload = function () {
                    const response = JSON.parse(this.responseText);

                    if (response.success) {
                        alert('Użytkownika dodano');
                        apartments_list();
                    }
                    else {
                        alert(response.message);
                    }
                }
                xhttp.open("POST", "ajax/admin-panel/residents/add_resident_to_apartment.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send(params.toString());
            });

            document.getElementById('remove_resident_form').addEventListener('submit', function (event) {
                event.preventDefault();
                const form = document.getElementById('remove_resident_form');
                const formData = new FormData(form);
                const params = new URLSearchParams();
                formData.forEach((value, key) => {
                    params.append(key, value);
                });

                const xhttp = new XMLHttpRequest;
                xhttp.onload = function () {
                    const response = JSON.parse(this.responseText);
                    if (response.success) {
                        alert('Użytkownika usunięto');
                        apartments_list();
                    }
                    else {
                        alert(response.message);
                    }
                }
                xhttp.open("POST","ajax/admin-panel/residents/remove_resident_from_apartment.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send(params.toString());
            });
        }

        var span = document.getElementsByClassName("close")[0];
        span.onclick = function() {
            var modal = document.getElementById("myModal");
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            var modal = document.getElementById("myModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    };
    xhr.send();
}

function closeAddModal() {
    var span = document.getElementsByClassName("close")[1];

    span.onclick = function() {
        var addApartmentWindow = document.getElementById("addModal");
        addApartmentWindow.style.display = "none"
        
    }

    window.onclick = function(event) {
        var addApartmentWindow = document.getElementById("addModal");
        if (event.target == addApartmentWindow) {
            addApartmentWindow.style.display = "none";
        }
    }
}