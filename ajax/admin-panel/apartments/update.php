<?php

include dirname(__DIR__,3).'/config.php';

if (!isset($_SESSION['user_id']) && !($_SESSION['admin'])) {
    http_response_code(403);
    echo json_encode(['success'=>false,'message'=>'Forbidden']);
    exit;
}

else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $number = $_POST['number'];
    $floor = $_POST['floor'];
    
    // Zaktualizuj dane mieszkania
    $stmt = $mysqli->prepare("UPDATE apartments SET number=?, floor=? WHERE id=?");
    $stmt->bind_param("ssi",$number, $floor, $id);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Mieszkanie zaktualizowane!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Błąd: '.$sql.'<br>'.($stmt->error)]);
    }
}

mysqli_close($mysqli);
?>
