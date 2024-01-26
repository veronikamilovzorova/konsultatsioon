<?php
include('navi.php')
?>


<?php

require('conf.php');

global $yhendus;


function printTable($data)
{
    echo "<table id='data-table'>";
    echo "<tr>";
    echo "<th>Päev</th>";
    echo "<th>Tund</th>";
    echo "<th>Klassiruum</th>";
    echo "<th>Periood</th>";
    echo "<th>Kommentaar</th>";

    echo "</tr>";

    foreach ($data as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['paev']) . "</td>";
        echo "<td>" . htmlspecialchars($row['tund']) . "</td>";
        echo "<td>" . htmlspecialchars($row['klassiruum']) . "</td>";
        echo "<td>" . htmlspecialchars($row['periood']) . "</td>";
        echo "<td>" . htmlspecialchars($row['kommentaar']) . "</td>";

        echo "</tr>";
    }

    echo "</table>";
}



$kask_select_opetajad = $yhendus->prepare("SELECT DISTINCT opetajaNimi FROM konsultatsioon");
$kask_select_opetajad->execute();
$result_opetajad = $kask_select_opetajad->get_result();
$opetajad = $result_opetajad->fetch_all(MYSQLI_ASSOC);

$kask_select_perioodid = $yhendus->prepare("SELECT DISTINCT periood FROM konsultatsioon");
$kask_select_perioodid->execute();
$result_perioodid = $kask_select_perioodid->get_result();
$periods = $result_perioodid->fetch_all(MYSQLI_ASSOC);

$selectedTeacher = isset($_GET['opetaja']) ? urldecode($_GET['opetaja']) : '';
$selectedPeriod = isset($_GET['periood']) ? $_GET['periood'] : '';

if ($selectedTeacher || $selectedPeriod) {
    if ($selectedTeacher && $selectedPeriod) {
        $kask_select = $yhendus->prepare("SELECT paev, tund, klassiruum, periood, kommentaar, opetajaNimi FROM konsultatsioon WHERE opetajaNimi = ? AND periood = ?");
        $kask_select->bind_param("si", $selectedTeacher, $selectedPeriod);
    } elseif ($selectedTeacher) {
        $kask_select = $yhendus->prepare("SELECT paev, tund, klassiruum, periood, kommentaar, opetajaNimi FROM konsultatsioon WHERE opetajaNimi = ?");
        $kask_select->bind_param("s", $selectedTeacher);
    } elseif ($selectedPeriod) {
        $kask_select = $yhendus->prepare("SELECT paev, tund, klassiruum, periood, kommentaar, opetajaNimi FROM konsultatsioon WHERE periood = ?");
        $kask_select->bind_param("i", $selectedPeriod);
    }
} else {
    $kask_select = $yhendus->prepare("SELECT paev, tund, klassiruum, periood, kommentaar, opetajaNimi FROM konsultatsioon");
}

$kask_select->execute();
$result = $kask_select->get_result();
$data = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="kasutaja.css">

    <title>Kasutaja</title>


</head>
<body>

<!-- Отображение выбранного периода -->
<?php if ($selectedPeriod && !$selectedTeacher): ?>
    <div class="period">Periood <?php echo $selectedPeriod; ?></div>
<?php endif; ?>

<header><?php echo strtoupper($selectedTeacher); ?></header>


<?php printTable($data); ?>

</body>
</html>

