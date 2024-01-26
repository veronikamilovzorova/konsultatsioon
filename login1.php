<?php
// Laeme konfiguratsioonifaili
require('conf.php');

// Alustame sessiooni
session_start();

// Määrame ühenduse globaalseks muutujaks
global $yhendus;

// Kui POST päringus on esitatud registreerimise andmed
if (!empty($_POST['register-login']) && !empty($_POST['register-pass'])) {
    // Võtame vastu ja puhastame sisestatud kasutajanime ja parooli
    $registerLogin = htmlspecialchars(trim($_POST['register-login']));
    $registerPass = htmlspecialchars(trim($_POST['register-pass']));

    // Soolamine parooli turvalisuse tagamiseks
    $salt = "superpaev";
    $hashedPass = crypt($registerPass, $salt);

    // Valmistame ette andmebaasi päringu kasutaja registreerimiseks
    $insertQuery = $yhendus->prepare("INSERT INTO kasutaja (kasutaja, parool, onAdmin) VALUES (?, ?, 0)");
    $insertQuery->bind_param("ss", $registerLogin, $hashedPass);

    // Kui päring õnnestub, kuvame sõnumi ja määrame sessiooni onAdmin väärtuseks 0
    if ($insertQuery->execute()) {
        echo "Registreerimine õnnestus";

        // Määrame onAdmin väärtuseks 0 tavalisele kasutajale
        $_SESSION['onAdmin'] = 0;
    } else {
        echo "Registreerimine ebaõnnestus";
    }

    // Sulgeme päringu
    $insertQuery->close();
}

// Kui POST päringus on esitatud sisselogimise andmed
if (!empty($_POST['login']) && !empty($_POST['pass'])) {
    // Võtame vastu ja puhastame sisestatud kasutajanime ja parooli
    $login = htmlspecialchars(trim($_POST['login']));
    $pass = htmlspecialchars(trim($_POST['pass']));

    // Soolamine parooli turvalisuse tagamiseks
    $salt = "superpaev";
    $hashedPass = crypt($pass, $salt);

    // Valmistame ette andmebaasi päringu kasutaja sisselogimiseks
    $kask = $yhendus->prepare("SELECT kasutaja, onAdmin FROM kasutaja WHERE kasutaja=? AND parool=?");
    $kask->bind_param("ss", $login, $hashedPass);
    $kask->bind_result($kasutaja, $onAdmin);
    $kask->execute();

    // Kui päring annab tulemuse, siis sisselogimine õnnestus
    if ($kask->fetch()) {
        // Sisselogimine õnnestus, salvestame kasutaja sessiooni
        $_SESSION['kasutaja'] = $kasutaja;

        // Määrame onAdmin väärtuseks sessioonis vastavalt kasutaja rollile
        $_SESSION['onAdmin'] = $onAdmin;

        // Suuname kasutaja navi.php lehele
        header("Location: navi.php");
        exit;
    } else {
        echo "Sisselogimine ebaõnnestus";
    }

    // Sulgeme päringu
    $kask->close();
    // Sulgeme andmebaasi ühenduse
    $yhendus->close();
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Lisa stiilileht ja stiilid sellele -->
    <link rel="stylesheet" href="logstylee.css">
    <style>
        /* Lisa taustavideo ja sellele stiilid */
        video {
            position: fixed;
            top: 0;
            left: 0;
            min-width: 100%;
            min-height: 100%;
            z-index: -1;
        }
    </style>
</head>
<body>
<!-- Taustavideo, millel on autoplay, mute ja loop atribuudid -->
<video autoplay muted loop>
    <source src="sun.mp4" type="video/mp4">
    Teie veebilehitseja ei toeta videotag'i.
</video>

<script>
    // JavaScript sündmus, mis käivitub dokumendi laadimisel
    document.addEventListener('DOMContentLoaded', function () {
        openModal();
    });
</script>

<!-- Modaalaken sisselogimiseks -->
<div id="modal">
    <h1>Sisselogimine</h1>
    <!-- Sisselogimisvorm POST meetodiga -->
    <form id="loginForm" action="" method="post">
        Kasutajanimi: <input type="text" name="login"><br>
        Parool: <input type="password" name="pass"><br>
        <input type="submit" value="Logi sisse">
    </form>

    <!-- Registreerimise nupp, millel on JavaScript sündmus -->
    <p>Pole veel registreeritud? <button onclick="openRegistrationPanel()">Registreerimine</button></p>

    <!-- Registreerimispaneel, vaikimisi peidetud -->
    <div id="registrationPanel" style="display: none;">
        <h1>Registreeri!</h1>
        <!-- Registreerimisvorm POST meetodiga -->
        <form id="registrationForm" action="" method="post">
            Kasutajanimi: <input type="text" name="register-login"><br>
            Parool: <input type="password" name="register-pass"><br>
            <input type="submit" value="Registreerida">
        </form>
    </div>

    <!-- Sulgemisnupp, millel on JavaScript sündmus -->
    <button onclick="closeModal()">Sulge</button>
</div>

<!-- JavaScript funktsioonid modaali avamiseks, sulgemiseks ja registreerimispaneeli avamiseks -->
<script>
    function openModal() {
        document.getElementById('modal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('modal').style.display = 'none';
    }

    function openRegistrationPanel() {
        document.getElementById('registrationPanel').style.display = 'block';
    }
</script>

</body>
</html>



