<?php
include dirname(__DIR__,3).'/config.php';

if (!isset($_SESSION['user_id']) || !$_SESSION['admin']) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Forbidden']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    // Убираем LEFT JOIN и удаляем запись напрямую из таблицы apartments
    $stmt = $mysqli->prepare("DELETE a FROM apartments a INNER JOIN multifamily_residential m ON a.address_id = m.id WHERE a.id = ? AND m.id = ?");

    if ($stmt) {
        $stmt->bind_param("ii", $id, $_SESSION['address_id']);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Mieszkanie zostało usunięte']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Usunięcie nie powiodło się']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Błąd przygotowania zapytania: ' . $mysqli->error]);
    }
}
?>
