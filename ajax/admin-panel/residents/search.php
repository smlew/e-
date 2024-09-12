<?php

include (dirname(__DIR__, 3)).'/config.php';

if (!isset($_SESSION['user_id']) && !($_SESSION['admin'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Forbidden']);
}
else if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $query=$_GET['query'];

    $stmt = $mysqli -> prepare("SELECT * FROM users LEFT JOIN apartments ON users.apartment_id=apartments.id WHERE name LIKE ? OR last_name LIKE ?");
    $stmt->bind_param('ss', $query, $query);

    if ($stmt->execute()) {
        $result = $stmt -> get_result();
        echo '
        <table class="table table-striped table-hover">
            <tr>
                <th>id</th>
                <th>Imię</th>
                <th>Nazwisko</th>
                <th>Mieskanie</th>
                <th>Piętro</th>
            </tr>
        ';

        while ($row = $result -> fetch_assoc()) {
            echo '
            <tr>
                <td>'.$row['id'].'</td>
                <td>'.$row['name'].'</td>
                <td>'.$row['last_name'].'</td>
                <td>'.$row['number'].'</td>
                <td>'.$row['floor'].'</td>
            </tr>

            ';
        }

        echo '
        </table>
        ';

    }
    
}

?>