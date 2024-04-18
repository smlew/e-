<?php

include("config.php");

if(isset($_GET['logout'])) {
    // Удаление всех данных сессии
    session_unset();

    // Уничтожение сессии
    session_destroy();

    // Перенаправление на текущую страницу для предотвращения повторной отправки формы
    header("Location: ".$_SERVER['PHP_SELF']);// PHP_SELF
    exit();
}

// Przetwarzanie danych wejściowych podczas przesyłania formularza
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение данных из формы
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Sprawdzanie nazwy użytkownika i hasła w bazie danych

    $query = "SELECT salt FROM users WHERE username = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $username); // Powiązanie parametrów zapytania ze zmiennymi
    $stmt->execute();
    $result = $stmt->get_result(); // Uzyskiwanie wyniku zapytania
    $row = $result->fetch_assoc(); // Pobieranie tablicy asocjacyjnej z wynikiem zapytania
    $salt = $row['salt']; // Wyodrębnianie soli z wyniku zapytania

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $mysqli->query($sql);


    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password . $salt, $row['password'])) { //password_verify($password, $row['password']) // $password == $row['password']
            // Вход выполнен успешно, устанавливаем сессию и перенаправляем пользователя на защищенную страницу
            session_start();
            $_SESSION['username'] = $username; // Сохраняем имя пользователя в сессии   
            header("Location: dashboard.php");
            exit();
        } else {
            $error_message = "Nieprawidłowa nazwa użytkownika lub hasło,";
        }
    } else {
        $error_message = "Nieprawidłowa nazwa użytkownika lub hasło";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

<?php if(isset($error_message)) { ?>
    <div><?php echo $error_message; ?></div>
<?php } ?>

<?php if(!isset($_SESSION['username'])) { ?>
    <h2>Zalogować się</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label>Imię użytkownika:</label><br>
        <input type="text" name="username" required><br>
        <label>Hasło:</label><br>
        <input type="password" name="password" required><br><br>
        <input type="submit" value="Wejdź">
    </form>
    <a href="sign-in.php">Zarejestruj się</a>
<?php } else { ?>
    <p>Już jesteś zalogowany w systemie jako: <?php echo $_SESSION['username']; ?>. <a href="?logout">Wyjdź</a></p>
<?php } ?>

</body>
</html>
