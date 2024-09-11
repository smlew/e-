<?php

include dirname(__DIR__, 3).'/config.php';


if (!isset($_SESSION['user_id']) && $_SESSION['admin']) {
    http_response_code(403);
    echo json_encode(['success' => true, 'message' => 'Forbidden']);
}
else if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $sql = "SELECT users.id, users.name, users.last_name, apartments.number AS apartment_number, apartments.floor AS apartment_floor
    FROM users
    LEFT JOIN apartments ON users.apartment_id = apartments.id;";

    $result = mysqli_query($mysqli, $sql);


    if(mysqli_num_rows($result) > 0) {
        echo '
            <table border="1" class = "table table-striped table-hover">
                <tr>

                    <th>id</th>
                    <th>Imię</th>
                    <th>Nazwisko</th>
                    <th>Mieskanie</th>
                    <th>Piętro</th>
                    <th>Edycja</th>
                    <th>Usuń</th>
                </tr>
        ';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '
                <tr>
                    <td>'.$row['id'].'</td>
                    <td>'.$row['name'].'</td>
                    <td>'.$row['last_name'].'</td>
                    <td>'.$row['apartment_number'].'</td>
                    <td>'.$row['apartment_floor'].'</td>
                    <td>
                        <button onclick="openResidentModal('.$row["id"].')">Edytuj</button>
                    </td>
                    <td>
                        <i class="fas fa-times delete" onclick="deleteResident('.$row["id"].')"></i>
                    </td
                </tr>

            ';
        }

        echo '</table>';
    }

}

?>