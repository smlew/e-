<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="./css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="js/owner-script.js"></script>
    <title>Panel właściciela</title>
</head>
<body class="d-flex flex-column min-vh-100">

<?php
    include 'config.php';
    include 'nav-bar.php';
?>
    
    <div class="container-xl">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" role="tab" aria-selected="true" href="#" onclick="payments()" id="payments">Zarządzaj płatnościami</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" role="tab" aria-selected="false" href="#" onclick="manageResidents()" id="residents">Zarządzaj mieszkańcami</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" role="tab" aria-selected="false" href="#" onclick="residency_history()" id="history">Historia zamieszkiwania</button>
            </li>
        </ul>
        <div id="control_window">

        </div>
    </div>

<?php
    include 'footer.php';
?>
</body>
</html>