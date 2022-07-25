<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>RadioBeere - Aufnahme planen</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <?php
    include("include/styling.php");
    ?>
</head>

<body>

    <?php
    $alias = $_POST["alias"];
    $stunde = $_POST["stunde"];
    $minute = $_POST["minute"];
    $dauer = $_POST["dauer"];
    $datum = $_POST["datum"];
    $wochentage = $_POST["wochentage"];
    ?>

    <?php
    include("include/db-connect.php");
    ?>

    <div data-role="page"
         class="ui-responsive-panel"
         id="panel"
         data-title="RadioBeere">
        <div data-role="header">
            <a href="#nav-panel"
                 data-icon="bars"
                 data-iconpos="notext">Menü</a>
            <h1>RadioBeere</h1>
            <a href="/"
                 data-icon="home"
                 data-iconpos="notext">Startseite</a>
        </div>

        <?php
        $sekunden = $dauer * 60;
        $abfrage = "SELECT name, url FROM sender WHERE alias = '$alias';";
        $ergebnis = mysqli_query($verbindung, $abfrage);
        while($row = mysqli_fetch_object($ergebnis))
            {
            $sender = "$row->name";
            $url = "$row->url";
            }

        if ($datum != "")
            {
            $wochentage ="*";
            $tag = (substr($datum,0,2));
            $monat = (substr($datum,3,2));
            $jahr = (substr($datum,6,4));
            $zeitstempel = (mktime($stunde,$minute,0,$monat,$tag,$jahr));
            }
        else
            {
            $tag = "*";
            $monat = "*";
            $zeitstempel = "";
            $klarnamen = array("Sonntag","Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag");
            $i = "0";
            while($i < 7)
                {
                $a = (string) "$i";
                $pos = strpos($wochentage, $a);
                if ($pos !== false)
                    {
                    $klartext .= "$klarnamen[$i], ";
                    }
                $i++;
                }
            $wtage = substr_replace($klartext, '', -2, 2);
            if ($wtage == "Sonntag, Montag, Dienstag, Mittwoch, Donnerstag, Freitag, Samstag")
                {
                $wtage = "Täglich";
                }
            }
        ?>

        <?php
        $eintrag = "INSERT INTO timer (sender, alias, stunde, minute, wochentage, dauer, tag, monat, zeitstempel) VALUES ('$sender', '$alias', '$stunde', '$minute', '$wochentage', '$sekunden', '$tag', '$monat', '$zeitstempel');";
        $eintragen = mysqli_query($verbindung, $eintrag);
        exec("sudo /home/pi/radiobeere/rb-timer-update.py");
        ?>

        <div data-role="main"
             class="ui-content">
            <h2>Aufnahme planen</h2>

            <p>Du hast folgende Aufnahme geplant:</p>

            <?php
            echo "Sender: <b>$sender</b><br><br>";
            if ($datum != "")
                {
                echo "Datum: <b>$datum</b><br>";
                }
            echo "Uhrzeit: <b>$stunde:$minute Uhr</b><br>";
            echo "Dauer: <b>$dauer Minuten</b><br>";
            if ($wtage != "")
                {
                echo "Wochentage: <b>$wtage</b>";
                }
            ?>

            <p>Alles korrekt?</p>

            <form action="index.php"
                  method="post">
                <button type="submit"
                      name="start"
                      id="start">Ja, zur Startseite</button>
            </form>

            <form action="record.php"
                  method="post">
                <button type="submit"
                      name="reset"
                      id="reset"
                      value="1">Nein, nochmal von vorne</button>
            </form>

            <div class="illu-content-wrapper">
                <div class="illu-content illu-record">
                </div>
            </div>
        </div>
        <?php
        include("include/navigation.php");
        ?>
    </div>
    <?php
    include("include/jquery.php");
    ?>
</body>
</html>
