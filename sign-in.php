<?php
include("config.php");

// Проверка, была ли отправлена форма
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получение данных из формы
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Генерация соли
    $salt = bin2hex(random_bytes(16));

    // Хеширование пароля
    $hashed_password = password_hash($password . $salt, PASSWORD_DEFAULT);
    //$hashed_password = sha1(md5($password . $salt));

    // Подготовка SQL-запроса для вставки данных в базу данных
    $query = "INSERT INTO users (username, password, email, salt) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);

    // Выполнение SQL-запроса
    try {
        $stmt->execute([$username, $hashed_password, $email, $salt]);
        echo "Użytkownik ".$username." został pomyślnie zarejestrowany!";
    } catch (PDOException $e) {
        die("Ошибка регистрации пользователя: " . $e->getMessage());
    }
}
?>

<!-- HTML-форма для регистрации пользователя -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarejestruj się</title>
</head>
<body>
    <h2>Zarejestracja użytkownika</h2>
    <form method="post" action="">
        <label for="username">Imię użytkownika:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Hasło:</label><br>
        <input type="password" id="password" name="password" required><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        <input type="submit" value="Zarejestruj się">
    </form>
</body>
</html>