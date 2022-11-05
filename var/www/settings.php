<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>RadioBeere - Einstellungen verwalten</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <?php
    include("include/styling.php");
    ?>
</head>

<body>
    <div data-role="page"
         class="ui-responsive-panel"
         id="panel"
         data-title="RadioBeere"
         data-dom-cache="false">
        <div data-role="header">
            <a href="#nav-panel"
                 data-icon="bars"
                 data-iconpos="notext">Menü</a>
            <h1>RadioBeere</h1>
            <a href="/"
                 data-icon="home"
                 data-iconpos="notext">Startseite</a>
        </div>

        <div data-role="main"
             class="ui-content">
            <h2>Sender verwalten</h2>

            <?php
            include("include/db-connect.php");
            ?>

<!-- Delete stations and related timers -->

            <?php
            if ($_POST['del'])
                {
                foreach ($_POST['del'] as $eintrag)
                    {
                    $abfrage_sender = "SELECT * FROM sender WHERE id = $eintrag";
                    $ergebnis = mysqli_query($verbindung, $abfrage_sender);
                    while($row = mysqli_fetch_object($ergebnis))
                        {
                        $loeschen_timer = "DELETE FROM timer WHERE alias = '$row->alias'";
                        $loesch_timer = mysqli_query($verbindung, $loeschen_timer);
                        }
                    $loeschen = "DELETE FROM sender WHERE id = $eintrag";
                    $loesch = mysqli_query($verbindung, $loeschen);
                    }
                unset($del);
                exec("sudo /home/pi/radiobeere/rb-timer-update.py");
                echo "<b><font color=\"#f00\">Sender gel&ouml;scht!</font></b><br><br>";
                echo "<script type=\"text/javascript\">setTimeout(function(){location.reload(true);}, 3000);</script>";
                }
            ?>

<!-- Add stations -->

          
            <h3>Einstellungen verwalten</h3>

            <form method="post"
                  id="verwalten_einstellungen"
                  enctype="multipart/form-data">
              
              
            <?php
            if ($name !="")
                {
                $abfrage = "SELECT * FROM settings;";
                $ergebnis = mysqli_query($verbindung, $abfrage);
                while($row = mysqli_fetch_object($ergebnis))
                    {
                    echo "<label for=\"name\">" . $row->name . ": <input type=\"text\"
                       name=\"" . $row->name . "\"
                       id=\"" . $row->name . "\"
                       value id=\"" . $row->wert . "\"/>";
                    }
             ?>
          </form>
              </div>
            <div class="illu-content-wrapper">
                <div class="illu-content illu-stations">
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
