    <div class="login">

        <h1>Logowanie</h1>
        <p>Podaj login oraz hasło</p>

        <form id="loginForm" name="log" method="POST">
            <input type="text" class="login-label" name="username" placeholder="Login">
            <input type="password" class="password-label" name="password" placeholder="Hasło">
            <div class="confirm-button">
                <button class="confirm" type="submit">Zaloguj</button>
            </div>
        </form>
        <div id="errorContainerLog"></div>
        <p>Nie masz konta? <a href="#" onclick="showRegistration()">Zarejestruj się</a></p> 
    </div>

    <div class="registration"> 

        <h1>Rejestracja</h1>
        <p>Podaj login oraz hasło</p>

        <form name="reg" id="registrationForm" method="POST">
            <input type="text" class="login-label" name="reg_username" placeholder="Login">
            <input type="password" class="password-label" name="reg_pass" placeholder="Hasło">
            <input type="password" class="password-confirm-label" name="reg_pass_repeat" placeholder="Potwierdź hasło">
            <input type="text" class="name-label" name="reg_name" placeholder="Imię">
            <input type="text" class="last-name-label" name="reg_last_name" placeholder="Nazwisko">
            <input type="text" class="email-label" name="reg_email" placeholder="Email">
            
            <div class="confirm-button">
                <button class="confirm" type="submit">Zarejestruj</button>
            </div>
        </form>
        <div id="errorContainerReg"></div>
        <p>Masz już konto? <a href="#" onclick="showLogin()">Zaloguj się</a></p> 
    </div>
    <div class="login-window" onClick="hideLoginWindow()"> </div>