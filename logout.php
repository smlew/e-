<?php
    session_start();

    // Usuń wszystkie dane sesji
    session_unset();

    // Usuń sesję
    //session_destroy();

    $_SESSION['logged'] = false;
    $_SESSION['user_id'] = -1;
    $_SESSION['username'] = "";
    // Przekierowuje na bieżącą stronę, aby zapobiec ponownemu przesłaniu formularza.
    header("Location: index.php");
    //header("Location: ".$_SERVER['PHP_SELF']);// PHP_SELF
    exit();
?>