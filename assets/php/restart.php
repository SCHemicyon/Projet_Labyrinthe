<?php

session_start();

if (isset($_POST["newgame"])) {
    $_SESSION = "";
    session_destroy();
} else if (isset($_POST["restart"])){
    $_SESSION['catPos'][0] = 1;
    $_SESSION['catPos'][1] = 1;
    $_SESSION['mousePos'] = $_SESSION["MOUSESTART"];
    // $_SESSION['hp'] = 10;
    // $_SESSION['nrj'] = 5;
} else {
    $_SESSION["fogofwar"] = !$_SESSION["fogofwar"];
}

header('Location: ../../index.php');
exit;

?>