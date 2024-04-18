<?php

include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sprawdź, czy obraz został wysłany
    if ($_FILES["image"]["error"] > 0) {
        echo "Błąd podczas przesyłania pliku: " . $_FILES["image"]["error"];
        if      ($_FILES["image"]["error"] == UPLOAD_ERR_INI_SIZE)      { echo "Błąd: Rozmiar pliku przekracza maksymalną dozwoloną wielkość określoną w php.ini"; }
        elseif  ($_FILES["image"]["error"] == UPLOAD_ERR_FORM_SIZE)     { echo "Błąd: Rozmiar pliku przekracza maksymalną dozwoloną wielkość określoną w formularzu"; }
        elseif  ($_FILES["image"]["error"] == UPLOAD_ERR_PARTIAL)       { echo "Błąd: Plik został załadowany tylko częściowo"; }
        elseif  ($_FILES["image"]["error"] == UPLOAD_ERR_NO_FILE)       { echo "Błąd: Brak pliku do załadowania"; }
        elseif  ($_FILES["image"]["error"] == UPLOAD_ERR_CANT_WRITE)    { echo "Błąd: Błąd podczas tymczasowego zapisywania pliku na serwerze"; }
        elseif  ($_FILES["image"]["error"] == UPLOAD_ERR_NO_TMP_DIR)    { echo "Błąd: Nie znaleziono katalogu tymczasowego do zapisywania pliku"; }
        elseif  ($_FILES["image"]["error"] == UPLOAD_ERR_EXTENSION)     { echo "Błąd: Rozszerzenie PHP zatrzymało ładowanie pliku"; }
        
    } else {
        // Разрешенные расширения файлов
        $allowedExtensions = array("jpg", "jpeg", "png", "gif");

        // Получаем расширение загруженного файла
        $extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));

        // Проверяем, соответствует ли расширение разрешенным расширениям
        if (!in_array($extension, $allowedExtensions)) {
            echo "Ошибка: Недопустимое расширение файла. Разрешены только файлы с расширениями: " . implode(", ", $allowedExtensions);
        }

        // Ustaw katalog do zapisywania przesłanych obrazów
        $uploadDir = "uploads/";



        // Generowanie unikalnej nazwy pliku na podstawie bieżącego znacznika czasu
        $fileName = uniqid() . "_" . basename($_FILES["image"]["name"]);

        // Pełna ścieżka do pliku na serwerze
        $uploadFile = $uploadDir . $fileName;

        // Przeniesienie pobranego pliku do określonego katalogu
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $uploadFile)) {
            echo "Plik domyślnie przesłany: " . $uploadFile;
            // W tym miejscu można zapisać ścieżkę pliku do bazy danych lub wykonać inne operacje

            // Zapytanie SQL do wstawiania danych do bazy danych
            $sql = "INSERT INTO images (file_path) VALUES ('$uploadFile')";
            if ($mysqli->query($sql) === TRUE) {
                echo "Запись успешно добавлена в базу данных";
            } else {
                echo "Ошибка: " . $sql . "<br>" . $mysqli->error;
            }

            // Закрываем соединение с базой данных
            $mysqli->close();

        } else {
            echo "Błąd podczas przesyłania pliku";
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Przesyłanie obrazu</title>
</head>
<body>
    <h2>Prześlij obraz</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <textarea name="text" rows="4" cols="50"></textarea>
        <input type="file" name="image" id="image">
        
        <input type="submit" value="Загрузить" name="submit">
    </form>
</body>
</html>
