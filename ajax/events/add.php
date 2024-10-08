<?php
include dirname(__DIR__, 2) . '/config.php';

if (!isset($_SESSION['user_id']) && !($_SESSION['admin'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Forbidden']);
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = isset($_POST['name']) ? $_POST['name'] : null;
    $description = isset($_POST['description']) ? $_POST['description'] : null;
    $startTime = isset($_POST['startTime']) ? $_POST['startTime'] : null;
    $endTime = isset($_POST['endTime']) ? $_POST['endTime'] : null;

    if ($name && $startTime && $endTime) {

        $startDateTime=new DateTime($startTime);
        $endDateTime=new DateTime($endTime);

        $startDateTime=$startDateTime->format('Y-m-d H:i:s');
        $endDateTime=$endDateTime->format('Y-m-d H:i:s');

        // Подготавливаем SQL запрос для вставки данных в таблицу
        $stmt = $mysqli->prepare("INSERT INTO events (title, description, start_date, end_date, address_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssi', $name, $description, $startDateTime, $endDateTime, $_SESSION['address_id']);

        // Выполняем запрос и проверяем результат
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Event added successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add event']);
        }
        // Закрываем запрос
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid input data']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

// Закрываем соединение с базой данных

?>
