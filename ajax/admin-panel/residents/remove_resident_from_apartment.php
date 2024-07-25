
<?php
include dirname(__DIR__, 3) . '/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $apartment_id = $_POST['apartment_id'];
    $user_id = $_POST['user_id'];
    
    // Usunięcie apartment_id od użytkownika
    $stmt = $mysqli->prepare("UPDATE users SET apartment_id=NULL WHERE id=?");
    $stmt->bind_param('i', $user_id);

    $stmt_history = $mysqli->prepare("UPDATE residency_history SET end_date=CURDATE()");

    
    if ($stmt->execute() && $stmt_history->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => $stmt->error]);
    }
    
    $stmt->close();
}

mysqli_close($mysqli);
?>
