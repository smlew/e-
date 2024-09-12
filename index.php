<?php
    include("config.php");
?>

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
    <title>E-Osiedle</title>
</head>
<body class="d-flex flex-column min-vh-100">

    <?php
        include 'nav-bar.php';
    ?>
        

    <div class="container-xl">

    <div class="row header-index">
        <div class="col-lg-6 order-lg-1 header-text">
            <span>Witamy na portalu!</span>

            <h1>
                E-osiedle to portal dla mieszkańców i administratorów budynków wielorodzinnych
            </h1>
            <br>
            <p>
            Cieszymy się, że dołączyłeś do naszego systemu zarządzania mieszkaniami. Dzięki naszemu portalowi możesz łatwo zgłaszać usterki, przeglądać najnowsze ogłoszenia oraz śledzić harmonogram wywozu śmieci i prac konserwacyjnych.
            </p>
        </div>
        <div class="col-lg-6 order-lg-1">
            <img class="index-img-1" src="osiedle-1.jpg" alt="">
        </div>
    </div>
    <hr>

    <div class="row header-index-2" style="margin-top: 80px;">
        <div class="col-lg-5 order-lg-1">
            <img class="index-img-1" src="osiedle-2.jpg" alt="">
        </div>
        <div class="col-lg-7 order-lg-1 header-text">
            <p>
            Naszym celem jest zapewnienie Ci wygodnego dostępu do wszystkich najważniejszych informacji dotyczących Twojego mieszkania oraz umożliwienie szybkiego kontaktu z administracją osiedla.
            </p>
        </div>

    </div>
    
    </div>

<?php
    include 'footer.php';
?>

    

    
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="./js/login-script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
</body>
</html>