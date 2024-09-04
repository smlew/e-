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

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet"/>

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/rrule@5.10.1/main.global.min.js" type='module'></script>
    <script src="https://cdn.jsdelivr.net/npm/rrule@2.6.8/dist/es5/rrule.min.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        #calendar {
        max-width: 900px;
        margin: 0 auto;
        }
    </style>

    <title>Admin panel</title>

</head>
<body>
    <a href="#" onclick="addNews()" id="addNews">Dodaj nowość</a>

    <a href="#" onclick="apartments_list()" id="apartments">Lista mieszkań</a>

    <a href="#" onclick="residents_list()" id="residents">Lista mieszkańców</a>

    <a href="#" onclick="residency_history()" id="history">Historia zamieszkiwania</a>

    <a href="#" onclick="addEvent()" id="event">Wydarzenie</a>
    
    <a href="#" onclick="payments()" id="payment">Opłata miesięczna</a>

    <a href="#" onclick="loadIssues()" id="issues">Usterki</a>


    <div id="control_window"></div>
        
    <div id="notification" style="display: none; background: #f8d7da; color: #721c24; padding: 10px; margin-top: 10px;"></div>

    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="./js/admin-script.js"></script>
</body>
</html>