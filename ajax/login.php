<?php
    include(dirname(__DIR__,1)."/config.php");

    function login($mysqli, $username, $password) {
        // Проверка имени пользователя в базе данных
        $sql = "SELECT * FROM users WHERE username = ? LIMIT 1";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
    
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
    
        if ($result->num_rows == 1) {
            $salt = $row['salt']; // Получение соли из базы данных
            // Проверка пароля с солью
            if (password_verify($password . $salt, $row['password'])) {
                // Успешная проверка пароля
                $_SESSION['logged']   = true;
                $_SESSION['user_id']  = $row['id'];
                $_SESSION['username'] = $username;
    
                // Проверка, является ли пользователь администратором
                $sql_admin = "SELECT address_id FROM administrators WHERE user_id = ?";
                $stmt_admin = $mysqli->prepare($sql_admin);
                $stmt_admin->bind_param("i", $row['id']);
                $stmt_admin->execute();
    
                $result_admin = $stmt_admin->get_result();
                $row_admin = $result_admin->fetch_assoc();
    
                if ($result_admin->num_rows == 1) {
                    $_SESSION['admin']      = true;
                    $_SESSION['address_id'] = $row_admin['address_id']; // Привязка к блоку администратора
                } else {
                    $_SESSION['admin'] = false;
                }
    
                // Если пользователь не администратор, определяем его квартиру и address_id
                if (!$row_admin && $row['apartment_id']) {
                    $apartment_id = $row['apartment_id'];
                    $sql_apartment = "SELECT address_id FROM apartments WHERE id = ? LIMIT 1";
                    $stmt_apartment = $mysqli->prepare($sql_apartment);
                    $stmt_apartment->bind_param("i", $apartment_id);
                    $stmt_apartment->execute();
    
                    $result_apartment = $stmt_apartment->get_result();
                    $row_apartment = $result_apartment->fetch_assoc();
    
                    if ($result_apartment->num_rows == 1) {
                        $_SESSION['address_id'] = $row_apartment['address_id']; // Привязка к адресу квартиры
                    }
                }

                $sql = 'SELECT owner FROM apartments WHERE owner = ?';
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param('i', $_SESSION['user_id']);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();

                if ($row) {
                    $_SESSION['owner'] = true;
                } 
    
                die(true); // Успешный вход
            } else {
                die(false); // Неверный пароль
            }
        } else {
            die(false); // Пользователь не найден
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
                
                die('ok');
            } else {
                die ('user');
            }
        } else {
            die (false);
        }
    }

?>