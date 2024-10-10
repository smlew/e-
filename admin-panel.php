<?php
    include("config.php");

    if (!$_SESSION['admin']) {
        header("Location: /index.php");
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="js/login-script.js"></script>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet"/>

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/rrule@5.10.1/main.global.min.js" type='module'></script>
    <script src="https://cdn.jsdelivr.net/npm/rrule@2.6.8/dist/es5/rrule.min.js"></script>

    <link rel="stylesheet" href="./css/styles.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        #calendar {
        max-width: 900px;
        margin: 0 auto;
        }
    </style>

    <title>Admin panel</title>

</head>
<body class="d-flex flex-column min-vh-100">

    <?php
        include 'nav-bar.php';
    ?>

    <div class="container-xl admin-container">

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" role="tab" aria-selected="true" href="#" onclick="addNews()" id="addNews">Dodaj nowość</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" role="tab" aria-selected="false" href="#" onclick="apartments_list()" id="apartments">Mieszkania</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" role="tab" aria-selected="false" href="#" onclick="residents_list()" id="residents">Mieszkańcy</button>
            </li>

            <li>
                <button class="nav-link" data-bs-toggle="tab" role="tab" aria-selected="false" href="#" onclick="addEvent()" id="event">Wydarzenia</button>
            </li>
            <li>
                <button class="nav-link" data-bs-toggle="tab" role="tab" aria-selected="false" href="#" onclick="payments()" id="payment">Opłata miesięczna</button>
            </li>
            <li>
                <button class="nav-link" data-bs-toggle="tab" role="tab" aria-selected="false" href="#" onclick="loadIssues()" id="issues">Usterki</button>
            </li>
        </ul>

        <div class="control-window"  id="control_window"></div>
            
        <div id="notification" style="display: none; background: #f8d7da; color: #721c24; padding: 10px; margin-top: 10px;"></div>
        
    </div>

<?php
    include 'footer.php'
?>


    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="./js/admin-script.js"></script>
</body>
</html>