<?php
include dirname(__DIR__, 3).'/config.php';

$number = isset($_GET['number']) ? $_GET['number'] : null;
$paid = isset($_GET['paid']) ? $_GET['paid'] : null;

$sql = "SELECT apartments.id, number, amount, payment_date, status, month_year
        FROM payments
        LEFT JOIN apartments ON payments.apartment_id = apartments.id";

if (!is_null($number) and $number != 'null') {
    $number = mysqli_real_escape_string($mysqli, $number);
    $sql .= " WHERE apartments.number = '$number'";

    if ($paid == 'no') {
        $sql .= " AND (payments.status = 'unpaid' OR payments.status = 'overdue')";
    }
}
else {
    if ($paid == 'no') {
        $sql .= " WHERE payments.status = 'unpaid' OR payments.status = 'overdue'";
    }
}

$result = mysqli_query($mysqli, $sql);

$history = array();
while ($row = mysqli_fetch_assoc($result)) {
    $history[] = $row;
}

echo json_encode($history);

mysqli_close($mysqli);
?>