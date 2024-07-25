<?php
    include(dirname(__DIR__,1)."/config.php");

    function login($mysqli, $username, $password) {
        // Sprawdzanie nazwy użytkownika i hasła w bazie danych
        $sql = "SELECT * FROM users WHERE username = ? LIMIT 1";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $username); // Powiązanie parametrów zapytania ze zmiennymi
        $stmt->execute();

        $result = $stmt->get_result(); // Uzyskiwanie wyniku zapytania
        $row = $result->fetch_assoc(); // Pobieranie tablicy asocjacyjnej z wynikiem zapytania


        if ($result->num_rows == 1) {
            $salt = $row['salt']; // Wyodrębnianie soli z wyniku zapytania
            if (password_verify($password . $salt, $row['password'])) {
                // Po pomyślnym zalogowaniu skonfiguruj sesję i przekieruj użytkownika na bezpieczną stronę
                $_SESSION['logged']     = true;
                $_SESSION['user_id']    = $row['id'];
                $_SESSION['username']   = $username; // Zapisujemy imię i id użytkownika do sesji
                if ($row['admin'])      { $_SESSION['admin'] = true; }
                else                    { $_SESSION['admin'] = false; }

                die(true);
            } else {
                die(false);
            }
        } else {
            die(false);
        }
    }

    
    if(isset($_POST['username']) && $_POST['username'] != ""){
        $username = $_POST["username"];
        $password = $_POST["password"];

        login($mysqli, $username, $password);
    }

    else if (isset($_POST['reg_username'])){
        
        if($_POST['reg_pass'] == $_POST['reg_pass_repeat']){
            
            $username = $_POST["reg_username"];
            $password = $_POST["reg_pass"];
            $name = $_POST["reg_name"];
            $last_name = $_POST["reg_last_name"];
            $email = $_POST["reg_email"];
            $sql = "SELECT username FROM users WHERE username = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if($result -> num_rows == 0){
                
                $salt = bin2hex(random_bytes(16));
                $hashed_password = password_hash($password . $salt, PASSWORD_DEFAULT);
                
                $query = "INSERT INTO users (username, password, email, salt, name, last_name) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $mysqli->prepare($query);
                
                $stmt->bind_param("ssssss", $username, $hashed_password, $email, $salt, $name, $last_name);
                
                $stmt->execute();

                echo($stmt->execute());
                
                die('ok');

            } else {
                die ('user');
                // $url = $currentURL . "?userExists=" . urlencode(true);
                // header("Location: $url");
            }
        } else {
            die (false);
        }
    }

?>