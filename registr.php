<?php
include('navi.php')
?>

<?php

require('conf.php');

global $yhendus;


$query_paev = "SELECT DISTINCT paev FROM konsultatsioon";
$result_paev = $yhendus->query($query_paev);
$options_paev = array();

while ($row_paev = $result_paev->fetch_assoc()) {
    $options_paev[] = $row_paev['paev'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="regis.css">
    <title>Регистрация</title>

</head>
<body>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedOption1 = $_POST["select_option1"];
    $selectedOption2 = $_POST["select_option2"];


    echo "<p class='success-message'>Olete edukalt registreerunud!</p>";
    echo "<div class='user-selection'>";
    echo "<h2>Teie valikud:</h2>";
    echo "<p><strong>Päev:</strong> $selectedOption1</p>";
    echo "<p><strong>Õpetaja nimi:</strong> $selectedOption2</p>";

// Добавляем остальные данные
    $selectedOption3 = $_POST["select_option3"];
    $selectedOption4 = $_POST["select_option4"];

    echo "<p><strong>Tund:</strong> $selectedOption3</p>";
    echo "<p><strong>Periood:</strong> $selectedOption4</p>";

// Добавьте вывод остальных данных, если есть
    echo "</div>";


}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="select_option1">Päev:</label>
    <select name="select_option1" id="select_option1">
        <?php

        foreach ($options_paev as $option) {
            echo "<option value=\"$option\">$option</option>";
        }
        ?>
    </select>
    <br>


    <label for="select_option2">Õpetaja nimi:</label>
    <select name="select_option2" id="select_option2">
        <?php
        $query_opetajaNimi = "SELECT DISTINCT opetajaNimi FROM konsultatsioon WHERE opetajaNimi != 'Taivos Mäng'";
        $result_opetajaNimi = $yhendus->query($query_opetajaNimi);
        $options_opetajaNimi = array();

        while ($row_opetajaNimi = $result_opetajaNimi->fetch_assoc()) {
            $opetajaNimi_value = $row_opetajaNimi['opetajaNimi'];
            $options_opetajaNimi[] = $opetajaNimi_value;
            echo "<option value=\"$opetajaNimi_value\">$opetajaNimi_value</option>";
        }
        ?>
    </select>
    <br>



    <label for="select_option3">Tund:</label>
    <select name="select_option3" id="select_option3">
        <?php
        $query_tund = "SELECT DISTINCT tund FROM konsultatsioon WHERE tund != '-'";
        $result_tund = $yhendus->query($query_tund);
        $options_tund = array();

        while ($row_tund = $result_tund->fetch_assoc()) {
            $tund_value = $row_tund['tund'];
            $options_tund[] = $tund_value;
            echo "<option value=\"$tund_value\">$tund_value</option>";
        }
        ?>
    </select>
    <br>



    <label for="select_option4">Periood:</label>
    <select name="select_option4" id="select_option4">
        <?php
        $query_periood = "SELECT DISTINCT periood FROM konsultatsioon";
        $result_periood = $yhendus->query($query_periood);
        $options_periood = array();

        while ($row_periood = $result_periood->fetch_assoc()) {
            $options_periood[] = $row_periood['periood'];
        }

        foreach ($options_periood as $option) {
            echo "<option value=\"$option\">$option</option>";
        }
        ?>
    </select>

    <br>

    <input type="submit" value="Registreeri">
</form>

</body>
</html>


