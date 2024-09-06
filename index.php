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

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <title>E-Osiedle</title>
</head>
<body>

    <?php 
        if($_SESSION['logged'] && isset($_SESSION['username'])){
            $sql = "SELECT * FROM users WHERE id = '{$_SESSION['user_id']}'";
            $result = $mysqli -> query($sql);
            $row = $result -> fetch_assoc();
        }
        include 'nav-bar.php';
    ?>
        

    <div class="container-xl">
        <header>
            <h1>Witamy w portalu mieszkańca</h1>
            <p>Zarządzaj swoimi płatnościami, zgłaszaj usterki i otrzymuj informacje o swoim osiedlu</p>
        </header>

        <div class="row align-items-center">
            <div class="col"></div>
        </div>
        

    </div>

    
    <footer>
        <p>E-Osiedle - Zarządzanie mieszkaniami © 2024</p>
    </footer>
    
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="./js/login-script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
</body>
</html>