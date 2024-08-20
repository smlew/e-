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

function addEvent() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {

        const response = JSON.parse(this.responseText);
        const controlWindow = document.getElementById('control_window');
        controlWindow.innerHTML = ''; // очищаем содержимое элемента

        // Создаем таблицу
        const table = document.createElement('table');
        table.style.width = '100%';
        table.border = '1';

        // Создаем заголовок таблицы
        const header = table.createTHead();
        const headerRow = header.insertRow(0);

        // Добавляем заголовки
        const headers = ['ID', 'Title', 'Start', 'End', 'Description', 'Freq', 'Byweekday'];
        headers.forEach((headerText, index) => {
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
                event.id || '',
                event.title || '',
                event.start || '',
                event.end || '',
                event.description || '',
                event.rrule.freq || '',
                event.rrule.byweekday || ''
            ];

            cells.forEach(cellText => {
                const cell = row.insertCell();
                cell.appendChild(document.createTextNode(cellText));
            });
        });

        // Добавляем таблицу в controlWindow
        controlWindow.appendChild(table);
    }
    xhttp.open("GET", "/ajax/events/get_events.php");
    xhttp.send();
}

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
            xhttp.setRequestHeader("Content-type", "application/x-www-urlencoded");
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
            document.getElementById('control_window').innerHTML = this.response;

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