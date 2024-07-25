<?php
 
$mysqli = new mysqli("localhost","root","1010","e-osiedle");

session_start();

function zero() {
  $_SESSION['logged'] = false;
  $_SESSION['admin'] = false;
  $_SESSION['user_id'] = -1;
}

if ($mysqli -> connect_errno) {
  echo "Błąd podczas połączenia z bazą danych: " . $mysqli -> connect_error;
  exit();
}

if (!isset($_SESSION['logged'])) {
  zero();
}

if (isset($_GET['logout'])) {
  // Usuń wszystkie dane sesji
  session_unset();

  // Usuń sesję
  session_destroy();

  zero();

  // Przekierowuje na bieżącą stronę, aby zapobiec ponownemu przesłaniu formularza.
  //header("Location: index.php");
  //header("Location: ".$_SERVER['PHP_SELF']);// PHP_SELF
  exit();
}

?>