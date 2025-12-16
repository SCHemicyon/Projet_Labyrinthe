<?php session_start(); ?>

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
                <?php include "./assets/php/script.php" ?>

            </div>

            <form class="btns" action="./assets/php/restart.php" method="POST">
                <button name="restart">RESTART</button><button name="newgame">NEW GAME</button>
            </form>

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
        </div>


        <?php

        // ----------------------------- FONCTIONS -------------------------------------------------
        function applyFog()
        {
            $cellSize = 16;

            $catRow = $_SESSION['catPos'][0];
            $catCol = $_SESSION['catPos'][1];

            $centerX = ($catCol * $cellSize) + ($cellSize * 2);
            $centerY = ($catRow * $cellSize) + $cellSize / 2;
            echo "<style>.fog{background:radial-gradient(circle at " . $centerX . "px " . $centerY . "px,rgba(0,0,0,0) 16px,rgba(115, 115, 115, 0.99) 32px);}</style>";
        }

        function moveCat($dir)
        {
            echo "<style>#id" . $_SESSION['catPos'][0] . "-" . $_SESSION['catPos'][1] . "{background-image:none;background-size:16px 16px;}</style>";

            $_SESSION['catPos'][0] = $_SESSION['catPos'][0] + $dir[0];
            $_SESSION['catPos'][1] = $_SESSION['catPos'][1] + $dir[1];

            echo "<style>#id" . $_SESSION['catPos'][0] . "-" . $_SESSION['catPos'][1] . "{background-image:url('assets/img/chat-noir.png');background-size:16px 16px;}</style>";
        }
        // ------------------------------------------------------------------------------------
        //----------------------------- ENVOI -------------------------------------------------
        if (!isset($_SESSION['catPos'])) {
            $_SESSION['catPos'] = [1, 1];
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {


            if (isset($_POST['up'])) {
                if ($_SESSION['maze'][$_SESSION['catPos'][0] - 1][$_SESSION['catPos'][1]] == 0) {
                    $_POST['up'] = [-1, 0];
                    moveCat($_POST['up']);
                }
            } else if (isset($_POST['down'])) {
                if ($_SESSION['maze'][$_SESSION['catPos'][0] + 1][$_SESSION['catPos'][1]] == 0) {
                    $_POST['down'] = [1, 0];
                    moveCat($_POST['down']);
                }
            } else if (isset($_POST['left'])) {
                if ($_SESSION['maze'][$_SESSION['catPos'][0]][$_SESSION['catPos'][1] - 1] == 0) {
                    $_POST['left'] = [0, -1];
                    moveCat($_POST['left']);
                }
            } else if (isset($_POST['right'])) {
                if ($_SESSION['maze'][$_SESSION['catPos'][0]][$_SESSION['catPos'][1] + 1] == 0) {
                    $_POST['right'] = [0, 1];
                    moveCat($_POST['right']);
                }
            }

            if ($_SESSION['catPos'] == [23, 23]) {
                echo "<div class='modale'><h2>BRAVO</h2></div>";
                echo "<style>.controls{display:none;}</style>";
            }
        }

        echo "<style>#id" . $_SESSION['catPos'][0] . "-" . $_SESSION['catPos'][1] . "{background-image:url('assets/img/chat-noir.png');background-size:16px 16px;}</style>";
        //applyFog();
        //-----------------------------------------------------------------------------------
        ?>

    </main>

    <?php include "./assets/php/footer.php" ?>
</body>

</html>