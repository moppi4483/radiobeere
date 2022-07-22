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
    $datum = $_POST["datum"];
    $wochentage = $_POST["wochentage"];
    if($wochentage == "")
        {
        $wochentage = "*";
        }
    else
        {
        foreach($wochentage AS $wochentag)
            {
            ob_start();
            echo "$wochentag,";
            $tage .= ob_get_contents();
            ob_end_clean();
            }
        $wochentage = trim($tage, ",");
        }
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

            <p>Wähle Uhrzeit und Länge der Aufnahme.</p>

            <form action="record4.php"
                  method="post">

                <?php
                echo "<input type=\"hidden\" name=\"alias\" value=\"$alias\">";
                echo "<input type=\"hidden\" name=\"datum\" value=\"$datum\">";
                echo "<input type=\"hidden\" name=\"wochentage\" value=\"$wochentage\">";
                ?>

                <p>Uhrzeit (hh:mm):</p>

                <div data-role="controlgroup"
                     data-type="horizontal">
                    <select name="stunde">
                        <option value="00">
                            00
                        </option>
                        <option value="01">
                            01
                        </option>
                        <option value="02">
                            02
                        </option>
                        <option value="03">
                            03
                        </option>
                        <option value="04">
                            04
                        </option>
                        <option value="05">
                            05
                        </option>
                        <option value="06">
                            06
                        </option>
                        <option value="07">
                            07
                        </option>
                        <option value="08">
                            08
                        </option>
                        <option value="09">
                            09
                        </option>
                        <option value="10">
                            10
                        </option>
                        <option value="11">
                            11
                        </option>
                        <option value="12">
                            12
                        </option>
                        <option value="13">
                            13
                        </option>
                        <option value="14">
                            14
                        </option>
                        <option value="15">
                            15
                        </option>
                        <option value="16">
                            16
                        </option>
                        <option value="17">
                            17
                        </option>
                        <option value="18">
                            18
                        </option>
                        <option value="19">
                            19
                        </option>
                        <option value="20">
                            20
                        </option>
                        <option value="21">
                            21
                        </option>
                        <option value="22">
                            22
                        </option>
                        <option value="23">
                            23
                        </option>
                    </select>
                    <select name="minute">
                        <option value="00">
                            00
                        </option>
                        <option value="05">
                            05
                        </option>
                        <option value="10">
                            10
                        </option>
                        <option value="15">
                            15
                        </option>
                        <option value="20">
                            20
                        </option>
                        <option value="25">
                            25
                        </option>
                        <option value="30">
                            30
                        </option>
                        <option value="35">
                            35
                        </option>
                        <option value="40">
                            40
                        </option>
                        <option value="45">
                            45
                        </option>
                        <option value="50">
                            50
                        </option>
                        <option value="55">
                            55
                        </option>
                    </select>
                </div>
                <br />
                <label for="slider-dauer">Dauer der Aufnahme (in
                Minuten):</label> <input type="range"
                      name="dauer"
                      id="slider-dauer"
                      value="0"
                      min="0"
                      max="300"
                      step="5" /><br />
                <br />
                <button type="submit"
                      name="submit">Programmierung abschließen</button>
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
