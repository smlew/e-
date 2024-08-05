<?php
    include("config.php");

    if(isset($_SESSION['logged']) && $_SESSION['logged'] && isset($_SESSION['username']) && ($_SESSION['admin'])){
        $sql = "SELECT * FROM users WHERE id = '{$_SESSION['user_id']}'";
        $result = $mysqli -> query($sql);
        $row = $result -> fetch_assoc();
        if(!$row['admin']) {
            header("Location: /index.php");
        }
    }
    else {
        header("Location: /index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin panel</title>

</head>
<body>
    <a href="#" onclick="addNews()" id="addNews">Dodaj nowość</a>

    <a href="#" onclick="apartments_list()" id="apartments">Lista mieszkań</a>

    <a href="#" onclick="residents_list()" id="residents">Lista mieszkańców</a>

    <a href="#" onclick="residency_history()" id="history">Historia zamieszkiwania</a>

    <a href="#" onclick="addEvent()" id="event">Dodaj wydarzenie</a>

    <div id="control_window">
        
    <div id="notification" style="display: none; background: #f8d7da; color: #721c24; padding: 10px; margin-top: 10px;"></div>


    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="./js/admin-script.js"></script>
</body>
</html>