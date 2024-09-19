<?php
include dirname(__DIR__, 2).'/config.php';

$user_id = $_SESSION['user_id']; // Zakładając, że użytkownik jest zalogowany i jego ID jest przechowywane w sesji

$sql = 'SELECT apartment_id FROM users WHERE id='.$user_id;

$apartment_id = $mysqli->query($sql)->fetch_assoc();

// Sprawdzenie limitu zgłoszeń (10 miesięcznie)
$currentMonth = date('Y-m-d');
$sql = "SELECT COUNT(*) as count FROM reports WHERE user_id = ? AND DATE_FORMAT(created_at, '%Y-%m-%d') = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('is', $user_id, $currentMonth);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['count'] >= 10) {
    http_response_code(400);
    echo 'Osiągnięto limit zgłoszeń na ten miesiąc.';
    exit;
}

// Dodanie zgłoszenia do tabeli reports
$description = $_POST['description'];
$sql = "INSERT INTO reports (user_id, apartment_id, description) VALUES (?, ?, ?)";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('iis', $user_id, $apartment_id, $description);
$stmt->execute();
$issue_id = $stmt->insert_id;

// Obsługa zdjęć
if (!empty($_FILES['images']['name'][0])) {
    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
        $file_name = uniqid() . basename($_FILES['images']['name'][$key]);
        $target_file = '/uploads/issues/' . $issue_id . '_' . $file_name;
        move_uploaded_file($tmp_name, $_SERVER['DOCUMENT_ROOT'] . $target_file);

        // Zapis ścieżki do bazy danych
        $sql = "INSERT INTO report_images (issue_id, image_path) VALUES (?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('is', $issue_id, $target_file);
        $stmt->execute();
    }
}

echo 'Zgłoszenie zostało wysłane pomyślnie.';

mysqli_close($mysqli);
?>
