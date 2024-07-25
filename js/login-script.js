function loadLoginWindow() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        document.body.insertAdjacentHTML('afterbegin', this.responseText);
        $('#loginForm').off('submit').on('submit', (function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            if (document.forms['log']['login-label'] == "") {
                alert();
            }
            $.ajax({
                type: 'POST',
                url: 'ajax/login.php',
                data: formData,
                success: function(response) {
                    if (response) {
                        window.location.href = "";
                    }
                    else {
                        document.getElementById("errorContainerLog").innerHTML = "Błędny login lub hasło";
                    }
                }
            });
        }));
        $('#registrationForm').off('submit').on('submit', (function(event) {

            if (document.forms['reg']['reg_pass'].value == document.forms['reg']['reg_pass_repeat'].value) {
                event.preventDefault();
                var formData = $(this).serialize();
                
                $.ajax({
                    type: 'POST',
                    url: 'ajax/login.php',
                    data: formData,
                    success: function(response) {
                        //document.getElementById("errorContainerReg").innerHTML = this.responseText;
                        if (response == 'ok') {
                            
                            document.getElementById("errorContainerReg").innerHTML = "Pomyślnie zarejestrowano, możesz się zalogować";
                        }
                        else if (response == 'user') {
                            document.getElementById("errorContainerReg").innerHTML = "Użytkownik o takim loginie już istnieje";
                        }
                    }
                });
            }
            else {
                event.preventDefault();
                document.getElementById ("errorContainerReg").innerHTML = "Hasła nie są takie same";
            }
        }));
    };
    xhttp.open("GET", "/ajax/login_form.php");
    xhttp.send();
}

function hideLoginWindow() {
    document.querySelector('.login').style.display = 'none';
    document.querySelector('.registration').style.display = 'none';
    document.querySelector('.login-window').style.display = 'none';
}

function showRegistration() {
    document.querySelector('.login').style.display = 'none';
    document.querySelector('.registration').style.display = 'block';
}

function showLogin() {
    document.querySelector('.registration').style.display = 'none';
    document.querySelector('.login').style.display = 'block';
}
