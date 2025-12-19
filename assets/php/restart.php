<?php

session_start();

if (isset($_POST["newgame"])) {
    $_SESSION = "";
    session_destroy();
} else if (isset($_POST["restart"])){
    $_SESSION['catPos'][0] = 1;
    $_SESSION['catPos'][1] = 1;
    $_SESSION['mousePos'] = $_SESSION["MOUSESTART"];
    $_SESSION['maze'] = $_SESSION['mazeOrigin'];
    $_SESSION["HAMMER"]["picked"] = false;
    $_SESSION["HAMMER"]["used"] = false;
    $_SESSION["MUSH"]["picked"] = false;
    $_SESSION["WEED"]["picked"] = false;
    $_SESSION["WEED"]["used"] = false;
    $_SESSION["CHEESE"]["picked"] = false;
    // $_SESSION['hp'] = 10;
    // $_SESSION['nrj'] = 5;
} else {
    $_SESSION["fogofwar"] = !$_SESSION["fogofwar"];
}

header('Location: ../../index.php');
exit;

?>