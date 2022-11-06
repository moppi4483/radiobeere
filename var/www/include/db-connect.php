<?php
$verbindung = mysqli_connect("localhost","radiobeere","password");

if (!$verbindung) {
  echo "Fehler bei DB-Verbindung!";
  exit;
}

mysqli_select_db($verbindung, "radiobeere");



function getFQDN($verb) {
        $fqdn = "";

        $abfrage = "SELECT * FROM settings WHERE name = 'FQDN';";
        $ergebnis = mysqli_query($verb, $abfrage);
        while($row = mysqli_fetch_object($ergebnis)) {
                $fqdn = $row->wert;
        }

        if($fqdn == '') {
                $fqdn = gethostname();
        }

        return $fqdn;
}


function getProtokoll($verb) {
        $prot = "";
        $abfrage = "SELECT * FROM settings WHERE name = 'Protokoll';";
        $ergebnis = mysqli_query($verb, $abfrage);
        while($row = mysqli_fetch_object($ergebnis)) {
                $prot = $row->wert;
        }

        if($prot == '') {
                $prot = 'http';
        }

        return $prot;
}


function setSettings($verb, $fqdn, $prot) {
        $abfrage = "INSERT INTO settings (name, wert) VALUES('FQDN', '" . $fqdn . "'), ('Protokoll', '" . $prot . "') ON DUPLICATE KEY UPDATE wert=VALUES(wert);";
        try {
                if(!mysqli_query($verb, $abfrage)) {
                        throw new Exception(mysqli_error($verb));
                } else {
                        echo "<p>Einstellungen gespeichert</p>";
                }
        }
        catch (Exception $e) {
                echo $e -> getMessage();
        }
  
  return $ergebnis;
}
?>
