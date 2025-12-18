<?php

// ------------------- VARIABLES ---------------------------------
$tab = [];
$GLOBALS["ROWS"] = 25;
$GLOBALS["COLS"] = 25;
$GLOBALS["WALL"] = -1;
$GLOBALS["PATH"] = 0;

$cpt = 1; // distance 1-1 vers case éloignée

// ----------------------------------------------------------------
// ---------------------- FONCTIONS -------------------------------
function generateGrid($t)
{
    for ($i = 0; $i < $GLOBALS["ROWS"]; $i++) {
        $t[$i] = [];
        echo "<div class='row'>";

        for ($j = 0; $j < $GLOBALS["COLS"]; $j++) {
            echo "<div class='cell' id='id$i-$j'></div>";
            $t[$i][$j] = $GLOBALS["WALL"];
        }
        echo "</div>";
    }
    return $t;
}

function generateMaze($t, $startR, $startC, $count)
{
    $directions = [[-2, 0], [0, 2], [2, 0], [0, -2],];
    shuffle($directions);

    foreach ($directions as [$dr, $dc]) {
        $newR = $startR + $dr;
        $newC = $startC + $dc;

        if ($newR > 0 && $newR < $GLOBALS["ROWS"] - 1 && $newC > 0 && $newC < $GLOBALS["COLS"] - 1 && $t[$newR][$newC] == $GLOBALS["WALL"]) {
            $t[$startR + $dr / 2][$startC + $dc / 2] = $count++;
            $t[$newR][$newC] = $count++;
            $t = generateMaze($t, $newR, $newC, $count);
            $count -= 2;
        }
    }
    return $t;
}

function fillGrid($t)
{
    for ($i = 0; $i < $GLOBALS["ROWS"]; $i++) {
        for ($j = 0; $j < $GLOBALS["COLS"]; $j++) {
            switch ($t[$i][$j]) {
                // case $GLOBALS["PATH"]:
                //     echo "<style>#id$i-$j{background-color:white;}</style>";
                //     break;
                case $GLOBALS["WALL"];
                    echo "<style>#id$i-$j{background-image:url('assets/img/wall.png');background-size:16px 16px;background-color:black;}</style>";
                    break;
                default:
                    echo "<style>#id$i-$j{background-color:#CCC;}</style>";
                    // echo "<style>#id$i-$j{background-color:rgb(" . 255 - $t[$i][$j] . ", 0, 0)</style>";
                    break;
            }
        }
    }
}

function initAll($t)
{
    $row = rand(15, 23);
    $col = rand(15, 23);
    while ($t[$row][$col] == -1) {
        $row = rand(15, 23);
        $col = rand(15, 23);
    }
    $_SESSION["MOUSESTART"] = [$row, $col];
}

//-----------------------------------------------------------------------
//------------------------------------ CODE -----------------------------


if (!isset($_SESSION['maze'])) {
    $tab = generateGrid($tab);
    $tab[1][1] = 0;
    $tab = generateMaze($tab, 1, 1, $cpt);
    $_SESSION['maze'] = $tab;

    fillGrid($tab);
} else {
    $tab = $_SESSION['maze'];

    for ($i = 0; $i < $GLOBALS["ROWS"]; $i++) {
        echo "<div class='row'>";
        for ($j = 0; $j < $GLOBALS["COLS"]; $j++) {
            echo "<div class='cell' id='id$i-$j'></div>";
        }
        echo "</div>";
    }

    fillGrid($tab);
}



echo "<script>console.log('" . json_encode($_SESSION['maze']) . "')</script>";
