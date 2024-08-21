<?php

include (dirname(__DIR__,3)."/config.php");

if (!isset($_SESSION['user_id']) && !($_SESSION['admin'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Forbidden']);
    exit;
}

if (isset($_POST['title'])) {
    if      ($_FILES["image"]["error"] == UPLOAD_ERR_INI_SIZE)      { die ("Błąd: Rozmiar pliku przekracza maksymalną dozwoloną wielkość 2MB"); } // określoną w php.ini
    elseif  ($_FILES["image"]["error"] == UPLOAD_ERR_FORM_SIZE)     { die ("Błąd: Rozmiar pliku przekracza maksymalną dozwoloną wielkość 2MB"); } // określoną w formularzu
    elseif  ($_FILES["image"]["error"] == UPLOAD_ERR_PARTIAL)       { die ("Błąd: Plik został załadowany tylko częściowo"); }
    elseif  ($_FILES["image"]["error"] == UPLOAD_ERR_CANT_WRITE)    { die ("Błąd: Błąd podczas tymczasowego zapisywania pliku na serwerze"); }
    elseif  ($_FILES["image"]["error"] == UPLOAD_ERR_NO_TMP_DIR)    { die ("Błąd: Nie znaleziono katalogu tymczasowego do zapisywania pliku"); }
    elseif  ($_FILES["image"]["error"] == UPLOAD_ERR_EXTENSION)     { die ("Błąd: Rozszerzenie PHP zatrzymało ładowanie pliku"); }
    elseif  ($_FILES["image"]["error"] > 0 && $_FILES["image"]["error"] != UPLOAD_ERR_NO_FILE) {
        die ("Błąd podczas przesyłania pliku: " . $_FILES["image"]["error"]); 
    }
    else {
        // Sprawdzenie, czy plik został przesłany
        if ($_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $fileName = NULL;

            // Dozwolone rozszerzenia plików
            $allowedExtensions = array("jpg", "jpeg", "png", "gif");

            // Pobierz rozszerzenie przesłanego pliku
            $extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));

            // Sprawdź, czy rozszerzenie pasuje do dozwolonych rozszerzeń
            if (!in_array($extension, $allowedExtensions)) {
                die ("Błąd: Nieprawidłowe rozszerzenie pliku. Dozwolone są tylko pliki z rozszerzeniami: " . implode(", ", $allowedExtensions));
            }

            // Ustaw katalog do zapisywania przesłanych obrazów
            $uploadDir = dirname(__DIR__,1)."/uploads/";

            // Generowanie unikalnej nazwy pliku na podstawie bieżącego znacznika czasu
            $fileName = uniqid() . "_" . basename($_FILES["image"]["name"]);

            // Pełna ścieżka do pliku na serwerze
            $uploadFile = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $uploadFile)) {
                $imagePath = $uploadFile;
            } else {
                throw new Exception("Błąd podczas ładowania zdjęcia.");
            }
        }
        else {
            $imagePath = NULL;
        }


        // Przeniesienie pobranego pliku do określonego katalogu
        try {

            // Przygotuj dane do wstawienia do bazy danych (ochrona przed atakami typu SQL injection)
            $title = $mysqli->real_escape_string($_POST['title']);
            $text = $mysqli->real_escape_string($_POST['text']);
            $date = date('y-m-d H:i:s'); // Aktualna data i czas



            // Zapytanie SQL do wstawienia danych do bazy danych
            $sql = "INSERT INTO news (user, title, text, date_published, image_path) VALUES ('$_SESSION[user_id]','$title', '$text', '$date', '$imagePath')";

            if ($mysqli->query($sql) === TRUE) {
                die('ok');
            } else { throw new Exception("Błąd podczas dodawania nowości do bazy danych: " . $mysqli->error); }

            // Próbujemy przenieść załadowany plik do określonego katalogu

        } catch (Exception $e) {
            die ("Wystąpił błąd: " . $e->getMessage());
        }

    }
    
}
?>