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
            Numer mieszkania:   <input type="text" name="number"    value="<?php echo $row['number'];                               ?>"><br>
            Litera:             <input type="text" name="letter"    value="<?php echo isset($row['letter']) ? $row['letter'] : '';  ?>"><br>
            Piętro:             <input type="text" name="floor"     value="<?php echo $row['floor'];                                ?>"><br>
            
            <input type="submit" value="Aktualizuj dane">

        </form>

        <?php
    } else {
        echo "Mieszkanie nie znalezione";
    }
}

mysqli_close($mysqli);
?>
