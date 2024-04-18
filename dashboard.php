<?php
// Подключение к базе данных
$conn = new mysqli("localhost", "root", "1010", "e-osiedle");

// Проверка соединения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// if (!isset($_SESSION['username'])) {
//     // Пользователь не авторизован, перенаправляем на страницу входа
//     header("Location: login.php");
//     exit();
// }

// Начало сессии
session_start();

// Обработка выхода (logout)
if(isset($_GET['logout'])) {
    // Удаление всех данных сессии
    session_unset();

    // Уничтожение сессии
    session_destroy();

    // Перенаправление на текущую страницу для предотвращения повторной отправки формы
    header("Location: ".$_SERVER['PHP_SELF']);// PHP_SELF
    exit();
}

// Обработка входных данных при отправке формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение данных из формы и обработка входа
    // ...

    // Проверка и установка сессии
    // ...
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Логин</title>
</head>
<body>

<?php if(isset($_SESSION['username'])) { ?>
    <p>Jesteś zalogowany jako <?php echo $_SESSION['username']; ?>. <a href="?logout">Wyjdź</a></p>
<?php } else { ?>
    <h2>Wejdź</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label>Nazwa użytkownika:</label><br>
        <input type="text" name="username" required><br>
        <label>Hasło:</label><br>
        <input type="password" name="password" required><br><br>
        <input type="submit" value="Wejdź">
    </form>
<?php } ?>
<a href="upload_form.php">Prześlij obraz</a>

</body>
</html>
