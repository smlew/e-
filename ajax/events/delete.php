<?php
include dirname(__DIR__, 2) . '/config.php';

if (!isset($_SESSION['user_id']) && !($_SESSION['admin'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Forbidden']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventId = $_POST['id'];

    if ($eventId) {
        $sql = "DELETE FROM events WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('i', $eventId);

        if ($stmt->execute()) {
            echo 'Success';
        } else {
            http_response_code(500);
            echo 'Error: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        http_response_code(400);
        echo 'Invalid event ID';
    }
} else {
    http_response_code(405);
    echo 'Method not allowed';
}

$mysqli->close();
?>
