<?php
include dirname(__DIR__, 3) . '/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $apartment_id = $_POST['apartment_id'];
    $user_id = $_POST['user_id'];
    
    // Aktualizacja użytkownika z nowym apartment_id
    $stmt = $mysqli->prepare("UPDATE users SET apartment_id=? WHERE id=?;");
    $stmt->bind_param('ss', $apartment_id, $user_id);

    $stmt_history = $mysqli->prepare("INSERT INTO residency_history (user_id, apartment_id, start_date) VALUES (?, ?, CURDATE());");
    $stmt_history->bind_param('ss', $user_id, $apartment_id);
    
    
    if ($stmt->execute() && $stmt_history->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => $stmt->error]);
    }
    
    $stmt->close();
}

mysqli_close($mysqli);
?>
