<?php

require('conf.php');

session_start();
global $yhendus;

if (!empty($_POST['register-login']) && !empty($_POST['register-pass'])) {
    $registerLogin = htmlspecialchars(trim($_POST['register-login']));
    $registerPass = htmlspecialchars(trim($_POST['register-pass']));

    $cool = "superpaev";
    $hashedPass = crypt($registerPass, $cool);

    $insertQuery = $yhendus->prepare("INSERT INTO kasutaja (kasutaja, parool, onAdmin) VALUES (?, ?, 0)");
    $insertQuery->bind_param("ss", $registerLogin, $hashedPass);

    if ($insertQuery->execute()) {
        echo "Registration successful";

        // Установите onAdmin в 0 для обычных пользователей
        $_SESSION['onAdmin'] = 0;
    } else {
        echo "Registration failed";
    }

    $insertQuery->close();
}

if (!empty($_POST['login']) && !empty($_POST['pass'])) {
    $login = htmlspecialchars(trim($_POST['login']));
    $pass = htmlspecialchars(trim($_POST['pass']));

    $cool = "superpaev";
    $krypt = crypt($pass, $cool);

    $kask = $yhendus->prepare("SELECT kasutaja, onAdmin FROM kasutaja WHERE kasutaja=? AND parool=?");
    $kask->bind_param("ss", $login, $krypt);
    $kask->bind_result($kasutaja, $onAdmin);
    $kask->execute();

    if ($kask->fetch()) {
        // Вход выполнен успешно
        $_SESSION['kasutaja'] = $kasutaja;

        // Установите onAdmin в сессии в соответствии с ролью пользователя
        $_SESSION['onAdmin'] = $onAdmin;

        header("Location: navi.php");
        exit;
    } else {
        echo "Login failed";
    }

    $kask->close();
    $yhendus->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="logstylee.css">
    <style>
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
<video autoplay muted loop>
    <source src="sun.mp4" type="video/mp4">
    Your browser does not support the video tag.
</video>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        openModal();
    });
</script>

<div id="modal">
    <h1>Login</h1>
    <form id="loginForm" action="" method="post">
        Login: <input type="text" name="login"><br>
        Password: <input type="password" name="pass"><br>
        <input type="submit" value="Logi sisse">
    </form>

    <p>Pole veel registreeritud? <button onclick="openRegistrationPanel()">Registreerimine</button></p>

    <div id="registrationPanel" style="display: none;">
        <h1>Registreeri!</h1>
        <form id="registrationForm" action="" method="post">
            Login: <input type="text" name="register-login"><br>
            Password: <input type="password" name="register-pass"><br>
            <input type="submit" value="Registreerida">
        </form>
    </div>

    <button onclick="closeModal()">Sulge</button>
</div>

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


