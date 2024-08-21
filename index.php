<?php
    include("config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="./css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title>E-Osiedle</title>
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <?php if(isset($error_message)) { ?>
        <div><?php echo $error_message; ?></div>
    <?php } ?>
    

    

    <div class="content">

        <?php
        
            //echo '<script>alert("id: '.$_SESSION['user_id'].', '.$_SESSION['logged'].'")</script>';

            if(isset($_SESSION['logged']) && $_SESSION['logged'] && isset($_SESSION['username'])){
                $sql = "SELECT * FROM users WHERE id = '{$_SESSION['user_id']}'";
                $result = $mysqli -> query($sql);
                $row = $result -> fetch_assoc();
                if($row['admin'] == 1) {
                    echo '<p>Witaj '.$row['username'].'. <a href="admin-panel.php">Admin Panel</a> <a href="?logout">Wyloguj sie</a></p>';
                }else{
                    echo '<p>Witaj '.$row['username'].'. Zapraszamy do serwisu <a href="?logout">Wyloguj sie</a></p>';
                }?>
            <p>Już jesteś zalogowany w systemie jako: <?php echo $_SESSION['username']; ?>. <a href="logout.php">Wyjdź</a></p>
            <a href='calendar.php'>Kalendarz</a>
        <?php
            }
            else { ?>

                <h2>Zalogować się</h2>
                <p>Masz już konto? <a href="#" onclick="loadLoginWindow()">Zaloguj się!</a></p>
                <div id='calendar'></div>


        <?php } ?>
    </div>
    



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="./js/login-script.js"></script>



</body>
</html>
