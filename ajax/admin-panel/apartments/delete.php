<?php

    include dirname(__DIR__,3).'/config.php';

    if (!isset($_SESSION['user_id']) && !($_SESSION['admin'])) {
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => 'Forbidden']);
        exit;
    }


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];

        $stmt = $mysqli->prepare("DELETE FROM apartments WHERE id=?");

        $stmt->bind_param("i", $id);

        if ($stmt) {
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Mieszkanie zostało usunięte']);
            }
            else {
                echo json_encode(['success' => false, 'message' => 'Usunięcie nie powiodło się']);
            }
        }
        else {
            echo json_encode(['success' => false, 'message' => 'Błąd przygotowania zapytania: ' . $stmt->error()]);
        }

    }
    
?>