<?php
$verbindung = mysqli_connect("localhost","radiobeere","password");

if (!$verbindung) {
  echo "Fehler bei DB-Verbindung!";
  exit;
}

mysqli_select_db($verbindung, "radiobeere");
?>
