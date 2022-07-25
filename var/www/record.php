<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>RadioBeere - Aufnahmen planen</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <?php
    include("include/styling.php");
    ?>
</head>

<body>

    <?php
    include("include/db-connect.php");
    ?>

<!-- Delete latest timer -->

    <?php
    $reset = $_POST["reset"];
    if ($reset == "1")
        {
        $abfrage = "SELECT id FROM timer ORDER BY id DESC LIMIT 1;";
        $ergebnis = mysqli_query($verbindung, $abfrage);
        while($row = mysqli_fetch_object($ergebnis))
             {
            $id =("$row->id");
             }
        $loeschen = "DELETE FROM timer WHERE id = '$id';";
        $loesch = mysqli_query($verbindung, $loeschen);
        $reset = "0";
        }
    exec("sudo /home/pi/radiobeere/rb-timer-update.py");
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

        <div data-role="main"
             class="ui-content">
            <h2>Aufnahme planen</h2>

            <p>Was möchtest du aufnehmen?</p>

            <div class="ui-field-contain">
                <form action="record2.php"
                      method="post">
                    <select name="alias"
                          onchange=
                          "if(this.value != 0) { this.form.submit(); }">
                        <option value="">
                            Sender auswählen
                        </option>

                        <?php
                        $abfrage = "SELECT name, alias FROM sender ORDER BY name;";
                        $ergebnis = mysqli_query($verbindung, $abfrage);
                        while($row = mysqli_fetch_object($ergebnis))
                            {
                            echo "<option value=\"$row->alias\">$row->name</option>";
                            }
                        ?>

                    </select>
                </form>
            </div>

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
