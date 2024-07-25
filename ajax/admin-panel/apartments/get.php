<?php
include dirname(__DIR__,3).'/config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Pobierz dane mieszkania o podanym ID
    $sql = $mysqli->prepare("SELECT * FROM apartments WHERE id=?");
    $sql->bind_param('i', $id);
    $sql->execute();
    $result = $sql->get_result();
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        ?>
        
        <form id="update_apartment_modal" action="" method="post">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            Numer mieszkania:   <input type="text" name="number" value="<?php echo $row['number']; ?>"><br>
            Piętro:             <input type="text" name="floor" value="<?php echo $row['floor']; ?>"><br>
            
            <input type="submit" value="Aktualizuj dane">

        </form>

        <h3>Dodaj mieszkańca</h3>
        <form id="add_resident_form" method="post">
            <input type="hidden" name="apartment_id" value="<?php echo $row['id']; ?>">
            <select name="user_id">
                <?php
                // Pobierz listę użytkowników, którzy nie są przypisani do żadnej mieszkania
                $users_result = $mysqli->query("SELECT * FROM users WHERE apartment_id IS NULL");
                while ($user = $users_result->fetch_assoc()) {
                    echo '<option value="' . $user['id'] . '">' . htmlspecialchars($user['name']) . ' ' . htmlspecialchars($user['last_name']) . '</option>';
                }
                ?>
            </select>
            <input type="submit" value="Dodaj mieszkańca">
        </form>
        
        <h3>Usuń mieszkańca</h3>
        <form id="remove_resident_form" method="post">
            <input type="hidden" name="apartment_id" value="<?php echo $row['id']; ?>">
            <select name="user_id">
                <?php
                // Pobierz listę użytkowników przypisanych do mieszkania
                $residents_result = $mysqli->query("SELECT * FROM users WHERE apartment_id=" . $row['id']);
                while ($resident = $residents_result->fetch_assoc()) {
                    echo '<option value="' . $resident['id'] . '">' . htmlspecialchars($resident['name']) . ' ' . htmlspecialchars($resident['last_name']) . '</option>';
                }
                ?>
            </select>
            <input type="submit" value="Usuń mieszkańca">
        </form>

        
        
        <?php
    } else {
        echo "Mieszkanie nie znalezione";
    }
}

mysqli_close($mysqli);
?>
