<?php
session_start();

if (isset($_POST["newgame"])) {
    $_SESSION = "";
    session_destroy();
} else {
    $_SESSION['catPos'][0] = 1;
    $_SESSION['catPos'][1] = 1;
}

header('Location: ../../index.php');
