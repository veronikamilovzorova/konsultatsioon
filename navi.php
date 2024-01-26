<?php
// Laeme konfiguratsioonifaili
require('conf.php');

// Määrame ühenduse globaalseks muutujaks
global $yhendus;

// Alustame sessiooni
session_start();

// Valmistame ette päringu unikaalsete õpetajate nimekiri saamiseks
$kask_select_opetajad = $yhendus->prepare("SELECT DISTINCT opetajaNimi FROM konsultatsioon");
$kask_select_opetajad->execute();
$result_opetajad = $kask_select_opetajad->get_result();
$opetajad = $result_opetajad->fetch_all(MYSQLI_ASSOC);

// Valmistame ette päringu unikaalsete perioodide nimekiri saamiseks
$kask_select_perioodid = $yhendus->prepare("SELECT DISTINCT periood FROM konsultatsioon");
$kask_select_perioodid->execute();
$result_perioodid = $kask_select_perioodid->get_result();
$periods = $result_perioodid->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="navi.css">
    <title>Tere</title>
    <style>
        /* Taustavideole stiilid */
        video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        /* Dropdowni stiilid */
        .dropdown {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        /* Dropdowni kuvamine, kui kategooriat hoitakse peal */
        .category:hover .dropdown {
            display: block;
        }
    </style>
</head>
<body>

<!-- Taustavideo, millel on autoplay, mute ja loop atribuudid -->
<video autoplay muted loop>
    <source src="get.mp4" type="video/mp4">
    Teie veebilehitseja ei toeta videotag'i.
</video>

<!-- Lehe päise ala -->
<header>KONSULTATSIOONI LEHT</header>

<!-- Väljalogimise link -->
<a href="logout.php" class="logout-link">Logi välja</a>

<!-- Kategooriad ja dropdown-menüüd -->
<div class="category">
    <a href="navi.php" class="menu common-link">Avaleht</a>
</div>

<div class="category">
    <a href="#" class="menu common-link">Õpetaja</a>
    <div class="dropdown">
        <ul>
            <?php foreach ($opetajad as $opetaja): ?>
                <?php
                $opetajaNimi = $opetaja['opetajaNimi'];
                // Valmistame ette päringu õpetaja tundide saamiseks
                $tund_query = "SELECT tund FROM konsultatsioon WHERE opetajaNimi = ?";
                $stmt_tund = $yhendus->prepare($tund_query);
                $stmt_tund->bind_param("s", $opetajaNimi);
                $stmt_tund->execute();
                $stmt_tund_result = $stmt_tund->get_result();
                $tund_data = $stmt_tund_result->fetch_assoc();
                $tund_value = $tund_data['tund'];
                ?>
                <?php if ($tund_value !== '-'): ?>
                    <!-- Lingid õpetaja lehele, normaalsete tundide korral -->
                    <li><a href="kasutaja.php?opetaja=<?= urlencode($opetajaNimi) ?>" class="menu common-link small-link" ><?php echo $opetajaNimi; ?></a></li>
                <?php else: ?>
                    <!-- Lingid õpetaja lehele, punase värviga, kui tal tund puudub -->
                    <li><a href="kasutaja.php?opetaja=<?= urlencode($opetajaNimi) ?>" class="menu common-link small-link" style="color: red;"><?php echo $opetajaNimi; ?></a></li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<div class="category">
    <a href="#" class="menu common-link">Periood</a>
    <div class="dropdown">
        <ul>
            <?php foreach ($periods as $period): ?>
                <!-- Lingid perioodi lehele -->
                <li><a href="kasutaja.php?periood=<?= $period['periood'] ?>" class="menu common-link small-link"><?php echo $period['periood']; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<!-- Oluline info ala -->
<div id="important">
    <h1>OLULINE</h1>
    <div id="important-text">
        <p>Tere!
            Õpetajate koolituste tõttu võivad konsultatsioonide ajad muutuda.
            Palun jälgige võimalikke muudatusi.
            Aitäh mõistva suhtumise eest!</p>
    </div>
</div>

<!-- Registreerimise link -->
<?php
// Kuvame registreerimise lingi ainult siis, kui kasutaja pole administraator
if (!isset($_SESSION['onAdmin']) || $_SESSION['onAdmin'] == 0) {
    echo '<div class="category"><a href="registr.php" class="menu common-link">REGISTR</a></div>';
}
?>

<!-- Kellaaja kuvamise koht -->
<div id="clock" class="clock"></div>

<!-- JavaScript funktsioon kellaaja värskendamiseks -->
<script>
    function updateClock() {
        var now = new Date();
        var hours = now.getHours();
        var minutes = now.getMinutes();
        var seconds = now.getSeconds();

        // Lisa nullid, kui on vajalik
        hours = hours < 10 ? "0" + hours : hours;
        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        // Kuva kella
        document.getElementById("clock").innerHTML = hours + ":" + minutes + ":" + seconds;

        // Uuenda kella iga sekundi järel
        setTimeout(updateClock, 1000);
    }

    // Sündmus dokumendi laadimisel, et alustada kellaaja värskendamist
    document.addEventListener("DOMContentLoaded", function () {
        updateClock();
    });
</script>

</body>
</html>

