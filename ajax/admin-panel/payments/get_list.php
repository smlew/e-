<?php
include dirname(__DIR__, 3).'/config.php';

if (!isset($_SESSION['user_id']) && !($_SESSION['admin'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Forbidden']);
    exit;
}

$number = isset($_GET['number']) ? $_GET['number'] : null;
$paid = isset($_GET['paid']) ? $_GET['paid'] : null;

$sql = "SELECT payments.id, number, amount, payment_date, status, month_year
        FROM payments
        LEFT JOIN apartments ON payments.apartment_id = apartments.id";

if (!is_null($number) and $number != 'null') {
    $number = mysqli_real_escape_string($mysqli, $number);
    $sql .= " WHERE apartments.number = ?";

    if ($paid == 'no') {
        $sql .= " AND (payments.status = 'unpaid' OR payments.status = 'overdue')";
    }

    $stmt = $mysqli -> prepare($sql);
    $stmt -> bind_param('s', $number);
    $stmt -> execute();
    $result = $stmt -> get_result();
}
else {
    if ($paid == 'no') {
        $sql .= " WHERE payments.status = 'unpaid' OR payments.status = 'overdue'";
    }
    $stmt = $mysqli -> prepare($sql);
    $stmt -> execute();
    $result = $stmt -> get_result();
}


// $result = mysqli_query($mysqli, $sql);

$history = array();
while ($row = mysqli_fetch_assoc($result)) {
    $history[] = $row;
}

echo json_encode($history);

mysqli_close($mysqli);
?>