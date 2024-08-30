<?php
include dirname(__DIR__, 3).'/config.php';

$currentDate = new DateTime();
$previousMonth = $currentDate->modify('-1 month')->format('Y-m');

$sql = "UPDATE payments
        SET status = 'overdue'
        WHERE status = 'unpaid'
        AND DATE_FORMAT(month_year, '%Y-%m') = '$previousMonth'";

mysqli_query($mysqli, $sql);

//----------------------------------------------------------------------------------------------------------------------------------//

$monthYear = date('Y-m-15');

$sql = "SELECT id FROM apartments";
$result = mysqli_query($mysqli, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $apartmentId = $row['id'];

    $checkSql = "SELECT id FROM payments WHERE apartment_id = $apartmentId AND month_year = '$monthYear'";
    $checkResult = mysqli_query($mysqli, $checkSql);

    if (mysqli_num_rows($checkResult) == 0) {
        $insertSql = "INSERT INTO payments (apartment_id, amount, month_year, status) 
                      VALUES ($apartmentId, (SELECT default_rent FROM apartments WHERE id = $apartmentId), '$monthYear', 'unpaid')";
        mysqli_query($mysqli, $insertSql);
    }
}

mysqli_close($mysqli);
?>