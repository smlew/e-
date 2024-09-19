<button onclick="get_apartments_list('s')">Pokaż osiadłe mieszkania</button>
<button onclick="get_apartments_list('u')">Pokaż puste mieszkania</button>

<?php

    include dirname(__DIR__,3).'/config.php';
    $sql = "
    SELECT
        apartments.id                   AS apartment_id,
        apartments.number               AS apartment_number,
        apartments.letter               AS apartment_letter,
        apartments.floor                AS apartment_floor,
        users.id                        AS user_id,
        users.name                      AS name,
        users.last_name                 AS last_name,
        multifamily_residential.id      AS address_id,
        multifamily_residential.address AS address,
        multifamily_residential.block   AS block
    FROM
        apartments
    ";

    // Логика для отображения заселённых/незаселённых квартир
    if ($_GET['settled'] == 'u') {
        // Для незаселённых квартир используем LEFT JOIN
        $sql .= "
            LEFT JOIN users ON apartments.id = users.apartment_id
            LEFT JOIN multifamily_residential ON apartments.address_id = multifamily_residential.id
            WHERE multifamily_residential.id = ? 
            AND users.id IS NULL
        ";
    } else if ($_GET['settled'] == 's') {
        // Для заселённых квартир используем INNER JOIN
        $sql .= "
            INNER JOIN users ON apartments.id = users.apartment_id
            LEFT JOIN multifamily_residential ON apartments.address_id = multifamily_residential.id
            WHERE multifamily_residential.id = ?
        ";
    } else { $sql .= "
            LEFT JOIN users ON apartments.id = users.apartment_id
            LEFT JOIN multifamily_residential ON apartments.address_id = multifamily_residential.id
            WHERE multifamily_residential.id = ? "; }

    // Завершение запроса
    $sql .= " ORDER BY apartments.number, users.id";


    
    // Подготавливаем и выполняем запрос
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $_SESSION['address_id']);
    $stmt->execute();
    
    $resultad = $stmt->get_result();
    $apartments = [];

    while ($row = mysqli_fetch_assoc($resultad)) {
        $apartment_id = $row['apartment_id'];
        if (!isset($apartments[$apartment_id])) {
            $apartments[$apartment_id] = [
                'id' => $row['apartment_id'],
                'number' => $row['apartment_number'],
                'letter' => $row['apartment_letter'],
                'floor' => $row['apartment_floor'],
                'users' => []
            ];
        }
        if ($row['user_id']) {
            $apartments[$apartment_id]['users'][] = [
                'id' => $row['user_id'],
                'name' => $row['name'],
                'last_name' => $row['last_name']
            ];
        }
    }
    echo '<table class="table table-striped table-hover">
        <thead>
            <tr>
                <th class="number">Numer Mieszkania</th>
                <th class="number">Piętro</th>
                <th>Mieszkańcy (id, imię i nazwisko)</th>
                <th>Akcje</th>
            </tr>
        </thead>
        <tbody>';
    foreach ($apartments as $apartment) { ?>
        <tr>
            <td class="number">
                <?php echo (htmlspecialchars(($apartment['number']) . ((isset($apartment['letter']) ? $apartment['letter'] : '')))); ?>
            </td>
            <td class="number">
                <?php echo htmlspecialchars($apartment['floor']); ?>
            </td>
            <?php
            if (count($apartment['users']) > 0) {
                $first_user = array_shift($apartment['users']); ?>
                <td>
                    <table>
                        <tbody>
                        <tr>
                            <td><?php echo htmlspecialchars($first_user['id']); ?></td>
                            <td><?php echo htmlspecialchars($first_user['name']).' '.htmlspecialchars($first_user['last_name']); ?></td>
                        </tr>
            
                        <?php foreach ($apartment['users'] as $user) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['id']); ?></td>
                                <td><?php echo htmlspecialchars($user['name']).' '.htmlspecialchars($user['last_name']); ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </td>
            <?php } else { ?>
                <td>Brak mieszkańców.</td>
            <?php } ?>
            <td>
                <button onclick="openApartmentModal ('<?php echo $apartment['id'];?>')">Edytuj</button>
                <button onclick="deleteApartment    ('<?php echo $apartment['id'];?>')">Usuń  </button>
            </td>
        </tr>
    <?php }
    
    echo '</tbody>
    </table>';


    mysqli_close($mysqli);
?>