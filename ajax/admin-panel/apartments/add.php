<?php
include dirname(__DIR__,3).'/config.php';

if (!isset($_SESSION['user_id']) && !($_SESSION['admin'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Forbidden']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $number = $_POST['number'];
    $floor = $_POST['floor'];

    if (empty($number) || !is_numeric($number)){
        echo json_encode(['success' => false, 'message' => 'Błędny numer mieszkania']);
        exit;
    }

    if (empty($floor) || !is_numeric($floor)) {
        echo json_encode(['success' => false, 'message' => 'Błędne piętro mieszkania']);
        exit;
    }
    
    // Dodaj nowe mieszkanie do bazy danych
    $stmt = $mysqli->prepare("INSERT INTO apartments (number, floor) VALUES (?, ?)");
    $stmt->bind_param("ss", $number, $floor);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Mieszkanie zostało dodane']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Dodanie nie powiodło się: ' . $stmt->error]);
    }
    
}

$mysqli->close();
?>
