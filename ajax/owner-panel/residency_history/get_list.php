<?php

include dirname(__DIR__,3).'/config.php';



if (!isset($_SESSION['user_id']) && !($_SESSION['admin'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Forbidden']);
    exit;
}


if($_SERVER['REQUEST_METHOD'] == 'GET') {

    $query = $_GET['query'];
    

    $stmt = $mysqli->query("
        SELECT
            users.id AS user_id,
            users.name AS user_name,
            users.last_name AS user_last_name,
            apartments.id AS apartment_id,
            apartments.number AS apartment_number,
            apartments.floor AS apartment_floor,
            residency_history.start_date,
            residency_history.end_date

        FROM
            residency_history

        JOIN
            users ON residency_history.user_id = users.id

        JOIN
            apartments ON residency_history.apartment_id = apartments.id
        
        WHERE
            apartments.owner = ".$_SESSION['user_id']."

        ORDER BY
            residency_history.start_date DESC
        ;
    ");
    

    

    if ($stmt->num_rows > 0) {
        ?>
        <table class= "table table-striped table-hover">
            <thead>
                <tr>
                    <th>Imię</th>
                    <th>Nazwisko</th>
                    <th>Numer pokoju</th>
                    <th>Piętro</th>
                    <th>Data wprowadzenia się</th>
                    <th>Data wyprowadzenia się</th>
                </tr>
            </thead>
            <tbody>

        <?php


        while ($row = $stmt -> fetch_assoc()) {
            echo '<tr>
                <td>' . htmlspecialchars($row['user_name']) . '</td>
                <td>' . htmlspecialchars($row['user_last_name']) . '</td>
                <td>' . htmlspecialchars($row['apartment_number']) . '</td>
                <td>' . htmlspecialchars($row['apartment_floor']) . '</td>
                <td>' . htmlspecialchars($row['start_date']) . '</td>
                <td>' . (($row['end_date'])? htmlspecialchars($row['end_date']) : '-'). '</td>
            </tr>';
        }

        echo '</tbody>
        </table>';
    }
        

    $mysqli->close();

}

?>