function manageResidents() {
    const xhttp = new XMLHttpRequest();

    xhttp.onload = function() {
        document.getElementById('control_window').innerHTML = this.responseText;

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
            xhttp.open("POST", "ajax/owner-panel/add_resident_to_apartment.php", true);
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
                console.log(this.responseText);
                const response = JSON.parse(this.responseText);
                if (response.success) {
                    alert('Użytkownika usunięto');
                    apartments_list();
                }
                else {
                    alert(response.message);
                }
            }
            xhttp.open("POST","ajax/owner-panel/remove_resident_from_apartment.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(params.toString());
        });
    };
    xhttp.open('GET', 'ajax/owner-panel/manage_residents.php');
    xhttp.send();
}

function residency_history() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        document.getElementById('control_window').innerHTML = this.response;
    };
    xhttp.open("GET", "/ajax/owner-panel/residency_history/get_list.php");
    xhttp.send();
}