<?php

require('conf.php');

global $yhendus;

session_start();

$kask_select_opetajad = $yhendus->prepare("SELECT DISTINCT opetajaNimi FROM konsultatsioon");
$kask_select_opetajad->execute();
$result_opetajad = $kask_select_opetajad->get_result();
$opetajad = $result_opetajad->fetch_all(MYSQLI_ASSOC);


$kask_select_perioodid = $yhendus->prepare("SELECT DISTINCT periood FROM konsultatsioon");
$kask_select_perioodid->execute();
$result_perioodid = $kask_select_perioodid->get_result();
$periods = $result_perioodid->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="navi.css">
    <title>Tere</title>
    <style>


        video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }





        .dropdown {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .category:hover .dropdown {
            display: block;
        }
    </style>
</head>
<body>


<video autoplay muted loop>
    <source src="get.mp4" type="video/mp4">
    Your browser does not support the video tag.
</video>

<header>KONSULTATSIOONI LEHT</header>
<a href="logout.php" class="logout-link">Logi välja</a>



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
                $tund_query = "SELECT tund FROM konsultatsioon WHERE opetajaNimi = ?";
                $stmt_tund = $yhendus->prepare($tund_query);
                $stmt_tund->bind_param("s", $opetajaNimi);
                $stmt_tund->execute();
                $stmt_tund_result = $stmt_tund->get_result();
                $tund_data = $stmt_tund_result->fetch_assoc();
                $tund_value = $tund_data['tund'];
                ?>
                <?php if ($tund_value !== '-'): ?>
                    <li><a href="kasutaja.php?opetaja=<?= urlencode($opetajaNimi) ?>" class="menu common-link small-link" ><?php echo $opetajaNimi; ?></a></li>
                <?php else: ?>
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
                <li><a href="kasutaja.php?periood=<?= $period['periood'] ?>" class="menu common-link small-link"><?php echo $period['periood']; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<div id="important">
    <h1>OLULINE</h1>
    <div id="important-text">
        <p>Tere!
            Õpetajate koolituste tõttu võivad konsultatsioonide ajad muutuda.
            Palun jälgige võimalikke muudatusi.
            Aitäh mõistva suhtumise eest!</p>
    </div>
</div>


<?php
if (!isset($_SESSION['onAdmin']) || $_SESSION['onAdmin'] == 0) {
echo '<div class="category"><a href="registr.php" class="menu common-link">REGISTR</a></div>';
}
?>





<div id="clock" class="clock"></div>

<script>
    function updateClock() {
        var now = new Date();
        var hours = now.getHours();
        var minutes = now.getMinutes();
        var seconds = now.getSeconds();

        hours = hours < 10 ? "0" + hours : hours;
        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;


        document.getElementById("clock").innerHTML = hours + ":" + minutes + ":" + seconds;


        setTimeout(updateClock, 1000);
    }


    document.addEventListener("DOMContentLoaded", function () {
        updateClock();
    });
</script>



</body>
</html>

