<?php
// Sisaldame navigatsioonifaili
include('navi.php');
?>

<?php
// Laadime konfiguratsioonifaili
require('conf.php');

// Määrame ühenduse globaalseks muutujaks
global $yhendus;

// Funktsioon tabeli väljastamiseks
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

// Laadime õpetajate andmed
$kask_select_opetajad = $yhendus->prepare("SELECT DISTINCT opetajaNimi FROM konsultatsioon");
$kask_select_opetajad->execute();
$result_opetajad = $kask_select_opetajad->get_result();
$opetajad = $result_opetajad->fetch_all(MYSQLI_ASSOC);

// Laadime perioodide andmed
$kask_select_perioodid = $yhendus->prepare("SELECT DISTINCT periood FROM konsultatsioon");
$kask_select_perioodid->execute();
$result_perioodid = $kask_select_perioodid->get_result();
$periods = $result_perioodid->fetch_all(MYSQLI_ASSOC);

// Valitud õpetaja ja perioodi salvestamine
$selectedTeacher = isset($_GET['opetaja']) ? urldecode($_GET['opetaja']) : '';
$selectedPeriod = isset($_GET['periood']) ? $_GET['periood'] : '';

// Kui on valitud õpetaja või periood
if ($selectedTeacher || $selectedPeriod) {
    // Kui on valitud mõlemad
    if ($selectedTeacher && $selectedPeriod) {
        $kask_select = $yhendus->prepare("SELECT paev, tund, klassiruum, periood, kommentaar, opetajaNimi FROM konsultatsioon WHERE opetajaNimi = ? AND periood = ?");
        $kask_select->bind_param("si", $selectedTeacher, $selectedPeriod);
    } elseif ($selectedTeacher) {
        // Kui on valitud ainult õpetaja
        $kask_select = $yhendus->prepare("SELECT paev, tund, klassiruum, periood, kommentaar, opetajaNimi FROM konsultatsioon WHERE opetajaNimi = ?");
        $kask_select->bind_param("s", $selectedTeacher);
    } elseif ($selectedPeriod) {
        // Kui on valitud ainult periood
        $kask_select = $yhendus->prepare("SELECT paev, tund, klassiruum, periood, kommentaar, opetajaNimi FROM konsultatsioon WHERE periood = ?");
        $kask_select->bind_param("i", $selectedPeriod);
    }
} else {
    // Kui ei ole valitud õpetajat ega perioodi, laadime kõik andmed
    $kask_select = $yhendus->prepare("SELECT paev, tund, klassiruum, periood, kommentaar, opetajaNimi FROM konsultatsioon");
}

// Käivitame päringu
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

<!-- Kuvame valitud perioodi -->
<?php if ($selectedPeriod && !$selectedTeacher): ?>
    <div class="period">Periood <?php echo $selectedPeriod; ?></div>
<?php endif; ?>

<header><?php echo strtoupper($selectedTeacher); ?></header>

<?php printTable($data); ?>

</body>
</html>


