
<?php
include dirname(__DIR__, 3) . '/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $user_id = $_POST['user_id'];

    // Usunięcie apartment_id od użytkownika
    $stmt = $mysqli->prepare("UPDATE users
        INNER JOIN apartments ON users.apartment_id = apartments.id
        INNER JOIN multifamily_residential ON apartments.address_id = multifamily_residential.id
        SET users.apartment_id = NULL
        WHERE users.id = ?;
        ");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    
    $stmt_history = $mysqli->prepare("UPDATE residency_history SET end_date=CURDATE() WHERE user_id = ? ORDER BY start_date LIMIT 1");
    $stmt_history->bind_param('i', $user_id);


    
    $stmt_history->execute();

    $stmt->close();
    $stmt_history->close();
}

mysqli_close($mysqli);
?>
