<?php
include dirname(__DIR__, 3).'/config.php';

$issue_id = $_POST['id'];

$sql = "UPDATE reports SET status = 'resolved' WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $issue_id);
$stmt->execute();

echo 'Usterka została oznaczona jako naprawiona.';

mysqli_close($mysqli);
?>
