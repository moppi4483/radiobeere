<?php
$verbindung = mysqli_connect("localhost","radiobeere","password");

if (!$verbindung) {
  echo "Fehler bei DB-Verbindung!";
  exit;
}

mysqli_select_db($verbindung, "radiobeere");



function getFQDN() {
  $fqdn = "";
  
  $abfrage = "SELECT * FROM settings WHERE name = 'FQDN';";
  $ergebnis = mysqli_query($verbindung, $abfrage);
  while($row = mysqli_fetch_object($ergebnis)) {
    $fqdn = $row->wert;
  }
  
  return $fqdn;
}



function setFQDN($fqdn) {
  $abfrage = "INSERT INTO table (name, wert) VALUES('FQDN', '" . $fqdn . "') ON DUPLICATE KEY UPDATE wert='" . $fqdn . "';";
  $ergebnis = mysqli_query($verbindung, $abfrage);
  
  return $ergebnis;
}
?>
