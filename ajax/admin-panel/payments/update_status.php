<?php
include dirname(__DIR__, 3).'/config.php';

$paymentId = $_POST['id'];
$paymentDate = date('Y-m-d');
$status = 'paid';

$sql = "UPDATE payments SET status = '$status', payment_date = '$paymentDate' WHERE id = $paymentId";

if (mysqli_query($mysqli, $sql)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => mysqli_error($mysqli)]);
}

mysqli_close($mysqli);
?>