<?php

include dirname(__DIR__, 3).'/config.php';

if (!isset($_SESSION['user_id']) && !($_SESSION['admin'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Forbidden']);
    exit;
}
else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];

    $stmt = $mysqli->prepare("UPDATE users SET name=?, last_name=?, email=? WHERE id=?");
    $stmt->bind_param('ssss', $name, $last_name, $email, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Dane użytkownika pomyślnie zaktualizowane']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Dane użytkownika nie zostały zaktualizowane']);
    }

}

?>