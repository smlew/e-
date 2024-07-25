<?php

include dirname(__DIR__, 3).'/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];

    $sql = $mysqli -> prepare("SELECT id, name, last_name, email FROM users WHERE id = ?");
    $sql -> bind_param("s", $id);
    $sql -> execute();

    $result = $sql -> get_result();

    if (mysqli_num_rows($result) > 0) {

        $row = $result -> fetch_assoc();
       ?>
            <form id="update_resident_modal" action="" method="post">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                Imię:       <input type="text" name="name" value="<?php echo $row['name']; ?>"/><br>
                Nazwisko:   <input type="text" name="last_name" value="<?php echo $row['last_name']; ?>"/><br>
                email:      <input type="text" name="email" value="<?php echo $row['email']?>"/><br>
                <input type="submit" value="Aktualizuj dane"/>
                <div id="output_info_update"></div>
            </form>

       <?php
    }


}

?>