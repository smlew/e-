<?php

include dirname(__DIR__, 3).'/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $name = $_POST['name'];
    $date = $_POST['date'];
    $startTime = $_POST['startTime'];
    $endTime = isset($_POST['endTime']) ? $_POST['endTime'] : null;

    $startDateTime = $date . ' ' . $startTime . ':00';
    $endDateTime = $endTime ? $date . ' ' . $endTime . ':00' : date("Y-m-d H:i:s", strtotime($startDateTime) + 60*60);

    $stmt = $mysqli->prepare("INSERT INTO events (name, start_datetime, end_datetime) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $startDateTime, $endDateTime);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }

    $stmt->close();
}

?>