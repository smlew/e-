<?php

include dirname(__DIR__, 3).'/config.php';

if (!$_SESSION['admin'] and !$_SESSION['logged']) {
    header('Location: /index.php');
    exit();
}

$sql = 'SELECT
            reports.id,
            apartments.number,
            apartments.letter,
            CASE
                WHEN LENGTH(description) > 32 THEN CONCAT(LEFT(description, 32), "...")
                ELSE description
            END AS descriptionL,
            created_at, 
            status
        FROM reports LEFT JOIN apartments ON apartments.id = reports.apartment_id';
$stmt = $mysqli -> query($sql);
$issues = array();
while($row = $stmt -> fetch_assoc()) {
    $issues[] = $row;
}

echo json_encode($issues);

mysqli_close($mysqli);
?>

