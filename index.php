<?php
session_start();



// if (!isset($_SESSION['hp'])) {
//     $_SESSION['hp'] = 10;
// }

// if (!isset($_SESSION['nrj'])) {
//     $_SESSION['nrj'] = 5;
// }








?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Labyrinthe</title>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <?php include "./assets/php/header.php" ?>

    <main>
        <div class="game-container">
            <div class="maze-container">
                <div class="fog"></div>
                <?php include "./assets/php/initMaze.php" ?>

            </div>

            <form class="btns"  method="POST" action="./assets/php/restart.php">
                <button name="restart">RESTART</button>
                <button id="fogofwar" name="fogofwar">FOG</button>
                <button name="newgame">NEW GAME</button>
            </form>
            <div class="HUD-container">
                <div class="stat-container">
                    <?php
                    //echo "<h3>HP : " .  $_SESSION['hp'] . "/10</h3>";
                    ?>
                    <div class="hp-bar"></div>
                    <?php
                    //echo "<h3>ENERGY : " .  $_SESSION['nrj'] . "/5</h3>";
                    ?>
                    <div class="nrj-bar"></div>
                </div>
                <form class="controls" method="post">
                    <div class="updown">
                        <button class="arrow" id="up" name="up"></button>
                        <button class="arrow" id="down" name="down"></button>
                    </div>
                    <div class="leftright">
                        <button class="arrow" id="left" name="left"></button>
                        <button class="arrow" id="right" name="right"></button>
                    </div>
                </form>
                <div class="items">

                </div>
            </div>

        </div>

<?php
// ----------------------------- FONCTIONS -------------------------------------------------



function applyFog()
{
    $cellSize = 16;

    $catRow = $_SESSION['catPos'][0];
    $catCol = $_SESSION['catPos'][1];

    $centerX = ($catCol * $cellSize) + ($cellSize * 1.5);
    $centerY = ($catRow * $cellSize) + $cellSize / 2;
    echo "<style>.fog{background:radial-gradient(circle at " . $centerX . "px " . $centerY . "px,rgba(0,0,0,0) 12px,rgba(115, 115, 115, 0.995) 20px);}</style>";
}

function moveCat($dir)
{
    $_SESSION['catPos'][0] = $_SESSION['catPos'][0] + $dir[0];
    $_SESSION['catPos'][1] = $_SESSION['catPos'][1] + $dir[1];
}

function moveMouse()
{
    if ($_SESSION['maze'][$_SESSION['mousePos'][0] - 1][$_SESSION['mousePos'][1]] > $_SESSION['maze'][$_SESSION['mousePos'][0]][$_SESSION['mousePos'][1]]) {
        $_SESSION['mousePos'] = [$_SESSION['mousePos'][0] - 1, $_SESSION['mousePos'][1]];
    } else if ($_SESSION['maze'][$_SESSION['mousePos'][0] + 1][$_SESSION['mousePos'][1]] > $_SESSION['maze'][$_SESSION['mousePos'][0]][$_SESSION['mousePos'][1]]) {
        $_SESSION['mousePos'] = [$_SESSION['mousePos'][0] + 1, $_SESSION['mousePos'][1]];
    } else if ($_SESSION['maze'][$_SESSION['mousePos'][0]][$_SESSION['mousePos'][1] - 1] > $_SESSION['maze'][$_SESSION['mousePos'][0]][$_SESSION['mousePos'][1]]) {
        $_SESSION['mousePos'] = [$_SESSION['mousePos'][0], $_SESSION['mousePos'][1] - 1];
    } else if ($_SESSION['maze'][$_SESSION['mousePos'][0]][$_SESSION['mousePos'][1] + 1] > $_SESSION['maze'][$_SESSION['mousePos'][0]][$_SESSION['mousePos'][1]]) {
        $_SESSION['mousePos'] = [$_SESSION['mousePos'][0], $_SESSION['mousePos'][1] + 1];
    }
}
// ------------------------------------------------------------------------------------

//----------------------------- ENVOI -------------------------------------------------
if (!isset($_SESSION['catPos'])) {
    $_SESSION['catPos'] = [1, 1];
    $_SESSION["fogofwar"] = false;
    initAll($_SESSION['maze']);
    $_SESSION['mousePos'] = $_SESSION["MOUSESTART"];
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    if (isset($_POST['up'])) {
        if ($_SESSION['maze'][$_SESSION['catPos'][0] - 1][$_SESSION['catPos'][1]] >= 0) {
            $_POST['up'] = [-1, 0];
            moveCat($_POST['up']);
           
            moveMouse();
        }
    } else if (isset($_POST['down'])) {
        if ($_SESSION['maze'][$_SESSION['catPos'][0] + 1][$_SESSION['catPos'][1]] >= 0) {
            $_POST['down'] = [1, 0];
            moveCat($_POST['down']);
           
            moveMouse();
        }
    } else if (isset($_POST['left'])) {
        if ($_SESSION['maze'][$_SESSION['catPos'][0]][$_SESSION['catPos'][1] - 1] >= 0) {
            $_POST['left'] = [0, -1];
            moveCat($_POST['left']);
           
            moveMouse();
        }
    } else if (isset($_POST['right'])) {
        if ($_SESSION['maze'][$_SESSION['catPos'][0]][$_SESSION['catPos'][1] + 1] >= 0) {
            $_POST['right'] = [0, 1];
            moveCat($_POST['right']);
           
            moveMouse();
        }
    }

    if ($_SESSION['catPos'] == $_SESSION['mousePos']) {
        echo "<div class='modale'><h2>BRAVO</h2></div>";
        echo "<style>.controls{display:none;}</style>";
        echo "<style>#fogofwar{display:none;}</style>";
    }
}


if ($_SESSION["fogofwar"] == true) {
    applyFog();
}

echo "<style>#id" . $_SESSION['catPos'][0] . "-" . $_SESSION['catPos'][1] . "{background-image:url('assets/img/chat-noir.png');background-size:16px 16px;background-color:red;}</style>";
echo "<style>#id" . $_SESSION['mousePos'][0] . "-" . $_SESSION['mousePos'][1] . "{background-image:url('assets/img/souris.png');background-size:16px 16px;background-color:green;}</style>";



//-----------------------------------------------------------------------------------

?>

    </main>

    <?php include "./assets/php/footer.php" ?>
</body>

</html>