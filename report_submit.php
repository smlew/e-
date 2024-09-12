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
    <title>Zgłoszenie</title>
</head>
<body class="d-flex flex-column min-vh-100">

<?php
    include 'config.php';
    include 'nav-bar.php';
?>

<div class="container-xl">

    <h2 class="header-report">Zgłoszenie usterki</h2>
    <hr>
    <form id="reportIssueForm" enctype="multipart/form-data">
        <div class="form-group">
            <label for="report-description">Wpisz opis problemu</label>
            <textarea class="form-control" id="report-description" name="description" placeholder="Opis usterki" required></textarea>
        </div>
        <br>
        <div class="form-group">
            <label for="report-image">Wyślij zdjęcie</label>
            <input class="form-control-file" id="report-image" type="file" name="images[]" multiple accept="image/*">
        </div>
        <br>
        
        <button type="submit" class="btn btn-primary">Zgłoś usterkę</button>
    </form>
    <div id="errorMessage"></div>
</div>



<script src="/js/report-issue.js"></script>


<?php
    include 'footer.php';
?>
</body>
</html>