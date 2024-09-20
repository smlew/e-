<?php
    include dirname(__DIR__, 2).'/config.php';

    if ($_SESSION['owner']) {
        $sql = 'SELECT * FROM apartments WHERE owner = '.$_SESSION['user_id'];
        $result = $mysqli->query($sql);
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "bred";
        exit();
    }
    
    
?>

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